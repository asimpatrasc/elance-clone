<?php 

include("access.php");

if(isset($_POST['block'])){

	include("../includes/db.conn.php");

	include("../includes/conf.class.php");

	include("../includes/details.class.php");

	$bsibooking = new bsiBookingDetails(); 

	$bsibooking->generateBlockingDetails(); 

	$bsiCore->clearExpiredBookings();

	$reservationdata = array();

	$reservationdata = $_SESSION['dvars_details'];

	$bookingId       = time();

	

	$sql = mysql_query("INSERT INTO bsi_bookings (booking_id, booking_time, start_date, end_date, client_id, is_block, payment_success, block_name) values(".$bookingId.", NOW(), '".$_SESSION['sv_mcheckindate']."', '".$_SESSION['sv_mcheckoutdate']."', '0', 1, 1, '".mysql_real_escape_string($_POST['block_name'])."')");	

	foreach($reservationdata as $revdata){

		foreach($revdata['availablerooms'] as $rooms){				

		$sql = mysql_query("INSERT INTO bsi_reservation (bookings_id, room_id, room_type_id) values(".$bookingId.",  ".$rooms['roomid'].", ".$revdata['roomtypeid'].")");

		} 

	}	

	header("location:admin_block_room.php");

	exit;

}

include("header.php"); 

include("../includes/conf.class.php");

include("../includes/admin.class.php");



if(isset($_POST['submit'])){

	include ('../includes/search.class.php');

	$bsisearch = new bsiSearch();

	$bsiCore->clearExpiredBookings();

}

?>

<link rel="stylesheet" type="text/css" href="../css/datepicker.css" />

<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />

<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js//dtpicker/jquery.ui.datepicker-<?=$langauge_selcted?>.js"></script>

<script type="text/javascript">

$(document).ready(function(){
$.datepicker.setDefaults( $.datepicker.regional[ "<?=$langauge_selcted?>" ] );
 $.datepicker.setDefaults({ dateFormat: '<?=$bsiCore->config['conf_dateformat']?>' });

    $("#txtFromDate").datepicker({

        minDate: 0,

        maxDate: "+365D",

        numberOfMonths: 2,

        onSelect: function(selected) {

    	var date = $(this).datepicker('getDate');

         if(date){

            date.setDate(date.getDate() + <?=$bsiCore->config['conf_min_night_booking']?>);

          }

          $("#txtToDate").datepicker("option","minDate", date)

        }

    });

 

    $("#txtToDate").datepicker({ 

        minDate: 0,

        maxDate:"+365D",

        numberOfMonths: 2,

        onSelect: function(selected) {

           $("#txtFromDate").datepicker("option","maxDate", selected)

        }

    });  

 $("#datepickerImage").click(function() { 

    $("#txtFromDate").datepicker("show");

  });

 $("#datepickerImage1").click(function() { 

    $("#txtToDate").datepicker("show");

  });

});

</script>

<div id="container-inside">

<span style="font-size:16px; font-weight:bold"><?php echo ROOM_BLOCKING_SEARCH;?></span>

<hr />

  <table cellpadding="4" width="100%">

    <tr>

      <td width="25%" valign="top"><form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form1">

          <table cellpadding="0"  cellspacing="7" border="0">

            <tr>

              <td><?php echo ROOM_BLOCK_CHECK_IN_DATE;?></td>

              <td><input id="txtFromDate" name="check_in" style="width:68px" type="text" readonly="readonly" AUTOCOMPLETE=OFF />

                <span style="padding-left:3px;"><a id="datepickerImage" href="javascript:;"><img src="../images/month.png" height="16px" width="16px" style=" margin-bottom:-4px;" /></a></span></td>

            </tr>

            <tr>

              <td><?php echo ROOM_BLOCK_CHECK_OUT_DATE;?></td>

              <td><input id="txtToDate" name="check_out" style="width:68px" type="text" readonly="readonly" AUTOCOMPLETE=OFF />

                <span style="padding-left:3px;"><a id="datepickerImage1" href="javascript:;"><img src="../images/month.png" height="18px" width="18px" style=" margin-bottom:-4px;" /></a></span></td>

            </tr>

            <tr>

              <td></td>

              <td><input type="submit" value="<?php echo ROOM_BLOCK_SEARCH;?>" name="submit" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>

            </tr>

          </table>

        </form></td>

      <td valign="top"><?php if(isset($_POST['submit'])){ echo '<script type="text/javascript" src="../js/hotelvalidation.js"></script> '; ?>

        <form name="adminsearchresult" id="adminsearchresult" method="post" action="<?=$_SERVER['PHP_SELF']?>" onsubmit="return validateSearchResult();">

          <table cellpadding="4" cellspacing="2" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:#999 solid 1px;" width="450px">

            <tr>

              <th align="left" colspan="2"><b>

                <?php echo SEARCH_RESULT;?>

                (

                <?=$_POST['check_in']?>

                to

                <?=$_POST['check_out']?>

                ) =

                <?=$bsisearch->nightCount?>

                <?php echo NIGHTS;?></b></th>

            </tr>

            <tr>

              <td align="left" ><?php echo DESCRIPTION_NAME;?></td>

              <td><input type="text" name="block_name" id="block_name"  style="width:230px !important;"/></td>

            </tr>

            <tr><td colspan="2"><hr /></td></tr>

            <tr>

              <th align="left"><?php echo BLOCK_ROOMTYPE;?></th>

              <th align="left"><?php echo BLOCK_AVAILABLITY;?></th>

            </tr>

             <tr><td colspan="2"><hr /></td></tr>

            <?php

	 	$gotSearchResult = false;

		$idgenrator = 0;

		foreach($bsisearch->roomType as $room_type){

			foreach($bsisearch->multiCapacity as $capid=>$capvalues){			

				$room_result = $bsisearch->getAvailableRooms($room_type['rtid'], $room_type['rtname'], $capid);

				if(intval($room_result['roomcnt']) > 0) {

					$gotSearchResult = true;	

			 ?>

            <tr>

              <td><?=$room_type['rtname']?>

                (

                <?=$capvalues['captitle']?>

                )</td>

              <td><select name="svars_selectedrooms[]" style="width:70px;">

                  <?=$room_result['roomdropdown']?>

                </select></td>

            </tr>

            <?php 

		$idgenrator++;

	} } }   

			if($gotSearchResult){

				echo '<tr>

				  <td>&nbsp;</td>

				  <td><input type="submit" value='.BLOCK.' name="block" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>

				</tr>';

			}else{

				echo '<tr>

				  <td colspan="2" align="center" style="color:red;"><b>Sorry no room available as your searching criteria.</b></td>

				</tr>';

			}

			?>

            

          </table>

        </form>

        <? } ?></td>

    </tr>

  </table>

</div>

<script type="text/javascript">

	$().ready(function() {

		$("#form1").validate();

		

     });

         

</script> 

<script src="js/jquery.validate.js" type="text/javascript"></script>

<?php include("footer.php"); ?>

