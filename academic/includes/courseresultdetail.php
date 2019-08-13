<?php
		#if exam type is Final Exam
				$pdf->setFont('Arial', 'B', 7); 
				$x = $x-20;
				$pdf->line($x, $y, 570.28, $y); 
				$pdf->line($x, $y+15, 570.28, $y+15); 
				$pdf->line($x, $y, $x, $y+15); 			$pdf->text($x+2, $y+12, 'S/No');
				$pdf->line($x+30, $y, $x+30, $y+15);	$pdf->text($x+35, $y+12, 'Name');
				$pdf->line($x+186, $y, $x+186, $y+15);	$pdf->text($x+190, $y+13, 'HW1'); $pdf->text($x+190, $y+6, '');
				$pdf->line($x+210, $y, $x+210, $y+15);	$pdf->text($x+214, $y+13, 'HW2'); $pdf->text($x+214, $y+6, '');
				$pdf->line($x+234, $y, $x+234, $y+15);	$pdf->text($x+236, $y+13, 'QZ1'); $pdf->text($x+236, $y+6, '');
				$pdf->line($x+258, $y, $x+258, $y+15);	$pdf->text($x+260, $y+13, 'QZ2'); $pdf->text($x+260, $y+6, '');
				$pdf->line($x+282, $y, $x+282, $y+15);	$pdf->text($x+284, $y+13, 'GAS'); $pdf->text($x+284, $y+6, '');
				$pdf->line($x+304, $y, $x+304, $y+15);	$pdf->text($x+306, $y+13, 'PRO'); $pdf->text($x+306, $y+6, '');
				$pdf->line($x+328, $y, $x+328, $y+15);	$pdf->text($x+330, $y+13, 'CT1'); $pdf->text($x+330, $y+6, '');
				$pdf->line($x+352, $y, $x+352, $y+15);	$pdf->text($x+354, $y+13, 'CT2'); $pdf->text($x+354, $y+6, '');
				$pdf->line($x+374, $y, $x+374, $y+15);	$pdf->text($x+375, $y+12, 'CA/40'); 
				$pdf->line($x+398, $y, $x+398, $y+15);	$pdf->text($x+399, $y+12, 'SE/100'); 
				$pdf->line($x+422, $y, $x+422, $y+15);	$pdf->text($x+423, $y+12, 'SE/60'); 
				$pdf->line($x+446, $y, $x+446, $y+15);	$pdf->text($x+448, $y+12, 'Total'); 
				$pdf->line($x+470, $y, $x+470, $y+15);	$pdf->text($x+472, $y+12, 'Grade'); 
				$pdf->line($x+494, $y, $x+494, $y+15);	$pdf->text($x+496, $y+12, 'Remark');
				$pdf->line(570.28, $y, 570.28, $y+15);   
				$pdf->setFont('Arial', '', 8); 
      
		#get coursename
		$qcourse = "Select CourseName, Department, StudyLevel from course where CourseCode = '$coursecode'";
		$dbcourse = mysql_query($qcourse);
		$row_course = mysql_fetch_array($dbcourse);
		$coursename = $row_course['CourseName'];
		$coursefaculty = $row_course['Department'];

		#initiate grade counter
		$countgradeA=0;
		$countgradeBplus=0;
		$countgradeB=0;
		$countgradeC=0;
		$countgradeD=0;
		$countgradeE=0;
		$countgradeI=0;

		$countgradeAm=0;
		$countgradeBplusm=0;
		$countgradeBm=0;
		$countgradeCm=0;
		$countgradeDm=0;
		$countgradeEm=0;
		$countgradeIm=0;

		$countgradeAf=0;
		$countgradeBplusf=0;
		$countgradeBf=0;
		$countgradeCf=0;
		$countgradeDf=0;
		$countgradeEf=0;
		$countgradeIf=0;
		#print title
		$sn=0;
		while($row_regno = mysql_fetch_array($dbregno)){
				$key= $row_regno['RegNo'];
				$course= $coursecode;
				$ayear = $year;
				$units= $row_course['Units'];
				$sn=$sn+1;
				$remarks = 'remarks';
				$grade='';

				#get name and sex of the candidate
				$qstudent = "SELECT Name, Sex from student WHERE RegNo = '$key'";
				$dbstudent = mysql_query($qstudent); 
				$row_result = mysql_fetch_array($dbstudent);
				$name = $row_result['Name'];
				$sex = strtoupper($row_result['Sex']);
				
				# grade marks
				$RegNo = $key;
				include 'includes/choose_studylevel.php';

			  #update grade counter
			   if ($grade=='A'){
				$countgradeA=$countgradeA+1;
					if($sex=='M'){
						$countgradeAm=$countgradeAm+1;
					}else{
						$countgradeAf=$countgradeAf+1;
					}
				}elseif($grade=='B+'){
					$countgradeBplus=$countgradeBplus+1;
					if($sex=='M'){
						$countgradeBplusm=$countgradeBplusm+1;
					}else{
						$countgradeBplusf=$countgradeBplusf+1;
					}
				}elseif($grade=='B'){
					$countgradeB=$countgradeB+1;
					if($sex=='M'){
						$countgradeBm=$countgradeBm+1;
					}else{
						$countgradeBf=$countgradeBf+1;
					}
			    }elseif($grade=='C'){
					$countgradeC=$countgradeC+1;
					if($sex=='M'){
						$countgradeCm=$countgradeCm+1;
					}else{
						$countgradeCf=$countgradeCf+1;
					}
			   }elseif($grade=='D'){
					$countgradeD=$countgradeD+1;
					if($sex=='M'){
						$countgradeDm=$countgradeDm+1;
					}else{
						$countgradeDf=$countgradeDf+1;
					}
			   }elseif($grade=='F'){
					$countgradeE=$countgradeE+1;
					if($sex=='M'){
						$countgradeEm=$countgradeEm+1;
					}else{
						$countgradeEf=$countgradeEf+1;
					}
			   }else{
					$countgradeI=$countgradeI+1;
					if($sex=='M'){
						$countgradeIm=$countgradeIm+1;
					}else{
						$countgradeIf=$countgradeIf+1;
					}
				}
			 // }
			 
				
		#display results
		
		#calculate summary areas
		$yind = $y+15;
		$dataarea = $ypoint-$yind;
		if ($dataarea< 20){
				$pdf->addPage();  
	
				$x=50;
				$y=50;
				$pg=$pg+1;
				$tpg =$pg;
				$pdf->setFont('Arial', 'I', 8);     
				$pdf->text(530.28, 820.89, 'Page '.$pg);  
				$pdf->text(300, 820.89, $copycount);    
				$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   
				$yind = $y; 
				$pdf->setFont('Arial', '', 10);  
				#reset the value of y
				#if exam type is Final Exam
				$pdf->setFont('Arial', 'B', 7); 
				$x = $x-20;
				$pdf->line($x, $y, 570.28, $y); 
				$pdf->line($x, $y+15, 570.28, $y+15); 
				$pdf->line($x, $y, $x, $y+15); 			$pdf->text($x+2, $y+12, 'S/No');
				$pdf->line($x+30, $y, $x+30, $y+15);	$pdf->text($x+35, $y+12, 'Name');
				$pdf->line($x+186, $y, $x+186, $y+15);	$pdf->text($x+190, $y+13, 'HW1'); $pdf->text($x+190, $y+6, '');
				$pdf->line($x+210, $y, $x+210, $y+15);	$pdf->text($x+214, $y+13, 'HW2'); $pdf->text($x+214, $y+6, '');
				$pdf->line($x+234, $y, $x+234, $y+15);	$pdf->text($x+236, $y+13, 'QZ1'); $pdf->text($x+236, $y+6, '');
				$pdf->line($x+258, $y, $x+258, $y+15);	$pdf->text($x+260, $y+13, 'QZ2'); $pdf->text($x+260, $y+6, '');
				$pdf->line($x+282, $y, $x+282, $y+15);	$pdf->text($x+284, $y+13, 'GAS'); $pdf->text($x+284, $y+6, '');
				$pdf->line($x+304, $y, $x+304, $y+15);	$pdf->text($x+306, $y+13, 'PRO'); $pdf->text($x+306, $y+6, '');
				$pdf->line($x+328, $y, $x+328, $y+15);	$pdf->text($x+330, $y+13, 'CT1'); $pdf->text($x+330, $y+6, '');
				$pdf->line($x+352, $y, $x+352, $y+15);	$pdf->text($x+354, $y+13, 'CT2'); $pdf->text($x+354, $y+6, '');
				$pdf->line($x+374, $y, $x+374, $y+15);	$pdf->text($x+375, $y+12, 'CA/40'); 
				$pdf->line($x+398, $y, $x+398, $y+15);	$pdf->text($x+399, $y+12, 'SE/100'); 
				$pdf->line($x+422, $y, $x+422, $y+15);	$pdf->text($x+423, $y+12, 'SE/60'); 
				$pdf->line($x+446, $y, $x+446, $y+15);	$pdf->text($x+448, $y+12, 'Total'); 
				$pdf->line($x+470, $y, $x+470, $y+15);	$pdf->text($x+472, $y+12, 'Grade'); 
				$pdf->line($x+494, $y, $x+494, $y+15);	$pdf->text($x+496, $y+12, 'Remark');
				$pdf->line(570.28, $y, 570.28, $y+15);   
				$pdf->setFont('Arial', '', 8); 
		}
		if ($test2score ==-1){
			$test2score = 'PASS';
		}
		if ($aescore ==-1){
			$aescore = 'PASS';
		} 
		if ($marks == -2) {
			$marks = 'PASS'; 
		}
		$y=$y+15;
			$pdf->setFont('Arial', '', 8.7);    
		$pdf->line($x, $y, 570.28, $y);
		$pdf->line($x, $y+15, 570.28, $y+15); 
		$pdf->line($x, $y, $x, $y+15); 			$pdf->text($x+2, $y+12, $sn);
		$pdf->line($x+30, $y, $x+30, $y+15);	$pdf->text($x+35, $y+12, $name);
		
		$pdf->line($x+186, $y, $x+186, $y+15);	$pdf->text($x+188, $y+12, $hw1score);
		$pdf->line($x+210, $y, $x+210, $y+15);	$pdf->text($x+212, $y+12, $hw2score);
		$pdf->line($x+234, $y, $x+234, $y+15);	$pdf->text($x+236, $y+12, $qz1score);
		$pdf->line($x+258, $y, $x+258, $y+15);	$pdf->text($x+260, $y+12, $qz2score);
		$pdf->line($x+282, $y, $x+282, $y+15);	$pdf->text($x+284, $y+12, $gascore);
		$pdf->line($x+304, $y, $x+304, $y+15);	$pdf->text($x+306, $y+12, $proscore);
		$pdf->line($x+328, $y, $x+328, $y+15);	$pdf->text($x+330, $y+12, $ct1score);
		$pdf->line($x+352, $y, $x+352, $y+15);	$pdf->text($x+354, $y+12, $ct2score);
		$pdf->line($x+374, $y, $x+374, $y+15);	$pdf->text($x+378, $y+12, $test2score); 
		$pdf->line($x+398, $y, $x+398, $y+15);	$pdf->text($x+400, $y+12, $aescore100); 
		$pdf->line($x+422, $y, $x+422, $y+15);	$pdf->text($x+424, $y+12, $aescore); 
		$pdf->line($x+446, $y, $x+446, $y+15);	$pdf->text($x+448, $y+12, $marks); 
		$pdf->line($x+470, $y, $x+470, $y+15);	$pdf->text($x+472, $y+12, $grade); 
		$pdf->line($x+494, $y, $x+494, $y+15);	$pdf->text($x+496, $y+12, $remark);
		$pdf->line(570.28, $y, 570.28, $y+15);   
	/*
		$pdf->line($x+186, $y, $x+186, $y+15);	$pdf->text($x+192, $y+12, strtoupper($sex));
		$pdf->line($x+210, $y, $x+210, $y+15);	$pdf->text($x+212, $y+12, strtoupper($key));
		$pdf->line($x+310, $y, $x+310, $y+15);	$pdf->text($x+315, $y+12, $test2score);
		$pdf->line($x+340, $y, $x+340, $y+15);	$pdf->text($x+345, $y+12, $aescore100); 
		$pdf->line($x+373, $y, $x+373, $y+15);	$pdf->text($x+377, $y+12, $aescore);
		$pdf->line($x+400, $y, $x+400, $y+15);	$pdf->text($x+405, $y+12, $marks); 
		$pdf->line($x+430, $y, $x+430, $y+15);	$pdf->text($x+439, $y+12, $grade); 
		$pdf->line($x+463, $y, $x+463, $y+15);	$pdf->text($x+465, $y+12, $remark);
		$pdf->line(570.28, $y, 570.28, $y+15);   
	*/
		$pdf->setFont('Arial', '', 10);
	}
#calculate summary areas
	$yind = $y+25;
	$summaryarea = $ypoint-$yind;
	if ($summaryarea<90){
			$pdf->addPage();  

			$x=50;
			$y=50;
			$pg=$pg+1;
			$tpg =$pg;
			$pdf->setFont('Arial', 'I', 8);     
			$pdf->text(530.28, 820.89, 'Page '.$pg);  
			$pdf->text(300, 820.89, $copycount);    
		    $pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   
			$yind = $y; 
			$pdf->setFont('Arial', 'I', 10);     
    }
	@$pdf->setFont('Arial', '', 10); 
	$b=$y+25;
	if ($b<820.89){
		include 'includes/courseresultstats.php';
	}			
?>
