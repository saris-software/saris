<?php 
require_once('../Connections/sessioncontrol.php');
# include the header
include('studentMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Academic Records';
	$szTitle = 'Examination Results';
	$szSubSection = 'Exam Result';
	include("studentheader.php");

$editFormAction = $_SERVER['PHP_SELF'];

#check if has blocked
$qstatus = "SELECT Status FROM student  WHERE (RegNo = '$RegNo')";
$dbstatus = mysqli_query($zalongwa,$qstatus);
$row_status = mysqli_fetch_array($dbstatus);
$status = $row_status['Status'];
if ($status=='Blocked')
{
	echo "Your Examination Results are Currently Blocked<br>";
	echo "Please Contact the Registrar Office to Resolve this Issue<br>";
	exit;
}

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$sn=0;
#print name and degree
//select student
	$qstudent = "SELECT Name, RegNo, EntryYear, ProgrammeofStudy from student WHERE RegNo = '$RegNo'";
	$dbstudent = mysqli_query($zalongwa,$qstudent);
	$row_result = mysqli_fetch_array($dbstudent);
	$name = $row_result['Name'];
	$regno = $row_result['RegNo'];
	$degree = $row_result['ProgrammeofStudy'];
	$entryyear = $row_result['EntryYear'];
	
	#compute study year
	$current_yeartranc = substr($cyear,0,4);
	$entryyear = substr($entryyear,0,4);
	$yearofstudy=$current_yeartranc-$entryyear+1;
	
	//get degree name
	$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
	$dbdegree = mysqli_query($zalongwa,$qdegree);
	$row_degree = mysqli_fetch_array($dbdegree);
	$programme = $row_degree['Title'];
	echo  "$name - $regno <br> $programme";	
	
#check if the candidate has paid enough money
require_once('../billing/includes/getgrandtotalpaid.php');
if($due<=$debtorlimit){
		#query academeic year
		$qayear = "SELECT DISTINCT AYear from examresult WHERE RegNo = '$RegNo' ORDER BY examresult.AYear ASC";
		$dbayear = mysqli_query($zalongwa,$qayear);

		//query exam results sorted per years
		while($rowayear = mysqli_fetch_object($dbayear)){
			$currentyear = $rowayear->AYear;
			$entryyear = substr($entryyear,0,4);
			$currentyeartranc = substr($currentyear,0,4);
			$yearofstudy = $currentyeartranc-$entryyear+1;
			
			#initialise
			$totalunit=0;
			$unittaken=0;
			$sgp=0;
			$totalsgp=0;
			$gpa=0;
			$gmarks=0;
			$totalinccount=0;
			
			# get all courses for this candidate
			$qcourse_total="SELECT CourseCode FROM courseprogramme WHERE  (ProgrammeID='$degree') AND (YearofStudy='$yearofstudy') 
						ORDER BY CourseCode";
												  
			$dbcourse_total = mysqli_query($zalongwa,$qcourse_total) or die("No Exam Results for the Candidate - $RegNo ");
			$total_rows = mysqli_num_rows($dbcourse_total);
		
		?>
		
		<table width="100%" height="100%" border="2" cellpadding="0" cellspacing="0">
		  <tr>
			<td bgcolor="#CCCCCC" scope="col"><strong><?php echo $rowayear->AYear;?></strong></td>
			<td width="350" nowrap bgcolor="#CCCCCC" scope="col"><strong>Course</strong></td>
			<!-- <td width="30" nowrap scope="col">Credit</td> -->
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>Cwk</strong></td>
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>FE</strong></td>
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>Total</strong></td>
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>Grade</strong></td>
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>Remarks</strong></td>
			 <!-- <td width="30" nowrap scope="col">Status</td> -->
		  </tr>
		  <?php
			$subjecttaken=0;
				while($row_course_total = mysqli_fetch_array($dbcourse_total)){
						$tmarks ='';
						$coption='';
						$marks='';
						$grade='';
						$aescore='';
						$test2score='';
						$remark='';
						$course= $row_course_total['CourseCode'];

						$qcoption = "SELECT Status FROM courseprogramme 
										WHERE  (ProgrammeID='$degree') AND (CourseCode='$course')";
						#get course details
						$dbcoption = mysqli_query($zalongwa,$qcoption);
						$row_coption = mysqli_fetch_array($dbcoption);
						$coption = $row_coption ['Status']; 

								$qcourse="SELECT DISTINCT 
											  course.CourseName, 
											  course.Units, 
											  course.Department, 
											  course.StudyLevel,
											  examresult.CourseCode, 
											  examresult.Status 
										  FROM 
											course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
										  WHERE (examresult.RegNo='$RegNo') AND 
											(examresult.AYear = '$currentyear') AND 
												(examresult.Checked='1') AND (course.CourseCode='$course')
											";	
								$dbcourse = mysqli_query($zalongwa,$qcourse);
								$row_course = mysqli_fetch_array($dbcourse);
								//$unit= $row_course['Units'];
								#get coursename
									$qcoursename = "SELECT CourseName FROM course WHERE (CourseCode='$course')";
									$dbcoursename = mysqli_query($zalongwa,$qcoursename);
									$row_coursename = mysqli_fetch_array($dbcoursename);
									$coursename = $row_coursename['CourseName'];
								//$coursefaculty = $row_course['Department'];
						if($coption==1){
						$status ='Core';
						}else{
						$status = 'Elective';
						}
						$sn=$sn+1;
						$remarks = 'remarks';
						$RegNo = $regno;
						include '../academic/includes/choose_studylevel.php';
						
								#check whether to count this course or no
								if(($coption==2)&&($tmarks<1)){
									//$remark = '';
									$marks = '';
									$grade = '';						
								}else{
									$subjecttaken = $subjecttaken+1;
								}
								#compute total marks
								$gmarks = $gmarks+$marks;
								if ($remark<>'PASS'){
									if(($marks>0)||($coption<>2)){
										if($marks==''){
											$remark = 'ABSC';
											$marks = '';
											$grade = '';
											$totalinccount=$totalinccount+1;
										}else{
											$totalfailed=$totalfailed+1;
										}
									}
								}
							
							if($remark == 'ABSC'){
								if ($marks>0){
									$remark = '';
									$marks = '';
									$grade = '';
									$totalinccount=$totalinccount+1;
								}else{
									$remark = 'ABSC';
									$marks = '';
									$grade = '';
									$totalinccount=$totalinccount+1;
								}
							}
							
							#prohibit division by zero
							if(($subjecttaken>0)&&($totalinccount==0)){
									$avg = number_format($gmarks/$subjecttaken,0);
									#calculate courses column width
									$cw = $cwf*$totalcolms;
									$x=$x+235;
									#get student remarks
									$qremarks = "SELECT Remark FROM studentremark WHERE RegNo='$regno'";
									$dbremarks = mysqli_query($zalongwa,$qremarks);
									$row_remarks = mysqli_fetch_assoc($dbremarks);
									$totalremarks = mysqli_num_rows($dbremarks);
									$studentremarks = $row_remarks['Remark'];
									if(($totalremarks>0)&&($studentremarks<>'')){
										$ovremark = $studentremarks;
									}else{
										#include overall remarks
									//$deg ='$degree';
										//include '../academic/includes/overall_remarks.php';	
									$halfsubjects = number_format($subjecttaken/2,1);
									# check nta level programme
									$programmeremarks = intval(substr($degree,0,3));
									if (($programmeremarks  == 300)&&($yearofstudy>1)){
										$minavg = 40.5;
									}else{
										$minavg = 36;
									}
									
									if (($totalfailed  == 0)&&($avg>= $minavg)){
										$ovremark = 'PASS';
										$overallpasscount = $overallpasscount+1;
										}
									elseif($totalinccount>0){
										$ovremark = 'ABSC';
										$overallinccount = $overallinccount+1;
										}
									elseif ($totalfailed <= $halfsubjects){
										$ovremark = 'SUPP:';
										$overallsuppcount = $overallsuppcount+1;
										}
									elseif (($totalfailed > $halfsubjects)&&($avg >= $minavg)){
										$ovremark = 'SUPP:';
										$overallsuppcount = $overallsuppcount+1;
										}
									elseif (($totalfailed > $halfsubjects)&&($avg >= $minavg)&&( $yearofstudy>1)){
										$ovremark = 'REPEAT';
										}
									else{
										$ovremark = 'DISCO';
										$overalldiscocount = $overalldiscocount+1;
										}
									
									}
							}else{
									$avg ='';
									$subjecttaken= '';
									$gmarks='';
									$ovremark = 'ABSC';
									
									#calculate courses column width
									$cw = $cwf*$totalcolms;
									$x=$x+235;
							}
						
						#display results
			if(($coption==2)&&(number_format($tmarks,0)<10)){
			#sasas
			}else{
				?>
				<tr>
				 <td scope="col"><div align="left"><?php echo $course;?></div></td>
				 <td width="350" nowrap scope="col"><div align="left"><?php echo $coursename;?></div></td>
				 <!-- <td width="30" nowrap scope="col"><div align="center"><?php echo $row_course['Units']?></div></td> -->
				 <td width="30" nowrap scope="col"><div align="center"><?php if ($test2score<>-1){echo $test2score;}?></div></td>
				 <td width="30" nowrap scope="col"><div align="center"><?php echo $aescore;?></div></td>
				 <td width="30" nowrap scope="col"><div align="center"><?php echo $marks;?></div></td>
				 <td width="30" nowrap scope="col"><div align="center"><?php echo $grade;?></div></td>
				 <td width="30" nowrap scope="col"><div align="center"><?php echo $remark;?></div></td>
				 <!-- <td width="30" nowrap scope="col"><div align="center"><?php echo $status;?></div></td> -->
			  </tr>
			  <?php 
			  }
		  }?>
			<tr>
			 <td colspan="6" bgcolor="#CCCCCC" scope="col"><strong>Overall Remarks</strong></td>
			 <!-- <td width="30" nowrap scope="col"><div align="center"><?php echo $unittaken;?></div></td> -->
			 <td width="30" nowrap bgcolor="#CCCCCC" scope="col"><div align="center"><strong>
				<?php
				#remarks
					$k =0;
					if ($ovremark=='SUPP:'){
						$ovremark='SUPP';
						 echo $ovremark;
					}else{
						 echo $ovremark;
					}
				?>
			 </strong></div></td>

			  <!-- <td width="30" nowrap scope="col"></td> -->
		  </tr>
		</table>
		
		<?php  
		echo '<br>===============&&&&&&&&================== ';
		echo '			<br>Payment Information: ';
		echo '			<br>Total Chargeable Fee: '.number_format($invoice,2,'.',',');
		echo '			<br>Amount Paid Todate: '.number_format($paid,2,'.',',');
		echo '			<br>Balance Due Todate: '.number_format($due,2,'.',',');
		echo '			<br>Programme Debtor Limit: '.number_format($debtorlimit,2,'.',',');
		echo '<br>===============&&&&&&&&================== ';
		
			}//else{ 
			if(!@$reg[$c]){}else{
			echo "$c". ".Sorry, No Records Found for '$reg[$c]'<br><hr>";
			}
	}else{
		echo '<br>===============&&&&&&&&================== ';
		echo '			<br>Exam Results withheld for Debt (Fee or Rent) Reasons: ';
		echo '			<br>Total Chargeable Fee: '.number_format($invoice,2,'.',',');
		echo '			<br>Amount Paid Todate: '.number_format($paid,2,'.',',');
		echo '			<br>Balance Due Todate: '.number_format($due,2,'.',',');
		echo '			<br>Programme Debtor Limit: '.number_format($debtorlimit,2,'.',',');
		echo '<br>===============&&&&&&&&================== ';
	}
mysqli_close($zalongwa);
include('../footer/footer.php');
?>
