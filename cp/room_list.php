<?php 
include("access.php");
if(isset($_GET['rid']) && isset($_GET['cid'])){
	include("../includes/db.conn.php"); 
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->delete_room();
	header("location:room_list.php");	
	exit;
}
include("header.php"); 
include("../includes/admin.class.php");
?>
<div id="container-inside">
<span style="font-size:16px; font-weight:bold"><?php echo ROOM_LIST;?></span><span style="font-size:13px; color:#F00; padding-left:200px;"><?php if(isset($_SESSION['msg_exists'])){ echo $_SESSION['msg_exists']; }
unset($_SESSION['msg_exists']);?></span>
    <input type="button" value="<?php echo ADD_NEW_ROOM;?>" onClick="window.location.href='add_edit_room.php?rid=0&cid=0'" style="background: #EFEFEF; float:right"/>
 <hr />
  <table class="display datatable" border="0">
    <thead>
      <tr>
        <th><?php echo ROOM_TYPE;?></th>
        <th><?php echo ADULT_ROOM; ?></th>
        <th><?php echo TOTAL_ROOM;?></th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <?=$bsiAdminMain->generateRoomListHtml()?>
  </table>
</div>
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 
<script>
 $(document).ready(function() {
	 	var oTable = $('.datatable').dataTable( {
				"bJQueryUI": true,
				"sScrollX": "",
				"bSortClasses": false,
				"aaSorting": [[0,'asc']],
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
