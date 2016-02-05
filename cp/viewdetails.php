<?php 
include("access.php");
include("header.php");
include("../includes/conf.class.php");	
include("../includes/admin.class.php");
if(!isset($_GET['booking_id'])){
	  header("location:admin-home.php");	
}
$bookingid = $bsiCore->ClearInput(base64_decode($_GET['booking_id']));
$viewdetailsquery = mysql_query("select bc.*, bb.* from bsi_bookings as bb, bsi_clients as bc where  bb.client_id=bc.client_id and booking_id=".$bookingid."");
$rowviewdetails = mysql_fetch_assoc($viewdetailsquery);	 
?>
<link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
<div id="container-inside"> <span style="font-size:16px; font-weight:bold"><?php echo VIEW_BOOKING_DETAILS;?> :
  <?=$bookingid?>
  </span>
  <?php if(isset($_SERVER['HTTP_REFERER'])){
	  		$pathArr = pathinfo($_SERVER['HTTP_REFERER']);//print_r($pathArr);
			if($pathArr['filename'] == 'view_active_or_archieve_bookings'){
				echo '<input type="submit" value='.VIEWDETAILS_BACK.' style="background:#e5f9bb; cursor:pointer; cursor:hand; float:right" onClick="javascript:window.location.href=\'view_active_or_archieve_bookings.php?book_type='.$_SESSION['book_type'].'\'"/>';
			}else{
				echo '<input type="submit" value='.VIEWDETAILS_BACK.' style="background:#e5f9bb; cursor:pointer; cursor:hand; float:right" onClick="javascript:window.location.href=\''.$_SERVER['HTTP_REFERER'].'\'"/>'; 
			}
  		}
  ?>
  <hr style="margin-top:10px;" />
  <table style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; background:#999999; width:700px; border:none;" cellpadding="4" cellspacing="1">
    <tr>
      <td align="left" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;" colspan="2"><b><?php echo VIEW_CUSTOMER_DETAILS;?></b></td>
    </tr>
    <tr>
      <td align="left" style="background:#ffffff;" width="150px"><?php echo VIEWDETAILS_NAME;?></td>
      <td align="left" style="background:#ffffff;"><?=$rowviewdetails['title']?>
        <?=$rowviewdetails['first_name']?>
        <?=$rowviewdetails['surname']?></td>
    </tr>
     <tr>
      <td align="left" style="background:#ffffff;"><?php echo VIEWDETAILS_ADDRESS;?></td>
      <td align="left" style="background:#ffffff;"><?=$rowviewdetails['street_addr']?></td>
    </tr>
    <tr>
      <td align="left" style="background:#ffffff;"><?php echo VIEWDETAILS_CITY;?></td>
      <td align="left" style="background:#ffffff;"><?=$rowviewdetails['city']?></td>
    </tr>
    <tr>
      <td align="left" style="background:#ffffff;"><?php echo VIEWDETAILS_STATE;?></td>
      <td align="left" style="background:#ffffff;"><?=$rowviewdetails['province']?></td>
    </tr>
    <tr>
      <td align="left" style="background:#ffffff;"><?php echo VIEWDETAILS_COUNTRY;?></td>
      <td align="left" style="background:#ffffff;"><?=$rowviewdetails['country']?></td>
    </tr>
    <tr>
      <td align="left" style="background:#ffffff;"><?php echo VIEWDETAILS_ZIP_AND_POST_CODE;?>:</td>
      <td align="left" style="background:#ffffff;"><?=$rowviewdetails['zip']?></td>
    </tr>
  
    <tr>
      <td align="left" style="background:#ffffff;"><?php echo VIEWDETAILS_PHONE;?></td>
      <td align="left" style="background:#ffffff;"><?=$rowviewdetails['phone']?></td>
      
   </tr>
    <tr>
      <td align="left" style="background:#ffffff;"><?php echo VIEWDETAILS_FAX;?></td>
      <td align="left" style="background:#ffffff;"><?=$rowviewdetails['fax']?></td>
    </tr>
    <tr>
      <td align="left" style="background:#ffffff;"><?php echo VIEWDETAILS_EMAIL;?></td>
      <td align="left" style="background:#ffffff;"><?=$rowviewdetails['email']?></td>
    </tr>
    
  </table>
  <?=$bsiAdminMain->paymentDetails($rowviewdetails['payment_type'], $bookingid);?><br />
  <table style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; background:#999999; width:700px; border:none;" cellpadding="4" cellspacing="1">
    <tr>
      <td align="left" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;" colspan="2"><b><?php echo VIEWDETAILS_BOOKING_STATUS;?></b></td>
    </tr>
    <tr>
      <?php
		 $status='';
		 $curdate=date('Y-m-d');
		 $rowviewdetails['is_deleted'];
		if($rowviewdetails['is_deleted'] == 0 && $rowviewdetails['end_date']<$curdate ){
			$status=DEPARTED;
			echo '<td align="left" style="background:#ffffff;color:blue;"><strong>'.$status.'</strong></td>';	
		}else if($rowviewdetails['is_deleted']==0 && $rowviewdetails['end_date']>$curdate){
			$status=ACTIVE;
			echo '<td align="left" style="background:#ffffff;color:green;"><strong>'.$status.'</strong></td>';	
		}else if($rowviewdetails['is_deleted']==1){
			$status=CANCELLED;
			echo '<td align="left" style="background:#ffffff;color:red;"><strong>'.$status.'</strong></td>';	
		}
		?>
    </tr>
  </table>
</div>
<?php include("footer.php"); ?>
