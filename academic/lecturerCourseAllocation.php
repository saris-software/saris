<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	// include('lecturerMenu.php');

  include('administration.php');


	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Administration';
	$szSubSection = 'Course Allocation';
	$szTitle = 'Lecturer Course Allocation';
	// include('lecturerheader.php');
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

<div class="container">

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO examregister (RegNo, CourseCode, AYear, Semester, Recorder) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['lecturer'], "text"),
                       GetSQLValueString($_POST['course'], "text"),
                       GetSQLValueString($_POST['Ayear'], "text"),
                       GetSQLValueString($_POST['semester'], "text"),
					   GetSQLValueString($_POST['user'], "text"));

  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error($zalongwa));
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_ExamOfficerGradeBook = 20;
$pageNum_ExamOfficerGradeBook = 0;
if (isset($_GET['pageNum_ExamOfficerGradeBook'])) {
  $pageNum_ExamOfficerGradeBook = $_GET['pageNum_ExamOfficerGradeBook'];
}
$startRow_ExamOfficerGradeBook = $pageNum_ExamOfficerGradeBook * $maxRows_ExamOfficerGradeBook;

mysqli_select_db($zalongwa, $database_zalongwa);
$query_ExamOfficerGradeBook = "SELECT CourseCode, AYear, Semester FROM examregister";
$query_limit_ExamOfficerGradeBook = sprintf("%s LIMIT %d, %d", $query_ExamOfficerGradeBook, $startRow_ExamOfficerGradeBook, $maxRows_ExamOfficerGradeBook);
$ExamOfficerGradeBook = mysqli_query($zalongwa, $query_limit_ExamOfficerGradeBook) or die(mysqli_error($zalongwa));
$row_ExamOfficerGradeBook = mysqli_fetch_assoc($ExamOfficerGradeBook);

if (isset($_GET['totalRows_ExamOfficerGradeBook'])) {
  $totalRows_ExamOfficerGradeBook = $_GET['totalRows_ExamOfficerGradeBook'];
} else {
  $all_ExamOfficerGradeBook = mysqli_query($zalongwa, $query_ExamOfficerGradeBook);
  $totalRows_ExamOfficerGradeBook = mysqli_num_rows($all_ExamOfficerGradeBook);
}
$totalPages_ExamOfficerGradeBook = ceil($totalRows_ExamOfficerGradeBook/$maxRows_ExamOfficerGradeBook)-1;

mysqli_select_db($zalongwa, $database_zalongwa);
$query_Ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$Ayear = mysqli_query($zalongwa, $query_Ayear) or die(mysqli_error($zalongwa));
$row_Ayear = mysqli_fetch_assoc($Ayear);
$totalRows_Ayear = mysqli_num_rows($Ayear);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_semester = "SELECT Description FROM terms ORDER BY Semester ASC";
$semester = mysqli_query($zalongwa, $query_semester) or die(mysqli_error($zalongwa));
$row_semester = mysqli_fetch_assoc($semester);
$totalRows_semester = mysqli_num_rows($semester);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_course = "SELECT CourseCode, CourseName FROM course ORDER BY CourseCode ASC";
$course = mysqli_query($zalongwa, $query_course) or die(mysqli_error($zalongwa));
$row_course = mysqli_fetch_assoc($course);
$totalRows_course = mysqli_num_rows($course);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_lecturer = "SELECT UserName, FullName, Position FROM security WHERE Position = 'Lecturer' ORDER BY FullName";
$lecturer = mysqli_query($zalongwa, $query_lecturer) or die(mysqli_error($zalongwa));
$row_lecturer = mysqli_fetch_assoc($lecturer);
$totalRows_lecturer = mysqli_num_rows($lecturer);

$maxRows_courseallocation = 50;
$pageNum_courseallocation = 0;
if (isset($_GET['pageNum_courseallocation'])) {
  $pageNum_courseallocation = $_GET['pageNum_courseallocation'];
}
$startRow_courseallocation = $pageNum_courseallocation * $maxRows_courseallocation;

mysqli_select_db($zalongwa, $database_zalongwa);
$query_courseallocation = "SELECT security.UserName, 
security.FullName,                 
security.Position,                 
examregister.RegNo,                 
examregister.AYear,                 
examregister.Semester,                 
examregister.CourseCode 
FROM examregister    
	INNER JOIN security ON (examregister.RegNo = security.UserName)
	 ORDER BY  examregister.AYear DESC, examregister.CourseCode ASC";
$query_limit_courseallocation = sprintf("%s LIMIT %d, %d", $query_courseallocation, $startRow_courseallocation, $maxRows_courseallocation);
$courseallocation = mysqli_query($zalongwa, $query_limit_courseallocation) or die(mysqli_error($zalongwa));
$row_courseallocation = mysqli_fetch_assoc($courseallocation);

if (isset($_GET['totalRows_courseallocation'])) {
  $totalRows_courseallocation = $_GET['totalRows_courseallocation'];
} else {
  $all_courseallocation = mysqli_query($zalongwa, $query_courseallocation);
  $totalRows_courseallocation = mysqli_num_rows($all_courseallocation);
}
$totalPages_courseallocation = ceil($totalRows_courseallocation/$maxRows_courseallocation)-1;

