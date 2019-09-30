<?php
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
# include the header

include('administration.php');

	// include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Administration';
	$szTitle = 'Register Exam Markers';
	$szSubSection = 'Exam Marker';
	// include('lecturerheader.php');
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
$sql ="SELECT Id 			
	  FROM exammarker WHERE (Id  = '$code')";
$result = mysqli_query($zalongwa, $sql) or die("Tunasikitika Kuwa Hatuwezi Kukuhudumia Kwa Sasa.<br>");
$coursecodeFound = mysqli_num_rows($result);
if ($coursecodeFound) {
          $coursefound   = mysqli_result($result,0,'SubjectID');
			print " This Combination Code: '".$coursefound."' Do Exists!!"; 
			exit;
}
#check if subject name exist
$namesql ="SELECT Name 			
	  FROM exammarker WHERE (Name  = '$name')";
$nameresult = mysqli_query($zalongwa, $namesql) or die("Tunasikitika Kuwa Hatuwezi Kukuhudumia Kwa Sasa.<br>");
$coursenameFound = mysqli_num_rows($nameresult);
if ($coursenameFound) {
          $namefound   = mysqli_result($nameresult,0,'Name');
			print " This Name: '".$namefound."' Do Exists!!"; 
			exit;
 }
#insert records	   				   
 $insertSQL = sprintf("INSERT INTO exammarker (Id, Name) VALUES (%s, %s)",
   GetSQLValueString($_POST['txtCode'], "text"),
   GetSQLValueString($_POST['txtTitle'], "text"));                   
  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error($zalongwa));
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
 					   $updateSQL = sprintf("UPDATE exammarker SET Name=%s WHERE Id=%s",
                       GetSQLValueString($_POST['txtTitle'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $updateSQL) or die(mysqli_error($zalongwa));
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

$maxRows_inst = 10;
$pageNum_inst = 0;
if (isset($_GET['pageNum_inst'])) {
  $pageNum_inst = $_GET['pageNum_inst'];
}
$startRow_inst = $pageNum_inst * $maxRows_inst;

mysqli_select_db($zalongwa, $database_zalongwa);
if (isset($_GET['course'])) {
  $rawkey=$_GET['course'];
  $key = addslashes($rawkey);
  $query_inst = "SELECT * FROM exammarker WHERE Name Like '%$key%' ORDER BY Id ASC";
}else{
$query_inst = "SELECT * FROM exammarker ORDER BY Id ASC";
}
//$query_inst = "SELECT * FROM course ORDER BY CourseCode ASC";
$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
$inst = mysqli_query($zalongwa, $query_limit_inst) or die(mysqli_error($zalongwa));
$row_inst = mysqli_fetch_assoc($inst);

if (isset($_GET['totalRows_inst'])) {
  $totalRows_inst = $_GET['totalRows_inst'];
} else {
  $all_inst = mysqli_query($zalongwa, $query_inst);
  $totalRows_inst = mysqli_num_rows($all_inst);
}
$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;
?>
<head>
  <title>policy setup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>





<?php @$new=$_GET['new'];
echo "</a>";
if (@$new<>1){
?>
<form name="form1" method="get" action="<?php echo $editFormAction; ?>">
            
            
<div class="container">
<button style="float:right"><?php echo "<a href=\"lecturerExammaker.php?new=1\">"?>Add New Exam Marker</a>
</button>


<form style="float:right" name="form1" method="get" action="admissionDepartment.php">
              Search by Name:
                <input name="course" type="text" id="course" maxlength="50">
              <input type="submit" name="Submit" value="Search">
</form>


  <p>Verify Your Information</p>            
 <table class="table table-striped">
    <thead>
      <tr>
        <th>S/NO</th>
        <th>Subject Combination</th>
      
      </tr>
    </thead>
  <?php do { ?>
  <tr>
     <td nowrap><?php $name = $row_inst['Id']; echo "<a href=\"lecturerExammaker.php?edit=$name\">$name</a>"?></td>
	 <td><?php echo $row_inst['Name'] ?></td>
 
  
    <td><button  type="submit" name="edit"  class="btn btn-default"><?php echo "<a href=\"lecturerExammaker.php?edit=$id\" >Edit</a>"?></button><td>
  
  </tr>


  <?php } while ($row_inst = mysqli_fetch_assoc($inst)); ?>
</table>
<button><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a>
</button>
<span class="style1">......<span class="style2"><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> </span>..........</span>
<button>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a>
</button>
<br>
       
	   
			
<?php }else{?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
 <div class="container">
     <button><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a>
</button>

<div class="form-group">
      <label for="address">Exam-marker Code:</label>
        <input type="text" class="form-control"  name="txtCode" id="txtCode" value="Enter Exam maker code">

    </div>
<div class="form-group">
      <label for="head">Exam-marker Name:</label>
        <input type="text" class="form-control" ame="txtTitle" id="txtTitle" value="Exam maker code">

    </div>

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

mysqli_select_db($zalongwa, $database_zalongwa);
$query_instEdit = "SELECT * FROM exammarker WHERE Id ='$key'";
$instEdit = mysqli_query($zalongwa, $query_instEdit) or die(mysqli_error($zalongwa));
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
    <div class="container">
    <button><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a>
</button>

<div class="form-group">
      <label for="address">Exam-marker Code:</label>
        <input type="text" class="form-control"  name="txtCode" id="txtCode" value="<?php echo $row_instEdit['Id'];?>">

    </div>
<div class="form-group">
      <label for="head">Exam-marker Name:</label>
        <input type="text" class="form-control" ame="txtTitle" id="txtTitle" value="<?php echo $row_instEdit['Name']; ?>">

    </div>

 
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
