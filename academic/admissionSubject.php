<?php require_once('../Connections/zalongwa.php'); 
require_once('../Connections/sessioncontrol.php');
# include the header
include('policy.php');

//include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Module Information';
	$szSubSection = 'Module';
	//include("lecturerheader.php");
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
$rawcode = $_POST['txtCode'];
$rawprog = $_POST['cmbprog'];
$code = preg_replace("[[:space:]]+", " ",$rawcode);
$prog = preg_replace("[[:space:]]+", " ",$rawprog);

#check if coursecode exist
$sql ="SELECT course.CourseCode 			
	  FROM course WHERE (course.CourseCode  = '$code')";
$result = mysqli_query($zalongwa, $sql);
$coursecodeFound = mysqli_num_rows($result);
if ($coursecodeFound) {
    $coursefound = mysqli_fetch_array($result['CourseCode']);
          //$coursefound   = mysql_result($result,0,'CourseCode');
			print " This Course Code: '".$coursefound."' Do Exists!!"; 
			echo '<meta http-equiv = "refresh" content ="1; 
				url = admissionSubject.php?new=1">';
			exit;
}else{
	   				   $insertSQL = sprintf("INSERT INTO course (CourseCode, CourseName, YearOffered, Capacity, Units, Department, Faculty, Programme, StudyLevel) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtCode'], "text"),
                       GetSQLValueString($_POST['txtTitle'], "text"),
					   GetSQLValueString($_POST['cmbSem'], "text"),
					   GetSQLValueString($_POST['txtCapacity'], "text"),
                       GetSQLValueString($_POST['txtUnit'], "text"),
                       GetSQLValueString($_POST['cmbFac'], "text"),
                       GetSQLValueString($_POST['cmbInst'], "text"),
                       GetSQLValueString($_POST['cmbprog'], "text"),
                       GetSQLValueString($_POST['cmbLevel'], "text"));

  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $insertSQL);
  }
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
 					   $updateSQL = sprintf("UPDATE course SET CourseName=%s, YearOffered=%s, Units=%s, Department=%s, Faculty=%s, Programme=%s, StudyLevel=%s, Capacity=%s WHERE Id=%s",
                       GetSQLValueString($_POST['txtTitle'], "text"),
					   GetSQLValueString($_POST['cmbSem'], "text"),
                       GetSQLValueString($_POST['txtUnit'], "text"),
                       GetSQLValueString($_POST['cmbFac'], "text"),
                       GetSQLValueString($_POST['cmbInst'], "text"),
                       GetSQLValueString($_POST['cmbprog'], "text"),
                       GetSQLValueString($_POST['cmbLevel'], "text"),
                       GetSQLValueString($_POST['txtCapacity'], "text"),
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

mysqli_select_db($zalongwa, $database_zalongwa);
$query_prog = "SELECT ProgrammeCode, Title FROM programme ORDER BY Title ASC";
$prog = mysqli_query($zalongwa, $query_prog) or die(mysqli_error($zalongwa));
$row_prog = mysqli_fetch_assoc($prog);
$totalRows_prog = mysqli_num_rows($prog);
$progcode = $row_prog['ProgrammeCode'];

mysqli_select_db($zalongwa, $database_zalongwa);
$query_campus = "SELECT FacultyID, FacultyName FROM faculty ORDER BY FacultyName ASC";
$campus = mysqli_query($zalongwa, $query_campus) or die(mysqli_error($zalongwa));
$row_campus = mysqli_fetch_assoc($campus);
$totalRows_campus = mysqli_num_rows($campus);
$facultyid = $row_campus['FacultyID'];

mysqli_select_db($zalongwa, $database_zalongwa);
$query_faculty = "SELECT DeptName FROM department ORDER BY DeptName ASC";
$faculty = mysqli_query($zalongwa, $query_faculty) or die(mysqli_error($zalongwa));
$row_faculty = mysqli_fetch_assoc($faculty);
$totalRows_faculty = mysqli_num_rows($faculty);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_semester = "SELECT Semester FROM terms ORDER BY Semester ASC";
$semester = mysqli_query($zalongwa, $query_semester) or die(mysqli_error($zalongwa));
$row_semester = mysqli_fetch_assoc($semester);
$totalRows_semester = mysqli_num_rows($semester);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_studylevel = "SELECT * FROM programmelevel ORDER BY Code ASC";
$studylevel = mysqli_query($zalongwa, $query_studylevel) or die(mysqli_error($zalongwa));
$row_studylevel = mysqli_fetch_assoc($studylevel);
$totalRows_studylevel = mysqli_num_rows($studylevel);


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
  $key=$_GET['course'];
  $query_inst = "SELECT * FROM course WHERE CourseCode Like '%$key%' ORDER BY CourseCode ASC";
}else{
$query_inst = "SELECT * FROM course ORDER BY CourseCode ASC";
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
<button style="float:right"><?php echo "<a href=\"admissionSubject.php?new=1\">"?>Add New Module </a>
</button>

  <h2>Modules</h2>
  
<form style="float:right" name="form1" method="get" action="admissionSubject.php">
              Search by Module Code
              <input name="course" type="text" id="course" maxlength="50">
              <input type="submit" name="Submit" value="Search">
</form>
  <p>Verify Your Information</p>            
 <table class="table table-striped">
 
 <table class="table table-striped">
    <thead>
      <tr>
        <th>Course</th>
        <th>Description</th>
        <th>Credits</th>
        <th>SemesterOffered</th>
        <?php if ($privilege==2){  ?>
       <th>Delete</th>
       <?php }  ?>
      </tr>
    </thead>


  <?php do { ?>

  <tr><?php $id = $row_inst['Id'];?>
      <td nowrap><?php $name = $row_inst['CourseCode']; echo "$name"?></td>
	  <td nowrap><?php echo $row_inst['CourseName'] ?></td>
	  <td><?php echo $row_inst['Units']; ?></td>
	  <td><?php echo $row_inst['YearOffered']; ?></td>
	  <?php if ($privilege==2){  ?>
	  <td nowrap><button  type="submit" name="delete"  class="btn btn-default"><?php echo "<a href=\"lecturerCoursedelete.php?id=$id&code=$name\">Delete</a>"?></button></td>
	  <?php } ?>
 <td><button  type="submit" name="edit"  class="btn btn-default"><?php echo "<a href=\"admissionSubject.php?edit=$id\">Edit</a>"?></button><td>

  </tr>
  <?php } while ($row_inst = mysqli_fetch_assoc($inst)); ?>
</table>
<button>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a>
</button>
<span class="style1"><span class="style2">......</span><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> <span class="style1"></span><span class="style2">..........</span></span>
<button>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
    	</button>		
<?php }else{?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">


<div class="container">

      <h2>Add new Module</h2>
  <div class="form-group">
      <label for="institution">Programme:</label>
      <select class="form-control" id="cmbprog" name="cmbprog" title="="<?php echo $row_prog['ProgrammeCode']; ?>">
     <?php
do {  
?>
  <option value="<?php echo $row_prog['ProgrammeCode']?>"><?php echo $row_prog['Title']?></option>
  <?php
} while ($row_prog = mysqli_fetch_assoc($prog));
  $rows = mysqli_num_rows($prog);
  if($rows > 0) {
      mysqli_data_seek($prog, 0);
	  $row_prog = mysqli_fetch_assoc($prog);
  }
?>
      </select>
 </div>
    
     <div class="form-group">
      <label for="institution">Faculty:</label>
      <select class="form-control" id="cmbInst" name="cmbInst" title="<?php echo $row_campus['FacultyName']?>">
       <?php
do {  
?>
  <option value="<?php echo $row_campus['FacultyID']?>"><?php echo $row_campus['FacultyName']?></option>
  <?php
} while ($row_campus = mysqli_fetch_assoc($campus));
  $rows = mysqli_num_rows($campus);
  if($rows > 0) {
      mysqli_data_seek($campus, 0);
	  $row_campus = mysqli_fetch_assoc($campus);
  }
?>
 
</select>
    </div>
     
<div class="form-group">
      <label for="address">Department:</label>
      <select class="form-control" id="cmbFac" name="cmbFac" title="<?php echo $row_campus['FacultyName']?>">
        <?php
do {  
?>
        <option value="<?php echo $row_faculty['DeptName']?>"><?php echo $row_faculty['DeptName']?></option>
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
    <br>
    <div class="form-group">
<div class="form-inline">
      <label for="head">Course Code:</label>
        <input type="text" class="form-control" id="txtCode" placeholder="Enter Course Code" name="txtCode">

   

      <label for="address">Course Title:</label>
        <input type="text" class="form-control" id="txtTitle" placeholder="Enter course title" name="txtTitle">
 <label  for="Physical address">Unit:</label>

        <input maxwidth="300" type="text" class="form-control" id="txtUnit" placeholder="Enter course unit" name="txtUnit">

    
      <label for="telephone">Capacity:</label>

        <input type="text" class="form-control" id="txtCapacity" placeholder="Enter Course Capacity" name="txtCapacity">

    </div>
    </div><br>
      

    <div class="form-group" style="text-align:center">
<div class="form-inline">
      <label  for="Physical address">Exam Regulation:</label>

       <select class="form-control" name="cmbLevel" id="cmbLevel" title="<?php echo $row_studylevel['Code']; ?>">
        <?php
do {  
?>
        <option value="<?php echo $row_studylevel['Code']?>"><?php echo $row_studylevel['StudyLevel']?></option>
        <?php
} while ($row_studylevel = mysqli_fetch_assoc($studylevel));
  $rows = mysqli_num_rows($studylevel);
  if($rows > 0) {
      mysqli_data_seek($studylevel, 0);
	  $row_studylevel = mysqli_fetch_assoc($studylevel);
  }
?>
      </select>
     <div class="form-group">
      <label for="telephone">Semester:</label>
<select class="form-control" name="cmbSem" id="cmbSem" title="<?php echo $row_semester['Semester']; ?>">
        <?php
do {  
?>
        <option value="<?php echo $row_semester['Semester']?>"><?php echo $row_semester['Semester'];?></option>
        <?php
} while ($row_semester = mysqli_fetch_assoc($semester));
  $rows = mysqli_num_rows($semester);
  if($rows > 0) {
      mysqli_data_seek($semester, 0);
	  $row_semester = mysqli_fetch_assoc($semester);
  }
?>
      </select>     
    </div>
    </div><br>
    <br>
        <div style="background:lightgray" class="form-group">        
      <div style="text-align:center" class="col-sm-offset-2 col-sm-10">
        <button  type="submit" name="Submit" >Add Record</button>
      </div>
    </div>
     
    
    <input type="hidden" name="MM_insert" value="frmInst">

</div>
</form>

</div>


<?php } 
if (isset($_GET['edit'])){
#get post variables
$key = $_GET['edit'];

mysqli_select_db($zalongwa, $database_zalongwa);
$query_instEdit = "SELECT * FROM course WHERE Id ='$key'";
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

      <h2>Edit Module</h2>
  <div class="form-group">

      <label for="institution">Programme:</label>
<?php
#get programme title
$progcode = $row_instEdit['Programme'];
$qprogtitle = "SELECT Title FROM programme WHERE ProgrammeCode = '$progcode'";
$dbprogtitle = mysqli_query($zalongwa, $qprogtitle);
$row_progtitle = mysqli_fetch_assoc($dbprogtitle);
$progtitle = $row_progtitle['Title'];
?>

      <select class="form-control" id="cmbprog" name="cmbprog" title="="<?php echo $row_prog['ProgrammeCode']; ?>">
<option value="<?php echo $row_instEdit['Programme']?>"><?php echo $progtitle ?></option>
  <?php
do {  
?>
<option value="<?php echo $row_prog['ProgrammeCode']?>"><?php echo $row_prog['Title']?></option>

  <?php
} while ($row_prog = mysqli_fetch_assoc($prog));
  $rows = mysqli_num_rows($prog);
  if($rows > 0) {
      mysqli_data_seek($prog, 0);
	  $row_prog = mysqli_fetch_assoc($prog);
  }
?>
      </select>
       </div>
    
     <div class="form-group">
      <label for="institution">Faculty:</label>
<?php
#get faculty name
$facultyid = $row_instEdit['Faculty'];
$qfacultytitle = "SELECT FacultyName FROM faculty WHERE FacultyID = '$facultyid'";
$dbfacultytitle = mysqli_query($zalongwa, $qfacultytitle);
$row_facultytitle = mysqli_fetch_assoc($dbfacultytitle);
$facultytitle = $row_facultytitle['FacultyName'];
?>

      <select class="form-control" id="cmbInst" name="cmbInst" title="<?php echo $row_campus['FacultyName']?>">
<option value="<?php echo $row_instEdit['Faculty']?>"><?php echo $facultytitle?></option>
  <?php
do {  
?>
<option value="<?php echo $row_campus['FacultyID']?>"><?php echo $row_campus['FacultyName']?></option>
  <?php
} while ($row_campus = mysqli_fetch_assoc($campus));
  $rows = mysqli_num_rows($campus);
  if($rows > 0) {
      mysqli_data_seek($campus, 0);
	  $row_campus = mysqli_fetch_assoc($campus);
  }
?>
      </select>
          </div>



<div class="form-group">
      <label for="address">Department:</label>
    <select class="form-control" name="cmbFac" id="cmbFac" title="<?php echo $row_faculty['DeptName']; ?>">
	  <option value="<?php echo $row_instEdit['Department']?>"><?php echo $row_instEdit['Department']?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_faculty['DeptName']?>"><?php echo $row_faculty['DeptName']?></option>
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
    <br>
    
    
    <div class="form-group">
<div class="form-inline">
      <label for="head">Course Code:</label>
        <input type="text" class="form-control" id="txtCode" value="<?php echo $row_instEdit['CourseCode']; ?>"  name="txtCode">
 &nbsp;&nbsp;&nbsp;&nbsp;
   

      <label for="address">Course Title:</label>
        <input type="text" class="form-control" id="txtTitle" value="<?php echo $row_instEdit['CourseName']; ?>" name="txtTitle">
  &nbsp;&nbsp;&nbsp;&nbsp;

 
 <label  for="Physical address">Unit:</label>
        <input maxwidth="300" type="text" class="form-control" id="txtUnit" value="<?php echo $row_instEdit['Units']; ?>" name="txtUnit">
 &nbsp;&nbsp;&nbsp;&nbsp;

     <label for="telephone">Capacity:</label>
        <input type="text" class="form-control" id="txtCapacity" value="<?php echo $row_instEdit['Capacity']; ?>" name="txtCapacity">

    
 
    </div>
    </div><br>

    <div class="form-group" style="text-align:center">
<div class="form-inline">

      <label  for="Physical address">Exam Regulation:</label>
<?php
		#get programme title
		$studycode = $row_instEdit['StudyLevel'];
		$qstudytitle = "SELECT StudyLevel FROM programmelevel WHERE Code = '$studycode'";
		$dbstudytitle = mysqli_query($zalongwa, $qstudytitle);
		$row_studytitle = mysqli_fetch_assoc($dbstudytitle);
		$studytitle = $row_studytitle['StudyLevel'];
		?>
       <select class="form-control" name="cmbLevel" id="cmbLevel" title="<?php echo $row_studylevel['Code']; ?>">
        <option value="<?php echo $row_instEdit['StudyLevel']?>"><?php echo $studytitle?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_studylevel['Code']?>"><?php echo $row_studylevel['StudyLevel']?></option>
        <?php
} while ($row_studylevel = mysqli_fetch_assoc($studylevel));
  $rows = mysqli_num_rows($studylevel);
  if($rows > 0) {
      mysqli_data_seek($studylevel, 0);
	  $row_studylevel = mysqli_fetch_assoc($studylevel);
  }
?>
      </select>
      
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <div class="form-group">
      <label for="telephone">Semester:</label>
<select class="form-control" name="cmbSem" id="cmbSem" title="<?php echo $row_semester['Semester']; ?>">
<option value="<?php echo $row_instEdit['YearOffered'];?>"><?php echo $row_instEdit['YearOffered'];?></option>

        <?php
		do {  
		?>
				<option value="<?php echo $row_semester['Semester']?>"><?php echo $row_semester['Semester'];?></option>
				<?php
		} while ($row_semester = mysqli_fetch_assoc($semester));
		  $rows = mysqli_num_rows($semester);
		  if($rows > 0) {
			  mysqli_data_seek($semester, 0);
			  $row_semester = mysqli_fetch_assoc($semester);
		  }
		?>
      </select>
          </div>
    </div><br>
    <br>
  
     <div style="background:lightgray" class="form-group">        
      <div style="text-align:center" class="col-sm-offset-2 col-sm-10">
        <button  type="submit" name="Submit" >Edit Record</button>
      </div>
    </div>
     
    
    <input type="hidden" name="MM_insert" value="frmInst">


</div>
</form>

</div>



<?php
}
	# include the footer
	include("../footer/footer.php");

@mysqli_free_result($inst);

@mysqli_free_result($instEdit);

@mysqli_free_result($faculty);

@mysqli_free_result($campus);
?>
