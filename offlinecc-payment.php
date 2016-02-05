<?php
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if(!$pos2){
	header('Location: booking-failure.php?error_code=9');
}
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("language.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$bsiCore->config['conf_hotel_name']?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link rel="stylesheet" type="text/css" href="css/datepicker.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script id="demo" type="text/javascript">
$(document).ready(function() {
	$("#form1").validate();
});
</script>
</head>
<body>
<div id="content" align="center">
  <h1><?=$bsiCore->config['conf_hotel_name']?></h1>
  <div id="wrapper" style="width:600px;">
       <h2 align="left" style="padding-left:5px;"><?=CC_DETAILS?></h2>
    <hr color="#e1dada"  style="margin-top:3px;"/>
      <form  name="signupform" id="form1"  action="cc_process.php" method="post" onSubmit="return testCreditCard();">
        <input type="hidden" name="bookingid" value="<?php echo $_POST['x_invoice_num'];?>" />
        <table cellpadding="6" cellspacing="6" width="100%"  style=" text-align:left;" >
          <tr>
            <td width="120px"><strong><?=CC_HOLDER?></strong></td>
            <td><input type="text" name="cc_holder_name" id="cc_holder_name" class="required" /></td><td  class="status"></td>
          </tr>
          <tr>
            <td><strong><?=CC_TYPE?></strong></td>
            <td><select name="CardType" id="CardType" class="textbox" style="width:100px;">
                <option value="AmEx">AmEx</option>
                <option value="DinersClub">DinersClub</option>
                <option value="Discover">Discover</option>
                <option value="JCB">JCB</option>
                <option value="Maestro">Maestro</option>
                <option value="MasterCard">MasterCard</option>
                <option value="Solo">Solo</option>
                <option value="Switch">Switch</option>
                <option value="Visa">Visa</option>
                <option value="VisaElectron">VisaElectron</option>
              </select></td><td></td>
          </tr>
          <tr>
            <td nowrap="nowrap"><strong><?=CC_NUMBER?></strong></td>
            <td><input type="text" name="CardNumber" id="CardNumber" maxlength="16" class="required creditcard" /></td><td  class="status"></td>
          </tr>
          <tr>
            <td nowrap="nowrap"><strong><?=CC_EXPIRY?> (mm/yy)</strong></td>
            <td><input type="text" name="cc_exp_dt" id="cc_exp_dt" style="width:50px;" maxlength="5" class="required" />
               </td>
          </tr>
          <tr>
            <td><strong>CCV/CCV2</strong></td>
            <td><input type="text" name="cc_ccv" id="cc_ccv"  style=" width:50px" maxlength="4" class="required number"/></td>
          </tr>
          <tr>
            <td><strong><?=CC_AMOUNT?></strong></td>
            <td><b><?=$bsiCore->config['conf_currency_symbol']?><?=$_POST['total']?></b></td>
          </tr>
          <tr>
            <td></td>
            <td colspan="2"><input type="checkbox" name="tos" id="tos" value="" style="width:15px;"   class="required"/> <?=CC_TOS1?> <?=$bsiCore->config['conf_hotel_name']?>
               <?=CC_TOS2?> <?=$bsiCore->config['conf_currency_symbol']?><?=$_POST['total']?> <?=CC_TOS3?>.</td>
          </tr>
          <tr>
            <td></td>
            <td  align="left"><button  type="submit" style="float:left;"><?=CC_SUBMIT?></button></td><td></td>
          </tr>
        </table>
      </form>
     </div>
</div>
</body>
</html>