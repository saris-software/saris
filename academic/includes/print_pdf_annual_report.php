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
// Author: Charles Bundu & Zalongwa Technologies
//
// (c) Copyright:
//               Charles John Bundu & Zalongwa Technologies Limited
//               DAR-ES-SALAAM
//               TANZANIA
//               EAST AFRICA
//               rwige1@gmail.com
//				 support@zalongwa.com
//============================================================+

	require_once('../tcpdf/config/lang/eng.php');
	require_once('../tcpdf/tcpdf.php');
	/** Error reporting */
	error_reporting(E_ALL);
	
	
	/****************************************
	 * UNDERGRADUATE SEMESTER REPORT FUNCTION
	 ****************************************/
	function undergraduateReport($progname,$class,$faculty,$deg,$cohot,$year,$coursearray){
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
		if(count($coursearray)>6){
			if(count($coursearray)==6){
				$custom_layout = array(395, 400);
				}
			else{
				$custom_layout = array(400, 405);
				}
			}
		else{
			$custom_layout = array(345, 350);
			}
		
		$custom_layout = array(370, 375);
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
		
		global 

$TITLE;
		// ---------------------------------------------------------

		
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
							<font size="+2">YEAR OF STUDY: $year</font>
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
		
		$compwidth = 40;
		foreach($coursearray as $studycourse){
			$compwidth = $compwidth + 70;
			}
		
		$compwidth = 'width="'.$compwidth.'"';
		//column header header
		$colhead = <<<EOD
					<tr bgcolor="cyan">
						<td width="30">S/No</td>
						<td width="130">REGISTRATION #</td>
						<td width="130">NAME</td>
						<td width="35">SEX</td>
						<td $compwidth>EXAMINATION RESULTS</td>
						<td width="290">PERFORMANCE</td>
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
		$qstudent = "SELECT * FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY RegNo";
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
								
            
            $LEVELS = array('','ONE1'=>'','ONE2'=>'','ONE3'=>'','TWO1'=>'','TWO2'=>'','TWO3'=>'');
            $LEVELS1 = array('','ONE1'=>'','ONE2'=>'','ONE3'=>'');
            $LEVELS2 = array('','TWO1'=>'','TWO2'=>'','TWO3'=>'');
            
            //failed course array
            $failed_course = array();
            $tbl = <<<EOD
					<td  width="30" rowspan="6">$i</td>
					<td width="130" rowspan="6">$regno</td>
					<td width="130" rowspan="6">$name</td>
					<td width="35" rowspan="6">$sex</td>
EOD;
            
			//get student marks and grades
			$qstdcourse = "SELECT DISTINCT coursecode FROM examresult WHERE RegNo='$regno' and AYear='$year'";
			$dbstdcourse = mysql_query($qstdcourse);
			$totalstdcourse = mysql_num_rows($dbstdcourse);
			
			$academic = array('FIRST YEAR'=>1,'SECOND YEAR'=>2,'THIRD YEAR'=>3,'FOURTH YEAR'=>4,'FIFTH YEAR'=>5);			
			$yearofstudy = $academic[$class];
            $courseperfom = array();
            $keyInc = '';
            
            $SEMcounter = 1;
            $sem1units = 0;
			$sem2units = 0;
			$sem1sgp = 0;
			$sem2sgp = 0;
				
            while($SEMcounter<3){
				
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
				$coursesfailed = 0;
				$skipped = 0;
				$incOption = '';
				$save = array();
				
				$qtotalstdsem = mysql_query("SELECT COUNT(DISTINCT(CourseCode)) AS TOTAL FROM examresult 
											WHERE RegNo='$regno' and AYear='$year' AND Semester='$SEMcounter'");
				list($totalstdsem) = mysql_fetch_array($qtotalstdsem);
				
				//get courses
				$qcourse = "SELECT DISTINCT CourseCode, Status FROM courseprogramme WHERE  (ProgrammeID='$deg') 
							AND (YearofStudy='$yearofstudy') AND (Semester = '$SEMcounter')  AND (AYear='$year') 
							ORDER BY CourseCode";
				$dbstdcourse = mysql_query($qcourse);
				
				//number of courses involved
				$courseInvolved = 0;
				while(list($studycourse,$option) = mysql_fetch_array($dbstdcourse)){
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
						
						include 'includes/choose_studylevel.php';
												
						//control remark for unfinished core modules
						if($option=='1'){
							if($test2score=='' && $aescore==''){
								$grade = '';
								$supp = '';
								$marks = '';
								$incOption = 'I';
								$keyInc = 1;
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
						
						//create array index
						if($SEMcounter==1){
							$a = 1;
							$b = 2;
							$c = 3;
							}
						else{
							$a = 4;
							$b = 5;
							$c = 6;
							}
						//populate coursecodes
						$course = strtoupper($course);
						$LEVELS[$a] .= <<<EOD
									<td width="70">$course <br/>($unit)</td>
EOD;
						//populate course perfomance header
						$LEVELS[$b] .= <<<EOD
									<td width="70">GRADE</td>
EOD;
						//populate course scores
						$LEVELS[$c] .= <<<EOD
									<td width="70" $style>$grade2</td>
EOD;
						$supp='';
						}
					$courseInvolved++;
					}
				
				//populate missing gaps
				if($SEMcounter==1){
					$a = 1;
					$b = 2;
					$c = 3;
					}
				else{
					$a = 4;
					$b = 5;
					$c = 6;
					}
							
				while($courseInvolved < count($coursearray)){					
					$LEVELS[$a] .= <<<EOD
									<td width="70" rowspan="3"></td>
EOD;
					$courseInvolved++;
					}
				
				//calculate semester G.P.A
				if($totalstdsem=0){
					$gunits = 0;
					$gpoints = 0;
					$gpa = '-';
					}
				else{
					$gunits = $unittaken +$gunits;
					$gpoints = $totalsgp + $gpoints;
					$gpa = @substr($totalsgp/$unittaken, 0,3);
					}
				
				//track units and points	
				if($SEMcounter==1){
					$sem1units = $unittaken;
					$sem1sgp = $totalsgp;
					}
				else{
					$sem2units = $unittaken;
					$sem2sgp = $totalsgp;
					}				
					
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
					
				$num_failed = (count($save)>0)? count($save):"";
				$failed_course[$SEMcounter] = $num_failed;
				$save = '';				
				$save_str = rtrim($save_str,'<br/>');
				$save_str = rtrim($save_str,', ');
				$coursesfailed = 0;
				
				//performance summary
				$semrem = ($SEMcounter==1)? "SEM I REMARKS":"SEM II REMARKS";
				
				if($SEMcounter==1){
					$a = 1;
					$b = 2;
					$c = 3;
					}
				else{
					$a = 4;
					$b = 5;
					$c = 6;
					}

				$LEVELS[$a] .= <<<EOD
								<td width="90">$semrem</td>
								<td width="120">MODULES FAILED</td>
EOD;
				$LEVELS[$b] .= <<<EOD
								<td width="30">CRD</td>
								<td width="30">PTS</td>
								<td width="30">GPA</td>
								<td width="120" rowspan="2">$num_failed</td>
EOD;
				$LEVELS[$c] .= <<<EOD
								<td width="30">$unittaken</td>
								<td width="30">$totalsgp</td>
								<td width="30">$gpa</td>
EOD;
				$SEMcounter++;
				}
					
			//calcultate annual G.P.A
				
			if($totalstdcourse=0){
				//Semester G.P.As
				$gunits = 0;
				$gpoints = 0;
				$Annualgpa = '-';
				}
			else{
				//Semester G.P.As
				$gunits = $sem1units +$sem2units;
				$gpoints = $sem1sgp + $sem2sgp;
				$Annualgpa = @substr($gpoints/$gunits, 0,3);
				}
			
			//ASSIGN G.P.A CLASS
			if ($Annualgpa >= 4.4 && empty($save)){
				$remark = 'PASS';
				$gpagrade='A';
				
				if($sex=='M'){
					$meA = $meA+1;
					}
				else{
					$feA = $feA+1;
					}
				}
			elseif ($Annualgpa >= 4.4 && !empty($save)){
				$remark = 'SUPP';
				$gpagrade='A';
				
				if($sex=='M'){
					$meA = $meA+1;
					}
				else{
					$feA = $feA+1;
					}
				}
			elseif ($Annualgpa >= 3.5 && empty($save)){
				$remark = 'PASS';
				$gpagrade= 'B+';
				
				if($sex=='M'){
					$meBp = $meBp+1;
					}
				else{
					$feBp = $feBp+1;
					}
				}
			elseif ($Annualgpa >= 3.5 && !empty($save)){
				$remark = 'SUPP';
				$gpagrade= 'B+';
				
				if($sex=='M'){
					$meBp = $meBp+1;
					}
				else{
					$feBp = $feBp+1;
					}
				}
			elseif ($Annualgpa >= 2.7 && empty($save)){
				$remark = 'PASS';
				$gpagrade= 'B';
				
				if($sex=='M'){
					$meB = $meB+1;
					}
				else{
					$feB = $feB+1;
					}
				}
			elseif ($Annualgpa >= 2.7 && !empty($save)){
				$remark = 'SUPP';
				$gpagrade= 'B';
				
				if($sex=='M'){
					$meB = $meB+1;
					}
				else{
					$feB = $feB+1;
					}
				}

			elseif ($Annualgpa >= 2.0 && empty($save)){
				$remark = 'PASS';
				$gpagrade= 'C';
				
				if($sex=='M'){
					$meC = $meC+1;
					}
				else{
					$feC = $feC+1;
					}
				}
			elseif ($Annualgpa >= 2.0 && !empty($save)){
				$remark = 'SUPP';
				$gpagrade= 'C';
				
				if($sex=='M'){
					$meC = $meC+1;
					}
				else{
					$feC = $feC+1;
					}
				}
			elseif ($Annualgpa < 2.0){
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
			if($keyInc=='1' && $Annualgpa>=2.0){
				$remark = 'ABSC';
				}
															
			$Annualgpa = ($gunits < 1)? '-':$Annualgpa;
			
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
			
			$LEVELS[1] .= <<<EOD
						<td width="80">OVERALL REMARKS</td>
EOD;
			
			//calculate remark basing on G.P.A or number of failed courses
			if($year>'2013/2014'){
				$remark1 = 'SUP';
				$remark2 = $failed_course[1]+$failed_course[2];
				if($remark2==0){
					$remark3 = 'PASS';
					}
				else{
					$remark3 = 'REPEAT';
					}
				}
			else{
				$remark1 = 'GPA';
				$remark2 = $Annualgpa;
				$remark3 = $remark;
				}
				
			$LEVELS[2] .= <<<EOD
						<td width="30">$remark1</td>
						<td width="50">REMARK</td>
EOD;
			$LEVELS[3] .= <<<EOD
							<td width="30" rowspan="4">$remark2</td>
							<td width="50" rowspan="4">$remark3</td>
EOD;
			
			/*************************************
			 * RESULTS PRINTING
			 ************************************/
			
			$tbl11 = $LEVELS[1]; $tbl21 = $LEVELS[4];
			$tbl12 = $LEVELS[2]; $tbl22 = $LEVELS[5];
			$tbl13 = $LEVELS[3]; $tbl23 = $LEVELS[6];
			
			if($i==1){
				$table = <<<EOD
						<table border="1" cellpadding="2" cellspacing="0" style="text-align:center">
							$colhead
							<tr>
								$tbl
								<td width="40" rowspan="3">SEM I</td>
								$tbl11
							</tr>
							<tr>								
								$tbl12
							</tr>
							<tr>								
								$tbl13
							</tr>
							<tr>
								<td width="40" rowspan="3">SEM II</td>
								$tbl21
							</tr>
							<tr>
								$tbl22
							</tr>
							<tr>
								$tbl23
							</tr>
						</table>
EOD;
				$pdf->writeHTML($TITLE, true, false, true, false, '');
				$pdf->writeHTML($table, true, false, true, false, '');
				}
			else{
				$startY = $pdf->GetY();
				$Y = ($totalcolms>6)? 320:320;
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
										<td width="40" rowspan="3">SEM I</td>
										$tbl11
									</tr>
									<tr>								
										$tbl12
									</tr>
									<tr>								
										$tbl13
									</tr>
									<tr>
										<td width="40" rowspan="3">SEM II</td>
										$tbl21
									</tr>
									<tr>
										$tbl22
									</tr>
									<tr>
										$tbl23
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
									<td width="40" rowspan="3">SEM I</td>
									$tbl11
								</tr>
								<tr>								
									$tbl12
								</tr>
								<tr>								
									$tbl13
								</tr>
								<tr>
									<td width="40" rowspan="3">SEM II</td>
									$tbl21
								</tr>
								<tr>
									$tbl22
								</tr>
								<tr>
									$tbl23
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
		$Y = ($totalcolms>5)? 305:305;	
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
		$Y = ($totalcolms>5)? 295:295;
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
		$qcourse = mysql_query("SELECT DISTINCT CourseCode FROM courseprogramme WHERE  (ProgrammeID='$deg') 
								AND (YearofStudy='$yearofstudy') AND (AYear='$year') ORDER BY CourseCode");
		
		while(list($course) = mysql_fetch_array($qcourse)){
			$get_coursedet = mysql_query("SELECT CourseName FROM course WHERE CourseCode='$course'");
			list($name) = mysql_fetch_array($get_coursedet);
			
			$startY = $pdf->GetY();
			$Y = ($totalcolms>5)? 330:330;
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
		$Y = ($totalcolms>5)? 325:325;
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
