<?php
$bsiAdminMain = new bsiAdminCore;
class bsiAdminCore{ 
public function global_setting(){
	global $bsiCore;
	$global_selects=array();
	//date format start
	$dt_format_array=array("mm/dd/yy","dd/mm/yy","mm-dd-yy","dd-mm-yy","mm.dd.yy","dd.mm.yy","yy-mm-dd");
	$select_dt_format="";
	for($p=0; $p<7; $p++){
	if($dt_format_array[$p]==$bsiCore->config['conf_dateformat'])
	$select_dt_format.='<option value="'.$dt_format_array[$p].'" selected="selected">'.strtoupper($dt_format_array[$p]).'</option>';
	else
	$select_dt_format.='<option value="'.$dt_format_array[$p].'" >'.strtoupper($dt_format_array[$p]).'</option>';
	}
	$global_selects['select_dt_format']=$select_dt_format;
	//date format end
	
	//room lock start
	$room_lock = array(
	        '200' => '2 Minute',
			'500' => '5 Minute',
			'1000' => '10 Minute',
			'2000' => '20 Minute',
			'3000' => '30 Minute');
			
	$select_room_lock="";
	foreach($room_lock as $key => $value) {
	    if($key==$bsiCore->config['conf_booking_exptime'])
		$select_room_lock.='		<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
		else
		$select_room_lock.='		<option value="' . $key . '">' . $value . '</option>' . "\n";
	}
	$global_selects['select_room_lock']=$select_room_lock;
	//room lock end
	
	//timezone_start
	$zonelist = array('Kwajalein' => '(GMT-12:00) International Date Line West',
			'Pacific/Midway' => '(GMT-11:00) Midway Island',
			'Pacific/Samoa' => '(GMT-11:00) Samoa',
			'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
			'America/Anchorage' => '(GMT-09:00) Alaska',
			'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US &amp; Canada)',
			'America/Tijuana' => '(GMT-08:00) Tijuana, Baja California',
			'America/Denver' => '(GMT-07:00) Mountain Time (US &amp; Canada)',
			'America/Chihuahua' => '(GMT-07:00) Chihuahua',
			'America/Mazatlan' => '(GMT-07:00) Mazatlan',
			'America/Phoenix' => '(GMT-07:00) Arizona',
			'America/Regina' => '(GMT-06:00) Saskatchewan',
			'America/Tegucigalpa' => '(GMT-06:00) Central America',
			'America/Chicago' => '(GMT-06:00) Central Time (US &amp; Canada)',
			'America/Mexico_City' => '(GMT-06:00) Mexico City',
			'America/Monterrey' => '(GMT-06:00) Monterrey',
			'America/New_York' => '(GMT-05:00) Eastern Time (US &amp; Canada)',
			'America/Bogota' => '(GMT-05:00) Bogota',
			'America/Lima' => '(GMT-05:00) Lima',
			'America/Rio_Branco' => '(GMT-05:00) Rio Branco',
			'America/Indiana/Indianapolis' => '(GMT-05:00) Indiana (East)',
			'America/Caracas' => '(GMT-04:30) Caracas',
			'America/Halifax' => '(GMT-04:00) Atlantic Time (Canada)',
			'America/Manaus' => '(GMT-04:00) Manaus',
			'America/Santiago' => '(GMT-04:00) Santiago',
			'America/La_Paz' => '(GMT-04:00) La Paz',
			'America/St_Johns' => '(GMT-03:30) Newfoundland',
			'America/Argentina/Buenos_Aires' => '(GMT-03:00) Georgetown',
			'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
			'America/Godthab' => '(GMT-03:00) Greenland',
			'America/Montevideo' => '(GMT-03:00) Montevideo',
			'Atlantic/South_Georgia' => '(GMT-02:00) Mid-Atlantic',
			'Atlantic/Azores' => '(GMT-01:00) Azores',
			'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
			'Europe/Dublin' => '(GMT) Dublin',
			'Europe/Lisbon' => '(GMT) Lisbon',
			'Europe/London' => '(GMT) London',
			'Africa/Monrovia' => '(GMT) Monrovia',
			'Atlantic/Reykjavik' => '(GMT) Reykjavik',
			'Africa/Casablanca' => '(GMT) Casablanca',
			'Europe/Belgrade' => '(GMT+01:00) Belgrade',
			'Europe/Bratislava' => '(GMT+01:00) Bratislava',
			'Europe/Budapest' => '(GMT+01:00) Budapest',
			'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
			'Europe/Prague' => '(GMT+01:00) Prague',
			'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
			'Europe/Skopje' => '(GMT+01:00) Skopje',
			'Europe/Warsaw' => '(GMT+01:00) Warsaw',
			'Europe/Zagreb' => '(GMT+01:00) Zagreb',
			'Europe/Brussels' => '(GMT+01:00) Brussels',
			'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
			'Europe/Madrid' => '(GMT+01:00) Madrid',
			'Europe/Paris' => '(GMT+01:00) Paris',
			'Africa/Algiers' => '(GMT+01:00) West Central Africa',
			'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
			'Europe/Berlin' => '(GMT+01:00) Berlin',
			'Europe/Rome' => '(GMT+01:00) Rome',
			'Europe/Stockholm' => '(GMT+01:00) Stockholm',
			'Europe/Vienna' => '(GMT+01:00) Vienna',
			'Europe/Minsk' => '(GMT+02:00) Minsk',
			'Africa/Cairo' => '(GMT+02:00) Cairo',
			'Europe/Helsinki' => '(GMT+02:00) Helsinki',
			'Europe/Riga' => '(GMT+02:00) Riga',
			'Europe/Sofia' => '(GMT+02:00) Sofia',
			'Europe/Tallinn' => '(GMT+02:00) Tallinn',
			'Europe/Vilnius' => '(GMT+02:00) Vilnius',
			'Europe/Athens' => '(GMT+02:00) Athens',
			'Europe/Bucharest' => '(GMT+02:00) Bucharest',
			'Europe/Istanbul' => '(GMT+02:00) Istanbul',
			'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
			'Asia/Amman' => '(GMT+02:00) Amman',
			'Asia/Beirut' => '(GMT+02:00) Beirut',
			'Africa/Windhoek' => '(GMT+02:00) Windhoek',
			'Africa/Harare' => '(GMT+02:00) Harare',
			'Asia/Kuwait' => '(GMT+03:00) Kuwait',
			'Asia/Riyadh' => '(GMT+03:00) Riyadh',
			'Asia/Baghdad' => '(GMT+03:00) Baghdad',
			'Africa/Nairobi' => '(GMT+03:00) Nairobi',
			'Asia/Tbilisi' => '(GMT+03:00) Tbilisi',
			'Europe/Moscow' => '(GMT+03:00) Moscow',
			'Europe/Volgograd' => '(GMT+03:00) Volgograd',
			'Asia/Tehran' => '(GMT+03:30) Tehran',
			'Asia/Muscat' => '(GMT+04:00) Muscat',
			'Asia/Baku' => '(GMT+04:00) Baku',
			'Asia/Yerevan' => '(GMT+04:00) Yerevan',
			'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
			'Asia/Karachi' => '(GMT+05:00) Karachi',
			'Asia/Tashkent' => '(GMT+05:00) Tashkent',
			'Asia/Calcutta' => '(GMT+05:30) Calcutta',
			'Asia/Colombo' => '(GMT+05:30) Sri Jayawardenepura',
			'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
			'Asia/Dhaka' => '(GMT+06:00) Dhaka',
			'Asia/Almaty' => '(GMT+06:00) Almaty',
			'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk',
			'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)',
			'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
			'Asia/Bangkok' => '(GMT+07:00) Bangkok',
			'Asia/Jakarta' => '(GMT+07:00) Jakarta',
			'Asia/Brunei' => '(GMT+08:00) Beijing',
			'Asia/Chongqing' => '(GMT+08:00) Chongqing',
			'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
			'Asia/Urumqi' => '(GMT+08:00) Urumqi',
			'Asia/Irkutsk' => '(GMT+08:00) Irkutsk',
			'Asia/Ulaanbaatar' => '(GMT+08:00) Ulaan Bataar',
			'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
			'Asia/Singapore' => '(GMT+08:00) Singapore',
			'Asia/Taipei' => '(GMT+08:00) Taipei',
			'Australia/Perth' => '(GMT+08:00) Perth',
			'Asia/Seoul' => '(GMT+09:00) Seoul',
			'Asia/Tokyo' => '(GMT+09:00) Tokyo',
			'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
			'Australia/Darwin' => '(GMT+09:30) Darwin',
			'Australia/Adelaide' => '(GMT+09:30) Adelaide',
			'Australia/Canberra' => '(GMT+10:00) Canberra',
			'Australia/Melbourne' => '(GMT+10:00) Melbourne',
			'Australia/Sydney' => '(GMT+10:00) Sydney',
			'Australia/Brisbane' => '(GMT+10:00) Brisbane',
			'Australia/Hobart' => '(GMT+10:00) Hobart',
			'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
			'Pacific/Guam' => '(GMT+10:00) Guam',
			'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
			'Asia/Magadan' => '(GMT+11:00) Magadan',
			'Pacific/Fiji' => '(GMT+12:00) Fiji',
			'Asia/Kamchatka' => '(GMT+12:00) Kamchatka',
			'Pacific/Auckland' => '(GMT+12:00) Auckland',
			'Pacific/Tongatapu' => '(GMT+13:00) Nukualofa');
			
			//date format
			
			$dformat=array(
			'MM/DD/YYYY' => 'mm/dd/yy',
			'DD/MM/YYYY' => 'dd/mm/yy',
			'MM-DD-YYYY' => 'mm-dd-yy',
			'DD-MM-YYYY' => 'dd-mm-yy',
			'MM.DD.YYYY' => 'mm.dd.yy',
			'DD.MM.YYYY' => 'dd.mm.yy',
			'YYYY-MM-DD' => 'yy-mm-dd'
			);
			
	$select_timezone="";
	foreach($zonelist as $key => $value) {
	    if($key==$bsiCore->config['conf_hotel_timezone'])
		$select_timezone.='		<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
		else
		$select_timezone.='		<option value="' . $key . '">' . $value . '</option>' . "\n";
	}
     $global_selects['select_timezone']=$select_timezone;
	 
	 if($bsiCore->config['conf_booking_turn_off']==0){
		 $select_booking_turn='		<option value="0" selected="selected">'.TURN_ON.'</option>' . "\n";
		 $select_booking_turn.='		<option value="1">'.TURN_OFF.'</option>' . "\n";
	 }else{
		 $select_booking_turn='		<option value="1" selected="selected">'.TURN_OFF.'</option>' . "\n";
		 $select_booking_turn.='		<option value="0">'.TURN_ON.'</option>' . "\n";
	 }
	 $global_selects['select_booking_turn']=$select_booking_turn;
	 
	 $select_min_booking="";
	 for($k=1; $k<11; $k++){
	 	if($bsiCore->config['conf_min_night_booking']==$k){
		$select_min_booking.='		<option value="' . $k . '" selected="selected">' . $k . '</option>' . "\n";
		}else{
		$select_min_booking.='		<option value="' . $k . '">' . $k . '</option>' . "\n";
		}
	 }
	 $global_selects['select_min_booking']=$select_min_booking;
	 
	 $select_dateformat="";
	foreach($dformat as $key => $value) {
	    if($value==$bsiCore->config['conf_dateformat'])
		$select_dateformat.='		<option value="' . $value . '" selected="selected">' . $key  . '</option>' . "\n";
		else
		$select_dateformat.='		<option value="' . $value  . '">' . $key. '</option>' . "\n";
	}
     $global_selects['select_dateformat']=$select_dateformat;
	 
	 return $global_selects;
	} 
	
	
	public function global_setting_post(){
		global $bsiCore;
		if(isset($_POST['price_inclu_tax'])){
			$pincludetax=1;
		}else{
			$pincludetax=0;
		}
		//echo "htmlentities('".$_POST['currency_symbol']."','ENT_COMPAT','utf-8')";
		$this->configure_update('conf_notification_email',  mysql_real_escape_string($_POST['email_notification']));
		$this->configure_update('conf_currency_code',  mysql_real_escape_string($_POST['currency_code']));
		$this->configure_update('conf_currency_symbol',  htmlentities(mysql_real_escape_string($_POST['currency_symbol']),ENT_COMPAT,'utf-8'));		
		$this->configure_update('conf_booking_turn_off',  mysql_real_escape_string($_POST['booking_turn']));
		$this->configure_update('conf_hotel_timezone',  mysql_real_escape_string($_POST['timezone']));
		$this->configure_update('conf_min_night_booking',  mysql_real_escape_string($_POST['minbooking']));
		$this->configure_update('conf_dateformat', mysql_real_escape_string($_POST['date_format']));
		$this->configure_update('conf_booking_exptime', mysql_real_escape_string($_POST['room_lock'])); 	
		$this->configure_update('conf_price_with_tax', $pincludetax);
		$this->configure_update('conf_tax_amount',  mysql_real_escape_string($_POST['tax']));	
		
	}
	
