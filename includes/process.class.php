<?php
/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/
class BookingProcess
{
	private $guestsPerRoom		= 0;
	private $checkInDate		= '';
	private $checkOutDate		= '';
	private $noOfNights			= 0;
	private $noOfRooms			= 0;
	private $mysqlCheckInDate	= '';
	private $mysqlCheckOutDate	= '';	
	private $clientdata			= array();		
	private $expTime			= 0;	
	private $roomIdsOnly		= '';
	
	private $pricedata			= array();
	private $taxAmount 			= 0.00;
	private $taxPercent			= 0.00;
	private $grandTotalAmount 	= 0.00;	
	private $currencySymbol		= '';
	
	private $depositenabled		= false;
	
	private $taxWithPrice;
	public $clientId			= 0;
	public $clientName			= '';
	public $clientEmail			= '';
	public $bookingId			= 0;
	public $paymentGatewayCode	= '';		
	public $totalPaymentAmount 	= 0.00;	
	public $invoiceHtml			= '';
	
	function BookingProcess() {				
		$this->setMyRequestParams();
		$this->removeSessionVariables();
		$this->checkAvailability();
		$this->saveClientData();
		$this->saveBookingData();
		$this->createInvoice();
	}
	
	private function setMyRequestParams(){ 
		global $bsiCore;
		$this->setMyParamValue($this->guestsPerRoom, 'SESSION', 'sv_guestperroom', 0, true);	
		$this->setMyParamValue($this->checkInDate, 'SESSION', 'sv_checkindate', NULL, true);
		$this->setMyParamValue($this->checkOutDate, 'SESSION', 'sv_checkoutdate', NULL, true);
		$this->setMyParamValue($this->noOfNights, 'SESSION', 'sv_nightcount', 0, true);
		$this->setMyParamValue($this->mysqlCheckInDate, 'SESSION', 'sv_mcheckindate', NULL, true);
		$this->setMyParamValue($this->mysqlCheckOutDate, 'SESSION', 'sv_mcheckoutdate', NULL, true);
		$this->setMyParamValue($this->roomIdsOnly, 'SESSION', 'dv_roomidsonly', '', true);		
		$this->setMyParamValue($this->reservationdata2, 'SESSION', 'dvars_details2', NULL, true);	
		$this->setMyParamValue($this->reservationdata, 'SESSION', 'dvars_details', NULL, true);						
		$this->setMyParamValue($this->pricedata, 'SESSION', 'dvars_roomprices', NULL, true);		
				
		$this->setMyParamValue($this->clientdata['title'], 'POST', 'title', true); 
		$this->setMyParamValue($this->clientdata['fname'], 'POST', 'fname', '', true);
		$this->setMyParamValue($this->clientdata['lname'], 'POST', 'lname', '', true);
		$this->setMyParamValue($this->clientdata['address'], 'POST', 'str_addr', '', true);
		$this->setMyParamValue($this->clientdata['city'], 'POST', 'city', '', true);
		$this->setMyParamValue($this->clientdata['state'], 'POST', 'state', '', true);
		$this->setMyParamValue($this->clientdata['zipcode'], 'POST', 'zipcode', '', true);
		$this->setMyParamValue($this->clientdata['country'], 'POST', 'country', '', true);
		$this->setMyParamValue($this->clientdata['phone'], 'POST', 'phone', '', true);
		$this->setMyParamValue($this->clientdata['fax'], 'POST', 'fax', '', false); //optionlal
		$this->setMyParamValue($this->clientdata['email'], 'POST', 'email', '', true);
		$this->setMyParamValue($this->clientdata['message'], 'POST', 'message', '', false);
		$this->setMyParamValue($this->clientdata['clientip'], 'SERVER', 'REMOTE_ADDR', '', false);					
		$this->setMyParamValue($this->paymentGatewayCode, 'POST', 'payment_type','', true);	
		
		$this->bookingId		= time();		
		$this->expTime 			= intval($bsiCore->config['conf_booking_exptime']);	
		$this->currencySymbol 	= $bsiCore->config['conf_currency_symbol'];
		$this->taxPercent 		= $bsiCore->config['conf_tax_amount'];
		$this->clientName 		= $this->clientdata['fname']." ". $this->clientdata['lname'];
		$this->clientEmail		= $this->clientdata['email'];
		$this->noOfRooms		= count(explode(",", $this->roomIdsOnly));
		$this->taxWithPrice     = $bsiCore->config['conf_price_with_tax'];
			
		if($bsiCore->config['conf_enabled_deposit'])
			$this->depositenabled = true;			
		
		$this->taxAmount 			= $this->pricedata['totaltax'];
		$this->grandTotalAmount 	= $this->pricedata['grandtotal'];
		$this->totalPaymentAmount 	= $this->pricedata['advanceamount'];
	
	}
	
