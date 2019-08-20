<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Accommodation';
	$szSubSection = 'Vacant Rooms';
	$szTitle = 'Vacant Rooms Report';
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
		?><table width="200" border="1" cellspacing="0" cellpadding="0">
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
				$i=$i+1;
				$room = $row_room['RNumber'];
				$capacity = intval($row_room['Capacity']);
				$qstudent = "SELECT RegNo FROM allocation WHERE HID='$hall' AND RNumber='$room' AND AYear='$ayear' AND CheckOut>'$today'";
				$dbstudent=mysqli_query($zalongwa,$qstudent);
				$totalstudent=mysqli_num_rows($dbstudent);
				$vacant = $capacity - $totalstudent;

				?>
                  <tr>
                    <td><?php echo $i?></td>
                    <td nowrap><?php echo $hallname?></td>
                    <td nowrap><?php echo $room?></td>
                    <td><div align="center"><?php echo $capacity?></div> </td>
                    <td><div align="center"><?php echo $vacant?></div></td>
                  </tr>
				<?php
		}
		?>
		</table>
		<?php
	}
}
else{
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
