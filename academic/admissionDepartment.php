<?php  require_once('../Connections/zalongwa.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
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

mysqli_select_db($zalongwa, $database_zalongwa);
$query_campus = "SELECT CampusID, Campus FROM campus";
$campus = mysqli_query($zalongwa, $query_campus) or die(mysqli_error($zalongwa));
$row_campus = mysqli_fetch_assoc($campus);
$totalRows_campus = mysqli_num_rows($campus);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_faculty = "SELECT FacultyID, FacultyName FROM faculty";
$faculty = mysqli_query($zalongwa, $query_faculty) or die(mysqli_error($zalongwa));
$row_faculty = mysqli_fetch_assoc($faculty);
$totalRows_faculty = mysqli_num_rows($faculty);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
  $updateSQL = sprintf("UPDATE department SET CampusID=%s, Faculty=%s, DeptName=%s, DeptPhysAdd=%s, DeptAddress=%s, DeptTel=%s, DeptEmail=%s, DeptHead=%s WHERE DeptID=%s",
                       GetSQLValueString($_POST['cmbInst'], "text"),
					   GetSQLValueString($_POST['txtName'], "text"),
                       GetSQLValueString($_POST['txtPhyAdd'], "text"),
                       GetSQLValueString($_POST['txtAdd'], "text"),
                       GetSQLValueString($_POST['txtTel'], "text"),
                       GetSQLValueString($_POST['txtEmail'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $updateSQL) or die(mysqli_error($zalongwa));

  $updateGoTo = "admissionDepartment.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  @header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
  $updateSQL = sprintf("UPDATE department SET CampusID=%s, Faculty=%s, DeptName=%s, DeptPhysAdd=%s, DeptAddress=%s, DeptTel=%s, DeptEmail=%s, DeptHead=%s WHERE DeptID=%s",
                       GetSQLValueString($_POST['cmbInst'], "int"),
                       GetSQLValueString($_POST['cmbFac'], "text"),
                       GetSQLValueString($_POST['txtName'], "text"),
                       GetSQLValueString($_POST['txtPhyAdd'], "text"),
                       GetSQLValueString($_POST['txtAdd'], "text"),
                       GetSQLValueString($_POST['txtTel'], "text"),
                       GetSQLValueString($_POST['txtEmail'], "text"),
                       GetSQLValueString($_POST['txtHead'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $updateSQL) or die(mysqli_error($zalongwa));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
  $insertSQL = sprintf("INSERT INTO department (CampusID, Faculty, DeptName, DeptPhysAdd, DeptAddress, DeptTel, DeptEmail, DeptHead) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cmbInst'], "int"),
                       GetSQLValueString($_POST['cmbFac'], "text"),
                       GetSQLValueString($_POST['txtName'], "text"),
                       GetSQLValueString($_POST['txtPhyAdd'], "text"),
                       GetSQLValueString($_POST['txtAdd'], "text"),
                       GetSQLValueString($_POST['txtTel'], "text"),
                       GetSQLValueString($_POST['txtEmail'], "text"),
                       GetSQLValueString($_POST['txtHead'], "text"));

  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error($zalongwa));
}

$maxRows_inst = 10;
$pageNum_inst = 0;
if (isset($_GET['pageNum_inst'])) {
  $pageNum_inst = $_GET['pageNum_inst'];
}
$startRow_inst = $pageNum_inst * $maxRows_inst;

mysqli_select_db($zalongwa, $database_zalongwa);
if (isset($_GET['course'])) {
  $key=$_GET['course'];
  $query_inst = "SELECT * FROM department WHERE DeptName Like '%$key%' ORDER BY DeptName ASC";
}else{
$query_inst = "SELECT * FROM department ORDER BY DeptName ASC";
}
//$query_inst = "SELECT * FROM department";
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

require_once('../Connections/sessioncontrol.php');
# include the header
	include("policy.php");

//include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Department Information';
	$szSubSection = 'Department';
	//include("lecturerheader.php");
 
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
<button style="float:right"><?php echo "<a href=\"admissionDepartment.php?new=1\">"?>Add New Department </a>
</button>

  <h2>Departments</h2>
  
<form style="float:right" name="form1" method="get" action="admissionDepartment.php">
              Search by Name:
                <input name="course" type="text" id="course" maxlength="50">
              <input type="submit" name="Submit" value="Search">
</form>


  <p>Verify Your Information</p>            
 <table class="table table-striped">
 
 <table class="table table-striped">
    <thead>
      <tr>
        <th>Department</th>
        <th>Location</th>
        <th>Head</th>
        <th>Address</th>
       <th>Tel</th>
        <th>Email</th>
      
      </tr>
    </thead>
  <?php do { ?>
  <tr>
    <td nowrap><?php $id = $row_inst['DeptID']; $name = $row_inst['DeptName'];
	echo "$name"?></td>
    <td><?php echo $row_inst['DeptPhysAdd']; ?></td>
	 <td><?php echo $row_inst['DeptHead']; ?></td>
    <td><?php echo $row_inst['DeptAddress']; ?></td>
    <td><?php echo $row_inst['DeptTel']; ?></td>
    <td><?php echo $row_inst['DeptEmail']; ?></td>
    <td><button  type="submit" name="edit"  class="btn btn-default"><?php echo "<a href=\"admissionDepartment.php?edit=$id\" >Edit</a>"?></button><td>
  
  </tr>
  <?php } while ($row_inst = mysqli_fetch_assoc($inst)); ?>
</table>
<button>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a>
</button>
<span class="style1">......<span class="style2"><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> </span>..........</span>
<button><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a></button>
<?php }else{?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
  
   <button>
<a style="border-radius:10px" href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a>
      </button>
   </div>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">

<div class="container">

      <h2>Add new Department</h2>
   <div class="form-group">
      <label for="institution">Institution:</label>
      <select class="form-control" id="cmbInst" name="cmbInst">
      <?php
do {  
?>
        <option value="<?php echo $row_campus['CampusID']?>"><?php echo $row_campus['Campus']?></option>
        <?php
} while ($row_campus = mysqli_fetch_assoc($campus));
  $rows = mysqli_num_rows($campus);
  if($rows > 0) {
      mysqli_data_seek($campus, 0);
	  $row_campus = mysqli_fetch_assoc($campus);
  }
?></select>
    </div>
    
     <div class="form-group">
      <label for="institution">Faculty:</label>
      <select class="form-control" id="cmbFac" name="cmbFac">
      <?php
do {  
?>
        <option value="<?php echo $row_faculty['FacultyID']?>"><?php echo $row_faculty['FacultyName']?></option>
        <?php
} while ($row_faculty = mysqli_fetch_assoc($faculty));
  $rows = mysqli_num_rows($faculty);
  if($rows > 0) {
      mysqli_data_seek($faculty, 0);
	  $row_faculty = mysqli_fetch_assoc($faculty);
  }
?>
</select>
    </div>
    
<div class="form-group">
      <label for="address">Department:</label>
        <input type="text" class="form-control" id="txtName" placeholder="Enter Faculty" name="txtName">

    </div>
<div class="form-group">
      <label for="head">Head:</label>
        <input type="text" class="form-control" id="txtHead" placeholder="Enter Faculty" name="txtHead">

    </div>

    <div class="form-group">
      <label for="address">Address:</label>
        <input type="text" class="form-control" id="txtAdd" placeholder="Enter Address" name="txtAdd">

    </div>
<div class="form-group">
      <label  for="Physical address">Physical Address:</label>

        <input type="text" class="form-control" id="txtPhyAdd" placeholder="Enter Physical Address" name="txtPhyAdd">

    </div>
    <div class="form-group">
      <label for="telephone">Telephone:</label>

        <input type="text" class="form-control" id="txtTel" placeholder="Enter Telephone" name="txtTel">

    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      
        <input type="email" class="form-control" id="txtEmail" placeholder="Enter email" name="txtEmail">
      
    </div>
        <div class="form-group">        
      <div style="text-align:center" class="col-sm-offset-2 col-sm-10">
        <button  type="submit" name="Submit" class="btn btn-default">Add Record</button>
      </div>
    </div>
    <input type="hidden" name="MM_insert" value="frmInst">

</div>
</form>

  
<?php } 
if (isset($_GET['edit'])){
#get post variables
$key = $_GET['edit'];
mysqli_select_db($zalongwa, $database_zalongwa);
$query_instEdit = "SELECT * FROM department WHERE DeptID ='$key'";
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
 
    <div class="form-group">
      <label for="institution">Institution:</label>
      <select class="form-control" id="cmbInst" name="cmbInst" title="<?php echo $row_instEdit['CampusID']; ?>">
      <?php
do {  
?>
 
        <option value="<?php echo $row_campus['CampusID']?>"><?php echo $row_campus['Campus']?></option>
        <?php
} while ($row_campus = mysqli_fetch_assoc($campus));
  $rows = mysqli_num_rows($campus);
  if($rows > 0) {
      mysqli_data_seek($campus, 0);
	  $row_campus = mysqli_fetch_assoc($campus);
  }
?>
      </select>
      
     <div class="form-group">
      <label for="institution">Faculty:</label>
      <select class="form-control" id="cmbFac" name="cmbFac">
      <?php
do {  
?>
        <option value="<?php echo $row_faculty['FacultyID']?>"><?php echo $row_faculty['FacultyName']?></option>
        <?php
} while ($row_faculty = mysqli_fetch_assoc($faculty));
  $rows = mysqli_num_rows($faculty);
  if($rows > 0) {
      mysqli_data_seek($faculty, 0);
	  $row_faculty = mysqli_fetch_assoc($faculty);
  }
?>
</select>
    </div>
    
    <div class="form-group">
      <label for="address">Department:</label>
        <input type="text" class="form-control" id="txtName" value="<?php echo $row_instEdit['DeptName']; ?>" name="txtName">

    </div>
    
    <div class="form-group">
      <label for="address">Head:</label>
        <input type="text" class="form-control" id="txtHead" value="<?php echo $row_instEdit['DeptHead']; ?>" name="txtHead">

    </div>
    <div class="form-group">
      <label for="address">Address:</label>
        <input type="text" class="form-control" id="txtAdd" value="<?php echo $row_instEdit['DeptAddress']; ?>" name="txtAdd">

    </div>
<div class="form-group">
      <label  for="Physical address">Physical Address:</label>

        <input type="text" class="form-control" id="txtPhyAdd" value="<?php echo $row_instEdit['DeptPhysAdd']; ?>" name="txtPhyAdd">

    </div>
    <div class="form-group">
      <label for="telephone">Telephone:</label>

        <input type="text" class="form-control" id="txtTel" value="<?php echo $row_instEdit['DeptTel']; ?>" name="txtTel">

    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      
        <input type="email" class="form-control" id="txtEmail" value="<?php echo $row_instEdit['DeptEmail']; ?>" name="txtEmail">
      
    </div>
        <div class="form-group">        
      <div style="text-align:center">
        <button  type="submit" name="edit" class="btn btn-default">Edit Record</button>
      </div>
    </div>
    
    <input name="id" type="hidden" id="id" value="<?php echo $key ?>">
      
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
