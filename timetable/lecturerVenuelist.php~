<?php require_once('../Connections/zalongwa.php'); 
require_once('../Connections/sessioncontrol.php');
# include the header
include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Available Venues Information';
	$szSubSection = 'Venues';
	include("lecturerheader.php");
?>
<?php
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

if ($privilege==2){
$currentPage = $_SERVER["PHP_SELF"];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
$rawcode = $_POST['txtCode'];
$rawprog = $_POST['cmbprog'];
$code = ereg_replace("[[:space:]]+", " ",$rawcode);
$prog = ereg_replace("[[:space:]]+", " ",$rawprog);

if(empty($_POST['txtCode']) || empty($_POST['txtTitle']) || empty($_POST['txtUnit']) || empty($_POST['txtCapacity'])){
	$error=urlencode('Please fill all field..');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php?new=1&error='.$error.'">';
	exit;
	
}
if(!preg_match('/^[0-9]+$/', $_POST['txtCapacity'])){
	        $error=urlencode('VenueCapacity Should be a Number');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php?new=1&error='.$error.'">';
	exit;
}
#check if coursecode exist
$sql ="SELECT * FROM venue WHERE (VenueCode  = '".$_POST['txtCode']."' OR VenueName='".$_POST['txtTitle']."')";
$result = mysql_query($sql);
$coursecodeFound = mysql_num_rows($result);
if ($coursecodeFound) {
            $error=urlencode('VenueCode and VenueName should be Unique..');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php?new=1&error='.$error.'">';
	exit;
}else{
	   				   $insertSQL = sprintf("INSERT INTO venue (VenueCode, VenueName, VenueLocation, VenueCapacity) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtCode'], "text"),
                       GetSQLValueString($_POST['txtTitle'], "text"),
                       GetSQLValueString($_POST['txtUnit'], "text"),
			GetSQLValueString($_POST['txtCapacity'], "text"));

  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($insertSQL, $zalongwa) or die(mysql_error());
  if($Result1){
  	 echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php">';
	exit;
  }
  }
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
	
if( empty($_POST['txtTitle']) || empty($_POST['txtUnit']) || empty($_POST['txtCapacity'])){
	$error=urlencode('Please fill all field..');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php?edit='.$_POST['id'].'&error='.$error.'">';
	exit;
	
}
if(!preg_match('/^[0-9]+$/', $_POST['txtCapacity'])){
	        $error=urlencode('VenueCapacity Should be a Number');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php?edit='.$_POST['id'].'&error='.$error.'">';
	exit;
}



#check if coursecode exist
$sql ="SELECT * FROM venue WHERE (VenueCode  = '".$_POST['txtCode']."' OR VenueName='".$_POST['txtTitle']."')";
$result = mysql_query($sql);
$coursecodeFound = mysql_num_rows($result);

$read = mysql_fetch_array($result);
if ($coursecodeFound > 1  || $read['Id'] != $_POST['id'] ) {
            $error=urlencode('VenueCode and VenueName should be Unique..');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php?edit='.$_POST['id'].'&error='.$error.'">';
	exit;
}


 					   $updateSQL = sprintf("UPDATE venue SET VenueName=%s, VenueLocation=%s, VenueCapacity=%s WHERE Id=%s",
                       GetSQLValueString($_POST['txtTitle'], "text"),
					   
                       GetSQLValueString($_POST['txtUnit'], "text"),
                       
                       GetSQLValueString($_POST['txtCapacity'], "text"),
					    GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($updateSQL, $zalongwa) or die(mysql_error());
 if($Result1){
  	 echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php">';
	exit;
  }
 }
 

//control the display table
@$new=2;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$maxRows_inst = 10;
$pageNum_inst = 0;
if (isset($_GET['pageNum_inst'])) {
  $pageNum_inst = $_GET['pageNum_inst'];
}
$startRow_inst = $pageNum_inst * $maxRows_inst;

mysql_select_db($database_zalongwa, $zalongwa);
if (isset($_GET['course'])) {
  $key=$_GET['course'];
  $query_inst = "SELECT * FROM venue WHERE VenueCode Like '%$key%' ORDER BY VenueCode ASC";
}else{
$query_inst = "SELECT * FROM venue ORDER BY VenueCode ASC";
}
//$query_inst = "SELECT * FROM course ORDER BY CourseCode ASC";
$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
$inst = mysql_query($query_limit_inst, $zalongwa) or die(mysql_error());
$row_inst = mysql_fetch_assoc($inst);

if (isset($_GET['totalRows_inst'])) {
  $totalRows_inst = $_GET['totalRows_inst'];
} else {
  $all_inst = mysql_query($query_inst);
  $totalRows_inst = mysql_num_rows($all_inst);
}
$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;

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
<style type="text/css">
<!--
.style1 {color: #000000}
.style2 {color: #FFFFFF}
-->
</style>

<h2 style="font-size:13px;"><?php echo "<a href=\"lecturerVenuelist.php?new=1\">"?>Add New Venue (Class Room) </h2>
<?php @$new=$_GET['new'];
echo "</a>";
if (@$new<>1){
?> 
<form name="form1" method="get" action="lecturerVenuelist.php">
              <table class="resView"><tr> <td class="resViewhd"><em> &nbsp Search by Venue Code </em></td><td class="resViewtd"><input name="course" type="text" id="course" maxlength="50"></td><td>
              <input type="submit" name="Submit" value="Search"onmouseover="this.style.background='#DEFEDE'"
onmouseout="this.style.background='lightblue'" style='background-color:lightblue;color:black;font-size:9pt;font-weight:bold' title="Click to Search the List"></td></tr></table>
</form><br>
	   
<table class="resView">
  <tr>
    <td class="resViewhd">Venue Code</td>
	<td class="resViewhd">Venue Name</td>
	<td class="resViewhd">Venue Location</td>
	<td class="resViewhd">Venue Capacity</td>
	
  </tr>
  <?php do { ?>

  <tr><?php $id = $row_inst['Id'];?>
		
      <td class="resViewtd" nowrap><?php $name = $row_inst['VenueCode']; echo "<a href=\"lecturerVenuelist.php?edit=$id\">$name</a>"?></td>
	  <td class="resViewtd" nowrap><?php echo $row_inst['VenueName'] ?></td>
	  <td class="resViewtd"><?php echo $row_inst['VenueLocation']; ?></td>
	  <td class="resViewtd"><?php echo $row_inst['VenueCapacity']; ?></td>
  </tr>
  <?php } while ($row_inst = mysql_fetch_assoc($inst)); ?>
</table>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1"><span class="style2">......</span><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> <span class="style1"></span><span class="style2">..........</span></span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
    			
<?php }else{ ?>

<br><form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">

  <table class="resView">
<?php  if(isset($_GET['error'])){
	?>
	<tr><td class="resViewhd" colspan="2"><div style="color:red; text-align:center;"><?php echo $_GET['error'];?></div></td></tr>
	<?php  } ?>
    <tr>
      <td class="resViewhd"nowrap scope="row"><div align="right">Venue Code:</div></td>
      <td class="resViewtd"><input name="txtCode" type="text" id="txtTitle" value="<?php echo $row_instEdit['VenueCode']; ?>" size="40"> </td>
    </tr>
    <tr>
      <td class="resViewhd"nowrap scope="row"><div align="right">Venue Name:</div></td>
      <td class="resViewtd"><input name="txtTitle" type="text" id="txtTitle" value="<?php echo $row_instEdit['VenueName']; ?>" size="40"></td>
    </tr>
    <tr>
      <td class="resViewhd" nowrap scope="row"><div align="right">Venue Location:</div></td>
      <td class="resViewtd"><input name="txtUnit" type="text" id="txtUnit" value="<?php echo $row_instEdit['VenueLocation']; ?>" size="40"></td></tr>
     <tr><td class="resViewhd"><font color="#000000"> Venue Capacity:</font></td>
	  <td class="resViewtd"><input name="txtCapacity" type="text" id="txtCapacity" value="<?php echo $row_instEdit['VenueCapacity']; ?>"size="40">
</td>
    </tr>
    
    <tr>
      <th class="resViewhd"scope="row">&nbsp;</th>
      <td class="resViewhd"><div align="center">
        <input type="submit" name="Submit" value="Add Record"onmouseover="this.style.background='#DEFEDE'"
onmouseout="this.style.background='lightblue'" style='background-color:lightblue;color:black;font-size:9pt;font-weight:bold' title="Click to Save Changes">
      </div></td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="frmInst">
</form>
<?php } 
if (isset($_GET['edit'])){
#get post variables
$key = $_GET['edit'];

mysql_select_db($database_zalongwa, $zalongwa);
$query_instEdit = "SELECT * FROM venue WHERE Id ='$key'";
$instEdit = mysql_query($query_instEdit, $zalongwa) or die(mysql_error());
$row_instEdit = mysql_fetch_assoc($instEdit);
$totalRows_instEdit = mysql_num_rows($instEdit);

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
<br><form action="<?php echo $editFormAction; ?>" method="POST" name="frmInstEdit" id="frmInstEdit">
 <table class="resView">
  <?php  if(isset($_GET['error'])){
	?>
	<tr><td class="resViewhd" colspan="2"><div style="color:red; text-align:center;"><?php echo $_GET['error'];?></div></td></tr>
	<?php  } ?>
    <tr>
      <td class="resViewhd"nowrap scope="row"><div align="right">Venue Code:</div></td>
      <td class="resViewtd"><?php echo $row_instEdit['VenueCode']; ?></td>
    </tr>
    <tr>
      <td class="resViewhd"nowrap scope="row"><div align="right">Venue Name:</div></td>
      <td class="resViewtd"><input name="txtTitle" type="text" id="txtTitle" value="<?php echo $row_instEdit['VenueName']; ?>" size="40"></td>
    </tr>
    <tr>
      <td class="resViewhd" nowrap scope="row"><div align="right">Venue Location:</div></td>
      <td class="resViewtd"><input name="txtUnit" type="text" id="txtUnit" value="<?php echo $row_instEdit['VenueLocation']; ?>" size="40"></td></tr>
      <tr><td class="resViewhd"><font color="#000000"> Venue Capacity:</font></td>
	  <td class="resViewtd"><input name="txtCapacity" type="text" id="txtCapacity" value="<?php echo $row_instEdit['VenueCapacity']; ?>"size="40">
</td>
    </tr>
	
    <tr>
      <th class="resViewhd"scope="row"><input name="id" type="hidden" id="id" value="<?php echo $key ?>"></th>
      <td class="resViewhd"><div align="center">
        <input type="submit" name="Submit" value="Edit Record"onmouseover="this.style.background='#DEFEDE'"
onmouseout="this.style.background='lightblue'" style='background-color:lightblue;color:black;font-size:9pt;font-weight:bold' title="Click to Save Changes">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="frmInstEdit">
</form>
<?php
}
echo"<br>";

}else{ 
$currentPage = $_SERVER["PHP_SELF"];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
$rawcode = $_POST['txtCode'];
$rawprog = $_POST['cmbprog'];
$code = ereg_replace("[[:space:]]+", " ",$rawcode);
$prog = ereg_replace("[[:space:]]+", " ",$rawprog);

if(empty($_POST['txtCode']) || empty($_POST['txtTitle']) || empty($_POST['txtUnit']) || empty($_POST['txtCapacity'])){
	$error=urlencode('Please fill all field..');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php?new=1&error='.$error.'">';
	exit;
	
}
if(!preg_match('/^[0-9]+$/', $_POST['txtCapacity'])){
	        $error=urlencode('VenueCapacity Should be a Number');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php?new=1&error='.$error.'">';
	exit;
}

#check if coursecode exist
$sql ="SELECT * FROM venue WHERE (VenueCode  = '".$_POST['txtCode']."' OR VenueName='".$_POST['txtTitle']."')";
$result = mysql_query($sql);
$coursecodeFound = mysql_num_rows($result);
if ($coursecodeFound) {
            $error=urlencode('VenueCode and VenueName should be Unique..');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerVenuelist.php?new=1&error='.$error.'">';
	exit;
}else{
	   				   $insertSQL = sprintf("INSERT INTO venue (VenueCode, VenueName, VenueLocation, VenueCapacity) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtCode'], "text"),
                       GetSQLValueString($_POST['txtTitle'], "text"),
                       GetSQLValueString($_POST['txtUnit'], "text"),
		  	GetSQLValueString($_POST['txtCapacity'], "text"));

  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($insertSQL, $zalongwa) or die('You What? '.mysql_error());
  }
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
 					   $updateSQL = sprintf("UPDATE venue SET VenueName=%s, VenueLocation=%s, VenueCapacity=%s WHERE Id=%s",
                       GetSQLValueString($_POST['txtTitle'], "text"),
					   
                       GetSQLValueString($_POST['txtUnit'], "text"),
                       
                       GetSQLValueString($_POST['txtCapacity'], "text"),
					    GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($updateSQL, $zalongwa) or die(mysql_error());
 }
 

//control the display table
@$new=2;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$maxRows_inst = 10;
$pageNum_inst = 0;
if (isset($_GET['pageNum_inst'])) {
  $pageNum_inst = $_GET['pageNum_inst'];
}
$startRow_inst = $pageNum_inst * $maxRows_inst;

mysql_select_db($database_zalongwa, $zalongwa);
if (isset($_GET['course'])) {
  $key=$_GET['course'];
  $query_inst = "SELECT * FROM venue WHERE VenueCode Like '%$key%' ORDER BY VenueCode ASC";
}else{
$query_inst = "SELECT * FROM venue ORDER BY VenueCode ASC";
}
//$query_inst = "SELECT * FROM course ORDER BY CourseCode ASC";
$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
$inst = mysql_query($query_limit_inst, $zalongwa) or die(mysql_error());
$row_inst = mysql_fetch_assoc($inst);

if (isset($_GET['totalRows_inst'])) {
  $totalRows_inst = $_GET['totalRows_inst'];
} else {
  $all_inst = mysql_query($query_inst);
  $totalRows_inst = mysql_num_rows($all_inst);
}
$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;

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

<form name="form1" method="get" action="venuelist.php">
              <table class="resView"><tr> <td class="resViewhd"><em> &nbsp Search by Venue Code </em></td><td class="resViewtd"><input name="course" type="text" id="course" maxlength="50"></td><td>
              <input type="submit" name="Submit" value="Search"onmouseover="this.style.background='#DEFEDE'"
onmouseout="this.style.background='lightblue'" style='background-color:lightblue;color:black;font-size:9pt;font-weight:bold' title="Click to Search the List"></td></tr></table>
</form><br>
	   
<table class="resView">
  <tr>
    <td class="resViewhd">Venue Code</td>
	<td class="resViewhd">Venue Name</td>
	<td class="resViewhd">Venue Location</td>
	<td class="resViewhd">Venue Capacity</td>
	
  </tr>
  <?php do { ?>

  <tr><?php $id = $row_inst['Id'];?>
		
      <td class="resViewtd" nowrap><?php $name = $row_inst['VenueCode']; echo "$name"?></td>
	  <td class="resViewtd" nowrap><?php echo $row_inst['VenueName'] ?></td>
	  <td class="resViewtd"><?php echo $row_inst['VenueLocation']; ?></td>
	  <td class="resViewtd"><?php echo $row_inst['VenueCapacity']; ?></td>
  </tr>
  <?php } while ($row_inst = mysql_fetch_assoc($inst)); ?>
</table>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1"><span class="style2">......</span><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> <span class="style1"></span><span class="style2">..........</span></span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
<?php
}
	# include the footer
	include("../footer/footer.php");

@mysql_free_result($inst);

@mysql_free_result($instEdit);

@mysql_free_result($faculty);

@mysql_free_result($campus);
?>
