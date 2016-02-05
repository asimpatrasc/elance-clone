<?php 
include("access.php");
include("header.php"); 

if(isset($_GET['del'])){
	$del2=$_GET['del'];
   $r=mysql_query("select * from bsi_adminmenu where parent_id=".mysql_real_escape_string($_REQUEST['id']));
   if(@mysql_num_rows($r)){
      $msg="<font face=verdana size=1 color=#ffffff><b>You Can't delete.agentmenus exists in this category.</b></font>";	  
   }else{
      $r=mysql_query("delete from bsi_adminmenu where id=\"" .mysql_real_escape_string($_REQUEST['id']). "\"");
      echo"<script>window.location.href='adminmenu.list.php';</script>";
   }
}
?>
<div id="container-inside">
<span style="font-size:16px; font-weight:bold"><?=ADMN_MENU_LST?></span>
    <input type="button" value="<?php echo ADMN_BTN_1ST;?>" onClick="javascritp:window.location.href='adminmenu.entryform.php?parent_id=0';"  style="background: #EFEFEF; float:right"/>
 <hr />


<form method=post action="<?=$_SERVER[PHP_SELF]?>">

<table id="table-1" width="100%" class="sort-table" align="center" cellspacing="1" cellpadding="4" border="0" style='border:solid 1px #666666'>

<tr><td valign=top><b><?=ADMN_1ST_LEVEL?></b></td><td valign=top><b><?=ADMN_2ND_LEVEL?></b></td><td valign=top align="center"><b><?=ADMN_ORDER?></b></td><td></td></tr>
<tr><td colspan="4" style='background-image:url(images/border23.jpg); background-repeat:repeat-x'></td></tr>
<?php
$j=0;
$tids=array();
if(isset($_REQUEST['tid'])){
  $tids=explode("|",$_REQUEST['tid']);
}
$tid=0;

$r=mysql_query("select * from bsi_adminmenu where parent_id=0 order by ord");
while($d=@mysql_fetch_array($r)):
    if(!($j%2)){$class="even";}else{$class="odd";}
	echo"<tr bgcolor=#ffffff class=even>
			<td >";
				if(in_array($d['id'],$tids)):
					echo"<input type=button align=\"left\" class=lnk onclick=\"javascript:window.location.href='" . $_SERVER['PHP_SELF'] . "?tid=". str_replace("|".$d['id']."|","|",$tid) .  "'\" value='-'>";
				else:
					$q=mysql_query("select count(*) as total from bsi_adminmenu where  parent_id=" . $d['id']);
					$n=@mysql_result($q,0,"total");
					
					if($n>0)
					{
						echo "<input type=button align=\"left\" class=lnk onclick=\"javascript:window.location.href='" . $_SERVER['PHP_SELF'] . "?tid=". $tid . "|" . $d['id'] . "|'\" value='+'>"; 
					}
					else
					{
						echo"<input type=button align=\"left\" class=lnk onclick=\"javascript:window.location.href='" . $_SERVER['PHP_SELF'] . "?tid=". str_replace("|$d[id]|","|",$tid) .  "'\" value='-'>";						
					}
				endif;
				echo" <a class=lnk";
						echo" href='adminmenu.entryform.php?id=" . $d['id'] . "'";
						//echo"href='#'";
						echo"><b>" . $d['name'] . "</b>
					</a>
			</td>
			<td></td>
			<td align=center>" . $d['ord'] . "</td>";
		
			
			echo "<td align=center>
				<a class=lnk ";
					//echo"href='#'"; 
					echo"href='adminmenu.entryform.php?id=".$d['id'] . "'"; 
					echo"><u>".CUSTOMERLOOKUP_EDIT."</u>
				</a> |  
				<a class=lnk "; 
					//echo"href='#'"; 
					echo"href='adminmenu.entryform.php?parent_id=".$d['id'] . "'";
					echo"><u>".ADMN_BTN_SUB."</u>
				</a> | 
				<a class=lnk"; 
					echo" href=\"javascript:if(confirm('You are deleting `" . $d['name'] . "`?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $d['id'] . "&del=1';}\""; 
					//echo" href='#'";
					echo"><u>".DELETE_ROOM_LIST."</u>
				</a>
			</td>
		</tr>";
    	if(in_array($d['id'],$tids)):
			$rr=mysql_query("select * from bsi_adminmenu where parent_id=" . $d['id'] . " order by ord");
			$k=0;
			while($dd=mysql_fetch_array($rr)):
				if(!($k%2)){$class="odd";}else{$class="even";} 
				echo"<tr bgcolor=#ffffff class=odd>
						<td>&nbsp;|___________________</td>
						<td >
							<a class=lnk"; 
								echo" href='adminmenu.entryform.php?id=" . $dd['id'] . "&id=" . $dd['id'] . "'"; 
								//echo "href='#'";
								echo">" . $dd['name'] . "
							</a>
						</td>
			<td align=center>" . $dd['ord'] . "</td>";
			
			
			echo "<td align=center>
							<a class=lnk"; 
								echo " href='adminmenu.entryform.php?tid=" . $_REQUEST['tid'] . "&id=" . $dd['id']. "&parent_id=" . $dd['parent_id'] . "'"; 
								//echo"href='#'";
								echo "><u>".CUSTOMERLOOKUP_EDIT."</u>
							</a> | 
							<a class=lnk "; 
					//echo"href='#'"; 
					echo"href='adminmenu.entryform.php?parent_id=" . $dd['id'] . "'";
					echo"><u>".ADMN_BTN_SUB."</u>
				</a> | 
							<a class=lnk"; 
								echo" href=\"javascript:if(confirm('You are deleting `" . $dd['name'] . "`?')){window.location='" . $_SERVER['PHP_SELF'] . "?tid=" . $_REQUEST['tid'] . "&id=" . $dd['id'] . "&del=1';}\"";
								//echo"href='#'";
								echo"><u>".DELETE_ROOM_LIST."</u>
							</a>
						</td>
					</tr>";
				
				
			endwhile;
		endif;	
		$j++;
	endwhile;   
	?>
	</tbody>
</table>
</form>
<br />
Note: Please do not delete existing menu without any reason.
</div>
<?php include("footer.php"); ?> 