<?php
	$x=50;
	$y=154;
	
	#print header
	$pdf->image('images/logo.jpg', 50, 50);   // Image at x=50 and y=200. 
	$pdf->setFont('Arial', 'BI', 12);     // Set font to arial bold italic 12 pt. 
	$pdf->text(80, 800.89, 'Page '.$pg);   // Text at x=100 and y=100. 
	$pdf->text(220, 50, 'UNIVERSITY OF DAR ES SALAAM');   // Text at x=100 and y=100. 
	$pdf->setFontSize(10.3);                // Set font size to 20 pt. 

	$pdf->text(118, 130, $regno.':'); // Text at x=100 and y=200.
	$pdf->text(210, 130, $name); // name at x=50 and y=50. 
	$pdf->text(118, 142, $programme); // Text at x=100 and y=200. 
	
	#draw a line
	$pdf->line($x, 145, 570.28, 145);       // table top margin. 
	$pdf->line($x, $y+3, 570.28, $y+3);       // table header margin. 
	$yval=$y+3;
	
?>
	
	/*
	#sql
	$sql='select * from course';
	$dbcourse=mysql_query($sql);
	$xp=170;
	$yp=200;
	$st=18;
	while ($rowcourse=mysql_fetch_assoc($dbcourse)){
		$pdf->setFont('Arial', 'BI', 12);      // Set font to arial 8 pt. 
		$pdf->setFontSize(10);                // Set font size to 20 pt. 
		$pdf->text(50, $xp, $rowcourse['CourseCode'].':'); // Text at x=100 and y=200. 
		$pdf->text(88, $xp, $rowcourse['CourseName']); // Text at x=100 and y=200. 
		$pdf->text(470, $xp, $rowcourse['CourseCode']); // Text at x=100 and y=200. 
		$xp=$xp+12;
		$i=$i+1;
		if ($i==10){
			$pdf->addPage();                      // Add a new page. 
			$pdf->setFont('Arial', 'BI', 12);     // Set font to arial bold italic 12 pt. 
			$pdf->text(80, 800.89, 'Page '.$pg=$pg+1);   // Text at x=100 and y=100. 
			$pdf->image('images/logo.jpg', 50, 50);   // Image at x=50 and y=200. 
			$pdf->text(220, 50, 'UNIVERSITY OF DAR ES SALAAM');   // Text at x=100 and y=100. 
			$i=0;
			$xp=170;
		}
	}*/
