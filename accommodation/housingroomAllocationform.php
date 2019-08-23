<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Accommodation';
	$szSubSection = 'Allocation Form';
	$szTitle = 'Room Allocation Form';
	include('admissionheader.php');
	$today = date("Y-m-d");

//control form display
mysqli_select_db($zalongwa,$database_zalongwa);
$query_AcademicYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AcademicYear = mysqli_query($zalongwa,$query_AcademicYear) or die(mysqli_error());
$row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
$totalRows_AcademicYear = mysqli_num_rows($AcademicYear);

mysqli_select_db($zalongwa,$database_zalongwa);
$query_Hostel = "SELECT HID, HName FROM hostel";
$Hostel = mysqli_query($zalongwa,$query_Hostel) or die(mysqli_error());
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);


if (isset($_POST["MM_search"]) && $_POST["MM_search"] == 'room'){
	//get the posted values
	$ayear=addslashes($_POST['ayear']);
	$hall = addslashes($_POST['Hall']);
	
	//create array of all rooms from this hostel
	$qroom = "SELECT HID, RNumber, Capacity FROM room WHERE HID='$hall'";
	$dbroom = mysqli_query($zalongwa,$qroom);
	$roomcount = mysqli_num_rows($dbroom);

	if($roomcount>0){
	//print report
	$qhall = "select HName from hostel where HID='$hall'";
	$dbhall = mysqli_query($zalongwa,$qhall);
	$row_hall = mysqli_fetch_assoc($dbhall);
	$hallname = $row_hall['HName'];
	echo"$ayear Vacant Beds Report for Hostel '$hallname'";
		?>
<table width="200" border="1" cellspacing="0" cellpadding="0">
						  <tr>
							<td>S/No</td>
							<td>Hostel/Hall</td>
							<td nowrap>Room Number</td>
							<td>Capacity</td>
							<td>Vacants</td>
						  </tr>
		<?php
		$i=0;
				//compare allocated students and room capacity
		while($row_room=mysqli_fetch_array($dbroom)){
				$room = $row_room['RNumber'];
				$capacity = intval($row_room['Capacity']);
				$qstudent = "SELECT RegNo FROM allocation WHERE HID='$hall' AND RNumber='$room' AND AYear='$ayear' AND CheckOut>'$today'";
				$dbstudent=mysqli_query($zalongwa,$qstudent);
				$totalstudent=mysqli_num_rows($dbstudent);
				$vacant = $capacity - $totalstudent;
				if($vacant>0){
				//increment the serial #
				$i=$i+1;
				?>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td nowrap><?php echo $hallname ?></td>
                    <?php echo "<td nowrap><a href=\"housingroomAllocationform.php?id=$room&hostel=$hall&ayear=$ayear\">$room</a></td>";?> 
                    <td><div align="center"><?php echo $capacity ?></div> </td>
                    <td><div align="center"><?php echo vacant?></div></td>
                  </tr>
				<?php
				}
		}
		?>
</table>
		<?php
	}
}elseif(isset($_POST['save'])){
//get posted values
$hall = addslashes($_POST['hostel']);
$room = addslashes($_POST['room']);
$regno = addslashes($_POST['regno']);

$ayear = addslashes($_POST['ayear']);
$checkin = addslashes($_POST['checkin']);
$checkout = addslashes($_POST['checkout']);

if ($checkout==''){
echo 'Please Enter Checkout Date';
exit;
}
if ($checkin==''){
echo 'Please Enter Checkin Date';
exit;
}

if ($checkin>$checkout){
echo 'Checkout Date is Older than Checkin Date!';
exit;
}

if ($regno==''){
echo 'Please Enter RegNo !';
exit;
}

//validate this regno
$qregno =  "select Name, RegNo from student where RegNo='$regno'";
$dbregno=mysqli_query($zalongwa,$qregno);
if(mysqli_num_rows($dbregno)>0){
//check if the room is empty
		$qroom = "SELECT HID, RNumber, Capacity FROM room WHERE HID='$hall' AND RNumber='$room'";
		$dbroom = mysqli_query($zalongwa,$qroom);
		$row_room=mysqli_fetch_array($dbroom);
		$room = $row_room['RNumber'];
		$capacity = intval($row_room['Capacity']);
		$qstudent = "SELECT RegNo FROM allocation WHERE HID='$hall' AND RNumber='$room' AND AYear='$ayear' AND CheckOut>'$today'";
		$dbstudent=mysqli_query($zalongwa,$qstudent);
		$totalstudent=mysqli_num_rows($dbstudent);
		$vacant = $capacity - $totalstudent;
		if($vacant>0){
			//save entries
			$qsave = "INSERT INTO allocation(HID,RNumber,RegNo,AYear,CheckOut,CheckIn) VALUES('$hall','$room','$regno','$ayear','$checkout','$checkin')";
			mysqli_query($zalongwa,$qsave) or die(mysqli_error().'<br>This Candidate has a Room already!, <br>');//die('Kuna tatizo la kiufundi');
		}
//display room list
	//create array of all rooms from this hostel
	$qroom = "SELECT HID, RNumber, Capacity FROM room WHERE HID='$hall'";
	$dbroom = mysqli_query($zalongwa,$qroom);
	$roomcount = mysqli_num_rows($dbroom);

	if($roomcount>0){
	//print report
	$qhall = "select HName from hostel where HID='$hall'";
	$dbhall = mysqli_query($zalongwa,$qhall);
	$row_hall = mysqli_fetch_assoc($dbhall);
	$hallname = $row_hall['HName'];
	echo"$ayear Vacant Beds Report for Hostel '$hallname'";
		?>
	<table width="200" border="1" cellspacing="0" cellpadding="0">
						  <tr>
							<td>S/No</td>
							<td>Hostel/Hall</td>
							<td nowrap>Room Number</td>
							<td>Capacity</td>
							<td>Vacants</td>
						  </tr>
		<?php
		$i=0;
				//compare allocated students and room capacity
		while($row_room=mysqli_fetch_array($dbroom)){
				$room = $row_room['RNumber'];
				$capacity = intval($row_room['Capacity']);
				$qstudent = "SELECT RegNo FROM allocation WHERE HID='$hall' AND RNumber='$room' AND AYear='$ayear' AND CheckOut>'$today'";
				$dbstudent=mysqli_query($zalongwa,$qstudent);
				$totalstudent=mysqli_num_rows($dbstudent);
				$vacant = $capacity - $totalstudent;
				if($vacant>0){
				//increment the serial #
				$i=$i+1;
				?>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td nowrap><?php echo $hallname ?></td>
                    <? echo "<td nowrap><a href=\"housingroomAllocationform.php?id=$room&hostel=$hall&ayear=$ayear\">$room</a></td>";?> 
                    <td><div align="center"><?php echo $capacity ?></div> </td>
                    <td><div align="center"><?php echo $vacant ?></div></td>
                  </tr>
				<?php
				}
		}
	}
		?>
</table>
<?php
}
else{
 echo "$regno, is an Invalid Candidate RegNo !<hr>";
 //display the form again
 ?>
 <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="save" target="_self">
Room Allocation:  <?php echo $ayear ?>
<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td><strong>Hostel:</strong></td>
    <td><input name="hostel" type="hidden" value="<?php echo $hall ?>">
	<?php
	$qhall = "select HName from hostel where HID='$hall'";
	$dbhall = mysqli_query($zalongwa,$qhall);
	$row_hall = mysqli_fetch_assoc($dbhall);
	echo $row_hall['HName'];
	?>
	<input name="ayear" type="hidden" value="<?php echo $ayear?>"></td>
  </tr>
  <tr>
    <td><strong>Room:</strong></td>
    <td><input name="room" type="hidden" value="<?php echo $room?>"><?php echo $room?></td>
  </tr>
  <tr>
    <td><strong>RegNo:</strong></td>
    <td><input name="regno" type="text" maxlength="20"></td>
  </tr>
  <tr>
    <td><strong>CheckIN:</strong></td>
	<!-- A Separate Layer for the Calendar -->
	<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>    
	<td><input name="checkin" type="text" maxlength="20" value=<?php echo $today ?>></td>
	<td><input type="button" class="button" name="dtDate_button" value="Calendar" onClick="show_calendar('save.checkin', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')"></td>
  </tr>
  <tr>
    <td><strong>CheckOUT:</strong></td>
    <td><input name="checkout" type="text" maxlength="20" value="
<?php $date = date('Y-m-d', strtotime("+6 months")); echo $date?>"></td>
	<td><input type="button" class="button" name="dtDate_button" value="Calendar" onClick="show_calendar('save.checkout', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')"></td>
  </tr>
  <tr>
    <td></td>
    <td><input name="save" type="submit" value="Update"></td>
  </tr>
</table>
</form>
 <?php
}
}elseif(isset($_GET['id'])){
//received get values
$room = addslashes($_GET['id']);
$hall = addslashes($_GET['hostel']);
$ayear = addslashes($_GET['ayear']);

//create a room allocation form
?>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="save" target="_self">
Room Allocation:  <?php echo $ayear?>
<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td><strong>Hostel:</strong></td>
    <td><input name="hostel" type="hidden" value="<?php echo $hall?>"><?
	$qhall = "select HName from hostel where HID='$hall'";
	$dbhall = mysqli_query($zalongwa,$qhall);
	$row_hall = mysqli_fetch_assoc($dbhall);
	echo $row_hall['HName'];
	?><input name="ayear" type="hidden" value="<?php echo $ayear?>"></td>
  </tr>
  <tr>
    <td><strong>Room:</strong></td>
    <td><input name="room" type="hidden" value="<?php echo $room?>"><?php echo $room?></td>
  </tr>
  <tr>
    <td><strong>RegNo:</strong></td>
    <td><input name="regno" type="text" maxlength="20"></td>
  </tr>
  <tr>
    <td><strong>CheckIN:</strong></td>
	<!-- A Separate Layer for the Calendar -->
	<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>
    <td><input name="checkin" type="text" maxlength="20" value=<?php echo $today ?>></td>
	<td><input type="button" class="button" name="dtDate_button" value="Calendar" onClick="show_calendar('save.checkin', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')"></td>
  </tr>
  <tr>
    <td><strong>CheckOUT:</strong></td>
    <td><input name="checkout" type="text" maxlength="20" value="
<?php $date = date('Y-m-d', strtotime("+6 months")); echo $date?>"></td>
	<td><input type="button" class="button" name="dtDate_button" value="Calendar" onClick="show_calendar('save.checkout', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')"></td>

  </tr>
  <tr>
    <td></td>
    <td><input name="save" type="submit" value="Update"></td>
  </tr>
</table>
</form>

<?php

}else{
?>
                <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" name="housingvacantRoom" id="housingvacantRoom">
            <fieldset bgcolor="#CCCCCC">
				<legend>Search Vacant Rooms</legend>
			<table width="284" border="0" bgcolor="#CCCCCC">
        <tr>
          <td width="111" nowrap><div align="right"></div></td>
          <td width="157" bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
          </span></td>
        </tr>
        <tr>
          <td nowrap><div align="right">Academic Year: </div></td>
          <td bgcolor="#CCCCCC"><select name="ayear" id="select2">
		  <option value="0">SelectAcademicYear</option>
            <?php
do {  
?>
            <option value="<?php echo $row_AcademicYear['AYear']?>"><?php echo $row_AcademicYear['AYear']?></option>
            <?php
} while ($row_AcademicYear = mysqli_fetch_assoc($AcademicYear));
  $rows = mysqli_num_rows($AcademicYear);
  if($rows > 0) {
      mysqli_data_seek($AcademicYear, 0);
	  $row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td nowrap><div align="right"> Hall/Hostel:</div></td>
          <td bgcolor="#CCCCCC"><select name="Hall" id="select">
		  <option value="0">Select Student Hostel</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Hostel['HID']?>"><?php echo $row_Hostel['HName']?></option>
              <?php
} while ($row_Hostel = mysqli_fetch_assoc($Hostel));
  $rows = mysqli_num_rows($Hostel);
  if($rows > 0) {
      mysqli_data_seek($Hostel, 0);
	  $row_Hostel = mysqli_fetch_assoc($Hostel);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td colspan="2" nowrap><div align="center">
            <input type="submit" name="Submit" value="Search Rooms">
          </div></td>
          </tr>
      </table>
	  </fieldset>
                    <input type="hidden" name="MM_search" value="room">
          </form>
<?php
}
# include the footer
	include('../footer/footer.php');
?>
