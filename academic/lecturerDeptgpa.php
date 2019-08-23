<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Annual GPA';

	$szTitle = 'Annual GPA Report';
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

mysqli_select_db($zalongwa, $database_zalongwa);
$query_studentlist = "SELECT RegNo, Name, ProgrammeofStudy FROM student ORDER BY ProgrammeofStudy  ASC";
$studentlist = mysqli_query($zalongwa, $query_studentlist) or die(mysqli_error($zalongwa));
$row_studentlist = mysqli_fetch_assoc($studentlist);
$totalRows_studentlist = mysqli_num_rows($studentlist);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_degree = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$degree = mysqli_query($zalongwa, $query_degree) or die(mysqli_error($zalongwa));
$row_degree = mysqli_fetch_assoc($degree);
$totalRows_degree = mysqli_num_rows($degree);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$ayear = mysqli_query($zalongwa, $query_ayear) or die(mysqli_error($zalongwa));
$row_ayear = mysqli_fetch_assoc($ayear);
$totalRows_ayear = mysqli_num_rows($ayear);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_dept = "SELECT Faculty, DeptName FROM department ORDER BY DeptName, Faculty ASC";
$dept = mysqli_query($zalongwa, $query_dept) or die(mysqli_error($zalongwa));
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

<h4 style="align=center">UNIVERSITY OF DAR ES SALAAM<br>
					  
Annual Examination GPA Report <br>

<?php 

@$checkdegree = $_POST['checkdegree'];
@$checkyear = $_POST['checkyear'];
@$checkdept = $_POST['checkdept'];
$checkcohot = $_POST['checkcohot'];


$prog=$_POST['degree'];
$cohotyear = $_POST['cohot'];
$ayear = $_POST['ayear'];
$qprog= "SELECT ProgrammeCode, Title FROM programme WHERE ProgrammeCode='$prog'";
$dbprog = mysqli_query($zalongwa,$qprog);
$row_prog = mysqli_fetch_array($dbprog);
$progname = $row_prog['Title'];
$qyear= "SELECT AYear FROM academicyear WHERE AYear='$cohotyear'";
$dbyear = mysqli_query($zalongwa,$qyear);

$dbprog = mysqli_query($zalongwa, $qprog);
$row_prog = mysqli_fetch_array($dbprog);
$progname = $row_prog['Title'];
$qyear= "SELECT AYear FROM academicyear WHERE AYear='$cohotyear'";
$dbyear = mysqli_query($zalongwa, $qyear);

$row_year = mysqli_fetch_array($dbyear);
$year = $row_year['AYear'];

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

//calculate year of study
$entry = intval(substr($cohot,0,4));
$current = intval(substr($year,0,4));
$yearofstudy=$current-$entry;

if($yearofstudy==0){
	$class="FIRST YEAR";
	}elseif($yearofstudy==1){
	$class="SECOND YEAR";
	}elseif($yearofstudy==2){
	$class="THIRDD YEAR";
	}elseif($yearofstudy==3){
	$class="FOURTH YEAR";
	}elseif($yearofstudy==4){
	$class="FIFTH YEAR";
	}elseif($yearofstudy==5){
	$class="SIXTH YEAR";
	}elseif($yearofstudy==6){
	$class="SEVENTHND YEAR";
	}else{
	$class="";
}

echo $progname;
echo " - ".$class;
echo "<br><br>Examination Results for Academic Year - ".$ayear;
?>
<br>
</h4>
<?php

//$reg = $_POST['regno'];

$c=0;