$queryString_courseallocation = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_courseallocation") == false && 
        stristr($param, "totalRows_courseallocation") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_courseallocation = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_courseallocation = sprintf("&totalRows_courseallocation=%d%s", $totalRows_courseallocation, $queryString_courseallocation);

$queryString_ExamOfficerGradeBook = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ExamOfficerGradeBook") == false && 
        stristr($param, "totalRows_ExamOfficerGradeBook") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ExamOfficerGradeBook = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ExamOfficerGradeBook = sprintf("&totalRows_ExamOfficerGradeBook=%d%s", $totalRows_ExamOfficerGradeBook, $queryString_ExamOfficerGradeBook);
 
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

<div class="container">




<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
             
              <h3>Course Allocation</h3>
 
             <div class="form-group">
      <label for="address">Academic Year:</label>
              <select class="form-control" name="Ayear" id="Ayear">
                    <?php
do {  
?>
                    <option value="<?php echo $row_Ayear['AYear']?>"><?php echo $row_Ayear['AYear']?></option>
                    <?php
} while ($row_Ayear = mysqli_fetch_assoc($Ayear));
  $rows = mysqli_num_rows($Ayear);
  if($rows > 0) {
      mysqli_data_seek($Ayear, 0);
	  $row_Ayear = mysqli_fetch_assoc($Ayear);
  }
?>
                  </select>
</div>

<div class="form-group">
      <label for="address">Course Code:</label>
              <select class="form-control" name="course" id="course">
                    <?php
do {  
?>
                    <option value="<?php echo $row_course['CourseCode']?>"><?php echo $row_course['CourseCode']?></option>
                    <?php
} while ($row_course = mysqli_fetch_assoc($course));
  $rows = mysqli_num_rows($course);
  if($rows > 0) {
      mysqli_data_seek($course, 0);
	  $row_course = mysqli_fetch_assoc($course);
  }
?>
                  </select>
                  </div>

<div class="form-group">
      <label for="address">Semester:</label>
              <select class="form-control" name="semester" id="semester">
                    <?php
do {  
?>
                    <option value="<?php echo $row_semester['Description']?>"><?php echo $row_semester['Description']?></option>
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
        
<div class="form-group">
      <label for="address">Lecturer Name:</label>
         <input class="btn btn-default" name="user" type="hidden" id="user" value="<?php echo $username;?>"> 
      
         </div>    
                 
<div class="form-group">
      <label for="address">Lecturer ID:</label>
              <select class="form-control" name="lecturer" id="lecturer">
                    <?php
do {  
?>
                    <option value="<?php echo $row_lecturer['UserName']?>"><?php echo $row_lecturer['FullName']?></option>
                    <?php
} while ($row_lecturer = mysqli_fetch_assoc($lecturer));
  $rows = mysqli_num_rows($lecturer);
  if($rows > 0) {
      mysqli_data_seek($lecturer, 0);
	  $row_lecturer = mysqli_fetch_assoc($lecturer);
  }
?>
                  </select>
                  </div>
                  
                  
                  <td colspan="4"><div align="center">
                      <input type="submit" name="Submit" value="Save Records">
                  </div>
                  
                <p>
                  <input type="hidden" name="MM_insert" value="form1">
</p>
                
                <p>LECTURER COURSE ALLOCATION                </p>
                
                
 <table class="table table-striped">
    <thead>
      <tr>
        <th>Full Name</th>
        <th>Position</th>
        <th>Academic Year</th>
        <th>Semester</th>
       <th>Course</th>
        <th>Delete</th>
      
      </tr>
    </thead>
                
                <?php do { ?>
                  <tr>
                    <td nowrap><?php $user=$row_courseallocation['UserName']; echo $row_courseallocation['FullName']; ?></td>
                    <td nowrap><?php echo $row_courseallocation['Position']; ?></td>
                    <td nowrap><?php $ayear=$row_courseallocation['AYear']; echo $row_courseallocation['AYear']; ?></td>
                    <td nowrap><?php echo $row_courseallocation['Semester']; ?></td>
                    <td nowrap><?php $key = $row_courseallocation['CourseCode']; echo $row_courseallocation['CourseCode']; ?></td>
	<td><button><?php print "<a href=\"lecturerexalresultdelete.php?RegNo=$user&ayear=$ayear&key=$key\">Drop</a>";?></button></td>
					 
    <td><button  type="submit" name="edit"  class="btn btn-default"><?php echo "<a href=\"admissionDepartment.php?edit=$id\" >Edit</a>"?></button><td>

                  </tr>
                  <?php } while ($row_courseallocation = mysqli_fetch_assoc($courseallocation)); ?>
  </table>
</form>
<button><a href="<?php printf("%s?pageNum_courseallocation=%d%s", $currentPage, max(0, $pageNum_courseallocation - 1), $queryString_courseallocation); ?>">Previous Page </a></button> Records......... <?php echo min($startRow_courseallocation + $maxRows_courseallocation, $totalRows_courseallocation) ?>/<?php echo $totalRows_courseallocation ?> 
<button><a href="<?php printf("%s?pageNum_courseallocation=%d%s", $currentPage, min($totalPages_courseallocation, $pageNum_courseallocation + 1), $queryString_courseallocation); ?>">Next Page</a></button>

<?php

include('../footer/footer.php');
?>
