<?php

/*
 * This file processes all the Semester Reports
 * Using TCPDF Class for PHP
 * 
 * Programmed By: Charles John Bundu <rwige1@gmail.com>
 * Monday November 10, 2014
 * Last Edited By: Charles Bundu
 * 
 */
 
//============================================================+
// 
// Description : For TCPDF class, Custom Header and Footer
//               
//
// Author:  Zalongwa Technologies
//
// (c) Copyright:
//               Zalongwa Technologies Limited
//               DAR-ES-SALAAM
//               TANZANIA
//               EAST AFRICA
//				 support@zalongwa.com
//============================================================+

	require_once('../tcpdf/config/lang/eng.php');
	require_once('../tcpdf/tcpdf.php');
	
	
	/****************************************
	 * UNDERGRADUATE SEMESTER REPORT FUNCTION
	 ****************************************/
	function undergraduateReport($progname,$class,$faculty,$deg,$cohot,$year,$sem,$coursearray){
		//determine total number of columns
		$qstd = "SELECT RegNo FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
		$dbstd = mysql_query($qstd);
		
		//get institution details
		$qorg = "SELECT * FROM organisation";
		$dborg = mysql_query($qorg);
		$row_org = mysql_fetch_assoc($dborg);
		$org = strtoupper($row_org['Name']);
		$post = strtoupper($row_org['Address']);
		$phone = $row_org['tel'];
		$fax = $row_org['fax'];
		$email = $row_org['email'];
		$website = strtolower($row_org['website']);
		$city = strtoupper($row_org['city']);
		
		$rptitle = strtoupper($progname);
		
		$reportHeader = $org;
		$reportsubHeader = "Printed ".date('Y-m-d');
		
		
		// Extend the TCPDF class to create custom Header and Footer
		class MYPDF extends TCPDF {
			
			//Page header
			public function Header() {
				// get the current page break margin
				$bMargin = $this->getBreakMargin();
				// get current auto-page-break mode
				$auto_page_break = $this->AutoPageBreak;
				// disable auto-page-break
				$this->SetAutoPageBreak(false, 0);
				// restore auto-page-break status
				$this->SetAutoPageBreak($auto_page_break, $bMargin);
				// set the starting point for the page content
				$this->setPageMark();
			}

			// Page footer
			public function Footer() {
				// Position at 15 mm from bottom
				$this->SetY(-15);
				
				// Set font
				$this->SetFont('helvetica', 'I', 8);
				
				// Page number
				$printDate = " Printed: ".date('Y-m-d H:m:s');
				
				$this->Cell(0, 3, $printDate, 0, false, 'L', 0, '', 0, false, 'T', 'M');
				$this->Cell(0, 3, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');				
			}
		}


		// create new PDF document
		$custom_layout='';
		$totalcolms = count($coursearray);
		if(count($coursearray)>5){
			if(count($coursearray)==6){
				$custom_layout = array(395, 400);
				}
			else{
				$custom_layout = array(435, 440);
				}
			}
		else{
			$custom_layout = array(345, 350);
			}
		
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Zalongwa Technologies Ltd');
		$pdf->SetTitle($reportHeader);
		$pdf->SetSubject($reportsubHeader);
		$pdf->SetKeywords('Transcript of Results');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->setPrintHeader(false);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		
		
		// set font
		$pdf->SetFont('dejavusans', '', 8);

		// add a page
		$pdf->AddPage();
		
		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();
		
		// ---------------------------------------------------------
		global $TITLE;
		
		//report header
		$TITLE = <<<EOD
				<table border="0" cellpadding="0" cellspacing="0" style="font-weight:bold">
					<tr>
						<td width="300"><font size="+4">NACTE FORM EXAM 03</font></td>
						<td width="900"><font size="+16.8">$org</font></td>
					</tr>
					<tr>
						<td align="center" colspan="2"><font size="+8">$faculty</font></td>
					</tr>
					<tr>
						<td align="center" colspan="2"><font size="+8">PROVISIONAL OVERALL SUMMARY RESULTS</font></td>
					</tr>
				</table>
EOD;

		$TITLE .= <<<EOD
				<table border="0" cellpadding="2" cellspacing="0" style="font-weight:bold">
					<tr>
						<th width="300">
							<font size="+2">YEAR OF STUDY: $year - $sem</font>
						</th>
						<th align="center" width="620">
							<font size="+4">[$class] $rptitle</font>
						</th>
						<th>
							<font size="+4">Weight: CA - 40% ... Weight: SE - 60%</font>
						</th>
					</tr>
				</table>
EOD;
		//$pdf->writeHTML($TITLE, true, false, true, false, '');
		//--------------------------------------------
		
		
		
		//----------------------------------------------	
		//GET COURSE DETAILS
		$progcredits = 0;
		$unithd = '';
		$coursehd = '';
		$scorehd = '';
		
		$compwidth = 0;
		foreach($coursearray as $studycourse){
			$XUnit = mysql_query("SELECT Units FROM course WHERE CourseCode='$studycourse'");
			list($unit) = mysql_fetch_array($XUnit);
			
			$coursehd .= <<<EOD
					<td align="center" width="120" colspan="4">$studycourse</td>
EOD;

			$unithd .= <<<EOD
					<td align="center" width="120" colspan="4">$unit</td>
EOD;
			$scorehd .= <<<EOD
					<td align="center" width="30">CA</td>
					<td align="center" width="30">SE</td>
					<td align="center" width="30">TOT</td>
					<td align="center" width="30">GRD</td>
EOD;
			$compwidth = $compwidth + 120;
			}
		
		$compwidth = 'width="'.$compwidth.'"';
		//column header header
		if(count($coursearray)>7){
			$width = 'width="195"';
			$Nametd = '';
			}
		else{
			$width = 'width="325"';
			$Nametd = '<td width="130">NAME</td>';
			}
		$colhead = <<<EOD
					<tr>
						<td align="center" $width>MODULE CODE:</td>
						$coursehd
						<td align="center" width="270" rowspan="3">OVERALL PERFORMANCE</td>						
					</tr>
					<tr>
						<td align="center" $width>MODULE CREDITS:</td>
						$unithd
					</tr>
					<tr>
						<td align="center" $width>EXAM COMPONENTS:</td>
						$scorehd						
					</tr>
					<tr>
						<td width="30">S/No</td>
						<td width="130">REGISTRATION #</td>
						$Nametd
						<td width="35">SEX</td>
						<td $compwidth>EXAMINATION RESULTS</td>
						<td width="40">CRDT</td>
						<td width="40">PTS</td>
						<td width="40">GPA</td>
						<td width="150">REMARK</td>
					</tr>
EOD;
		//----------------------------------------------
		
		//write to PDF	
		
		//GPA Classes
		$meA=0; $feA=0;
		$meBp=0; $feBp=0;
		$meB=0; $feB=0;
		$meC=0; $feC;
		$meF=0; $feF=0;
		
		//REMARKS Categories
		$mepass=0; $fepass=0;
		$mesupp=0; $fesupp=0;
		$mefail=0; $fefail=0;
		$meinc=0; $feinc=0;
		$meother=0; $feother=0;

        //get student results
        $qstudent = "SELECT * FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
        if($_POST['orderby'] == 'regno'){
            $qstudent .= " ORDER BY RegNo";
        }elseif ($_POST['orderby'] == 'gender'){
            $qstudent .= " ORDER BY Sex";
        }elseif ($_POST['orderby'] == 'name'){
            $qstudent .= " ORDER BY Name";
        }
		$dbstudent = mysql_query($qstudent);
		$totalstudent = mysql_num_rows($dbstudent);
		$i=1;
		
		$studenresults = '';
		$tbl = '';
		//query exam results sorted per years
		while($rowstudent = mysql_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
			$key = $regno;
			$RegNo = $regno;
			
			$bdate = $rowstudent['DBirth'];
			$degree = stripslashes($rowstudent["ProgrammeofStudy"]);
			$faculty = stripslashes($rowstudent["Faculty"]);
			$sponsor = stripslashes($rowstudent["Sponsor"]);
			$entryyear = stripslashes($rowstudent['EntryYear']);
			$ststatus = stripslashes($rowstudent['Status']);
			
			$entryyr = "OCTOBER, ".substr($rowstudent['EntryYear'],0,4);
			
			$chckremark="select * from studentremark where RegNo='$regno' ";
			$resultremark=mysql_query($chckremark);
			$rowremark=mysql_fetch_array($resultremark);
			$studremark=$rowremark['Remark'];
			$semremark=$rowremark['Semester'];
			$acyrremark=$rowremark['AYear'];
			$shiftyearclause=($studremark=='PSSG')?" OR examresult.AYear='$acyrremark'":"";
					
			//initialize
			$totalunit=0;
			$unittaken=0;
			$sgp=0;
			$totalsgp=0;
			$gpa=0;
			$key = $regno;
			$offset = 1;
			$suppcount = 0;
			$gunits = 0;
			$gpoints = 0;
			$sem1units = 0;
			$sem2units = 0;
			$sem1sgp = 0;
			$sem2sgp = 0;
			$coursesfailed = 0;
			$skipped = 0;
			$incOption = '';
			
			$courseperfom = array();
			$save = array();
            
            if(count($coursearray)>7){
				$Nametd = "";
				}
			else{
				$Nametd = "<td width=\"130\">$name</td>";
				}
            $tbl = <<<EOD
					<td  width="30">$i</td>
					<td width="130">$regno</td>
					$Nametd
					<td width="35">$sex</td>
EOD;
            
			//get student marks and grades
			$qstdcourse = "SELECT DISTINCT coursecode FROM examresult WHERE RegNo='$regno' and AYear='$year' AND Semester='$sem'";
			$dbstdcourse = mysql_query($qstdcourse);
			$totalstdcourse = mysql_num_rows($dbstdcourse);
			
            //foreach($coursearray as $studycourse){
            foreach($coursearray as $studycourse){
				$getrows = mysql_query("SELECT * FROM examresult WHERE CourseCode='$studycourse' AND RegNo='$regno' AND AYear='$year'");
				$uploaded = mysql_num_rows($getrows);
				
				$dbcourseUnit = mysql_query("SELECT * FROM course WHERE CourseCode='$studycourse'");
				
				//get student performance
				while($row_course = mysql_fetch_array($dbcourseUnit)) { 
					$course= $row_course['CourseCode'];
					$unit = $row_course['Units'];
					$name = $row_course['CourseName'];
					$coursefaculty = $row_course['Department'];
					$remarks = 'remarks';
					$grade='';
					$supp='';
					$RegNo = $regno;
					
					$stdcourse = $course;
					$coursefull = explode(" ",$stdcourse);
					$courseleft = $coursefull[0];
					$courseright = $coursefull[1];
					$exam_ayear = $year;					
					include 'includes/choose_studylevel.php';
					
					//get course status
					$academic = array('FIRST YEAR'=>1,'SECOND YEAR'=>2,'THIRD YEAR'=>3,'FOURTH YEAR'=>4,'FIFTH YEAR'=>5);
					$semval = ($sem=='Semester I')? 1:2;
					$yearofstudy = $academic[$class];
					
					$qcourse = "SELECT Status FROM courseprogramme WHERE (ProgrammeID='$deg') 
								AND (YearofStudy='$yearofstudy') AND (Semester = '$semval')
								AND (AYear='$year') AND (CourseCode='$stdcourse')";
					$dbstdcourse = mysql_query($qcourse);
					list($option) = mysql_fetch_array($dbstdcourse);
					
					//control remark for unfinished core modules
					if($option=='1'){
						if($test2score=='' && $aescore==''){
							$grade = '';
							$supp = '';
							$marks = '';
							$incOption = 'I';
							}
						}
					else{
						if($test2score=='' && $aescore==''){
							$grade = '';
							$supp = '';
							$marks = '';
							}
						}
						
					if($grade=='D' || $grade=='E' || $grade=='E*' || $grade=='I' || $grade=='F'){
						//$style = 'style="background-color:yellow; font-weight:bold"';
						$style = 'style="font-weight:bold"';
						$style2 = 'style="font-weight:bold"';
						$suppcount = $suppcount+1;
						$coursesfailed = $coursesfailed + 1;
						$save[] = strtoupper($course);
						}
					else{
						$style = '';
						$style2 = '';
						}
					
					if(@$supp=='!'){ 
						$grade2 = $grade.''.$supp;
						//$style = 'style="background-color:yellow; font-weight:bold"';
						$style = 'style="font-weight:bold"';
						$style2 = 'style="font-weight:bold"';
						}
					else{
						$grade2 = $grade;
						}
					
					//student scores
					$aescore = (($row_sup_total>0)&&($supscore<>''))? $supscore:$aescore;
					
					$tbl .= <<<EOD
								<td width="30" $style>$test2score</td>
								<td width="30" $style>$aescore</td>
								<td width="30" $style>$marks</td>
								<td width="30" $style>$grade2</td>
EOD;
					$supp='';
					}
				}			
				
			//calcultate G.P.As
				
			if($totalstdcourse=0){
				//Semester G.P.As
				$gunits = 0;
				$gpoints = 0;
				$gpa = '-';
				}
			else{
				//Semester G.P.As
				$gunits = $unittaken +$gunits;
				$gpoints = $totalsgp + $gpoints;
				$gpa = @substr($totalsgp/$unittaken, 0,3);
				}
			
			//ASSIGN G.P.A CLASS
			if ($gpa  >= 4.4 && empty($save)){
				$remark = 'PASS';
				$gpagrade='A';
				
				if($sex=='M'){
					$meA = $meA+1;
					}
				else{
					$feA = $feA+1;
					}
				}
			elseif ($gpa  >= 4.4 && !empty($save)){
				$remark = 'SUPP';
				$gpagrade='A';
				
				if($sex=='M'){
					$meA = $meA+1;
					}
				else{
					$feA = $feA+1;
					}
				}
			elseif ($gpa >= 3.5 && empty($save)){
				$remark = 'PASS';
				$gpagrade= 'B+';
				
				if($sex=='M'){
					$meBp = $meBp+1;
					}
				else{
					$feBp = $feBp+1;
					}
				}
			elseif ($gpa >= 3.5 && !empty($save)){
				$remark = 'SUPP';
				$gpagrade= 'B+';
				
				if($sex=='M'){
					$meBp = $meBp+1;
					}
				else{
					$feBp = $feBp+1;
					}
				}
			elseif ($gpa >= 2.7 && empty($save)){
				$remark = 'PASS';
				$gpagrade= 'B';
				
				if($sex=='M'){
					$meB = $meB+1;
					}
				else{
					$feB = $feB+1;
					}
				}
			elseif ($gpa >= 2.7 && !empty($save)){
				$remark = 'SUPP';
				$gpagrade= 'B';
				
				if($sex=='M'){
					$meB = $meB+1;
					}
				else{
					$feB = $feB+1;
					}
				}

			elseif ($gpa >= 2.0 && empty($save)){
				$remark = 'PASS';
				$gpagrade= 'C';
				
				if($sex=='M'){
					$meC = $meC+1;
					}
				else{
					$feC = $feC+1;
					}
				}
			elseif ($gpa >= 2.0 && !empty($save)){
				$remark = 'SUPP';
				$gpagrade= 'C';
				
				if($sex=='M'){
					$meC = $meC+1;
					}
				else{
					$feC = $feC+1;
					}
				}
			elseif ($gpa < 2.0){
				$remark = 'DISCO';
				$gpagrade= 'D';
				
				if($sex=='M'){
					$meF = $meF+1;
					}
				else{
					$feF = $feF+1;
					}
				}
			else{
				$remark = 'DISCO';
				$gpagrade= 'E';
				
				if($sex=='M'){
					$meF = $meF+1;
					}
				else{
					$feF = $feF+1;
					}
				}
			
			//check if student has unfinished compulsary modules
			if($incOption=='I' && $gpa>=2.0){
				$remark = 'ABSC';
				}
															
			$gpa = ($unittaken < 1)? '-':$gpa;
				
			//track supplementary courses
			$save_str = '';
			$br = 0;
			foreach($save as $val){
				$br++;
				if($br > 1){
					$save_str .= $val.'<br/>';
					$br = 0;
					}
				else{
					$save_str .= $val.', ';				
					}
				}
			$save = '';
			$save_str = rtrim($save_str,'<br/>');
			$save_str = rtrim($save_str,', ');
			$coursesfailed = 0;
			
			$qremarks = "SELECT Remark FROM studentremark WHERE RegNo='$regno' AND AYear='$year'";
			$dbremarks = mysql_query($qremarks);
			$row_remarks = mysql_fetch_assoc($dbremarks);
			$totalremarks = mysql_num_rows($dbremarks);
			$studentremarks = $row_remarks['Remark'];
			if(($totalremarks>0)&&($studentremarks<>'')){
				$remark = $studentremarks;
				}
			
			//set background color for failures
			if($remark<>'PASS'){
				if($remark=='FAIL' || $remark=='DISCO'){
					//$style = 'style="background-color:red"';
					$style = '';
					if($sex=='M'){
						$mefail = $mefail+1;
						}
					else{
						$fefail = $fefail+1;
						}
					}
				elseif($remark=='ABSC'){
					if($sex=='M'){
						$meinc = $meinc+1;
						}
					else{
						 $feinc =  $feinc+1;
						}
					}
				else{
					//$style = 'style="background-color:yellow"';
					$style = 'font-weight:bold';
					if($remark=='SUPP'){
						if($sex=='M'){
							$mesupp = $mesupp+1;
							}
						else{
							$fesupp = $fesupp+1;
							}
						}
					else{
						if($sex=='M'){
							$meother = $meother+1;
							}
						else{
							$feother = $feother+1;
							}

						}
					}
				}
			else{
				$style = '';
				
				if($sex=='M'){
					$mepass = $mepass+1;
					}
				else{
					$fepass = $fepass+1;
					}
				}
			
			$save_str = ($remark=='SUPP')? $save_str:'';
			$tbl .= <<<EOD
					<td width="40">$unittaken</td>
					<td width="40">$totalsgp</td>
					<td width="40">$gpa</td>
					<td $style width="150">$remark<br/><br/>$save_str</td>
EOD;
			
			/*************************************
			 * RESULTS PRINTING
			 ************************************/
			if($i==1){
				$table = <<<EOD
						<table border="1" cellpadding="2" cellspacing="0" style="text-align:center">
							$colhead
							<tr>
								$tbl
							</tr>
						</table>
EOD;
				$pdf->writeHTML($TITLE, true, false, true, false, '');
				$pdf->writeHTML($table, true, false, true, false, '');				
				}
			else{
				$startY = $pdf->GetY();
				$Y = ($totalcolms>6)? 385:355;
				if($startY>$Y){
					// add a page
					$pdf->AddPage();
					
					// get the current page break margin
					$bMargin = $pdf->getBreakMargin();
					// get current auto-page-break mode
					$auto_page_break = $pdf->getAutoPageBreak();
					// disable auto-page-break
					$pdf->SetAutoPageBreak(false, 0);
					// restore auto-page-break status
					$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
					// set the starting point for the page content
					$pdf->setPageMark();
					
					//print first row
					$table = <<<EOD
								<table border="1" cellpadding="2" cellspacing="0" style="text-align:center">
									$colhead
									<tr>
										$tbl
									</tr>
								</table>
EOD;
					$pdf->writeHTML($table, true, false, true, false, '');
					}	
				else{
					$startY = $pdf->GetY();
					$pdf->SetY($startY-3.6);
					$table = <<<EOD
							<table border="1" cellpadding="2" cellspacing="0" style="text-align:center">
								<tr>
									$tbl
								</tr>
							</table>
EOD;
					$pdf->writeHTML($table, true, false, true, false, '');
					}
				}
				
			$i++;
			}
		
		
		//PERFORMANCE STATISTICS
		$pass = $fepass + $mepass;
		$supps = $fesupp + $mesupp;
		$fail = $fefail + $mefail;
		$inco = $feinc + $meinc;
		$other = $feother + $meother;
		
		$pass2 = number_format($pass*100/$totalstudent,1).'%';
		$supps2 = number_format($supps*100/$totalstudent,1).'%';
		$fail2 = number_format($fail*100/$totalstudent,1).'%';
		$inco2 = number_format($inco*100/$totalstudent,1).'%';
		$other2 = number_format($other*100/$totalstudent,1).'%';
		
		$perfstats =<<<EOD
					<br/><br/>
					<font size="+2">
					<table border="1" cellpadding="1" cellspacing="0" width="90%" style="font-style:italic; text-align:center">
						<tr>
							<td colspan="6">SUMMARY OF PERFORMANCE STATISTICS</td>
						</tr>
						<tr>
							<td align="left"> REMARKS</td>
							<td>PASS</td>
							<td>SUPPLEMENTARY</td>
							<td>FAIL</td>
							<td>INCOMPLETE</td>
							<td>OTHER REMARKS</td>
						</tr>
						<tr>
							<td align="left"> FEMALE</td>
							<td>$fepass</td>
							<td>$fesupp</td>
							<td>$fefail</td>
							<td>$feinc</td>
							<td>$feother</td>
						</tr>
						<tr>
							<td align="left"> MALE</td>
							<td>$mepass</td>
							<td>$mesupp</td>
							<td>$mefail</td>
							<td>$meinc</td>
							<td>$meother</td>
						</tr>
						<tr>
							<td align="left"> SUBTOTAL</td>
							<td>$pass($pass2)</td>
							<td>$supps($supps2)</td>
							<td>$fail($fail2)</td>
							<td>$inco($inco2)</td>
							<td>$other($other2)</td>
						</tr>
					</table>
					</font>
EOD;
		
		$startY = $pdf->GetY();
		$Y = ($totalcolms>5)? 370:290;	
		if($startY>$Y){
			// add a page
			$pdf->AddPage();
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
			$pdf->SetAutoPageBreak(false, 0);
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			}
		
		$pdf->writeHTML($perfstats, true, false, true, false, '');
		
		
		//SUMMARY OF GPA STATISTICS FOR UNDERGRADUATES
		$A = $feA + $meA;
		$Bp = $feBp + $meBp;
		$B = $feB + $meB;
		$C = $feC + $meC;
		$F = $feF + $meF;
		
		
		//PRINTING COURSE DETAILS
		$tbl='';
		$startY = $pdf->GetY();
		$Y = ($totalcolms>5)? 320:280;
		if($startY>$Y){
			$pdf->AddPage();
				
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
			$pdf->SetAutoPageBreak(false, 0);
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			
			$tbl = <<<EOD
				<br/><br/>
EOD;
			}
		
		$ext = ($tbl=='')? "<br/><br/>":"";
		$tbl .= <<<EOD
				$ext
				<font size="+3">
				<table border="1" cellpadding="2" cellspacing="0" style="font-style:italic; font-weight:bold;">
					<tr><td colspan="3"  width="600" align="center">KEY FOR COURSE CODES</td></tr>
					<tr><td  width="50">SNo.</td><td width="200">COURSE CODE</td><td  width="350">COURSE TITLE</td></tr>
				</table>
				</font>
EOD;
		$pdf->writeHTML($tbl, true, false, true, false, '');
		
		$i=1;
		foreach($coursearray as $course){
			$get_coursedet = mysql_query("SELECT CourseName FROM course WHERE CourseCode='$course'");
			list($name) = mysql_fetch_array($get_coursedet);
			
			$startY = $pdf->GetY();
			$Y = ($totalcolms>5)? 345:305;
			if($startY>$Y){
										// add a page
				$pdf->AddPage();
				
				// get the current page break margin
				$bMargin = $pdf->getBreakMargin();
				// get current auto-page-break mode
				$auto_page_break = $pdf->getAutoPageBreak();
				// disable auto-page-break
				$pdf->SetAutoPageBreak(false, 0);
				// restore auto-page-break status
				$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
				// set the starting point for the page content
				$pdf->setPageMark();
				
				$tbl = <<<EOD
					<br/><br/>
EOD;
				$pdf->writeHTML($tbl, true, false, true, false, '');
				}
			$startY = $pdf->GetY();
			$pdf->SetY($startY-3.6);
			$tbl = <<<EOD
					<font size="+3">
					<table border="1" cellpadding="2" cellspacing="0" style="font-style:italic">
						<tr><td width="50">$i</td><td  width="200">$course</td><td  width="350">$name</td></tr>
					</table>
					</font>
EOD;
			$pdf->writeHTML($tbl, true, false, true, false, '');
			$i++;
			}
		
		//print signatory part
		$tbl =<<<EOD
				<br/><br/>
				<font size="+2">
				<table border="0" cellpadding="2" cellspacing="0">
					<tr>
						<td align="center" colspan="2">######## END OF EXAM RESULTS ########</td>
					</tr>
					<tr>
						<td> Signature of The Secretary, Examination Board: ___________________ Date: _________________ </td>
						<td> Signature of the Chairperson, Examination Board: ___________________ Date: _________________</td>
					</tr>
				</table>
				</font>
EOD;
		
		$startY = $pdf->GetY();	
		$Y = ($totalcolms>5)? 340:300;
		if($startY>$Y){
			// add a page
			$pdf->AddPage();
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
			$pdf->SetAutoPageBreak(false, 0);
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			}
		
		$pdf->writeHTML($tbl, true, false, true, false, '');
				
		//Close and output PDF document
		$pdf->Output($rptitle.'.pdf', 'I');
		}
	
	
?>