if (($checkdegree=='on') && ($checkcohot == 'on') && ($checkdept == 'on') && ($checkyear == 'on')){
//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

$qstudent = "SELECT Name, RegNo, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";

$dbstudent = mysqli_query($zalongwa,$qstudent);

$dbstudent = mysqli_query($zalongwa, $qstudent);

$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$gpoints = 0;
			$gunits = 0;
			
			//query depts where the student has courses registered for
			$qdept = "SELECT DISTINCT DeptName
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

			$dbdept = mysqli_query($zalongwa, $qdept);
			$dbdeptUnit = mysqli_query($zalongwa, $qdept);
			$dbdeptGrade = mysqli_query($zalongwa, $qdept);

			
			?>
			<table style="width=100%; height=100%; border=1; cellpadding=0; cellspacing=0">
				  <tr>
					<td scope="col"><div align="left"></div>
					  <?php echo $i.".0" ?>
							<br>
							<span class="style1">................................</span></td>
							<?php while($rowdept = mysqli_fetch_array($dbdept)) { ?>
							<td colspan="4" nowrap scope="col"><?php echo $rowdept['DeptName']; ?></td> 
							<?php } ?>
							<td><div align="center">Total</div></td>
							<td><div align="center">Total</div></td>
							<td><div align="center">Total</div></td>
							<td><div align="center">Total</div></td>
							<td scope="col">Remarks</td>
				  </tr>
				  <tr>
							<td width="15"><?php echo $name; ?> </td>
							<?php while($rowdeptUnit = mysqli_fetch_array($dbdeptUnit)) { ?>
							<td><div align="center">Units</div></td>
							<td><div align="center">SGP</div></td>
							<td><div align="center">GPA</div></td>
							<td><div align="center">Grade</div></td>
							<?php }?>
							<td><div align="center">Units</div></td>
							<td><div align="center">SGP</div></td>
							<td><div align="center">GPA</div></td>
							<td><div align="center">Grade</div></td>
							<td rowspan="2"><?php $qsupp = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'Fail')";

								$dbsupp = mysqli_query($zalongwa,$qsupp);
								$dbsupptotal = mysqli_query$zalongwa,($qsupp);

								$dbsupp = mysqli_query($zalongwa, $qsupp);
								$dbsupptotal = mysqli_query($zalongwa, $qsupp);

								$total = mysqli_num_rows($dbsupptotal);
								if($total >0){
								echo "Supp: ";
								while($rowsupp = mysqli_fetch_array($dbsupp)) {
								echo $rowsupp['CourseCode'].", ";
								} 
								echo "\n";
								echo "\n";
								}//else{echo "PASS";}
							?>					          <div align="left"><?php $qinc = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'I')";
								$dbqinc = @mysqli_query($zalongwa, $qinc);
								$dbinctotal = mysqli_query($zalongwa, $qinc);
								$totalinc = mysqli_num_rows($dbinctotal);
								if($totalinc >0){
								echo "SE: ";
								while($rowinc = @mysqli_fetch_array($dbqinc)) {
								echo $rowinc['CourseCode'] .", ";
								}
								echo "\n";
								}
							?>		
                                                     </div></td>
				  </tr>
        			<tr>
					<td width="15"><?php echo $regno ?></td>
					<?php while($rowdeptGrade = mysqli_fetch_array($dbdeptGrade)) { 
						$dept = $rowdeptGrade['DeptName'];
						@$updateSQL = "SELECT 
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
											(examresult.AYear = '$year') AND
											(checked=1) AND (Count=0) AND 
											(course.Department = '$dept')
										   )";

           	$result = mysqli_query($zalongwa,$updateSQL) or die("Mwanafunzi huyu hana matokeo");
			$query = @mysqli_query($zalongwa,$updateSQL) or die("Cannot query the database.<br>" .  mysqli_error($zalongwa));

           	$result = mysqli_query($zalongwa, $updateSQL) or die("Mwanafunzi huyu hana matokeo");
			$query = @mysqli_query($zalongwa, $updateSQL) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));

							
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
					<?php }
						
					}$i=$i+1;
						?>
						    <td><div align="center"><?php echo $gunits ?> </div></td>
							<td><div align="center"><?php echo $gpoints ?> </div></td>
							<td><div align="center"><?php $ggpa = @substr($gpoints/$gunits, 0,3); echo $ggpa; ?></div></td>
							<td><div align="center"><?php if ($ggpa  >= 4.4){
								echo 'A';
											}
							elseif ($ggpa >= 3.5){
								echo 'B+';
								}
							elseif ($ggpa >= 2.7){
								echo 'B';
								}
							elseif ($ggpa >= 2.0){
								echo 'C';
								}
							elseif ($ggpa >= 1.0){
								echo 'D';
								}
							else{
								echo 'E';
								}
					?></div></td>
					<?php }
					?>
			  </tr>