	private function setMyParamValue(&$membervariable, $vartype, $param, $defaultvalue, $required = false){
		global $bsiCore;
		switch($vartype){
			case "POST": 
				if($required){if(!isset($_POST[$param])){$this->invalidRequest(9);} 
					else{$membervariable = $bsiCore->ClearInput($_POST[$param]);}}
				else{if(isset($_POST[$param])){$membervariable = $bsiCore->ClearInput($_POST[$param]);} 
					else{$membervariable = $defaultvalue;}}				
				break;	
			case "GET":
				if($required){if(!isset($_GET[$param])){$this->invalidRequest(9);} 
					else{$membervariable = $bsiCore->ClearInput($_GET[$param]);}}
				else{if(isset($_GET[$param])){$membervariable = $bsiCore->ClearInput($_GET[$param]);} 
					else{$membervariable = $defaultvalue;}}				
				break;	
			case "SESSION":
				if($required){if(!isset($_SESSION[$param])){$this->invalidRequest(9);} 
					else{$membervariable = $_SESSION[$param];}}
				else{if(isset($_SESSION[$param])){$membervariable = $_SESSION[$param];} 
					else{$membervariable = $defaultvalue;}}				
				break;	
			case "REQUEST":
				if($required){if(!isset($_REQUEST[$param])){$this->invalidRequest(9);}
					else{$membervariable = $bsiCore->ClearInput($_REQUEST[$param]);}}
				else{if(isset($_REQUEST[$param])){$membervariable = $bsiCore->ClearInput($_REQUEST[$param]);}
					else{$membervariable = $defaultvalue;}}				
				break;
			case "SERVER":
				if($required){if(!isset($_SERVER[$param])){$this->invalidRequest(9);}
					else{$membervariable = $_SERVER[$param];}}
				else{if(isset($_SERVER[$param])){$membervariable = $_SERVER[$param];}
					else{$membervariable = $defaultvalue;}}				
				break;			
		}		
	}	
	
	private function invalidRequest($errocode = 9){		
		header('Location: booking-failure.php?error_code='.$errocode.'');
		die;
	}
	
	private function removeSessionVariables(){
		if(isset($_SESSION['sv_checkindate'])) unset($_SESSION['sv_checkindate']);
		if(isset($_SESSION['sv_checkoutdate'])) unset($_SESSION['sv_checkoutdate']);
		if(isset($_SESSION['sv_mcheckindate'])) unset($_SESSION['sv_mcheckindate']);
		if(isset($_SESSION['sv_mcheckoutdate'])) unset($_SESSION['sv_mcheckoutdate']);	
		if(isset($_SESSION['sv_nightcount'])) unset($_SESSION['sv_nightcount']);
		if(isset($_SESSION['sv_guestperroom'])) unset($_SESSION['sv_guestperroom']);
		if(isset($_SESSION['sv_childcount'])) unset($_SESSION['sv_childcount']);	
		if(isset($_SESSION['svars_details'])) unset($_SESSION['svars_details']);
		if(isset($_SESSION['dvars_details'])) unset($_SESSION['dvars_details']);
		if(isset($_SESSION['dv_roomidsonly'])) unset($_SESSION['dv_roomidsonly']);	
		if(isset($_SESSION['dvars_roomprices'])) unset($_SESSION['dvars_roomprices']);
	}
	 
