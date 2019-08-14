<?php
	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
	$dborg = mysql_query($qorg);
	$row_org = mysql_fetch_assoc($dborg);
	$org = $row_org['Name'];

	@$checkdegree = addslashes($_POST['checkdegree']);
	@$checkyear = addslashes($_POST['checkyear']);
	@$checkdept = addslashes($_POST['checkdept']);
	@$checkcohot = addslashes($_POST['checkcohot']);
	@$checkwh = addslashes($_POST['checkwh']);
	
	@$paper = 'a3'; //addslashes($_POST['paper']);
	@$layout = 'L'; //addslashes($_POST['layout']);
	if ($paper=='a3')
	{
		$xpoint = 1050.00;
		$ypoint = 800.89;
	}else
	{
		$xpoint = 800.89;
		$ypoint = 580.28;
	}

	$prog=$_POST['degree'];
	$cohotyear = $_POST['cohot'];
	$ayear = $_POST['ayear'];
	$qprog= "SELECT ProgrammeCode, Title, Faculty, Ntalevel FROM programme WHERE ProgrammeCode='$prog'";
	$dbprog = mysql_query($qprog);
	$row_prog = mysql_fetch_array($dbprog);
	$progname = $row_prog['Title'];
	$faculty = $row_prog['Faculty'];
	$class = $row_prog['Ntalevel'];
	
	//calculate year of study
	$entry = intval(substr($cohotyear,0,4));
	$current = intval(substr($ayear,0,4));
	$yearofstudy=$current-$entry;
	
	if (($checkdegree=='on') && ($checkyear == 'on') && ($checkcohot == 'on')){
		$deg=addslashes($_POST['degree']);
		$year = addslashes($_POST['ayear']);
		$cohot = addslashes($_POST['cohot']);
		$dept = addslashes($_POST['dept']);
		$sem = addslashes($_POST['sem']);
		if ($sem =='Semester I'){
			$semval = 1;
		}elseif ($sem=='Semester II'){
			$semval = 2;
		}
	
	echo $progname;
	echo " - ".$year;	
	echo " - ".$sem;	
		
	#calculate year of study
	$entry = intval(substr($cohot,0,4));
	$current = intval(substr($ayear,0,4));
	$yearofstudy=$current-$entry;
	
	if($yearofstudy==0){
		$class="FIRST YEAR";
		}elseif($yearofstudy==1){
		$class="SECOND YEAR";
		}elseif($yearofstudy==2){
		$class="THIRD YEAR";
		}elseif($yearofstudy==3){
		$class="FOURTH YEAR";
		}elseif($yearofstudy==4){
		$class="FIFTH YEAR";
		}elseif($yearofstudy==5){
		$class="SIXTH YEAR";
		}elseif($yearofstudy==6){
		$class="SEVENTH YEAR";
		}else{
		$class="";
	}
	#cohort number
	$yearofstudy = $yearofstudy +1;
	$totalcolms =0;
		#determine total number of columns
		$qcolmns = "SELECT DISTINCT CourseCode, Status FROM courseprogramme 
								WHERE  (ProgrammeID='$deg') AND (YearofStudy='$yearofstudy') AND 
									(Semester='$semval') ORDER BY CourseCode";
		$dbcolmns = mysql_query($qcolmns);
		$dbcolmnscredits = mysql_query($qcolmns);
		$dbexamcat = mysql_query($qcolmns);
		$totalcolms = mysql_num_rows($dbcolmns);
?>
<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="20" colspan="5" rowspan="2" nowrap scope="col"><div align="left"></div>CourseCode</td>
		<?php
		# print course header
		while($rowcourseheader = mysql_fetch_array($dbcolmns)) { 
		?>
		<td width="70" colspan="4" nowrap scope="col"><?php echo $rowcourseheader['CourseCode'] ?> </td>
		<?php } ?>
		<td width="52" rowspan="2" colspan="4" nowrap><div align="center">Overall Remarks</div></td>
	  </tr>
	  <tr>
		<?php
		# print course header
		while($rowcourseheader = mysql_fetch_array($dbcolmnscredits)) { 
			if($checksem2==0){
				?>
				<td width="70" colspan="4" nowrap scope="col"><?php
				$course= $rowcourseheader['CourseCode'] ;
			    #get course unit
				$qunits = "SELECT Units FROM course WHERE CourseCode='$course'";
				$dbunits = mysql_query($qunits);
				$row_units = mysql_fetch_array($dbunits);
				$unit=$row_units['Units'];	 
				echo $unit;
			}
		 ?> </td>
		<?php } ?>
	  </tr>   
	  <tr>
		<td width="10" colspan="1" nowrap scope="col"><div align="left"></div>S/No</td>
		<td width="40" colspan="1" nowrap scope="col"><div align="left"></div>Name</td>
		<td width="40" colspan="1" nowrap scope="col"><div align="left"></div>RegNo</td>
		<td width="40" colspan="1" nowrap scope="col"><div align="left"></div>ExamNo</td>
		<td width="20" colspan="1" nowrap scope="col"><div align="left"></div>Sex</td>
		<?php
		# print course header
		while($rowexamcat = mysql_fetch_array($dbexamcat)) { 
		?>
		<td width="20" colspan="1" nowrap scope="col">CA</td>
		<td width="20" colspan="1" nowrap scope="col">SE</td>
		<td width="20" colspan="1" nowrap scope="col">TOTL</td>
		<td width="20" colspan="1" nowrap scope="col">GRD</td>
		<?php } ?>
		<td width="13" colspan="1" nowrap><div align="center">CREDITS</div></td>
		<td width="13" colspan="1" nowrap><div align="center">POINTS</div></td>
		<td width="13" colspan="1" nowrap><div align="center">GPA</div></td>
		<td width="13" colspan="1" nowrap><div align="center">CLASSIFICATION</div></td>
		<td width="13" colspan="1" nowrap><div align="center">Remarks</div></td>
	  </tr>
	  <?php
		# print candidate results
		$overallpasscount = 0;
		$overallsuppcount = 0;
		$overallinccount = 0;
		$overalldiscocount = 0;
		$qstudent = "SELECT Name, RegNo, Sex, DBirth, ProgrammeofStudy, Faculty, Sponsor, EntryYear, Status FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY RegNo";
		$dbstudent = mysql_query($qstudent);
		$totalstudent = mysql_num_rows($dbstudent);
		$z=1;
		while($rowstudent = mysql_fetch_array($dbstudent)) 
		{
				$name = stripslashes($rowstudent['Name']);
				$regno = $rowstudent['RegNo'];
				$sex = $rowstudent['Sex'];
				$bdate = $rowstudent['DBirth'];
					$degree = stripslashes($rowstudent["ProgrammeofStudy"]);
					$faculty = stripslashes($rowstudent["Faculty"]);
					$sponsor = stripslashes($rowstudent["Sponsor"]);
					$entryyear = stripslashes($result['EntryYear']);
					$ststatus = stripslashes($rowstudent['Status']);
				
				#initialise
					$totalunit=0;
					$gmarks=0;
					$totalfailed=0;
					$totalinccount=0;
					$unittaken=0;
					$sgp=0;
					$totalsgp=0;
					$gpa=0;
					
					# new values
					$subjecttaken=0;
					$totalfailed=0;
					$totalinccount=0;
					$halfsubjects=0;
					$ovremark='';
					$gmarks=0;
					$avg =0;
					$gmarks=0;	
					
					$sem1subj = 0;
				  	$sem1marks = 0;
				  	$sem1avg = 0;
				  	$sem1ovremark = '';
				  	$sem1suppcount=0;
				  	$sem1unittaken = 0;
				  	$sem1totalcredits=0;
				  	$sem1totalcredits=0;
					$sem1totalsgp=0;
					$sem1gpa='';
					
					$key = $regno; 
				?>
			  <tr>
				<td width="20" colspan="1" nowrap><div align="left"></div><?php echo $z ?></td>
				<td width="20" colspan="1" nowrap><div align="left"></div><?php echo $name ?></td>
				<td width="20" colspan="1" nowrap><div align="left"></div><?php echo $regno ?></td>				
				<td width="20" colspan="1" nowrap><div align="left"></div>
					<?php 
						$examno = '';
						$num = mysql_query("SELECT DISTINCT ExamNo FROM examresult WHERE RegNo='$regno' AND AYear >= '$year' 
											AND Semester='$sem'");
											
						while($row = mysql_fetch_array($num)){
							$nums = $row['ExamNo'];
							$examno = ($nums > $examno)? $nums:$examno;
							}
						echo $examno 
					?>
				</td>
				<td width="20" colspan="1" nowrap><div align="left"></div><?php echo $sex ?></td>
				<?php
				$z=$z+1;	
				if ($checkwh=='on')
					{
						# check if paid
						//$regno=$RegNo;
						#initialise billing values
						$grandtotal=0;
						$feerate=0;
						$invoice=0;
						$paid=0;
						$debtorlimit=0;
						$tz103=0;
						$amount=0;
						$subtotal=0;
						$cfee=0;
						include('../billing/includes/getgrandtotalpaid.php');
					}
				#get all courses
				$qcourselist = "SELECT DISTINCT CourseCode, Status FROM courseprogramme 
								WHERE  (ProgrammeID='$deg') AND (YearofStudy='$yearofstudy') AND 
									(Semester='$semval') ORDER BY CourseCode";
				$dbcourselist = mysql_query($qcourselist);
				
				while($row_courselist = mysql_fetch_array($dbcourselist)) 
				{ 
					$course= $row_courselist['CourseCode'];
					$coption = $row_courselist['Status']; 
					$qcoursestd="SELECT Units, Department, StudyLevel FROM course WHERE CourseCode = '$course'";	
					$dbcoursestd = mysql_query($qcoursestd);
					$row_coursestd = mysql_fetch_array($dbcoursestd);
					$unit = $row_coursestd['Units'];					
					$remarks = 'remarks';
					$RegNo = $key;
					$currentyear=$year;
					include '../academic/includes/compute_student_remark.php';
					if($semval == 1){
						$sem1unittaken = $unittaken;
						$sem1totalsgp=$totalsgp;
					}elseif($semval == 2){
						$sem2unittaken = $unittaken;
						$sem2totalsgp=$totalsgp;
					}
					?>
					<td width="20" colspan="1" nowrap scope="col"><?php if ($checkwh=='on'){ /*if($due<=$debtorlimit){ */ echo $test2score; /*}*/ }else{ echo $test2score; } ?></td> 
					<td width="20" colspan="1" nowrap scope="col"><?php if ($checkwh=='on'){ /*if($due<=$debtorlimit){ */ echo $aescore;/* }*/ }else{ echo $aescore; } ?></td>
					<td width="20" colspan="1" nowrap scope="col"><?php if ($checkwh=='on'){ /*if($due<=$debtorlimit){ */ echo $marks; /* }*/ }else{ echo $marks; } ?></td>
					<td width="20" colspan="1" nowrap scope="col"><?php if ($checkwh=='on'){ /*if($due<=$debtorlimit){ */ echo $grade;/* }*/}else{ echo $grade; } ?></td>
					<?php 
				} 
				    $curr_semester=$semval;
					include '../academic/includes/compute_overall_remark.php';
					if($semval == 1){
						$sem1ptc=$ptc;
						$sem1gpa=$gpa;
						$sem1subj=$subjecttaken;
						$sem1marks=$gmarks;
						$sem1avg=$avg;
					}elseif($semval == 2){
						$sem2ptc=$ptc;
						$sem2gpa=$gpa;
						$sem2subj=$subjecttaken;
						$sem2marks=$gmarks;
				     	$sem2avg=$avg;						
					}
					?>
						<td width="13" colspan="1" nowrap><div align="center"><?php /*if($due<=$debtorlimit){ */echo $unittaken; /*}*/ ?></div></td>
						<td width="13" colspan="1" nowrap><div align="center"><?php /*if($due<=$debtorlimit){ */ echo $totalsgp;/*}*/ ?></div></td>
						<td width="13" colspan="1" nowrap><div align="center"><?php /*if($due<=$debtorlimit){ */ echo $gpa;/*}*/?></div></td>
						<td colspan='1' align='center' nowrap>
								<?php 
									$ovgpa = $gpa;
									include '../academic/includes/classification.php';
									echo $classification; 
								?>
							</td>
						<td width="13" colspan="1" nowrap><div align="center">
						<?php 
						// this checking payment
					/*if($due<=$debtorlimit){
						#check it
				    }else{
				    	$ovremark = 'WITHHELD';
				    }	*/
				
				#check failed exam
					if ($fexm=='#'){
						$fexm = ''; $remark ='';
					}
					#check failed exam
					if(($totalremarks>0)&&($studentremarks<>'')){
						echo $ovremark;
						$remark ='';
						$fexm = '';
						$fcwk = '';
						$fsup = ''; 
						$igrade = ''; 
						$egrade = ''; 
						$supp='';
					}else{
						#check for supp and inco
						$k =0;
						if ($ovremark=='SUPP:'){
							echo $ovremark;
								#print supplementaries
								$k =25;
								#determine total number of columns
								$qsupp = "SELECT DISTINCT CourseCode, Status FROM courseprogramme WHERE  (ProgrammeID='$deg') 
											AND (YearofStudy='$yearofstudy') 
												AND (Semester = '$semval') ORDER BY CourseCode";
								$dbsupp = mysql_query($qsupp);
								while($row_supp = mysql_fetch_array($dbsupp)){
									$course= $row_supp['CourseCode'];
									$coption = $row_supp['Status']; 
									$grade='';
									$supp='';
									$RegNo = $regno;
										#include grading scale
										include 'includes/choose_studylevel.php';	
										if(($supp=='!')&&($marks>0)){
											echo ','.$course;
											$k =$k+35;
										}
									#empty option value
									$coption='';
								}
						}
						else{
							echo $ovremark;
						}
		
						if ($igrade<>'I'){
						   }
							if($fsup=='!'){
								$fsup = '';
								//$overallsuppcount = $overallsuppcount+1;
								
							}elseif (($igrade<>'I') || ($fsup<>'!')){
								//$overallpasscount= $overallpasscount+1;
							}
		
							if($totalinccount>0){
								$igrade = '';
								//$overallinccount = $overallinccount+1;
							}
					}
				?>
				</div></td>
			  </tr>
	  <?php 

		}
	} 
?>
</table>
