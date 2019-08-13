<?php
#start pdf
if (isset($_POST['PDF']) && ($_POST['PDF'] == "Print PDF")){
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php');

	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
	$dborg = mysql_query($qorg);
	$row_org = mysql_fetch_assoc($dborg);
	$org = $row_org['Name'];

	@$checkdegree = addslashes($_POST['checkdegree']);
	@$checkyear = addslashes($_POST['checkyear']);
	@$checkdept = addslashes($_POST['checkdept']);
	@$checkcohot = addslashes($_POST['checkcohot']);
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
		
		#determine total number of columns
		$qstd = "SELECT RegNo FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
		$dbstd = mysql_query($qstd);
		$totalcolms = 0;
		while($rowstd = mysql_fetch_array($dbstd)) {
			$stdregno = $rowstd['RegNo'];
			$qstdcourse = "SELECT DISTINCT coursecode FROM examresult WHERE (RegNo='$stdregno') AND (AYear='$year') AND (Semester='$sem') ORDER BY coursecode";
			
			$dbstdcourse = mysql_query($qstdcourse);
			$totalstdcourse = mysql_num_rows($dbstdcourse);
			#count total courses for all students
			if ($totalstdcourse>$totalcolms){
				$totalcolms = $totalstdcourse;
			}
		}
		#start pdf
		include('includes/PDF.php');
		$pdf = &PDF::factory($layout, $paper);      
		$pdf->open();                         
		$pdf->setCompression(true);           
		$pdf->addPage();  
		$pdf->setFont('Arial', 'I', 8);     
		$pdf->text(50, $ypoint, 'Printed On '.$today = date("d-m-Y H:i:s"));  		
 
		#put page header
		$x=60;
		$y=74;
		$i=1;
		$pg=1;
		$pdf->text($xpoint,$ypoint, 'Page '.$pg);   
		
		#count unregistered
		$j=0;
		#count sex
		$fmcount = 0;
		$mcount = 0;
		$fcount = 0;
		#print row 1
		#print NACTE FORM EXAM 0.3
		$pdf->setFont('Arial', 'B', 12);   
		$pdf->text(50,$y, 'NACTE FORM EXAM 03');
		  
		#print header for landscape paper layout 
		$playout ='l'; 
		include '../includes/orgname.php';
		#print row 2
		$pdf->setFillColor('rgb', 0, 0, 0);    
		$pdf->setFont('Arial', 'B', 20);      
		$pdf->text($x+190, $y+20, strtoupper($faculty)); 
		$pdf->text(50, $y+40, strtoupper($class)); 
		#print row 3
		$pdf->text($x+150, $y+40, 'PROVISIONAL OVERALL SUMMARY RESULTS');
		#print row 4
			$pdf->setFont('Arial', 'B', 12);   
			//$pdf->text(50, $y+60, 'NTA LEVEL 4:');
			$pdf->text($x+90, $y+60, strtoupper($progname));
		#print row 5
			$pdf->text(50, $y+60, 'Year of study: '.$year.' - '.$sem);
			//$pdf->text($x+300, $y+74, 'Semester: '.$sem);
			$pdf->text($x+650, $y+60, 'Weight: CA - 40%');
			$pdf->text($x+768, $y+60, 'Weight: SE - 60%');
		#reset values of x,y
		$x=50; $y=$y+88;
		#set table header
		#print row 1
		$pdf->line($x, $y, $xpoint+25, $y); //first horizontal line
		$pdf->line($x, $y+14, $xpoint+25, $y+14); //second horizontal line
		$pdf->line($x, $y, $x, $y+14); //first vertical line
		$pdf->line($xpoint+25, $y, $xpoint+25, $y+14); //last vertical line
		#print row 2
		$pdf->line($x, $y+28, $xpoint+25, $y+28); //second horizontal line
		$pdf->line($x, $y+14, $x, $y+28); //first vertical line
		$pdf->line($xpoint+25, $y+14, $xpoint+25, $y+28); //last vertical line
		#print row 3
		//$pdf->line($x+150, $y+42, $xpoint+25, $y+42); //second horizontal line
		$pdf->line($x, $y+28, $x, $y+42); //first vertical line
		$pdf->line($xpoint+25, $y+28, $xpoint+25, $y+42); //last vertical line
		#print row 4
		$pdf->line($x, $y+56, $xpoint+25, $y+56); //second horizontal line
		$pdf->line($x, $y+42, $x, $y+56); //first vertical line
		$pdf->line($xpoint+25, $y+42, $xpoint+25, $y+56); //last vertical line
		#print row 5
		$pdf->line($x, $y+70, $xpoint+25, $y+70); //second horizontal line
		$pdf->line($x, $y+56, $x, $y+70); //first vertical line
		$pdf->line($xpoint+25, $y+56, $xpoint+25, $y+70); //last vertical line
		
		#print module column
		$pdf->line($x+150, $y, $x+150, $y+70); 
		$pdf->line($x+25, $y+56, $x+25, $y+70); 
		$pdf->line($x+120, $y+56, $x+120, $y+70); 
		#print text
			$pdf->setFont('Arial', '', 10); 
			$pdf->text($x+2, $y+12, 'Module Credits:');
			$pdf->text($x+2, $y+24, 'Module Code:');
			$pdf->text($x+2, $y+48, 'Exam Components:');
			$pdf->text($x+2, $y+68, 'S/No');
			$pdf->text($x+26, $y+68, 'Reg. No.');
			$pdf->text($x+122, $y+68, 'Sex');
			$pdf->text($x+275, $y+68, 'Module Code (Module Credit)'); 
		#reset values of x,y
		$x=50; $y=$y+56;
		#set colm width
		$clmw = 80;
		#get column width factor
		$cwf = 80;
		#calculate course clumns widths
		$cw = $cwf*$totalcolms;
		$x=$x+235;
		$x=$x-85;
		$pdf->line($x+$cw, $y, $x+$cw, $y+14);	$pdf->text($x+$cw+1, $y+12, 'QTY');
		$pdf->line($x+$cw+30, $y, $x+$cw+30, $y+14);	$pdf->text($x+$cw+32, $y+12, 'TOTL'); $pdf->text($x+$cw+22, $y-8, 'OVERALL PERFORMANCE'); 
		$pdf->line($x+$cw+60, $y, $x+$cw+60, $y+14);	$pdf->text($x+$cw+67, $y+12, 'AVG'); 
		$pdf->line($x+$cw+95, $y, $x+$cw+95, $y+14);	$pdf->text($x+$cw+97, $y+12, 'Remark');
		$pdf->line($xpoint+25, $y, $xpoint+25, $y+14);  
		$y=$y+15;
		
		#query student list
		$overallpasscount = 0;
		$overallsuppcount = 0;
		$overallinccount = 0;
		$qstudent = "SELECT Name, RegNo, Sex, DBirth, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY RegNo";
		$dbstudent = mysql_query($qstudent);
		$totalstudent = mysql_num_rows($dbstudent);
		$i=1;
			$jheader = 0;
			while($rowstudent = mysql_fetch_array($dbstudent)) {
					$name = $rowstudent['Name'];
					$regno = $rowstudent['RegNo'];
					$sex = $rowstudent['Sex'];
					$bdate = $rowstudent['DBirth'];
					# get all courses for this candidate
					$qcourse="SELECT DISTINCT course.Units, course.Department, course.StudyLevel, examresult.CourseCode FROM 
								course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
									 WHERE (examresult.RegNo='$regno') AND (examresult.AYear='$year') AND (examresult.Semester='$sem') ORDER BY examresult.CourseCode";	
					$dbcourse = mysql_query($qcourse);
					$dbcourseUnit = mysql_query($qcourse);
					$total_rows = mysql_num_rows($dbcourse);
					
					if($total_rows>0){
		
					#initialise
					$totalunit=0;
					$gmarks=0;
					$totalfailed=0;
					$unittaken=0;
					$sgp=0;
					$totalsgp=0;
					$gpa=0;
					$key = $regno; 
					$x=50;
					
					#print student info
					$pdf->setFont('Arial', '', 8); 
					$pdf->line($x, $y, $xpoint+25, $y); 
					$pdf->line($x, $y+28, $xpoint+25, $y+28); 
					$pdf->line($x, $y, $x, $y+28); 			$pdf->text($x+2, $y+26, $i);
					$pdf->line($x+25, $y, $x+25, $y+28);	 $pdf->text($x+27, $y+15, strtoupper($regno)); $pdf->text($x+27, $y+25, 'B.Date: '.strtoupper($bdate));
					$x=$x-85;
					$pdf->line($x+205, $y, $x+205, $y+28);	$pdf->text($x+210, $y+16, strtoupper($sex));
					$pdf->line($x+235, $y, $x+235, $y+28);	
					
					#calculate course clumns widths
					$clnspace = $x+235; 
					$header = $x+235;
						while($rowcourse = mysql_fetch_array($dbcourse)) { 
							$stdcourse = $rowcourse['CourseCode']; 
							$unit = $rowcourse['Units'];
							//$pdf->text($clnspace+20, $y+12, $stdcourse.' ('.$unit.')');
							$pdf->text($clnspace+20, $y+12, $stdcourse);
							$pdf->line($clnspace, $y+15, $clnspace+$clmw, $y+15);
							#partition the course
								 $pdf->line($clnspace+20, $y+15, $clnspace+20, $y+28);
								 $pdf->line($clnspace+40, $y+15, $clnspace+40, $y+28);
								 $pdf->line($clnspace+60, $y+15, $clnspace+60, $y+28);
								 //$pdf->line($clnspace+80, $y+15, $clnspace+80, $y+28);
								 $pdf->line($clnspace, $y+28, $clnspace+$clmw, $y+28);
								 //$pdf->line($clnspace+$clmw, $y, $clnspace+$clmw, $y+28);
							
							#print exam categories headers
							if ($jheader==0){
								for ($jheader =0; $jheader < $totalcolms; $jheader++){
									 #partition the header
									 $pdf->text($header+3, $y-35, 'CW'); 	
									 $pdf->text($header+3, $y-17, 'X/40');
									 $pdf->line($header+20, $y-42, $header+20, $y-15); 
									 $pdf->text($header+22, $y-35, 'FE'); 
									 $pdf->line($header, $y-30, $header+60, $y-30); 
									 $pdf->text($header+22, $y-17, 'X/60');
									 $pdf->line($header+40, $y-42, $header+40, $y-15); $pdf->text($header+41, $y-35, 'TOTL'); 
									 $pdf->text($header+42, $y-17, 'X/100');
									 $pdf->line($header+60, $y-42, $header+60, $y-15); $pdf->text($header+62, $y-17, 'GRD');
									 $pdf->line($header+80, $y-42, $header+80, $y-15); //$pdf->text($header+82, $y-17, 'GP');
									 //$pdf->line($header+100, $y-42, $header+100, $y-15);
									 $header = $header+$clmw; 
								}
							}
							$clnspace = $clnspace+$clmw;
						 } 
					$jheader = $jheader+1;	 
					#reset colm space
					$clmspace = $x+235; 
							while($row_course = mysql_fetch_array($dbcourseUnit)){
								$course= $row_course['CourseCode'];
								$unit = $row_course['Units'];
								$name = $row_course['CourseName'];
								$coursefaculty = $row_course['Department'];
								$sn=$sn+1;
								$remarks = 'remarks';
								$grade='';
								$RegNo = $key;
						
						#include grading scale
						include 'includes/choose_studylevel.php';	
						#compute total marks
						$gmarks = $gmarks+$marks;
						if ($remark<>'PASS'){
							$totalfailed=$totalfailed+1;
						}
						if ($supp=='!'){
							$pdf->setFont('Arial', 'B', 8);
							$pdf->text($clmspace+3, $y+24, $test2score);
							$pdf->text($clmspace+23, $y+24, $aescore);
							$pdf->text($clmspace+43, $y+24, $marks);
							$pdf->text($clmspace+63, $y+24, $grade);
							//$pdf->text($clmspace+83, $y+24, number_format($sgp/$unit,1,'.',','));
							$supp=''; 	$fsup='!';
							$pdf->setFont('Arial', '', 8);
						}else{
							$pdf->text($clmspace+3, $y+24, $test2score);
							$pdf->text($clmspace+23, $y+24, $aescore);
							$pdf->text($clmspace+43, $y+24, $marks);
							$pdf->text($clmspace+63, $y+24, $grade);
							//$pdf->text($clmspace+83, $y+24, number_format($sgp/$unit,1,'.',','));
						}
						$pdf->line($clmspace+$clmw, $y, $clmspace+$clmw, $y+28);
						$clmspace = $clmspace+$clmw;	
						}
						#fill blank space
						 $emptycolm = $totalcolms - $total_rows;
						 while ($emptycolm  >0){
							$pdf->line($clmspace+$clmw, $y, $clmspace+$clmw, $y+28);
							$clmspace = $clmspace+$clmw;	
							$emptycolm = $emptycolm-1;
							$pdf->line($clnspace, $y+28, $clnspace+$clmw, $y+28);
                            $clnspace = $clnspace+$clmw;
						 }

						$gunits = $unittaken +$gunits;
						$gpoints = $totalsgp + $gpoints;
						$gpa = @substr($totalsgp/$unittaken, 0,3);
						$avg = number_format($gmarks/$total_rows,0);
						#calculate courses column width
						$cw = $cwf*$totalcolms;
						$x=$x+235;
								$pdf->line($x+$cw, $y, $x+$cw, $y+28);	if ($igrade<>'I'){$pdf->text($x+$cw+4, $y+24, $total_rows); } #print total subject candidate taken
								$pdf->line($x+$cw+30, $y, $x+$cw+30, $y+28);	if ($igrade<>'I'){$pdf->text($x+$cw+32, $y+24, $gmarks); }
								$pdf->line($x+$cw+60, $y, $x+$cw+60, $y+28);	if ($igrade<>'I'){$pdf->text($x+$cw+67, $y+24, $avg); }
								
								#get student remarks
								$qremarks = "SELECT Remark FROM studentremark WHERE RegNo='$regno'";
								$dbremarks = mysql_query($qremarks);
								$row_remarks = mysql_fetch_assoc($dbremarks);
								$totalremarks = mysql_num_rows($dbremarks);
								$studentremarks = $row_remarks['Remark'];
								if(($totalremarks>0)&&($studentremarks<>'')){
									$remark = $studentremarks;
								}else{
										$halfsubjects = number_format($total_rows/2,0);
										if ($totalfailed  == 0){
											$remark = 'PASS';
											}
										elseif (($totalfailed <= $halfsubjects)&&($avg >= 36)){
											$remark = 'SUPP, see values in bold';
											}
										elseif (($totalfailed < $halfsubjects)&&($avg >= 36)){
											$remark = 'REPEAT';
											}
										else{
											$remark = 'DISCO';
											}
										}
								$pdf->line($x+$cw+60, $y, $x+$cw+60, $y+28);	
								$pdf->line($xpoint+25, $y, $xpoint+25, $y+28); 
								
								$pdf->line($x+$cw+60, $y+28, $x+$cw+95, $y+28);
								$pdf->line($x+$cw+95, $y, $x+$cw+95, $y+28);	
						#check failed exam
						if ($fexm=='#'){
						$pdf->text($x+$cw+97, $y+26, $fexm.' = Fail Exam'); $fexm = ''; $remark ='';
						}
						#check failed exam
						if(($totalremarks>0)&&($studentremarks<>'')){
								$pdf->text($x+$cw+97, $y+14, $remark);
								$remark ='';
								$fexm = '';
								$fcwk = '';
								$fsup = ''; 
								$igrade = ''; 
								$egrade = ''; 
						}else{
						/*
							#check for supp and inco	
									if ($igrade<>'I'){
									     //  $pdf->text($x+$cw+77, $y+24, '  '.$gpagrade); 
									   }
										if($fsup=='!'){
											$pdf->text($x+$cw+97, $y+12, 'SUPP');
											$fsup = '';
											$overallsuppcount = $overallsuppcount+1;
										}elseif (($igrade<>'I') || ($fsup<>'!')){
											$pdf->text($x+$cw+97, $y+24, $remark);
											$overallpasscount= $overallpasscount+1;
										}

										if($igrade=='I'){
											$pdf->text($x+$cw+97, $y+24, 'INC.');
											$igrade = '';
											$overallinccount = $overallinccount+1;
										}
								
								
								if ($fcwk=='*'){
								$pdf->text($x+$cw+97, $y+38, $fcwk.' = Fail CWK'); $fcwk = ''; $remark ='';
								}
		
								if ($fsup=='!'){
								$pdf->text($x+$cw+97, $y+42, $fsup.' = Supp'); $fsup = ''; $remark ='';
								}
								if ($igrade=='I'){
								$pdf->text($x+$cw+137, $y+42, $igrade.' = Inc.'); $igrade = ''; $remark ='';
								}
								if ($egrade=='*'){
								$pdf->text($x+$cw+137, $y+26, $egrade.' = C/Repeat.'); $egrade = ''; $remark ='';
								}
							*/
						}
					  $i=$i+1;
					  $y=$y+28;
					  if($y>=$ypoint-50){
					  #start new page
						$pdf->addPage();  
						$pdf->setFont('Arial', 'I', 8);     
						$pdf->text(50, $ypoint, 'Printed On '.$today = date("d-m-Y H:i:s"));   
						
						$x=50;
						$y=50;
						$pg=$pg+1;
						$pdf->text($xpoint,$ypoint, 'Page '.$pg);   
						
						#count unregistered
						$j=0;
						#count sex
						$fmcount = 0;
						$mcount = 0;
						$fcount = 0;
						#set table header
						#print row 1
						$pdf->line($x, $y, $xpoint+25, $y); //first horizontal line
						$pdf->line($x, $y+14, $xpoint+25, $y+14); //second horizontal line
						$pdf->line($x, $y, $x, $y+14); //first vertical line
						$pdf->line($xpoint+25, $y, $xpoint+25, $y+14); //last vertical line
						#print row 2
						$pdf->line($x, $y+28, $xpoint+25, $y+28); //second horizontal line
						$pdf->line($x, $y+14, $x, $y+28); //first vertical line
						$pdf->line($xpoint+25, $y+14, $xpoint+25, $y+28); //last vertical line
						#print row 3
						//$pdf->line($x+150, $y+42, $xpoint+25, $y+42); //second horizontal line
						$pdf->line($x, $y+28, $x, $y+42); //first vertical line
						$pdf->line($xpoint+25, $y+28, $xpoint+25, $y+42); //last vertical line
						#print row 4
						$pdf->line($x, $y+56, $xpoint+25, $y+56); //second horizontal line
						$pdf->line($x, $y+42, $x, $y+56); //first vertical line
						$pdf->line($xpoint+25, $y+42, $xpoint+25, $y+56); //last vertical line
						#print row 5
						$pdf->line($x, $y+70, $xpoint+25, $y+70); //second horizontal line
						$pdf->line($x, $y+56, $x, $y+70); //first vertical line
						$pdf->line($xpoint+25, $y+56, $xpoint+25, $y+70); //last vertical line
						
						#print module column
						$pdf->line($x+150, $y, $x+150, $y+70); 
						$pdf->line($x+25, $y+56, $x+25, $y+70); 
						$pdf->line($x+120, $y+56, $x+120, $y+70); 
						#print text
							$pdf->setFont('Arial', '', 10); 
							$pdf->text($x+2, $y+12, 'Module Credits:');
							$pdf->text($x+2, $y+24, 'Module Code:');
							$pdf->text($x+2, $y+48, 'Exam Components:');
							$pdf->text($x+2, $y+68, 'S/No');
							$pdf->text($x+26, $y+68, 'Reg. No.');
							$pdf->text($x+122, $y+68, 'Sex');
							$pdf->text($x+275, $y+68, 'Course Code (Module Code)'); 
						
						
						#reset values of x,y
						$x=50; $y=$y+56;
						#set colm width
						$clmw = 80;
						#get column width factor
						$cwf = 80;
						#calculate course clumns widths
						$cw = $cwf*$totalcolms;
						$header=$x+150;
						$x=$x+235;
						$x=$x-85;
						$jheader=0;
						$pdf->line($x+$cw, $y, $x+$cw, $y+14);	$pdf->text($x+$cw+1, $y+12, 'QTY');
						$pdf->line($x+$cw+30, $y, $x+$cw+30, $y+14);	$pdf->text($x+$cw+32, $y+12, 'TOTL'); $pdf->text($x+$cw+22, $y-8, 'OVERALL PERFORMANCE'); 
						$pdf->line($x+$cw+60, $y, $x+$cw+60, $y+14);	$pdf->text($x+$cw+67, $y+12, 'AVG'); 
						$pdf->line($x+$cw+95, $y, $x+$cw+95, $y+14);	$pdf->text($x+$cw+97, $y+12, 'Remark');
						$pdf->line($xpoint+25, $y, $xpoint+25, $y+14);  
						$y=$y+15;
							#print exam categories headers
							if ($jheader==0){
								for ($jheader =0; $jheader < $totalcolms; $jheader++){
									 #partition the header
									$pdf->setFont('Arial', '', 8); 
									 $pdf->text($header+3, $y-35, 'CW'); 	
									 $pdf->text($header+3, $y-17, 'X/40');
									 $pdf->line($header+20, $y-42, $header+20, $y-15); 
									 $pdf->text($header+22, $y-35, 'FE'); 
									 $pdf->line($header, $y-30, $header+60, $y-30); 
									 $pdf->text($header+22, $y-17, 'X/60');
									 $pdf->line($header+40, $y-42, $header+40, $y-15); $pdf->text($header+41, $y-35, 'TOTL'); 
									 $pdf->text($header+42, $y-17, 'X/100');
									 $pdf->line($header+60, $y-42, $header+60, $y-15); $pdf->text($header+62, $y-17, 'GRD');
									 //$pdf->line($header+80, $y-42, $header+80, $y-15); //$pdf->text($header+82, $y-17, 'GP');
									 //$pdf->line($header+100, $y-42, $header+100, $y-15);
									 $header = $header+$clmw; 
									$pdf->setFont('Arial', '', 10); 
								}
						  }
						  $jheader++;
					  }
				   } //ends if $total_rows
				}//ends $rowstudent loop

#start new page for the keys
$space = $ypoint-50 - $y;
$yind = $y+20; 
if($space<70){
	$pdf->addPage();  

			$x=50;
			$y=50;
			$pg=$pg+1;
			$tpg =$pg;
			$pdf->setFont('Arial', 'I', 8);     
			$pdf->text(50, $ypoint-50, 'Printed On '.$today = date("d-m-Y H:i:s"));   
			$pg=$pg+1;
			$pdf->text($xpoint,$ypoint-50, 'Page '.$pg);   
			$yind = $y; 
 }
 $pdf->text(50, $yind, 'PASS count = '.$overallpasscount.' SUPP Count = '.$overallsuppcount.' INC Count ='.$overallinccount );
 	/*
	$pdf->text(450, $yind, 'Signature of The Dean:  ………………………     ');  
	$pdf->text(450, $yind+12, 'Date: ………………………………………………………       ');
 	$pdf->text(450, $yind+24, 'Signature of the Chairperson of the Senate:  …………………………');  
	$pdf->text(450, $yind+36, 'Date: …………………………………………………………');  

	$pdf->setFont('Arial', 'I', 9); 
	$pdf->text(190.28, $yind, '          ######## END OF EXAM RESULTS ########');   
	
	#table 1
 	include 'includes/pointskey.php';
	$x=50;
	$y= $yind + 44;
	#table 1
 	include 'includes/gradescale.php';
	*/
 	 #output file
	 $filename = ereg_replace("[[:space:]]+", "",$progname);
	 $pdf->output($filename.'.pdf');
	 }
}//end of print pdf
?>
<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'NTA Semester Rpt';
	$szTitle = 'Printing Examination Results Report';
	include('lecturerheader.php');
