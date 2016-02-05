<?php
include ("access.php");
if(isset($_POST['act']) && $_POST['act'] == 1){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	if($_POST['roomtype_edit'] > 0){
		$bsiAdminMain->priceplan_edit($_POST['roomtype_edit']);
	}else{
		$bsiAdminMain->priceplan_add_edit(); 
	}
	exit;
}
$pageid = 36; 
include ("header.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");
$getHTML  = array();
$getHTML1 = array();
$getHTML2 = array();
$row      = array();
$id=$bsiCore->ClearInput($_REQUEST['rtype']);
if($id){
	$text     = '';
	$start_dt = mysql_real_escape_string($_REQUEST['start_dt']);
	if($start_dt != '0000-00-00'){
		
		$row=mysql_fetch_assoc(mysql_query("SELECT bp.*, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date1,
		DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date1, start_date, end_date, bc.title, bc.capacity FROM `bsi_priceplan` as bp,bsi_capacity as bc
		where `plan_id`='".$id."' and start_date='".$start_dt."' and default_plan=0 and bp.capacity_id=bc.id group by
		`roomtype_id`,`start_date`"));
		
	}else{
		
		$row = mysql_fetch_assoc(mysql_query("SELECT bp.*, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date1,
		DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date1, start_date, end_date, bc.title, bc.capacity FROM `bsi_priceplan` as bp,bsi_capacity as bc 
		where `plan_id`='".$id."' and start_date='".$start_dt."' and default_plan=1 and bp.capacity_id=bc.id group by 
		`roomtype_id`,`start_date`"));
		
	}
	$rtypeName = mysql_fetch_assoc(mysql_query("select * from bsi_roomtype where roomtype_ID='".$row['roomtype_id']."'"));
	
	$getHTML   = $bsiAdminMain->getDatepicker($id, $rtypeName['type_name'], $row['start_date'], $row['end_date'], $row);
	
	$getHTML1  = $getHTML['html'];
	
	$getHTML2  = $getHTML['editPriceplanHTML'];
	
	$text      = '';
	
}else{
	
	$getHTML   = $bsiAdminMain->getDatepicker();
	
	$getHTML1  = $getHTML['html'];
	
	$getHTML2  = $getHTML['editPriceplanHTML'];
	
	$start_dt  = '0000-00-00';
	
	$text      = PLEASE_SELECT_ROOMTYPE_FROM_DROPDOWN;
}
?>
<link rel="stylesheet" type="text/css" href="../css/datepicker.css" />
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js//dtpicker/jquery.ui.datepicker-<?=$langauge_selcted?>.js"></script>
<script type="text/javascript" charset="">
   $(document).ready(function() {
   $("#priceplanaddeit").validate();
   $('#roomtype_id').change(function() {
         if($('#roomtype_id').val() != 0){
			var querystr = 'actioncode=3&roomtype_id='+$('#roomtype_id').val();		
			$.post("admin_ajax_processor.php", querystr, function(data){												 
				if(data.errorcode == 0){
					 $('#default_capacity').html(data.strhtml)
				}else{
				    $('#default_capacity').html("<span style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px;\">'<?php  echo NOT_FOUND;?>'</span>")
				}
			}, "json");
		} else {
		 $('#default_capacity').html("<span style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px;\">'<?php echo PLEASE_SELECT_ROOMTYPE_FROM_DROPDOWN_ALERT; ?>'</span>")
		}
	});
	
	if($('#roomtype').val() == 0){
		$('#default_capacity').html("<span style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px;\">'<?php echo PLEASE_SELECT_ROOMTYPE_FROM_DROPDOWN_ALERT; ?>'</span>")
	}
});
 
$(document).ready(function(){
	$.datepicker.setDefaults( $.datepicker.regional[ "<?=$langauge_selcted?>" ] );
	$.datepicker.setDefaults({ dateFormat: '<?=$bsiCore->config['conf_dateformat']?>' });
    $("#txtFromDate").datepicker({
        minDate: 0,
        maxDate: "+365D",
        numberOfMonths: 2,
        onSelect: function(selected) {
        var date = $(this).datepicker('getDate');
        if(date){
            date.setDate(date.getDate() + <?=$bsiCore->config['conf_min_night_booking']?>);
        }
          $("#txtToDate").datepicker("option","minDate", date)
        }
    });
    $("#txtToDate").datepicker({ 
        minDate: 0,
        maxDate:"+365D",
        numberOfMonths: 2,
        onSelect: function(selected) {
           $("#txtFromDate").datepicker("option","maxDate", selected)
        }
    });
	
	$("#txtFromDate").datepicker();
	$("#datepickerImage").click(function() { 
		$("#txtFromDate").datepicker("show");
	});
	
	$("#txtToDate").datepicker();
	$("#datepickerImage1").click(function() { 
		$("#txtToDate").datepicker("show");
	});    
});
</script>
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<div id="container-inside">
<span style="font-size:16px; font-weight:bold"><?php echo PRICE_PLAN_ADD_AND_EDIT;?></span>
    <input type="button" value="<?php echo PRICE_PLAN_BACK;?>" onClick="window.location.href='priceplan.php'" style="background:#e5f9bb; cursor:pointer; cursor:hand; float:right; "/>
<hr style="margin-top:10px;" />
  <form action="" method="post" id="form1">
    <input type="hidden" name="roomtype_edit" value="<?=$id?>" />
    <input type="hidden" name="roomtype" value="<?=$row['roomtype_id']?>" />
    <input type="hidden" name="start_date_old" value="<?=$start_dt?>" />
    <input type="hidden" name="act" value="1" />
    <table cellpadding="5" cellspacing="2" border="0">
      <tr>
        <td colspan="2" align="center" style="font-size:14px; color:#006600; font-weight:bold"><?php if(isset($error_msg)) echo $error_msg; ?></td>
      </tr>
      <?=$getHTML1?>
      <tr>
        <td id="default_capacity" colspan="2">
          <?=$text?>
          <?=$getHTML2?>
        </td>
      </tr> 
    </table>
  </form>
</div>   
<script type="text/javascript">
	$(document).ready(function() {
		$("#form1").validate();
     });    
</script> 
<script src="../js/jquery.validate_pp.js" type="text/javascript"></script>
<?php include("footer.php"); ?>
