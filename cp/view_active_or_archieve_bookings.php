<?php 
include("access.php");
if(isset($_REQUEST['delete'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");	
	$bsiAdminMain->booking_cencel_delete(2);
	header("location:view_active_or_archieve_bookings.php?book_type=".$_GET['book_type']);
	exit;
}
if(isset($_REQUEST['cancel'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");	
	include("../includes/admin.class.php");
	include("../includes/mail.class.php");	
	$bsiAdminMain->booking_cencel_delete(1); 
	header("location:view_active_or_archieve_bookings.php?book_type=".$_GET['book_type']);
	exit;
}
include("header.php"); 
include("../includes/conf.class.php");	
include("../includes/admin.class.php");
if(isset($_GET['book_type'])){
	$book_type = $bsiCore->ClearInput($_GET['book_type']);
	
}else{
	$book_type = $bsiCore->ClearInput($_POST['book_type']);
	$_SESSION['book_type'] = $book_type;
	$_SESSION['fromDate']=$bsiCore->ClearInput($_POST['fromDate']);
	$_SESSION['toDate']=$bsiCore->ClearInput($_POST['toDate']);
	$_SESSION['shortby']=$bsiCore->ClearInput($_POST['shortby']);
}
if($_SESSION['fromDate'] !="" and $_SESSION['toDate'] != ""){
$condition=" and (DATE_FORMAT(".$_SESSION['shortby'].", '%Y-%m-%d') between '".$bsiCore->getMySqlDate($_SESSION['fromDate'])."' and '".$bsiCore->getMySqlDate($_SESSION['toDate'])."')";
$shortbyarr=array("booking_time"=>VIEW_ACTIVE_BOOKING_DATE, "start_date"=>CUSTOMER_BOOKING_CHECK_IN_DATE, "end_date"=>CUSTOMER_BOOKING_CHECK_OUT_DATE);
$text_cond="( ".$_SESSION['fromDate']."  ".VB_TO." ".$_SESSION['toDate']."  ".VB_BY." ".$shortbyarr[$_SESSION['shortby']]." )";
}else{
$condition="";
$text_cond="";
}

$query = $bsiAdminMain->getBookingInfo($book_type, $clientid=0, $condition);

$html  = $bsiAdminMain->getHtml($book_type, $query);
$title_hr = array(1=>VB_ACTIVE, 2=>VB_HISTORY);
?>   
<script type="text/javascript">
	function cancel(bid){
		var answer = confirm ("Are you sure want to cancel Booking?");
		if (answer)
			window.location="<?=$_SERVER['PHP_SELF']?>?cancel="+bid+"&book_type="+<?=$book_type?>;
	}
	
	function deleteBooking(bid){
		var answer = confirm ("Are you sure want to delete Booking?");
		if (answer)
			window.location="<?=$_SERVER['PHP_SELF']?>?delete="+bid+"&book_type="+<?=$book_type?>;
	}
		
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
</script> 
      <div id="container-inside">
      <span style="font-size:16px; font-weight:bold"><?=$title_hr[$book_type]?>  <?=$text_cond?></span>
      <input type="submit" value="Back" style="background:#e5f9bb; cursor:pointer; cursor:hand; float:right" onClick="javascript:window.location.href='view_bookings.php'"/>
      <hr />
        <table class="display datatable" border="0">
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