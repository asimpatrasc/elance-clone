<?php 
include ("access.php");
if(isset($_POST['sbt_details'])){
	include("../includes/db.conn.php");
	include("../includes/admin.class.php");
	include("../includes/conf.class.php");
	$bsiAdminMain->hotel_details_post();
	header("location:admin_hotel_details.php");
}
include("header.php"); 
include("../includes/conf.class.php");
?>
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<div id="container-inside">
<span style="font-size:16px; font-weight:bold"><?php echo HOTEL_DETAILS; ?></span>
<hr />
  <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form1">
    <table cellpadding="5" cellspacing="2" border="0">
      <tr>
        <td valign="middle"><strong><?php echo HOTEL_NAME;?>:</strong></td>
        <td><input type="text" name="hotel_name" class="required" size="50" value="<?=$bsiCore->config['conf_hotel_name']?>"/></td>
      </tr>
      <tr>
        <td valign="middle"><strong><?php echo STREET_ADDRESS;?>:</strong></td>
        <td><input type="text" name="str_addr" class="required" size="40" value="<?=$bsiCore->config['conf_hotel_streetaddr']?>"/></td>
      </tr>
      <tr>
        <td valign="middle"><strong><?php echo CITY;?>:</strong></td>
        <td><input type="text" name="city" size="30" class="required" value="<?=$bsiCore->config['conf_hotel_city']?>"/></td>
      </tr>
      <tr>
        <td valign="middle"><strong><?php echo STATE; ?>:</strong></td>
        <td><input type="text" name="state" class="required" size="30" value="<?=$bsiCore->config['conf_hotel_state']?>"/></td>
      </tr>
      <tr>
        <td valign="middle"><strong><?php echo COUNTRY; ?>:</strong></td>
        <td><input type="text" name="country" class="required" size="30" value="<?=$bsiCore->config['conf_hotel_country']?>"/></td>
      </tr>
      <tr>
        <td valign="middle"><strong><?php echo ZIP_AND_POST_CODE;  ?>:</strong></td>
        <td><input type="text" name="zipcode" class="required" size="10" value="<?=$bsiCore->config['conf_hotel_zipcode']?>"/></td>
      </tr>
      <tr>
        <td valign="middle"><strong><?php echo PHONE_NUMBER; ?>:</strong></td>
        <td><input type="text" name="phone" class="required" size="15" value="<?=$bsiCore->config['conf_hotel_phone']?>"/></td>
      </tr>
      <tr>
        <td valign="middle"><strong><?php echo FAX; ?>:</strong></td>
        <td><input type="text" name="fax" class="" size="15" value="<?=$bsiCore->config['conf_hotel_fax']?>"/></td>
      </tr>
      <tr>
        <td valign="middle"><strong><?php echo EMAIL_ID; ?>:</strong></td>
        <td><input type="text" name="email" class="required email" size="30" value="<?=$bsiCore->config['conf_hotel_email']?>"/></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="<?php echo SUBMIT;?>" name="sbt_details" id="sbt_details"  style="background:#e5f9bb; cursor:pointer; cursor:hand;" /></td>
      </tr>
    </table>
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#form1").validate();
		
     });
         
</script> 
<script src="js/jquery.validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?>