	private function configure_update($key, $value){
		//echo "update bsi_configure set conf_value='".$value."' where conf_key='".$key."'";die;
		mysql_query("update bsi_configure set conf_value='".$value."' where conf_key='".$key."'");
	}
	
	public function payment_gateway(){
		$gateway_value=array();
		$pp_row=mysql_fetch_assoc(mysql_query("select * from bsi_payment_gateway where gateway_code='pp'"));
		$poa_row=mysql_fetch_assoc(mysql_query("select * from bsi_payment_gateway where gateway_code='poa'"));
		$cc_row=mysql_fetch_assoc(mysql_query("select * from bsi_payment_gateway where gateway_code='cc'"));
		
		$gateway_value['pp_enabled']=$pp_row['enabled'];
		$gateway_value['pp_gateway_name']=$pp_row['gateway_name'];
		$gateway_value['pp_account']=$pp_row['account'];
		
		
		
		$gateway_value['poa_enabled']=$poa_row['enabled'];
		$gateway_value['poa_gateway_name']=$poa_row['gateway_name'];
		
		$gateway_value['cc_enabled']=$cc_row['enabled'];
		$gateway_value['cc_gateway_name']=$cc_row['gateway_name'];
		
		return $gateway_value;
	}
	
	public function payment_gateway_post(){
		global $bsiCore;
	    $pp = ((isset($_POST['pp'])) ? 1 : 0);
		$pp_title=mysql_real_escape_string($_POST['pp_title']);
		$paypal_id=mysql_real_escape_string($_POST['paypal_id']);
		
		
		$poa = ((isset($_POST['poa'])) ? 1 : 0);
		$poa_title=mysql_real_escape_string($_POST['poa_title']);
		
		$eft = ((isset($_POST['cc'])) ? 1 : 0);
		$cc_title=mysql_real_escape_string($_POST['cc_title']);
		
	
		
		mysql_query("update bsi_payment_gateway set gateway_name='$pp_title', account='$paypal_id', enabled=$pp where gateway_code='pp'");
		mysql_query("update bsi_payment_gateway set gateway_name='$poa_title',  enabled=$poa where gateway_code='poa'");
		mysql_query("update bsi_payment_gateway set gateway_name='$cc_title',  enabled=$eft where gateway_code='cc'");
	}
	
