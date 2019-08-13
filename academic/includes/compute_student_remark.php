<?php
	$tmarks ='';
	$marks='';
	$grade='';
	$aescore='';
	$test2score='';
	$remark='';
	$remarks='';

	if($reportgroup <> 'sheet')	
	{
		if	($reportgroup <> 'annualsheet')
		{	

	//	$remarks = 'remarks';
		if($rpttype =='attendlist')	{
			$course= $row_course_total['CourseCode'];
			$qcoption = "SELECT Status FROM courseprogramme 
						WHERE  (ProgrammeID='$deg') AND (CourseCode='$course')";
			#get course details
			$dbcoption = mysql_query($qcoption);
			$row_coption = mysql_fetch_array($dbcoption);
			$coption = $row_coption ['Status']; 
		}
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
					(examresult.Checked='1') AND 
					(course.CourseCode='$course')
					";	
		
		$dbcourse = mysql_query($qcourse);
		$row_course = mysql_fetch_array($dbcourse);
		$coursename = $row_course['CourseName'];
		if($stdreport=='on'){
		 $course= $row_course['CourseCode'];
		}
	  }
	}

	if($coption==1){
		$status ='Core';
	}else{
		$status = 'Elective';
	}

	include '../academic/includes/choose_studylevel.php';

	#check whether to count this course or not
	if(($coption==2)&&($marks<1)){
		$remark = '';
		$tmarks ='';
		$marks = '';
		$grade = '';	
		$supp =	'';			

	}
	elseif(($coption==3)&&($marks<1)){
		$remark = '';
		$tmarks ='';
		$marks = '';
		$grade = '';	
		$supp =	'';			

	}
	else{
		$subjecttaken = $subjecttaken+1;
		#compute total marks
		$gmarks = $gmarks+$marks;
	}

	if (($remark<>'PASS') and ($marks>0)){
		if(($marks>0)||($coption<>2)){
			$totalfailed=$totalfailed+1;
		}
	}
	if($remark == 'ABSC'){
		if ($coption==2){
			$remark = '';
			$marks = '';
			$grade = '';
			$totalinccount=$totalinccount+1;

		}
		else{
			$remark = 'ABSC';
			$marks = '';
			$grade = '';
			$totalinccount=$totalinccount+1;

		}
	}
			
	# print exam results values
	if($reportgroup == 'sheet')	
	{	
			if ($supp=='!')
				{
					$pdf->setFont('Arial', 'B', $fonts);
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+3, $y+12, $test2score);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+23, $y+12, $aescore);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+43, $y+12, $marks);}else{ $pdf->text($clmspace+3, $y+12, $marks);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+63, $y+12, $grade);}else{ $pdf->text($clmspace+23, $y+12, $grade);}
					$supp=''; 	$fsup='!';
					$pdf->setFont('Arial', '', $fonts);
				}else{
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+3, $y+12, $test2score);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+23, $y+12, $aescore);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+43, $y+12, $marks);}else{ $pdf->text($clmspace+3, $y+12, $marks);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+63, $y+12, $grade);}else{ $pdf->text($clmspace+23, $y+12, $grade);}
				}
			$pdf->line($clmspace+$clmw, $y, $clmspace+$clmw, $y+15);
			$clmspace = $clmspace+$clmw;	

			#fill blank space
			 $emptycolm = $totalcolms - $total_rows;
			 while ($emptycolm  >0){
				$pdf->line($clmspace+$clmw, $y, $clmspace+$clmw, $y+15);
				$clmspace = $clmspace+$clmw;	
				$emptycolm = $emptycolm-1;
				$pdf->line($clnspace, $y+15, $clnspace+$clmw, $y+15);
                            $clnspace = $clnspace+$clmw;
			 }
	}
	elseif($reportgroup == 'annualsheet')	 
	{
	   if($semval == 2)
	   {
		  if ($sem1ovremark != 'ABSC')
		  
		  {
	   		if ($supp=='!')
				{
					$pdf->setFont('Arial', 'B', 8);
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+3, $y+12, $test2score);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+23, $y+12, $aescore);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+43, $y+12, $marks);}else{ $pdf->text($clmspace+3, $y+12, $marks);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+63, $y+12, $grade);}else{ $pdf->text($clmspace+23, $y+12, $grade);}
					$supp=''; 	$fsup='!';
					$pdf->setFont('Arial', '', 8);
				}else{
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+3, $y+12, $test2score);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+23, $y+12, $aescore);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+43, $y+12, $marks);}else{ $pdf->text($clmspace+3, $y+12, $marks);}
					if ($marksdisplayoption<>'compact'){ $pdf->text($clmspace+63, $y+12, $grade);}else{ $pdf->text($clmspace+23, $y+12, $grade);}
				}
		  }
			$pdf->line($clmspace+$clmw, $y, $clmspace+$clmw, $y+15);
			$clmspace = $clmspace+$clmw;	

			#fill blank space
			 $emptycolm = $totalcolms - $total_rows;
			 while ($emptycolm  >0){
				$pdf->line($clmspace+$clmw, $y, $clmspace+$clmw, $y+15);
				$clmspace = $clmspace+$clmw;	
				$emptycolm = $emptycolm-1;
				$pdf->line($clnspace, $y+15, $clnspace+$clmw, $y+15);
                            $clnspace = $clnspace+$clmw;
			 }
	   }
	} 
	
	#compute static values
	$gunits = $unittaken +$gunits;
	$gpoints = $totalsgp + $gpoints;
?>
