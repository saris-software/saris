<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Statement';
	$szTitle = 'Statement of Examination Results';
	include('lecturerheader.php');
$editFormAction = $_SERVER['PHP_SELF'];

mysqli_select_db($zalongwa,$database_zalongwa);
$query_studentlist = "SELECT RegNo, Name, ProgrammeofStudy FROM student ORDER BY ProgrammeofStudy  ASC";
$studentlist = mysqli_query($zalongwa,$query_studentlist) or die(mysqli_error($zalongwa));
$row_studentlist = mysqli_fetch_assoc($studentlist);
$totalRows_studentlist = mysqli_num_rows($studentlist);

mysqli_select_db($zalongwa,$database_zalongwa);
$query_degree = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$degree = mysqli_query($zalongwa,$query_degree) or die(mysqli_error($zalongwa));
$row_degree = mysqli_fetch_assoc($degree);
$totalRows_degree = mysqli_num_rows($degree);

mysqli_select_db($zalongwa,$database_zalongwa);
$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$ayear = mysqli_query($zalongwa,$query_ayear) or die(mysqli_error($zalongwa));
$row_ayear = mysqli_fetch_assoc($ayear);
$totalRows_ayear = mysqli_num_rows($ayear);

mysqli_select_db($zalongwa,$database_zalongwa);
$query_dept = "SELECT Faculty, DeptName FROM department ORDER BY DeptName, Faculty ASC";
$dept = mysqli_query($zalongwa,$query_dept) or die(mysqli_error($zalongwa));
$row_dept = mysqli_fetch_assoc($dept);
$totalRows_dept = mysqli_num_rows($dept);
?>
<?php
			
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

<h4 align="center">

<?php 
$prog=$_POST['degree'];
$cohotyear = $_POST['cohot'];
$ayear = $_POST['ayear'];
$qprog= "SELECT ProgrammeCode, Title FROM programme WHERE ProgrammeCode='$prog'";
$dbprog = mysqli_query($zalongwa,$qprog);
$row_prog = mysqli_fetch_array($dbprog);
$progname = $row_prog['Title'];
$qyear= "SELECT AYear FROM academicyear WHERE AYear='$cohotyear'";
$dbyear = mysqli_query($zalongwa,$qyear);
$row_year = mysqli_fetch_array($dbyear);
$year = $row_year['AYear'];
echo $progname;
echo " - ".$year;
echo "<br><br>Examination Results for Academic Year - ".$ayear;
?>
<br>
</h4>
<?php

//$reg = $_POST['regno'];
@$checkdegree = addslashes($_POST['checkdegree']);
@$checkyear = addslashes($_POST['checkyear']);
@$checkdept = addslashes($_POST['checkdept']);
$checkcohot = addslashes($_POST['checkcohot']);

$c=0;

