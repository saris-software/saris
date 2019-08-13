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
mysql_select_db($database_zalongwa, $zalongwa);
$query_AYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AYear = mysql_query($query_AYear, $zalongwa) or die(mysql_error());
$row_AYear = mysql_fetch_assoc($AYear);
$totalRows_AYear = mysql_num_rows($AYear);

//populate semester combo box
mysql_select_db($database_zalongwa, $zalongwa);
$query_sem = "SELECT Semester FROM terms ORDER BY Semester ASC";
$sem = mysql_query($query_sem, $zalongwa) or die(mysql_error());
$row_sem = mysql_fetch_assoc($sem);
$totalRows_sem = mysql_num_rows($sem);

//populate coursecode combo box
mysql_select_db($database_zalongwa, $zalongwa);
$query_course = "SELECT CourseCode FROM course ORDER BY CourseCode ASC";
$course = mysql_query($query_course, $zalongwa) or die(mysql_error());
$row_course = mysql_fetch_assoc($course);
$totalRows_course = mysql_num_rows($course);

mysql_select_db($database_zalongwa, $zalongwa);
$query_Hostel = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$Hostel = mysql_query($query_Hostel, $zalongwa) or die(mysql_error());
$row_Hostel = mysql_fetch_assoc($Hostel);
$totalRows_Hostel = mysql_num_rows($Hostel);



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
		$result = mysql_query($query);


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
$result = mysql_query($query) or die("Siwezi kuingiza data.<br>" . mysql_error());


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
} while ($row_AYear = mysql_fetch_assoc($AYear));
  $rows = mysql_num_rows($AYear);
  if($rows > 0) {
      mysql_data_seek($AYear, 0);
	  $row_AYear = mysql_fetch_assoc($AYear);
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
} while ($row_Hostel = mysql_fetch_assoc($Hostel));
  $totalRows_Hostel = mysql_num_rows($Hostel);
  if($totalRows_Hostel > 0) {
      mysql_data_seek($Hostel, 0);
	  $row_Hostel = mysql_fetch_assoc($Hostel);
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
} while ($row_sem = mysql_fetch_assoc($sem));
  $rows = mysql_num_rows($sem);
  if($rows > 0) {
      mysql_data_seek($sem, 0);
	  $row_sem = mysql_fetch_assoc($sem);
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
} while ($row_course = mysql_fetch_assoc($course));
  $rows = mysql_num_rows($course);
  if($rows > 0) {
      mysql_data_seek($course, 0);
	  $row_course = mysql_fetch_assoc($course);
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
} while ($row_AYear = mysql_fetch_assoc($AYear));
  $rows = mysql_num_rows($AYear);
  if($rows > 0) {
      mysql_data_seek($AYear, 0);
	  $row_AYear = mysql_fetch_assoc($AYear);
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
} while ($row_sem = mysql_fetch_assoc($sem));
  $rows = mysql_num_rows($sem);
  if($rows > 0) {
      mysql_data_seek($sem, 0);
	  $row_sem = mysql_fetch_assoc($sem);
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
} while ($row_course = mysql_fetch_assoc($course));
  $rows = mysql_num_rows($course);
  if($rows > 0) {
      mysql_data_seek($course, 0);
	  $row_course = mysql_fetch_assoc($course);
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
@mysql_free_result(@$ExamOfficerGradeBook);
include('../footer/footer.php');
?>
