<?php require_once('../Connections/zalongwa.php'); ?>
<?php
mysqli_select_db($zalongwa,$database_zalongwa);
$query_Hostel = "SELECT HID, HName FROM hostel ORDER BY HName ASC";
$Hostel = mysqli_query($zalongwa,$query_Hostel) or die(mysqli_error());
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>HID</td>
    <td>HName</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><a href="frmRoomallocationDetail.php?recordID=<?php echo $row_Hostel['HID']; ?>"> <?php echo $row_Hostel['HID']; ?>&nbsp; </a> </td>
    <td><?php echo $row_Hostel['HName']; ?>&nbsp; </td>
  </tr>
  <?php } while ($row_Hostel = mysqli_fetch_assoc($Hostel)); ?>
</table>
<br>
<?php echo $totalRows_Hostel ?> Records Total
</body>
</html>
<?php
mysqli_free_result($Hostel);
?>
