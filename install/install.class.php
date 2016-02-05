<?php
class bsiInstallStart
{	
	private $bsiCoreRoot  = '';
	private $bsiHostPath  = '';
	private $bsiDBCONFile = '/includes/db.conn.php';
	private $bsiGallery   = 'gallery/';
	
	public $installinfo = array('php_version'=>false, 'gd_version'=>false, 'config_file'=>false);
	public $installerror = array('session_disabled'=>false, 'config_notwritable'=>false, 'gallery_notwritable'=>false, 'gd_notinstalled'=>false, 'gd_versionnotpermit'=>false, 'mysql_notavailable'=>false);
	
	function bsiInstallStart(){
		$this->getPathInfo();
		$this->getInstallInfo(); 
	}

	private function getPathInfo(){
		$path_info = pathinfo($_SERVER["SCRIPT_FILENAME"]);
		preg_match("/(.*[\/\\\])/",$path_info['dirname'],$tmpvar);
		$this->bsiCoreRoot = $tmpvar[1];		
		$host_info = pathinfo($_SERVER["PHP_SELF"]);
		$this->bsiHostPath = "http://".$_SERVER['HTTP_HOST'].$host_info['dirname']."/";		
	}
	public function getInstallInfo(){
		$this->installinfo['php_version'] = phpversion();
		
		if (!session_id()) $this->installerror['session_disabled'] = true;
		
		$this->installinfo['config_file'] = $this->bsiCoreRoot.$this->bsiDBCONFile;
		
		// check writable settings file
		if (!is_writable($this->installinfo['config_file'])) $this->installerror['config_notwritable'] = true; 
		
		$this->installinfo['gallery_path'] = $this->bsiCoreRoot.$this->bsiGallery;
		if (!$this->checkFolder($this->installinfo['gallery_path'])) $this->installerror['gallery_notwritable'] = true;
						
		if (!in_array("gd",get_loaded_extensions())) {
			$this->installerror['gd_notinstalled'] = true;
			$this->installerror['gd_versionnotpermit'] = true;
		}
		
		if (!$this->installerror['gd_notinstalled'] && function_exists('gd_info')){
			$info = gd_info();
			$this->installinfo['gd_version'] = preg_replace("/[^\d\.]/","",$info['GD Version'])*1;	
			if ($this->installinfo['gd_version'] < 2) $this->installerror['gd_versionnotpermit'] = true;
		}
		
		if (!in_array("mysql",get_loaded_extensions())) $this->installerror['mysql_notavailable'] = true;			
	}
	
	private function checkFolder($folderPath){
		if ( !($fileHandler=@fopen($folderPath."sample_bsi_dir_test.php","a+"))) return false;
		if (!@fwrite($fileHandler,"test")) return false;
		if (!@fclose($fileHandler)) return false;
		if (!@unlink($folderPath."sample_bsi_dir_test.php")) return false;
		
		return true;
	}	
} 

class bsiInstallFinish
{	
	public $adminUserName  = '';
	public $adminUserPass  = '';
	public $adminFirstName = '';
	public $adminLastName  = '';
	public $adminemail     = '';
	public $userSitePath   = '';
	public $adminSitePath  = '';
	
	private $encAdminPass = '';
	private $hotelName = '';
	private $hotelEmail = '';
		
	function bsiInstallFinish(){
		$this->getAuthParams();		
		$this->updateConfigData();
		$this->getHostPaths();
	}

	private function getAuthParams(){
		if(trim($_POST["admin_login"])){
			$this->adminUserName = trim($_POST["admin_login"]);
		}else{
			$this->adminUserName = "admin@".$_SERVER['HTTP_HOST'];
		}
		
		if(trim($_POST["admin_firstname"])){
			$this->adminFirstName = trim($_POST["admin_firstname"]);
		}else{
			$this->adminFirstName = "";
		}
		
		if(trim($_POST["admin_lastname"])){
			$this->adminLastName = trim($_POST["admin_lastname"]);
		}else{
			$this->adminLastName = "";
		}
		
		if(trim($_POST["admin_email"])){
			$this->adminemail = trim($_POST["admin_email"]);
		}else{
			$this->adminemail = "admin@".$_SERVER['HTTP_HOST'];
		}		
		
		if(trim($_POST["admin_password"])){
			$this->adminUserPass = trim($_POST["admin_password"]);
		}else{
			$this->adminUserPass = $this->autoGeneratePassword(8,8);
		}
		$this->encAdminPass = md5($this->adminUserPass);		
		
		if(trim($_POST["hotel_name"])){
			$this->hotelName = trim($_POST["hotel_name"]);
		}else{
			$this->hotelName = false;
		}
		
		if(trim($_POST["hotel_email"])){
			$this->hotelEmail = trim($_POST["hotel_email"]);
		}else{
			$this->hotelEmail = false;
		}				
	}
	
