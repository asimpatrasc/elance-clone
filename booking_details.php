<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("language.php");
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if(!$pos2){
	header('Location: booking-failure.php?error_code=9');
}
include("includes/details.class.php");
$bsibooking = new bsiBookingDetails();
$bsiCore->clearExpiredBookings();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?=$bsiCore->config['conf_hotel_name']?>
</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<!--<script id="demo" type="text/javascript">
$(document).ready(function() {
	$("#form1").validate();		
});
</script>-->
<script type="text/javascript">
	$().ready(function() {
		$("#form1").validate();
    });        
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#btn_exisitng_cust').click(function() {
	    $('#exist_wait').html("<img src='images/ajax-loader.gif' border='0'>")
		var querystr = 'actioncode=2&existing_email='+$('#email_addr_existing').val(); 
		$.post("ajaxreq-processor.php", querystr, function(data){ 						 
			if(data.errorcode == 0){
				$('#title').html(data.title)
				$('#fname').val(data.first_name)
				$('#lname').val(data.surname)
				$('#str_addr').val(data.street_addr)
				$('#city').val(data.city)
				$('#state').val(data.province)
				$('#zipcode').val(data.zip)
				$('#country').val(data.country)
				$('#phone').val(data.phone)
				$('#fax').val(data.fax)
				$('#email').val(data.email)
				$('#exist_wait').html("")
			}else { 
				alert(data.strmsg);
				$('#fname').val('')
				$('#lname').val('')
				$('#str_addr').val('')
				$('#city').val('')
				$('#state').val('')
				$('#zipcode').val('')
				$('#country').val('')
				$('#phone').val('')
				$('#fax').val('')
				$('#email').val('')
				$('#exist_wait').html("")
			}	
		}, "json");
	});
});
function myPopup2(booking_id){
		var width = 730;
		var height = 650;
		var left = (screen.width - width)/2;
		var top = (screen.height - height)/2;
		var url='terms-and-services.php?bid='+booking_id;
		var params = 'width='+width+', height='+height;
		params += ', top='+top+', left='+left;
		params += ', directories=no';
		params += ', location=no';
		params += ', menubar=no';
		params += ', resizable=no';
		params += ', scrollbars=yes';
		params += ', status=no';
		params += ', toolbar=no';
		newwin=window.open(url,'Chat', params);
		if (window.focus) {newwin.focus()}
		return false;
   }
