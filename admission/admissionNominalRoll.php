<?php 
if (isset($_POST['printPDF']) && ($_POST['printPDF'] == "Print PDF")) {
	
	#get connected to the database
	require_once('../Connections/zalongwa.php');
	
	#get post values
	$programme = addslashes($_POST['programme']);
	$cohort = addslashes($_POST['cohort']);
	$ryear = addslashes($_POST['ayear']);
	$stream = addslashes($_POST['stream']);
	$status = addslashes($_POST['status']);
	$sponsor = addslashes($_POST['sponsor']);
	$checkbill = addslashes($_POST['checkbill']);
	

	#get programme name
	if($programme!=0){
		$qprogram = "SELECT ProgrammeName, Title FROM programme WHERE ProgrammeCODE ='$programme'";
		$dbprogram = mysqli_query($zalongwa, $qprogram);
		$row_program = mysqli_fetch_assoc($dbprogram);
		$pname = $row_program['ProgrammeName'];
		$ptitle = $row_program['Title'];
	}
	#create report title
	if($programme==0){
		$title = 'LIST OF ALL STUDENTS SELECTED IN '.$cohort.' ACADEMIC AUDIT YEAR';
	}else{
		$listitle = $ptitle;
	}
	#create grouplist tiltes
	if($stream !=0){
	$listitle = $ptitle.' -> '.$class;
	}

	if (($sponsor=='0') and ($stream=='0') and ($status=='0') and ($cohort!='0') and ($programme=='0') ){
		$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE (student.EntryYear='$cohort') 
						ORDER BY
						student.ProgrammeofStudy, 
						student.Class, 
						student.Name";
		}
	elseif (($sponsor=='0') and ($stream=='0') and ($status=='0') and ($cohort!='0') and ($programme!='0') ){
		$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE (student.EntryYear='$cohort') AND (student.ProgrammeofStudy='$programme') 
						ORDER BY
						student.ProgrammeofStudy, 
						student.Class, 
						student.Name";
		}
	elseif (($sponsor=='0') and ($stream=='0') and ($status!='0')  and ($cohort!='0') and ($programme!='0') ){
		$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE (student.EntryYear='$cohort') AND (student.ProgrammeofStudy='$programme') AND
							(student.Status='$status') 
						ORDER BY
						student.ProgrammeofStudy, 
						student.Class, 
						student.Name";
		}
	elseif (($sponsor!='0') and ($stream!='0') and ($status=='0')  and ($cohort!='0') and ($programme!='0') ){	
		$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE (student.EntryYear='$cohort') AND (student.ProgrammeofStudy='$programme') AND
							(student.Class='$stream')  AND (student.Sponsor='$sponsor') 
						ORDER BY
						student.ProgrammeofStudy, 
						student.Class, 
						student.Name";	
		}
	elseif (($sponsor=='0') and ($stream!='0') and ($status!='0')  and ($cohort!='0') and ($programme!='0') ){	
		$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE (student.EntryYear='$cohort') AND	(student.ProgrammeofStudy='$programme') AND
							(student.Class='$stream') AND (student.Status='$status') 
						ORDER BY
						student.ProgrammeofStudy, 
						student.Class, 
						student.Name";	
		}
	elseif (($sponsor!='0') and ($stream!='0') and ($status!='0') and ($cohort!='0') and ($programme!='0') ){	
		$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE (student.EntryYear='$cohort') AND (student.ProgrammeofStudy='$programme') AND
							(student.Class='$stream') AND (student.Status='$status') AND (student.Sponsor='$sponsor')
						ORDER BY
						student.ProgrammeofStudy, 
						student.Class, 
						student.Name";	
		}
	elseif (($sponsor=='0') and ($stream!='0') and ($status=='0')  and ($cohort!='0') and ($programme!='0') ){	
			$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE (student.EntryYear='$cohort') AND (student.ProgrammeofStudy='$programme') AND
							(student.Class='$stream')
						ORDER BY
						student.ProgrammeofStudy, 
						student.Class, 
						student.Name";	
	}elseif (($sponsor!='0') and ($stream=='0') and ($status!='0')  and ($cohort!='0') and ($programme!='0') ){	
			$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE 
						 (
							(student.EntryYear='$cohort') AND
							(student.ProgrammeofStudy='$programme') AND
							(student.Sponsor='$sponsor')AND
							(student.Status='$status')
						 )
									ORDER BY
									student.ProgrammeofStudy, 
									student.Class, 
									student.Name";	
	}elseif (($sponsor=='0') and ($stream=='0') and ($status!='0') and ($cohort!='0') and ($programme=='0') ){	
			$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE 
						 (
							(student.EntryYear='$cohort') AND
							(student.Status='$status')
						 )
									ORDER BY
									student.ProgrammeofStudy, 
									student.Class, 
									student.Name";	
	}elseif (($sponsor=='0') and ($stream!='0') and ($status=='0') and ($cohort!='0') and ($programme=='0') ){	
			$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE 
						 (
							(student.EntryYear='$cohort') AND
							(student.Class='$stream')
						 )
									ORDER BY
									student.ProgrammeofStudy, 
									student.Class, 
									student.Name";	
	}elseif (($sponsor!='0') and ($stream=='0') and ($status=='0') and ($cohort!='0') and ($programme=='0') ){	
			$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE 
						 (
							(student.EntryYear='$cohort') AND
							(student.Sponsor='$sponsor')
						 )
									ORDER BY
									student.ProgrammeofStudy, 
									student.Class, 
									student.Name";	
	}elseif (($sponsor!='0') and ($stream=='0') and ($status!='0') and ($cohort!='0') and ($programme=='0') ){	
			$sql = "SELECT student.Id,
					   student.Name,
					   student.RegNo,
					   student.Sex,
					   student.EntryYear,
					   student.Sponsor,
					   student.Status,
					   student.Class,
					   student.ProgrammeofStudy
		   
					FROM student
					WHERE 
						 (
							(student.EntryYear='$cohort') AND
							(student.Sponsor='$sponsor') AND
							(student.Status='$status')
						 )
									ORDER BY
									student.ProgrammeofStudy, 
									student.Class, 
									student.Name";	
	}
		
	$query_std = @mysqli_query($zalongwa, $sql);

	/* Printing Results in pdf */
		if (mysqli_num_rows($query_std) > 0)
		{
	
				$pdf = &PDF::factory('p', 'a4');      // Set up the pdf object. 
				$pdf->open();                         // Start the document. 
				$pdf->setCompression(true);           // Activate compression. 
				$pdf->addPage();  
				#put page header
			
				$x=50;
				$y=210;
				$i=1;
				$pg=1;
				//$i=1;
				#count unregistered
				$j=0;
				#count sex
            /** @var fmcount $fmcount */
            $$fmcount = 0;
            /** @var mcount $mcount */
            $$mcount = 0;
            /** @var fcount $fcount */
            $$fcount = 0;
				include '../includes/logoformat.php';
				#print header
				$pdf->image($logofile, 248, 50);   // Image at x=50 and y=200. 
				$pdf->setFont('Arial', 'I', 8);     // Set font to arial bold italic 12 pt. 
				$pdf->text(530.28, 825.89, 'Page '.$pg);   // Text at x=100 and y=100. 
				if($programme=='0'){
				$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"). ' - NOT REGISTERED STUDENTS ARE MARKED IN RED');   
				}else{
				$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   
				} 
				$pdf->setFont('Arial', 'B', 21.5);     // Set font to arial bold italic 12 pt. 
				$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
            /** @var org $org */
            $pdf->text(66, 50, strtoupper($org));   // Text at x=100 and y=100.
				$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to black. 
				
				#University Addresses
				$pdf->setFont('Arial', '', 11.3);     
				$pdf->text(95, 80, 'Phone: '.$phone);   
				$pdf->text(95, 99, 'Fax: '.$fax);  
				$pdf->text(95, 121, 'Email: '.$email);   
				$pdf->text(370, 80, strtoupper($post));   
				$pdf->text(370, 99, strtoupper($city));   
				$pdf->text(370, 121, $website);   
				
				$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
				$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
				$pdf->text(180, 158, $ryear.' - CLASS LIST REPORT'); // Text at x=100 and y=200.
				$pdf->text(137, 173, strtoupper($listitle)); // Text at x=100 and y=200.
				$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
				
				$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
				$pdf->setFont('Arial', 'B', 13);     // Set font to arial bold italic 12 pt. 
				$pdf->text(84, $y-20, $title); // Text at x=100 and y=200.
				$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
		
				$pdf->text($x, $y, 'S/N'); // Text at x=100 and y=200.
				$pdf->text($x+50, $y, 'Name'); // Text at x=100 and y=200.
				$pdf->text($x+250, $y, 'RegNo'); // Text at x=100 and y=200.
				$pdf->text($x+346, $y, 'Sex'); // Text at x=100 and y=200.
				$pdf->text($x+380, $y, 'Programme'); // Text at x=100 and y=200.
				$pdf->setFont('Arial', '', 9);     // Set font to arial bold italic 9 pt. 
				
				$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
				$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
				$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
				$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
				$pdf->line($x+231, $y-15, $x+231, $y+3);               // most left side margin. 
				$pdf->line($x+340, $y-15, $x+340, $y+3);               // most left side margin. 
				$pdf->line($x+370, $y-15, $x+370, $y+3);               // most left side margin. 
				$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
				$pdf->line($x, $y+19, 570.28, $y+19);       // bottom year summary line. 
				
				while($result = mysqli_fetch_array($query_std)) {
					$id = stripslashes($result["Id"]);
					$Name = stripslashes($result["Name"]);
					$RegNo = stripslashes($result["RegNo"]);
					$sex = stripslashes($result["Sex"]);
					$degreecode = stripslashes($result["ProgrammeofStudy"]);
					$faculty = stripslashes($result["Faculty"]);
					$sponsor = stripslashes($result["Sponsor"]);
					$class = stripslashes($result["Class"]);
					#initialise
					$entryyear = stripslashes($result['EntryYear']);
				    $ststatus = stripslashes($result['Status']);
					#compute year of study
                    /** @var cyear $cyear */
                    $current_yeartranc = substr($cyear,0,4);
					$entryyear = substr($entryyear,0,4);
					$yearofstudy=$current_yeartranc-$entryyear+1;
						
					#get study programe name
					$qprogram = "SELECT ProgrammeName FROM programme WHERE ProgrammeCODE ='$degreecode'";
					$dbprogram = mysqli_query($zalongwa, $qprogram);
					$row_program = mysqli_fetch_assoc($dbprogram);
					$degree = $row_program['ProgrammeName'];
					
					#get study status name
					$qstatus = "SELECT Status FROM studentstatus WHERE StatusID ='$ststatus'";
					$dbstatus = mysqli_query($zalongwa, $qstatus);
					$row_status = mysqli_fetch_assoc($dbstatus);
					$status = $row_status['Status'];
					
					/*
					#check if the candidate has registered to a course in this current year
					$qstatus = "SELECT DISTINCT RegNo FROM examresult WHERE RegNo='$RegNo' AND AYear='$ryear'";
					$dbstatus = mysql_query($qstatus);
					$statusvalue = mysql_num_rows($dbstatus);
					if($statusvalue>0){
					$status  = stripslashes($result["Status"]);
					}else{
					#check in examregister
						$qstatus = "SELECT DISTINCT RegNo FROM examregister WHERE RegNo='$RegNo' AND AYear='$ryear'";
						$dbstatus = mysql_query($qstatus);
						$statusvalue = mysql_num_rows($dbstatus);
						if($statusvalue>0){
							$status  = stripslashes($result["Status"]);
							}else{
							$status = 'Not Registered';
							$j=$j+1;
							}
					}
					*/
					#get line color
					$remainder = $i%2;
					if ($remainder==0){
						$linecolor = 1;
					}else{
					 $linecolor = 2;//'bgcolor="#FFFFFF"';
					}

                    /** @var display $display */
                    if($display==1){
						if($ststatus != 3){
						$pdf->setFillColor('rgb', 1, 0, 0); 
						}else{
						$pdf->setFillColor('rgb', 0, 0, 0);  
						}
						
						$pdf->text($x, $y+15, $i); 
						$pdf->text($x+40, $y+15, $Name); 
						$pdf->text($x+234, $y+15, $RegNo); 
						$pdf->text($x+346, $y+15, $sex); 
						$pdf->text($x+376, $y+15, substr($degree,0,26)); 
			            $pdf->setFillColor('rgb', 0, 0, 0);
						$i=$i+1;
						if ($sex=='F'){
							$fcount = $fcount +1;
						}elseif($sex=='M'){
							$mcount = $mcount +1;
						}else{
							$fmcount = $fmcount +1;
						}
						$x=$x;
						$y=$y+15;
						$pdf->line(50, $y-15, 50, $y);               
						$pdf->line($x, $y+3, 570.28, $y+3);     
						$pdf->line($x, $y-15, $x, $y+3);              
						$pdf->line($x+35, $y-15, $x+35, $y+3);               
						$pdf->line($x+231, $y-15, $x+231, $y+3);               
						$pdf->line($x+340, $y-15, $x+340, $y+3);                
						$pdf->line($x+370, $y-15, $x+370, $y+3);               
						$pdf->line(570.28, $y-15, 570.28, $y+3);      
					}elseif($display==2){
						if($ststatus == 3){
						$pdf->text($x, $y+15, $i); 
						$pdf->text($x+40, $y+15, $Name); 
						$pdf->text($x+234, $y+15, $RegNo); 
						$pdf->text($x+346, $y+15, $sex); 
						$pdf->text($x+376, $y+15, substr($degree,0,26)); 
						$i=$i+1;
						if ($sex=='F'){
							$fcount = $fcount +1;
						}elseif($sex=='M'){
							$mcount = $mcount +1;
						}else{
							$fmcount = $fmcount +1;
						}
						$x=$x;
						$y=$y+15;
						$pdf->line(50, $y-15, 50, $y);               
						$pdf->line($x, $y+3, 570.28, $y+3);     
						$pdf->line($x, $y-15, $x, $y+3);              
						$pdf->line($x+35, $y-15, $x+35, $y+3);               
						$pdf->line($x+231, $y-15, $x+231, $y+3);               
						$pdf->line($x+340, $y-15, $x+340, $y+3);                
						$pdf->line($x+370, $y-15, $x+370, $y+3);               
						$pdf->line(570.28, $y-15, 570.28, $y+3);      
					  }
					}else{
						if($ststatus != 3){
						$pdf->text($x, $y+15, $i); 
						$pdf->text($x+40, $y+15, $Name); 
						$pdf->text($x+234, $y+15, $RegNo); 
						$pdf->text($x+346, $y+15, $sex); 
						$pdf->text($x+376, $y+15, substr($degree,0,26)); 
						$i=$i+1;
						if ($sex=='F'){
							$fcount = $fcount +1;
						}elseif($sex=='M'){
							$mcount = $mcount +1;
						}else{
							$fmcount = $fmcount +1;
						}
						$x=$x;
						$y=$y+15;
						$pdf->line(50, $y-15, 50, $y);               
						$pdf->line($x, $y+3, 570.28, $y+3);     
						$pdf->line($x, $y-15, $x, $y+3);              
						$pdf->line($x+35, $y-15, $x+35, $y+3);               
						$pdf->line($x+231, $y-15, $x+231, $y+3);               
						$pdf->line($x+340, $y-15, $x+340, $y+3);                
						$pdf->line($x+370, $y-15, $x+370, $y+3);               
						$pdf->line(570.28, $y-15, 570.28, $y+3);      
					  }
					}

			
					if ($y>800){
						#put page header
						//include('PDFTranscriptPageHeader.inc');
						$pdf->addPage();  
						$x=50;
						$y=210;
						$pg=$pg+1;
				
						#print header
						$pdf->image('../images/logo.jpg', 248, 50);   // Image at x=50 and y=200. 
						$pdf->setFont('Arial', 'I', 8);     // Set font to arial bold italic 12 pt. 
						$pdf->text(530.28, 825.89, 'Page '.$pg);   // Text at x=100 and y=100. 
						if($programme=='0'){
						$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"). ' - Not Registered Students are Marked in Red');   
						}else{
						$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   
						} 
						$pdf->setFont('Arial', 'B', 21.5);     // Set font to arial bold italic 12 pt. 
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						$pdf->text(66, 50, strtoupper($org));   // Text at x=100 and y=100. 
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						
						#University Addresses
						$pdf->setFont('Arial', '', 11.3);     
						$pdf->text(95, 80, 'Phone: '.$phone);   
						$pdf->text(95, 99, 'Fax: '.$fax);  
						$pdf->text(95, 121, 'Email: '.$email);
                        /** @var address $address */
                        $pdf->text(370, 80, strtoupper($address));
						$pdf->text(370, 99, strtoupper($city));   
						$pdf->text(370, 121, $website);   
						
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
						$pdf->text(180, 158, $ryear.' - NOMINAL ROLL REPORT'); // Text at x=100 and y=200.
						$pdf->text(137, 173, strtoupper($listitle)); // Text at x=100 and y=200.
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
						$pdf->text(84, $y-20, $title); // Text at x=100 and y=200.
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
				
						$pdf->text($x, $y, 'S/N'); // Text at x=100 and y=200.
						$pdf->text($x+50, $y, 'Name'); // Text at x=100 and y=200.
						$pdf->text($x+250, $y, 'RegNo'); // Text at x=100 and y=200.
						$pdf->text($x+346, $y, 'Sex'); // Text at x=100 and y=200.
						$pdf->text($x+380, $y, 'Programme'); // Text at x=100 and y=200.
				        $pdf->setFont('Arial', '', 9);     // Set font to arial bold italic 9pt. 
						
						$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
						$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
						$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
						$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
						$pdf->line($x+231, $y-15, $x+231, $y+3);               // most left side margin. 
						$pdf->line($x+340, $y-15, $x+340, $y+3);               // most left side margin. 
						$pdf->line($x+370, $y-15, $x+370, $y+3);               // most left side margin. 
						$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
						$pdf->line($x, $y+19, 570.28, $y+19);       // bottom year summary line. 
					}
			 }//ends while loop
					if ($y>763){
						#put page header
						//include('PDFTranscriptPageHeader.inc');
						$pdf->addPage();  
						$x=50;
						$y=210;
						$pg=$pg+1;
				
						#print header
						$pdf->image('../images/logo.jpg', 248, 50);   // Image at x=50 and y=200. 
						$pdf->setFont('Arial', 'I', 8);     // Set font to arial bold italic 12 pt. 
						$pdf->text(530.28, 825.89, 'Page '.$pg);   // Text at x=100 and y=100. 
						if($programme=='0'){
						$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"). ' - Not Registered Students are Marked in Red');   
						}else{
						$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   
						} 
						$pdf->setFont('Arial', 'B', 21.5);     // Set font to arial bold italic 12 pt. 
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						$pdf->text(66, 50, strtoupper($org));   // Text at x=100 and y=100. 
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						
						#University Addresses
						$pdf->setFont('Arial', '', 11.3);     
						$pdf->text(95, 80, 'Phone: '.$phone);   
						$pdf->text(95, 99, 'Fax: '.$fax);  
						$pdf->text(95, 121, 'Email: '.$email);   
						$pdf->text(370, 80, strtoupper($address));   
						$pdf->text(370, 99, strtoupper($city));   
						$pdf->text(370, 121, $website);   
						
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
						$pdf->text(180, 158, $ryear.' - CLASS LIST REPORT'); // Text at x=100 and y=200.
						$pdf->text(137, 173, strtoupper($listitle)); // Text at x=100 and y=200.
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
						$pdf->text(84, $y-20, $title); // Text at x=100 and y=200.
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
				
						$pdf->text($x, $y, 'S/N'); // Text at x=100 and y=200.
						$pdf->text($x+50, $y, 'Name'); // Text at x=100 and y=200.
						$pdf->text($x+250, $y, 'RegNo'); // Text at x=100 and y=200.
						$pdf->text($x+346, $y, 'Sex'); // Text at x=100 and y=200.
						$pdf->text($x+380, $y, 'Programme'); // Text at x=100 and y=200.
				        $pdf->setFont('Arial', '', 11);     // Set font to arial bold italic 12 pt. 
						
						$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
						$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
						$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
						$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
						$pdf->line($x+235, $y-15, $x+235, $y+3);               // most left side margin. 
						$pdf->line($x+340, $y-15, $x+340, $y+3);               // most left side margin. 
						$pdf->line($x+370, $y-15, $x+370, $y+3);               // most left side margin. 
						$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
						$pdf->line($x, $y+19, 570.28, $y+19);       // bottom year summary line. 
					}
			$pdf->setFillColor('rgb', 0, 0, 0);
			$gt=$i-1;
			$pdf->text(50, $y+20, 'Grand Total: '.$gt);  

			if ($display==1){
			$pdf->setFillColor('rgb', 1, 0, 0);
			$pdf->text(50, $y+40, 'Total Unregistered Students  are: '.$j.'('.round($j/$gt*100,2).'%) - SEE THE RED LINES!');  
			$pdf->setFillColor('rgb', 0, 0, 0);
			}
			$pdf->text(50, $y+60, 'Total Female Students are: '.$fcount.'('.round($fcount/$gt*100,2).'%)');  
			$pdf->text(50, $y+80, 'Total Male Students are: '.$mcount.'('.round($mcount/$gt*100,2).'%)'); 
			if($fmcount<>0){
			$pdf->text(50, $y+100, 'Total Male/Female Unspecified Students are '.$fmcount.'('.round($fmcount/$gt*100,2).'%)'); 
			}

			//$pdf->text(200.28, 800.89, '.........................................................        ............................');   // Text at x=100 and y=100. 						
			//$pdf->text(200.28, 810.89, '          For Chief Academic Officer                    Date');   // Text at x=100 and y=100. 						
			$pdf->setFont('Arial', 'I', 8);     // Set font to arial bold italic 12 pt. 
			$pdf->output($ryear.'-classlist'.'.pdf');              // Output the 
		}else{
			echo "Sorry, No Records Found <br>";
	}
	exit;
	
} 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Class Lists';
	$szTitle = 'Class Lists';
	include('admissionheader.php');