	private function autoGeneratePassword($length=10, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%~';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}	
	
	private function updateConfigData(){
		mysql_query("UPDATE bsi_admin SET username = '".$this->adminUserName."', pass = '".$this->encAdminPass."', f_name = '".$this->adminFirstName."', l_name = '".$this->adminLastName."', email = '".$this->adminemail."' WHERE id = 1");
				
		if($this->hotelName){
			mysql_query("UPDATE bsi_configure SET conf_value = '".$this->hotelName."' WHERE conf_key = 'conf_hotel_name'");
		}
		if($this->hotelEmail){
			mysql_query("UPDATE bsi_configure SET conf_value = '".$this->hotelEmail."' WHERE conf_key = 'conf_hotel_email'");
		}
	}
	private function getHostPaths(){
		$host_info = pathinfo($_SERVER["PHP_SELF"]);		
		$bsiHostPath = "http://".$_SERVER['HTTP_HOST'].substr($host_info['dirname'], 0, strrpos($host_info['dirname'], '/'))."/";
		$this->adminSitePath = $bsiHostPath."cp/index.php";
		$this->userSitePath = $bsiHostPath."index.php";	
	}
}

class bsiInstallScript
{	
	private $bsiCoreRoot = '';
	private $bsiDBCONFile = '/includes/db.conn.php';
	public  $installerror = array('save_conn'=>false, 'mysql_conn'=>false, 'create_db'=>false, 'create_table'=>false);
	
	function bsiInstallScript(){
		$this->setConfigPath();
		$this->doInstallScript();
	}

	private function setConfigPath(){
		$path_info = pathinfo($_SERVER["SCRIPT_FILENAME"]);
		preg_match("/(.*[\/\\\])/",$path_info['dirname'],$tmpvar);
		$this->bsiCoreRoot = $tmpvar[1];			
	}
	
	private function cleanString($string){	
		$string = preg_replace("/[\'\/\\\]/","",stripslashes($string));
		return $string;
	}
	
	public function writeFile($filestring){		
		$this->bsiDBCONFile = $this->bsiCoreRoot.$this->bsiDBCONFile;		
		$fhandle = fopen($this->bsiDBCONFile,"w");
		if (!$fhandle) {
			return false;
		}	
		if (fwrite($fhandle, $filestring) === FALSE) {
			return false;
		}
		fclose ($fhandle);
		return true;
	}		
		