	/* Check Immediate Booking Status For Concurrent Access */
	private function checkAvailability(){
		$sql = "
		SELECT resv.room_id
		  FROM bsi_reservation resv, bsi_bookings boks
		 WHERE     resv.bookings_id = boks.booking_id
			   AND ((NOW() - boks.booking_time) < ".$this->expTime.")
			   AND boks.is_deleted = FALSE
			   AND resv.room_id IN (".$this->roomIdsOnly.")
			   AND (('".$this->mysqlCheckInDate."' BETWEEN boks.start_date AND DATE_SUB(boks.end_date, INTERVAL 1 DAY))
				OR (DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY) BETWEEN boks.start_date AND DATE_SUB(boks.end_date, INTERVAL 1 DAY))
				OR (boks.start_date BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY))
				OR (DATE_SUB(boks.end_date, INTERVAL 1 DAY) BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY)))";				
		$sql = mysql_query($sql);
			
		if(mysql_num_rows($sql)){	
			mysql_free_result($sql);
			$this->invalidRequest(13);
			die;
		}
		mysql_free_result($sql);
	}
	
	private function saveClientData(){
		$sql1 = mysql_query("SELECT client_id FROM bsi_clients WHERE email = '".$this->clientdata['email']."'");
		if(mysql_num_rows($sql1) > 0){
			$clientrow = mysql_fetch_assoc($sql1);
			$this->clientId = $clientrow["client_id"];	
			$sql2 = mysql_query("UPDATE bsi_clients SET first_name = '".$this->clientdata['fname']."', surname = '".$this->clientdata['lname']."', title = '".$this->clientdata['title']."', street_addr = '".$this->clientdata['address']."', city = '".$this->clientdata['city']."' , province = '".$this->clientdata['state']."', zip = '".$this->clientdata['zipcode']."', country = '".$this->clientdata['country']."', phone = '".$this->clientdata['phone']."', fax = '".$this->clientdata['fax']."', additional_comments = '".$this->clientdata['message']."', ip = '".$this->clientdata['clientip']."' WHERE client_id = ".$this->clientId);				
		}else{
			$sql2 = mysql_query("INSERT INTO bsi_clients (first_name, surname, title, street_addr, city, province, zip, country, phone, fax, email, additional_comments, ip) values('".$this->clientdata['fname']."', '".$this->clientdata['lname']."', '".$this->clientdata['title']."', '".$this->clientdata['address']."', '".$this->clientdata['city']."' , '".$this->clientdata['state']."', '".$this->clientdata['zipcode']."', '".$this->clientdata['country']."', '".$this->clientdata['phone']."', '".$this->clientdata['fax']."', '".$this->clientdata['email']."', '".$this->clientdata['message']."', '".$this->clientdata['clientip']."')");
			$this->clientId = mysql_insert_id();			
		}
		mysql_free_result($sql1);		
	}
	
	private function saveBookingData(){
		$sql = mysql_query("INSERT INTO bsi_bookings (booking_id, booking_time, start_date, end_date, client_id, total_cost, payment_amount, payment_type, special_requests) values(".$this->bookingId.", NOW(), '".$this->mysqlCheckInDate."', '".$this->mysqlCheckOutDate."', ".$this->clientId.", ".$this->grandTotalAmount.", ".$this->totalPaymentAmount.", '".$this->paymentGatewayCode."', '".$this->clientdata['message']."')");
		
		foreach($this->reservationdata as $revdata){
			foreach($revdata['availablerooms'] as $rooms){				
			$sql = mysql_query("INSERT INTO bsi_reservation (bookings_id, room_id, room_type_id) values(".$this->bookingId.",  ".$rooms['roomid'].", ".$revdata['roomtypeid'].")");
			} 
		}
	}	
	
	private function createInvoice(){
		$this->invoiceHtml = '<table style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; background:#999999; width:700px; border:none;" cellpadding="4" cellspacing="1"><tbody><tr><td align="left" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;" colspan="4">'.mysql_real_escape_string(BOOKING_DETAILS_TEXT).'</td></tr>
		<tr><td align="left" style="background:#ffffff;">'.mysql_real_escape_string(INV_BOOKING_NUMBER).'</td><td align="left" style="background:#ffffff;" colspan="3">'.$this->bookingId.'</td></tr>
		<tr><td align="left" style="background:#ffffff;">'.mysql_real_escape_string(INV_CUSTOMER_NAME).'</td><td align="left" style="background:#ffffff;" colspan="3">'.$this->clientName.'</td></tr>	
		<tr height="8px;"><td align="left" style="background:#ffffff;" colspan="4"></td></tr>
		<tr><td align="center" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(CHECKIN_DATE_TEXT).'</td><td align="center" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(CHECKOUT_DATE_TEXT).'</td><td align="center" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(TOTAL_NIGHT_TEXT).'</td><td align="center" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(TOTAL_ROOMS_TEXT).'</td></tr>
		<tr><td align="center" style="background:#ffffff;">'.$this->checkInDate.'</td><td align="center" style="background:#ffffff;">'.$this->checkOutDate.'</td><td align="center" style="background:#ffffff;">'.$this->noOfNights.'</td><td align="center" style="background:#ffffff;">'.$this->noOfRooms.'</td></tr>
		<tr height="8px;"><td align="left" style="background:#ffffff;" colspan="4">&nbsp;</td></tr>
		<tr><td align="center" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(NUMBER_OF_ROOM_TEXT).'</td><td align="center" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(ROOM_TYPE_TEXT).'</td><td align="center" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(MAXI_OCCUPENCY_TEXT).'</td><td align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(GROSS_TOTAL_TEXT).'</td></tr>';		
			
		foreach($this->reservationdata2 as $revdata){
				$this->invoiceHtml.= '<tr><td align="center" style="background:#ffffff;">'.$revdata['roomno'].'</td><td align="center" style="background:#ffffff;">'.$revdata['roomtype'].' ('.$revdata['capacitytitle'].')</td><td align="center" style="background:#ffffff;">'.$revdata['capacity'].' '.INV_ADULT.'';			
				$this->invoiceHtml.= '</td><td align="right" style="background:#ffffff;">'.$this->currencySymbol.number_format($revdata['grosstotal'], 2 , '.', ',').'</td></tr>';
			
		}
		
		$this->invoiceHtml.= '<tr height="8px;"><td align="left" style="background:#ffffff;" colspan="4"></td></tr><tr><td colspan="3" align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(SUB_TOTAL_TEXT).'</td><td align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.$this->currencySymbol.number_format($this->pricedata['subtotal'], 2 , '.', ',').'</td></tr>';
					
		if($this->taxPercent > 0 &&  $this->taxWithPrice == 0){ 	
		$this->invoiceHtml.= '<tr><td colspan="3" align="right" style="background:#ffffff;">'.mysql_real_escape_string(TAX_TEXT).'('.number_format($this->taxPercent, 2 , '.', '').'%)</td><td align="right" style="background:#ffffff;">(+) '.$this->currencySymbol.number_format($this->taxAmount, 2 , '.', ',').'</td></tr><tr><td colspan="3" align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(GRAND_TOTAL_TEXT).'</td><td align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.$this->currencySymbol.number_format($this->grandTotalAmount, 2 , '.', ',').'</td></tr>';
		}else{
			$this->invoiceHtml.= '<tr><td colspan="3" align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.GRAND_TOTAL_TEXT.'</td><td align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.$this->currencySymbol.number_format($this->grandTotalAmount, 2 , '.', ',').'</td></tr>';	
		}
		if($this->depositenabled && ($this->pricedata['advancepercentage'] > 0 && $this->pricedata['advancepercentage'] < 100)){
			
			$this->invoiceHtml.= '<tr><td colspan="3" align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(ADVANCE_PAYMENT_TEXT).'(<span style="font-size: 10px;">'.number_format($this->pricedata['advancepercentage'], 2 , '.', '').'% '.mysql_real_escape_string(OF_GRAND_TOTAL_TEXT).'</span>)</td><td align="right" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.$this->currencySymbol.number_format($this->totalPaymentAmount, 2 , '.', ',').'</td></tr>';
		} 
		$this->invoiceHtml.= '</tbody></table>';
		
		if($this->paymentGatewayCode == "poa"){
			$payoptions = "Manual: Pay On Arival";		
			
			$this->invoiceHtml.= '<br /><table  style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; background:#999999; width:700px; border:none;" cellpadding="4" cellspacing="1"><tr><td align="left" colspan="2" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(INV_PAY_DETAILS).'</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps;background:#ffffff;">'.mysql_real_escape_string(INV_PAY_OPTION).'</td><td align="left" style="background:#ffffff;">'.$payoptions.'</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps; background:#ffffff;">'.mysql_real_escape_string(INV_TXN_ID).'</td><td align="left" style="background:#ffffff;">NA</td></tr></table>';					
		}
		
		/* insert the invoice data in bsi_invoice table */
		$insertInvoiceSQL = mysql_query("INSERT INTO bsi_invoice(booking_id, client_name, client_email, invoice) values(".$this->bookingId.", '".$this->clientName."', '".$this->clientdata['email']."', '".$this->invoiceHtml."')");	
	}
}
?>