	public function getEmailContents(){
				global $bsiCore;
				$dropList='<option value="0" selected="selected">----'.SELECT_EMAIL_TYPE_CONTENT.'----</option>';
				$sql=mysql_query("select * from bsi_email_contents");
				while($rowemailinfo=mysql_fetch_assoc($sql)){
					$dropList.='<option value="'.$rowemailinfo['id'].'">'.$rowemailinfo['email_name'].'</option>';
					}
				return $dropList;
		}
		
		public function updateEmailContent(){	
		   global $bsiCore;
		   $emailsub=$bsiCore->ClearInput($_POST['email_sub']);
		   $emailcon=$bsiCore->ClearInput($_POST['email_con']);
		   $mailid=$bsiCore->ClearInput($_POST['c_update']);
		   mysql_query("update bsi_email_contents set email_subject='".$emailsub."',email_text='".$emailcon."' where id='".$mailid."'");	
		}
     public function getRoomtype($id=0){
		$roomtype = '<select name="roomtype" id="roomtype"><option value="0">---- '.PRICEPLAN_SELECT.' ----</option>';
		$result = mysql_query("select * from bsi_roomtype");
		while($roomtypeRow=mysql_fetch_assoc($result)){
			if($roomtypeRow['roomtype_ID'] == $id)
				$roomtype .='<option value="'.$roomtypeRow['roomtype_ID'].'" selected="selected">'.$roomtypeRow['type_name'].'</option>';
			else
				$roomtype .='<option value="'.$roomtypeRow['roomtype_ID'].'">'.$roomtypeRow['type_name'].'</option>';
		}
		$roomtype .= '</select>';
		return $roomtype;
	}	
 
 public function hotel_details_post(){
		global $bsiCore;
		$this->configure_update('conf_hotel_name', mysql_real_escape_string($_POST['hotel_name']));
		$this->configure_update('conf_hotel_streetaddr', mysql_real_escape_string($_POST['str_addr']));
		$this->configure_update('conf_hotel_city', mysql_real_escape_string($_POST['city']));
		$this->configure_update('conf_hotel_state', mysql_real_escape_string($_POST['state']));
		$this->configure_update('conf_hotel_country', mysql_real_escape_string($_POST['country']));
		$this->configure_update('conf_hotel_zipcode', mysql_real_escape_string($_POST['zipcode']));
		$this->configure_update('conf_hotel_phone', mysql_real_escape_string($_POST['phone']));
		$this->configure_update('conf_hotel_fax', mysql_real_escape_string($_POST['fax']));
		$this->configure_update('conf_hotel_email', mysql_real_escape_string($_POST['email']));
		
	}
	
	public function getBookingInfo($info , $clientid=0, $condition=""){
		global $bsiCore;
		switch($info){
			case 1:
			$sql = "SELECT booking_id, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id  FROM bsi_bookings where payment_success=true and CURDATE() <= end_date and is_deleted=false and is_block=false  ".$condition." ";
			break;
		
			case 2:
			$sql = "SELECT booking_id, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id, is_deleted  FROM bsi_bookings where payment_success=true and (CURDATE() > end_date OR is_deleted=true)  and is_block=false ".$condition." ";
			break;
			
			case 3:
			$sql = "SELECT booking_id, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date, end_date as checkout, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, is_deleted, is_block  FROM bsi_bookings where client_id=".$clientid;
			break;
		
		}
		return $sql;
	 }
	 public function getClientInfo($client_id){
		$row=mysql_fetch_assoc(mysql_query("select * from bsi_clients where client_id=".$client_id));
		return $row;
	 } 
	 
	 
	 public function getHtml($type=0,$query){
		global $bsiCore;
		$clientArr = array();
		if($type == 1){
			$html = '<thead>
						  <tr>
							<th width="10%" nowrap>'.VIEW_ACTIVE_BOOKING_ID.'</th>
							<th width="18%" nowrap>'.VIEW_ACTIVE_NAME.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_CHECK_IN.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_CHECK_OUT.'</th>
							<th width="8%" nowrap>'.VIEW_ACTIVE_AMOUNT.'</th>
							<th width="14%" nowrap>'.VIEW_ACTIVE_BOOKING_DATE.'</th>
							<th width="30%" nowrap>&nbsp;</th>
						   </tr>
					  </thead>
					  <tbody>';
			$result = mysql_query($query);
			while($row = mysql_fetch_assoc($result)){
				$clientArr = $this->getClientInfo($row['client_id']);
				$html .= '<tr>
							<td width="10%" nowrap>'.$row['booking_id'].'</td>
							<td width="18%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
							<td width="10%" nowrap>'.$row['start_date'].'</td>
							<td width="10%" nowrap>'.$row['end_date'].'</td>
							<td width="8%" nowrap>'.$bsiCore->config['conf_currency_symbol'].$row['total_cost'].'</td>
							<td width="14%" nowrap>'.$row['booking_time'].'</td>
							<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap" width="30%">
								<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'">'.VIEW_ACTIVE_DETAILS.'</a> | 
								<a href="javascript:;" onClick="javascript:myPopup2(\''.$row['booking_id'].'\');">'.VIEW_PRINT_VOUCHER.'</a> |  
								<a href="javascript:;" onClick="return cancel(\''.$row['booking_id'].'\');">'.VIEW_ACTIVE_CANCEL.'</a>
							</td>
						  </tr>';
			}
		}
		if($type == 2){
			$html = '<thead>
						  <th width="10%" nowrap><strong>Booking ID</strong></th>
						  <th width="18%" nowrap><strong>Name</strong></th>
						  <th width="10%" nowrap><strong>Check In</strong></th>
						  <th width="10%" nowrap><strong>Check Out</strong></th>
						  <th width="8%" nowrap><strong>Amount</strong></th>
						  <th width="14%" nowrap><strong>Booking Date</strong></th>
						  <th width="30%" nowrap>&nbsp;</th>
					  </thead>
					  <tbody>';
			$result = mysql_query($query);
			if(mysql_num_rows($result)){
				while($row = mysql_fetch_assoc($result)){
					$clientArr = $this->getClientInfo($row['client_id']);
					$html .= '<tr>
								<td width="10%" nowrap>'.$row['booking_id'].'</td>
								<td width="18%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
								<td width="10%" nowrap>'.$row['start_date'].'</td>
								<td width="10%" nowrap>'.$row['end_date'].'</td>
								<td width="10%" nowrap>'.$bsiCore->config['conf_currency_symbol'].$row['total_cost'].'</td>
								<td width="14%" nowrap>'.$row['booking_time'].'</td>
								<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap" width="30%">
									<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'">View Details</a> | 
									<a href="javascript:;" onclick="myPopup2(\''.$row['booking_id'].'\');">Print Voucher</a> |  
									<a href="javascript:;" onclick="return deleteBooking(\''.$row['booking_id'].'\');">Delete</a>
								</td>
							  </tr>';
				}
			}
		}
		$html .= '</tbody>'; 
		return $html;
	 }
	 	
