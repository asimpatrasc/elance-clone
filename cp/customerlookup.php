<?php 
include ("access.php");
if(isset($_REQUEST['update'])){
	
	header('location:customerlookup.php');
	exit;
}
include ("header.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");
$html = $bsiAdminMain->getCustomerHtml();
 ?>    
      <div id="container-inside">
       <span style="font-size:16px; font-weight:bold"><?php echo CUSTOMERLOOKUP_CUSTOMER_LIST;?></span>
      <hr />
        <table class="display datatable" border="0">
          <thead>
	<tr><th width="18%" nowrap="nowrap"><?php echo CUSTOMERLOOKUP_GUEST_NAME;?></th><th width="27%" nowrap="nowrap"><?php echo CUSTOMER_STREET_ADDRESS;?></th><th width="15%" nowrap="nowrap"><?php echo CUSTOMERLOOKUP_PHONE_NUMBER;?></th><th width="25%" nowrap="nowrap"><?php echo CUSTOMERLOOKUP_EMAIL_ID;?></th><th width="15%" nowrap="nowrap">&nbsp;</th></tr>
 </thead>
 <tbody id="getcustomerHtml">
 	<?=$html?>
 </tbody>
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