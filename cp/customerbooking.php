<?php
include ("access.php");
if(isset($_REQUEST['delete'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->booking_cencel_delete(2);
	$client = base64_encode($_REQUEST['client']);
	header("location:customerbooking.php?client=".$client);
	exit;
}
if(isset($_REQUEST['cancel'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");	
	include("../includes/admin.class.php");
	include("../includes/mail.class.php");	
	$bsiAdminMain->booking_cencel_delete(1); 
	$client = base64_encode($_REQUEST['client']);
	header("location:customerbooking.php?client=".$client);
	exit;
}
if(isset($_GET['client'])){
	include("header.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$client    = mysql_real_escape_string(base64_decode($_GET['client']));
	$delClient = $client;
	$htmlArr   = $bsiAdminMain->fetchClientBookingDetails($client);
	
	$html      = $htmlArr['html'];
}else{
	header("location:customerlookup.php");
	exit;
}
?>
<script type="text/javascript">
function myPopup2(booking_id){
	var width = 730;
	var height = 650;
	var left = (screen.width - width)/2;
	var top = (screen.height - height)/2;
	var url='print_invoice.php?bid='+booking_id;
	var params = 'width='+width+', height='+height;
	params += ', top='+top+', left='+left;
	params += ', directories=no';
	params += ', location=no';
	params += ', menubar=no';
	params += ', resizable=no';
	params += ', scrollbars=yes';
	params += ', status=no';
	params += ', toolbar=no';
	newwin=window.open(url,'Chat', params);
	if (window.focus) {newwin.focus()}
	return false;
}
function cancel(bid){
	var answer = confirm ('<?php  echo CUSTOMER_BOOKING_ARE_YOU_SURE_WANT_TO_CANCEL_BOOKING; ?>');
	if (answer)
		window.location="<?=$_SERVER['PHP_SELF']?>?cancel="+bid+"&client="+<?=$delClient?>;
}
function booking_delete(delid){
	var answer = confirm ('<?php echo ARE_YOU_SURE_WANT_TO_DELETE_BOOKING_ALERT; ?>');
	if (answer)
		window.location="<?=$_SERVER['PHP_SELF']?>?delete="+delid+"&client="+<?=$delClient?>;
	}
</script>
<div id="container-inside"> <span style="font-size:16px; font-weight:bold"><?php echo CUSTOMER_BOOKING_LIST_OF;?> <?=$htmlArr['clientName']?></span>
 <hr />
 <table class="display datatable" border="0">
  <thead>
   <tr>
    <th width="9%" nowrap><?php echo CUSTOMER_BOOKING_ID;?></th>
    <th width="18%" nowrap><?php echo CUSTOMER_BOOKING_NAME;?></th>
    <th width="8%" nowrap="nowrap"><?php echo CUSTOMER_BOOKING_CHECK_IN_DATE;?></th>
    <th width="10%" nowrap><?php echo CUSTOMER_BOOKING_CHECK_OUT_DATE;?></th>
    <th width="10%" nowrap><?php echo CUSTOMER_BOOKING_AMOUNT;?></th>
    <th width="9%" nowrap><?php echo CUSTOMER_BOOKING_DATE;?></th>
    <th width="8%" nowrap="nowrap"><?php echo CUSTOMER_BOOKING_STATUS;?></th>
    <th width="25%">&nbsp;</th>
   </tr>
  </thead>
  <?=$html?>
 </table>
</div>
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 
<script>
 $(document).ready(function() {
	 	var oTable = $('.datatable').dataTable( {
				"bJQueryUI": true,
				"sScrollX": "",
				"bSortClasses": false,
				"aaSorting": [[0,'desc']],
				"bAutoWidth": true,
				"bInfo": true,
				"sScrollY": "100%",	
				"sScrollX": "100%",
				"bScrollCollapse": true,
				"sPaginationType": "full_numbers",
				"bRetrieve": true,
				"oLanguage": {
								"sSearch": "<?=DT_SEARCH?>:",
								"sInfo": "<?=DT_SINFO1?> _START_ <?=DT_SINFO2?> _END_ <?=DT_SINFO3?> _TOTAL_ <?=DT_SINFO4?>",
								"sInfoEmpty": "<?=DT_INFOEMPTY?>",
								"sZeroRecords": "<?=DT_ZERORECORD?>",
								"sInfoFiltered": "(<?=DT_FILTER1?> _MAX_ <?=DT_FILTER2?>)",
								"sEmptyTable": "<?=DT_EMPTYTABLE?>",
								"sLengthMenu": "<?=DT_LMENU?> _MENU_ <?=DT_SINFO4?>",
								"oPaginate": {
												"sFirst":    "<?=DT_FIRST?>",
												"sPrevious": "<?=DT_PREV?>",
												"sNext":     "<?=DT_NEXT?>",
												"sLast":     "<?=DT_LAST?>"
											  }
							 }
	} );
} );
</script> 
<script type="text/javascript" src="js/bsi_datatables.js"></script>
<link href="css/data.table.css" rel="stylesheet" type="text/css" />
<link href="css/jqueryui.css" rel="stylesheet" type="text/css" />
<?php include("footer.php"); ?>