</table>
			<?php }elseif (($checkdegree=='on') && ($checkyear == 'on') && ($checkcohot == 'on')){

//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE 
(ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY Subject, Name ASC";

$dbstudent = mysqli_query($zalongwa,$qstudent);

$dbstudent = mysqli_query($zalongwa, $qstudent);

$totalstudent = mysqli_num_rows($dbstudent);
//initialise S/No
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
			$gpoints = 0;
			$gunits = 0;
			
			//query depts where the student has courses registered for
			$qdept = "SELECT DISTINCT DeptName
						FROM course
						   INNER JOIN department ON (course.Department = department.DeptName)
						   INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
						WHERE 
						   (
							  (examresult.RegNo = '$regno') AND
							  (examresult.AYear = '$year')
						    ) ORDER BY DeptName ASC";
			

			$dbdept = mysqli_query($zalongwa,$qdept);
			$dbdeptUnit = mysqli_query($zalongwa,$qdept);
			$dbdeptGrade = mysqli_query($zalongwa,$qdept);

			$dbdept = mysqli_query($zalongwa, $qdept);
			$dbdeptUnit = mysqli_query($zalongwa, $qdept);
			$dbdeptGrade = mysqli_query($zalongwa, $qdept);

			
			?>
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
       			<tr>
				  <td width="20" rowspan="2" nowrap><?php echo $i ?></td>
				  <td width="170" height="20" rowspan="2" nowrap><?php echo $name.": <br> ".$regno ?></td>
				  <td width="13" rowspan="2" nowrap><div align="center"><?php echo $sex ?></div></td>
				<?php while($rowdept = mysqli_fetch_array($dbdept)) 
				{ ?>
							<td colspan="4" nowrap scope="col"><?php echo substr($rowdept['DeptName'],0,8); ?>
						    <div align="center"></div></td> 
				<?php } ?>
							<td width="20" nowrap><div align="center">Units</div></td>
							<td width="20" nowrap><div align="center">Points</div></td>
							<td width="20" nowrap><div align="center">GPA</div></td>
							<td width="20" nowrap><div align="center">Grade</div></td>
							<td width="100" nowrap>Remarks</td>
			  </tr>
				<tr>
					<?php while($rowdeptGrade = mysqli_fetch_array($dbdeptGrade)) { 
						@$dept = $rowdeptGrade['DeptName'];
						@$updateSQL = "SELECT 
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
											(checked=1) AND (Count=0) AND 
											(course.Department = '$dept') 
											
										   )";

									$result = mysqli_query($zalongwa,$updateSQL) or die("Mwanafunzi huyu hana matokeo");
									$query = @mysqli_query($zalongwa,$updateSQL) or die("Cannot query the database.<br>" .  mysqli_error($zalongwa));

									$result = mysqli_query($zalongwa, $updateSQL) or die("Mwanafunzi huyu hana matokeo");
									$query = @mysqli_query($zalongwa, $updateSQL) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));

													
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
											<td width="22" nowrap><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?>
											</div></td>
											<td width="22" nowrap><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?>
											</div></td>
											<td width="22" nowrap><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa; ?>
											</div></td>
											<td width="22" nowrap> <div align="center"><?php if ($gpa  >= 4.4){
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
											?>					  
											</div></td>
											<?php }
						
					}$i=$i+1;
						?>
						    <td width="20" nowrap><div align="center"><?php echo $gunits ?></div></td>
							<td width="20" nowrap><div align="center"><?php echo $gpoints ?></div></td>
							<td width="20" nowrap><div align="center"><?php $ggpa = @substr($gpoints/$gunits, 0,3); echo $ggpa; ?></div></td>
							<td width="20" nowrap><div align="center"><?php if ($ggpa  >= 4.4){
								echo 'A';
											}
							elseif ($ggpa >= 3.5){
								echo 'B+';
								}
							elseif ($ggpa >= 2.7){
								echo 'B';
								}
							elseif ($ggpa >= 2.0){
								echo 'C';
								}
							elseif ($ggpa >= 1.0){
								echo 'D';
								}
							else{
								echo 'E';
								}
					?>
						      </div></td>
					<td width="100" row span="2" nowrap>
						<?php if($ggpa<2){
										$remarkggpa = "DISCO";
										echo $remarkggpa;
										}elseif($gpa<1.5){
											$remarkgpa = "DISCO";
											echo $remarkgpa;
											}else{
											//check if has existing course
										$qcourse = "SELECT CourseCode from examresult WHERE (RegNo = '$regno') AND (AYear = '$year')";

										$dbcourse = mysqli_query($zalongwa,$qcourse);

										$dbcourse = mysqli_query($zalongwa, $qcourse);

										$totalcourse = mysqli_num_rows($dbcourse);
										if($totalcourse == 0){
										echo "DISCO";
										}else{
													$qsupp = "SELECT CourseCode FROM examresult 
															  WHERE (RegNo = '$regno') AND (Remarks = 'Fail') AND (AYear = '$year')";

													$dbsupp = mysqli_query($zalongwa,$qsupp);
													$dbsupptotal = mysqli_query($zalongwa,$qsupp);

													$dbsupp = mysqli_query($zalongwa, $qsupp);
													$dbsupptotal = mysqli_query($zalongwa, $qsupp);

													$total = mysqli_num_rows($dbsupptotal);
													if(intval($total) == 0){
															echo "PASS";  
																}else{
																	   echo "Supp: ";
																	   while($rowsupp = mysqli_fetch_array($dbsupp)) {
																	     echo $rowsupp['CourseCode'].", ";
																		}
															   }
													?>					         
													<?php $qinc = "SELECT CourseCode FROM examresult 
															WHERE (RegNo = '$regno') AND (Remarks = 'I') AND (AYear = '$year')";
															$dbqinc = @mysqli_query($zalongwa, $qinc);
															$dbinctotal = mysqli_query($zalongwa, $qinc);
															$totalinc = mysqli_num_rows($dbinctotal);
														if($totalinc >=1){
														echo "SE: ";
															while($rowinc = @mysqli_fetch_array($dbqinc)) {
															echo $rowinc['CourseCode'] .", ";
													  }
													}
												}
											}
											?>		
                  </td>
					<?php }
					?>
			  </tr>
