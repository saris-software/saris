<?php
require_once('../Connections/sessioncontrol.php');
# include the header
include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Subject Combination';
	$szSubSection = 'Combination';
	include("admissionheader.php");
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
$rawcode = $_POST['txtCode'];
$code = preg_replace("[[:space:]]+", " ",$rawcode);
$rawname = $_POST['txtTitle'];
$name = preg_replace("[[:space:]]+", " ",$rawname);

#check if subject exist exist
$sql ="SELECT SubjectID 			
	  FROM subjectcombination WHERE (SubjectID  = '$code')";
$result = mysqli_query($sql , $zalongwa) or die("Tunasikitika Kuwa Hatuwezi Kukuhudumia Kwa Sasa.<br>");
$coursecodeFound = mysqli_num_rows($result);
if ($coursecodeFound) {
          $coursefound   = mysqli_result($result,0,'SubjectID');
			print " This Combination Code: '".$coursefound."' Do Exists!!"; 
			exit;
}
#check if subject name exist
$namesql ="SELECT SubjectName 			
	  FROM subjectcombination WHERE (SubjectName  = '$name')";
$nameresult = mysqli_query($namesql , $zalongwa) or die("Tunasikitika Kuwa Hatuwezi Kukuhudumia Kwa Sasa.<br>");
$coursenameFound = mysqli_num_rows($nameresult);
if ($coursenameFound) {
          $namefound   = mysqli_result($nameresult,0,'SubjectName');
			print " This Subject Combination: '".$namefound."' Do Exists!!"; 
			exit;
 }
#insert records	   				   
 $insertSQL = sprintf("INSERT INTO subjectcombination (SubjectID, SubjectName) VALUES (%s, %s)",
   GetSQLValueString($_POST['txtCode'], "text"),
   GetSQLValueString($_POST['txtTitle'], "text"));                   
  mysqli_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysqli_query($insertSQL, $zalongwa) or die(mysqli_error());
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
 					   $updateSQL = sprintf("UPDATE subjectcombination SET SubjectName=%s WHERE SubjectID=%s",
                       GetSQLValueString($_POST['txtTitle'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysqli_query($updateSQL, $zalongwa) or die(mysqli_error());
 }
 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
      case "date":
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
      case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
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

mysqli_select_db($database_zalongwa, $zalongwa);
if (isset($_GET['course'])) {
  $rawkey=$_GET['course'];
  $key = addslashes($rawkey);
  $query_inst = "SELECT * FROM subjectcombination WHERE SubjectName Like '%$key%' ORDER BY SubjectID ASC";
}else{
$query_inst = "SELECT * FROM subjectcombination ORDER BY SubjectID ASC";
}
//$query_inst = "SELECT * FROM course ORDER BY CourseCode ASC";
$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
$inst = mysqli_query($query_limit_inst, $zalongwa) or die(mysqli_error());
$row_inst = mysqli_fetch_assoc($inst);

if (isset($_GET['totalRows_inst'])) {
  $totalRows_inst = $_GET['totalRows_inst'];
} else {
  $all_inst = mysqli_query($query_inst);
  $totalRows_inst = mysqli_num_rows($all_inst);
}

$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {color: #000000}
-->
</style>

<p><?php echo "<a href=\"admissionCombination.php?new=1\">"?>Add New Subject Combination</p>
<?php @$new=$_GET['new'];
echo "</a>";
if (@$new<>1){
?>
<form name="form1" method="get" action="<?php echo $editFormAction; ?>">
              Search by Combination Name: 
                <input name="course" type="text" id="course" maxlength="50">
              <input type="submit" name="Submit" value="Search">
       </form>
	   
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td><strong>S/No</strong></td>
	<td><strong>Subject Combination</strong></td>
  </tr>
  <?php do { ?>
  <tr>
     <td nowrap><?php $name = $row_inst['SubjectID']; echo "<a href=\"admissionCombination.php?edit=$name\">$name</a>"?></td>
	 <td><?php echo $row_inst['SubjectName'] ?></td>
	 </tr>
  <?php } while ($row_inst = mysqli_fetch_assoc($inst)); ?>
</table>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1">......<span class="style2"><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> </span>..........</span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
       
	   
			
<?php }else{?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
  <table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
    <tr bgcolor="#CCCCCC">
      
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Combination Code:</div></th>
      <td><input name="txtCode" type="text" id="txtCode" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Combination Name:</div></th>
      <td><input name="txtTitle" type="text" id="txtTitle" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      
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

mysqli_select_db($database_zalongwa, $zalongwa);
$query_instEdit = "SELECT * FROM subjectcombination WHERE SubjectID ='$key'";
$instEdit = mysqli_query($query_instEdit, $zalongwa) or die(mysqli_error());
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
      
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Combination Code:</div></th>
      <td><input name="txtCode" type="hidden" id="txtCode" value="<?php echo $row_instEdit['SubjectID']; ?>" size="40"><?php echo $row_instEdit['SubjectID']; ?></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Combination Name:</div></th>
      <td><input name="txtTitle" type="text" id="txtTitle" value="<?php echo $row_instEdit['SubjectName']; ?>" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><input name="id" type="hidden" id="id" value="<?php echo $key ?>"></th>
      <td><div align="center">
        <input type="submit" name="Submit" value="Edit Record">
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

@mysqli_free_result($faculty);

@mysqli_free_result($campus);
?>