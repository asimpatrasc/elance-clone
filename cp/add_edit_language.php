<?php 
include("access.php");
if(isset($_POST['submitCapacity'])){
	include("../includes/db.conn.php"); 
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->add_edit_language();
	header("location:manage_langauge.php");	
	exit;
}

include("header.php"); 
include("../includes/conf.class.php");
include("../includes/admin.class.php");
if(isset($_GET['id']) && $_GET['id'] != ""){

	$id = $bsiCore->ClearInput($_GET['id']);
	if($id){
		$result = mysql_query("select * from bsi_language where id=".$id);
		$row    = mysql_fetch_assoc($result);
		$dflt=($row['lang_default'])? 'checked="checked"':'';
	}else{
		$row    = NULL;
		$readonly = '';
		$dflt='';

	}

}else{

	header("location:manage_langauge.php");

	exit;

}

?>
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />

<div id="container-inside"> <span style="font-size:16px; font-weight:bold"><?php echo LANGAUGE_ADD_EDIT; ?></span>
 <hr />
 <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form1">
  <table cellpadding="5" cellspacing="2" border="0">
   <tr>
    <td><strong><?php echo LANGAUGE_TITLE; ?>:</strong></td>
    <td valign="middle"><input type="text" name="lang_title" id="lang_title" class="required" value="<?=$row['lang_title']?>" style="width:150px;" />
     </td>
   </tr>
   <tr>
    <td><strong><?php echo LANGAUGE_CODE; ?>:</strong></td>
    <td><input type="text" name="lang_code" id="lang_code" value="<?=$row['lang_code']?>" class="required " style="width:70px;"  /></td>
   </tr>
   <tr>
    <td><strong><?php echo LANGAUGE_FNAME; ?>:</strong></td>
    <td valign="middle"><input type="text" name="lang_file" id="lang_file" class="required" value="<?=$row['lang_file']?>" style="width:150px;" />
     </td>
   </tr>
    <tr>
    <td><strong><?php echo LANGAUGE_DEFAULT; ?>:</strong></td>
    <td valign="middle"><input type="checkbox" name="lang_default" value="1"  <?=$dflt?>/></td>
   </tr>
   
    <td><input type="hidden" name="addedit" value="<?=$id?>"></td>
    <td><input type="submit" value="<?php echo ADD_EDIT_CAPACITY_SUBMIT;?>" name="submitCapacity" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>
   </tr>
  </table>
 </form><br />
  Note: Please create langauge file by copy of languages/english.php before add language.
</div>
<script type="text/javascript">

	$().ready(function() {

		$("#form1").validate();
     });

         

</script> 
<script src="js/jquery.validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?>