	public function getYearcombo($yearselected){
		$year = '<select name="year" id="year">';
		$time = time();
		$current_year = date("Y", $time);
		
		for($i = $current_year; $i <= ($current_year+5); $i++){
			if($i == $yearselected){
				$year .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			}else{
				$year .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$year .= '</select>';
		return $year;
	}
	
	public function getRoomtypeCal($id=0){
		$roomtype = '<select name="roomtype" id="roomtype"><option value="0">All RoomType</option>';
		$result = mysql_query("select * from bsi_roomtype");
		while($roomtypeRow=mysql_fetch_assoc($result)){
			if($roomtypeRow['roomtype_ID'] == $id)
				$roomtype .='<option value="'.$roomtypeRow['roomtype_ID'].'" selected="selected">'.$roomtypeRow['type_name'].'</option>';
			else
				$roomtype .='<option value="'.$roomtypeRow['roomtype_ID'].'">'.$roomtypeRow['type_name'].'</option>';
		}
		$roomtype .= '</select>';
		return $roomtype;
	}
	
	public function getdaysName(){	
			$html = '';
		for($i=0; $i<5; $i++){
			$html .= '<td align="center" bgcolor="#ffbc5b" style="color:#040404"><strong>'.SU.'</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>'.MO.'</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>'.TU.'</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>'.WE.'</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>'.TH.'</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>'.FR.'</strong></td>
					  <td align="center" bgcolor="#ffbc5b" style="color:#040404"><strong>'.SA.'</strong></td>';
		}
		
			$html .= '<td align="center" bgcolor="#ffbc5b" style="color:#040404"><strong>'.SU.'</strong></td>
					  <td align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>'.MO.'</strong></td>';   
		return $html;
	}
	
	public function getCustomerHtml(){
		$html = '';
		$result = mysql_query("select * from bsi_clients");
		while($row = mysql_fetch_assoc($result)){
			$html .= '<tr><td width="20%" nowrap="nowrap">'.$row['title']." ".$row['first_name']." ".$row['surname'].'</td><td width="30%">'.$row['street_addr'].",".$row['city'].",".$row['country']." - ".$row['zip'].'</td><td width="10%">'.$row['phone'].'</td><td width="25%">'.$row['email'].'</td><td width="15%" align="right" nowrap="nowrap"><a href="customerbooking.php?client='.base64_encode($row['client_id']).'">'.CUSTOMERLOOKUP_VIEW_BOOKING.'</a>&nbsp;&nbsp;<a href="customerlookupEdit.php?update='.base64_encode($row['client_id']).'">'.CUSTOMERLOOKUP_EDIT.'</a></td></tr>';
		}
		return $html;
	}
	
public function fetchClientBookingDetails($clientid){
		global $bsiCore;
		$html = '<tbody>';
		
		$arr['clientName'] = '';
	  	$result = $this->getBookingInfo(3, $clientid);
		$res = mysql_query($result);
		
		$client_info = mysql_fetch_assoc(mysql_query("select * from bsi_clients where client_id=".$clientid));
      	while($row =  mysql_fetch_assoc($res)){
			if($row['checkout'] >= date('Y-m-d') && $row['is_deleted'] == 0 && $row['is_block'] == 0){
				$status = '<font color="#00CC00"><b>'.CUSTOMER_BOOKING_ACTIVE.'</b></font>';	
				$action = '<a href="javascript:;" onClick="return cancel(\''.$row['booking_id'].'\');">'.CUSTOMER_CANCEL_BOOKING.'</a>';
				
				$type   = 1;
			}elseif($row['checkout'] < date('Y-m-d') && $row['is_deleted'] == 0 && $row['is_block'] == 0){
				$status = '<font color="#0033FF"><b>'.CUSTOMER_BOOKING_COMPLETED.'</b></font>';	
				$action = '<a href="javascript:;" onclick="javascript:booking_delete('.$row['booking_id'].');" class="bodytext">'.CUSTOMER_DELETE_FOREVER.'</a>';
				$type   = 2;
			}else{
				$status = '<font color="#FF0000"><b>'.CUSTOMER_BOOKING_CANCELLED.'</b></font>';
				
				$type   = 2;
				$action = '<a href="javascript:;" onclick="javascript:booking_delete('.$row['booking_id'].');" class="bodytext">'.CUSTOMER_DELETE_FOREVER.'</a>';
			}
			
			  $html .= '<tr class="gradeX">
				<td align="right">'.$row['booking_id'].'</td>
				<td align="right"  nowrap="nowrap">'.$client_info['title']." ". $client_info['first_name']." ".$client_info['surname'].'</td>
				<td align="right">'.$row['start_date'].'</td>
				<td align="right">'.$row['end_date'].'</td>
				<td align="right">'.$bsiCore->config['conf_currency_symbol'].$row['total_cost'].'</td>
				<td align="right">'.$row['booking_time'].'</td>
				<td align="right">'.$status.'</td>
				<td align="right" nowrap="nowrap"><a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type='.$type.'"" class="bodytext">'.CUSTOMER_BOOKING_VIEW_DETAILS.'</a>&nbsp;&nbsp;<a  href="javascript:;" onclick="javascript:myPopup2('.$row['booking_id'].');" class="bodytext">'.CUSTOMER_BOOKING_PRINT_VOUCHER.'</a>&nbsp;&nbsp;'.$action.'</td>
			  </tr>';
       }
	   $html .= '</tbody>';	
		//}
		
		$arr['html'] = $html;
		
		$arr['clientName'] = $client_info['title']." ". $client_info['first_name']." ".$client_info['surname'];
	   return $arr;
	}
	
	public function booking_cencel_delete($type){
		global $bsiCore;
		global $bsiMail;
		switch($type){
			case 1:
				$bsiMail = new bsiMail();
				$is_cancel = mysql_query("update bsi_bookings set is_deleted=true where booking_id=".$bsiCore->ClearInput($_GET['cancel']));
				if($is_cancel){
				$cust_details = mysql_fetch_assoc(mysql_query("select * from bsi_invoice where booking_id=".$bsiCore->ClearInput($_GET['cancel'])));
				$email_details    = mysql_fetch_assoc(mysql_query("select * from bsi_email_contents where id=2"));
				$cancel_emailBody = "Dear ".$cust_details['client_name']."<br>";
				$cancel_emailBody .= html_entity_decode($email_details['email_text'])."<br>";
				$cancel_emailBody .= "<b>Your Booking Details:</b><br>".$cust_details['invoice']."<br>";
				$cancel_emailBody .= "<b>Regards</b><br>".$bsiCore->config['conf_hotel_name']."<BR>".$bsiCore->config['conf_hotel_phone']."<br>";
				$bsiMail->sendEMail($cust_details['client_email'], $email_details['email_subject'], $cancel_emailBody);
				}
			break;
			
			case 2:
				mysql_query("delete from  bsi_bookings where booking_id=".$bsiCore->ClearInput($_REQUEST['delete']));
				mysql_query("delete from  bsi_reservation where bookings_id=".$bsiCore->ClearInput($_REQUEST['delete']));
				mysql_query("delete from  bsi_invoice where booking_id=".$bsiCore->ClearInput($_REQUEST['delete']));
			break;
		
		}	
	}
	
	public function updateCustomerLookup(){
		$title = mysql_real_escape_string($_POST['titled']);
		$fname = mysql_real_escape_string($_POST['fname']);
		$sname = mysql_real_escape_string($_POST['sname']);
		$sadd = mysql_real_escape_string($_POST['sadd']);
		$city = mysql_real_escape_string($_POST['city']);
		$province = mysql_real_escape_string($_POST['province']);
		$zip = mysql_real_escape_string($_POST['zip']);
		$country = mysql_real_escape_string($_POST['country']);
		$phone = mysql_real_escape_string($_POST['phone']);
		$fax = mysql_real_escape_string($_POST['fax']);
		$email = mysql_real_escape_string($_POST['email']);
		$cid = mysql_real_escape_string($_POST['cid']);
		
		mysql_query("update bsi_clients set first_name='".$fname."',surname='".$sname."',title='".$title."',street_addr='".$sadd."',city='".$city."',province='".$province."',zip='".$zip."',country='".$country."',phone='".$phone."',fax='".$fax."',email='".$email."' where client_id=".$cid);	
		
		$_SESSION['httpRefferer'] = $_POST['httpreffer'];
	}
	
	public function getCustomerLookup($cid){
		global $bsiCore;
		$result = mysql_query("select * from bsi_clients where client_id=".$bsiCore->ClearInput($cid));
		$customerarray=mysql_fetch_assoc($result);
		return $customerarray;
		
	}
	
	public function getTitle($title){
		$html  = '<select name="titled" id="titled">';
		$titleArray =array("Mr" => "Mr.", "Mrs" => "Mrs.", "Ms" => "Ms.", "Dr" => "Dr.", "Miss" => "Miss.", "Prof" => "Prof.");
		foreach($titleArray as $key => $value){
			if($title == $key){
				$html .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
			}else{
				$html .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		$html .= '</select>'; 
		return $html; 
	}
	
	public function paymentDetails($gateway, $bookingid){
		global $bsiCore;
		$paymentgateway = $this->getPayment_Gateway($gateway);
		$invoice=mysql_fetch_assoc(mysql_query("select * from bsi_invoice where booking_id=".$bookingid)); 
		$htmlPD=$invoice['invoice'];
		switch($gateway){			
			
			case "cc":  $ccArr  = $this->getCreditCardDetails($bookingid);
						$htmlPD .= '<br><table style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; background:#999999; 
									width:700px; border:none;" cellpadding="4" cellspacing="1">
										<tr>
										  <td align="left" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;" colspan="2"><b>Credit Card Details</b></td>
										</tr>
										<tr>
										  <td align="left" style="background:#ffffff;" width="150px">Card Holder Name</td>
										  <td align="left" style="background:#ffffff;">'.$ccArr['cardholder_name'].'</td>
										</tr>
										<tr>
										  <td align="left" style="background:#ffffff;">Card Type</td>
										  <td align="left" style="background:#ffffff;">'.$ccArr['card_type'].'</td>
										</tr>
										<tr>
										  <td align="left" style="background:#ffffff;">Card Number</td>
										  <td align="left" style="background:#ffffff;">'.$bsiCore->decryptCard($ccArr['card_number']).'</td>
										</tr>
										<tr>
										  <td align="left" style="background:#ffffff;">Expiry Date</td>
										  <td align="left" style="background:#ffffff;">'.$ccArr['expiry_date'].'</td>
										</tr>
										<tr>
										  <td align="left" style="background:#ffffff;">CCV/CCV2</td>
										  <td align="left" style="background:#ffffff;">'.$ccArr['ccv2_no'].'</td>
										</tr>
								  </table>';
			break;
		}
		return $htmlPD;
	}
	
	public function getPayment_Gateway($pg){
		$row = mysql_fetch_assoc(mysql_query("select gateway_name from bsi_payment_gateway where gateway_code='".$pg."'"));	
		return $row['gateway_name'];
	}
	
	public function getPaypalDetails($bid){
		$row = mysql_fetch_assoc(mysql_query("select payment_txnid, paypal_email from bsi_bookings where booking_id=$bid"));
		return $row;
	}
	
	public function getCapacitysql($id=0){
		if($id){
			$subquery = " where id=".$id;
		}else{
			$subquery = "";
		}
		$sql = "select * from bsi_capacity".$subquery;
		return $sql;	
	}
	
	public function add_edit_language(){
		global $bsiCore;
		$id = $bsiCore->ClearInput($_POST['addedit']);
		$lang_title = $bsiCore->ClearInput($_POST['lang_title']);
		$lang_code = $bsiCore->ClearInput($_POST['lang_code']);
		$lang_file = $bsiCore->ClearInput($_POST['lang_file']);
		$lang_default = (isset($_POST['lang_default']))? 1:0;
		if($lang_default==1)
		mysql_query("update bsi_language set lang_default=0");
		
		if($id){
			mysql_query("update bsi_language set lang_title='$lang_title', lang_code='$lang_code', lang_file='$lang_file', lang_default=$lang_default where id=".$id);
		}else{
			mysql_query("insert into `bsi_language` (`lang_title`, `lang_code`, `lang_file`, `lang_default`) values ('$lang_title', '$lang_code', '$lang_file', '$lang_default')");
		
		}
		
	}
	
	public function add_edit_capacity(){
		global $bsiCore;
		$id = $bsiCore->ClearInput($_POST['addedit']);
		$title = $bsiCore->ClearInput($_POST['capacity_title']);
		$capacity = $bsiCore->ClearInput($_POST['no_adult']);
		if($id){
			mysql_query("update `bsi_capacity` set `title`='$title' where `id`=".$id);
		}else{
			mysql_query("insert into `bsi_capacity` (`title`, `capacity`) values ('$title', ".$capacity.")");
			$capacity_id = mysql_insert_id();
			$result = mysql_query("select start_date, end_date, roomtype_id, default_plan from bsi_priceplan group by start_date, end_date, roomtype_id");
			if(mysql_num_rows($result)){
				while($row = mysql_fetch_assoc($result)){
					mysql_query("INSERT INTO `bsi_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`) VALUES (".$row['roomtype_id'].", ".$capacity_id.", '".$row['start_date']."', '".$row['end_date']."', '0', '0', '0', '0', '0', '0', '0', '".$row['default_plan']."')");
				}
			}else{
				$res = mysql_query($this->getRoomtypesql());
				if(mysql_num_rows($res)){
					while($row = mysql_fetch_assoc($res)){
						mysql_query("INSERT INTO `bsi_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`) VALUES (".$row['roomtype_ID'].", '".$capacity_id."', '0000-00-00', '0000-00-00', '0', '0', '0', '0', '0', '0', '0', '1')");
					}
				}
			}
		}
	}
	
	public function generateCapacityListHtml(){
		$clhtml	= '<tbody>';
		$result = mysql_query($this->getCapacitysql());
		while($row = mysql_fetch_assoc($result)){
			$clhtml .= '<tr>
						  <td >'.$row['title'].'</td>
						  <td >'.$row['capacity'].'</td>
						  <td class="center"  align="right"><a href="add_edit_capacity.php?id='.$row['id'].'">'.CAPACITY_LIST_EDIT.'</a> | <a href="javascript:;" onclick="return capacitydelete(\''.$row['id'].'\');">'.CAPACITY_LIST_DELETE.'</a></td>
						</tr>';
		}
		$clhtml .= '</tbody>';
		return $clhtml;
	}
	
	public function generateLanguageListHtml(){
		$clhtml	= '<tbody>';
		$result = mysql_query("select * from bsi_language");
		while($row = mysql_fetch_assoc($result)){
			$dflt=($row['lang_default'])? 'Yes':'No';
			$clhtml .= '<tr>
						  <td >'.$row['lang_title'].'</td>
						  <td >'.$row['lang_code'].'</td>
						  <td >'.$row['lang_file'].'</td>
						  <td >'.$dflt.'</td>
						  <td class="center"  align="right"><a href="add_edit_language.php?id='.$row['id'].'">'.LANGAUGE_LIST_EDIT.'</a> | <a href="manage_langauge.php?delid='.$row['id'].'" >'.LANGAUGE_LIST_DELETE.'</a></td>
						</tr>';
		}
		$clhtml .= '</tbody>';
		return $clhtml;
	}
	
	public function delete_capacity(){
		global $bsiCore;
		mysql_query("delete from bsi_capacity where id=".$bsiCore->ClearInput($_GET['cdelid']));
		mysql_query("delete from bsi_room where capacity_id=".$bsiCore->ClearInput($_GET['cdelid']));
		mysql_query("delete from bsi_priceplan where capacity_id=".$bsiCore->ClearInput($_GET['cdelid']));	
	}
	
	public function delete_lang(){
		global $bsiCore;
		mysql_query("delete from bsi_language where id=".$bsiCore->ClearInput($_GET['delid']));	
	}
	
	public function getRoomtypesql($id=0){
		if($id){
			$subquery = " where roomtype_ID=".$id;
		}else{
			$subquery = "";
		}
		$sql = "select * from bsi_roomtype".$subquery;
		return $sql;	
	}
	
	public function add_edit_roomtype(){
		global $bsiCore;
		$id = $bsiCore->ClearInput($_POST['addedit']);
		$title = $bsiCore->ClearInput($_POST['roomtype_title']);
		if($id){
			if(isset($_POST['delimg'])){
				$row = mysql_fetch_assoc(mysql_query($this->getRoomtypesql($id)));
				unlink("../gallery/".$row['img']);
				unlink("../gallery/thumb_".$row['img']);
				mysql_query("update `bsi_roomtype` set `img`='' where `roomtype_ID`=".$id);
			}
			if(($_FILES['img']['name'] != "")){
				$enable_thumbnails = 1 ;
				$max_image_size	   = 1024000 ;
				$upload_dir		   = "../gallery/";
				foreach($_FILES as $k => $v){ 	
					$img_type = "";
					if( $_FILES[$k]['error'] == 0 && $_FILES[$k]['size'] < $max_image_size ){
						$img_type = ($_FILES[$k]['type'] == "image/jpeg") ? ".jpg" : $img_type ;
						$img_type = ($_FILES[$k]['type'] == "image/gif") ? ".gif" : $img_type ;
						$img_type = ($_FILES[$k]['type'] == "image/png") ? ".png" : $img_type ;		
						$img_rname = time().'_'.$_FILES[$k]['name'];
						$img_path = $upload_dir.$img_rname;		
						copy( $_FILES[$k]['tmp_name'], $img_path ); 
						$imginfo = getimagesize($img_path);
						$aspectRatio = $imginfo[0] / $imginfo[1];
						$newWidth = (int)($aspectRatio * 50);
						mysql_query("update `bsi_roomtype` set `img`='$img_rname' where `roomtype_ID`=".$id);
						if($enable_thumbnails) $this->make_thumbnails($upload_dir, $img_rname, $newWidth, 50);						
					}
				}
			}			
			mysql_query("update `bsi_roomtype` set `type_name`='$title' where `roomtype_ID`=".$id);
		}else{
			mysql_query("insert into `bsi_roomtype` (`type_name`) values ('$title')");
			$roomtype_id = mysql_insert_id();
			$result = mysql_query("select start_date, end_date, capacity_id, default_plan from bsi_priceplan group by start_date, end_date, capacity_id");
			if(mysql_num_rows($result)){
				while($row = mysql_fetch_assoc($result)){
					mysql_query("INSERT INTO `bsi_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`) VALUES (".$roomtype_id.", '".$row['capacity_id']."', '".$row['start_date']."', '".$row['end_date']."', '0', '0', '0', '0', '0', '0', '0', '".$row['default_plan']."')");
				}
			}else{
				$res = mysql_query($this->getCapacitysql());
				if(mysql_num_rows($res)){
					while($row = mysql_fetch_assoc($res)){
						mysql_query("INSERT INTO `bsi_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`) VALUES (".$roomtype_id.", '".$row['id']."', '0000-00-00', '0000-00-00', '0', '0', '0', '0', '0', '0', '0', '1')");
					}
				}
			}
		}
	}
	
	public function generateRoomtypeListHtml(){
		$rthtml	= '<tbody>';
		$result = mysql_query($this->getRoomtypesql());
		while($row = mysql_fetch_assoc($result)){
			$rthtml .= '<tr>
						  <td>'.$row['type_name'].'</td>
						  <td class="center"  align="right"><a href="add_edit_roomtype.php?id='.$row['roomtype_ID'].'">'.ROOM_TYPE_EDIT.'</a> | <a href="roomtype.php" onclick="return deleteRoomType(\''.$row['roomtype_ID'].'\');">'.ROOM_TYPE_DELETE.'</a></td>
						</tr>';
		}
		$rthtml .= '</tbody>';
		return $rthtml;
	}
	
	public function delete_roomtype(){
		global $bsiCore;
		mysql_query("delete from bsi_roomtype where roomtype_ID=".$bsiCore->ClearInput($_GET['rdelid']));
		mysql_query("delete from bsi_room where roomtype_id=".$bsiCore->ClearInput($_GET['rdelid']));
		mysql_query("delete from bsi_priceplan where roomtype_id=".$bsiCore->ClearInput($_GET['rdelid']));	
	}
	
	public function getRoomsql($rid=0, $cid=0){
		if($rid != 0 && $cid != 0){
			$subquery = " where `roomtype_id`=$rid and `capacity_id`=$cid";
		}else{
			$subquery = "";
		}
		$sql = "SELECT count(*) as NoOfRoom, `roomtype_id`, `capacity_id` FROM bsi_room".$subquery." group by `roomtype_id`, `capacity_id`";
		return $sql;	
	}
	
	public function generateRoomListHtml(){
		$rthtml	= '<tbody>';
		$result = mysql_query($this->getRoomsql());
		while($row = mysql_fetch_assoc($result)){
			$rowrt = mysql_fetch_assoc(mysql_query($this->getRoomtypesql($row['roomtype_id'])));
			$rowca = mysql_fetch_assoc(mysql_query($this->getCapacitysql($row['capacity_id'])));
			$rthtml .= '<tr>
						  <td>'.$rowrt['type_name'].'</td>
						  <td>'.$rowca['title'].'('.$rowca['capacity'].')</td>
						  <td>'.$row['NoOfRoom'].'</td>
						  <td class="center" align="right"><a href="add_edit_room.php?rid='.$row['roomtype_id'].'&cid='.$row['capacity_id'].'">'.EDIT_ROOM_LIST.'</a> | <a href="'.$_SERVER['PHP_SELF'].'?rid='.$row['roomtype_id'].'&cid='.$row['capacity_id'].'">'.DELETE_ROOM_LIST.'</a></td>
						</tr>';
		}
		$rthtml .= '</tbody>';
		return $rthtml;
	}
	
	public function generateRoomtypecombo($rid=0){
		$result = mysql_query($this->getRoomtypesql());	
		$chtml = '<select name="roomtype_id" id="roomtype_id"><option value="0">'.ADD_EDIT_ROOM_SELECT.'</option>';
		while($row = mysql_fetch_assoc($result)){
			if($rid == $row['roomtype_ID']){
				$chtml .= '<option value="'.$row['roomtype_ID'].'" selected="selected">'.$row['type_name'].'</option>';
			}else{
				$chtml .= '<option value="'.$row['roomtype_ID'].'">'.$row['type_name'].'</option>';	
			}
		}
		$chtml .= '</select>';
		return $chtml;
	}
	
	public function generateCapacitycombo($cid=0){
		$result = mysql_query($this->getCapacitysql());	
		$chtml = '<select name="capacity_id" id="capacity_id"><option value="0">'.ADD_EDIT_CAPACITY_SELECT.'</option>'; 
		while($row = mysql_fetch_assoc($result)){
			if($cid == $row['id']){
			    $chtml .= '<option value="'.$row['id'].'" selected="selected">'.$row['title'].'</option>';
			}else{
				$chtml .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
			}
		}
		$chtml .= '</select>';
		return $chtml;
	}
	
	public function add_edit_room(){
		global $bsiCore;
		$no_of_room   = $bsiCore->ClearInput($_POST['no_of_room']);
		$pre_room_cnt = $bsiCore->ClearInput($_POST['pre_room_cnt']);
		$roomtypeId   = $bsiCore->ClearInput($_POST['roomtype_id']);
		$capacityId   = $bsiCore->ClearInput($_POST['capacity_id']);
		
		if($pre_room_cnt != "" || $pre_room_cnt != NULL){
			if($no_of_room > $pre_room_cnt){
				$limit = $no_of_room - $pre_room_cnt;
				for($i=1; $i<=$limit; $i++){
					mysql_query("insert into bsi_room (`roomtype_id`, `room_no`, `capacity_id`) values (".$roomtypeId.", '1', ".$capacityId.")");
					$room_id = mysql_insert_id();
					mysql_query("update bsi_room set room_no='".$room_id."' where room_ID=".$room_id);				
				}
			}
			
			if($no_of_room < $pre_room_cnt){
				$limit = $pre_room_cnt - $no_of_room;
				mysql_query("delete from bsi_room where roomtype_id=".$roomtypeId." and capacity_id=".$capacityId." limit ".$limit);
			}	
		}else{
			$result  = mysql_query("select * from bsi_room where roomtype_id=".$roomtypeId." and capacity_id=".$capacityId);
			if(!mysql_num_rows($result)){		
				for($i=1; $i<=$no_of_room; $i++){
					mysql_query("insert into bsi_room (`roomtype_id`, `room_no`, `capacity_id`) values (".$roomtypeId.", '1', ".$capacityId.")");
					$room_id = mysql_insert_id();
					mysql_query("update bsi_room set room_no='".$room_id."' where room_ID=".$room_id);				
				}
			}else{
				$_SESSION['msg_exists'] = 'Same Combination of Roomtype and capacity Already Exists.';
			}
		}
	}
	
	public function delete_room(){
		global $bsiCore;
		mysql_query("delete from bsi_room where roomtype_id=".$bsiCore->ClearInput($_GET['rid'])." and capacity_id=".$bsiCore->ClearInput($_GET['cid']));
	}
	
	public function getBlockRoomDetails(){
		global $bsiCore;
		$getHtml='<tbody>';
		$result=mysql_query("SELECT br.bookings_id, bb.block_name, DATE_FORMAT(bb.start_date, '".$bsiCore->userDateFormat."') AS StartDate, DATE_FORMAT(bb.end_date, '".$bsiCore->userDateFormat."') AS EndDate, br.room_type_id, brt.type_name, br.room_id, brm.capacity_id, count(*) as NoOfRoom from bsi_reservation br, bsi_bookings bb, bsi_roomtype brt, bsi_room brm where br.bookings_id=bb.booking_id and bb.is_block=1 and br.room_type_id=brt.roomtype_id and br.room_id=brm.room_ID group by br.room_type_id, brm.capacity_id");
		if(mysql_num_rows($result)){
			while($row=mysql_fetch_assoc($result)){
				$row_capacity_title=mysql_fetch_assoc(mysql_query("SELECT bc.title from bsi_capacity bc, bsi_room br where br.capacity_id=bc.id and br.room_id='".$row['room_id']."'"));
				$getHtml.='<tr><td>'.$row['block_name'].'</td><td>'.$row['StartDate']."-".$row['EndDate'].'</td><td>'.$row['type_name']."(".$row_capacity_title['title'].')</td><td>'.$row['NoOfRoom'].'</td><td align="right"><a href="'.$_SERVER['PHP_SELF'].'?action=unblock&bid='.$row['bookings_id'].'&rti='.$row['room_type_id'].'&cid='.$row['capacity_id'].'">'.UN_BLOCK.'</a></td></tr>';
			}
		}
		$getHtml .= '<tbody>';
		return $getHtml;
	}
	
	public function getDatepicker($id=0, $roomtypename='', $startdate='', $enddate='', $row=array()){
		$htmlArray = array();
		global $bsiCore;
		if($id){
			$html = '<tr>
			  <td width="80px"><strong>&nbsp;'.ADD_EDIT_PRICEPLAN_ROOMTYPE.':</strong></td>
			  <td width="800px" align="left">&nbsp;'.$roomtypename.'</td>
			</tr>';
			if($startdate != '0000-00-00' || $enddate != '0000-00-00'){
				$html .= '<tr id="daybyplan1">
						  	<td><strong>&nbsp;'.ADD_EDIT_START_DATE.':</strong></td>
						  	<td valign="middle">&nbsp;'.$startdate.'</td>
						  </tr>
						  <tr id="daybyplan2">
						    <td><strong>&nbsp;'.ADD_EDIT_PRICEPLAN_END_DATE.':</strong></td>
						    <td>&nbsp;'.$enddate.'</td>
						  </tr>';
			}
			$editPriceplanHTML = '<table cellpadding="3" cellspacing="0" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;" width="700px;">
				<tr>
					<td width="85px"><strong>Capacity</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>Sun</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>Mon</strong></td>
					<td width="75px" style="padding-left:10px;"><strong>Tue</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>Wed</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>Thu</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>Fri</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>Sat</strong></td>
				</tr>
				<tr><td colspan="8"><hr/></td></tr><tr>
<td>'.$row['title'].' ('.$row['capacity'].') &nbsp;</td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" name="sun" id="sun" class="required number" value="'.$row['sun'].'" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" name="mon" id="mon" class="required number" value="'.$row['mon'].'" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" name="tue" id="tue" class="required number" value="'.$row['tue'].'" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" name="wed" id="wed" class="required number" value="'.$row['wed'].'" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" name="thu" id="thu" class="required number" value="'.$row['thu'].'" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" name="fri" id="fri" class="required number" value="'.$row['fri'].'" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" name="sat" id="sat" class="required number" value="'.$row['sat'].'" size="4" /></td>
				</tr></table><br>
				<table width="100%">
					<tr><td width="82px"></td><td style="padding-left:10px;"><input type="submit" value="Submit" style="background: #EFEFEF;"/></td></tr>
					<tr><td width="82px"></td><td style="padding-left:10px;">&nbsp;</td></tr>
					<tr><td colspan="2"><font color="#FF0000"><b>*</b></font>  &nbsp;&nbsp;&nbsp;Means required</td></tr>
					<tr><td colspan="2"><font color="#FF0000"><b>**</b></font> &nbsp;Means Only Number</td></tr>
				</table>';
				
				$htmlArray['html']              = $html;
				$htmlArray['editPriceplanHTML'] = $editPriceplanHTML;
		}else{
			$html = '<tr>
			  <td width="95px"><strong>Roomtype:</strong></td>
			  <td>&nbsp;'.$this->generateRoomtypecombo().'</td>
			</tr>
			<tr id="daybyplan1">
			  <td><strong>Start date:</strong></td>             
			  <td valign="middle"><table><tr><td><input type="text" id="txtFromDate" name="startdate" readonly="readonly" size="10"/></td><td style="padding-left:5px;"><a id="datepickerImage" href="javascript:;"><img src="../images/month.png" height="18px" width="18px" /></a></td></tr></table></td>
			</tr>
			<tr id="daybyplan2">
			  <td><strong>End date:</strong></td>
			  <td><table><tr><td><input type="text" id="txtToDate" name="closingdate" value="" readonly="readonly"  size="10"></td><td style="padding-left:5px;"><a id="datepickerImage1" href="javascript:;"><img src="../images/month.png" height="18px" width="18px" /></a></td></tr></table></td>
			</tr>';
			
			$htmlArray['html']              = $html;
			$htmlArray['editPriceplanHTML'] = '';
		}
		return $htmlArray;
	}
	
	public function priceplan_add_edit(){
		global $bsiCore;
		$roomtype       = $bsiCore->ClearInput($_POST['roomtype_id']);
		$start_date_old = $_POST['start_date_old'];
		$startdate      = $bsiCore->getMySqlDate(mysql_real_escape_string($_POST['startdate']));
		$closingdate    = $bsiCore->getMySqlDate(mysql_real_escape_string($_POST['closingdate']));
		if($startdate == "" && $closingdate == ""){
			$startdate     = '0000-00-00';
			$closingdate   = '0000-00-00';
			$default_plan  = 1;
			$_SESSION['error_msg'] = "<font color=\"red\"><b>Error: Regular Price Plan Already Exists! You can only edit Regular Price Plan</b></font><br><br>";
			header("location:priceplan.php");
		}else{
			$startdate     = $startdate;
			$closingdate   = $closingdate;
			$default_plan  = 0;
		}
		$exist = mysql_num_rows(mysql_query("select * from bsi_priceplan where roomtype_id=$roomtype and (('$startdate'  Between
		start_date and  end_date OR  '$closingdate' between  start_date and  end_date ) OR (start_date between '$startdate' and 
		'$closingdate' OR end_date between '$startdate' and '$closingdate'))  group by roomtype_id"));
					
		if(!$exist){
			 $priceplanArray = $_POST['priceplan'];
			 $priceplanKey = array_keys($priceplanArray);
			 for($i=0;$i<count($priceplanKey);$i++){
				 $priceplanValue = array_values($priceplanArray[$priceplanKey[$i]]);
				 $result = mysql_query("select * from bsi_priceplan where roomtype_id='".$roomtype."' and capacity_id='".$priceplanKey[$i]."'");
				 mysql_query("INSERT INTO `bsi_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`) VALUES ('".$roomtype."', '".$priceplanKey[$i]."', '".$startdate."', '".$closingdate."', '".$priceplanValue[0]."', '".$priceplanValue[1]."', '".$priceplanValue[2]."', '".$priceplanValue[3]."', '".$priceplanValue[4]."', '".$priceplanValue[5]."', '".$priceplanValue[6]."', '".$default_plan."');");
				 $_SESSION['roomtype_id'] = $roomtype;
			 }
		header("location:priceplan.php");
		}else{
			$_SESSION['error_msg'] = "<font color=\"red\"><b>Error: Regular Price Plan Already Exists! You can only edit Regular Price Plan</b></font><br><br>";
			header("location:priceplan.php");
		}		 
	}
	
	public function priceplan_edit($plan_id){
		$row = mysql_fetch_assoc(mysql_query("select roomtype_id from bsi_priceplan where plan_id=".$plan_id));
		$_SESSION['roomtype_id'] = $row['roomtype_id'];
		mysql_query("UPDATE `bsi_priceplan` SET 
					`sun` = '".$_POST['sun']."',
					`mon` = '".$_POST['mon']."',
					`tue` = '".$_POST['tue']."',
					`wed` = '".$_POST['wed']."',
					`thu` = '".$_POST['thu']."',
					`fri` = '".$_POST['fri']."',
					`sat` = '".$_POST['sat']."'
					 WHERE `plan_id` ='".$plan_id."'");
					 
		header("location:priceplan.php");
	}
	
	public function getCreditCardDetails($bid){
		$result = mysql_query("select * from bsi_cc_info where booking_id='".$bid."'");
		if(mysql_num_rows($result)){
			$row = mysql_fetch_assoc($result);
			return $row;
		}
	}
	
	public function changePassword(){
		global $bsiCore;
		$oldpass = $_POST['old_pass'];
		$newpass = $_POST['new_pass'];  
		$adminid = $_SESSION['cpuidBSI'];
		$result  = mysql_query("select * from bsi_admin where pass=\"" . md5($oldpass) . "\" and id=".$adminid);
		if(@mysql_num_rows($result)){
			mysql_query("update bsi_admin set pass='".md5($newpass)."' where id=".$adminid);
			$_SESSION['chngmsg'] = 'Password changed successfuly';
		}else{
			$_SESSION['chngmsg'] = 'Password do not matched.';
		}	
	}
	private function make_thumbnails($updir, $img){    
		$thumbnail_width	= 146;
		$thumbnail_height	= 116;
		$thumb_preword		= "thumb_";
		$arr_image_details	= GetImageSize("$updir"."$img");
		$original_width		= $arr_image_details[0];
		$original_height	= $arr_image_details[1];
		if( $original_width > $original_height ){
			$new_width	= $thumbnail_width;
			$new_height	= intval($original_height*$new_width/$original_width);
		} else {
			$new_height	= $thumbnail_height;
			$new_width	= intval($original_width*$new_height/$original_height);
		}
		$dest_x = intval(($thumbnail_width - $new_width) / 2);
		$dest_y = intval(($thumbnail_height - $new_height) / 2);
		
		if($arr_image_details[2]==1) { $imgt = "ImageGIF"; $imgcreatefrom = "ImageCreateFromGIF";  }
		if($arr_image_details[2]==2) { $imgt = "ImageJPEG"; $imgcreatefrom = "ImageCreateFromJPEG";  }
		if($arr_image_details[2]==3) { $imgt = "ImagePNG"; $imgcreatefrom = "ImageCreateFromPNG";  }
				
		if( $imgt ) { 
			$old_image	= $imgcreatefrom("$updir"."$img");
			$new_image	= imagecreatetruecolor($thumbnail_width, $thumbnail_height);
			imageCopyResized($new_image,$old_image,0, 0,0,0,146,116,$original_width,$original_height);
			$imgt($new_image,"$updir"."$thumb_preword"."$img");
		}	
	}
	
	public function homewidget($type){
			global $bsiCore;
			if($type==1){
				$sql = "SELECT booking_id, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id  FROM bsi_bookings where payment_success=true and is_block=false  order by booking_id desc limit 10";
				//echo $sql;
			}else if($type==2){
				$sql = "SELECT booking_id, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id  FROM bsi_bookings where payment_success=true and is_block=false and DATE_FORMAT(start_date, '%Y-%m-%d')=CURDATE()";
			}else if($type==3){
				$sql = "SELECT booking_id, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, payment_type, client_id  FROM bsi_bookings where payment_success=true and is_block=false  and DATE_FORMAT(end_date, '%Y-%m-%d')=CURDATE()";
			}
			
			$html = '<thead>
						  <tr>
							<th width="10%" nowrap>'.VIEW_ACTIVE_BOOKING_ID.'</th>
							<th width="15%" nowrap>'.VIEW_ACTIVE_NAME.'</th>
							<th width="15%" nowrap>'.VIEW_ACTIVE_CHECK_IN.'</th>
							<th width="15%" nowrap>'.VIEW_ACTIVE_CHECK_OUT.'</th>
							<th width="10%" nowrap>'.VIEW_ACTIVE_AMOUNT.'</th>
							<th width="15%" nowrap>'.VIEW_ACTIVE_BOOKING_DATE.'</th>
							<th width="15%" nowrap>&nbsp;</th>
						   </tr>
					  </thead>
					  <tbody>';
			$result = mysql_query($sql);
			while($row = mysql_fetch_assoc($result)){
				$clientArr = $this->getClientInfo($row['client_id']);
				$html .= '<tr>
							<td width="10%" nowrap>'.$row['booking_id'].'</td>
							<td width="15%" nowrap>'.$clientArr['title']." ".$clientArr['first_name']." ".$clientArr['surname'].'</td>
							<td width="15%" nowrap>'.$row['start_date'].'</td>
							<td width="15%" nowrap>'.$row['end_date'].'</td>
							<td width="10%" nowrap>'.$bsiCore->config['conf_currency_symbol'].$row['total_cost'].'</td>
							<td width="15%" nowrap>'.$row['booking_time'].'</td>
							<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap" width="15%">
								<a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'&book_type=1">'.VIEW_ACTIVE_DETAILS.'</a>  
								
							</td>
						  </tr>';
				}
		
		 return $html;	
		}
}
?>