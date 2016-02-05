 <?php 
 if(isset($_POST['submit'])){ 
 ?>
          <form name="adminsearchresult" id="adminsearchresult" method="post" action="roomblocking.class.php" >
            <input type="hidden" name="allowlang" id="allowlang" value="no" />
            <table cellpadding="5" cellspacing="2" border="2" width="450px" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
              <tr>
                <th align="left" colspan="2"><b>Search Result (
                  <?=$_POST['check_in']?>
                  to
                  <?=$_POST['check_out']?>
                  ) =
                  <?=$bsisearch->nightCount?>
                  Night(s)</b></th>
              </tr>
              <tr>
                <th valign="middle" width="250px">Room Type</th>
                <th valign="middle">Availability</th>
              </tr>
              <?php
	 	$gotSearchResult = false;
		$idgenrator = 0;
		foreach($bsisearch->roomType as $room_type){
			foreach($bsisearch->multiCapacity as $capid=>$capvalues){			
				$room_result = $bsisearch->getAvailableRooms($room_type['rtid'], $room_type['rtname'], $capid);
				if(intval($room_result['roomcnt']) > 0) {
					$gotSearchResult = true;	
			 ?>
              <tr>
                <td><?=$room_type['rtname']?>
                  (
                  <?=$capvalues['captitle']?>
                  )</td>
                <td><select name="svars_selectedrooms[]" style="width:70px;">
                    <?=$room_result['roomdropdown']?>
                  </select></td>
              </tr>
              <?php 
		$idgenrator++;
	} } } ?>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Block" name="submit" id="submit" style="background: #EFEFEF;"/></td>
              </tr>
            </table>
          </form>
          <? } ?>