</table>
			<?php }elseif (($checkdegree=='on') && ($checkcohot == 'on') && ($checkdept == 'on')){
//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];

$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";

$dbstudent = mysqli_query($zalongwa,$qstudent);

$dbstudent = mysqli_query($zalongwa, $qstudent);

$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
			$gpoints = 0;
			$gunits = 0;
			
			//query depts where the student has courses registered for
			$qdept = "SELECT DISTINCT DeptName
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

			$dbdept = mysqli_query($zalongwa, $qdept);
			$dbdeptUnit = mysqli_query($zalongwa, $qdept);
			$dbdeptGrade = mysqli_query($zalongwa, $qdept);

			
			?>
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
       			<tr>
				  <td width="20" rowspan="2" nowrap><?php echo $i ?></td>
				  <td width="170" height="20" rowspan="2" nowrap><?php echo $name.": <br> ".$regno ?></td>
				  <td width="13" rowspan="2" nowrap><div align="center"><?php echo $sex ?></div></td>
				<?php while($rowdept = mysqli_fetch_array($dbdept)) 
				{ ?>
							<td colspan="4" nowrap scope="col"><?php echo substr($rowdept['DeptName'],0,8); ?>
						    <div align="center"></div></td> 
				<?php } ?>
							<td width="20" nowrap><div align="center">Units</div></td>
							<td width="20" nowrap><div align="center">Points</div></td>
							<td width="20" nowrap><div align="center">GPA</div></td>
							<td width="20" nowrap><div align="center">Grade</div></td>
							<td width="100" nowrap>Remarks</td>
			  </tr>
				<tr>
					<?php while($rowdeptGrade = mysqli_fetch_array($dbdeptGrade)) { 
						@$dept = $rowdeptGrade['DeptName'];
						@$updateSQL = "SELECT 
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
											(checked=1) AND (Count=0) AND 
											(course.Department = '$dept') 
											
										   )";

									$result = mysqli_query($zalongwa,$updateSQL) or die("Mwanafunzi huyu hana matokeo");
									$query = @mysqli_query($zalongwa,$updateSQL) or die("Cannot query the database.<br>" .  mysqli_error($zalongwa));

									$result = mysqli_query($zalongwa, $updateSQL) or die("Mwanafunzi huyu hana matokeo");
									$query = @mysqli_query($zalongwa, $updateSQL) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));

													
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
											<td width="22" nowrap><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?>
											</div></td>
											<td width="22" nowrap><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?>
											</div></td>
											<td width="22" nowrap><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa; ?>
											</div></td>
											<td width="22" nowrap> <div align="center"><?php if ($gpa  >= 4.4){
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
											?>					  
											</div></td>
											<?php }
						
					}$i=$i+1;
						?>
						    <td width="20" nowrap><div align="center"><?php echo $gunits ?></div></td>
							<td width="20" nowrap><div align="center"><?php echo $gpoints ?></div></td>
							<td width="20" nowrap><div align="center"><?php $ggpa = @substr($gpoints/$gunits, 0,3); echo $ggpa; ?></div></td>
							<td width="20" nowrap><div align="center"><?php if ($ggpa  >= 4.4){
								echo 'A';
											}
							elseif ($ggpa >= 3.5){
								echo 'B+';
								}
							elseif ($ggpa >= 2.7){
								echo 'B';
								}
							elseif ($ggpa >= 2.0){
								echo 'C';
								}
							elseif ($ggpa >= 1.0){
								echo 'D';
								}
							else{
								echo 'E';
								}
					?>
						      </div></td>
					<td width="100" nowrap>
						<?php $qsupp = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'Fail')";

								$dbsupp = mysqli_query($zalongwa,$qsupp);
								$dbsupptotal = mysqli_query($zalongwa,$qsupp);

								$dbsupp = mysqli_query($zalongwa, $qsupp);
								$dbsupptotal = mysqli_query($zalongwa, $qsupp);

								$total = mysqli_num_rows($dbsupptotal);
								if($total >0){
									echo "Supp: ";
									while($rowsupp = mysqli_fetch_array($dbsupp)) {
									echo $rowsupp['CourseCode'].", ";
									} 
								//echo "\n";
								
								}
								/*
								elseif ($ggpa >= 2.0) {
										echo "PASS";
										echo "<br>";
								}else {echo "DISCO.";}
*/
							?>					         <?php $qinc = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'I')";
								$dbqinc = @mysqli_query($zalongwa, $qinc);
								$dbinctotal = mysqli_query($zalongwa, $qinc);
								$totalinc = mysqli_num_rows($dbinctotal);
								if($totalinc >0){
								echo "SE: ";
								while($rowinc = @mysqli_fetch_array($dbqinc)) {
								echo $rowinc['CourseCode'] .", ";
								}
								//echo "\n";
								}
							?>		
                  </td>
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

