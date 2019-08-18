<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Administration';
	$szSubSection = 'Publish Exam';
	$szTitle = 'Publishing and or Unpublishing Exam Results';
	include('lecturerheader.php');
?>

<?php
$currentPage = $_SERVER["PHP_SELF"];

//populate academic year combo box
mysqli_select_db($zalongwa, $database_zalongwa);
$query_AYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AYear = mysqli_query($zalongwa, $query_AYear) or die(mysqli_error());
$row_AYear = mysqli_fetch_assoc($AYear);
$totalRows_AYear = mysqli_num_rows($AYear);

//populate semester combo box
mysqli_select_db($zalongwa, $database_zalongwa);
$query_sem = "SELECT Semester FROM terms ORDER BY Semester ASC";
$sem = mysqli_query($zalongwa, $query_sem) or die(mysqli_error());
$row_sem = mysqli_fetch_assoc($sem);
$totalRows_sem = mysqli_num_rows($sem);

//populate coursecode combo box
mysqli_select_db($zalongwa, $database_zalongwa);
$query_course = "SELECT CourseCode FROM course ORDER BY CourseCode ASC";
$course = mysqli_query($zalongwa, $query_course) or die(mysqli_error());
$row_course = mysqli_fetch_assoc($course);
$totalRows_course = mysqli_num_rows($course);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_Hostel = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$Hostel = mysqli_query($zalongwa, $query_Hostel) or die(mysqli_error());
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
$result = mysqli_query($zalongwa, $query) or die("Siwezi kuingiza data.<br>" . mysqli_error());


echo "Database Update Succeful!";
}else{
//openup a form
?>
<form name="form1" method="post" action="<?php echo $currentPage;?> ">
  <table width="400" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
	  <tr><th colspan="2">PUBLISH EXAMRESULT PROGRAMME WISE</th></tr>
    <tr>
      <th nowrap scope="row"><div align="right">Academic Year: </div></th>
      <td><select name="ayear" id="ayear">
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
      </select></td>
    </tr>
    <tr>
      <th scope="row"><div align="right">Programmme:</div></th>
      <td><select name="programme" id="programme">
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
            </select></td>
    </tr>
    <tr>
      <th scope="row"><div align="right">Semester:</div></th>
      <td><select name="sem" id="sem">
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
            </select></td>
    </tr>
    <!--<tr>
      <th scope="row"><div align="right">Course Code: </div></th>
      <td><select name="course" id="select2">
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
            </select></td>
    </tr>-->
    <tr>
      <th nowrap scope="row"><div align="right">Choose Action:</div></th>
      <td><select name="action" id="select3">
	  <option value="">-----------------</option>
        <option value="1">Publish</option>
        <option value="0">Unpublish</option>
                        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input name="confirm" type="submit" id="confirm" value="Confirm"></td>
    </tr>
  </table>
</form>
<form name="form1" method="post" action="<?php echo $currentPage;?> ">
  <table width="400" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
	  <tr><th colspan="2">PUBLISH EXAMRESULT SEMESTER WISE</th></tr>
    <tr>
      <th nowrap scope="row"><div align="right">Academic Year: </div></th>
      <td><select name="ayear" id="ayear">
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
      </select></td>
    </tr>
    <tr>
      <th scope="row"><div align="right">Semester:</div></th>
      <td><select name="sem" id="sem">
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
            </select></td>
    </tr>
    <!--<tr>
      <th scope="row"><div align="right">Course Code: </div></th>
      <td><select name="course" id="select2">
	  <option value="">-----------------</option>
	   <?php
do {  
?>
                        <option value="<?php echo $row_course['CourseCode']?>"><?php echo $row_course['CourseCode']?></option>
                        <?php
} while ($row_course = mysqli_fetch_assoc($course));
  $rows = mysqli_num_rows($course);
  if($rows > 0) {
      mysql_data_seek($course, 0);
	  $row_course = mysqli_fetch_assoc($course);
  }
?>
            </select></td>
    </tr>-->
    <tr>
      <th nowrap scope="row"><div align="right">Choose Action:</div></th>
      <td><select name="action" id="select3">
	  <option value="">-----------------</option>
        <option value="1">Publish</option>
        <option value="0">Unpublish</option>
                        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input name="confirm" type="submit" id="confirm" value="Confirm"></td>
    </tr>
  </table>
</form>

<?php

}
@mysqli_free_result(@$ExamOfficerGradeBook);
include('../footer/footer.php');
?>