if (($checkdegree=='on') && ($checkcohot == 'on') && ($checkdept == 'on') && ($checkyear == 'on')){
//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
$dbstudent = mysqli_query($zalongwa,$qstudent);
$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
			$gpoints = 0;
			$gunits = 0;
			
			//query depts where the student has courses registered for
			$qdept = " SELECT DISTINCT examresult.CourseCode, Grade
						FROM course
						   INNER JOIN department ON (course.Department = department.DeptName)
						   INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
						WHERE 
						   (
							  (examresult.RegNo = '$regno') AND
							  (course.Department = '$dept') AND
							  (examresult.AYear = '$year')
						    )";
			
			$dbdept = mysqli_query($zalongwa,$qdept);
			$dbdeptUnit = mysqli_query($zalongwa,$qdept);
			$dbdeptGrade = mysqli_query($zalongwa,$qdept);
			
			?>
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="20" rowspan="2" nowrap scope="col"><div align="left"></div> <?php echo $i ?></td>
					<td width="160" rowspan="2" nowrap scope="col"><?php echo $name.": ".$regno; ?> </td>
					<td width="13" rowspan="2" nowrap><div align="center"><?php echo $sex ?></div></td>
							<?php while($rowdept = mysqli_fetch_array($dbdept)) { ?>
							<td><div align="center"><?php echo $rowdept['CourseCode']; ?></div></td> 
							<?php } ?>
							<td><div align="center">Units</div></td>
							<td><div align="center">Points</div></td>
							<td><div align="center">GPA</div></td>
							<td><div align="center">Grade</div></td>
							<td scope="col">Remarks</td>
				  </tr>
				  <tr>
							<?php while($rowdeptUnit = mysqli_fetch_array($dbdeptUnit)) { ?>
							<td><div align="center"><?php echo $rowdeptUnit['Grade']; ?></div></td>
							<?php }?>
							<?php @$updateSQL = "SELECT 
										   examresult.RegNo,
										   examresult.ExamNo,
										   examresult.CourseCode,
										   course.Units,
										   examresult.Grade,
										   examresult.AYear,
										   examresult.Remarks,
										   examresult.Status,
										   examresult.SemesterID,
										   examresult.Comment,
										   course.Department
							FROM course
						       INNER JOIN department ON (course.Department = department.DeptName)
						       INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
							WHERE 
										   (
											(examresult.RegNo = '$regno') AND
											(examresult.AYear = '$year')  AND
											(checked=1) AND (Count=0) 
											
										   )";
           	$result = mysqli_query($zalongwa,$updateSQL) or die("Mwanafunzi huyu hana matokeo");
			$query = @mysqli_query($zalongwa,$updateSQL) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
							
			if (mysqli_num_rows($query) > 0){
					$totalunit=0;
					$unittaken=0;
					$sgp=0;
					$totalsgp=0;
					$gpa=0;	
			
				while($result = mysqli_fetch_array($query)) {
					$unit = $result['Units'];
					$totalunit=$totalunit+$unit;
					$ayear = $result['AYear'];
					$remarks = $result['Remarks'];
					$status = $result['Status'];
					$grade = $result['Grade'];
					$comment = $result['Comment'];						
					if ($grade=='A'){
							$point=5;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='B+'){
							$point=4;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='B'){
							$point=3;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='C'){
							$point=2;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='D'){
							$point=1;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='E'){
							$point=0;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}else
							$sgp='';
							
					$coursecode = $result['CourseCode'];
					}?>
					<td><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?></div></td>
					<td><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?></div></td>
					<td><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa; ?></div></td>
					<td><div align="center"><?php if ($gpa  >= 4.4){
								echo 'A';
											}
							elseif ($gpa >= 3.5){
								echo 'B+';
								}
							elseif ($gpa >= 2.7){
								echo 'B';
								}
							elseif ($gpa >= 2.0){
								echo 'C';
								}
							elseif ($gpa >= 1.0){
								echo 'D';
								}
							else{
								echo 'E';
								}
					?></div></td>
					<?php }$i=$i+1;
						?>
						    <td><div align="left">
							
							<?php //search supplimentaru exam
							 $qsupp = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'Fail')";
								$dbsupp = mysqli_query($zalongwa,$qsupp);
								$dbsupptotal = mysqli_query($zalongwa,$qsupp);
								$total = mysqli_num_rows($dbsupptotal);
								//search special exam
								$qinc = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'I')";
								$dbqinc = @mysqli_query($zalongwa,$qinc);
								$dbinctotal = mysqli_query($zalongwa,$qinc);
								$totalinc = mysqli_num_rows($dbinctotal);
								
								if($total >0){
									echo "Supp: ";
									while($rowsupp = mysqli_fetch_array($dbsupp)) {
									echo $rowsupp['CourseCode'].", ";
									} 
									//echo "\n";
									//$pass = "n";
								}
								/*
								else{
								echo "PASS";
								}
								*/
								
								if($totalinc >0){
										echo "SE: ";
										while($rowinc = @mysqli_fetch_array($dbqinc)) {
										echo $rowinc['CourseCode'] .", ";
										}
								//echo "\n";
								//$pass = "n";
								}
								/*
								if ($pass == "n") {
								}else{
								echo "PASS";
								}*/

							?></div></td>
					<?php }
					?>
			  </tr>      			
