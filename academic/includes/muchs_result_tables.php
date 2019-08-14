<?php
		$pdf->text($x+1, $y, 'Semester'); 
		$pdf->text($x+45, $y, 'Code'); 
		$pdf->text($x+84, $y, 'Course Title'); 
		$pdf->text($x+412, $y, 'Units'); 
		$pdf->text($x+437, $y, 'Grade'); 
		$pdf->text($x+472, $y, 'Point'); 
		$pdf->text($x+500, $y, 'GPA'); 
		
		#calculate results
		$i=1;
		while($row_course = mysql_fetch_array($dbcourseUnit)){
			$course= $row_course['CourseCode'];
			$unit = $row_course['Units'];
			$cname = $row_course['CourseName'];
			$coursefaculty = $row_course['Department'];
			$sn=$sn+1;
			$remarks = 'remarks';
			$grade='';
		
		$RegNo = $regno;
		
		#include grading system 					
		include 'includes/gpa_gradingresults.php';
				
				$coursecode = $course;
				
				#print results
				$pdf->text($x+16, $y+$rh, $semid); 
				$pdf->text($x+45, $y+$rh, substr($coursecode,0,6)); 
				$pdf->text($x+84, $y+$rh, substr($cname,0,73)); 
				$pdf->text($x+413, $y+$rh, $unit); 
				$pdf->text($x+445, $y+$rh, $grade); 
				$pdf->text($x+477, $y+$rh, $sgp); 
				#check if the page is full
				$x=$x;
				#draw a line
				$pdf->line($x, $y-$rh+2, 570.28, $y-$rh+2);        
				$pdf->line($x, $y-$rh+2, $x, $y);       
				$pdf->line(570.28, $y-$rh+2, 570.28, $y);      
				$pdf->line($x, $y-$rh+2, $x, $y+$rh+4);              
				$pdf->line(570.28, $y-$rh+2, 570.28, $y+$rh+4);      
				$pdf->line($x+498, $y-$rh+2, $x+498, $y+$rh+4);       
				$pdf->line($x+468, $y-$rh+2, $x+468, $y+$rh+4);     
				$pdf->line($x+434, $y-$rh+2, $x+434, $y+$rh+4);       
				$pdf->line($x+410, $y-$rh+2, $x+410, $y+$rh+4);  
				$pdf->line($x+82, $y-$rh+2, $x+82, $y+$rh+2); 
				$pdf->line($x+43, $y-$rh+2, $x+43, $y+$rh+2); 
				#get space for next year
				$y=$y+$rh;

				if ($y>800){
					#put page header
					//include('PDFTranscriptPageHeader.inc');
					$pdf->addPage();  
		
						$x=50;
						$yadd=50;
		
						$y=80;
						$pg=$pg+1;
						$tpg =$pg;
						include 'includes/transcriptfooter.php';
					#title line
					$pdf->line(50, 135, 570, 135);
					#set page body content fonts
					$pdf->setFont('Arial', '', 9.5);    
				}
				#draw a line
				$pdf->line($x, $y+$rh+2, 570.28, $y+$rh+2);       
				$pdf->line($x, $y-$rh+2, $x, $y+$rh+2); 
				$pdf->line(570.28, $y-$rh+2, 570.28, $y+$rh+2);      
				$pdf->line($x+498, $y-$rh+2, $x+498, $y+$rh+2);       
				$pdf->line($x+468, $y-$rh+2, $x+468, $y+$rh+2);       
				$pdf->line($x+434, $y-$rh+2, $x+434, $y+$rh+2);      
				$pdf->line($x+410, $y-$rh+2, $x+410, $y+$rh+2); 
				$pdf->line($x+82, $y-$rh+2, $x+82, $y+$rh+2); 
				$pdf->line($x+43, $y-$rh+2, $x+43, $y+$rh+2);      
			  }//ends while loop
			  #check degree
			  if(($degree==632)||($degree==633)||($degree==635)){
				$pdf->setFont('Arial', 'BI', 9.5);     
				$pdf->text($x+84, $y+$rh+1, 'Sub-total');
				$pdf->text($x+413, $y+$rh+1, $unittaken); 
				$pdf->text($x+470, $y+$rh+1, $totalsgp); 
				$pdf->text($x+504, $y+$rh+1,@substr($totalsgp/$unittaken, 0,3)); 
				$pdf->setFont('Arial', '', 9.5); 
			  }#end check degree    
?>