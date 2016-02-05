<?php 
include("access.php");
include("header.php"); 
include("../includes/conf.class.php");
?>    
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
 <script type="text/javascript" src="../js//dtpicker/jquery.ui.datepicker-<?=$langauge_selcted?>.js"></script>
  
 <script type="text/javascript">
	$(document).ready(function(){
		disableInput("#submit");
		$('#book_type').change(function(){
			if($('#book_type').val() != ""){
				enableInput("#submit");			
			}else{
				disableInput("#submit");
			}
		});
		//Enabling Disabling Function
		function disableInput(id){
			jQuery(id).attr('disabled', 'disabled');
		}
		function enableInput(id){
			jQuery(id).removeAttr('disabled');	
		}
	});
</script>
      <div id="container-inside">
      <span style="font-size:16px; font-weight:bold"><?php echo VIEW_BOOKING_LIST;?></span>
      <hr />
        <form action="view_active_or_archieve_bookings.php" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0">
            <tr>
            <td valign="middle"><strong><?php echo SELECT_BOOKING_TYPE;?></strong>:</td>
            <td><select name="book_type" id="book_type"><option value="">---<?php echo VIEW_BOOKINGS_SELECT_TYPE;?>---</option><option value="1"><?php echo ACTIVE_BOOKING;?></option><option value="2"><?php echo BOOKING_HISTORY;?></option></select> </td>
            
            </tr>
            
           <tr><td><strong><?=VB_DATE_RANGE?>(<?=VB_OPTIONAL?>)</strong></td><td><input id="txtFromDate" name="fromDate" style="width:68px" type="text" readonly="readonly" />
      <span style="padding-left:0px;"><a id="datepickerImage" href="javascript:;"><img src="../images/month.png" height="16px" width="16px" style=" margin-bottom:-4px;" border="0" /></a></span>&nbsp;&nbsp;&nbsp;&nbsp; <strong><?=VB_TO?></strong> &nbsp;&nbsp;&nbsp;&nbsp;<input id="txtToDate" name="toDate" style="width:68px" type="text" readonly="readonly"/>
      <span style="padding-left:0px;"><a id="datepickerImage1" href="javascript:;"><img src="../images/month.png" height="18px" width="18px" style=" margin-bottom:-4px;" border="0" /></a></span>&nbsp;&nbsp;&nbsp;&nbsp;<strong><?=VB_BY?></strong>&nbsp;&nbsp;&nbsp;&nbsp;<select name="shortby"><option value="booking_time" selected="selected"><?=VIEW_ACTIVE_BOOKING_DATE?></option><option value="start_date"><?=ROOM_BLOCK_CHECK_IN_DATE?></option><option value="end_date"><?=ROOM_BLOCK_CHECK_OUT_DATE?></option></select></td></tr>
           <tr><td></td><td><input type="submit" value="<?php echo VIEW_BOOKINGS_SUBMIT;?>" name="submit" id="submit" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>
          </table>
        </form>
      </div>
<script type="text/javascript">
	$().ready(function() {
		$("#form1").validate();
		
     });
         
</script>      
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="../css/datepicker.css" />
<script type="text/javascript">
$(document).ready(function(){
	$.datepicker.setDefaults( $.datepicker.regional[ "<?=$langauge_selcted?>" ] );
 $.datepicker.setDefaults({ dateFormat: '<?=$bsiCore->config['conf_dateformat']?>' });
    $("#txtFromDate").datepicker({
        maxDate: "+365D",
        numberOfMonths: 2,
        onSelect: function(selected) {
    	var date = $(this).datepicker('getDate');
         if(date){
            date.setDate(date.getDate());
          }
          $("#txtToDate").datepicker("option","minDate", date)
        }
    });
 
    $("#txtToDate").datepicker({ 
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

<script src="js/jquery.validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?> 
