<?php
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# include menu
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Policy Setup';
	$szTitle = 'Programme Information';
	$szSubSection = 'Programme';
	include("lecturerheader.php");

$currentPage = $_SERVER["PHP_SELF"];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
	$rawcode = $_POST['txtCode'];
	$programme = ereg_replace("[[:space:]]+", " ",$rawcode);
	$rawcount = $_POST['txtCount'];
	$code = ereg_replace("[[:space:]]+", " ",$rawcount);
	$rawyearofstudy = $_POST['YearofStudy'];
	$yearofstudy = ereg_replace("[[:space:]]+", " ",$rawyearofstudy);
	$rawsemester = $_POST['semester'];
	$semester = ereg_replace("[[:space:]]+", " ",$rawsemester);
	$rawayear = $_POST['ayear'];
	$ayear = ereg_replace("[[:space:]]+", " ",$rawayear);

#check if coursecode exist
$coursecodeFound = 1;
if ($coursecodeFound) {
	#insert records	 
	$insSQL = "INSERT INTO coursecountprogramme (ProgrammeID, YearofStudy, Semester, CourseCount, AYear) VALUES ('$programme', '$yearofstudy', '$semester', '$code', '$ayear')";  				   
	  $Result1 = mysql_query($insSQL);
	}

 }
 
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
//control the display table
@$new=2;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$maxRows_inst = 10000;
$pageNum_inst = 0;
if (isset($_GET['pageNum_inst'])) {
  $pageNum_inst = $_GET['pageNum_inst'];
}
$startRow_inst = $pageNum_inst * $maxRows_inst;

mysql_select_db($database_zalongwa, $zalongwa);
if (isset($_GET['edit'])) {
  $rawkey=$_GET['edit'];
  $key = addslashes($rawkey);
  $query_inst = "SELECT * FROM coursecountprogramme WHERE ProgrammeID='$key' ORDER BY ProgrammeID ASC";
}else{
$query_inst = "SELECT * FROM coursecountprogramme ORDER BY ProgrammeID ASC";
}
#get combination name
$qcomb = "select ProgrammeName from programme where ProgrammeCode='$key'";
$dbcomb = mysql_query($qcomb);
$row_comb =mysql_fetch_assoc($dbcomb);
$comb = $row_comb['ProgrammeName'];

mysql_select_db($database_zalongwa, $zalongwa);
$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$ayear = mysql_query($query_ayear, $zalongwa);
$row_ayear = mysql_fetch_assoc($ayear);
$totalRows_ayear = mysql_num_rows($ayear);

$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
$inst = mysql_query($query_limit_inst, $zalongwa);
$row_inst = mysql_fetch_assoc($inst);

if (isset($_GET['totalRows_inst'])) {
  $totalRows_inst = $_GET['totalRows_inst'];
} else {
  $all_inst = mysql_query($query_inst);
  $totalRows_inst = mysql_num_rows($all_inst);
}
$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {color: #000000}
-->
</style>


<?php @$new=$_GET['new'];
echo "</a>";
if (@$new<>1){
?>
<form name="form1" method="get" action="<?php echo $editFormAction; ?>">
              Search by CourseCode: 
                <input name="course" type="text" id="course" maxlength="50">
              <input type="submit" name="Submit" value="Search">
</form>

<?php
if (isset($_GET['edit'])){
#get post variables
$rawkey = addslashes($_GET['edit']);
$key = ereg_replace("[[:space:]]+", " ",$rawkey);

mysql_select_db($database_zalongwa, $zalongwa);
$query_instEdit = "SELECT * FROM coursecountprogramme WHERE ProgrammeID ='$key'";
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInstEdit" id="frmInstEdit">
  <table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
    
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Study Programme:</div></th>
      <td><input name="txtCode" type="hidden" id="txtCode" value="<?php echo $key?>" size="20" />
          <?php echo $comb?></td>
      <td>YearofStudy</td>
      <td>Semester</td>
      <td>Academic Year</td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Total Credits Count:</div></th>
      <td><input name="txtCount" type="text" id="txtCount" value="" size="6" /></td>
       <td><select name="YearofStudy" id="YearofStudy">
        <option value="1">First Year</option>
        <option value="2">Second Year</option>
        <option value="3">Third Year</option>
        <option value="4">Fourth Year</option>
        <option value="5">Fifth Year</option>
      </select>      </td>
      <td><select name="semester" id="semester">
        <option value="1">Semester I </option>
        <option value="2">Semester II</option>
      </select> </td>

       <td><div align="left">
               <select name="ayear" id="ayear">
                  <?php
					do {  
					?>
                    <option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
                    <?php
						} while ($row_ayear = mysql_fetch_assoc($ayear));
						  $rows = mysql_num_rows($ayear);
						  if($rows > 0) {
					      mysql_data_seek($ayear, 0);
						  $row_ayear = mysql_fetch_assoc($ayear);
					  }
					?>
                    </select>
                  </div></td>
    </tr>
    
    <tr bgcolor="#CCCCCC">
      <th scope="row"><input name="id" type="hidden" id="id" value="<?php echo $key ?>" /></th>
      <td colspan="4"><div align="center">
          <input type="submit" name="Submit2" value="Add Record" />
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="frmInstEdit">
</form>
<?php
}
?>
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td><strong>S/No</strong></td>
	<td><strong>Programme</strong></td>
	<td><strong>YearofStudy</strong></td>
	<td><strong>Semester</strong></td>
	<td><strong>Academic Year</strong></td>
	<td><strong>CourseCount</strong></td>
	<td><strong>Delete</strong></td>
  </tr>
  <?php 
  $sn =1;
  do { ?>
  <tr>
     <td nowrap><?php echo $sn?></td>
	 <td><?php echo $comb?></td>
	  <td nowrap><?php $yrs=$row_inst['YearofStudy']; echo $row_inst['YearofStudy']?></td>
     <td nowrap><?php $sem=$row_inst['Semester']; echo $row_inst['Semester']?></td>
     <td nowrap><?php $ayear=$row_inst['AYear']; echo $row_inst['AYear']?></td>
 	 <td nowrap><?php $count=$row_inst['CourseCount']; echo $row_inst['CourseCount']?></td>
      <td nowrap><?php echo "<a href=\"lecturerProgrammecoursecountdelete.php?prog=$key&sem=$sem&year=$yrs&ayear=$ayear\">Delete</a>"?></td>
    </tr>
  <?php 
  $sn=$sn+1;
  
  } while ($row_inst = mysql_fetch_assoc($inst)); ?>
</table>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1">......<span class="style2"><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> </span>..........</span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
<?php }

	# include the footer
	include("../footer/footer.php");

@mysql_free_result($inst);

@mysql_free_result($instEdit);

@mysql_free_result($faculty);

@mysql_free_result($campus);
