<?php 

include ("access.php"); 

if(isset($_POST['act'])){

	include("../includes/db.conn.php");

	include("../includes/admin.class.php");

	$bsiAdminMain->updateCustomerLookup();

	header("location:customerlookup.php"); 

	exit;

}

$update=base64_decode($_GET['update']);

include("header.php");

if(isset($update)){

	include("../includes/conf.class.php");

	include("../includes/admin.class.php");

	$row   = $bsiAdminMain->getCustomerLookup($update);

	$title = $bsiAdminMain->getTitle($row['title']);

}else{

	header("location:customerlookup.php");

}

 ?>

<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />

<div id="container-inside"> <span style="font-size:16px; font-weight:bold">Customer Details Edit</span>

  <hr />

  <form action="" method="post" id="form1">

    <table cellpadding="5" cellspacing="2" border="0">

      <tr>

        <td><strong>Title:</strong></td>

        <td><?=$title?></td>

      </tr>

      <tr>

        <td align="left"><strong>First Name:</strong></td>

        <td><input type="text" class="required" value="<?=$row['first_name']?>" style="width:200px;" name="fname" id="fname"/></td>

      </tr>

      <tr>

        <td align="left"><strong>Last Name:</strong></td>

        <td><input type="text" class="required" value="<?=$row['surname']?>" style="width:200px;" name="sname" id="sname"/></td>

      </tr>

      <tr>

        <td align="left"><strong>Street Address:</strong></td>

        <td><input type="text" class="required" value="<?=$row['street_addr']?>" style="width:250px;" name="sadd" id="sadd"/></td>

      </tr>

      <tr>

        <td align="left"><strong>City:</strong></td>

        <td><input type="text" class="required" value="<?=$row['city']?>"  name="city" id="city"/></td>

      </tr>

      <tr>

        <td align="left"><strong>Province:</strong></td>

        <td><input type="text" class="required" value="<?=$row['province']?>"  name="province" id="province"/></td>

      </tr>

      <tr>

        <td align="left"><strong>Zip / Post code:</strong></td>

        <td><input type="text" class="required" value="<?=$row['zip']?>"  name="zip" id="zip"/></td>

      </tr>

      <tr>

        <td align="left"><strong>Country:</strong></td>

        <td><input type="text" class="required" value="<?=$row['country']?>"  name="country" id="country"/></td>

      </tr>

      <tr>

        <td align="left"><strong>Phone Number:</strong></td>

        <td><input type="text" class="required" value="<?=$row['phone']?>"  name="phone" id="phone"/></td>

      </tr>

      <tr>

        <td align="left"><strong>Fax:</strong></td>

        <td><input type="text" value="<?=$row['fax']?>"  name="fax" id="fax"/></td>

      </tr>

      <tr>

        <td align="left"><strong>Email Id:</strong></td>

        <td><input type="text" value="<?=$row['email']?>"  name="email" id="email" style="width:250px;" readonly="readonly"/>

          <input type="hidden" name="httpreffer" value="<?=$_SERVER['HTTP_REFERER']?>" /></td>

      </tr>

      <input type="hidden" name="cid" value="<?=$row['client_id']?>">

      <input type="hidden" name="act" value="1">

      <tr>

        <td  width="100px"></td>

        <td align="left"><input type="submit" value="Submit"  style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>

      </tr>

    </table>

  </form>

</div>

<script type="text/javascript">

	$().ready(function() {

		$("#form1").validate();

		

     });

         

</script> 

<script src="js/jquery.validate.js" type="text/javascript"></script>

<?php include("footer.php"); ?>

