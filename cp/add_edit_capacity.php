<?php 
include("access.php");
if(isset($_POST['submitCapacity'])){
	include("../includes/db.conn.php"); 
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->add_edit_capacity();
	header("location:admin_capacity.php");	
	exit;
}
include("header.php"); 
include("../includes/conf.class.php");
include("../includes/admin.class.php");
if(isset($_GET['id']) && $_GET['id'] != ""){
	$id = $bsiCore->ClearInput($_GET['id']);
	if($id){
		$result = mysql_query($bsiAdminMain->getCapacitysql($id));
		$row    = mysql_fetch_assoc($result);
		$readonly = 'readonly="readonly"';
	}else{
		$row    = NULL;
		$readonly = '';
	}
}else{
	header("location:admin_capacity.php");
	exit;
}
?>  
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
      <div id="container-inside">
      <span style="font-size:16px; font-weight:bold"><?php echo CAPACITY_ADD_AND_EDIT; ?></span>
      <hr />
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0">
            <tr>
              <td><strong><?php echo CAPACITY_TITLE_ADD_EDIT; ?>:</strong></td>
              <td valign="middle"><input type="text" name="capacity_title" id="capacity_title" class="required" value="<?=$row['title']?>" style="width:250px;" /> &nbsp;&nbsp;<?php echo EXAMPLE_SINGLE_DOUBLE;?></td>
            </tr>
            <tr>
              <td><strong><?php echo ADD_EDIT_CAPACITY_NUMBER_OF_ADULT; ?>:</strong></td>
              <td><input type="text" name="no_adult" id="no_adult" <?=$readonly?> value="<?=$row['capacity']?>" class="required number" style="width:70px;"  /></td>
            </tr>
            
            
              <td><input type="hidden" name="addedit" value="<?=$id?>"></td>
              <td><input type="submit" value="<?php echo ADD_EDIT_CAPACITY_SUBMIT;?>" name="submitCapacity" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>
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
