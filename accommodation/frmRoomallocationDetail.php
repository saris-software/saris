<?php require_once('../Connections/zalongwa.php'); ?><?php
mysqli_select_db($zalongwa,$database_zalongwa);
$query_student = "SELECT Name, RegNo FROM student WHERE Status IN ['Continuing', 'Fresher'] ORDER BY RegNo ASC";
$student = mysqli_query($zalongwa,$query_student) or die(mysqli_error());
$row_student = mysqli_fetch_assoc($student);
$totalRows_student = mysqli_num_rows($student);

mysqli_select_db($zalongwa,$database_zalongwa);
$recordID = $_GET['recordID'];
//get hostel name
$query_DetailRS1 = "SELECT HID, HName FROM hostel WHERE HID = '$recordID' ORDER BY HName ASC";
$DetailRS1 = mysqli_query($zalongwa,$query_DetailRS1) or die(mysqli_error());
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
//get Academic Year
$query_DetailRS2 = "SELECT AYear, Status FROM academicyear WHERE Status = '1'";
$DetailRS2 = mysqli_query($zalongwa,$query_DetailRS2) or die(mysqli_error());
$row_DetailRS2 = mysqli_fetch_assoc($DetailRS2);
$totalRows_DetailRS2 = mysqli_num_rows($DetailRS2);

//get variables
$hid=$row_DetailRS1['HID'];

mysqli_select_db($zalongwa,$database_zalongwa);
$query_room = "SELECT RNumber, HID, Capacity FROM room WHERE HID='$hid' ORDER BY RNumber ASC";
$room = mysqli_query($zalongwa,$query_room) or die(mysqli_error());
$row_room = mysqli_fetch_assoc($room);
$totalRows_room = mysqli_num_rows($room);

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
</head>

<body>
		
<table border="1" align="center">
  
  <tr>
    <td>HID</td>
    <td><?php echo $row_DetailRS1['HID']; ?> </td>
  </tr>
  <tr>
    <td>HName</td>
    <td>&nbsp; </td>
  </tr>
  
  
</table>
<form action="" method="post" enctype="multipart/form-data" name="frmRoomallocation" target="_self">
<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col">Hall/Hostel: </th>
    <th scope="col"><?php echo $row_DetailRS1['HName']; ?></th>
    <th scope="col"><?php echo $row_DetailRS2['AYear']; ?></th>
  </tr>
  <tr>
    <td>Candidate</td>
    <td nowrap>Room Number </td>
    <td>Delete</td>
  </tr>
  <tr>
    <td><select name="student" id="student">
      <?php
do {  
?>
      <option value="<?php echo $row_student['RegNo']?>"><?php echo $row_student['RegNo']?></option>
      <?php
} while ($row_student = mysqli_fetch_assoc($student));
  $rows = mysqli_num_rows($student);
  if($rows > 0) {
      mysqli_data_seek($student, 0);
	  $row_student = mysqli_fetch_assoc($student);
  }
?>
    </select></td>
    <td><select name="room" id="room">
      <?php
do {  
?>
      <option value="<?php echo $row_room['RNumber']?>"><?php echo $row_room['RNumber']?>|<?php echo $row_room['Capacity']?></option>
      <?php
} while ($row_room = mysqli_fetch_assoc($room));
  $rows = mysqli_num_rows($room);
  if($rows > 0) {
      mysqli_data_seek($room, 0);
	  $row_room = mysqli_fetch_assoc($room);
  }
?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>

</body>
</html><?php
mysqli_free_result($student);

mysqli_free_result($room);

mysqli_free_result($DetailRS1);
?>
