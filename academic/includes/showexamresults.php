<?php
	//select student
	$qstudent = "SELECT * from student WHERE RegNo = '$key'";
	$dbstudent = mysqli_query($zalongwa, $qstudent) or die("Mwanafunzi huyu hana matokeo");
	$row_result = mysqli_fetch_array($dbstudent);
	$name = $row_result['Name'];
	$regno = $row_result['RegNo'];
	$degree = $row_result['ProgrammeofStudy'];
	$RegNo = $regno;
	$deg =$degree;
	//get degree name
	$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
	$dbdegree = mysqli_query($zalongwa, $qdegree);
	$row_degree = mysqli_fetch_array($dbdegree);
	$programme = $row_degree['Title'];
	
	echo  "$name - $regno <br> $programme";	
	
	//array to track gpas
	$gpa_tracker = array();
	//query academeic year
	$qayear = "SELECT DISTINCT AYear FROM examresult WHERE RegNo = '$key' ORDER BY AYear ASC";
	$dbayear = mysqli_query($zalongwa, $qayear);
	
	//get current year
	$get_current_year = mysqli_query($zalongwa, "SELECT AYear FROM academicyear WHERE Status=1 ORDER BY AYear DESC LIMIT 1");
	list($academicYEAR) = mysqli_fetch_array($get_current_year);
	
	echo '<table width="100%" height="100%" border="1" cellpadding="3" cellspacing="0" id="table">';
	//query exam results sorted per years
	while($rowayear = mysqli_fetch_object($dbayear)){

		$currentyear = $rowayear->AYear;
		
		$tbHeader =<<<EOD
					  <tr class='total'>
						<td colspan="1"><strong>$currentyear</strong></td>
						<td width="350" nowrap><strong>Course</strong></td>
						<td width="30" nowrap scope="col">Credit</td>
						<td width="30" nowrap ><strong>Grade</strong></td>						
						<td width="30" nowrap ><strong>Points</strong></td>						
						<td width="30" nowrap ><strong>GPA</strong></td>						
					  </tr>
					   
EOD;
		echo $tbHeader;
		
		//query semester
		$qsemester = "SELECT DISTINCT Semester FROM examresult WHERE RegNo = '$key' AND AYear = '$currentyear' ORDER BY Semester ASC";
		$dbsemester = mysqli_query($zalongwa, $qsemester);

		//query exam results sorted per semester
		while($rowsemester = mysqli_fetch_object($dbsemester)){
			
			$currentsemester = $rowsemester->Semester;
			
			echo "<tr><td colspan='6' bgcolor='#CCCCCC' scope='col'><b>$currentsemester</b></td></tr>";
			//get user module
			if($module == 3){
				//check if the student has not cleared the fees
				$chekdue = mysqli_query($zalongwa,"SELECT * FROM studentremark WHERE RegNo='$key' AND Semester='$currentsemester' 
								AND AYear='$currentyear' AND Remark<>''");
				$getdue = mysqli_num_rows($chekdue);
				$row=mysqli_fetch_array($chekdue);
				
				/**
				 * capture remark value from studentremark table 
				 * and use it to find remark Description form 
				 * examremark table 
				 *
				 * */
				$remarkvalue=$row['Remark'];
				$remarksql="SELECT Description FROM examremark where Remark='$remarkvalue'";
				$remarkresult=mysqli_query($zalongwa, $remarksql);
				$row2=mysqli_fetch_array($remarkresult);
				$remarkDescription=$row2['Description'];
				
				$qcourse="SELECT DISTINCT course.CourseName, course.Units, course.StudyLevel, 
						  course.Department, examresult.CourseCode, examresult.Semester 
						  FROM course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
						  WHERE (examresult.RegNo='$key') AND (examresult.AYear = '$currentyear') AND
								(examresult.Semester = '$currentsemester') AND  (examresult.Checked='1') 
						  ORDER BY examresult.AYear DESC, examresult.Semester ASC";
				$getdue=1;
				}
				
			else{
				$getdue = '0';
				# get all courses for this candidate
				$qcourse="SELECT DISTINCT course.CourseName, course.Units, course.StudyLevel, 
						  course.Department, examresult.CourseCode, examresult.Semester 
						  FROM course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
						  WHERE (examresult.RegNo='$key') AND (examresult.AYear = '$currentyear') AND
								(examresult.Semester = '$currentsemester')
						  ORDER BY examresult.AYear DESC, examresult.Semester ASC";
				}
			
			
//results blocking
//echo '<br>=======<br> getdue value is: '.$getdue.'<br> inst value is: '.$inst.'<br> empty value is: '.$remarkDescription.'<br> Year is: '.$currentyear.'<br> Academic Year is: '.$academicYEAR;			

if($getdue != '0' && !empty($remarkDescription)){
				echo "<tr><td colspan='6' bgcolor='#ff0000' scope='col'><b>Your Results for the academic year $currentyear - $currentsemester <br/> Overall Remark is $remarkDescription</b></td></tr>";
				}
				
			elseif($inst == md5(2) && $currentyear==$academicYEAR && $module == 3){
				echo "<tr><td colspan='6' bgcolor='#ff0000' scope='col'><b>Your Results for the academic year $currentyear - $currentsemester  are withheld pending fees payment</b></td></tr>";
				}
		
			elseif($inst == md5(1) && $currentyear==$academicYEAR && $currentsemester=='Semester II' && $module == 3){
				echo "<tr><td colspan='6' bgcolor='#ff0000' scope='col'><b>Your Results for the academic year $currentyear - $currentsemester are withheld pending fees payment balance</b></td></tr>";
				}
				
			else{
					
				$dbcourse = mysqli_query($zalongwa, $qcourse);
				$total_rows = mysqli_num_rows($dbcourse);
				
				if($total_rows>0){
					//print name and degree
					//select student
					$qstudent = "SELECT Name, RegNo, ProgrammeofStudy from student WHERE RegNo = '$key'";
					$dbstudent = mysqli_query($zalongwa, $qstudent);
					$row_result = mysqli_fetch_array($dbstudent);
					$name = $row_result['Name'];
					$regno = $row_result['RegNo'];
					$degree = $row_result['ProgrammeofStudy'];
					
					//get degree name
					$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
					$dbdegree = mysqli_query($zalongwa, $qdegree);
					$row_degree = mysqli_fetch_array($dbdegree);
					$programme = $row_degree['Title'];
									
					//initialise
					$totalunit=0;
					$unittaken=0;
					$sgp=0;
					$totalsgp=0;
					$gpa=0;
					$sn = 1;
					
					while($row_course = mysqli_fetch_array($dbcourse)){
						$course= $row_course['CourseCode'];
						$unit= $row_course['Units'];
						$semester= $row_course['Semester'];
						$coursename= $row_course['CourseName'];
						$coursefaculty = $row_course['Department'];
						
						if($row_course['Status']==1){
							$status ='Core';
							}
						else{
							$status = 'Elective';
							}
							
						$remarks = 'remarks';
						$class = (fmod($sn,2) == '0')? "bgcolor='#ceceff'":"bgcolor='#ffffff'";
						$sn=$sn+1;
						$exam_ayear = $currentyear;						
						include 'choose_studylevel.php';
						
						//display results
						echo "<tr $class>
								<td nowrap align='left'>$course</td>
								<td nowrap align='left'>".ucwords(strtolower($coursename))."</td>
								<td nowrap align='center'> $row_course[Units]</td>
								<td nowrap align='center'>$grade</td>
								<td nowrap align='center'>$sgp</td>								 
								<td nowrap align='center'></td>								 
							  </tr>";
						
						if($remark=='PASS'){
							$gpa_tracker[$currentyear]['pass'] += 1;
							}
						else{
							$gpa_tracker[$currentyear]['fail'] += 1;
							}
						}
		  
					$gpa = @substr($totalsgp/$unittaken, 0,3);
					$gpa_tracker[$currentyear]['units'] += $unittaken;
					$gpa_tracker[$currentyear]['points'] += $totalsgp;
					
					echo "<tr>
							<td colspan='2' align='right'><strong>$currentyear $currentsemester GPA:</strong></td>
							<td nowrap align='center'><strong>$unittaken</strong></td>
							<td nowrap align='center'><strong></strong></td>
							<td nowrap align='center'><strong>$totalsgp</strong></td>
							<td nowrap align='center'><strong>$gpa</strong></td>
						 </tr>";
		 
						  
					$query = mysqli_query($zalongwa, "SELECT ProgrammeCode, Title, Faculty, Ntalevel FROM programme WHERE ProgrammeCode='$deg'");
					$chas = mysqli_fetch_array($query);
					$class = $chas['Ntalevel'];
					$remark = '';
						
					if($class == 'NTA Level 7' || $class == 'NTA Level 8'){
						if($gpa >= 4.4){
							$remark = "FIRST CLASS";
						}else if($gpa>=3.5){
							$remark = "UPPER SECOND CLASS";
						}else if($gpa>=2.7){
							$remark = "LOWER SECOND CLASS";
						} else if($gpa>=2.0){
							$remark = "PASS";
						}else if($gpa>=1.7){
							$remark = "REPEAT";
						}else{
							$remark ="DISCO";
						}
					} 
					else if($class == 'NTA Level 6'){
					   if($gpa >= 4.4){
							$remark = "FIRST CLASS";
						}else if($gpa>=3.5){
							$remark = "UPPER SECOND CLASS";
						}else if($gpa>=2.7){
							$remark = "LOWER SECOND CLASS";
						} else if($gpa>=2.0){
							$remark = "PASS";
						}else if($gpa>=1.0){
							$remark = "REPEAT";
						}else{
							$remark ="DISCO";
						}
					}
					else if($class == 'NTA Level 4' || $class == 'NTA Level 5' ){
					   if($gpa >= 3.5){
							$remark = "FIRST CLASS";
						}else if($gpa>=3.0){
							$remark = "SECOND CLASS";
						} else if($gpa>=2.0){
							$remark = "PASS";
						}else if($gpa>=1.0){
							$remark = "REPEAT";
						}else{
							$remark ="DISCO";
						}
					}
					
					echo "<tr bgcolor='#aaffcc'>
							<td colspan='2' align='right'><strong>GPA REMARK:</strong></td>
							<td colspan='4' nowrap align='center'><strong>$remark</strong></td>
						 </tr>";
						 
					}
			
				else{ 
					if(!@$reg[$c]){}
					else{
						echo "<tr><td colspan='6' bgcolor='#CCCCCC' scope='col'><b>$c Sorry, No Records Found for $reg[$c]</b></td></tr>";
						}
					}
				}//ends check of fees payment (student dues)
			
			$semstr = $currentsemester;
			$currentsemester = '';
			} //ends while rowsemester
		
		
		if($semstr=='Semester II' && ($getdue == '0' || $inst == md5(0))){
			$gpa = @substr($gpa_tracker[$currentyear]['points']/$gpa_tracker[$currentyear]['units'], 0,3);
			
			if($currentyear>'2012/2013'){
				$remark = $gpa_tracker[$currentyear]['fail']/($gpa_tracker[$currentyear]['pass'] + $gpa_tracker[$currentyear]['fail']);
				if($remark==0){
					$remark = 'PASS';
					}
				else{
					$remark = ($remark>0.5)? 'DISCO':'SUPP';
					}
				}
			else{
				if ($gpa<1.8){
					$remark = 'DISCO';
					}
				else{
					$remark = ($gpa_tracker[$currentyear]['fail']>0)? 'SUPP':'PASS';
					}
				}
			echo "<tr bgcolor='#ffff00'>
							<td colspan='2' align='right'><strong>$currentyear GPA & <br/>REMARK:</strong></td>
							<td colspan='4' nowrap align='center'><strong>$gpa<br/>$remark</strong></td>
						 </tr>";
			}
				
		} //ends while rowayear	
	
	echo '</table>';
	mysqli_close($zalongwa);
?>