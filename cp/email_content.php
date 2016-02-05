<?php 
include("access.php");
if(isset($_POST['c_update'])){

		include("../includes/db.conn.php");

		include("../includes/conf.class.php");

		include("../includes/admin.class.php");	

		$bsiAdminMain->updateEmailContent();

		header("location:email_content.php");

	}

include("header.php"); 

include("../includes/conf.class.php");

include("../includes/admin.class.php");	

$emaillist=$bsiAdminMain->getEmailContents();

	

?>

<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />

<script type="text/javascript">

$(document).ready(function(){

	$('#update_con').validate();

	$('#email_id').change(function(){

		if($('#email_id').val()!= 0){

			jQuery("#submit:button").removeAttr("disabled");

			var selectid=$('#email_id').val();

			var querystr='actioncode=1&choiceid='+$('#email_id').val();

			$.post("admin_ajax_processor.php", querystr, function(data){						 

				if(data.errorcode == 0){

					$('#email_sub').val(data.viewcontent);

					$('#c_update').val(data.viewcontent1);

					$('#email_con').val(data.viewcontent2);

				}else{

					$('#email_sub').val('');

					$('#email_con').val('');

				}

			}, "json");

		}else{

			$('#email_sub').val('');

			$('#email_con').val('');

		}

	});

});	

</script>

<div id="container-inside">

<span style="font-size:16px; font-weight:bold"><?php echo EMAIL_CONTENT_SETTING;?></span>

      <hr />

  <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form1">

    <table cellpadding="5" cellspacing="2" border="0">

    <thead>

    <tr>

      <th align="left"><strong><?php echo SELECT_EMAIL_TYPE;?></strong></th><th align="left"><select id="email_id" name="email_id"><?=$emaillist?></select></th>

    </tr>

    </thead>

    <tbody>

      <tr>

        <td><input type="hidden" id="c_update" name="c_update" /></td>

      </tr>

      <tr>

        <td ><strong><?php echo EMAIL_SUBJECT; ?>:</strong></td>

        <td><input  type="text" id="email_sub" name="email_sub" class="required" style="width:700px !important;" /></td>

      </tr>

      <tr>

        <td valign="top"><strong><?php echo EMAIL_CONTENT;?>:</strong></td>

        <td><textarea name="email_con" id="email_con"  style="width:700px; height:250px;" class="required"></textarea></td>

      </tr>

      <tr>

        <td></td>

        <td><input type="submit" value="<?php echo EMAIL_UPDATE;?>" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>

      </tr>

      </tbody>

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

