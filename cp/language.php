<?php
$row_default_lang=mysql_fetch_assoc(mysql_query("select * from bsi_language where `lang_default`=true"));
if(isset($_SESSION['language1']))
$langauge_selcted=mysql_real_escape_string($_SESSION['language1']);
else
$langauge_selcted=$row_default_lang['lang_code'];

$row_visitor_lang=mysql_fetch_assoc(mysql_query("select * from bsi_language where  lang_code='$langauge_selcted' "));
include("languages/".$row_visitor_lang['lang_file']);
?>