</script>
</head>
<body>
<div id="content" align="center">
 <h1>
  <?=$bsiCore->config['conf_hotel_name']?>
 </h1>
 <?php $bookingDetails = $bsibooking->generateBookingDetails(); ?>
 <div id="wrapper" style="width:600px !important;">
  <h2 align="left" style="padding-left:5px;"><?=BOOKING_DETAILS_TEXT?></h2>
  <hr color="#e1dada"  style="margin-top:3px;"/>
  <br />
  <table cellpadding="4" cellspacing="1" border="0" width="100%" bgcolor="#FFFFFF" style="font-size:13px;">
   <tr>
    <td bgcolor="#f2f2f2" align="center"><strong><?=CHECKIN_DATE_TEXT?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=CHECKOUT_DATE_TEXT?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=TOTAL_NIGHT_TEXT?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=TOTAL_ROOMS_TEXT?></strong></td>
   </tr>
   <tr>
    <td align="center" bgcolor="#f5f9f9"><?=$bsibooking->checkInDate?></td>
    <td align="center" bgcolor="#f5f9f9"><?=$bsibooking->checkOutDate?></td>
    <td align="center" bgcolor="#f5f9f9"><?=$bsibooking->nightCount?></td>
    <td align="center" bgcolor="#f5f9f9"><?=$bsibooking->totalRoomCount?></td>
   </tr>
   <tr>
    <td bgcolor="#f2f2f2" align="center"><strong><?=NUMBER_OF_ROOM_TEXT?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=ROOM_TYPE_TEXT?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=MAXI_OCCUPENCY_TEXT?></strong></td>
    <td bgcolor="#f2f2f2" align="right" style="padding-right:5px;"><strong><?=GROSS_TOTAL_TEXT?></strong></td>
   </tr>
   <?php		
		foreach($bookingDetails as $bookings){		
			echo '<tr>';
			echo '<td align="center" bgcolor="#f5f9f9">'.$bookings['roomno'].'</td>';
			echo '<td align="center" bgcolor="#f5f9f9">'.$bookings['roomtype'].' ('.$bookings['capacitytitle'].')</td>';				
			echo '<td align="center" bgcolor="#f5f9f9">'.$bookings['capacity'].' Adult</td>';
				
			echo '<td align="right" bgcolor="#f5f9f9" style="padding-right:5px;">'.$bsiCore->config['conf_currency_symbol'].number_format($bookings['grosstotal'], 2 , '.', ',').'</td>';
			echo '</tr>';		
		}
	 ?>
   <tr>
    <td colspan="3" align="right" bgcolor="#f2f2f2"><strong><?=SUB_TOTAL_TEXT?></strong></td>
    <td bgcolor="#f2f2f2" align="right" style="padding-right:5px;"><strong>
     <?=$bsiCore->config['conf_currency_symbol']?><?=number_format($bsibooking->roomPrices['subtotal'], 2 , '.', ',')?>
     </strong></td>
   </tr>
   <?php
		if($bsiCore->config['conf_tax_amount'] > 0 &&  $bsiCore->config['conf_price_with_tax']==0){
			$taxtext=""; 
		?>
   <tr>
    <td colspan="3" align="right" bgcolor="#f5f9f9"><?=TAX_TEXT?>
     
     (
     <?=$bsiCore->config['conf_tax_amount']?>
     %)</td>
    <td align="right" bgcolor="#f5f9f9" style="padding-right:5px;"><span id="taxamountdisplay">
     <?=$bsiCore->config['conf_currency_symbol']?><?=number_format($bsibooking->roomPrices['totaltax'], 2 , '.', ',')?>
     </span></td>
   </tr>
   <?php }else{
			$taxtext="(".BD_INC_TAX.")";
		}
		?>
   <tr>
    <td colspan="3" align="right" bgcolor="#f2f2f2"><strong><?=GRAND_TOTAL_TEXT?></strong>
     <?=$taxtext?></td>
    <td align="right" bgcolor="#f2f2f2" style="padding-right:5px;"><strong> <span id="grandtotaldisplay">
     <?=$bsiCore->config['conf_currency_symbol']?><?=number_format($bsibooking->roomPrices['grandtotal'], 2 , '.', ',')?>
     </span></strong></td>
   </tr>
   <?php 
		if($bsiCore->config['conf_enabled_deposit'] && ($bsibooking->depositPlans['deposit_percent'] > 0 && $bsibooking->depositPlans['deposit_percent'] < 100)){
		?>
   <tr id="advancepaymentdisplay">
    <td colspan="3" align="right" bgcolor="#f2f2f2"><strong></strong> <?=ADVANCE_PAYMENT_TEXT?>(<span style="font-size:11px;">
     <?=$bsibooking->depositPlans['deposit_percent']?>
     %<?=OF_GRAND_TOTAL_TEXT?></span>)</td>
    <td align="right" bgcolor="#f2f2f2" style="padding-right:5px;"><span id="advancepaymentamount">
     <?=$bsiCore->config['conf_currency_symbol']?><?=number_format($bsibooking->roomPrices['advanceamount'], 2 , '.', ',')?>
     </span></td>
   </tr>
   <?php
        }?>
  </table>
 </div>
 <br />
 <br />
 <div id="wrapper" style="width:600px !important;">
  <h2 align="left" style="padding-left:5px;"><?=CUSTOMER_DETAILS_TEXT?></h2>
  <hr color="#e1dada"  style="margin-top:3px;"/>
  <br />
  <h3 align="left" style="padding-left:5px;  color:#999;"><?=EXISTING_CUSTOMER_TEXT?>?</h3>
  <table cellpadding="6" cellspacing="6" align="left" style="text-align:left;" width="100%">
   <tr>
    <td width="160px"><strong><?=EMAIL_ADDRESS_TEXT?>:</strong></td>
    <td><input type="text" name="email_addr_existing" id="email_addr_existing"   /></td>
   </tr>
   <tr>
    <td></td>
    <td><button id="btn_exisitng_cust" type="submit" style="float:left;"><?=FETCH_DETAILS_TEXT?></button></td>
   </tr>
   <tr>
    <td id="exist_wait" ></td>
   </tr>
  </table>

  <h1 align="center" ><?=OR_TEXT?></h1>
  
  <h3 align="left" style="padding-left:5px; color:#999;"><?=NEW_CUSTOMER_TEXT?>?</h3>
  <form method="post" action="booking-process.php" id="form1" class="signupform">
   <input type="hidden" name="allowlang" id="allowlang" value="no" />
   <table cellpadding="6" cellspacing="6" width="100%" border="0" style="text-align:left;">
    <tr>
     <td width="120px"><strong><?=TITLE_TEXT?>:</strong></td>
     <td id="title"><select name="title" class="textbox3" style="width:60px;">
       <option value="Mr."><?=MR_TEXT?>.</option>
       <option value="Ms."><?=MS_TEXT?>.</option>
       <option value="Mrs."><?=MRS_TEXT?>.</option>
       <option value="Miss."><?=MISS_TEXT?>.</option>
       <option value="Dr."><?=DR_TEXT?>.</option>
       <option value="Prof."><?=PROF_TEXT?>.</option>
      </select></td>
    </tr>
    <tr>
     <td><strong><?=FIRST_NAME_TEXT?>:</strong></td>
     <td><input type="text" name="fname" id="fname"  class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=LAST_NAME_TEXT?>:</strong></td>
     <td><input type="text" name="lname" id="lname"  class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=ADDRESS_TEXT?>:</strong></td>
     <td><input type="text" name="str_addr" id="str_addr"  class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=CITY_TEXT?>:</strong></td>
     <td><input type="text" name="city"  id="city" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=STATE_TEXT?>:</strong></td>
     <td><input type="text" name="state"  id="state" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=POSTAL_CODE_TEXT?>:</strong></td>
     <td><input type="text" name="zipcode"  id="zipcode" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=COUNTRY_TEXT?>:</strong></td>
     <td><input type="text" name="country"  id="country" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=PHONE_TEXT?>:</strong></td>
     <td><input type="text" name="phone"  id="phone" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=FAX_TEXT?>:</strong></td>
     <td><input type="text" name="fax"  id="fax" /></td>
    </tr>
    <tr>
     <td><strong><?=EMAIL_TEXT?>:</strong></td>
     <td><input type="text" name="email"  id="email" class="required email" /></td>
    </tr>
    <tr>
     <td valign="top"><strong><?=PAYMENT_BY_TEXT?>:</strong></td>
     <td><?php
				$paymentGatewayDetails = $bsiCore->loadPaymentGateways();				
				foreach($paymentGatewayDetails as $key => $value){ 	
					echo '<input type="radio" name="payment_type" id="payment_type_'.$key.'" value="'.$key.'" class="required" />'.$value['name'].'<br />';
				}
				?>
      <label class="error" generated="true" for="payment_type" style="display:none;"><?=FIELD_REQUIRED_ALERT?>.</label></td>
    </tr>
    <tr>
     <td valign="top" nowrap="nowrap"><strong><?=ADDITIONAL_REQUESTS_TEXT?> :</strong></td>
     <td ><textarea name="message" style="width:300px; height:70px;" ></textarea></td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td><input type="checkbox" name="tos" id="tos" value="" style="width:15px !important"  class="required"/>
      &nbsp;
      
     <?=I_AGREE_WITH_THE_TEXT?> <a href="javascript: ;" onclick="javascript:myPopup2();"> <?=TERMS_AND_CONDITIONS_TEXT?>.</a></td>
    </tr>
    <tr>
     <td height="50"></td>
     <td><button id="registerButton" type="submit" style="float:left;"><?=CONFIRM_TEXT?> &amp; <?=CHECKOUT_TEXT?></button></td>
    </tr>
   </table>
  </form>
 </div>
</div>
</body>
</html>