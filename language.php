<?php
if(isset($_REQUEST['lang'])){
$_SESSION['language']=$_REQUEST['lang'];
}

$row_default_lang=mysql_fetch_assoc(mysql_query("select * from bsi_language where `lang_default`=true"));
if(isset($_SESSION['language']))
$langauge_selcted=mysql_real_escape_string($_SESSION['language']);
else
$langauge_selcted=$row_default_lang['lang_code'];

$row_visitor_lang=mysql_fetch_assoc(mysql_query("select * from bsi_language where  lang_code='$langauge_selcted' "));
include("languages/".$row_visitor_lang['lang_file']);

//******************************************
$sql_lang_select=mysql_query("select * from bsi_language order by lang_title");
$lang_dd='';
while($row_lang_select=mysql_fetch_assoc($sql_lang_select)){
	if($row_lang_select['lang_code']==$langauge_selcted)
	$lang_dd.='<option value="'.$row_lang_select['lang_code'].'" selected="selected">'.$row_lang_select['lang_title'].'</option>';
	else
	$lang_dd.='<option value="'.$row_lang_select['lang_code'].'">'.$row_lang_select['lang_title'].'</option>';
}
//******************************************
?>