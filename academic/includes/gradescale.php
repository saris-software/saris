<?php
		#compute marks range
		if ($award==1){
			$Arange='70-100%'; $Avalue='5'; $Agrade='A'; $Aremark='Excellent';
			$Bprange='60-69%'; $Bpvalue='4'; $Bpgrade='B+'; $Bpremark='Very Good';
			$Brange='50-59%'; $Bvalue='3'; $Bgrade='B'; $Bremark='Good';
			$Crange='40-49%'; $Cvalue='2'; $Cgrade='C'; $Cremark='Satisfactory';
			$Drange='35-39%'; $Dvalue='1'; $Dgrade='D'; $Dremark='Poor';
			$Erange='0-34%'; $Evalue='0'; $Egrade='F';  $Eremark='Failure';
		}elseif($award==2){
			$Arange='75-100%'; $Avalue='5'; $Agrade='A'; $Aremark='Excellent';
			$Bprange='65-74%'; $Bpvalue='4'; $Bpgrade='B+'; $Bpremark='Very Good';
			$Brange='55-64%'; $Bvalue='3'; $Bgrade='B'; $Bremark='Good';
			$Crange='45-54%'; $Cvalue='2'; $Cgrade='C'; $Cremark='Satisfactory';
			$Drange='35-44%'; $Dvalue='1'; $Dgrade='D'; $Dremark='Poor';
			$Erange='0-34%'; $Evalue='0'; $Egrade='F'; $Eremark='Failure';
		}elseif($award==3 || $award==4 ){
			$Arange='80-100%';$Avalue='4'; $Agrade='A'; $Aremark='Very Good';
			$Bprange='65-79%'; $Bpvalue='3';  $Bpgrade='B'; $Bpremark='Good';
			$Brange='50-64%'; $Bvalue='2'; $Bgrade='C'; $Bremark='Satisfactory';
			$Crange='40-49%'; $Cvalue='1'; $Cgrade='D'; $Cremark='Poor';
			$Drange='0-39%'; $Dvalue='0'; $Dgrade='F'; $Dremark='Failure';
			$Erange=''; $Evalue=''; $Egrade=''; $Eremark='';
		}
		#draw a line
		$pdf->line($x, $y, 570.28, $y);       
		$pdf->line($x, $y+56, 570.28, $y+56); 
		$pdf->line($x, $y, $x, $y+56); 
		$pdf->line(570.28, $y, 570.28, $y+56);
		#vertical lines
		$pdf->line($x+65, $y, $x+65, $y+56);  
		$pdf->line($x+145, $y, $x+145, $y+56); 
		$pdf->line($x+225, $y, $x+225, $y+56); 
		$pdf->line($x+305, $y, $x+305, $y+56); 
		$pdf->line($x+385, $y, $x+385, $y+56); 
		$pdf->line($x+455, $y, $x+455, $y+56); 
		
		#horizontal lines
		$pdf->line($x, $y+14, 570.28, $y+14); 
		$pdf->line($x, $y+28, 570.28, $y+28);  
		$pdf->line($x, $y+42, 570.28, $y+42); 
		#row 1 text
		$pdf->text($x+2, $y+12, 'Grade   '); 
		$pdf->text($x+105, $y+12, $Agrade);
		$pdf->text($x+175, $y+12, $Bpgrade);
		$pdf->text($x+250, $y+12, $Bgrade);
		$pdf->text($x+345, $y+12, $Cgrade);
		$pdf->text($x+410, $y+12, $Dgrade);
		$pdf->text($x+480, $y+12, $Egrade);
		#row 2 text
		$pdf->text($x+2, $y+24, 'Marks  '); 
		$pdf->text($x+95, $y+24,  $Arange   );
		$pdf->text($x+165, $y+24, $Bprange  );
		$pdf->text($x+255, $y+24, $Brange   );
		$pdf->text($x+335, $y+24, $Crange   );
		$pdf->text($x+400, $y+24, $Drange   );
		$pdf->text($x+470, $y+24, $Erange   );
		#row 3 text
		$pdf->text($x+2, $y+37, 'Grade Points  '); 
		$pdf->text($x+105, $y+37, $Avalue);
		$pdf->text($x+175, $y+37, $Bpvalue);
		$pdf->text($x+265, $y+37, $Bvalue);
		$pdf->text($x+345, $y+37, $Cvalue);
		$pdf->text($x+410, $y+37, $Dvalue);
		$pdf->text($x+480, $y+37, $Evalue);
		#row 4 text
		$pdf->text($x+2, $y+50, 'Remarks  '); 
		$pdf->text($x+95, $y+50, $Aremark);
		$pdf->text($x+165, $y+50, $Bpremark);
		$pdf->text($x+265, $y+50, $Bremark);
		$pdf->text($x+320, $y+50, $Cremark);
		$pdf->text($x+390, $y+50, $Dremark);
		$pdf->text($x+455, $y+50, $Eremark);
?>