$editFormAction = $_SERVER['PHP_SELF'];

mysql_select_db($database_zalongwa, $zalongwa);
$query_studentlist = "SELECT RegNo, Name, ProgrammeofStudy FROM student ORDER BY ProgrammeofStudy  ASC";
$studentlist = mysql_query($query_studentlist, $zalongwa) or die(mysql_error());
$row_studentlist = mysql_fetch_assoc($studentlist);
$totalRows_studentlist = mysql_num_rows($studentlist);

mysql_select_db($database_zalongwa, $zalongwa);
$query_degree = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$degree = mysql_query($query_degree, $zalongwa) or die(mysql_error());
$row_degree = mysql_fetch_assoc($degree);
$totalRows_degree = mysql_num_rows($degree);

mysql_select_db($database_zalongwa, $zalongwa);
$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$ayear = mysql_query($query_ayear, $zalongwa) or die(mysql_error());
$row_ayear = mysql_fetch_assoc($ayear);
$totalRows_ayear = mysql_num_rows($ayear);

mysql_select_db($database_zalongwa, $zalongwa);
$query_sem = "SELECT Semester FROM terms ORDER BY Semester";
$sem = mysql_query($query_sem, $zalongwa) or die(mysql_error());
$row_sem = mysql_fetch_assoc($sem);
$totalRows_sem = mysql_num_rows($sem);

