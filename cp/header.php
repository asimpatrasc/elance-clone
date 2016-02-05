<?php
include("../includes/db.conn.php");
include("language.php");
$path=pathinfo($_SERVER['PHP_SELF']);
$filename=$path['basename'];
$get_sub_title=mysql_query("select * from bsi_adminmenu where url='".$filename."'");
if(mysql_num_rows($get_sub_title)){
	$get_sub_title_row=mysql_fetch_array($get_sub_title);
	$get_parent_title=mysql_query("select * from bsi_adminmenu where id='".$get_sub_title_row['parent_id']."'");
	$get_parent_title_row=mysql_fetch_array($get_parent_title);
	$main_title=$get_parent_title_row['name'].' > '.$get_sub_title_row['name'];
	$_SESSION['main_title']=$main_title;
}
if($filename=='admin-home.php')
$main_title="Home";
elseif($filename=='change_password.php')
$main_title="Change Password";
else
$main_title=$_SESSION['main_title'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hotel Booking Admin Panel</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/menu.css" rel="stylesheet" />
<!-- Load JQuery -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
</head>
<body>
<div id="top">
 <div id="top-inside">
  <div id="bsi-addmin-text">Hotel Booking Admin Panel</div>
  <div class=" top-link_last"><a href="logout.php"><?=HEADER_LOGOUT?></a></div>
  <div class=" top-link"><a href="change_password.php"><?=HEADER_CHANGE_PASS?></a></div>
  <div class=" top-link"><a href="admin-home.php"><?=HEADER_HOME?></a></div>
 
 </div>
</div>
<div id="con">
<div id="container">
<div id="contain">
<div id="title">
 <h1>
  <?=$main_title?>
 </h1>
</div>
<div id="menu">
 <ul class="menu">
  <?php
  $sql_parent=mysql_query("select * from bsi_adminmenu where parent_id=0 and status='Y' order by ord");
	while($row_parent=mysql_fetch_array($sql_parent))
	{
		if($row_parent['name']=='SETTING')
		echo '<li class="last"><a href="'.$row_parent['url'].'"><span>'.$row_parent['name'].'</span></a>';
		else
		echo '<li><a href="'.$row_parent['url'].'"><span>'.$row_parent['name'].'</span></a>';
		
		$sql_parent222=mysql_query("select * from bsi_adminmenu where parent_id=".$row_parent[0]." and status='Y' order by ord");
		if(mysql_num_rows($sql_parent222))
		{
			echo '<ul>';
			while($row_parent222=mysql_fetch_array($sql_parent222))
			{
				echo '<li><a href="'.$row_parent222['url'].'"><span>'.$row_parent222['name'].'</span></a></li>';
			}
			echo '</ul>';
		}else{
			echo '</li>';
		}
	}
  ?>
 </ul>
</div>
