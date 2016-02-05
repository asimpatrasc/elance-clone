<?php
class adminAjaxProcessor
{
	public function sendErrorMsg(){		
		$this->errorMsg = "unknown error";	
		echo json_encode(array("errorcode"=>99,"strmsg"=>$this->errorMsg));
	}//end of function	
	
	public function getbsiEmailcontent(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$getArray = array();
		$choiceid = $bsiCore->ClearInput($_POST['choiceid']);
		$result = mysql_query("select * from bsi_email_contents where id='".$choiceid."'");
		if(mysql_num_rows($result)){
			$getEmailcontentlist=mysql_fetch_assoc($result);
			$email = $getEmailcontentlist['email_subject'];
			$emailText = $getEmailcontentlist['email_text'];
			$getArray['email'] = $email;
			$getArray['emailText'] = $emailText;
			echo json_encode(array("errorcode"=>$errorcode,"viewcontent"=>$getArray['email'],"viewcontent1"=>$choiceid, "viewcontent2"=>$getArray['emailText']));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no  result found ";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	public function generatePriceplanList(){
		global $bsiCore;
		$errorcode	= 0;
		$strmsg	= "";
		$pphtml='';
		$roomtype_id = $bsiCore->ClearInput($_POST['roomtype_id']);
		$daterange = mysql_query("select start_date, end_date, DATE_FORMAT(start_date, '".$bsiCore->userDateFormat."') AS start_date1, DATE_FORMAT(end_date, '".$bsiCore->userDateFormat."') AS end_date1, default_plan from bsi_priceplan where roomtype_id='".$roomtype_id."' group by start_date, end_date");
		
		  if(mysql_num_rows($daterange)){
			while($row_daterange = mysql_fetch_assoc($daterange)){
				$query = mysql_query("select bp.*, bc.title from bsi_priceplan as bp, bsi_capacity as bc where start_date='".$row_daterange['start_date']."' and end_date='".$row_daterange['end_date']."' and roomtype_id='".$roomtype_id."' and bp.capacity_id=bc.id");
				  
				  if($row_daterange['default_plan']==1){  				
				  $pphtml.='<tr class=odd style="background:#ffffff;">
    <td align="left" colspan="12"><b><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif" size="2">'.PP_REGULAR.'</font></b></td></tr>
	<tr class=odd bgcolor="#f7f1f1">
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.PP_CAPACITY.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.SUN.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.MON.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.TUE.'</font></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.WED.'</font></td>    
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.THU.'</font></td>  
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.FRI.'</font></td> 
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.SAT.'</font></b></td>
									<td align="left" width="90px" colspan="2"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></b></td><td></td>
								</tr>';		
					$daletetd=mysql_num_rows($query);	
					$i1=$daletetd;			
					  while($row_pp=mysql_fetch_assoc($query)){
						   $pphtml.='<tr class=odd  bgcolor="#E8E8E8">
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$row_pp['title'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</font></td>    
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</font></td>  
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</font></td> 
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</font></td>
									<td align="left" width="90px" colspan="2" style="padding-left:10px;"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"><a href="add_edit_priceplan.php?rtype='.$row_pp['plan_id'].'&start_dt='.$row_pp['start_date'].'">'.EDIT_ROOM_LIST.'</a></font></b></td>';
								if($daletetd==$i1){	
								 $pphtml.='<td rowspan="'.$daletetd.'" width="90px"></td>';
								 $pphtml.='</tr>';
								}
					  
						$i1--;
						}	
				  }else{
					  $pphtml.='<tr class=odd style="background:#ffffff;">
    <td align="left"  colspan="12"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="2">Date Range : '.$row_daterange['start_date1'].'&nbsp; To &nbsp;'.$row_daterange['end_date1'].'</font></b></td></tr><tr class=odd bgcolor="#f7f1f1">
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.PP_CAPACITY.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.SUN.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.MON.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.TUE.'</font></b></td>
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.WED.'</font></b></td>    
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.THU.'</font></b></td>  
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.FRI.'</font></b></td> 
									<td align="left" width="70px"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.SAT.'</font></b></td>
									<td align="left" width="90px" colspan="2"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></b></td><td></td>
								</tr>';
								
					  
					$daletetd=mysql_num_rows($query);		
					$i1=$daletetd;
				      while($row_pp=mysql_fetch_assoc($query)){
						  $pphtml.='<tr class=odd bgcolor="#E8E8E8">
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$row_pp['title'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sun'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['mon'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['tue'].'</font></td>
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['wed'].'</font></td>    
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['thu'].'</font></td>  
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['fri'].'</font></td> 
									<td align="left" width="70px"><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1">'.$bsiCore->config['conf_currency_symbol'].$row_pp['sat'].'</font></td>
									<td align="left" width="90px" colspan="2" style="padding-left:10px;"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"><a href="add_edit_priceplan.php?rtype='.$row_pp['plan_id'].'&start_dt='.$row_pp['start_date'].'">'.EDIT_ROOM_LIST.'</a> </font></b></td>';
									if($daletetd==$i1){
									$pln_del=$row_pp['plan_id'].'|'.$row_pp['start_date'].'|'.$row_pp['end_date'].'|'.$row_pp['roomtype_id'];
									$pln_del=base64_encode($pln_del);
									$pphtml.='<td align="center" width="90px" rowspan="'.$daletetd.'" style="padding-left:10px;"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="javascript:;" onclick="return priceplandelete(\''.$pln_del.'\');">'.DELETE_ROOM_LIST.'</a></font></b></td>';
									}
									
								$pphtml.='</tr>';
								
								$i1--;
						}	
				  }
			  
		 	}
		 	echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$pphtml));	
		 }else{
			$errorcode	= 1;
			 $strmsg	= "No  data found !";
			 echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$strmsg));	
		 }
	}
	
	public function getdefaultcapacity(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$roomtype_id = $bsiCore->ClearInput($_POST['roomtype_id']);	
		$capacity_sql = mysql_query("select * from bsi_capacity");
		if(mysql_num_rows($capacity_sql)){
			$capacity_input_box = 
			'<table cellpadding="3" cellspacing="0" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;" width="750px;">
				<tr>
					<td width="85px" style="padding-left:5px;"><strong>'.PP_CAPACITY.'</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>'.SUN.'</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>'.MON.'</strong></td>
					<td width="75px" style="padding-left:10px;"><strong>'.TUE.'</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>'.WED.'</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>'.THU.'</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>'.FRI.'</strong></td>
					<td width="80px" style="padding-left:10px;"><strong>'.SAT.'</strong></td>
				</tr>
				<tr><td colspan="8"><hr/></td></tr>';
					
			while($row = mysql_fetch_assoc($capacity_sql)){
			$priceplan_sql = mysql_query("SELECT * FROM `bsi_priceplan` WHERE roomtype_id='".$roomtype_id."' and capacity_id='".$row['id']."'");		
			if(mysql_num_rows($priceplan_sql)){
				$priceplan_row = mysql_fetch_assoc($priceplan_sql);
				$capacity_input_box.=
				'<tr>
<td>'.$row['title'].' ('.$row['capacity'].') &nbsp;</td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][sun]" id="priceplan['.$row['id'].'][sun]"  size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][mon]" id="priceplan['.$row['id'].'][mon]"  size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][tue]" id="priceplan['.$row['id'].'][tue]"  size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][wed]" id="priceplan['.$row['id'].'][wed]"  size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][thu]" id="priceplan['.$row['id'].'][thu]"  size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][fri]" id="priceplan['.$row['id'].'][fri]"  size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][sat]" id="priceplan['.$row['id'].'][sat]"  size="4" /></td>
				</tr>';
		}else{
			  $capacity_input_box.=
				'<tr>
<td>'.$row['title'].' ('.$row['capacity'].') &nbsp;</td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][sun]" id="priceplan['.$row['id'].'][sun]" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][mon]" id="priceplan['.$row['id'].'][mon]" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][tue]" id="priceplan['.$row['id'].'][tue]" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][wed]" id="priceplan['.$row['id'].'][wed]" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][thu]" id="priceplan['.$row['id'].'][thu]" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][fri]" id="priceplan['.$row['id'].'][fri]" size="4" /></td>
<td>'.$bsiCore->config['conf_currency_symbol'].'<input type="text" class="required number"  name="priceplan['.$row['id'].'][sat]" id="priceplan['.$row['id'].'][sat]" size="4" /></td></tr>';
			}
		}
			$capacity_input_box.='</table><br><table width="100%">
					<tr><td width="100"></td><td><input type="submit" id="submit-priceplan" value="'.ADD_EDIT_SUBMIT.'" style="background: #EFEFEF;"/></td></tr>
					<tr><td colspan="2"><font color="#FF0000"><b>*</b></font>  &nbsp;&nbsp;&nbsp;'.PP_REQUIRED.'</td></tr> 
					<tr><td colspan="2"><font color="#FF0000"><b>**</b></font> &nbsp;'.PP_ONLY_NUM.'</td></tr>
				</table>';
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$capacity_input_box));							
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! Room Type does not exist!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
		}
	
	}
	
	public function getDeposit()
	{
	    global $bsiCore;
		$errorcode = 0;
		$getddresult="";
		$type=$_POST['type'];
		$deposit_discount_result=mysql_query("SELECT * FROM bsi_advance_payment");
		
		switch($type){
			
			case 2:
			    $chk_deposit =$_POST['chk_deposit'];	
				if($chk_deposit=='true' ){
					 while($getrowresult=mysql_fetch_assoc($deposit_discount_result)){
						 	$getddresult.='<tr><td style="width:100px;"><strong>'.constant(strtoupper($getrowresult['month'])).'</strong></td><td><input type="text" name="'.$getrowresult['month_num'].'" value="'.$getrowresult['deposit_percent'].'" class="required number" style="width:70px;"/>% '.OF_TOTAL_AMT.'</td></tr>';
					 }
					$getddresult.='<tr><td></td><td><input type="submit" value="'.UPDATE.'" name="act_save"  style="background:#e5f9bb; cursor:pointer; cursor:hand;"/></td></tr>';
mysql_query("update bsi_configure set conf_value='1' where conf_key='conf_enabled_deposit'");					 
				 }else{
					     mysql_query("update bsi_configure set conf_value='0' where conf_key='conf_enabled_deposit'");
					 	$getddresult.='<tr><td colspan="2">'.ADV_PP_DESABLED.'</td></tr>';
				 }
				 
			break;
			
		}  
	
									
	 echo  json_encode(array("errorcode"=>$errorcode,"getresult"=>$getddresult)); 
	
	
	}
	
	public function genearateCapacityCombo(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$roomtype = $bsiCore->ClearInput($_POST['roomtype']);
		$result = mysql_query("select distinct br.capacity_id, bc.title from bsi_room br, bsi_capacity bc where roomtype_id=".$roomtype." and bc.id=br.capacity_id");
		if(mysql_num_rows($result)){
			$chtml = '<select name="capacity_id" id="capacity_id"><option value="0">All Capacity</option>';
			while($row = mysql_fetch_assoc($result)){
				$chtml .= '<option value="'.$row['capacity_id'].'">'.$row['title'].'</option>';
			}
		    $chtml .= '</select>'; 
			echo json_encode(array("errorcode"=>$errorcode,"chtml"=>$chtml));
		}else{
			$errorcode = 1;
			$strmsg = '<font style="color:#F00;">No Room Found For This Roomtype</font>';
			echo json_encode(array("errorcode"=>$errorcode,"chtml"=>$strmsg)); 
		}
	}	
}
?>