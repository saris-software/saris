<?php
#five template
	#fit the image
	$pdf->image('./images/muchslogo.jpg', 260, 60);   
	
	#signatory
	$signatory = 'Deputy Vice Chancellor Academics, Research and Consultancy                      Date';

	$pdf->setFont('Arial', 'I', 8);     
	$pdf->text(530.28, 820.89, 'Page '.$pg);   
	$pdf->setFont('Arial', 'B', 17.7); 
	$pdf->text(52, 50, 'MUHIMBILI UNIVERSITY OF HEALTH AND ALLIED SCIENCES');   
	$pdf->setFillColor('rgb', 0, 0, 0);  
	$pdf->setFont('Arial', 'I', 8);    
	$pdf->text(50, 820.89, 'Dar-es-Salaam, '.$today = date("d-m-Y H:i:s"));   
	$pdf->text(300, 820.89, $copycount);  
 
	$yadd=85;
	#University Addresses
	$phone = '+255-22-2150473';
	$fax = '+255-22-2150465';
	$email = 'registrar@muchs.ac.tz';
	$post = 'P.O. Box 65001';
	$website = 'http://www.muhas.ac.tz';
	$city = 'DAR-ES-SALAAM';
	
	$pdf->setFont('Arial', '', 11.3);     
	$pdf->text(115, $yadd, 'Phone: '.$phone);
	$pdf->text(115, $yadd+12, 'Fax: '.$fax);    
	$pdf->text(115, $yadd+24, 'Email: '.$email);
	$pdf->text(350, $yadd, strtoupper($post));    
	$pdf->text(350, $yadd+12, strtoupper($city)); 
	$pdf->text(350, $yadd+24, $website);  
	
	#candidate photo box
	$pdf->line(490, 65, 490, 145);       // leftside. 
	$pdf->line(490, 65, 570, 65);        // upperside. 
	$pdf->line(570, 65, 570, 145);       // rightside. 
	$pdf->line(490, 145, 570, 145);       // bottom side. 
	if ($nophoto == 1){
		$pdf->text(450, 85, 'Invalid Without Photo: ');    
	}else{
		$pdf->image($imgfile, 490, 55);  
	}
	
?>