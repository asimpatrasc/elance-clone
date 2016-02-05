<?php 
include("access.php");
if(isset($_POST['act_save'])){
		include("../includes/db.conn.php");
		$month_num1=$_POST;
		for($j=1;$j<=12;$j++){
			mysql_query("update bsi_advance_payment set deposit_percent='".$month_num1[$j]."' where month_num=".$j);
		}
		header("location:advance_payment.php");
 }
include("header.php"); 
include("../includes/conf.class.php");
$depo_val='';
	if($bsiCore->config['conf_enabled_deposit']==1){
		$depo_val  = 1;
	$deposit_check = "checked";
	}else{
		$depo_val=0;
	$deposit_check = "";
	}
?>    
 <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
 <script type="text/javascript">
$(document).ready(function(){
		if(<?=$depo_val?>==1){								 
			showDeposit();
		}
  		$('#chk_deposit').click(function() {
			showDeposit();		
		});
		
		function showDeposit(){
		 var chk_deposit=$('#chk_deposit').attr('checked');
			var querystr = 'actioncode=4&type=2&chk_deposit='+chk_deposit; 
			$.post("admin_ajax_processor.php", querystr, function(data){											  
				if(data.errorcode == 0){
					$('#showdeposit').html(data.getresult)
				}
				}, "json");
	}
		
		
});
			
	</script>
      <div id="container-inside">
      <span style="font-size:16px; font-weight:bold"><?php echo ADVANCE_PAYMENT_SETTING;?></span>
      <hr />
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form1">
          <table cellpadding="5" cellspacing="2" border="0" width="100%">
          <thead>
          <tr>
            <th colspan="2"  align="left"><input type="checkbox" <?=$deposit_check?>  id="chk_deposit" name="chk_deposit" value=""/><?php echo ENABLED_MONTHLY_DEPOSIT_SCHEME;?></th>
            
          </tr>
          <tr><th colspan="2" colspan="2"><hr /></th></tr>
        </thead>
        <tbody id="showdeposit">
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
