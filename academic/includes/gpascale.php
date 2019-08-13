<?php
		#draw a line
		$pdf->line($x, $y, 570.28, $y);       
		$pdf->line($x, $y+84, 570.28, $y+84); 
		$pdf->line($x, $y, $x, $y+84); 
		$pdf->line(570.28, $y, 570.28, $y+84);
		#vertical lines (the big partitions)
		$pdf->line($x+170, $y, $x+170, $y+84);  
		$pdf->line($x+337, $y, $x+337, $y+84); 
		#horizontal lines
		$pdf->line($x, $y+14, 570.28, $y+14); 
		$pdf->line($x, $y+28, 570.28, $y+28);  
		$pdf->line($x, $y+42, 570.28, $y+42); 
		$pdf->line($x, $y+56, 570.28, $y+56); 
		$pdf->line($x, $y+70, 570.28, $y+70); 
		#vertical lines (the big partitions)
		$pdf->line($x+90, $y+14, $x+90, $y+84);  
		$pdf->line($x+253.5, $y+14, $x+253.5, $y+84); 
		$pdf->line($x+433.5, $y+14, $x+433.5, $y+84); 
		
		#row 1 text
		$pdf->text($x+55, $y+12, 'NTAL LEVEL 7 - 8  '); 
		$pdf->text($x+223.5, $y+12, '  NTA LEVEl 6  ');
		$pdf->text($x+403.5, $y+12, '  NTA LEVEL 5  ');
		#row 2 text
		$pdf->text($x+17, $y+24,  '  Overall G.P.A.   '); 
		$pdf->text($x+110, $y+24, '  Class            ');
		$pdf->text($x+180, $y+24, '  Overall G.P.A.   ');
		$pdf->text($x+280, $y+24, '  Class            ');
		$pdf->text($x+350, $y+24, '  Overall G.P.A.   ');
		$pdf->text($x+460, $y+24, '  Class            ');
		
		#row 3 text
		$pdf->text($x+27, $y+36,  '  4.4-5.0   '); 
		$pdf->text($x+102, $y+36, '  FIRST CLASS    ');
		$pdf->text($x+190, $y+36, '  4.4-5.0   ');
		$pdf->text($x+266, $y+36, '  FIRST CLASS    ');
		$pdf->text($x+360, $y+36, '  3.5-4.0   ');
		$pdf->text($x+446, $y+36, '  FIRST CLASS    ');
		#row 4 text
		$pdf->text($x+27, $y+50,  '  3.5-4.3   '); 
		$pdf->text($x+90, $y+50, '  UPPER SECOND     ');
		$pdf->text($x+190, $y+50, '  3.5-4.3   ');
		$pdf->text($x+250, $y+50, '  UPPER SECOND    ');
		$pdf->text($x+360, $y+50, '  3.0-3.4   ');
		$pdf->text($x+430, $y+50, '  SECOND CLASS    ');
		#row 5 text
		$pdf->text($x+27, $y+64,  '  2.7-3.4   '); 
		$pdf->text($x+85, $y+64, '   LOWER SECOND    ');
		$pdf->text($x+190, $y+64, '  2.7-3.4     ');
		$pdf->text($x+250, $y+64, '  LOWER SECOND    ');
		$pdf->text($x+360, $y+64, '  2.0-2.9   ');
		$pdf->text($x+440, $y+64, '  PASS     ');
		#row 6 text
		$pdf->text($x+27, $y+78,  '  2.0-2.6   '); 
		$pdf->text($x+90, $y+78, '    PASS     ');
		$pdf->text($x+190, $y+78, '  2.0-2.6 ');
		$pdf->text($x+280, $y+78, '   PASS  ');
		$pdf->text($x+350, $y+78, '     ');
		$pdf->text($x+460, $y+78, '       ');
?>
