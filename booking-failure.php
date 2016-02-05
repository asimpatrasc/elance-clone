<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("language.php");
if(isset($_REQUEST["error_code"]))
$errorCode = $bsiCore->ClearInput($_REQUEST["error_code"]);
else
$errorCode=9;
$erroMessage = array(); 
$erroMsg[9] = BOOKING_FAILURE_ERROR_9;
$erroMsg[13] = BOOKING_FAILURE_ERROR_13;
$erroMsg[22] = BOOKING_FAILURE_ERROR_22;
$erroMsg[25] = BOOKING_FAILURE_ERROR_25;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$bsiCore->config['conf_hotel_name']?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
</head>
<body>
<div id="content" align="center">
  <h1><?=$bsiCore->config['conf_hotel_name']?></h1>
   <div id="wrapper" style="width:400px !important; height:200px;">
   <h2 align="left" style="padding-left:5px;"><?=BOOKING_FAILURE_TEXT?></h2>
    <hr color="#e1dada"  style="margin-top:3px;"/><br /><br />
    <span style="color: #D00;"><?=$erroMsg[$errorCode]?></span>
  </div>
</div>
</body>
</html>