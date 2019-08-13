<?php
	$pdf->text($x+1, $y+15, $n); 
	$stname = explode(',',$Name);
	$pdf->text($x+36, $y+15, strtoupper(stripslashes($stname[0])).', '.ucwords(strtolower(stripslashes($stname[1])))); 
	$pdf->text($x+169, $y+15, $RegNo); 
	$pdf->text($x+241, $y+15, $sex); 
	
	if ($ovremark=='SUPP:'){
		$ovremark='SUPP';
		$pdf->text($x+260, $y+15, $ovremark); 
	}else{
		$pdf->text($x+260, $y+15, $ovremark); 
	}
	$pdf->text($x+310, $y+15, number_format($invoice,2,'.',',')); 
	$pdf->text($x+379, $y+15, number_format($paid,2,'.',','));
	$pdf->text($x+460, $y+15, number_format($due,2,'.',','));  
	$n++;
	if ($sex=='F'){
		$fcount = $fcount +1;
	}elseif($sex=='M'){
		$mcount = $mcount +1;
	}else{
		$fmcount = $fmcount +1;
	}
	$x=$x;
	$y=$y+15;
	$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
	$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
	$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
	$pdf->line($x+168, $y-15, $x+168, $y+3);              // most left side margin. 
	$pdf->line($x+236, $y-15, $x+236, $y+3);              // most left side margin. 
	$pdf->line($x+258, $y-15, $x+258, $y+3); 
	$pdf->line($x+306, $y-15, $x+306, $y+3);  
	$pdf->line($x+374, $y-15, $x+374, $y+3); 
	$pdf->line($x+458, $y-15, $x+458, $y+3);             // most left side margin. 
	$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
?>	