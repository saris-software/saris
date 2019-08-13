<?php
		# results summary table 
		$y=$b;
		#draw a line
		$pdf->line($x, $y, 570.28, $y);       
		$pdf->line($x, $y+56, 570.28, $y+56); 
		$pdf->line($x, $y, $x, $y+56); 
		$pdf->line(570.28, $y, 570.28, $y+56);
		#vertical lines
		$pdf->line($x+65, $y, $x+65, $y+56); 	$pdf->line($x+93, $y+14, $x+93, $y+42);  
		$pdf->line($x+121, $y, $x+121, $y+56); 	$pdf->line($x+149, $y+14, $x+149, $y+42);  
		$pdf->line($x+177, $y, $x+177, $y+56); 	$pdf->line($x+205, $y+14, $x+205, $y+42);
		$pdf->line($x+233, $y, $x+233, $y+56); 	$pdf->line($x+261, $y+14, $x+261, $y+42);
		$pdf->line($x+289, $y, $x+289, $y+56); 	$pdf->line($x+317, $y+14, $x+317, $y+42);
		$pdf->line($x+345, $y, $x+345, $y+56); 	$pdf->line($x+373, $y+14, $x+373, $y+42);
		$pdf->line($x+401, $y, $x+401, $y+56); 	$pdf->line($x+429, $y+14, $x+429, $y+42);
		$pdf->line($x+457, $y, $x+457, $y+56); 	$pdf->line($x+490, $y+14, $x+490, $y+42);
		#horizontal lines
		$pdf->line($x, $y+14, 570.28, $y+14); 
		$pdf->line($x, $y+28, 570.28, $y+28);  
		$pdf->line($x, $y+42, 570.28, $y+42); 
		#row 1 text
		$pdf->text($x+2, $y+12, 'Grade   '); 
		$pdf->text($x+93, $y+12, '  A   ');
		$pdf->text($x+149, $y+12, '  B+  ');
		$pdf->text($x+205, $y+12, '  B   ');
		$pdf->text($x+261, $y+12, '  C   ');
		$pdf->text($x+317, $y+12, '  D   ');
		#check whether to print E or F
		if(strtoupper($level)=='TRADITIONAL SYSTEM'){
			$pdf->text($x+373, $y+12, '  E   ');
		}else{
			$pdf->text($x+373, $y+12, '  F  ');
		}
		$pdf->text($x+404, $y+12, '  I  (ABSC) ');
		$pdf->text($x+469, $y+12, '  TOTAL ');

		#row 2 text
		$pdf->text($x+2, $y+24, 'Gender  '); 
		$pdf->text($x+75, $y+24, 'M        F');
		$pdf->text($x+131, $y+24, 'M        F');
		$pdf->text($x+187, $y+24, 'M        F');
		$pdf->text($x+243, $y+24, 'M        F');
		$pdf->text($x+299, $y+24, 'M        F');
		$pdf->text($x+355, $y+24, 'M        F');
		$pdf->text($x+411, $y+24, 'M        F');
		$pdf->text($x+467, $y+24, 'M        F');
		#row 3 text
		$pdf->text($x+2, $y+37, 'Subtotal  '); 
		$pdf->text($x+71, $y+37, $countgradeAm.'       '.$countgradeAf);
		$pdf->text($x+127, $y+37, $countgradeBplusm.'        '.$countgradeBplusf);
		$pdf->text($x+183, $y+37, $countgradeBm.'        '.$countgradeBf);
		$pdf->text($x+239, $y+37, $countgradeCm.'        '.$countgradeCf);
		$pdf->text($x+295, $y+37, $countgradeDm.'        '.$countgradeDf);
		if(strtoupper($level)=='TRADITIONAL SYSTEM'){
			$pdf->text($x+351, $y+37, $countgradeEm.'        '.$countgradeEf);
		}else{
			$pdf->text($x+351, $y+37, $countgradeFm.'        '.$countgradeFf);
		}
		$pdf->text($x+408, $y+37, $countgradeIm.'        '.$countgradeIf);
		$pdf->text($x+464, $y+37, $countgradeAm+$countgradeBplusm+$countgradeBm+$countgradeCm+$countgradeDm+$countgradeEm+$countgradeFm+$countgradeIm);
		$pdf->text($x+494, $y+37, $countgradeAf+$countgradeBplusf+$countgradeBf+$countgradeCf+$countgradeDf+$countgradeEf+$countgradeFf+$countgradeIf);
		#check examregulations for this course
		
		#get coursename
		$qcourse = "Select StudyLevel from course where CourseCode = '$coursecode'";
		$dbcourse = mysql_query($qcourse);
		$row_course = mysql_fetch_array($dbcourse);
		$studylevel = $row_course['StudyLevel'];

		$pdf->text($x+2, $y+53, 'Grandtotal  '); 
		$pdf->text($x+67, $y+53, $countgradeA.'('.number_format($countgradeA*100/$sn,1).'%)');
		$pdf->text($x+123, $y+53, $countgradeBplus.'('.number_format($countgradeBplus*100/$sn,1).'%)');
		$pdf->text($x+179, $y+53, $countgradeB.'('.number_format($countgradeB*100/$sn,1).'%)');
		$pdf->text($x+235, $y+53, $countgradeC.'('.number_format($countgradeC*100/$sn,1).'%)');
		$pdf->text($x+291, $y+53, $countgradeD.'('.number_format($countgradeD*100/$sn,1).'%)');
		if(strtoupper($level)=='TRADITIONAL SYSTEM'){
			$pdf->text($x+347, $y+53, $countgradeE.'('.number_format($countgradeE*100/$sn,1).'%)');
		}else{
			$pdf->text($x+347, $y+53, $countgradeF.'('.number_format($countgradeF*100/$sn,1).'%)');
		}
		$pdf->text($x+403, $y+53, $countgradeI.'('.number_format($countgradeI*100/$sn,1).'%)');
		$pdf->text($x+475, $y+53, number_format(($countgradeA+$countgradeBplus+$countgradeB+$countgradeC+$countgradeD+$countgradeE+$countgradeF+$countgradeI),0));
		#reset the value of y
		$y=$y+56;
		$pdf->text(190.28, $y+15, '          ######## END OF EXAM RESULTS ########');  
		#print signature lines
		$pdf->text(120.28, $y+35, '.............................................................                                   ............................');    						
		$pdf->text(130.28, $y+45, '							Course Lecturer\'s Name                                                       Signature');   	
		$pdf->text(120.28, $y+60, '.............................................................                                   ............................');    						
		$pdf->text(130.28, $y+75, '	Date Approved by the Head of the Department                          Signature');   	
		//$pdf->text(120.28, $y+90, '.............................................................                                   ............................');    						
		//$pdf->text(130.28, $y+105, 'Date Approved by the Dean of the Faculty                                  Signature');   	

?>