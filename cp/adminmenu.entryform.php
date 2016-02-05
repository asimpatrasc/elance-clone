<?php 
include("access.php");
include("header.php"); 

$msg="";
if(isset($_POST['Update'])){
   if(!$_POST['id']):
       $r=mysql_query("insert into bsi_adminmenu(name,url,ord, parent_id) values ('". $_POST['name'] ."','".$_POST['url'] ."',". $_POST['ord'].",". $_POST['parent_id'].")");	
	  // echo "insert into bsi_adminmenu(name,url,ord, parent_id) values ('". $_POST['name'] ."','".$_POST['url'] ."',". $_POST['ord'].",". $_POST['parent_id'].")";
	   $id=mysql_insert_id();
   else:
       $r=mysql_query("update bsi_adminmenu set name='".$_POST['name']."',url='".$_POST['url']."',ord=".$_POST['ord']." where id=". $_POST['id']);
	   $id=$_POST['id'];
	  // echo "update bsi_adminmenu set name='".$_POST['name']."',url='".$_POST['url']."',ord=".$_POST['ord']." where id=". $_POST['id'];
	   
   endif;
   if($r):
   	   $msg="<font face=verdana size=1 color=#111111><b>Update Successful.</b></font>";
       echo"<script>window.location.href='adminmenu.list.php?tid=" . $_REQUEST['tid'] . "';</script>";
   else:
       $msg="<font face=verdana size=1 color=red><b>Update Failure.</b></font>";
   endif;		
}
if(isset($_REQUEST['id'])){
   $r=mysql_query("select * from  bsi_adminmenu where id=" . $_REQUEST['id']);
   $d=mysql_fetch_array($r);
   $name=$d["name"];
   $url=$d['url'];
   $ord=$d['ord'];
   $id=$_REQUEST['id'];
}else{
   $name="";
   $url="";
   $ord="";
   $id="";
}
if(isset($_REQUEST['parent_id'])){
   $r=mysql_query("select * from  bsi_adminmenu where id=" . $_REQUEST['parent_id']);
   $dd=mysql_fetch_array($r);
 	$pid=$_REQUEST['parent_id'];
}else{
	$pid=0;
}

if($msg){echo"<div align=center class=lnk>" . $msg . "</div>";}
?>
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<div id="container-inside">
<span style="font-size:16px; font-weight:bold"><?=ADMN_TITLE?>  <?php if(isset($_REQUEST['parent_id'])){echo"(Under : " . $dd['name'] . ")";}?>  : <?=$name?></span>
<hr />
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" id="form1">
<input type="hidden" name="parent_id" value="<?=$pid?>" >
<input type="hidden" name="id" value="<?=$id?>">

<table width="60%" border="0"  cellpadding="3">


<tr><td valign=top><?=ADMN_TITLE1?></td><td><input type="text" size=25 name="name" value="<?=$name?>" class="required" /></td></tr>
<tr><td valign=top><?=ADMN_FNAME?></td><td><input type="text" size=25 name="url" value="<?=$url?>"  class="required" /> [Example. test.php]</td></tr>
<tr><td valign=top nowrap="nowrap"><?=ADMN_ORDER1?></td><td><input type="text" size=5 name="ord" value="<?=$ord?>"  class="required" /> [Example. 2]</td></tr>
<tr><td></td><td ><input type="submit" value="<?php echo ADD_EDIT_CAPACITY_SUBMIT;?>" name="Update" style="background:#e5f9bb; cursor:pointer; cursor:hand;" /></td></tr>

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