	public function doInstallScript(){		
		$mysql_host = $this->cleanString($_POST['mysql_host']);
		$mysql_host = !$mysql_host?"localhost":$mysql_host;	
		
		$mysql_user = $this->cleanString($_POST['mysql_login']);
		$mysql_pass = $this->cleanString($_POST['mysql_password']);
		$mysql_db   = $this->cleanString($_POST['mysql_db']);
				
		$filestring = "<?php\ndefine(\"MYSQL_SERVER\", \"".$mysql_host."\");\ndefine(\"MYSQL_USER\", \"".$mysql_user."\");\ndefine(\"MYSQL_PASSWORD\", \"".$mysql_pass."\");\ndefine(\"MYSQL_DATABASE\", \"".$mysql_db."\");\n\nmysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASSWORD) or die ('I cannot connect to the database because 1: ' . mysql_error());\nmysql_select_db(MYSQL_DATABASE) or die ('I cannot connect to the database because 2: ' . mysql_error());\n?>";		
						
		if(!$this->writeFile($filestring)){  // save settings
			$this->installerror['save_conn'] = true;
		}

		$mysql_link = @mysql_connect ($mysql_host,$mysql_user,$mysql_pass);	
	
		
		if ($mysql_link){		
			if(!mysql_select_db($mysql_db,$mysql_link)){
				// attempt to create db when doesn't exists
				if(!mysql_query ("create database ".$mysql_db, $mysql_link)) {
					$this->installerror['create_db'] = true; 
				}else{
					mysql_select_db ($mysql_db, $mysql_link);
				}
			}
		}else{			
			$this->installerror['mysql_conn'] = true;
			$this->installerror['create_db'] = true; 
		}
		

		// no errors if mysql connection successful and db is exists or was created		
		if (!$this->installerror['mysql_conn'] && !$this->installerror['create_db']){

			//install dbscripts
			$this->installDBScripts();
			
			// check if all tables was created correctly
             $allowed_tables = array(1=>"bsi_admin", "bsi_adminmenu", "bsi_advance_payment", "bsi_bookings", "bsi_capacity", "bsi_cc_info", "bsi_clients", "bsi_configure", "bsi_email_contents", "bsi_invoice", "bsi_payment_gateway", "bsi_priceplan", "bsi_reservation", "bsi_room", "bsi_roomtype", "bsi_language" );
			 
             $res = mysql_query("show tables");			
             while ($row =@mysql_fetch_row($res)){				 
                  $table = preg_replace("/(.*)/","$1",$row[0]); 
                  if ($key = array_search($table,$allowed_tables)) {
                      unset ($allowed_tables[$key]);
                  }
             }

             if (count($allowed_tables)>0) $this->installerror['create_table'] = true;  // not all tables was created			
		}else{
			$this->installerror['create_table'] = true;
		}		
	}	
	
