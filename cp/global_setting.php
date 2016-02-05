<?php 
include("access.php");
if(isset($_POST['act_sbmt'])){

		include("../includes/db.conn.php");

		include("../includes/conf.class.php");

		include("../includes/admin.class.php");

		$bsiAdminMain->global_setting_post();

		header("location:global_setting.php");

}

include("header.php"); 

include("../includes/conf.class.php");

include("../includes/admin.class.php");

$global_setting=$bsiAdminMain->global_setting();

?>    

 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />

      <div id="container-inside">

      <span style="font-size:16px; font-weight:bold"><?php echo GLOBAL_SETTING;?></span>

      <hr />

        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form1">

          <table cellpadding="5" cellspacing="2" border="0">

            <tr>

              <td><strong><?php echo EMAIL_NOTIFICATION;?>:</strong></td>

              <td valign="middle"><input type="text" name="email_notification" id="email_notification" value="<?=$bsiCore->config['conf_notification_email']?>" class="required" style="width:250px;" /></td>

            </tr>

            <tr>

              <td><strong><?php echo CURRENCY_CODE;?>:</strong></td>

              <td><input type="text" name="currency_code" id="currency_code" value="<?=$bsiCore->config['conf_currency_code']?>"  class="required" style="width:70px;"  /></td>

            </tr>

             <tr>

              <td><strong><?php echo CURRENCY_SYMBOL; ?>:</strong></td>

              <td><input type="text" name="currency_symbol" id="currency_symbol" value="<?=$bsiCore->config['conf_currency_symbol']?>"  class="required" style="width:70px;"  /></td>

            </tr>

             <tr>

              <td><strong><?php echo BOOKING_ENGINE;?>:</strong></td>

              <td><select name="booking_turn" id="booking_turn"><?=$global_setting['select_booking_turn']?></select></td>

            </tr>

             <tr>

              <td><strong><?php echo HOTEL_TIMEZONE;?>:</strong></td>

              <td><select name="timezone" id="timezone"><?=$global_setting['select_timezone']?></select></td>

            </tr>

             <tr>

              <td><strong><?php echo MINIMUM_BOOKING;?>:</strong></td>

              <td><select name="minbooking" id="minbooking"><?=$global_setting['select_min_booking']?></select>&nbsp;&nbsp;<?php echo GLOBAL_SETTING_NIGHTS;?></td>

            </tr>

            <tr>

                <td><strong><?php echo DATE_FORMAT;?></strong></td>

                <td><select name="date_format" id="date_format">

                <?=$global_setting['select_dateformat']?>

                </select></td>

          </tr>

             <tr>

              <td><strong><?php echo ROOM_LOCK_TIME;?>:</strong></td>

              <td><select name="room_lock" id="room_lock"><?=$global_setting['select_room_lock']?></select> <span style="font-size:10px">&nbsp;&nbsp;<?php echo DURATION_FOR_CUSTOMER_SELECTED_ROOM;?></span></td>

            </tr>

            

            <tr>

              <td><strong><?php echo GLOBAL_SETTING_TAX;?>:</strong></td>

              <td><input type="text" name="tax" id="tax" size="6" class="required number" value="<?=$bsiCore->config['conf_tax_amount']?>" />&nbsp;%</td>

            </tr>

            <tr>

              <td><strong><?php echo PRICE_INCLUDING_TAX;?></strong></td>

              <td><?php

                     if($bsiCore->config['conf_price_with_tax']==1){

	              ?>

    

                 <input type="checkbox" name="price_inclu_tax" id="price_inclu_tax" checked="checked" />

				<?php

                }else{

                ?>

                <input type="checkbox" name="price_inclu_tax" id="price_inclu_tax" />

                <?php

                }

                ?>

    </td>

            </tr>

              <td><input type="hidden" name="act_sbmt" value="1" /></td>

              <td><input type="submit" value="<?php echo GLOBAL_SETTING_SUBMIT;?>" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>

            </tr>

          </table>

        </form>

      </div>

<script type="text/javascript">

	$().ready(function() {

		$("#form1").validate();

		

     });

         

</script>      

<script src="js/jquery.validate.js" type="text/javascript"></script>

<?php include("footer.php"); ?> 

