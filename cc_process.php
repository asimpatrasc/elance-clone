<?php
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if(!$pos2){
	header('Location: booking-failure.php?error_code=9');
}
	session_start();
	include("includes/db.conn.php");
	include("includes/conf.class.php");
	$row_default_lang=mysql_fetch_assoc(mysql_query("select * from bsi_language where `lang_default`=true"));
	include("languages/".$row_default_lang['lang_file']);
	include("includes/mail.class.php");
   
    $booking_id = mysql_real_escape_string($_POST['bookingid']);
	$emailBody  = '';
	
    $invoiceROWS= mysql_fetch_assoc(mysql_query("SELECT client_name, client_email, invoice FROM bsi_invoice WHERE booking_id='".$booking_id."'"));
	$ccArray    = array();
	$bsiMail    = new bsiMail();	
	$emailContent=$bsiMail->loadEmailContent();
	$subject    = $emailContent['subject'];
	$emailBody .= "Dear ".$invoiceROWS['client_name'].",<br><br>";
	$emailBody .= $emailContent['body'];
	$emailBody .= $invoiceROWS['invoice'];
				
	$cardnum        = $_POST['CardNumber'];
	$cc_holder_name = $_POST['cc_holder_name'];
	$CardType       = $_POST['CardType'];
	$cc_exp_dt      = $_POST['cc_exp_dt'];
	$cc_ccv         = $_POST['cc_ccv'];
	$cardnum_enc    = $bsiCore->encryptCard(mysql_real_escape_string($_POST['CardNumber']));
	$cardno_len=strlen($cardnum)-4;
	$creditcard_no=substr($cardnum,$cardno_len);
	$star='';
	for($i=0;$i<$cardno_len;$i++){ $star.='#';}
	$show_cardno=$star.$creditcard_no;
	
	$payoptions = "Credit Card";
	$table      = '<br /><table  style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; background:#999999; width:700px; border:none;" cellpadding="4" cellspacing="1"><tr><td align="left" colspan="2" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(INV_PAY_DETAILS).'</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps;background:#ffffff;">'.mysql_real_escape_string(INV_PAY_OPTION).'</td><td align="left" style="background:#ffffff;">'.$payoptions.'</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps;background:#ffffff;">'.mysql_real_escape_string(CC_NUMBER).'</td><td align="left" style="background:#ffffff;">'.$show_cardno.'</td></tr></table>';
	$updatedInvoice=$invoiceROWS['invoice'].$table;
	mysql_query("Update bsi_invoice SET invoice='$updatedInvoice' WHERE booking_id='".$booking_id."'");				
	mysql_query("insert into bsi_cc_info(booking_id, cardholder_name, card_type, card_number, expiry_date, ccv2_no) values('".mysql_real_escape_string($_POST['bookingid'])."', '".mysql_real_escape_string($_POST['cc_holder_name'])."', '".mysql_real_escape_string($_POST['CardType'])."', '".$cardnum_enc."', '".mysql_real_escape_string($_POST['cc_exp_dt'])."', '".mysql_real_escape_string($_POST['cc_ccv'])."')");
	
	$emailBody .= $table;
	
	
	$emailBody .= '<br><br>'.mysql_real_escape_string(PP_REGARDS).',<br>'.$bsiCore->config['conf_hotel_name'].'<br>'.$bsiCore->config['conf_hotel_phone'];
	$emailBody .= '<br><br><font style=\"color:#F00; font-size:10px;\">[ '.mysql_real_escape_string(PP_CARRY).' ]</font>';		
		
	$returnMsg = $bsiMail->sendEMail($invoiceROWS['client_email'],$subject, $emailBody);
	if ($returnMsg == true) {
	    mysql_query("update bsi_bookings set payment_success=true where booking_id=".$booking_id);
			
		$notifyEmailSubject = "Booking no.".$_POST['bookingid']." - Notification of Room Booking by ".$invoiceROWS['client_name'];				
		$notifynMsg = $bsiMail->sendEMail($bsiCore->config['conf_notification_email'], $notifyEmailSubject, $invoiceROWS['invoice']);
		header('Location: booking-confirm.php?success_code=1');
		die; 
	}else {
		header('Location: booking-failure.php?error_code=25');
		die;
	}		
?>