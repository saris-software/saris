<?php
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
# include the header
include("policy.php");

	//include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Subject Combination';
	$szSubSection = 'Combination';
//	include('lecturerheader.php');
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
$result = mysqli_query($zalongwa, $sql) or die("Tunasikitika Kuwa Hatuwezi Kukuhudumia Kwa Sasa.<br>");
$coursecodeFound = mysqli_num_rows($result);
if ($coursecodeFound) {

//    This mysql result function need to be modified
            $coursefound = mysqli_fetch_array($result['SubjectID']);
         // $coursefound   = mysql_result($result,0,'SubjectID');
			print " This Combination Code: '".$coursefound."' Do Exists!!"; 
			exit;
}
#check if subject name exist
$namesql ="SELECT SubjectName 			
	  FROM subjectcombination WHERE (SubjectName  = '$name')";
$nameresult = mysqli_query($zalongwa, $namesql) or die("Tunasikitika Kuwa Hatuwezi Kukuhudumia Kwa Sasa.<br>");
$coursenameFound = mysqli_num_rows($nameresult);
if ($coursenameFound) {
            $namefound = mysqli_fetch_array($nameresult['SubjectName']);
          //$namefound   = mysql_result($nameresult,0,'SubjectName');
			print " This Subject Combination: '".$namefound."' Do Exists!!"; 
			exit;
 }
#insert records	   				   
 $insertSQL = sprintf("INSERT INTO subjectcombination (SubjectID, SubjectName) VALUES (%s, %s)",
   GetSQLValueString($_POST['txtCode'], "text"),
   GetSQLValueString($_POST['txtTitle'], "text"));                   
  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error($zalongwa));
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
 					   $updateSQL = sprintf("UPDATE subjectcombination SET SubjectName=%s WHERE SubjectID=%s",
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
  $query_inst = "SELECT * FROM subjectcombination WHERE SubjectName Like '%$key%' ORDER BY SubjectID ASC";
}else{
$query_inst = "SELECT * FROM subjectcombination ORDER BY SubjectID ASC";
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

<div class="container">
<button style="float:right"><?php echo "<a href=\"admissionCombination.php?new=1\">"?>Add New Subject Combination</a>
</button>

  <h2>Subject Combination</h2>
  
<form  style="text-align:right" name="form1" method="get" action="<?php echo $editFormAction; ?>">
              
              <input name="course" type="text" id="course" placeholder="Search by combination name" maxlength="100">
              <button type="submit" name="Submit">Search</button>
</form>
  <p>Verify Your Information</p>            
 <table class="table table-striped">
 
 <table class="table table-striped">
    <thead>
      <tr>
        <th>S/NO</th>
        <th>Subject combination</th>
      </tr>
    </thead>


  <?php do { ?>
  <tr>
     <td nowrap><?php $name = $row_inst['SubjectID']; echo "$name"?></td>
	 <td><?php echo $row_inst['SubjectName'] ?></td>
	 <td nowrap><button  type="submit" name="delete"  class="btn btn-default"><?php echo "<a href=\"delete.php?id=$id&code=$name\">Delete</a>"?></button></td>
	 
 <td><button  type="submit" name="edit"  class="btn btn-default"><?php echo "<a href=\"admissionCombination.php?edit=$id\">Edit</a>"?></button><td>
</tr>
  
  
  <?php } while ($row_inst = mysqli_fetch_assoc($inst)); ?>
</table>
<button><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst);?>">Previous</a>
</button>
    <span class="style1">......<span class="style2"><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst);?>/<?php echo $totalRows_inst ?> </span>..........</span>
    <button><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a></button><br>
       
	   
			
<?php }else{?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
  
  <div class="container">
  
<button><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst);?>">Previous</a>
</button>
  
  
  <div class="form-group">
      <label for="head">Combination Code:</label>
        <input type="text" class="form-control" id="txtCode" placeholder="Enter Course Code" name="txtCode">
    </div>
  <div class="form-group">
      <label for="address">Combination Title:</label>
        <input type="text" class="form-control" id="txtTitle" placeholder="Enter course title" name="txtTitle">
 </div>

<div align="center">
        <input type="submit" name="Submit" value="Add Record">
      </div>
    <input type="hidden" name="MM_insert" value="frmInst">
</form>


<?php } 
if (isset($_GET['edit'])){
#get post variables
$key = $_GET['edit'];

mysqli_select_db($zalongwa, $database_zalongwa);
$query_instEdit = "SELECT * FROM subjectcombination WHERE SubjectID ='$key'";
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
  
  
<button><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst);?>">Previous</a>
</button>

  <div class="form-group">
      <label for="head">Combination Code:</label>
        <input type="text" class="form-control" id="txtCode" value="<?php echo $row_instEdit['SubjectID']; ?>" name="txtCode">
    </div>
  <div class="form-group">
      <label for="address">Combination Title:</label>
        <input type="text" class="form-control" id="txtTitle" value="<?php echo $row_instEdit['SubjectName']; ?>" name="txtTitle">
 </div>


<input name="id" type="hidden" id="id" value="<?php echo $key ?>">
      <div align="center">
        <input type="submit" name="Submit" value="Edit Record">
      </div>
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
