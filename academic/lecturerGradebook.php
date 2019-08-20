<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Grade Book';
	$szTitle = 'Examination GradeBook';
	include('lecturerheader.php');

#save user statistics
$browser  = $_SERVER["HTTP_USER_AGENT"];   
$ip  =  $_SERVER["REMOTE_ADDR"];   
$sql="INSERT INTO stats(ip,browser,received,page) VALUES('$ip','$browser',now(),'$username')";   
$result = mysqli_query($zalongwa, $sql) or die("Siwezi kuingiza data.<br>" . mysqli_error());

#Control Refreshing the page
#if not refreshed set refresh = 0
@$refresh = 0;
#------------
#populate academic year combo box
mysqli_select_db($zalongwa, $database_zalongwa);
$query_AYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AYear = mysqli_query($zalongwa, $query_AYear) or die(mysqli_error());
$row_AYear = mysqli_fetch_assoc($AYear);
$totalRows_AYear = mysqli_num_rows($AYear);

//check if is a Departmental examination officer
$query_userdept = "SELECT Dept FROM security where UserName = '$username' AND Dept<>0";
$userdept = mysqli_query($zalongwa, $query_userdept) or die(mysqli_error());
$row_userdept = mysqli_fetch_assoc($userdept);
$totalRows_userdept = mysqli_num_rows($userdept);
mysqli_select_db($zalongwa, $database_zalongwa);

//check if is Faculty examination officer
$query_userfac = "SELECT Faculty FROM security where UserName = '$username' AND Dept=0";
$userfac = mysqli_query($zalongwa, $query_userfac) or die(mysqli_error());
$row_userfac = mysqli_fetch_assoc($userfac);
$totalRows_userfac = mysqli_num_rows($userfac);
$fac = $row_userfac["Faculty"];

if($totalRows_userdept>0){
							$query_dept = "SELECT department.DeptName
							FROM department
							INNER JOIN security ON (department.DeptID = security.Dept)
							WHERE 
							   (
								  (UserName = '$username')
							   )
							ORDER BY department.DeptName";
  }elseif($privilege == 2){
						$query_dept = "SELECT FacultyID, FacultyName FROM faculty 
										WHERE
											(
												(FacultyID = '$fac')
											)";
						}else{
								$query_dept = "SELECT DeptID, DeptName	FROM department 
								ORDER BY DeptName ASC";
								}
								
$dept = mysqli_query($zalongwa, $query_dept) or die(mysqli_error());
$row_dept = mysqli_fetch_assoc($dept);
$totalRows_dept = mysqli_num_rows($dept);

