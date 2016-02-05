<?php
session_start();
include("../includes/db.conn.php");
include("../includes/conf.class.php");
include("language.php");
include("../includes/admin.ajaxprocess.class.php");	 
$adminAjaxProc = new adminAjaxProcessor();
$actionCode = isset($_POST['actioncode']) ? $_POST['actioncode'] : 0;
switch($actionCode){
	
	case "1": $adminAjaxProc->getbsiEmailcontent();break;
	
	case "2": $adminAjaxProc->generatePriceplanList();break;
	
	case "3": $adminAjaxProc->getdefaultcapacity();break;
	
	case "4": $adminAjaxProc->getDeposit();break;
	
	case "5": $adminAjaxProc->genearateCapacityCombo();break;
	default:  $adminAjaxProc->sendErrorMsg();
	
   }
?>