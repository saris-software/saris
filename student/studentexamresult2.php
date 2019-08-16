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
	$qstudent = "SELECT Name, RegNo, EntryYear, ProgrammeofStudy, Status from student WHERE RegNo = '$RegNo'";
	$dbstudent = mysqli_query($zalongwa,$qstudent);
	$row_result = mysqli_fetch_array($dbstudent);
	$name = $row_result['Name'];
	$regno = $row_result['RegNo'];
	$degree = $row_result['ProgrammeofStudy'];
	$entryyear = $row_result['EntryYear'];
	$ststatus = $row_result['Status'];
	$stdreport='on';

	
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
		while($rowayear = mysqli_fetch_object($dbayear))
		{
			$currentyear = $rowayear->AYear;
			$entryyear = substr($entryyear,0,4);
			$currentyeartranc = substr($currentyear,0,4);
			$yearofstudy = $currentyeartranc-$entryyear+1;
			
			#initialise
			$totalunit=0;
			$unittaken=0;
			$curr_semester='';
			$sgp=0;
			$totalsgp=0;
			$gpa=0;
			$gmarks=0;
			$totalinccount=0;
			$sem1ovremark='';
			$sem2ovremark='';
			
			# get all courses for this candidate

			$qcourse_total="SELECT CourseCode, Status, Semester FROM courseprogramme 
					WHERE  (ProgrammeID='$degree') AND 
						(YearofStudy='$yearofstudy') ORDER BY semester, CourseCode";
													  
			$dbcourse_total = mysqli_query($zalongwa,$qcourse_total) or die("No Exam Results for the Candidate - $RegNo ");
			$total_rows = mysqli_num_rows($dbcourse_total);
		
		?>
		
		<table width="100%" height="100%" border="2" cellpadding="0" cellspacing="0">
		  <tr>
			<td colspan="1" bgcolor="#CCCCCC" scope="col"><strong><?php echo $rowayear->AYear;?></strong></td>
			<td width="350" nowrap bgcolor="#CCCCCC" scope="col"><strong>Course</strong></td>
			<!-- <td width="30" nowrap scope="col">Credit</td> -->
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>Cwk</strong></td>
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>FE</strong></td>
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>Total</strong></td>
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>Grade</strong></td>
			<td width="30" nowrap bgcolor="#CCCCCC" scope="col"><strong>Remarks</strong></td>
			 <!-- <td width="30" nowrap scope="col">Status</td> -->
		  </tr>
		  <tr> 
		  <?php
			$subjecttaken=0;
			$x=0;
			while($row_course_total = mysqli_fetch_array($dbcourse_total))
			{
				$course= $row_course_total['CourseCode'];
				$coption = $row_course_total['Status']; 
				$semester = $row_course_total['Semester']; 

					include '../academic/includes/compute_student_remark.php';
									
				#display results
				if(($coption==2)&&($remark=='ABSC')){
	
				#print nothing
				}else{
					 
					 if($x==0)
					 {
						echo '<tr><td colspan="7" bgcolor="#CCCCCC" scope="col"> Semester I </td></tr>';
					     $x=1;
					     
					 }elseif (($semester==2)&&($x==1))
					 {
						$curr_semester=$semester;
					 	include '../academic/includes/compute_overall_remark.php'; 
					 	$sem1ovremark = $ovremark;
					 	
					 	echo '<tr><td colspan="7" bgcolor="#CCCCCC" scope="col"> Semester II </td></tr>';
					     $x = 2;
					     $ovremark ='';
					 }

					 ?>
					 <td norwap scope="col"><div align="left"><?php echo $course?></div></td>
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
		  }
			include '../academic/includes/compute_overall_remark.php'; 
		  $sem2ovremark = $ovremark;

		switch ($sem1ovremark) 
	    {
					case "PASS":
	    	  			 if (($ovavg<36)&&($sem2ovremark<>'ABSC'))
	    	  			  {
	    					$annualovremark='DISCO';
	 					  }else{
								
								if ($sem2ovremark=='PASS'){
									$annualovremark='PASS';
								}elseif($sem2ovremark=='SUPP:'){
									$annualovremark='SUPP';
								}elseif($sem2ovremark=='REPEAT'){
									$annualovremark='REPEAT';
								}elseif($sem2ovremark=='DISCO'){
									$annualovremark='DISCO';
								}elseif($sem2ovremark=='ABSC'){
									$annualovremark='ABSC';
								}elseif($sem2ovremark=='INCO'){
									$annualovremark='INCO';
								}
	 					  }
								break;
					case "SUPP:":
						if (($ovavg<36)&&($sem2ovremark<>'ABSC'))
	    	  			  {
	    					$annualovremark='DISCO';
	 					  }else{					
						
								if ($sem2ovremark=='PASS'){
									$annualovremark='SUPP';
								}elseif($sem2ovremark=='SUPP:'){
									$annualovremark='SUPP';
								}elseif($sem2ovremark=='REPEAT'){
									$annualovremark='REPEAT';
								}elseif($sem2ovremark=='DISCO'){
									$annualovremark='DISCO';
								}elseif($sem2ovremark=='ABSC'){
									$annualovremark='ABSC';
								}elseif($sem2ovremark=='INCO'){
									$annualovremark='INCO';
								}
	 					  }
								break;
					case "REPEAT":
	    						$sem2ovremark = '***';		
								$annualovremark='REPEAT';
								break;
					case "DISCO":
							    $sem2ovremark = '***';			
								$annualovremark='DISCO';
								break;
					case "ABSC":
							    $sem2ovremark = '***';			
								$annualovremark='ABSC';
								break;
					case "INCO":
							    //$sem2ovremark = '***';			
								$annualovremark='INCO';
								break;
					default:
								$sem2ovremark = $sem1ovremark;			
								$annualovremark=$sem1ovremark;
	    }
		  ?>
			<tr>
			 <td colspan="6" bgcolor="#CCCCCC" scope="col"><strong>Annual Overall Remarks</strong></td>
			 <!-- <td width="30" nowrap scope="col"><div align="center"><?php echo $unittaken;?></div></td> -->
			 <td width="30" nowrap bgcolor="#CCCCCC" scope="col"><div align="center"><strong>
				<?php
				#remarks
					$k =0;
					if ($annualovremark=='SUPP:'){
						$annualovremark='SUPP';
						 echo $annualovremark;
					}else{
						 echo $annualovremark;
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
		
			} 
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
