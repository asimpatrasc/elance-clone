<?php 

include("access.php");

if((isset($_GET['action'])) && ($_GET['action'] == "unblock")){

	include("../includes/db.conn.php");

	include("../includes/conf.class.php");

	$booking_id  = $bsiCore->ClearInput($_GET['bid']);

	$roomtype_id = $bsiCore->ClearInput($_GET['rti']);

	$capacity_id = $bsiCore->ClearInput($_GET['cid']);

	$result      = mysql_query("SELECT count(*) from bsi_reservation br, bsi_bookings bb, bsi_roomtype brt where br.bookings_id=".$booking_id." and

						 bb.is_block=1 and br.room_type_id=brt.roomtype_id group by br.room_type_id");

	$num=mysql_num_rows($result);

	if($num<=1){

		mysql_query("delete from bsi_reservation where bookings_id=".$booking_id." and room_type_id=".$roomtype_id);

		mysql_query("delete from bsi_bookings where booking_id=".$booking_id."");

	}else{

		mysql_query("delete from bsi_reservation where bookings_id=".$booking_id." and room_type_id=".$roomtype_id);	

	}

	header("location:admin_block_room.php");

	exit;

}

include("header.php"); 

include("../includes/conf.class.php");

include("../includes/admin.class.php");

?>



<div id="container-inside">

<span style="font-size:16px; font-weight:bold"><?php echo ROOM_BLOCK_LIST;?></span>

    <input type="button" value="<?php echo CLICK_HERE_TO_BLOCK_ROOM;?>" onClick="window.location.href='block_room.php'" style="background: #EFEFEF; float:right;"/>

<hr />

  <table class="display datatable" border="0">

    <thead>

      <tr>

        <th><?php echo DESCRIPTION_AND_NAME;?></th>

        <th><?php echo DATE_RANGE;?></th>

        <th><?php echo ROOMTYPE_CAPACITY;?></th>

        <th><?php echo ADMIN_BLOCK_TOTAL_ROOM;?></th>

        <th></th>

      </tr>

    </thead>

    <?=$bsiAdminMain->getBlockRoomDetails();?>

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

