<?php require_once('../Connections/zalongwa.php'); ?>
<?php
require_once('../Connections/sessioncontrol.php');
# include the header
include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Accommodation';
	$szTitle = 'Room Allocation Form';
	$szSubSection = 'Allocation Form';
	include("admissionheader.php");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
?>

<?php
mysqli_select_db($zalongwa,$database_zalongwa);
$query_year = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$year = mysqli_query($zalongwa,$query_year) or die(mysqli_error());
$row_year = mysqli_fetch_assoc($year);
$totalRows_year = mysqli_num_rows($year);

mysqli_select_db($zalongwa,$database_zalongwa);
$query_hostel = "SELECT HID, HName FROM hostel ORDER BY HName ASC";
$hostel = mysqli_query($zalongwa,$query_hostel) or die(mysqli_error());
$row_hostel = mysqli_fetch_assoc($hostel);
$totalRows_hostel = mysqli_num_rows($hostel);


?>

<form name="form1" method="post" action="<?php echo $editFormAction; ?>">
  <table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <caption align="left">&nbsp;
    </caption>
    <tr>
      <th scope="row"><div align="right">Year:</div></th>
      <td><select name="cmbYear" id="cmbYear">
	  <option value="0">[Select Year]</option>
        <?php
do {  
?>
        <option value="<?php echo $row_year['AYear']?>"><?php echo $row_year['AYear']?></option>
        <?php
} while ($row_year = mysqli_fetch_assoc($year));
  $rows = mysqli_num_rows($year);
  if($rows > 0) {
      mysqli_data_seek($year, 0);
	  $row_year = mysqli_fetch_assoc($year);
  }
?>
      </select></td>
    </tr>
    <tr>
      <th scope="row"><div align="right">Hostel:</div></th>
      <td><select name="cmbHostel" id="cmbHostel">
	  <option value="0">[Select Hostel]</option>
        <?php
do {  
?>
        <option value="<?php echo $row_hostel['HID']?>"><?php echo $row_hostel['HName']?></option>
        <?php
} while ($row_hostel = mysqli_fetch_assoc($hostel));
  $rows = mysqli_num_rows($hostel);
  if($rows > 0) {
      mysqli_data_seek($hostel, 0);
	  $row_hostel = mysqli_fetch_assoc($hostel);
  }
?>
                  </select></td>
    </tr>
	<tr>
	  <td><strong>Canidate</strong>:</td>
		<td><input name="candidate" type="text" id = "candidate" value="" size = "25" maxlength="20"></td>
	</tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input name="action" type="submit" id="Submit" value="Next Step"></td>
    </tr>
  </table>
</form>
<?php
if ((isset($_POST["action"])) && ($_POST["action"] == "Next Step")) {
//get posted variables
$year=$_POST['cmbYear'];
$hostel_ID=$_POST['cmbHostel'];
$regno=$_POST['candidate'];

//get student list
mysqli_select_db($zalongwa,$database_zalongwa);
$query_candidate = "SELECT Name, RegNo FROM student WHERE RegNo='$regno' ORDER BY RegNo ASC";
$candidate = mysqli_query($zalongwa,$query_candidate) or die(mysqli_error());
$row_candidate = mysqli_fetch_assoc($candidate);
$totalRows_candidate = mysqli_num_rows($candidate);

//get room capacity
mysqli_select_db($zalongwa,$database_zalongwa);
$query_room = "SELECT hostel.HID,
				   hostel.HName,
				   room.RNumber,
				   room.Capacity,
				   room.BID
				FROM room
				   INNER JOIN hostel ON (room.HID = hostel.HID)
				 WHERE hostel.HID = '$hostel_ID' ORDER BY room.RNumber";
$dbroom = mysqli_query($zalongwa,$query_room) or die(mysqli_error());
//$row_room = mysql_fetch_assoc($room);
//$totalRows_room = mysql_num_rows($room);

?>
<form name= "allocation" action="<?php echo $editFormAction; ?>" method="post">
<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <th scope="col">Candidate</th>
	<th scope="col">Year</th>
    <th scope="col">Hostel</th>
    <th scope="col">Block</th>
	<th scope="col">Room</th>
 
  </tr>
  <?php
  while($row_rooms = mysqli_fetch_assoc($dbroom)) {
			$capacity = $row_rooms['Capacity'];
			$room = $row_rooms['RNumber'];
			
						//get allocated students
					mysqli_select_db($zalongwa,$database_zalongwa);
					$query_allocated = "SELECT allocation.HID,
						   allocation.RNumber,
						   allocation.RegNo,
						   allocation.AYear,
						   student.Name
					FROM allocation
					   INNER JOIN student ON (allocation.RegNo = student.RegNo)
					   WHERE (allocation.AYear = '$year') AND allocation.HID='$hostel_ID' AND allocation.RNumber = '$room'";
					$allocated = mysqli_query($zalongwa,$query_allocated) or die(mysqli_error());
					$row_allocated = mysqli_fetch_assoc($allocated);
					$totalRows_allocated = mysqli_num_rows($allocated);
			
			for ($j=1; $j<=$capacity; $j++) {
  ?>
  <tr>
    <td><input name="year[]" type="hidden" id="year[]" value="<?php echo $year; ?>"><?php echo $year; ?></td>
    <td nowrap><input name="hostel[]" type="hidden" id="hostel[]" value="<?php echo $row_rooms['HID']; ?>"><?php echo $row_rooms['HName']; ?></td>
    <td nowrap><input name="block[]" type="hidden" id="block[]" value="<?php echo $row_rooms['BID']; ?>"><?php echo $row_rooms['BID']; ?></td>
    <td><input name="room[]" type="hidden" id="room[]" value="<?php echo $room; ?>"><?php echo $room; ?></td>
    <td><select name="candidate[]" id="candidate[]">
      <?php
	 ?>
      <option value="<?php echo $row_allocated['RegNo']?>"><?php echo $row_allocated['RegNo'].": ".$row_allocated['Name']?></option>
	  <?php
do {  
?>
      <option value="<?php echo $row_candidate['RegNo']?>"><?php echo $row_candidate['RegNo'].": ".$row_candidate['Name']?></option>
      <?php
} while ($row_candidate = mysqli_fetch_assoc($candidate));
  $rows = mysqli_num_rows($candidate);
  if($rows > 0) {
      mysqli_data_seek($candidate, 0);
	  $row_candidate = mysqli_fetch_assoc($candidate);
  }
?>
    </select></td>
  </tr>
  <?php
  }//end for loop
 }//end while loop
?>
  <tr>
    <td colspan="4"><input name="action" type="submit" id="action" value="Save Allocation"></td>
    </tr>
</table>

</form>
<?php } ?>
<?php
mysqli_free_result($year);

mysqli_free_result($hostel);

mysqli_free_result($candidate);
?>

