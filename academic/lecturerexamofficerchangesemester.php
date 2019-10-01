<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
  
  include('administration.php');

  // include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Administration';
	$szSubSection = 'Change Semester';
	$szTitle = 'Change Exam Semester';
	// include('lecturerheader.php');
?>

<?php
$currentPage = $_SERVER["PHP_SELF"];

//populate academic year combo box
mysqli_select_db($zalongwa, $database_zalongwa);
$query_AYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AYear = mysqli_query($zalongwa, $query_AYear) or die(mysqli_error($zalongwa));
$row_AYear = mysqli_fetch_assoc($AYear);
$totalRows_AYear = mysqli_num_rows($AYear);

//populate semester combo box
mysqli_select_db($zalongwa, $database_zalongwa);
$query_sem = "SELECT Semester FROM terms ORDER BY Semester ASC";
$sem = mysqli_query($zalongwa, $query_sem) or die(mysqli_error($zalongwa));
$row_sem = mysqli_fetch_assoc($sem);
$totalRows_sem = mysqli_num_rows($sem);

//populate coursecode combo box
mysqli_select_db($zalongwa, $database_zalongwa);
$query_course = "SELECT CourseCode FROM course ORDER BY CourseCode ASC";
$course = mysqli_query($zalongwa, $query_course) or die(mysqli_error($zalongwa));
$row_course = mysqli_fetch_assoc($course);
$totalRows_course = mysqli_num_rows($course);

if(isset($_POST['confirm']) && ($_POST['confirm']=='Confirm')){

$currentPage = $_SERVER["PHP_SELF"];
@$key=$_POST['course'];
@$ayear=$_POST['ayear'];
@$sem=$_POST['sem'];




$maxRows_ExamOfficerGradeBook = 10000;
$pageNum_ExamOfficerGradeBook = 0;
//change semester registration
$query = "UPDATE examregister SET Semester='$sem' WHERE CourseCode ='$key' AND AYear = '$ayear'";
$qupdadateexamresult = "UPDATE examresult SET Semester='$sem' WHERE CourseCode ='$key' AND AYear = '$ayear'";

$result = mysqli_query($zalongwa, $query);
$result1 = mysqli_query($zalongwa, $qupdadateexamresult);

	if($result) {
	echo " Database Updated Successful!";
	exit;
	}
}else{
//openup a form
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

<form name="form1" method="post" action="<?php echo $currentPage;?> ">
<!-- head -->             
  <h3>Change Semester</h3>

<!-- all view items for changes-->
<div class="form-group">
      <label for="address">Academic Year:</label>
              <select class="form-control" name="ayear" id="ayear">
	  <option value="">-----------------</option>
	   <?php
do {  
?>
<option value="<?php echo $row_AYear['AYear']?>"><?php echo $row_AYear['AYear']?></option>
                        <?php
} while ($row_AYear = mysqli_fetch_assoc($AYear));
  $rows = mysqli_num_rows($AYear);
  if($rows > 0) {
      mysqli_data_seek($AYear, 0);
	  $row_AYear = mysqli_fetch_assoc($AYear);
  }
?>
      </select>
    </div>
<div class="form-group">
      <label for="head">Semester:</label>
              <select class="form-control" name="sem" id="sem">
	  <option value="">-----------------</option>
	   <?php
do {  
?>
 <option value="<?php echo $row_sem['Semester']?>"><?php echo $row_sem['Semester']?></option>
                        <?php
} while ($row_sem = mysqli_fetch_assoc($sem));
  $rows = mysqli_num_rows($sem);
  if($rows > 0) {
      mysqli_data_seek($sem, 0);
	  $row_sem = mysqli_fetch_assoc($sem);
  }
?>
            </select>
    </div>

    <div class="form-group">
      <label for="address">Course Code:</label>
              <select class="form-control" name="course" id="select2">
	  <option value="">-----------------</option>
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
<div class="form-group" style="text-align:center">
<button name="confirm" type="submit" id="confirm" value="">Confirm</button>
  
    </div>
</form>
<?php
}
@mysqli_free_result(@$ExamOfficerGradeBook);
include('../footer/footer.php');
?>
