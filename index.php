<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("language.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?=$bsiCore->config['conf_hotel_name']?>
</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link rel="stylesheet" type="text/css" href="css/datepicker.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js//dtpicker/jquery.ui.datepicker-<?=$langauge_selcted?>.js"></script>
<script type="text/javascript">
$(document).ready(function(){
 $.datepicker.setDefaults( $.datepicker.regional[ "<?=$langauge_selcted?>" ] );
 $.datepicker.setDefaults({ dateFormat: '<?=$bsiCore->config['conf_dateformat']?>'});
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
 $("#datepickerImage").click(function() { 
    $("#txtFromDate").datepicker("show");
  });
 $("#datepickerImage1").click(function() { 
    $("#txtToDate").datepicker("show");
  });
  
  $('#btn_room_search').click(function() { 		
	  	if($('#txtFromDate').val()==""){
	  		alert('<?=mysql_real_escape_string(ENTER_CHECK_IN_DATE_ALERT)?>');
	  		return false;
	 	}else if($('#txtToDate').val()==""){
	  		alert('<?=mysql_real_escape_string(ENTER_CHECK_OUT_DATE_ALERT)?>');
	  		return false;
	  	} else {
	  		return true;
	 	}	  
	});	
});
</script>
<script>
function langchange(lng)
{
	window.location.href = '<?=$_SERVER['PHP_SELF']?>?lang=' + lng;
}		
</script>
</head>
<body>
<div id="content" align="center">
<select name="lang" style="width:150px;" onchange="langchange(this.value)"><?=$lang_dd?></select>
 <h1>
  <?=$bsiCore->config['conf_hotel_name']?>
 </h1>
 <div id="wrapper" style="width:300px !important;" >
  <h2 align="left" style="padding-left:5px;"><?=ONLINE_BOOKING_TEXT?></h2>
  <hr color="#e1dada"  style="margin-top:3px;"/>
  <form id="formElem" name="formElem" action="booking-search.php" method="post">
   <table cellpadding="0"  cellspacing="7" border="0"  align="left" style="text-align:left;">
    <tr>
     <td><strong><?=CHECK_IN_DATE_TEXT?>:</strong></td>
     <td><input id="txtFromDate" name="check_in" style="width:68px" type="text" readonly="readonly" AUTOCOMPLETE=OFF />
      <span style="padding-left:3px;"><a id="datepickerImage" href="javascript:;"><img src="images/month.png" height="16px" width="16px" style=" margin-bottom:-4px;" border="0" /></a></span></td>
    </tr>
    <tr>
     <td><strong><?=CHECK_OUT_DATE_TEXT?>:</strong></td>
     <td><input id="txtToDate" name="check_out" style="width:68px" type="text" readonly="readonly" AUTOCOMPLETE=OFF />
      <span style="padding-left:3px;"><a id="datepickerImage1" href="javascript:;"><img src="images/month.png" height="18px" width="18px" style=" margin-bottom:-4px;" border="0" /></a></span></td>
    </tr>
    <tr>
     <td><strong><?=ADULT_OR_ROOM_TEXT?>:</strong></td>
     <td><?=$bsiCore->capacitycombo();?></td>
    </tr>
    <tr>
     <td></td>
     <td><button id="btn_room_search" type="submit"><?=SEARCH_TEXT?></button></td>
    </tr>
   </table>
  </form>
 </div>
</div>
</body>
</html>