mysql_select_db($database_zalongwa, $zalongwa);
$query_dept = "SELECT Faculty, DeptName FROM department ORDER BY DeptName, Faculty ASC";
$dept = mysql_query($query_dept, $zalongwa) or die(mysql_error());
$row_dept = mysql_fetch_assoc($dept);
$totalRows_dept = mysql_num_rows($dept);
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
$dbprog = mysql_query($qprog);
$row_prog = mysql_fetch_array($dbprog);
$progname = $row_prog['Title'];
$qyear= "SELECT AYear FROM academicyear WHERE AYear='$cohotyear'";
$dbyear = mysql_query($qyear);
$row_year = mysql_fetch_array($dbyear);
$year = $row_year['AYear'];
echo $progname;
echo " - ".$year;
?>

<br>
</h4>
<?php

@$checkdegree = addslashes($_POST['checkdegree']);
@$checkyear = addslashes($_POST['checkyear']);
@$checksem = addslashes($_POST['checksem']);
$checkcohot = addslashes($_POST['checkcohot']);

$c=0;

if (($checkdegree=='on') && ($checkyear == 'on') && ($checksem == 'on')&& ($checkcohot == 'on')){
echo "<br><br>Examination Results for Academic Year - ".$ayear;

$deg=addslashes($_POST['degree']);
$year = addslashes($_POST['ayear']);
$cohot = addslashes($_POST['cohot']);
$sem = addslashes($_POST['sem']); 
//query student list
$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY RegNo";
$dbstudent = mysql_query($qstudent);
$totalstudent = mysql_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysql_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];

			# get all courses for this candidate
			$qcourse="SELECT DISTINCT course.Units, course.Department, course.StudyLevel, examresult.CourseCode FROM 
						course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
							 WHERE 
									(RegNo='$regno') AND 
									(AYear='$year') AND 
									(Semester = '$sem')";	
			$dbcourse = mysql_query($qcourse);
			$dbcourseUnit = mysql_query($qcourse);
			$total_rows = mysql_num_rows($dbcourse);
			
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
							<?php while($rowcourse = mysql_fetch_array($dbcourse)) { ?>
							<td><div align="center"><?php echo $rowcourse['CourseCode']; ?></div></td> 
							<?php } ?>
							<td><div align="center">Units</div></td>
							<td><div align="center">Points</div></td>
							<td><div align="center">GPA</div></td>
							<td><div align="center">Grade</div></td>
							<td scope="col">Remarks</td>
				  </tr>
				  <tr>
					<?php while($row_course = mysql_fetch_array($dbcourseUnit)){
						$course= $row_course['CourseCode'];
						$unit = $row_course['Units'];
						$name = $row_course['CourseName'];
						$coursefaculty = $row_course['Department'];
						$sn=$sn+1;
						$remarks = 'remarks';							
							
						$RegNo = $key;
						
						#include grading scale
						include 'includes/choose_studylevel.php';									
				?>
				
				<td><div align="center"><?php echo $grade;?></div></td>
				<?php } //ends while row_course loop
				
				?>
				<td><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?></div></td>
				<td><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?></div></td>
				<td><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa ?></div></td>
				<td><div align="center"><?php #get student remarks
				$qremarks = "SELECT Remark FROM studentremark WHERE RegNo='$regno'";
				$dbremarks = mysql_query($qremarks);
				$row_remarks = mysql_fetch_assoc($dbremarks);
				$totalremarks = mysql_num_rows($dbremarks);
				$studentremarks = $row_remarks['Remark'];
				if(($totalremarks>0)&&($studentremarks<>'')){
					$remark = $studentremarks;
				}else{
				
						if ($gpa  >= 4.4){
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

}elseif (($checkdegree=='on') && ($checkcohot == 'on')){				
//query student list

$deg=$_POST['degree'];
$year = $_POST['ayear'];
$cohot = $_POST['cohot'];
$dept = $_POST['dept'];
echo "<br><br>Examination Results for Academic Year - ".$year;
//query student list
$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY RegNo";
$dbstudent = mysql_query($qstudent);
$totalstudent = mysql_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysql_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];

			# get all courses for this candidate
			$qcourse="SELECT DISTINCT course.Units, course.Department, course.StudyLevel, examresult.CourseCode FROM 
						course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
							 WHERE 
									(RegNo='$regno') AND 
									(AYear='$year') ";	
			$dbcourse = mysql_query($qcourse) or die("No Exam Results for the Candidate - $key ");
			$dbcourseUnit = mysql_query($qcourse);
			$total_rows = mysql_num_rows($dbcourse);
			
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
							<?php while($rowcourse = mysql_fetch_array($dbcourse)) { ?>
							<td><div align="center"><?php echo $rowcourse['CourseCode']; ?></div></td> 
							<?php } ?>
							<td><div align="center">Units</div></td>
							<td><div align="center">Points</div></td>
							<td><div align="center">GPA</div></td>
							<td><div align="center">Grade</div></td>
							<td scope="col">Remarks</td>
				  </tr>
				  <tr>
					<?php while($row_course = mysql_fetch_array($dbcourseUnit)){
						$course= $row_course['CourseCode'];
						$unit = $row_course['Units'];
						$name = $row_course['CourseName'];
						$coursefaculty = $row_course['Department'];
						$sn=$sn+1;
						$remarks = 'remarks';							
							
						$RegNo = $key;
						#insert grading results
						include 'includes/choose_studylevel.php';
				?>
				
				<td><div align="center"><?php echo $grade;?></div></td>
				<?php } //ends while row_course loop
				
				?>
				<td><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?></div></td>
				<td><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?></div></td>
				<td><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa; ?></div></td>
				<td><div align="center"><?php #get student remarks
				$qremarks = "SELECT Remark FROM studentremark WHERE RegNo='$regno'";
				$dbremarks = mysql_query($qremarks);
				$row_remarks = mysql_fetch_assoc($dbremarks);
				$totalremarks = mysql_num_rows($dbremarks);
				$studentremarks = $row_remarks['Remark'];
				if(($totalremarks>0)&&($studentremarks<>'')){
					$remark = $studentremarks;
				}else{
				
						if ($gpa  >= 4.4){
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
 
}elseif ($checkcohot == 'on'){				

$deg=addslashes($_POST['degree']);
$year = addslashes($_POST['ayear']);
$cohot = addslashes($_POST['cohot']);
echo "<br><br>Examination Results for Academic Year - ".$year;

//query student list
$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy FROM student WHERE EntryYear = '$cohot' ORDER BY RegNo";
$dbstudent = mysql_query($qstudent);
$totalstudent = mysql_num_rows($dbstudent);
$i=1;
	while($rowstudent = mysql_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];

			# get all courses for this candidate
			$qcourse="SELECT DISTINCT course.Units, course.Department, course.StudyLevel, examresult.CourseCode FROM 
						course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
							 WHERE 
									(RegNo='$regno') AND
									(course.Programme = '$deg') 
							";	
			$dbcourse = mysql_query($qcourse) or die("No Exam Results for the Candidate - $key ");
			$dbcourseUnit = mysql_query($qcourse);
			$total_rows = mysql_num_rows($dbcourse);
			
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
							<?php while($rowcourse = mysql_fetch_array($dbcourse)) { ?>
							<td><div align="center"><?php echo $rowcourse['CourseCode']; ?></div></td> 
							<?php } ?>
							<td><div align="center">Units</div></td>
							<td><div align="center">Points</div></td>
							<td><div align="center">GPA</div></td>
							<td><div align="center">Grade</div></td>
							<td scope="col">Remarks</td>
				  </tr>
				  <tr>
					<?php while($row_course = mysql_fetch_array($dbcourseUnit)){
						$course= $row_course['CourseCode'];
						$unit = $row_course['Units'];
						$name = $row_course['CourseName'];
						$coursefaculty = $row_course['Department'];
						$sn=$sn+1;
						$remarks = 'remarks';							
							
						$RegNo = $key;
						#insert grading results
						include 'includes/choose_studylevel.php';
				?>
				
				<td><div align="center"><?php echo $grade;?></div></td>
				<?php } //ends while row_course loop
				
				?>
				<td><div align="center"><?php $gunits = $unittaken +$gunits; echo $unittaken;  ?></div></td>
				<td><div align="center"><?php $gpoints = $totalsgp + $gpoints; echo $totalsgp;  ?></div></td>
				<td><div align="center"><?php $gpa = @substr($totalsgp/$unittaken, 0,3); echo $gpa; ?></div></td>
				<td><div align="center"><?php #get student remarks
				$qremarks = "SELECT Remark FROM studentremark WHERE RegNo='$regno'";
				$dbremarks = mysql_query($qremarks);
				$row_remarks = mysql_fetch_assoc($dbremarks);
				$totalremarks = mysql_num_rows($dbremarks);
				$studentremarks = $row_remarks['Remark'];
				if(($totalremarks>0)&&($studentremarks<>'')){
					$remark = $studentremarks;
				}else{
				
						if ($gpa  >= 4.4){
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
			<table width="200" border="0" bgcolor="#CCCCCC">
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
} while ($row_degree = mysql_fetch_assoc($degree));
  $rows = mysql_num_rows($degree);
  if($rows > 0) {
      mysql_data_seek($degree, 0);
	  $row_degree = mysql_fetch_assoc($degree);
  }
?>
                        </select>
                    </div></td></tr>
                <tr>
                  <td><input name="checkcohot" type="checkbox" id="checkcohot" value="on"></td>
                  <td nowrap><div align="left">Cohort of the  Year: </div></td>
                  <td><div align="left">
                    <select name="cohot" id="cohot">
                        <?php
do {  
?>
                        <option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
                        <?php
} while ($row_ayear = mysql_fetch_assoc($ayear));
  $rows = mysql_num_rows($ayear);
  if($rows > 0) {
      mysql_data_seek($ayear, 0);
	  $row_ayear = mysql_fetch_assoc($ayear);
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
} while ($row_ayear = mysql_fetch_assoc($ayear));
  $rows = mysql_num_rows($ayear);
  if($rows > 0) {
      mysql_data_seek($ayear, 0);
	  $row_ayear = mysql_fetch_assoc($ayear);
  }
?>
                    </select>
                  </div></td>
                </tr>
            	<tr>
                  <td><input name="checksem" type="checkbox" id="checksem" value="on"></td>
                  <td nowrap><div align="left">Semester: </div></td>
                  <td><div align="left">
                    <select name="sem" id="sem">
                        <?php
do {  
?>
                        <option value="<?php echo $row_sem['Semester']?>"><?php echo $row_sem['Semester']?></option>
                        <?php
} while ($row_sem = mysql_fetch_assoc($sem));
  $rows = mysql_num_rows($sem);
  if($rows > 0) {
      mysql_data_seek($sem, 0);
	  $row_sem = mysql_fetch_assoc($sem);
  }
?>
                    </select>
                  </div></td>
                </tr>
                <tr>
                  <td colspan="3"><div align="center">
                    <input type="submit" name="PDF"  id="PDF" value="Print PDF">
                  </div></td>
              </tr>
              </table>
              <input name="MM_update" type="hidden" id="MM_update" value="form1">       
  </div>
</form>
<?php
}
include('../footer/footer.php');
?>