<?php
	#reset gpa calculation values
	$point = '';
	$grade = '';
	$remark = '';
	$nullae=0;
	#query Homework One
	$qhw1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=1";
	$dbhw1=mysqli_query($qhw1);
	$total_hw1 = mysqli_num_rows($dbhw1);
	$row_hw1=mysqli_fetch_array($dbhw1);
	$value_hw1score=$row_hw1['ExamScore'];
	if(($total_hw1>0)&&($value_hw1score<>'')){
		$hw1date=$row_hw1['ExamDate'];
		$hw1score=number_format($value_hw1score,1);
	}else{
		$hw1score='';
	}

	#query Homework Two
	$qhw2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=2";
	$dbhw2=mysqli_query($qhw2);
	$total_hw2 = mysqli_num_rows($dbhw2);
	$row_hw2=mysqli_fetch_array($dbhw2);
	$value_hw2score=$row_hw2['ExamScore'];
	if(($total_hw2>0)&&($value_hw2score<>'')){
		$hw2date=$row_hw2['ExamDate'];
		$hw2score=number_format($value_hw2score,1);
	}else{
		$hw2score='';
	}

	#query Quiz One
	$qqz1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=3";
	$dbqz1=mysqli_query($qqz1);
	$total_qz1 = mysqli_num_rows($dbqz1);
	$row_qz1=mysqli_fetch_array($dbqz1);
	$value_qz1score=$row_qz1['ExamScore'];
	if(($total_qz1>0)&&($value_qz1score<>'')){
		$qz1date=$row_qz1['ExamDate'];
		$qz1score=number_format($value_qz1score,1);
	}else{
		$qz1score='';
	}

	#query Quiz Two
	$qqz2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=4";
	$dbqz2=mysqli_query($qqz2);
	$total_qz2 = mysqli_num_rows($dbqz2);
	$row_qz2=mysqli_fetch_array($dbqz2);
	$value_qz2score=$row_qz2['ExamScore'];
	if(($total_qz2>0)&&($value_qz2score<>'')){
		$qz2date=$row_qz2['ExamDate'];
		$qz2score=number_format($value_qz2score,1);
	}else{
		$qz2score='';
		$nullca=1;
	}
	
	#query Semester Examination
	$qae = "SELECT ExamCategory, Examdate, ExamScore, AYear, Semester FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=5";
	$dbae=mysqli_query($qae);
	$total_ae = mysqli_num_rows($dbae);
	$row_ae=mysqli_fetch_array($dbae);
	$value_aescore=$row_ae['ExamScore'];
	if(($total_ae>0)&&($value_aescore<>'')){
		$aedate=$row_ae['ExamDate'];
		$aescore=number_format($value_aescore,1);
		
		#get values
		$yr=substr($row_ae['AYear'],5,4);
		$sm=$row_ae['Semester'];
		#convert to 60%
		$aescore=number_format($value_aescore,1);
		//$aescore100=number_format($aescore*100/60,1);
        $aescore100=number_format($aescore*100/100,1);
	}else{
		$remarks = "Inc";
		$aescore='';
		$aescore100='';
		$nullae=1;
	}
	
	#query Group Assignment
	$qga = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=6";
	$dbga=mysqli_query($qga);
	$total_ga = mysqli_num_rows($dbga);
	$row_ga=mysqli_fetch_array($dbga);
	$value_gascore=$row_ga['ExamScore'];
	if(($total_ga>0)&&($value_gascore<>'')){
		$gadate=$row_ga['ExamDate'];
		$gascore=number_format($value_gascore,1);
	}else{
		$gascore='';
	}

	#query Supplimentatary Exam
	if($module == 3){
		$qsup = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=7 AND Checked=1";
		}
	else{
		$qsup = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=7";
		}
	
	$dbsup=mysqli_query($qsup);
	$row_sup=mysqli_fetch_array($dbsup);
	$row_sup_total=mysqli_num_rows($dbsup);
	$supdate=$row_sup['ExamDate'];
	$supscore=$row_sup['ExamScore'];
	if(($row_sup_total>0)&&($supscore<>'')){
		$remarks = '';
		$supscore = number_format($supscore,1);
		#empty coursework
		$test2score ='n/a';
	}

	#query Project Exam
	$qpro = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=8";
	$dbpro=mysqli_query($qpro);
	$row_pro=mysqli_fetch_array($dbpro);
	$row_pro_total=mysqli_num_rows($dbpro);
	$prodate=$row_pro['ExamDate'];
	$proscore=$row_pro['ExamScore'];
	if(($row_pro_total>0)&&($proscore<>'')){
		$remarks = '';
		$proscore = number_format($proscore,1);
	}else{
		$proscore='';
	}
	
	#query Classroom Test One (1)
	$qct1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=9";
	$dbct1=mysqli_query($qct1);
	$row_ct1=mysqli_fetch_array($dbct1);
	$row_ct1_total=mysqli_num_rows($dbct1);
	$ct1date=$row_ct1['ExamDate'];
	$ct1score=$row_ct1['ExamScore'];
	if(($row_ct1_total>0)&&($ct1score<>'')){
		$remarks = '';
		$ct1score = number_format($ct1score,1);
	}else{
		$ct1score='';
	}
	
	#query Classroom Test Two (2)
	$qct2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=10";
	$dbct2=mysqli_query($qct2);
	$row_ct2=mysqli_fetch_array($dbct2);
	$row_ct2_total=mysqli_num_rows($dbct2);
	$ct2date=$row_ct2['ExamDate'];
	$ct2score=$row_ct2['ExamScore'];
	if(($row_ct2_total>0)&&($ct2score<>'')){
		$remarks = '';
		$ct2score = number_format($ct2score,1);
	}else{
		$ct2score='';
	}

	
	#query Special Exam
	if($module == 3){
		$qsp = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=11 AND Checked=1";
		}
	else{
		$qsp = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=11";
		}
	$dbsp=mysqli_query($qsp);
	$total_sp = mysqli_num_rows($dbsp);
	$row_sp=mysqli_fetch_array($dbsp);
	$value_spscore=$row_sp['ExamScore'];
	if(($total_sp>0)&&($value_spscore<>'')){
		$spdate=$row_sp['ExamDate'];
		$spscore=number_format($value_spscore,1);
		$remarks = "sp";
		#get values
		#get values
		$yr=substr($row_ae['AYear'],5,4);
		$sm=$row_ae['Semester'];
		
		#convert to 100%
		$aescore=number_format($value_aescore,1);
		//$aescore100=number_format($aescore*100/60,1);
        $aescore100=number_format($aescore*100/100,1);
		
	}else{
		$spscore='';
	}
	
	#Check if the course is option
	$qcoption = "SELECT Status FROM courseprogramme 
				WHERE  (ProgrammeID='$deg') AND (CourseCode='$course')";
	$dbcoption = mysqli_query($qcoption);
	$row_coption = mysqli_fetch_array($dbcoption);
	$coption = $row_coption ['Status']; 
	
	#check if ommited
	$qcount = "SELECT DISTINCT Count FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo'";
	$dbcount=mysqli_query($qcount);
	$row_count=mysqli_fetch_array($dbcount);
	$count =$row_count['Count'];
	
	if ($count==1){
		$unit=0;
		$coursename ='*'.$coursename;
	}
	
	if(($coption==2) and ($marks<1)){
		$unit=0;
	}
	
	#get Continuous Assessment (C.A)
	$test2score = $hw1score + $hw2score + $qz1score + $qz2score + $gascore + $proscore + $ct1score + $ct2score;
	$test2score = number_format($test2score,1);
	
	#covert semester exam
	$xscore = 20-$aescore;
	if (($xscore<=0.5)&&($xscore>0)){
		$aescore=20;
	}
	
	#get total marks
	if (($row_sup_total>0)&&($supscore<>'')){
				$tmarks = $supscore;
				if($tmarks>=40){
					$gradesupp='C';
					$remark = 'PASS';
				}
	}
	elseif(($row_pro_total>0)&&($proscore<>'')){
		$tmarks = $proscore;
		$gradesupp='';
	}
	/*
	elseif(($row_pt_total>0)&&($ptscore<>'')){
		$tmarks = $ptscore;
	}
	*/
	elseif(($total_sp>0)&&($spscore<>'')){
		$tmarks = $test2score + $spscore;
		$gradesupp='';
	}
	else{
		$tmarks = $test2score + $aescore;
		$gradesupp='';
	}

	#round marks
	$marks = number_format($tmarks,0);

?>
