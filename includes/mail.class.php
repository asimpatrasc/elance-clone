<?php
/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/
class bsiMail 
{
	private $isSMTP 		= false;
	private $emailFrom 		= '';
	private $emailReplyTo 	= '';
    private $smtpHost 		= NULL;	
	private $smtpPort 		= NULL;
	private $smtpUserName 	= NULL;			
	private $smtpPassword 	= NULL;
	private $emailTo 		= '';
	private $emailSubject 	= '';
	private $emailBody 		= '';	
	
	
	function bsiMail() {
		/**
		 * Global Ref: conf.class.php
		 **/
		global $bsiCore;		
					
		$this->isSMTP = false;	
			
		if($this->isSMTP == true){	
			require_once "Mail.php"; // PEAR Mail package
			require_once ('Mail/mime.php'); // PEAR Mail_Mime package		
			$this->emailFrom = $bsiCore->config['conf_hotel_name']."<bsimarketingdept@gmail.com>";		
		}else{
			$this->emailFrom = $bsiCore->config['conf_hotel_name']."<".$bsiCore->config['conf_hotel_email'].">";
		}
		
		$this->emailReplyTo 	= $bsiCore->config['conf_hotel_email'];
		$this->smtpHost 		= "ssl://smtp.gmail.com";
		$this->smtpPort 		= intval(465);
		$this->smtpUserName 	= "bsimarketingdept@gmail.com";
		$this->smtpPassword 	= "hhh";
		//$this->loadEmailContent();	
		if(!$this->smtpPort){
			$this->smtpPort = NULL;
		}			
	}
	
	public function sendEMail($emailTo, $emailSubject, $emailBody){
		$this->emailTo = $emailTo;
		$this->emailSubject = $emailSubject;
		$this->emailBody = $emailBody;
		return (($this->isSMTP == true)? $this->sendSMTPMail() : $this->sendPHPMail());		
	}
	
	/* Send Email using PHP Mail Function */	
	public function sendPHPMail(){
		// To send HTML mail, the Content-type header must be set
		$emailHeaders  = 'MIME-Version: 1.0' . "\r\n";
		$emailHeaders .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				
		// Additional headers
		$emailHeaders .= 'reply-to: '.$this->emailReplyTo.'' . "\r\n";
		$emailHeaders .= 'From: '.$this->emailFrom.'' . "\r\n";	
		
		$retmsg = mail($this->emailTo, $this->emailSubject, $this->emailBody, $emailHeaders);		
		// Mail it
		if ($retmsg) {
			return true;
		}else {
			return "Failed to sent Message!";
		}
	}
			
	/* Send Email using SMTP authentication */	
	public function sendSMTPMail(){
		$emailHeaders = array (
			'From' => $this->emailFrom, 
			'To' => $this->emailTo, 			
			'reply-to' => $this->emailReplyTo, 
			'Subject' => $this->emailSubject,
			'Mime-Version' => "1.0",
			'Content-Type' => "text/html",
			'charset' => "utf-8",
			'Content-Transfer-Encoding' => "7bit");
		$smtpAuthData = array (
			'host' => $this->smtpHost, 
			'port' => $this->smtpPort,
			'auth' => true, 
			'username' => $this->smtpUserName, 
			'password' => $this->smtpPassword);
			
		$smtpMail = Mail::factory('smtp', $smtpAuthData);			
		$smtpMsg = $smtpMail->send($this->emailTo, $emailHeaders, $this->emailBody);
		
		if (PEAR::isError($smtpMail)) {
			return $smtpMail->getMessage();
		}else {
			return true;
		}	
	} 
		
	public function loadEmailContent() {		
		$sql = mysql_query("SELECT * FROM bsi_email_contents WHERE email_name = 'Confirmation Email'");
		$currentrow = mysql_fetch_assoc($sql);	
		$emailContent =  array('subject'=> $currentrow["email_subject"], 'body'=> $currentrow["email_text"]);			
		return $emailContent; 		
	}
}
?>