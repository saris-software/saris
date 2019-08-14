<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.6, 2011-02-27
 */

/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once '../Classes/PHPExcel.php';
	
	$papersize='PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4';
	$fontstyle='Arial';
	$font=10.5;
	/*
	$prog=$_POST['degree'];
	$qprog= "SELECT ProgrammeCode, Title, Faculty FROM programme WHERE ProgrammeCode='$prog'";
	$dbprog = mysql_query($qprog);
	$row_prog = mysql_fetch_array($dbprog);
	$programme = $row_prog['Title'];
	*/
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set properties
	$objPHPExcel->getProperties()->setCreator("Zalongwa")
								 ->setLastModifiedBy("Juma Lungo")
								 ->setTitle($programme)
								 ->setSubject("Semester Exam Results")
								 ->setDescription("\Graduates Results.")
								 ->setKeywords("zalongwa saris software")
								 ->setCategory("Exam result file");
	
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
	
		# Set protected sheets to 'true' kama hutaki waandike waziedit sheets zako. Kama unataka wazi-edit weka 'false'
		$objPHPExcel->getActiveSheet()->getProtection()->setSheet(false);
	
		#set worksheet orientation and size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize($papersize);
	
		#Set page fit width to true
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
	
		#Set footer page numbers
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
		#Show or hide grid lines
		$objPHPExcel->getActiveSheet()->setShowGridlines(false);
	
		#Set sheet style (fonts and font size)
		$objPHPExcel->getDefaultStyle()->getFont()->setName($fontstyle);
		$objPHPExcel->getDefaultStyle()->getFont()->setSize($font); 
	
		#Set page margins
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);
	
		# Set Rows to repeate in each page
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);
	
		# Set Report Logo
		/*
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('../images/logo.jpg');
		$objDrawing->setHeight(100);
	
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('../images/logo.jpg');
		$objDrawing->setCoordinates('B1');
		$objDrawing->setOffsetX(110);
		$objDrawing->setRotation(25);
		$objDrawing->getShadow()->setVisible(true);
		$objDrawing->getShadow()->setDirection(45);
	
	       */
		$styleArray = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				),
			),
		);

	

		for($col=A;$col<ZZ;$col++) { 
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		#Get Organisation Name
		$qorg = "SELECT * FROM organisation";
		$dborg = mysql_query($qorg);
		$row_org = mysql_fetch_assoc($dborg);
		$org = $row_org['Name'];
	
		$prog=$_POST['degree'];
		$cohotyear = $_POST['cohort'];
		$ayear = $_POST['ayear'];
		$qprog= "SELECT ProgrammeCode, Title, Faculty FROM programme WHERE ProgrammeCode='$prog'";
		$dbprog = mysql_query($qprog);
		$row_prog = mysql_fetch_array($dbprog);
		$programme = $row_prog['Title'];
		$faculty = $row_prog['Faculty'];
		$class = $row_prog['Ntalevel'];
	
		//calculate year of study
		$entry = intval(substr($cohotyear,0,4));
		$current = intval(substr($ayear,0,4));
		$yearofstudy=$current-$entry;
	
		if ($entry>0){
			$deg=addslashes($_POST['degree']);
			$year = addslashes($_POST['ayear']);
			$cohot = addslashes($_POST['cohot']);
			$dept = addslashes($_POST['dept']);
			$sem = addslashes($_POST['sem']);
			if ($sem =='Semester I'){
				$semval = 1;
			}elseif ($sem=='Semester II'){
				$semval = 2;
			}
		$sem='Annual Report';
		$sem='graduates';
		#force semvalue to be semester 2	
	
		#calculate year of study
		//$entry = intval(substr($cohot,0,4));
		//$current = intval(substr($ayear,0,4));
		//$yearofstudy=$current-$entry;
	
		if($yearofstudy==0){
			$class="FIRST YEAR";
			}elseif($yearofstudy==1){
			$class="SECOND YEAR";
			}elseif($yearofstudy==2){
			$class="THIRD YEAR";
			}elseif($yearofstudy==3){
			$class="FOURTH YEAR";
			}elseif($yearofstudy==4){
			$class="FIFTH YEAR";
			}elseif($yearofstudy==5){
			$class="SIXTH YEAR";
			}elseif($yearofstudy==6){
			$class="SEVENTH YEAR";
			}else{
			$class="";
		}
		#cohort number
		$yearofstudy = $yearofstudy +1;
		$totalcolms =0;
	
		#determine total number of columns
		if ($checkcombin=='on'){
			$combin = addslashes($_POST['combin']);
		
			$qcolmns = "SELECT DISTINCT CourseCode, Status FROM courseprogramme WHERE  (ProgrammeID='$deg')
						AND (Combination='$combin') AND (YearofStudy='$yearofstudy') AND (Semester='$semval')
						ORDER BY CourseCode";
			}
		else{
			$qcolmns = "SELECT DISTINCT CourseCode, Status FROM courseprogramme 
					WHERE  (ProgrammeID='$deg') AND (YearofStudy='$yearofstudy') AND (Semester='$semval')
					ORDER BY CourseCode";
			}
				
		$dbcolmns = mysql_query($qcolmns);
		$dbcolmnscredits = mysql_query($qcolmns);
		$dbexamcat = mysql_query($qcolmns);
		$totalcolms = mysql_num_rows($dbcolmns);
	
		$degree=$deg;
	
		#getting the number of credits to be studied							
		if ($checkcombin=='on'){
			$combin = addslashes($_POST['combin']);
		
			$mysql = mysql_query("SELECT * FROM coursecountprogramme WHERE ProgrammeID='$deg' AND Combination='$combin' 
								AND YearofStudy='$yearofstudy' AND AYear='$year'");
			}
		else{
			$mysql = mysql_query("SELECT * FROM coursecountprogramme WHERE ProgrammeID='$deg' AND YearofStudy='$yearofstudy' 
							AND AYear='$year'");
			}
	
		$semx = 0;					
		while($mysq = mysql_fetch_array($mysql)){
			$semx = $semx + $mysq['CourseCount'];
		}
	
		# Print Report header	
		$rpttitle='Overall Summary of Examinations Results';
		$objPHPExcel->getActiveSheet()->mergeCells('A1:AN1');
		$objPHPExcel->getActiveSheet()->mergeCells('A2:AN2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:AN3');
		if ($checkcombin=='on'){
			$combin = addslashes($_POST['combin']);
			$objPHPExcel->setActiveSheetIndex(0)
			    ->setCellValue('A1', strtoupper($org))
			    ->setCellValue('A2', $rpttitle)
			    ->setCellValue('A3', $year.' - '.'['.$class.'] - '.$programme.' - ['.$combin.']');
		}else{
			$objPHPExcel->setActiveSheetIndex(0)
			    ->setCellValue('A1', strtoupper($org))
			    ->setCellValue('A2', $rpttitle)
			    ->setCellValue('A3', $year.' - '.'['.$class.'] - '.$programme);
		}
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20); 
		$objPHPExcel->getActiveSheet()->getStyle('A2:A3')->getFont()->setSize(16); 
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(26);
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(26);
		$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(26);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
		$colm = "A";
		$rows = 4;
		$rows1 = $rows +1;
	
		$objPHPExcel->getActiveSheet()->getStyle('A4:BE5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		#Print Serial Number
		$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
					      ->getStyle($colm.$rows.':'.$colm.$rows1)->applyFromArray($styleArray);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, '#');
		$colm++; 	    
	
		#Print Sex
		$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
					      ->getStyle($colm.$rows.':'.$colm.$rows1)->applyFromArray($styleArray);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'Name'); 
		$colm++; 
	
		#Print RegNo
		$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
					      ->getStyle($colm.$rows.':'.$colm.$rows1)->applyFromArray($styleArray);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'RegNo'); 
		$colm++; 
	
		$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
						->getStyle($colm.$rows.':'.$colm.$rows1)->applyFromArray($styleArray);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'SEX');
		$colm++;
		
		#query exam results sorted per years
		for($fy=$entry; $fy<=$current; $fy++)
		{
			$acyear = $acyear +1;
			$currentyear = $rowayear->AYear;
			
			$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
							->getStyle($colm.$rows.':'.$colm.$rows1)->getAlignment()->setTextRotation(90);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'CREDITS - '.$fy);
			#set row height to 74 points
			$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(74);
			
			$colm++;
	
			$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
							->getStyle($colm.$rows.':'.$colm.$rows1)->getAlignment()->setTextRotation(90);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'POINTS - '.$fy);
			$colm++;
	
			$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
							->getStyle($colm.$rows.':'.$colm.$rows1)->getAlignment()->setTextRotation(90);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'GPA - '.$fy);
			$colm++;
		}
			
		$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
						->getStyle($colm.$rows.':'.$colm.$rows1)->getAlignment()->setTextRotation(90);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'T.CREDITS');
		$colm++;
	
		$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
						->getStyle($colm.$rows.':'.$colm.$rows1)->getAlignment()->setTextRotation(90);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'T.POINTS');
		$colm++;
	
		$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
						->getStyle($colm.$rows.':'.$colm.$rows1)->getAlignment()->setTextRotation(90);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'T.GPA');
		$colm++;
	
		$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
						->getStyle($colm.$rows.':'.$colm.$rows1)->getAlignment()->setTextRotation(90);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'REMARK');
		$colm++;
		
		$objPHPExcel->getActiveSheet()->mergeCells($colm.$rows.':'.$colm.$rows1)
						->getStyle($colm.$rows.':'.$colm.$rows1)->getAlignment()->setTextRotation(90);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm.$rows, 'CLASSFICATIONS');
		$colm++;	
					
		$overallpasscount = 0;
		$overallsuppcount = 0;
		$overallinccount = 0;
		$overalldiscocount = 0;
		
		$qstudent = "SELECT Name, RegNo, Sex, DBirth, ProgrammeofStudy, Faculty, Sponsor, EntryYear, Status, Class 
					 FROM student WHERE (ProgrammeofStudy = '$prog') AND (EntryYear = '$cohotyear') ORDER BY Class, Name";
	
		$dbstudent = mysql_query($qstudent);
		$totalstudent = mysql_num_rows($dbstudent);
		$z=1;
		$rows = 6;
		while($rowstudent = mysql_fetch_array($dbstudent)) 
		{
	
			$colms = "A";
			$regno = $rowstudent['RegNo'];
			$name = stripslashes($rowstudent['Name']);			
			$sex = $rowstudent['Sex'];
			$bdate = $rowstudent['DBirth'];
			$comb = $rowstudent['Class'];
			$degree = stripslashes($rowstudent["ProgrammeofStudy"]);
			$faculty = stripslashes($rowstudent["Faculty"]);
			$sponsor = stripslashes($rowstudent["Sponsor"]);
			$entryyear = stripslashes($result['EntryYear']);
			$ststatus = stripslashes($rowstudent['Status']);

		
			#initialise
				$totalunit=0;
				$gmarks=0;
				$totalfailed=0;
				$totalinccount=0;
				$unittaken=0;
				$creditslost=0;
				$requiredcredits=0;
				$creditstaken=0;
				$optcredits=0;
				$extracreditstaken=0;
				$sgp=0;
				$totalsgp=0;
				$gpa=0;
				$pct=0;
				$chas=0;
				$ovgpa = '';
				$ptcs = '';
				$gpas = '';
				$gpa = '';
				$spoints = 0;
				$scredits = 0;
				$creditstaken=0;
				$totalsgp=0;
			
			# new values
				$totalfailed=0;
				$totalinccount=0;
				$halfsubjects=0;
				$ovremark='';
				$gmarks=0;
				$avg =0;
				$gmarks=0;	
				$decrement = 0;
				$credits = 0;
			
				$key = $regno; 			
		
			# Print results
		
			#Print Serial Number
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $z);
			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);
			$colms++; 
		
		
			#Print Serial Number
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $name);
			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);
			$colms++; 
		
		
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $regno);
			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);
			$colms++;
			
			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $sex);
			$colms++;
				
		   # start looping for the years
		    for($fy=$entry; $fy<=$current; $fy++)
		    {
		        #empty credits
			$creditstaken=0;				
			$totalunit=0;
			$unittaken=0;
			$sgp=0;
			$totalsgp=0;
			$gpa=0;
			$ray=$fy+1;
			$resultyear=$fy.'/'.$ray;
			# search for course results and prints	
			$qcourselist = "SELECT DISTINCT CourseCode FROM examresult WHERE  (RegNo='$regno') AND (AYear='$resultyear')";
			$dbcourselist = mysql_query($qcourselist);
					
			if ($checkwh=='on')
				{
					# check if paid
					//$regno=$RegNo;
					#initialise billing values
					$grandtotal=0;
					$feerate=0;
					$invoice=0;
					$paid=0;
					$debtorlimit=0;
					$tz103=0;
					$amount=0;
					$subtotal=0;
					$cfee=0;
					//include('../billing/includes/getgrandtotalpaid.php');
				}
				while($row_courselist = mysql_fetch_array($dbcourselist)) 
				{ 
					$course= $row_courselist['CourseCode'];
					$coption = $row_courselist['Status']; 
					$qcoursestd="SELECT Units, Department, StudyLevel FROM course WHERE CourseCode = '$course'";	
					$dbcoursestd = mysql_query($qcoursestd);
					$row_coursestd = mysql_fetch_array($dbcoursestd);
					$unit       = $row_coursestd['Units'];
					$studylevel = $row_coursestd['StudyLevel'];					
					$remarks = 'remarks';
					$RegNo = $key;
					$currentyear=$year;
					include '../academic/includes/compute_student_remark.php';
				}
				# Assign total credits
				$requiredcredits = $progcredits-$optcredits-$extracreditstaken;
			
				$curr_semester=$semval;
				include '../academic/includes/compute_overall_remark.php';

				#check failed exam
				if ($fexm=='#'){
					$fexm = ''; $remark ='';
				}
				#check failed exam
				if(($totalremarks>0)&&($studentremarks<>'')){
						#prints overall remarks
						/*
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $ovremark); 
						$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);
						*/
					$remark ='';
					$fexm = '';
					$fcwk = '';
					$fsup = ''; 
					$igrade = ''; 
					$egrade = ''; 
					$supp='';
				}
			else{
					#check for supp and inco
					$k =0;
					if ($ovremark=='SUPP:'){ 
						#
					}
				else{
					#prints overall remarks
					}
				}

			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $unittaken);
			$colms++;

			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);		
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $totalsgp);
			$colms++;
			
			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);		
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, substr($gpa,0,4));
			$colms++;
			
			#commulate credits
			$scredits=$scredits+$unittaken;
			$spoints=$spoints+$totalsgp;
			$annualUnits = $annualUnits+$unittaken;
			$annualPoints = $annualPoints+$totalsgp;
			
 		} #for loops ends
 			#calculate gpa
 			if ($scredits>0){
 				$ovgpa=$spoints/$scredits;
 			}
 			$ovgpa=number_format($ovgpa,1, '.', ' ');
 		
			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);		
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $scredits);
			$colms++;

			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);		
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $spoints);
			$colms++;
			
			$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);		
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $ovgpa);
			$colms++;			
			
			if(($gpas[1] == '0' || $gpas[2] == '0') && ($ptcs[1] == '0' || $ptcs[2] == '0')){
				$remark = 'ABSC';
				}
			elseif($ovgpa < 2){
				$remark = 'DISCO';
				}		
			else{
				$remark = 'PASS';
				}
			
				if($remark == 'DISCO'){
						$objPHPExcel->getActiveSheet()->getStyle($colms--.$rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle($colms--.$rows)->getFill()->getStartColor()->setARGB('FFFF0000');					
						$objPHPExcel->getActiveSheet()->getStyle($colms--.$rows)->applyFromArray($styleArray);					
					}
				
				elseif($remark == 'PASS'){
					#if pass then clean sheet					
					}
				elseif($remark == 'ABSC'){
						$objPHPExcel->getActiveSheet()->getStyle($colms--.$rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);					
						$objPHPExcel->getActiveSheet()->getStyle($colms--.$rows)->getFill()->getStartColor()->setARGB('CCCCCC');
						$objPHPExcel->getActiveSheet()->getStyle($colms--.$rows)->applyFromArray($styleArray);					
					}
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $remark);
				$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);
				$colms++;
			
			
			#specify degree classification
			$avgGPA=$ovgpa;
			if($avgGPA>=4.4){
					$degreeclass = 'First Class';
				}elseif($avgGPA>=3.5){
					$degreeclass = 'Upper Second Class';
				}elseif($avgGPA>=2.7){
					$degreeclass = 'Lower Second Class';
				}elseif($avgGPA>=2.0){
					$degreeclass = 'Pass';
				}else{
					$degreeclass = 'FAIL';
				}
								
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colms.$rows, $degreeclass);
				$objPHPExcel->getActiveSheet()->getStyle($colms.$rows)->applyFromArray($styleArray);
			
			$rows++;					
			$z=$z+1;		
	 	}


	// Rename 3rd sheet
	$objPHPExcel->getActiveSheet()->setTitle('Graduates Report');
	}
	
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="SARIS_Exam_Results.xls"');
	header('Cache-Control: max-age=0');
	#make pdf
	/*
	header('Content-Type: application/pdf');
	header('Content-Disposition: attachment;filename="SARIS_Exam_Results.pdf"');
	header('Cache-Control: max-age=0');
	*/
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	#make pdf
	// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
$objWriter->save('php://output');
exit;