$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";

$dbstudent = mysqli_query($zalongwa,$qstudent);

$dbstudent = mysqli_query($zalongwa, $qstudent);

$totalstudent = mysqli_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
			$gpoints = 0;
			$gunits = 0;
			
			//query depts where the student has courses registered for
			$qdept = "SELECT DISTINCT AYear
						FROM examresult
					 WHERE 
						   (
							  (examresult.RegNo = '$regno')
						    ) 
							ORDER BY AYear ASC";
			

			$dbdept = mysqli_query($zalongwa,$qdept);
			$dbdeptUnit = mysqli_query($zalongwa,$qdept);
			$dbdeptGrade = mysqli_query($zalongwa,$qdept);

			$dbdept = mysqli_query($zalongwa, $qdept);
			$dbdeptUnit = mysqli_query($zalongwa, $qdept);
			$dbdeptGrade = mysqli_query($zalongwa, $qdept);

			
			?>
			<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
       			<tr>
				  <td width="20" rowspan="2" nowrap><?php echo $i ?></td>
				  <td width="170" height="20" rowspan="2" nowrap><?php echo $name.": <br> ".$regno ?></td>
				  <td width="13" rowspan="2" nowrap><div align="center"><?php echo $sex ?></div></td>
				<?php while($rowdept = mysqli_fetch_array($dbdept)) 
				{ ?>
							<td colspan="4" nowrap scope="col"><?php echo substr($rowdept['AYear'],0,8); ?>
						    <div align="center"></div></td> 
				<?php } ?>
							<td width="20" nowrap><div align="center">Units</div></td>
							<td width="20" nowrap><div align="center">Points</div></td>
							<td width="20" nowrap><div align="center">GPA</div></td>
							<td width="20" nowrap><div align="center">Grade</div></td>
							<td width="100" nowrap>Remarks</td>
			  </tr>
				<tr>
					<?php while($rowdeptGrade = mysqli_fetch_array($dbdeptGrade)) { 
						@$dept = $rowdeptGrade['AYear'];
						@$updateSQL = "SELECT 
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
											(examresult.AYear = '$dept')  AND
											(checked=1) AND (Count=0) 											
										   )";

									$result = mysqli_query($zalongwa,$updateSQL) or die("Mwanafunzi huyu hana matokeo"); 
									$query = @mysqli_query($zalongwa,$updateSQL) or die("Cannot query the database.<br>" .  mysqli_error($zalongwa));

									$result = mysqli_query($zalongwa, $updateSQL) or die("Mwanafunzi huyu hana matokeo");
									$query = @mysqli_query($zalongwa, $updateSQL) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));

													
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
											<td width="22" nowrap><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?>
											</div></td>
											<td width="22" nowrap><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?>
											</div></td>
											<td width="22" nowrap><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa; ?>
											</div></td>
											<td width="22" nowrap> <div align="center"><?php if ($gpa  >= 4.4){
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
											?>					  
											</div></td>
											<?php }
						
					}$i=$i+1;
						?>
						    <td width="20" nowrap><div align="center"><?php echo $gunits ?></div></td>
							<td width="20" nowrap><div align="center"><?php echo $gpoints ?></div></td>
							<td width="20" nowrap><div align="center"><?php $ggpa = @substr($gpoints/$gunits, 0,3); echo $ggpa; ?></div></td>
							<td width="20" nowrap><div align="center"><?php if ($ggpa  >= 4.4){
								echo 'A';
											}
							elseif ($ggpa >= 3.5){
								echo 'B+';
								}
							elseif ($ggpa >= 2.7){
								echo 'B';
								}
							elseif ($ggpa >= 2.0){
								echo 'C';
								}
							elseif ($ggpa >= 1.0){
								echo 'D';
								}
							else{
								echo 'E';
								}
					?>
						      </div></td>
					<td width="100" nowrap>
						<?php $qsupp = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'Fail')";

								$dbsupp = mysqli_query($zalongwa,$qsupp);
								$dbsupptotal = mysqli_query($zalongwa,$qsupp);

								$dbsupp = mysqli_query($zalongwa, $qsupp);
								$dbsupptotal = mysqli_query($zalongwa, $qsupp);

								$total = mysqli_num_rows($dbsupptotal);
								if($total >0){
									echo "Supp: ";
									while($rowsupp = mysqli_fetch_array($dbsupp)) {
									echo $rowsupp['CourseCode'].", ";
									} 
								//echo "\n";
								
								}
								/*
								elseif ($ggpa >= 2.0) {
										echo "PASS";
										echo "<br>";
								}else {echo "DISCO.";}
*/
							?>					         <?php $qinc = "SELECT CourseCode FROM examresult WHERE (RegNo = '$regno') AND (Remarks = 'I')";
								$dbqinc = @mysqli_query($zalongwa, $qinc);
								$dbinctotal = mysqli_query($zalongwa, $qinc);
								$totalinc = mysqli_num_rows($dbinctotal);
								if($totalinc >0){
								echo "SE: ";
								while($rowinc = @mysqli_fetch_array($dbqinc)) {
								echo $rowinc['CourseCode'] .", ";
								}
								//echo "\n";
								}
							?>		
                  </td>
					<?php }
					?>
			  </tr>
</table>
			<?php }
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