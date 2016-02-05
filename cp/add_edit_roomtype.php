<?php 
include("access.php");
if(isset($_POST['submitRoomtype'])){
	include("../includes/db.conn.php"); 
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->add_edit_roomtype();
	header("location:roomtype.php");	
	exit;
}
include("header.php"); 
include("../includes/conf.class.php");
include("../includes/admin.class.php");
if(isset($_GET['id']) && $_GET['id'] != ""){
	$id = $bsiCore->ClearInput($_GET['id']);
	if($id){
		$result = mysql_query($bsiAdminMain->getRoomtypesql($id));
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
      <span style="font-size:16px; font-weight:bold"><?php echo ROOM_TYPE_ADD_AND_EDIT;?></span>
      <hr />
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form1" enctype="multipart/form-data">
          <table cellpadding="5" cellspacing="2" border="0">
            <tr>
              <td><strong><?php echo ROOM_TYPE_TITLE;?>:</strong></td>
              <td valign="middle"><input type="text" name="roomtype_title" id="roomtype_title" class="required" value="<?=$row['type_name']?>" style="width:250px;" /> &nbsp;&nbsp;<?php echo EXAMPLE_DELUXE_AND_STANDARD;?></td>
            </tr>
            <tr>
              <td><strong><?php echo ROOM_TYPE_IMG;?>:</strong></td>
              <td><input type="file" name="img" id="img" /><?php if($row['img'] != ""){ echo '<span style="margin-left:15px"><a href="../gallery/'.$row['img'].'" target="_blank"><strong>View Image</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000"><strong>Delete Image</strong>&nbsp;</font><input type="checkbox" name="delimg"></span>'; }?></td>
            </tr>
            <tr>           
              <td><input type="hidden" name="addedit" value="<?=$id?>"></td>
              <td><input type="submit" value="<?php echo ROOM_TYPE_SUBMIT;?>" name="submitRoomtype" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td>
            </tr>
          </table>
        </form>
      </div>
<script type="text/javascript">
	$().ready(function() { $("#form1").validate(); });       
</script>      
<script src="js/jquery.validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?> 
