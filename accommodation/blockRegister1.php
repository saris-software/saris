<?php require_once('../Connections/zalongwa.php'); 
require_once('../Connections/sessioncontrol.php');
# include the header
include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Hostel Blocks Information';
	$szSubSection = 'Block Register';
	include("admissionheader.php");
	
	
$currentPage = $_SERVER["PHP_SELF"];

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

mysqli_select_db($zalongwa,$database_zalongwa);
$query_Hostel = "SELECT HID, HName FROM hostel";
$Hostel = mysqli_query($zalongwa,$query_Hostel) or die(mysqli_error());
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);

//control the display table
@$new=2;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
  $insertSQL = sprintf("INSERT INTO block (HID, BName, Capacity, NoofRooms, NoofFloors) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cmbHall'], "text"),
                       GetSQLValueString($_POST['txtBlock'], "text"),
                       GetSQLValueString($_POST['txtCapacity'], "text"),
                       GetSQLValueString($_POST['txtTrm'], "text"),
                       GetSQLValueString($_POST['txtTfr'], "text"));

  mysqli_select_db($zalongwa,$database_zalongwa);
  $Result1 = mysqli_query($zalongwa,$insertSQL) or die(mysqli_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
  $updateSQL = sprintf("UPDATE block SET BName=%s, Capacity=%s, NoofRooms=%s, NoofFloors=%s WHERE Id=%s",
                       GetSQLValueString($_POST['txtBlock'], "text"),
                       GetSQLValueString($_POST['txtCapacity'], "text"),
                       GetSQLValueString($_POST['txtTrm'], "text"),
                       GetSQLValueString($_POST['txtTfr'], "text"),
                       GetSQLValueString($_POST['Id'], "text"));

  mysqli_select_db($zalongwa,$database_zalongwa);
  $Result1 = mysqli_query($zalongwa,$updateSQL);

  $updateGoTo = "blockRegister.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_inst = 10;
$pageNum_inst = 0;
if (isset($_GET['pageNum_inst'])) {
  $pageNum_inst = $_GET['pageNum_inst'];
}
$startRow_inst = $pageNum_inst * $maxRows_inst;

mysqli_select_db($zalongwa,$database_zalongwa);
//the query was again inconsistent, Id field is unknown in the table
//$query_inst = "SELECT Id, HID, BName, NoofRooms, Capacity, NoofFloors FROM block ORDER BY HID ASC";
$query_inst = "SELECT HID, BName, NoofRooms, Capacity, NoofFloors FROM block ORDER BY HID ASC";
$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
$inst = mysqli_query($zalongwa,$query_limit_inst);
$row_inst = mysqli_fetch_assoc($inst);

if (isset($_GET['totalRows_inst'])) {
  $totalRows_inst = $_GET['totalRows_inst'];
} else {
  $all_inst = mysqli_query($zalongwa,$query_inst);
  $totalRows_inst = mysqli_num_rows($all_inst);
}
$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;

?>
<style type="text/css">
<!--

.style1 {color: #FFFFFF}
-->
</style>


<p><?php echo "<a href=\"blockRegister.php?new=1\">"?>Add New Block</a> </p>
<? @$new=$_GET['new'];
if (@$new<>1){
?>

<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td><strong>Code</strong></td>
    <td><strong>Block Name</strong></td>
    <td><strong>Capacity</strong></td>
    <td><strong>Total Rooms </strong></td>
    <td><strong>Total Floors </strong></td>
  </tr>
  <?php do { ?>
  <tr>
    <td nowrap><?php $id = $row_inst['Id']; $name = $row_inst['HID'];
	echo "<a href=\"blockRegister.php?edit=$id\">$name</a>"?></td>
    <td nowrap><?php echo $row_inst['BName']; ?></td>
    <td><?php echo $row_inst['Capacity']; ?></td>
    <td><?php echo $row_inst['NoofRooms']; ?></td>
    <td><?php echo $row_inst['NoofFloors']; ?></td>
  </tr>
  <?php } while ($row_inst = mysqli_fetch_assoc($inst)); ?>
</table>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1">.............</span><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> <span class="style1">..............</span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
<? }else{?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
  <table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
    <tr bgcolor="#CCCCCC">
      <th scope="row"><div align="right">Hostel Name:</div></th>
      <td bgcolor="#CCCCCC"><select name="cmbHall" id="cmbHall">
				  <option value="0">Select Hostel</option>
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
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Block  Name:</div></th>
      <td><input name="txtBlock" type="text" id="txtBlock" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Capacity: </div></th>
      <td><input name="txtCapacity" type="text" id="txtCapacity" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Total Rooms:</div></th>
      <td><input name="txtTrm" type="text" id="txtTrm" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Total Floors:</div></th>
      <td><input name="txtTfr" type="text" id="txtTfr" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row">&nbsp;</th>
      <td><div align="center">
        <input type="submit" name="Submit" value="Add Record">
      </div></td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="frmInst">
</form>
<?php } 
if (isset($_GET['edit'])){
#get post variables
$key = $_GET['edit'];
mysqli_select_db($zalongwa,$database_zalongwa);
$query_instEdit = "SELECT * FROM block WHERE Id ='$key'";
$instEdit = mysqli_query($zalongwa,$query_instEdit);
$row_instEdit = mysqli_fetch_assoc($instEdit);
$totalRows_instEdit = mysqli_num_rows($instEdit);

$queryString_inst = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_inst") == false && 
        stristr($param, "totalRows_inst") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_inst = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_inst = sprintf("&totalRows_inst=%d%s", $totalRows_inst, $queryString_inst);
?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInstEdit" id="frmInstEdit">
  <table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Hostel Code:</div></th>
      <td><?php echo $row_instEdit['HID']; ?><input name="Id" type="hidden" id="Id"value="<?php echo $row_instEdit['Id']; ?>"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Block Name:</div></th>
      <td><input name="txtBlock" type="text" id="txtBlock" value="<?php echo $row_instEdit['BName']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Capacity: </div></th>
      <td><input name="txtCapacity" type="text" id="txtCapacity" value="<?php echo $row_instEdit['Capacity']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Total Rooms:</div></th>
      <td><input name="txtTrm" type="text" id="txtTrm" value="<?php echo $row_instEdit['NoofRooms']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Total Floors:</div></th>
      <td><input name="txtTfr" type="text" id="txtTfr" value="<?php echo $row_instEdit['NoofFloors']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><input name="id" type="hidden" id="id" value="<?php echo $key ?>"></th>
      <td><div align="center">
        <input type="submit" name="edit" value="Edit Record">
      </div></td>
    </tr>
  </table>
      <input type="hidden" name="MM_update" value="frmInstEdit">
</form>
  <?php
}
	# include the footer
	include("../footer/footer.php");

@mysqli_free_result($inst);

@mysqli_free_result($instEdit);
?>