#process form submission
$editFormAction = $_SERVER['PHP_SELF'];
if ((isset($_POST["frmSubmit"])) && ($_POST["frmSubmit"] == "yes")) {
#set refresh = 1
$refresh = 1;

#..............
@$ayear = addslashes($_POST['ayear']);
@$faculty = addslashes($_POST['faculty']);
@$sem = $_POST['sem'];

if($sem=="choice"){
	echo "<p>Choose Semester of Study First<p>";
	exit;
}

#populate examcayegory combo box
mysqli_select_db($zalongwa, $database_zalongwa);

if($fac==1){
$query_examcategory = "SELECT Id,Description FROM examcategory WHERE (Id > 2) ORDER BY Id";
}
else{
$query_examcategory = "SELECT Id,Description FROM examcategory ORDER BY Id";
}
$examcategory = mysqli_query($zalongwa, $query_examcategory) or die(mysqli_error());
$row_examcategory = mysqli_fetch_assoc($examcategory);
$totalRows_examcategory = mysqli_num_rows($examcategory);

#populate Exam Marker combo box
mysqli_select_db($zalongwa, $database_zalongwa);
$query_exammarker = "SELECT Id, Name FROM exammarker ORDER BY Name";
$exammarker = mysqli_query($zalongwa, $query_exammarker) or die(mysqli_error());
$row_exammarker = mysqli_fetch_assoc($exammarker);
$totalRows_exammarker = mysqli_num_rows($exammarker);

#populate CourseCode combo box
/*
if ($privilege ==3) {
$query_coursecode = "
		SELECT DISTINCT course.CourseCode, 
						examregister.AYear
		FROM examregister 
			INNER JOIN course ON (examregister.CourseCode = course.CourseCode)
		WHERE (examregister.AYear ='$ayear') 
		AND (examregister.RegNo='$username')  ORDER BY examregister.CourseCode ASC";
}else{
$query_coursecode = "
		SELECT DISTINCT course.CourseCode, 
						examregister.AYear
		FROM examregister 
			INNER JOIN course ON (examregister.CourseCode = course.CourseCode)
		WHERE (examregister.AYear ='$ayear') 
		AND (course.Faculty = '$faculty') ORDER BY examregister.CourseCode ASC";
}
*/
if ($privilege ==3) {
$query_coursecode = "
		SELECT DISTINCT course.CourseCode, 
						examregister.AYear
		FROM examregister 
			INNER JOIN course ON (examregister.CourseCode = course.CourseCode)
		WHERE (examregister.AYear ='$ayear') 
		AND (examregister.RegNo='$username')  ORDER BY examregister.CourseCode ASC";
}else{
$query_coursecode = "
		SELECT DISTINCT CourseCode
		FROM course 
		WHERE 
		 (Faculty = '$fac') ORDER BY CourseCode ASC";
}


$coursecode = mysqli_query($zalongwa, $query_coursecode) or die(mysqli_error());

?>
 <fieldset>
	<legend>Select Appropriate Entries</legend>
	<?php 
	echo $_POST['sem'].' - '.$_POST['ayear'];
	?>
		<form action="lecturerGradebookAdd.php" method="post" enctype="multipart/form-data" name="frmCourse" target="_self">
						
		<table width="200" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <th nowrap="nowrap" bgcolor="#999999" scope="col">Module Code 
				<input name="ayear" type="hidden" value="<?php echo $ayear ?>">
				<input name="sem" type="hidden" value="<?php echo $_POST['sem'] ?>">
			</th>
            <th nowrap="nowrap" bgcolor="#999999" scope="col">Exam Category </th>
            <th nowrap="nowrap" bgcolor="#999999" scope="col">Exam Date </th>
            <th nowrap="nowrap" bgcolor="#999999" scope="col">Show Class Roster </th>
          </tr>
          <tr>
            <td bgcolor="#999999"><select name="course" size="1">
              <option value="0">[Select Course Code]</option>
              <?php
				do {  
						?>
              <option value="<?php echo $row_coursecode['CourseCode']?>"><?php echo $row_coursecode['CourseCode']?></option>
              <?php
							} while ($row_coursecode = mysqli_fetch_assoc($coursecode));
									$rows = mysqli_num_rows($coursecode);
									if($rows > 0) {
						mysqli_data_seek($coursecode, 0);
						$row_coursecode = mysqli_fetch_assoc($coursecode);
  					}
               ?>
            </select></td>
            <td bgcolor="#999999"><select name="examcat" size="1">
              <option value="0">[Select Examcategory]</option>
              <?php
				do {  
						?>
              <option value="<?php echo $row_examcategory['Id']?>"><?php echo $row_examcategory['Description']?></option>
              <?php
							} while ($row_examcategory = mysqli_fetch_assoc($examcategory));
									$rows = mysqli_num_rows($examcategory);
									if($rows > 0) {
						mysqli_data_seek($examcategory, 0);
						$row_examcategory = mysqli_fetch_assoc($examcategoryr);
  					}
               ?>
            </select></td>
            <td bgcolor="#999999">			<!-- A Separate Layer for the Calendar -->
					<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>
					 <table border="0">
									<tr>
										<td><input name="examdate" type="text" size="10" maxlength="10"></td>
										<td><input type="button" class="button" name="rpDate_button" value="Pick Date" onClick="show_calendar('frmCourse.examdate', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=325;PopupY=325;')"></td>
									</tr>
		    </table></td>
            <td bgcolor="#999999"><div align="center">
              <input name="view" type="submit" value="Edit Records" />
            </div></td>
          </tr>
        </table>
		</form>			
 </fieldset>
<?php
//end of the form display
}

#display the form when refresh is zero
if ($refresh == 0) {
?> 
 <fieldset>
				<legend>Select Appropriate Academic Year and Faculty</legend>
<form action="<?php echo $editFormAction ?>" method="post" enctype="multipart/form-data" name="form1">
              <table width="200" border="0" cellpadding="0" cellspacing="1">
                <tr>
                  <td nowrap><div align="right">Academic Year: </div></td>
                  <td><select name="ayear" id="ayear">
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
                  <td nowrap><div align="right">Semester: </div></td>
                  <td><select name="sem" id="sem">
						<option value="choice">Choose Semester</option>
                        <?php
mysqli_select_db($zalongwa, $database_zalongwa);
$query_sem = "SELECT Semester FROM terms ORDER BY Semester Limit 2";
$sem = mysqli_query($zalongwa, $query_sem);
$row_sem = mysqli_fetch_assoc($sem);
$totalRows_sem = mysqli_num_rows($sem);
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
                  </td>
                </tr>
			<?php if ($privilege =='2') { ?>
                <tr>
                  <td nowrap><div align="right">Faculty:</div></td>
                  <td><select name="faculty" id="faculty">
                      <?php
do {  
?>
                      <option value="<?php echo $row_dept['FacultyID']?>"><?php echo $row_dept['FacultyName']?></option>
                      <?php
} while ($row_dept = mysqli_fetch_assoc($dept));
  $rows = mysqli_num_rows($dept);
  if($rows > 0) {
      mysqli_data_seek($dept, 0);
	  $row_dept = mysqli_fetch_assoc($dept);
  }
?>
                  </select></td>
                </tr>
				<?php } ?>
                <tr>
                  <td><input name="frmSubmit" type="hidden" id="frmSubmit" value="yes"></td>
                  <td><input type="submit" name="action" value="View Courses"></td>
                </tr>
  </table>
</form>
</fieldset>
<?php
}
include('../footer/footer.php');
?>
