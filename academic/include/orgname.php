<?php
		#Get Organisation Name
		$qorg = "SELECT Name FROM organisation";
		$dborg = mysqli_query($zalongwa, $qorg);
		$row_org = mysqli_fetch_assoc($dborg);
		$org = $row_org['Name'];
		
		#print header
		if ($playout == 'l')
		{
			#tite for landscape
			$pdf->setFont('Arial', 'B', 22); 
			$x = 200;   
		}else
		{	
			#title for potriate
			$pdf->setFont('Arial', 'B', 17.7); 
			$x = 52;
		}
		$pdf->setFillColor('rgb', 0, 0, 0);   
		$pdf->text($x+90, $y, strtoupper($org));   
		$pdf->setFillColor('rgb', 0, 0, 0);   
?>
