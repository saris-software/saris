<?php
	#reset gpa calculation values
	$point = '';
	$grade = '';
	$remark = '';
	
	#query Project Exam
	$qproj = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=5";
	$dbproj=mysql_query($qproj);
	$row_proj=mysql_fetch_array($dbproj);
	$row_proj_total=mysql_num_rows($dbproj);
	$projdate=$row_proj['ExamDate'];
	$projscore=$row_proj['ExamScore'];
	if(($row_proj_total>0)&&($projscore<>'')){
		$remarks = '';
		$aescore = number_format($projscore,1);
		#empty coursework
		$test2score ='n/a';
	}else{
			$remarks = "Inc";	
			$aescore = '';
			$aescore100 = '';
			$test2score ='';
	}
	
	#get total marks
	if (($row_sup_total>0)&&($supscore<>'')){
				$tmarks = $supscore;
				if($tmarks>=40){
					$gradesupp='C';
					$remark = 'PASS';
				}
	}elseif(($row_proj_total>0)&&($projscore<>'')){
		$tmarks = $projscore;
	}elseif(($row_tp_total>0)&&($tpscore<>'')){
		$tmarks = $tpscore;
	}elseif(($row_pt_total>0)&&($ptscore<>'')){
		$tmarks = $ptscore;
	}elseif(($total_sp>0)&&($spscore<>'')){
		$tmarks = $test2score + $spscore;
	}else{
		$tmarks = $test2score + $aescore;
	}
	
	#round marks
	$marks = number_format($tmarks,0);
		
	#grade marks
	if($remarks =='Inc'){
		$grade='I';
		$igrade='I';
		$remark = 'Inc.';
		$point=0;
		$sgp=$point*$unit;
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
		}elseif($marks>=35){
			$grade='D';
			$remark = 'SUPP';
			$fsup='!';
			$supp='!';
			$point=1;
			$sgp=$point*$unit;
			$totalsgp=$totalsgp+$sgp;
			$unittaken=$unittaken+$unit;
		}else{
			$grade='E';
			$remark = 'SUPP';
			$fsup='!';
			$supp='!';
			$point=0;
			$sgp=$point*$unit;
			$totalsgp=$totalsgp+$sgp;
			$unittaken=$unittaken+$unit;
		}
	}
	
	#check if ommited
	$qcount = "SELECT DISTINCT Count FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo'";
	$dbcount=mysql_query($qcount);
	$row_count=mysql_fetch_array($dbcount);
	$count =$row_count['Count'];
	if ($count==1){
		$sgp =0;
		$unit=0;
		$coursename ='*'.$coursename;
	}
	
	#manage supplimentary exams
	if ($gradesupp=='C'){
		$unittaken=$unittaken-$unit;
		$totalsgp=$totalsgp-$sgp;
		$grade='C'; // put the fixed value of a supplimentary grade
		$point=2; // put the fixed value for SUPP point whic is equivalent to 50 marks
		$sgp=$point*$unit;
		$totalsgp=$totalsgp+$sgp;
		$unittaken=$unittaken+$unit;
		#empty gradesupp
		$gradesupp='';
	}
	
	#prohibit the printing of zeros in coursework and exam
	if ($grade=='I' and $marks==0){
		$marks = '';
		$remark = 'ABSC';
	}
	
	#manage $aescore100
	$aescore100 = $aescore;
	$aescore='';
	
	#get course semester
	$qsem = "SELECT YearOffered FROM course WHERE CourseCode = '$course'";
	$dbsem = mysql_query($qsem);
	$row_sem = mysql_fetch_assoc($dbsem);
	$semname = $row_sem['YearOffered'];
	#get semester ID
	$qsemid = "SELECT Id FROM terms WHERE Semester = '$semname'";
	$dbsemid = mysql_query($qsemid );
	$row_semid = mysql_fetch_assoc($dbsemid);
	$semid = $row_semid['Id'];
?>