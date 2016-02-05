<?php
include ("access.php");
if(isset($_REQUEST['pln_del'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	$pln_del = base64_decode($_REQUEST['pln_del']);
	$pln_del = explode("|",$pln_del);
	$r_id = $bsiCore->ClearInput($pln_del[3]);
	mysql_query("delete from bsi_priceplan where start_date='$pln_del[1]' and end_date='$pln_del[2]' and roomtype_id=".$r_id);
	$_SESSION['roomtype_id'] = $pln_del[3];
	header("location: priceplan.php");
}
$pageid=36;
include ("header.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");
?>
<script>
	$(document).ready(function(){
		
		 $('#roomtype').change(function() { 
			getPriceplan();
		 });
		 if($('#roomtype').val() > 0){
			 getPriceplan();
		 }
		 function getPriceplan(){
			 if($('#roomtype').val() != 0){
				var querystr = 'actioncode=2&roomtype_id='+$('#roomtype').val();
				$.post("admin_ajax_processor.php", querystr, function(data){						 
					if(data.errorcode == 0){ 
						$('#getpriceplanHtml').html(data.strhtml)
					}else{
						$('#getpriceplanHtml').html('<tr><td colspan="12"><?php echo NO_AVAILABLE_DATA_FOUND; ?> !</td></tr>')
					}
					
				}, "json");
			}
			if($('#roomtype').val() == 0){
				$('#getpriceplanHtml').html('<tr><td colspan="12"><?php echo PRICEPLAN_PLEASE_SELECT_ROOMTYPE_FIRST; ?>!</td></tr>')
			}
		 }
	});
function priceplandelete(rid){
	var ans=confirm('+<?php echo DO_YOU_WANT_TO_DELETE_SELECTED_PRICEPLAN; ?>+');
	if(ans){
		window.location='<?=$_SERVER['PHP_SELF']?>?pln_del='+rid;
		return true;
		
	}else{
		return false;
		
	}
	
}
</script>
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<div id="container-inside">
<span style="font-size:16px; font-weight:bold"><?php echo PRICE_PLAN_PRICE_LIST;?></span>
<input type="button" value="<?php echo ADD_NEW_PRICEPLAN; ?>" onClick="window.location.href='add_edit_priceplan.php?rtype=0&start_dt=0'" style="background:#e5f9bb; cursor:pointer; cursor:hand; float:right; " />
<hr style="margin-top:10px;" />
    <table width="100%"><tr><td width="80%" align="left"><?php if(isset($_SESSION['error_msg'])){ echo $_SESSION['error_msg']; }
	unset($_SESSION['error_msg']);?></td><td align="right"></td></tr></table>
  
    <table cellpadding="5" cellspacing="0" border="0" width="100%">
      <thead>
        <tr>
          <th nowrap="nowrap" width="15%" align="left"><?php echo PRICE_PLAN_SELECT_ROOM_TYPE;?>:</th>
          <th  colspan="11" align="left"><?php 
							if(isset($_SESSION['roomtype_id'])){
								echo $select_rtype=$bsiAdminMain->getRoomtype($_SESSION['roomtype_id']);
							}else{
								echo $select_rtype=$bsiAdminMain->getRoomtype();
							}
							?></th>
                            
        </tr>
        <tr><th colspan="12"><hr /></th></tr>
      </thead>
      <tbody id="getpriceplanHtml">
     <tr><td colspan="12"> <?php echo PLEASE_SELECT_ROOMTYPE_FIRST;?> !</td></tr>
      </tbody>
    </table>
</div>
<script type="text/javascript">
	$().ready(function() {
		$("#form1").validate();
		
     });
         
</script> 
<script src="js/jquery.validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?>