mysqli_select_db($database_zalongwa, $zalongwa);
$query_AcademicYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AcademicYear = mysqli_query($zalongwa, $query_AcademicYear) or die(mysqli_error());
$row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
$totalRows_AcademicYear = mysqli_num_rows($AcademicYear);

mysqli_select_db($database_zalongwa, $zalongwa);
$query_Hostel = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$Hostel = mysqli_query($zalongwa, $query_Hostel) or die(mysqli_error());
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);

mysqli_select_db($database_zalongwa, $zalongwa);
$query_faculty = "SELECT FacultyID, FacultyName FROM faculty ORDER BY FacultyName ASC";
$faculty = mysqli_query($zalongwa, $query_faculty) or die(mysqli_error());
$row_faculty = mysqli_fetch_assoc($faculty);
$totalRows_faculty = mysqli_num_rows($faculty);

if (isset($_POST['print']) && ($_POST['print'] == "PreView")) {
	#get post values
	$programme = addslashes($_POST['programme']);
	$cohort = addslashes($_POST['cohort']);
	$ryear = addslashes($_POST['ayear']);
	$stream = addslashes($_POST['stream']);
	$status = addslashes($_POST['status']);
	$sponsor = addslashes($_POST['sponsor']);
	$checkbill = addslashes($_POST['checkbill']);
	
	#get programme name
	$qprogram = "SELECT ProgrammeName FROM programme WHERE ProgrammeCODE ='$programme'";
	$dbprogram = mysqli_query($zalongwa, $qprogram);
	$row_program = mysqli_fetch_assoc($dbprogram);
	$pname = $row_program['ProgrammeName'];
	
	#create report title
	if($programme==0){
		$title = 'LIST OF ALL STUDENTS SELECTED IN '.$cohort.' ACADEMIC AUDIT YEAR';
	}else{
		$listitle = $pname;
	}
	#create grouplist tiltes
	if($stream !=0){
	$listitle = $pname.' -> '.$class;
	}
		
		include 'includes/filter_students.php';

	/* Printing Results in html */
	if (mysqli_num_rows($query_std) > 0){
		$degree = $pname;
		?>
		
		<table width="100%"  border="0">
          <tr>
            <td></td>
          </tr>
          <tr>
            <td><div align="center" class="style4">
                    <h1><?php /** @var org $org */
                  echo $org?></h1>
            </div></td>
          </tr>
          <tr>
            <td><div align="center">
              <h4>Cohort <?php echo $cohort?> Nominal Roll</h4>
            </div></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="center">
              <h4>A <?php echo $ryear?> Status Report</h4>
            </div></td>
          </tr>
		  <?php if ($programme!= '0'){?>
          <tr>
            <td><div align="center">
              <h4><span class="style4"> <?php echo $listitle ?></span></h4>
            </div></td>
          </tr>
		   <?php } ?>
        </table>
        
		<table border='1' cellpadding='0' cellspacing='0'>
		<tr bgcolor="#CCCCCC"><td> S/No </td><td> Name </td>
		<td> RegNo </td>
		<td> Sex </td>
		<td> Degree </td>
		<td> Stream Session </td>
		<td> Sponsor </td>
		 <?php 
		 if($checkbill=='on') {
			echo "<td> Balance </td><td>invoice</td>";
			} 
		?>
		<td> Status </td>
		</tr>
		<?php
		$i=1;
		#count unregistered
		$j=0;
		#count sex
		$fmcount = 0;
		$mcount = 0;
		$fcount = 0;
		include("../includes/pastel.class.php");
		$odbcfile = 'http://172.31.0.94:8090/saris/odbc.php';
		$pastelurl = $odbcfile;
		$pastelobj = new pastel();

		while($result = mysqli_fetch_array($query_std)) {
				$id = stripslashes($result["Id"]);
				$Name = stripslashes($result["Name"]);
				$RegNo = stripslashes($result["RegNo"]);
				$sex = stripslashes($result["Sex"]);
				$degreecode = stripslashes($result["ProgrammeofStudy"]);
				$faculty = stripslashes($result["Faculty"]);
				$sponsor = stripslashes($result["Sponsor"]);
				$class = stripslashes($result["Class"]);
				#initialise
				$entryyear = stripslashes($result['EntryYear']);
			    $ststatus = stripslashes($result['Status']);
				#compute year of study
            /** @var cyear $cyear */
            $current_yeartranc = substr($cyear,0,4);
				$entryyear = substr($entryyear,0,4);
				$yearofstudy=$current_yeartranc-$entryyear+1;
				
				$regno = trim(strtoupper($RegNo));
				if($checkbill=='on') {
					//get student balance					
					$view_type = 1;
					$balance = $pastelobj->currentPayment($pastelurl, $regno, $view_type);
                                        $balance = explode('-', $balance);					
					}
				
				//get student payment balance status
				$view_type = 3;
				$inst = $pastelobj->resultCode($pastelurl, $regno, $view_type);
				
				//update admission status
				$acc_id = ($inst==md5(0))? 3: (($inst==md5(1))? 2:8);
				
				//an array for unchangeable statuses
				$registration_status = array(1, 4, 5, 6, 7);
				
				//update registration status
				if(!in_array($ststatus,$registration_status,true)){
					mysqli_query("UPDATE student SET Status='$acc_id' WHERE RegNo='$regno'");
					$ststatus = $acc_id;
					}
					
				#get study programe name
				$qprogram = "SELECT ProgrammeName FROM programme WHERE ProgrammeCODE ='$degreecode'";
				$dbprogram = mysqli_query($zalongwa, $qprogram);
				$row_program = mysqli_fetch_assoc($dbprogram);
				$degree = $row_program['ProgrammeName'];
				
				#get study status name
				$qstatus = "SELECT Status FROM studentstatus WHERE StatusID ='$ststatus'";
				$dbstatus = mysqli_query($zalongwa, $qstatus);
				$row_status = mysqli_fetch_assoc($dbstatus);
				$status = $row_status['Status'];
				
				
				#get line color
				$remainder = $i%2;
				if ($remainder==0){
					$linecolor = 'bgcolor="#FFFFCC"';
				}else{
				 $linecolor = 'bgcolor="#FFFFFF"';
				}
				$style = ($ststatus != 3)?'<span class="style1">':'';
				echo "<tr>
						<td $linecolor><a href=\"admissionRegistrationForm.php?id=$id&RegNo=$RegNo\">$i</a></td>
						<td $linecolor nowrap>$style $Name</td>
						<td $linecolor nowrap>$style $RegNo</td>
						<td $linecolor nowrap>$style $sex</td>
						<td $linecolor nowrap>$style $degree</td>
						<td $linecolor nowrap>$style $class</td>
						<td $linecolor nowrap>$style $sponsor</td>";
					
				if($checkbill=='on'){
					echo "<td $linecolor nowrap>".$balance[0]."</td>";
                                        echo "<td $linecolor nowrap>".$balance[1]."</td>";

					} 
				echo "<td $linecolor nowrap>$status</td></tr>";
					
				$i=$i+1;
				if ($sex=='F'){
					$fcount = $fcount +1;
					}
				elseif($sex=='M'){
					$mcount = $mcount +1;
					}
				else{
					$fmcount = $fmcount +1;
					}
				}
				#end while loop

			$rows = ($checkbill=='on')? "colspan='9'":"colspan='8'";
			echo "<tr bgcolor='#CCCCCC'>
					<td $rows nowrap>Total</td></tr>
				  </table>";
			
			#print statistics
			$gt=$i-1;
			echo 'Grand Total: '.$gt;
			echo '<hr>';
        /** @var display $display */
        if ($display==1){
				echo 'Total Unregistered Students  are: '.$j.'('.round($j/$gt*100,2).'%)';
			}
				echo '<hr> Total Female Students are: '.$fcount.'('.round($fcount/$gt*100,2).'%)';
				echo '<hr> Total Male Students are: '.$mcount.'('.round($mcount/$gt*100,2).'%)';
			if($fmcount<>0){
				echo '<hr> Total Male/Female Unspecified Students are '.$fmcount.'('.round($fmcount/$gt*100,2).'%)';
			}
			}else{
					echo "Sorry, No Records Found <br>";
				}
}else{

?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentclasslist" id="studentclasslist">
            <table width="300" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
          <td colspan="2" nowrap><div align="center">PRINTING STUDENTS CLASS LISTS </div></td>
          </tr>
		  <tr>
			  <td rowspan="1" nowrap><div align="right">Programme:</div></td>
			  <td colspan="1" bgcolor="#CCCCCC"><select name="programme" id="programme">
				   <option value="0">--------------------------------</option>
			            <?php
						do {  
						?>
						            <option value="<?php echo $row_Hostel['ProgrammeCode']?>"><?php echo $row_Hostel['ProgrammeName']?></option>
						            <?php
						} while ($row_Hostel = mysqli_fetch_assoc($Hostel));
						  $rows = mysqli_num_rows($Hostel);
						  if($rows > 0) {
						      mysqli_data_seek($Hostel, 0);
							  $row_Hostel = mysqli_fetch_assoc($Hostel);
						  }
						?>
          			</select></td>
		  </tr>
  		  <tr>
			  <td rowspan="1" nowrap><div align="right">Group Cohort:</div></td>
					<td colspan="1" bgcolor="#CCCCCC"><select name="cohort" id="cohort">
					  <option value="0">--------------------------------</option>
			            <?php
					do {  
					?>
			            <option value="<?php echo $row_AcademicYear['AYear']?>"><?php echo $row_AcademicYear['AYear']?></option>
			            <?php
					} while ($row_AcademicYear = mysqli_fetch_assoc($AcademicYear));
					  $rows = mysqli_num_rows($AcademicYear);
					  if($rows > 0) {
					      mysqli_data_seek($AcademicYear, 0);
						  $row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
					  }
					?>
				   </select></td>
		   </tr>     
   		  <tr>
			  <td rowspan="1" nowrap><div align="right">Audit Year:</div></td>
				<td colspan="1" bgcolor="#CCCCCC"><select name="ayear" id="ayear">
					 <option value="0">--------------------------------</option>
			            <?php
				do {  
				?>
		            <option value="<?php echo $row_AcademicYear['AYear']?>"><?php echo $row_AcademicYear['AYear']?></option>
		            <?php
				} while ($row_AcademicYear = mysqli_fetch_assoc($AcademicYear));
				  $rows = mysqli_num_rows($AcademicYear);
				  if($rows > 0) {
				      mysqli_data_seek($AcademicYear, 0);
					  $row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
				  }
				?>
        	  </select></td>
		   </tr>
 		   <tr>
          <td nowrap><div align="right">Class Stream:</div></td>
          	<td colspan="1" bgcolor="#CCCCCC"><select name="stream" id="stream">
		       <option value="0">--------------------------------</option>
				<?php
					$query_class = "SELECT name FROM classstream ORDER BY name ASC";
					$nm=mysqli_query($zalongwa, $query_class);
					while($show = mysqli_fetch_array($nm) )
					{  										 
					 echo"<option  value='$show[name]'>$show[name]</option>";      	    
					}
					?>
	      </select></td>
	     </tr>
	     <tr>
           <td nowrap><div align="right">Reg. Status:</div></td>
          	<td colspan="1" bgcolor="#CCCCCC"><select name="status" id="status">
		       <option value="0">--------------------------------</option>
			      <?php  
					$query_studentStatus = "SELECT StatusID,Status FROM studentstatus ORDER BY StatusID";
					$nm=mysqli_query($zalongwa, $query_studentStatus);
					while($show = mysqli_fetch_array($nm) )
					{  										 
						echo"<option  value='$show[StatusID]'>$show[Status]</option>";      
					      
					}
				 ?>
	      </select></td>
	     </tr>
  		 <tr>
          <td nowrap><div align="right">  Sponsorship:</div></td>
            <td colspan="1" bgcolor="#CCCCCC"><select name="sponsor" id="sponsor">
             <option value="0">--------------------------------</option>
		       <?php
               /** @var sponsor $sponsor */
               if($sponsor)
				{
					echo"<option value='$sponsor'>$sponsor</option>";
				}  
				$query_sponsor = "SELECT Name FROM sponsors ORDER BY SponsorID ASC";
				$nm=mysqli_query($zalongwa, $query_sponsor);
				while($show = mysqli_fetch_array($nm) )
				{  										 
				   echo"<option  value='$show[Name]'>$show[Name]</option>";      	    
				}
				?>
     		</select></td>
     	  </tr>
          <tr>
		    <td nowrap><div align="right">  Show Billing:</div></td> 
		    <td colspan="1" bgcolor="#CCCCCC">
		    <input name="checkbill" type="checkbox" id="checkbill" value="on" >Yes
		    </td>
         </tr>
        <tr>
         <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">
		    <div align="center">
		      <input name="print" type="submit" id="print" value="PreView">
              <input name="printPDF" type="submit" id="printPDF" value="Print PDF">
            </div></td>
	        </tr>
	      </table>
        </form>
<?php
}
mysqli_free_result($AcademicYear);

mysqli_free_result($Hostel);
include('../footer/footer.php');
?>