	private function installDBScripts(){
		mysql_query("DROP TABLE IF EXISTS `bsi_admin`");
		mysql_query("CREATE TABLE `bsi_admin` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `pass` varchar(255) CHARACTER SET latin1 NOT NULL,
					  `username` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'admin',
					  `access_id` int(1) NOT NULL DEFAULT '0',
					  `f_name` varchar(255) CHARACTER SET latin1 NOT NULL,
					  `l_name` varchar(255) CHARACTER SET latin1 NOT NULL,
					  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
					  `designation` varchar(255) CHARACTER SET latin1 NOT NULL,
					  `last_login` timestamp NULL DEFAULT NULL,
					  `status` tinyint(1) NOT NULL DEFAULT '1',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;");
					
		mysql_query("INSERT INTO `bsi_admin` (`pass`, `username`, `access_id`, `f_name`, `l_name`, `email`, `designation`, `status`) VALUES 
					('aaa', 'admin', '1', 'aa', 'aa', 'aa', 'Administrator', '1');");	
									
		mysql_query("DROP TABLE IF EXISTS `bsi_adminmenu`");
		mysql_query("CREATE TABLE `bsi_adminmenu` (
					  `id` int(4) NOT NULL AUTO_INCREMENT,
					  `name` varchar(200) CHARACTER SET latin1 NOT NULL,
					  `url` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
					  `parent_id` int(4) DEFAULT '0',
					  `status` enum('Y','N') CHARACTER SET latin1 DEFAULT 'Y',
					  `ord` int(5) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;");
		mysql_query("INSERT INTO `bsi_adminmenu` (`id`, `name`, `url`, `parent_id`, `status`, `ord`) VALUES
						(6, 'SETTING', '#', 0, 'Y', 9),
						(31, 'Global Setting', 'global_setting.php', 6, 'Y', 1),
						(33, 'HOTEL MANAGER', '#', 0, 'Y', 2),
						(34, 'Room Manager', 'room_list.php', 33, 'Y', 1),
						(35, 'RoomType Manager', 'roomtype.php', 33, 'Y', 2),
						(36, 'PricePlan Manager', 'priceplan.php', 63, 'Y', 4),
						(37, 'BOOKING MANAGER', '#', 0, 'Y', 4),
						(39, 'View Booking List', 'view_bookings.php', 37, 'Y', 2),
						(43, 'Payment Gateway', 'payment_gateway.php', 6, 'Y', 4),
						(44, 'Email Contents', 'email_content.php', 6, 'Y', 5),
						(59, 'Capacity Manager', 'admin_capacity.php', 33, 'Y', 3),
						(61, 'Advance Payment', 'advance_payment.php', 63, 'Y', 6),
						(63, 'PRICE MANAGER', '#', 0, 'Y', 3),
						(66, 'Hotel Details', 'admin_hotel_details.php', 33, 'Y', 0),
						(68, 'Room Blocking', 'admin_block_room.php', 37, 'Y', 6),
						(70, 'Calendar View', 'calendar_view.php', 37, 'Y', 5),
						(71, 'Customer Lookup', 'customerlookup.php', 37, 'Y', 4),
						(72, 'Admin Menu Manager', 'adminmenu.list.php', 6, 'Y', 6),
						(73, 'LANGUAGE MANAGER', '#', 0, 'Y', 6),
						(74, 'Manage Languages', 'manage_langauge.php', 73, 'Y', 1);");
		
		mysql_query("DROP TABLE IF EXISTS `bsi_advance_payment`");
		mysql_query("CREATE TABLE `bsi_advance_payment` (
						  `month_num` int(11) NOT NULL AUTO_INCREMENT,
						  `month` varchar(255) CHARACTER SET latin1 NOT NULL,
						  `deposit_percent` decimal(10,2) NOT NULL,
						  PRIMARY KEY (`month_num`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
						
		mysql_query("INSERT INTO `bsi_advance_payment` (`month_num`, `month`, `deposit_percent`) VALUES
					(1, 'January', '0.00'),
					(2, 'February', '0.00'),
					(3, 'March', '0.00'),
					(4, 'April', '0.00'),
					(5, 'May', '0.00'),
					(6, 'June', '0.00'),
					(7, 'July', '0.00'),
					(8, 'August', '0.00'),
					(9, 'September', '0.00'),
					(10, 'October', '0.00'),
					(11, 'November', '0.00'),
					(12, 'December', '0.00');");
		
		mysql_query("DROP TABLE IF EXISTS `bsi_bookings`");
		mysql_query("CREATE TABLE `bsi_bookings` (
					  `booking_id` int(10) unsigned NOT NULL,
					  `booking_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `start_date` date NOT NULL DEFAULT '0000-00-00',
					  `end_date` date NOT NULL DEFAULT '0000-00-00',
					  `client_id` int(10) unsigned DEFAULT NULL,
					  `child_count` int(2) NOT NULL DEFAULT '0',
					  `extra_guest_count` int(2) NOT NULL DEFAULT '0',
					  `discount_coupon` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
					  `total_cost` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
					  `payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
					  `payment_type` varchar(255) CHARACTER SET latin1 NOT NULL,
					  `payment_success` tinyint(1) NOT NULL DEFAULT '0',
					  `payment_txnid` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
					  `paypal_email` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
					  `special_id` int(10) unsigned NOT NULL DEFAULT '0',
					  `special_requests` text CHARACTER SET latin1,
					  `is_block` tinyint(4) NOT NULL DEFAULT '0',
					  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
					  `block_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
					  PRIMARY KEY (`booking_id`),
					  KEY `start_date` (`start_date`),
					  KEY `end_date` (`end_date`),
					  KEY `booking_time` (`discount_coupon`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		
		mysql_query("DROP TABLE IF EXISTS `bsi_capacity`");
		mysql_query("CREATE TABLE `bsi_capacity` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
					  `capacity` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
				
		mysql_query("DROP TABLE IF EXISTS `bsi_cc_info`");
		mysql_query("CREATE TABLE `bsi_cc_info` (
					  `booking_id` varchar(100) CHARACTER SET latin1 NOT NULL,
					  `cardholder_name` varchar(255) CHARACTER SET latin1 NOT NULL,
					  `card_type` varchar(50) CHARACTER SET latin1 NOT NULL,
					  `card_number` blob NOT NULL,
					  `expiry_date` varchar(10) CHARACTER SET latin1 NOT NULL,
					  `ccv2_no` int(4) NOT NULL,
					  PRIMARY KEY (`booking_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");	
										
		mysql_query("DROP TABLE IF EXISTS `bsi_clients`");
		mysql_query("CREATE TABLE `bsi_clients` (
					  `client_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `first_name` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
					  `surname` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
					  `title` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
					  `street_addr` text CHARACTER SET latin1,
					  `city` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
					  `province` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
					  `zip` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
					  `country` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
					  `phone` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
					  `fax` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
					  `email` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
					  `additional_comments` text CHARACTER SET latin1,
					  `ip` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
					  `existing_client` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`client_id`),
					  KEY `email` (`email`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");					
		
		mysql_query("DROP TABLE IF EXISTS `bsi_configure`");
		mysql_query("CREATE TABLE `bsi_configure` (
					  `conf_id` int(11) NOT NULL AUTO_INCREMENT,
					  `conf_key` varchar(100) CHARACTER SET latin1 NOT NULL,
					  `conf_value` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
					  PRIMARY KEY (`conf_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='bsi hotel configurations';");
						
		mysql_query("INSERT INTO `bsi_configure` (`conf_id`, `conf_key`, `conf_value`) VALUES
					(1, 'conf_hotel_name', 'Hotel Boking System'),
					(2, 'conf_hotel_streetaddr', '99 xxxxx Road'),
					(3, 'conf_hotel_city', 'Your City'),
					(4, 'conf_hotel_state', 'Your State'),
					(5, 'conf_hotel_country', 'USA'),
					(6, 'conf_hotel_zipcode', '11211'),
					(7, 'conf_hotel_phone', '+18778888972'),
					(8, 'conf_hotel_fax', '+18778888972'),
					(9, 'conf_hotel_email', 'sales@bestsoftinc.com'),
					(13, 'conf_currency_symbol', '$'),
					(14, 'conf_currency_code', 'USD'),
					(20, 'conf_tax_amount', '12.50'),
					(21, 'conf_dateformat', 'mm/dd/yy'),
					(22, 'conf_booking_exptime', '1000'),
					(25, 'conf_enabled_deposit', '1'),
					(26, 'conf_hotel_timezone', 'Asia/Calcutta'),
					(27, 'conf_booking_turn_off', '0'),
					(28, 'conf_min_night_booking', '2'),
					(30, 'conf_notification_email', 'sales@bestsoftinc.com'),
					(31, 'conf_price_with_tax', '0');
					");			
		
									
		mysql_query("DROP TABLE IF EXISTS `bsi_email_contents`");
		mysql_query("CREATE TABLE `bsi_email_contents` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `email_name` varchar(500) CHARACTER SET latin1 NOT NULL,
					  `email_subject` varchar(500) CHARACTER SET latin1 NOT NULL,
					  `email_text` longtext CHARACTER SET latin1 NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
		mysql_query("INSERT INTO `bsi_email_contents` (`id`, `email_name`, `email_subject`, `email_text`) VALUES
(1, 'Confirmation Email', 'Confirmation of your successfull booking in our hotel', '<p><strong>Text can be chnage in admin panel</strong></p>\r\n'),
(2, 'Cancellation Email ', 'Cancellation Email subject', '<p><strong>Text can be chnage in admin panel</strong></p>\r\n');");
							
		mysql_query("DROP TABLE IF EXISTS `bsi_invoice`");
		mysql_query("CREATE TABLE `bsi_invoice` (
					  `booking_id` int(10) NOT NULL,
					  `client_name` varchar(500) CHARACTER SET latin1 NOT NULL,
					  `client_email` varchar(500) CHARACTER SET latin1 NOT NULL,
					  `invoice` longtext CHARACTER SET latin1 NOT NULL,
					  PRIMARY KEY (`booking_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		mysql_query("DROP TABLE IF EXISTS `bsi_language`;");
		mysql_query("CREATE TABLE `bsi_language` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `lang_title` varchar(255) NOT NULL,
					  `lang_code` varchar(10) NOT NULL,
					  `lang_file` varchar(255) NOT NULL,
					  `lang_default` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
		mysql_query("INSERT INTO `bsi_language` (`id`, `lang_title`, `lang_code`, `lang_file`, `lang_default`) VALUES
						(1, 'English', 'en', 'english.php', 1),
						(2, 'French', 'fr', 'french.php', 0),
						(3, 'German', 'de', 'german.php', 0),
						(4, 'Greek', 'el', 'greek.php', 0),
						(5, 'Spanish', 'es', 'espanol.php', 0),
						(6, 'Italian', 'it', 'italian.php', 0),
						(7, 'Dutch', 'de', 'dutch.php', 0),
						(8, 'Polish', 'pl', 'polish.php', 0),
						(9, 'Portuguese', 'pt', 'portuguese.php', 0),
						(10, 'Russian', 'ru', 'russian.php', 0),
						(11, 'Turkish', 'tr', 'turkish.php', 0),
						(12, 'Thai', 'th', 'thai.php', 0),
						(13, 'Chinese', 'zh-CN', 'chinese.php', 0),
						(14, 'Indonesian', 'id', 'indonesian.php', 0),
						(15, 'Romanian', 'ro', 'romanian.php', 0),
						(17, 'Japanese', 'ja', 'japanese.php', 0);");

		mysql_query("DROP TABLE IF EXISTS `bsi_payment_gateway`");
		mysql_query("CREATE TABLE `bsi_payment_gateway` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `gateway_name` varchar(255) CHARACTER SET latin1 NOT NULL,
					  `gateway_code` varchar(50) CHARACTER SET latin1 NOT NULL,
					  `account` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
					  `enabled` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
		mysql_query("INSERT INTO `bsi_payment_gateway` (`id`, `gateway_name`, `gateway_code`, `account`, `enabled`) VALUES
					(1, 'Paypal', 'pp', 'phpdev_1330251667_biz@aol.com', 1),
					(2, 'Manual', 'poa', NULL, 1),
					(3, 'Credit Card', 'cc', NULL, 1);");		
							
		mysql_query("DROP TABLE IF EXISTS `bsi_priceplan`");
		mysql_query("CREATE TABLE `bsi_priceplan` (
					  `plan_id` int(10) NOT NULL AUTO_INCREMENT,
					  `roomtype_id` int(10) DEFAULT NULL,
					  `capacity_id` int(11) NOT NULL,
					  `start_date` date DEFAULT NULL,
					  `end_date` date DEFAULT NULL,
					  `sun` decimal(10,2) DEFAULT '0.00',
					  `mon` decimal(10,2) DEFAULT '0.00',
					  `tue` decimal(10,2) DEFAULT '0.00',
					  `wed` decimal(10,2) DEFAULT '0.00',
					  `thu` decimal(10,2) DEFAULT '0.00',
					  `fri` decimal(10,2) DEFAULT '0.00',
					  `sat` decimal(10,2) DEFAULT '0.00',
					  `default_plan` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`plan_id`),
					  KEY `priceplan` (`roomtype_id`,`capacity_id`,`start_date`,`end_date`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
								
		mysql_query("DROP TABLE IF EXISTS `bsi_reservation`");
		mysql_query("CREATE TABLE `bsi_reservation` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `bookings_id` int(11) NOT NULL,
					  `room_id` int(11) NOT NULL,
					  `room_type_id` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");


		mysql_query("DROP TABLE IF EXISTS `bsi_room`");
		mysql_query("CREATE TABLE `bsi_room` (
					  `room_ID` int(10) NOT NULL AUTO_INCREMENT,
					  `roomtype_id` int(10) DEFAULT NULL,
					  `room_no` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
					  `capacity_id` int(10) DEFAULT NULL,
					  `no_of_child` int(11) NOT NULL DEFAULT '0',
					  `extra_bed` tinyint(1) DEFAULT '0',
					  PRIMARY KEY (`room_ID`),
					  KEY `roomtype_id` (`roomtype_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
		
		
		mysql_query("DROP TABLE IF EXISTS `bsi_roomtype`");
		mysql_query("CREATE TABLE `bsi_roomtype` (
					  `roomtype_ID` int(10) NOT NULL AUTO_INCREMENT,
					  `type_name` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
					  `description` text CHARACTER SET latin1,
					  `img` varchar(256) CHARACTER SET latin1 DEFAULT NULL,
					  PRIMARY KEY (`roomtype_ID`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");

	}	
}

?>