</table>
			<?php }elseif (($checkdegree=='on') && ($checkyear == 'on') && ($checkcohot == 'on')){

$deg=addslashes($_POST['degree']);
$year = addslashes($_POST['ayear']);
$cohot = addslashes($_POST['cohot']);
$dept = addslashes($_POST['dept']);

//query student list
$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
$dbstudent = mysqli_query($zalongwa,$qstudent);
$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];

			# get all courses for this candidate
			$qcourse="SELECT DISTINCT course.Units, examresult.CourseCode FROM 
						course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
							 WHERE RegNo='$regno' AND AYear='$year'";	
			$dbcourse = mysqli_query($zalongwa,$qcourse) or die("No Exam Results for the Candidate - $key ");
			$dbcourseUnit = mysqli_query($zalongwa,$qcourse);
			$total_rows = mysqli_num_rows($dbcourse);
			
			if($total_rows>0){

			#initialise
			$totalunit=0;
			$unittaken=0;
			$sgp=0;
			$totalsgp=0;
			$gpa=0;
			$key = $regno; 
			?>
			
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="20" rowspan="2" nowrap scope="col"><div align="left"></div> <?php echo $i ?></td>
					<td width="160" rowspan="2" nowrap scope="col"><?php echo $name.": ".$regno; ?> </td>
					<td width="13" rowspan="2" nowrap><div align="center"><?php echo $sex ?></div></td>
							<?php while($rowcourse = mysqli_fetch_array($dbcourse)) { ?>
							<td><div align="center"><?php echo $rowcourse['CourseCode']; ?></div></td> 
							<?php } ?>
							<td><div align="center">Units</div></td>
							<td><div align="center">Points</div></td>
							<td><div align="center">GPA</div></td>
							<td><div align="center">Grade</div></td>
							<td scope="col">Remarks</td>
				  </tr>
				  <tr>
					<?php while($row_course = mysqli_fetch_array($dbcourseUnit)){
						$course= $row_course['CourseCode'];
						$unit = $row_course['Units'];
						$name = $row_course['CourseName'];
						$sn=$sn+1;
						$remarks = 'remarks';
						
						#query Assignment One
						$qass1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=1";
						$dbass1=mysqli_query($zalongwa,$qass1);
						$total_ass1 = mysqli_num_rows($dbass1);
						if($total_ass1>0){
							$row_ass1=mysqli_fetch_array($dbass1);
							$ass1date=$row_ass1['ExamDate'];
							$ass1score=$row_ass1['ExamScore'];
						}else{
							$remarks = "Inc";
							$ass1score='';
						}
						#query Assignment Two
						$qass2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=2";
						$dbass2=mysqli_query($zalongwa,$qass2);
						$total_ass2 = mysqli_num_rows($dbass2);
						if($total_ass2>0){
							$row_ass2=mysqli_fetch_array($dbass2);
							$ass2date=$row_ass2['ExamDate'];
							$ass2score=$row_ass2['ExamScore'];
						}else{
							$remarks = "Inc";
							$ass2score='';
						}
						#query Test One
						$qtest1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=3";
						$dbtest1=mysqli_query($zalongwa,$qtest1);
						$total_test1 = mysqli_num_rows($dbtest1);
						if($total_test1>0){
							$row_test1=mysqli_fetch_array($dbtest1);
							$test1date=$row_test1['ExamDate'];
							$test1score=$row_test1['ExamScore'];
						}else{
							$remarks = "Inc";
							$test1score='';
						}
						#query Test Two
						$qtest2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=4";
						$dbtest2=mysqli_query($zalongwa,$qtest2);
						$total_test2 = mysqli_num_rows($dbtest2);
						if($total_test2>0){
							$row_test2=mysqli_fetch_array($dbtest2);
							$test2date=$row_test2['ExamDate'];
							$test2score=$row_test2['ExamScore'];
						}else{
							$remarks = "Inc";
							$test2score='';
						}
		
						#query Annual Exam
						$qae = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=5";
						$dbae=mysqli_query($zalongwa,$qae);
						$total_ae = mysqli_num_rows($dbae);
						if($total_ae>0){
							$row_ae=mysqli_fetch_array($dbae);
							$aedate=$row_ae['ExamDate'];
							$aescore=$row_ae['ExamScore'];
						}else{
							$remarks = "Inc";
							$aescore='';
						}
						
						#query Special Exam
						$qsp = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=7";
						$dbsp=mysqli_query($zalongwa,$qsp);
						$row_sp=mysqli_fetch_array($dbsp);
						$row_sp_total=mysqli_num_rows($dbsp);
						if($row_sp_total>0){
							$spdate=$row_sp['ExamDate'];
							$spcore=$row_sp['ExamScore'];
							$remarks = "sp";
						}
						
						#Check if has a Supplimentatary Exam
						$qsup = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=6";
						$dbsup=mysqli_query($zalongwa,$qsup);
						$row_sup=mysqli_fetch_array($dbsup);
						$row_sup_total=mysqli_num_rows($dbsup);
						$supdate=$row_sup['ExamDate'];
						$supscore=$row_sup['ExamScore'];
		
						#get total marks
						if ($row_sup_total>0){
							$marks=$supscore;
						}elseif($row_sp_total>0){
							$marks = $ass1score + $ass2score + $test1score + $test2score + $spcore;
						}else{
							$marks = $ass1score + $ass2score + $test1score + $test2score + $aescore;
						}
													
						#grade marks
						if($remarks =='Inc'){
						$grade='I';
						$remark = 'Inc.';
						$point=0;
						$sgp=$point*$unit;
						$totalsgp=$totalsgp+$sgp;
						$unittaken=$unittaken+$unit;
						}else{
							if($marks>=70){
								$grade='A';
								$remark = 'PASS';
								$point=5;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}elseif($marks>=60){
								$grade='B+';
								$remark = 'PASS';
								$point=4;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}elseif($marks>=50){
								$grade='B';
								$remark = 'PASS';
								$point=3;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}elseif($marks>=40){
								$grade='C';
								$remark = 'PASS';
								$point=2;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}elseif($marks>=30){
								$grade='D';
								$remark = 'FAIL';
								$point=1;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}else{
								$grade='E';
								$remark = 'FAIL';
								$point=0;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}
				}//	ends grade remarks
				?>
				
				<td><div align="center"><?php echo $grade;?></div></td>
				<?php } //ends while row_course loop
				
				?>
				<td><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?></div></td>
				<td><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?></div></td>
				<td><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa; ?></div></td>
				<td><div align="center"><?php if ($gpa  >= 4.4){
							$remark = 'PASS';
							echo 'A';
										}
						elseif ($gpa >= 3.5){
							$remark = 'PASS';
							echo 'B+';
							}
						elseif ($gpa >= 2.7){
							$remark = 'PASS';
							echo 'B';
							}
						elseif ($gpa >= 2.0){
							$remark = 'PASS';
							echo 'C';
							}
						elseif ($gpa >= 1.0){
							$remark = 'FAIL';
							echo 'D';
							}
						else{
							$remark = 'FAIL';
							echo 'E';
							}
				?></div></td>
				<td><div align="left">
					<?php echo $remark;
					?>	
		      </div></td>
		    </tr>
         </table>
         <?php $i=$i+1;
		   } //ends if $total_rows
		}//ends $rowstudent loop

}elseif (($checkdegree=='on') && ($checkcohot == 'on') && ($checkdept == 'on')){
//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
$dbstudent = mysqli_query($zalongwa,$qstudent);
$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
			$gpoints = 0;
			$gunits = 0;
			
			//query depts where the student has courses registered for
			$qdept = " SELECT DISTINCT examresult.CourseCode, Grade
						FROM course
						   INNER JOIN department ON (course.Department = department.DeptName)
						   INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
						WHERE 
						   (
							  (examresult.RegNo = '$regno') AND
							  (course.Department = '$dept') 
						    )";
			
			$dbdept = mysqli_query($zalongwa,$qdept);
			$dbdeptUnit = mysqli_query($zalongwa,$qdept);
			$dbdeptGrade = mysqli_query($zalongwa,$qdept);
			
			?>
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="20" rowspan="2" nowrap scope="col"><div align="left"></div> <?php echo $i ?></td>
					<td width="160" rowspan="2" nowrap scope="col"><?php echo $name.": ".$regno; ?> </td>
					<td width="13" rowspan="2" nowrap><div align="center"><?php echo $sex ?></div></td>
							<?php while($rowdept = mysqli_fetch_array($dbdept)) { ?>
							<td><div align="center"><?php echo $rowdept['CourseCode']; ?></div></td> 
							<?php } ?>
							<td><div align="center">Units</div></td>
							<td><div align="center">Points</div></td>
							<td><div align="center">GPA</div></td>
							<td><div align="center">Grade</div></td>
							<td scope="col">Remarks</td>
				  </tr>
				  <tr>
							<?php while($rowdeptUnit = mysqli_fetch_array($dbdeptUnit)) { ?>
							<td><div align="center"><?php echo $rowdeptUnit['Grade']; ?></div></td>
							<?php }?>
							<?php @$updateSQL = "SELECT 
										   examresult.RegNo,
										   examresult.ExamNo,
										   examresult.CourseCode,
										   course.Units,
										   examresult.Grade,
										   examresult.AYear,
										   examresult.Remarks,
										   examresult.Status,
										   examresult.SemesterID,
										   examresult.Comment,
										   course.Department
							FROM course
						       INNER JOIN department ON (course.Department = department.DeptName)
						       INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
							WHERE 
										   (
											(examresult.RegNo = '$regno') AND
											(examresult.AYear = '$year')  AND
											(checked=1) AND (Count=0) 
											
										   )";
           	$result = mysqli_query($zalongwa,$updateSQL) or die("Mwanafunzi huyu hana matokeo");
			$query = @mysqli_query($zalongwa,$updateSQL) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
							
			if (mysqli_num_rows($query) > 0){
					$totalunit=0;
					$unittaken=0;
					$sgp=0;
					$totalsgp=0;
					$gpa=0;	
			
				while($result = mysqli_fetch_array($query)) {
					$unit = $result['Units'];
					$totalunit=$totalunit+$unit;
					$ayear = $result['AYear'];
					$remarks = $result['Remarks'];
					$status = $result['Status'];
					$grade = $result['Grade'];
					$comment = $result['Comment'];						
					if ($grade=='A'){
							$point=5;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='B+'){
							$point=4;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='B'){
							$point=3;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='C'){
							$point=2;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='D'){
							$point=1;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}elseif($grade=='E'){
							$point=0;
							$sgp=$point*$unit;
							$totalsgp=$totalsgp+$sgp;
							$unittaken=$unittaken+$unit;
						}else
							$sgp='';
							
					$coursecode = $result['CourseCode'];
					}?>
					<td><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?></div></td>
					<td><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?></div></td>
					<td><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa; ?></div></td>
					<td><div align="center"><?php if ($gpa  >= 4.4){
								echo 'A';
											}
							elseif ($gpa >= 3.5){
								echo 'B+';
								}
							elseif ($gpa >= 2.7){
								echo 'B';
								}
							elseif ($gpa >= 2.0){
								echo 'C';
								}
							elseif ($gpa >= 1.0){
								echo 'D';
								}
							else{
								echo 'E';
								}
					?></div></td>
					<?php }$i=$i+1;
						?>
						    <td><div align="left">
							
							<?php //search supplimentaru exam
							 $qsupp = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'Fail')";
								$dbsupp = mysqli_query($zalongwa,$qsupp);
								$dbsupptotal = mysqli_query($zalongwa,$qsupp);
								$total = mysqli_num_rows($dbsupptotal);
								//search special exam
								$qinc = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'I')";
								$dbqinc = @mysqli_query($zalongwa,$qinc);
								$dbinctotal = mysqli_query($zalongwa,$qinc);
								$totalinc = mysqli_num_rows($dbinctotal);
								
								if($total >0){
									echo "Supp: ";
									while($rowsupp = mysqli_fetch_array($dbsupp)) {
									echo $rowsupp['CourseCode'].", ";
									} 
									//echo "\n";
									//$pass = "n";
								}
								/*
								else{
								echo "PASS";
								}
								*/
								
								if($totalinc >0){
										echo "SE: ";
										while($rowinc = @mysqli_fetch_array($dbqinc)) {
										echo $rowinc['CourseCode'] .", ";
										}
								//echo "\n";
								//$pass = "n";
								}
								/*
								if ($pass == "n") {
								}else{
								echo "PASS";
								}*/

							?></div></td>
					<?php }
					?>
			  </tr>       			
