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
	$szSubSection = 'Publish Exam';
	$szTitle = 'Publishing and or Unpublishing Exam Results';
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

mysqli_select_db($zalongwa, $database_zalongwa);
$query_Hostel = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$Hostel = mysqli_query($zalongwa, $query_Hostel) or die(mysqli_error($zalongwa));
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);



if(isset($_POST['confirm']) && ($_POST['confirm']=='Confirm')){

$currentPage = $_SERVER["PHP_SELF"];
@$key=$_POST['course'];
@$ayear=$_POST['ayear'];
@$sem=$_POST['sem'];
@$act=$_POST['action'];
@$programme=$_POST['programme'];
@$act=$_POST['action'];



$maxRows_ExamOfficerGradeBook = 10000;
$pageNum_ExamOfficerGradeBook = 0;
//check whether to publish or Unpublish


								
	//check whether to publish or Unpublish
	if(intval($act)==1 || intval($act)==0){
		
		$query = "UPDATE examresult LEFT JOIN student ON (examresult.regno)=(student.regno) SET checked='$act' 
					WHERE (AYear='$ayear' AND ProgrammeofStudy='$programme' AND Semester='$sem')";
		$result = mysqli_query($zalongwa, $query);


}
if(intval($act)==1){

//publish results
$query = "UPDATE examresult SET checked = 1 WHERE Semester ='$sem' AND AYear = '$ayear'";
}elseif(intval($act)==0){
//unpublish results
$query = "UPDATE examresult SET checked = 0 WHERE Semester ='$sem' AND AYear = '$ayear'";
}else{
echo "Please Choose Action, Either Publish or Unpublish!";
exit;
}
$result = mysqli_query($zalongwa, $query) or die("Siwezi kuingiza data.<br>" . mysqli_error($zalongwa));


echo "Database Update Succeful!";
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


  <h3 style="text-align:centre">PUBLISH EXAM RESULT PROGRAMME WISE</h3>

 <div class="form-group">
      <label for="institution">Academic Year:</label>
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
      <label for="institution">Programme:</label>
      <select class="form-control"  name="programme" id="programme">
	  <option value="">-----------------</option>
	   <?php
do {  
?>
 <option value="<?php echo $row_Hostel['ProgrammeCode']?>"><?php echo $row_Hostel['ProgrammeName']?></option>
                        <?php
} while ($row_Hostel = mysqli_fetch_assoc($Hostel));
  $totalRows_Hostel = mysqli_num_rows($Hostel);
  if($totalRows_Hostel > 0) {
      mysqli_data_seek($Hostel, 0);
	  $row_Hostel = mysqli_fetch_assoc($Hostel);
  }
?>
            </select>
</div>

<div class="form-group">
      <label for="institution">Semester:</label>
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
      <label for="institution">Choose Action:</label>
      <select class="form-control" name="action" id="select3">
	  <option value="">-----------------</option>
        <option value="1">Publish</option>
        <option value="0">Unpublish</option>
                        </select>
	</div>
	<div class="form-group">
      <button name="confirm" type="submit" id="confirm">Confirm</button>
	</div>
</form>
<form name="form1" method="post" action="<?php echo $currentPage;?> ">
  
 <div class="container"> 
  <h3 style="text-align:centre">PUBLISH EXAM RESULT SEMESTER WISE</h3>

 <div class="form-group">
      <label for="institution">Academic Year:</label>
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
      <label for="institution">Semester:</label>
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

<div class="form-group">
      <label for="institution">Choose Action:</label>
      <select class="form-control" name="action" id="select3">
	  <option value="">-----------------</option>
        <option value="1">Publish</option>
        <option value="0">Unpublish</option>
                        </select>
	</div>
	<div class="form-group">
      <button name="confirm" type="submit" id="confirm">Confirm</button>
	</div>
  
  
</form>

<?php

}
@mysqli_free_result(@$ExamOfficerGradeBook);
include('../footer/footer.php');
?>
