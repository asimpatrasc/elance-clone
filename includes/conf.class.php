<?php
/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/
$bsiCore = new bsiHotelCore;
class bsiHotelCore{
	public $config = array();
	public $userDateFormat = "";		
	
	function bsiHotelCore(){		
		$this->getBSIConfig();
		$this->getUserDateFormat();		
	}	
	
	private function getBSIConfig(){
		$sql = mysql_query("SELECT conf_id, IFNULL(conf_key, false) AS conf_key, IFNULL(conf_value,false) AS conf_value FROM bsi_configure");
		while($currentRow = mysql_fetch_assoc($sql)){
			if($currentRow["conf_key"]){
				if($currentRow["conf_value"]){
					$this->config[trim($currentRow["conf_key"])] = trim($currentRow["conf_value"]);
				}else{
					$this->config[trim($currentRow["conf_key"])] = false;
				}
			}
		}
		mysql_free_result($sql);	
	}
	
	private function getUserDateFormat(){		
		$dtformatter = array('dd'=>'%d', 'mm'=>'%m', 'yyyy'=>'%Y', 'yy'=>'%Y');		
		$dtformat = preg_split("@[/.-]@", $this->config['conf_dateformat']);
		$dtseparator = ($dtformat[0] === 'yyyy')? substr($this->config['conf_dateformat'], 4, 1) : substr($this->config['conf_dateformat'], 2, 1);
		$this->userDateFormat = $dtformatter[$dtformat[0]].$dtseparator.$dtformatter[$dtformat[1]].$dtseparator.$dtformatter[$dtformat[2]];	
	}	
	
	public function getMySqlDate($date){
		if($date == "") return "";
		$dateformatter = preg_split("@[/.-]@", $this->config['conf_dateformat']);
		$date_part = preg_split("@[/.-]@", $date);		
		$date_array = array();		
		for($i=0; $i<3; $i++) {
			$date_array[$dateformatter[$i]] = $date_part[$i];
		}
		return $date_array['yy']."-".$date_array['mm']."-".$date_array['dd'];
	}	
	
	public function ClearInput($dirty){
		$dirty = mysql_real_escape_string($dirty);
		return $dirty;
	}	
	
	public function capacitycombo(){
		$chtml = '<select id="capacity" name="capacity" style="width:80px">';
		
		$capacityrow = mysql_fetch_assoc(mysql_query("SELECT Max(capacity) as capa FROM bsi_capacity WHERE `id` IN (SELECT DISTINCT (capacity_id) FROM bsi_room) ORDER BY capacity"));
				for($i=1; $i<=$capacityrow["capa"]; $i++){ 
					$chtml .=  '<option value="'.$i.'">'.$i.'</option>';
				}
		$chtml .= '</select>';	
		return $chtml;
	}
	
	public function clearExpiredBookings(){		
		$sql = mysql_query("SELECT booking_id FROM bsi_bookings WHERE payment_success = false AND ((NOW() - booking_time) > ".intval($this->config['conf_booking_exptime'])." )");
		while($currentRow = mysql_fetch_assoc($sql)){			
			mysql_query("DELETE FROM bsi_invoice WHERE booking_id = '".$currentRow["booking_id"]."'");
			mysql_query("DELETE FROM bsi_reservation WHERE bookings_id = '".$currentRow["booking_id"]."'");	
			mysql_query("DELETE FROM bsi_bookings WHERE booking_id = '".$currentRow["booking_id"]."'");			
		}
		mysql_free_result($sql);
	}
	
	public function loadPaymentGateways() {			
		$paymentGateways = array();
		$sql = mysql_query("SELECT * FROM bsi_payment_gateway where enabled=true");
		while($currentRow = mysql_fetch_assoc($sql)){	
			$paymentGateways[$currentRow["gateway_code"]] = array('name'=>$currentRow["gateway_name"], 'account'=>$currentRow["account"]);	 
		}
		mysql_free_result($sql);
		return $paymentGateways;
	}
	
	public function encryptCard($creditno){
		$key = 'sdj*sadt63423h&%$@c34234c346v4c43czxcx'; //Change the key here
		$td = mcrypt_module_open('tripledes', '', 'cfb', '');
		srand((double) microtime() * 1000000);
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		$okey = substr(md5($key.rand(0, 9)), 0, mcrypt_enc_get_key_size($td));
		mcrypt_generic_init($td, $okey, $iv);
		$encrypted = mcrypt_generic($td, $creditno.chr(194));
		$code = $encrypted.$iv;
		$code = eregi_replace("'", "\'", $code);
		return $code;
	}
	
	public function decryptCard($code){
		$key = 'sdj*sadt63423h&%$@c34234c346v4c43czxcx'; // use the same key used for encrypting the data
		$td = mcrypt_module_open('tripledes', '', 'cfb', '');
		$iv = substr($code, -8);
		$encrypted = substr($code, 0, -8);
		for ($i = 0; $i < 10; $i++) {
			$okey = substr(md5($key.$i), 0, mcrypt_enc_get_key_size($td));
			mcrypt_generic_init($td, $okey, $iv);
			$decrypted = trim(mdecrypt_generic($td, $encrypted));
			mcrypt_generic_deinit($td);
			$txt = substr($decrypted, 0, -1);
			if (ord(substr($decrypted, -1)) == 194 && is_numeric($txt)) break;
		}
		mcrypt_module_close($td);
		return $txt;
	}
	
	public function paymentGateway($code){
		$row = mysql_fetch_assoc(mysql_query("SELECT gateway_name FROM bsi_payment_gateway where gateway_code='".$code."'"));
		return  $row['gateway_name'];
	}
	
	public function getInvoiceinfo($bid){
		$invoiceres=mysql_fetch_assoc(mysql_query("select * from bsi_invoice where booking_id='".$bid."'"));			
		return $invoiceres['invoice'];
	}
	public function paymentGatewayName($gcode){
		$row=mysql_fetch_row(mysql_query("select gateway_name from bsi_payment_gateway where gateway_code='".$gcode."'"));
		return $row[0];
	}
}