</table>
			<?php }elseif (($checkdegree=='on') && ($checkcohot == 'on')){				
//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

//query student list
$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
$dbstudent = mysqli_query($zalongwa,$qstudent);
$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];

			# get all courses for this candidate
			$qcourse="SELECT DISTINCT course.Units, examresult.CourseCode FROM 
						course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
							 WHERE RegNo='$regno'";	
			$dbcourse = mysqli_query($zalongwa,$qcourse) or die("No Exam Results for the Candidate - $key ");
			$dbcourseUnit = mysqli_query($zalongwa,$qcourse);
			$total_rows = mysqli_num_rows($dbcourse);
			
			if($total_rows>0){

			#initialise
			$totalunit=0;
			$unittaken=0;
			$sgp=0;
			$totalsgp=0;
			$gpa=0;
			$key = $regno; 
			?>
			
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="20" rowspan="2" nowrap scope="col"><div align="left"></div> <?php echo $i ?></td>
					<td width="160" rowspan="2" nowrap scope="col"><?php echo $name.": ".$regno; ?> </td>
					<td width="13" rowspan="2" nowrap><div align="center"><?php echo $sex ?></div></td>
							<?php while($rowcourse = mysqli_fetch_array($dbcourse)) { ?>
							<td><div align="center"><?php echo $rowcourse['CourseCode']; ?></div></td> 
							<?php } ?>
							<td><div align="center">Units</div></td>
							<td><div align="center">Points</div></td>
							<td><div align="center">GPA</div></td>
							<td><div align="center">Grade</div></td>
							<td scope="col">Remarks</td>
				  </tr>
				  <tr>
					<?php while($row_course = mysqli_fetch_array($dbcourseUnit)){
						$course= $row_course['CourseCode'];
						$unit = $row_course['Units'];
						$name = $row_course['CourseName'];
						$sn=$sn+1;
						$remarks = 'remarks';
						
						#query Assignment One
						$qass1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=1";
						$dbass1=mysqli_query($zalongwa,$qass1);
						$total_ass1 = mysqli_num_rows($dbass1);
						if($total_ass1>0){
							$row_ass1=mysqli_fetch_array($dbass1);
							$ass1date=$row_ass1['ExamDate'];
							$ass1score=$row_ass1['ExamScore'];
						}else{
							$remarks = "Inc";
							$ass1score='';
						}
						#query Assignment Two
						$qass2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=2";
						$dbass2=mysqli_query($zalongwa,$qass2);
						$total_ass2 = mysqli_num_rows($dbass2);
						if($total_ass2>0){
							$row_ass2=mysqli_fetch_array($dbass2);
							$ass2date=$row_ass2['ExamDate'];
							$ass2score=$row_ass2['ExamScore'];
						}else{
							$remarks = "Inc";
							$ass2score='';
						}
						#query Test One
						$qtest1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=3";
						$dbtest1=mysqli_query($zalongwa,$qtest1);
						$total_test1 = mysqli_num_rows($dbtest1);
						if($total_test1>0){
							$row_test1=mysqli_fetch_array($dbtest1);
							$test1date=$row_test1['ExamDate'];
							$test1score=$row_test1['ExamScore'];
						}else{
							$remarks = "Inc";
							$test1score='';
						}
						#query Test Two
						$qtest2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=4";
						$dbtest2=mysqli_query($zalongwa,$qtest2);
						$total_test2 = mysqli_num_rows($dbtest2);
						if($total_test2>0){
							$row_test2=mysqli_fetch_array($dbtest2);
							$test2date=$row_test2['ExamDate'];
							$test2score=$row_test2['ExamScore'];
						}else{
							$remarks = "Inc";
							$test2score='';
						}
		
						#query Annual Exam
						$qae = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=5";
						$dbae=mysqli_query($zalongwa,$qae);
						$total_ae = mysqli_num_rows($dbae);
						if($total_ae>0){
							$row_ae=mysqli_fetch_array($dbae);
							$aedate=$row_ae['ExamDate'];
							$aescore=$row_ae['ExamScore'];
						}else{
							$remarks = "Inc";
							$aescore='';
						}
						
						#query Special Exam
						$qsp = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=7";
						$dbsp=mysqli_query($zalongwa,$qsp);
						$row_sp=mysqli_fetch_array($dbsp);
						$row_sp_total=mysqli_num_rows($dbsp);
						if($row_sp_total>0){
							$spdate=$row_sp['ExamDate'];
							$spcore=$row_sp['ExamScore'];
							$remarks = "sp";
						}
						
						#Check if has a Supplimentatary Exam
						$qsup = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$key' AND ExamCategory=6";
						$dbsup=mysqli_query($zalongwa,$qsup);
						$row_sup=mysqli_fetch_array($dbsup);
						$row_sup_total=mysqli_num_rows($dbsup);
						$supdate=$row_sup['ExamDate'];
						$supscore=$row_sup['ExamScore'];
		
						#get total marks
						if ($row_sup_total>0){
							$marks=$supscore;
						}elseif($row_sp_total>0){
							$marks = $ass1score + $ass2score + $test1score + $test2score + $spcore;
						}else{
							$marks = $ass1score + $ass2score + $test1score + $test2score + $aescore;
						}
													
						#grade marks
						if($remarks =='Inc'){
						$grade='I';
						$remark = 'Inc.';
						$point=0;
						$sgp=$point*$unit;
						$totalsgp=$totalsgp+$sgp;
						$unittaken=$unittaken+$unit;
						}else{
							if($marks>=70){
								$grade='A';
								$remark = 'PASS';
								$point=5;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}elseif($marks>=60){
								$grade='B+';
								$remark = 'PASS';
								$point=4;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}elseif($marks>=50){
								$grade='B';
								$remark = 'PASS';
								$point=3;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}elseif($marks>=40){
								$grade='C';
								$remark = 'PASS';
								$point=2;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}elseif($marks>=30){
								$grade='D';
								$remark = 'FAIL';
								$point=1;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}else{
								$grade='E';
								$remark = 'FAIL';
								$point=0;
								$sgp=$point*$unit;
								$totalsgp=$totalsgp+$sgp;
								$unittaken=$unittaken+$unit;
							}
				}//	ends grade remarks
				?>
				
				<td><div align="center"><?php echo $grade;?></div></td>
				<?php } //ends while row_course loop
				
				?>
				<td><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?></div></td>
				<td><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?></div></td>
				<td><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa; ?></div></td>
				<td><div align="center"><?php if ($gpa  >= 4.4){
							$remark = 'PASS';
							echo 'A';
										}
						elseif ($gpa >= 3.5){
							$remark = 'PASS';
							echo 'B+';
							}
						elseif ($gpa >= 2.7){
							$remark = 'PASS';
							echo 'B';
							}
						elseif ($gpa >= 2.0){
							$remark = 'PASS';
							echo 'C';
							}
						elseif ($gpa >= 1.0){
							$remark = 'FAIL';
							echo 'D';
							}
						else{
							$remark = 'FAIL';
							echo 'E';
							}
				?></div></td>
				<td><div align="left">
					<?php echo $remark;
					?>	
		      </div></td>
		    </tr>
         </table>
         <?php $i=$i+1;
		   } //ends if $total_rows
		}//ends $rowstudent loop
 }
}else{
?>

<form name="form1" method="post" action="<?php echo $editFormAction ?>">
            <div align="center">
			<table width="200" border="0">
                <tr>
                  <td colspan="3"><span class="style61">if you want to filter the results by  criteria <span class="style34">Tick the corresponding check box first</span> then select appropriately </span></td>
                </tr>
                <tr>
                  <td nowrap><input name="checkdegree" type="checkbox" id="checkdegree" value="on"></td>
                  <td nowrap><div align="left">Degree Programme:</div></td>
                  <td>
                      <div align="left">
                        <select name="degree" id="degree">
                          <?php
do {  
?>
                          <option value="<?php echo $row_degree['ProgrammeCode']?>"><?php echo $row_degree['ProgrammeName']?></option>
                          <?php
} while ($row_degree = mysqli_fetch_assoc($degree));
  $rows = mysqli_num_rows($degree);
  if($rows > 0) {
      mysqli_data_seek($degree, 0);
	  $row_degree = mysqli_fetch_assoc($degree);
  }
?>
                        </select>
                    </div></td></tr>
                <tr>
                  <td><input name="checkcohot" type="checkbox" id="checkcohot" value="on"></td>
                  <td nowrap><div align="left">Cohot of the  Year: </div></td>
                  <td><div align="left">
                    <select name="cohot" id="cohot">
                        <?php
do {  
?>
                        <option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
                        <?php
} while ($row_ayear = mysqli_fetch_assoc($ayear));
  $rows = mysqli_num_rows($ayear);
  if($rows > 0) {
      mysqli_data_seek($ayear, 0);
	  $row_ayear = mysqli_fetch_assoc($ayear);
  }
?>
                    </select>
                  </div></td>
                </tr>
            	<tr>
                  <td><input name="checkyear" type="checkbox" id="checkyear" value="on"></td>
                  <td nowrap><div align="left">Results of the  Year: </div></td>
                  <td><div align="left">
                    <select name="ayear" id="ayear">
                        <?php
do {  
?>
                        <option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
                        <?php
} while ($row_ayear = mysqli_fetch_assoc($ayear));
  $rows = mysqli_num_rows($ayear);
  if($rows > 0) {
      mysqli_data_seek($ayear, 0);
	  $row_ayear = mysqli_fetch_assoc($ayear);
  }
?>
                    </select>
                  </div></td>
                </tr>
                <tr>
                  <td><input name="checkdept" type="checkbox" id="checkdept" value="on"></td>
                  <td nowrap><div align="left">From Department: </div></td>
                  <td><div align="left">
                    <select name="dept" id="dept">
                        <?php
do {  
?>
                        <option value="<?php echo $row_dept['DeptName']?>"><?php echo $row_dept['DeptName']?></option>
                        <?php
} while ($row_dept = mysqli_fetch_assoc($dept));
  $rows = mysqli_num_rows($dept);
  if($rows > 0) {
      mysqli_data_seek($dept, 0);
	  $row_dept = mysqli_fetch_assoc($dept);
  }
?>
                    </select>
                  </div></td>
                </tr>
                <tr>
                  <td colspan="3"><div align="center"></div></td>
                </tr>
              </table>

              <input name="action" type="submit" id="action" value="Print Results"> 
              <input name="MM_update" type="hidden" id="MM_update" value="form1">       
  </div>
</form>
<?php
}
include('../footer/footer.php');
?>