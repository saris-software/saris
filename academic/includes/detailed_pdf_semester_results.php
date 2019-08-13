<?php		#set table header
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
			$pdf->text($x+275, $y+68, 'Examinations Results'); 
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
		$pdf->line($x+$cw, $y, $x+$cw, $y+14);	$pdf->text($x+$cw+1, $y+12, 'CRDT');
		$pdf->line($x+$cw+30, $y, $x+$cw+30, $y+14);	$pdf->text($x+$cw+32, $y+12, 'PNTS'); $pdf->text($x+$cw+22, $y-8, 'OVERALL PERFORMANCE'); 
		$pdf->line($x+$cw+60, $y, $x+$cw+60, $y+14);	$pdf->text($x+$cw+67, $y+12, 'GPA'); 
		$pdf->line($x+$cw+95, $y, $x+$cw+95, $y+14);	$pdf->text($x+$cw+97, $y+12, 'Remark');
		$pdf->line($xpoint+25, $y, $xpoint+25, $y+14);  
		$y=$y+15;
		
		#query student list
		$overallpasscount = 0;
		$overallsuppcount = 0;
		$overallinccount = 0;
		$overalldiscocount = 0;
		$overallrepeatcount = 0;
		$qstudent = "SELECT Name, RegNo, Sex, DBirth, ProgrammeofStudy, Faculty, Sponsor, EntryYear, Status FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY RegNo";
		$dbstudent = mysql_query($qstudent);
		$totalstudent = mysql_num_rows($dbstudent);
		$i=1;
		$jheader = 0;
		while($rowstudent = mysql_fetch_array($dbstudent)) 
		{
				$name = stripslashes($rowstudent['Name']);
				$regno = $rowstudent['RegNo'];
				$sex = $rowstudent['Sex'];
				$bdate = $rowstudent['DBirth'];
				
				if ($checkhide=='on'){
					$degree = stripslashes($rowstudent["ProgrammeofStudy"]);
					$faculty = stripslashes($rowstudent["Faculty"]);
					$sponsor = stripslashes($rowstudent["Sponsor"]);
					$entryyear = stripslashes($result['EntryYear']);
					$ststatus = stripslashes($rowstudent['Status']);
				}
				# get all courses for this candidate

				$qcourse = "SELECT DISTINCT CourseCode, Status FROM courseprogramme 
								WHERE  (ProgrammeID='$deg') AND (YearofStudy='$yearofstudy') AND 
									(Semester='$semval') ORDER BY CourseCode";
				$dbcourse = mysql_query($qcourse);
				$dbcourseUnit = mysql_query($qcourse);
				$dbcourseovremark = mysql_query($qcourse);
				$dbcourseheader = mysql_query($qcourse);
				$total_rows = mysql_num_rows($dbcourse);
					
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
					$curr_semester='';
					$totalfailed=0;
					$totalinccount=0;
					$halfsubjects=0;
					$ovremark='';
					$gmarks=0;
					$avg =0;
					$gmarks=0;	
					
					$key = $regno; 
					$x=50;
					
     					#print student info
						$pdf->setFont('Arial', '', 8); 
						$pdf->line($x, $y, $xpoint+25, $y); 
						$pdf->line($x, $y+15, $xpoint+25, $y+15); 
						$pdf->line($x, $y, $x, $y+15); 			$pdf->text($x+2, $y+12, $i);
						$pdf->line($x+25, $y, $x+25, $y+15);	 $pdf->text($x+27, $y+12, strtoupper($regno)); //$pdf->text($x+27, $y+25, 'B.Date: '.strtoupper($bdate));
						$x=$x-85;
						$pdf->line($x+205, $y, $x+205, $y+15);	$pdf->text($x+210, $y+12, strtoupper($sex));
						$pdf->line($x+235, $y, $x+235, $y+15);	
						
						#calculate course clumns widths
						$clnspace = $x+235; 
						$header = $x+235;
					    
						#print header
						while($rowcourse = mysql_fetch_array($dbcourse)) 
						{ 
							$stdcourse = $rowcourse['CourseCode']; 
							$qcoursestd="SELECT Units, Department, StudyLevel FROM course WHERE CourseCode = '$stdcourse'";	
							$dbcoursestd = mysql_query($qcoursestd);
							$row_coursestd = mysql_fetch_array($dbcoursestd);
							$unit = $row_coursestd['Units'];
							$pdf->line($clnspace, $y+15, $clnspace+$clmw, $y+15);
						
							#partition the course
							$pdf->line($clnspace+20, $y, $clnspace+20, $y+15);
							$pdf->line($clnspace+40, $y, $clnspace+40, $y+15);
							$pdf->line($clnspace+60, $y, $clnspace+60, $y+15);
							$pdf->line($clnspace, $y+15, $clnspace+$clmw, $y+15);
								
								#print exam categories headers
								if ($jheader==0){
									$cheader = $header;
									while ($rownheader = mysql_fetch_array($dbcourseheader)) {
											$courseheader = $rownheader['CourseCode']; 
											#get course unit
											$qunits = "SELECT Units FROM course WHERE CourseCode='$courseheader'";
											$dbunits = mysql_query($qunits);
											$row_units = mysql_fetch_array($dbunits);
											$unit=$row_units['Units'];
												#print courses as headers
												$unitheader = $unit;
												$courseheader = $rownheader['CourseCode']; 
												$pdf->text($cheader+26, $y-60, $unitheader);
												$pdf->text($cheader+22, $y-48, $courseheader);
												$cheader = $cheader+$clmw; 
									}
									
										for ($jheader =0; $jheader < $totalcolms; $jheader++)
										{										
											 #partition the header
											 $pdf->text($header+3, $y-35, 'CW'); 	
											 $pdf->text($header+3, $y-17, 'CA');
											 $pdf->line($header+20, $y-42, $header+20, $y-15); 
											 $pdf->text($header+22, $y-35, 'FE'); 
											 $pdf->line($header, $y-30, $header+60, $y-30); 
											 $pdf->text($header+22, $y-17, 'SE');
											 $pdf->line($header+40, $y-42, $header+40, $y-15); $pdf->text($header+41, $y-35, 'TOTL'); 
											 $pdf->text($header+42, $y-17, '100%');
											 $pdf->line($header+60, $y-42, $header+60, $y-15); $pdf->text($header+65, $y-35, 'GD');
											 $pdf->line($header+80, $y-70, $header+80, $y-15); 
											 $header = $header+$clmw; 
										 }
								}
								$clnspace = $clnspace+$clmw;
							}
					$jheader = $jheader+1;	 
					#reset colm space
					$clmspace = $x+235; 
					
 					while($row_course = mysql_fetch_array($dbcourseUnit))
 					{
						$course= $row_course['CourseCode'];
						$coption = $row_course['Status']; 
						
						#get course unit
						$qunits = "SELECT Units FROM course WHERE CourseCode='$course'";
						$dbunits = mysql_query($qunits);
						$row_units = mysql_fetch_array($dbunits);
						$unit=$row_units['Units'];
						
						$sn=$sn+1;
						$remarks = 'remarks';
						$RegNo = $key;
						
						#mark this report as report group 2
						$reportgroup = 'sheet';

						$currentyear=$year;
						include '../academic/includes/compute_student_remark.php';
 						if($semval == 1){
							$sem1unittaken = $unittaken;
							$sem1totalsgp=$totalsgp;
						}elseif($semval == 2){
							$sem2unittaken = $unittaken;
							$sem2totalsgp=$totalsgp;
						}
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
					#check failed exam
					if ($fexm=='#'){
						$pdf->text($x+$cw+97, $y+26, $fexm.' = Fail Exam'); $fexm = ''; $remark ='';
					}
					#check failed exam
					if(($totalremarks>0)&&($studentremarks<>'')){
						$pdf->text($x+$cw+97, $y+12, $ovremark);
						$remark ='';
						$fexm = '';
						$fcwk = '';
						$fsup = ''; 
						$igrade = ''; 
						$egrade = ''; 
					}
					else{
							#check for supp and inco
									$k =0;
									if ($ovremark=='SUPP:'){
										$pdf->text($x+$cw+97, $y+12, $ovremark);
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
														$pdf->text($x+$k+$cw+97, $y+12, ','.$course);
														$k =$k+35;
													}
												#empty option value
												$coption='';
											}
									}
									else{
										$pdf->text($x+$cw+97, $y+12, $ovremark);
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
				
					  $i=$i+1;
					  $y=$y+15;
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
							$pdf->text($x+275, $y+68, 'Examinations Results'); 
						
						
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
						$pdf->line($x+$cw, $y, $x+$cw, $y+14);	$pdf->text($x+$cw+1, $y+12, 'CRDT');
						$pdf->line($x+$cw+30, $y, $x+$cw+30, $y+14);	$pdf->text($x+$cw+32, $y+12, 'PNTS'); $pdf->text($x+$cw+22, $y-8, 'OVERALL PERFORMANCE'); 
						$pdf->line($x+$cw+60, $y, $x+$cw+60, $y+14);	$pdf->text($x+$cw+67, $y+12, 'GPA'); 
						$pdf->line($x+$cw+95, $y, $x+$cw+95, $y+14);	$pdf->text($x+$cw+97, $y+12, 'Remark');
						$pdf->line($xpoint+25, $y, $xpoint+25, $y+14);  
						$y=$y+15;
							#print exam categories headers
							if ($jheader==0){
							$cheader = $header;
							while ($rownheader = mysql_fetch_array($dbcourseheader)) {
								#get course unit
								$qunits = "SELECT Units FROM course WHERE CourseCode='$courseheader'";
								$dbunits = mysql_query($qunits);
								$row_units = mysql_fetch_array($dbunits);
								$unit=$row_units['Units'];
								#print courses as headers
								$unitheader = $unit;
								$courseheader = $rownheader['CourseCode']; 
								$pdf->text($cheader+26, $y-60, $unitheader);
								$pdf->text($cheader+22, $y-48, $courseheader);
								$cheader = $cheader+$clmw; 
							}
								for ($jheader =0; $jheader < $totalcolms; $jheader++){
									 #partition the header
									 $pdf->setFont('Arial', '', 8); 
									 $pdf->text($header+3, $y-35, 'CW'); 	
									 $pdf->text($header+3, $y-17, 'CA');
									 $pdf->line($header+20, $y-42, $header+20, $y-15); 
									 $pdf->text($header+22, $y-35, 'FE'); 
									 $pdf->line($header, $y-30, $header+60, $y-30); 
									 $pdf->text($header+22, $y-17, 'SE');
									 $pdf->line($header+40, $y-42, $header+40, $y-15); $pdf->text($header+41, $y-35, 'TOTL'); 
									 $pdf->text($header+42, $y-17, '100%');
									 $pdf->line($header+60, $y-42, $header+60, $y-15); $pdf->text($header+65, $y-35, 'GD');
									 $pdf->line($header+80, $y-42, $header+80, $y-15);
									 $pdf->line($header+80, $y-70, $header+80, $y-15); 
									 $header = $header+$clmw; 
									 $pdf->setFont('Arial', '', 10); 
								}
						  }
						  $jheader++;
					  }
				  } //ends if $total_rows

			
