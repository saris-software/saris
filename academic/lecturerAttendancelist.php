<?php
#flag report
$rpttype ='attendlist';
#start html
if (isset($_POST['HTML']) && ($_POST['HTML'] == "Print HTML")){
	
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Attendance List';
	$szTitle = 'Printing Attendance List Report';
	include('lecturerheader.php');
	include '../academic/includes/print_html_attendance_list.php';
	include('../footer/footer.php');
	/*
	# file name for download 
	$filename = "SARIS_Results_" . date('Ymd') . ".xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel"); 
   */
	exit;
}elseif(isset($_POST['PDF']) && ($_POST['PDF'] == "Print PDF"))
{
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php');
	include('includes/PDF.php');

	#get post values
	$year = addslashes($_POST['cohot']);
	$degree = addslashes($_POST['degree']);
	$list = 2;//addslashes($_POST['list']);
	$faculty = addslashes($_POST['faculty']);
	$checkdegree = addslashes($_POST['checkdegree']);
	$checkyear = addslashes($_POST['checkyear']);
	$checkdept = addslashes($_POST['checkdept']);
	$checkcohot = addslashes($_POST['checkcohot']);
	$checkrem = addslashes($_POST['checkrem']);
	$checkbill = addslashes($_POST['checkbill']);
	$ovr = addslashes($_POST['ovrm']);
             
	#calculate year of study
	$entry = intval(substr($year,0,4));
	$current = intval(substr($cyear,0,4));
	$yearofstudy=$current-$entry;

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
	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
	$dborg = mysql_query($qorg);
	$row_org = mysql_fetch_assoc($dborg);
	$org = $row_org['Name'];
	$address = $row_org['Address'];
	$phone = $row_org['tel'];
	$fax = $row_org['fax'];
	$email = $row_org['email'];
	$website = $row_org['website'];
	$city = $row_org['city'];

	$display=2;

	#get programme name
	$qprogram = "SELECT ProgrammeName FROM programme WHERE ProgrammeCODE ='$degree'";
	$dbprogram = mysql_query($qprogram);
	$row_program = mysql_fetch_assoc($dbprogram);
	$pname = $row_program['ProgrammeName'];

	#create grouplist tiltes
	if($list==1){
	$listitle = 'OF ALL STUDENTS';
	}elseif($list==2){
	$listitle = $pname;
	}else{
	$listitle = $faculty;
	}

		$pdf = &PDF::factory('p', 'a4');      // Set up the pdf object. 
		$pdf->open();                         // Start the document. 
		$pdf->setCompression(true);           // Activate compression. 
		$pdf->addPage();  

		#put page header
		$x=50;
		$y=210;
		$n=1;
		$pg=1;
		
		//$i=1;
		#count unregistered
		$j=0;
		#count sex
		$$fmcount = 0;
		$$mcount = 0;
		$$fcount = 0;
		
		#print header
		$pdf->image('../images/logo.jpg', 248, 50);   
		$pdf->setFont('Arial', 'I', 8);     
		$pdf->text(530.28, 825.89, 'Page '.$pg);   
		$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   

		$pdf->setFont('Arial', 'B', 23);     
		$pdf->setFillColor('rgb', 0, 0, 0);   
		$pdf->text(66, 50, strtoupper($org));   
		$pdf->setFillColor('rgb', 0, 0, 0);  
		
		#University Addresses
		$pdf->setFont('Arial', '', 11.3);     
		$pdf->text(95, 80, 'Phone: '.$phone);   
		$pdf->text(95, 99, 'Fax: '.$fax);  
		$pdf->text(95, 121, 'Email: '.$email);   
		$pdf->text(370, 80, strtoupper($address));   
		$pdf->text(370, 99, strtoupper($city));   
		$pdf->text(370, 121, $website);   
		
		$pdf->setFillColor('rgb', 0, 0, 0);   
		$pdf->setFont('Arial', '', 13);     
		$pdf->text(174, 193, $ovr.' - '.$class.' - '.strtoupper($listitle).' - ATTENDANCE LIST'); 
		$pdf->setFillColor('rgb', 0, 0, 0); 
		
		$pdf->setFillColor('rgb', 0, 0, 0);   
		$pdf->setFont('Arial', 'B', 10);    
		$pdf->setFillColor('rgb', 0, 0, 0);   
	 

		$pdf->text($x, $y, 'S/N'); 
		$pdf->text($x+38, $y, 'Name'); 
		$pdf->text($x+170, $y, 'RegNo'); 
		$pdf->text($x+238, $y, 'Sex'); 
		if ($checkbill<>'on'){ 
		$pdf->text($x+260, $y, 'Remarks');
		$pdf->text($x+310, $y, 'Invoice'); 
		$pdf->text($x+380, $y, 'Paid'); 
		$pdf->text($x+460, $y, 'Balance'); 
		}
		$pdf->setFont('Arial', '', 8.6); 
		
		$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
		$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
		$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
		$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
		$pdf->line($x+168, $y-15, $x+168, $y+3);              // most left side margin. 
		$pdf->line($x+236, $y-15, $x+236, $y+3);              // most left side margin. 
		$pdf->line($x+258, $y-15, $x+258, $y+3); 
		if ($checkbill<>'on'){ 
		$pdf->line($x+306, $y-15, $x+306, $y+3);  
		$pdf->line($x+374, $y-15, $x+374, $y+3); 
		$pdf->line($x+458, $y-15, $x+458, $y+3);             // most left side margin. 
		}
		$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
				
		$sqlstd = "SELECT student.Id,
			   student.Name,
			   student.RegNo,
			   student.Sex,
			   student.Faculty,
			   student.EntryYear,
			   student.Sponsor,
			   student.Status,
			   student.ProgrammeofStudy
			FROM student
			WHERE 
				 (
					(student.EntryYear='$year') AND 
					(student.ProgrammeofStudy = '$degree') AND
					(student.ProgrammeofStudy <> '10103')
				 )
					ORDER BY  student.Name";
	
		$querystd = mysql_query($sqlstd);
		
		while($result = mysql_fetch_array($querystd)) 
		{
			$Name = stripslashes($result["Name"]);
			$RegNo = stripslashes($result["RegNo"]);
			$sex = stripslashes($result["Sex"]);
			$degree = stripslashes($result["ProgrammeofStudy"]);
			$faculty = stripslashes($result["Faculty"]);
			//$sponsor = stripslashes($result["Sponsor"]);
			$entryyear = stripslashes($result['EntryYear']);
			$ststatus = stripslashes($result['Status']);
			
			#compute year of study
			$current_yeartranc = substr($cyear,0,4);
			$entryyear = substr($entryyear,0,4);
			$yearofstudy=$current_yeartranc-$entryyear+1;
		
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
			
			$regno=$RegNo;
			include('../billing/includes/getgrandtotalpaid.php');
		
			if($due<=$debtorlimit){
				#check overall remarks
				# get all courses for this candidate
				$qcourse_total="SELECT CourseCode FROM courseprogramme WHERE  (ProgrammeID='$degree') AND (YearofStudy='$yearofstudy') 
							ORDER BY CourseCode";
				$dbcourse_total = mysql_query($qcourse_total);
				#initialise all values
				$subjecttaken=0;
				$totalfailed=0;
				$totalinccount=0;
				$halfsubjects=0;
				$overalldiscocount=0;
				$overallpasscount=0;
				$overallinccount=0;
				$overallsuppcount=0;
				$ovremark='';
				$gmarks=0;
				$avg =0;
				$gmarks=0;
				
				while($row_course_total = mysql_fetch_array($dbcourse_total)){
					$RegNo=$regno;
					$currentyear=$cyear;
					$course= $row_course_total['CourseCode'];
					include '../academic/includes/compute_student_remark.php';
				}
					#computer overall remarks
					$degree = $deg;
					include '../academic/includes/compute_overall_remark.php';
			
				$x=50;

				if($checkrem=='on'){
					if($ovr=='ALL'){
						 if(($ovremark=='PASS')||($ovremark=='SUPP:')||($ovremark=='INCO')){
								$pdf->text($x+1, $y+15, $n); 
								$stname = explode(',',$Name);
								$pdf->text($x+36, $y+15, strtoupper(stripslashes($stname[0])).', '.ucwords(strtolower(stripslashes($stname[1])))); 
								$pdf->text($x+169, $y+15, $RegNo); 
								$pdf->text($x+241, $y+15, $sex); 
								if ($checkbill<>'on'){ 
								if ($ovremark=='SUPP:'){
									$ovremark='SUPP';
									$pdf->text($x+260, $y+15, $ovremark); 
								}else{
									$pdf->text($x+260, $y+15, $ovremark); 
								}
								$pdf->text($x+310, $y+15, number_format($invoice,2,'.',',')); 
								$pdf->text($x+379, $y+15, number_format($paid,2,'.',','));
								$pdf->text($x+460, $y+15, number_format($due,2,'.',','));  
								}
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
								$pdf->line($x+236, $y-15, $x+236, $y+3); 
								$pdf->line($x+258, $y-15, $x+258, $y+3); 
								if ($checkbill<>'on'){ 
								$pdf->line($x+306, $y-15, $x+306, $y+3);  
								$pdf->line($x+374, $y-15, $x+374, $y+3); 
								$pdf->line($x+458, $y-15, $x+458, $y+3);             // most left side margin. 
								}
								$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
						}
					}else{
						if($ovremark==$ovr){
								$pdf->text($x+1, $y+15, $n); 
								$stname = explode(',',$Name);
								$pdf->text($x+36, $y+15, strtoupper(stripslashes($stname[0])).', '.ucwords(strtolower(stripslashes($stname[1])))); 
								$pdf->text($x+169, $y+15, $RegNo); 
								if ($checkbill<>'on'){ 
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
								}
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
								if ($checkbill<>'on'){ 
								$pdf->line($x+306, $y-15, $x+306, $y+3);  
								$pdf->line($x+374, $y-15, $x+374, $y+3); 
								$pdf->line($x+458, $y-15, $x+458, $y+3);             // most left side margin. 
								}
								$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 			
		       			}
					}
	 			    if ($y>800){
						#put page header
						$pdf->addPage();  
						$x=50;
						$y=80;
						$pg=$pg+1;
						$pdf->setFont('Arial', 'I', 8); 
						$pdf->text(530.28, 828.89, 'Page '.$pg);   
						$pdf->text(50, 828.89, 'Printed On '.$today = date("d-m-Y H:i:s"));
						
						#print header
						$pdf->setFont('Arial', '', 13);     
						$pdf->text(174, 60, $ovr.' - '.$year.' - '.strtoupper($listitle).'- ATTENDANCE LIST'); 
						$pdf->setFillColor('rgb', 0, 0, 0); 
				
						$pdf->setFillColor('rgb', 0, 0, 0);   
						$pdf->setFont('Arial', 'B', 10);    
						$pdf->setFillColor('rgb', 0, 0, 0);   
					 
						$pdf->text($x, $y, 'S/N'); 
						$pdf->text($x+38, $y, 'Name'); 
						$pdf->text($x+170, $y, 'RegNo'); 
						$pdf->text($x+238, $y, 'Sex'); 
						if ($checkbill<>'on'){ 
						$pdf->text($x+260, $y, 'Remarks'); 
						$pdf->text($x+310, $y, 'Invoice'); 
						$pdf->text($x+380, $y, 'Paid'); 
						$pdf->text($x+460, $y, 'Balance');
						} 
						$pdf->setFont('Arial', '', 8.6); 
						
						$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
						$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
						$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
						$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
						$pdf->line($x+168, $y-15, $x+168, $y+3);              // most left side margin. 
						$pdf->line($x+236, $y-15, $x+236, $y+3);              // most left side margin. 
						if ($checkbill<>'on'){ 
						$pdf->line($x+258, $y-15, $x+258, $y+3); 
						$pdf->line($x+306, $y-15, $x+306, $y+3);  
						$pdf->line($x+374, $y-15, $x+374, $y+3); 
						$pdf->line($x+458, $y-15, $x+458, $y+3);             // most left side margin. 
						}
						$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
					}
				}
			}else{
				#print with held results
							#check overall remarks
				# get all courses for this candidate
				$qcourse_total="SELECT CourseCode FROM courseprogramme WHERE  (ProgrammeID='$degree') AND (YearofStudy='$yearofstudy') 
							ORDER BY CourseCode";
				$dbcourse_total = mysql_query($qcourse_total);
				#initialise all values
				$subjecttaken=0;
				$totalfailed=0;
				$totalinccount=0;
				$halfsubjects=0;
				$overalldiscocount=0;
				$overallpasscount=0;
				$overallinccount=0;
				$overallsuppcount=0;
				$ovremark='';
				$gmarks=0;
				$avg =0;
				$gmarks=0;
				
				
				while($row_course_total = mysql_fetch_array($dbcourse_total)){
					$RegNo=$regno;
					$currentyear=$cyear;
					include '../academic/includes/compute_student_remark.php';
				}
				#computer overall remarks
					include '../academic/includes/compute_overall_remark.php';
			
				$x=50;

				if($checkrem=='on'){
					if($ovr=='WITHHELD'){
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
						}
					}
	 			    if ($y>800){
						#put page header
						$pdf->addPage();  
						$x=50;
						$y=80;
						$pg=$pg+1;
						$pdf->setFont('Arial', 'I', 8); 
						$pdf->text(530.28, 828.89, 'Page '.$pg);   
						$pdf->text(50, 828.89, 'Printed On '.$today = date("d-m-Y H:i:s"));
						
						#print header
						$pdf->setFont('Arial', '', 13);     
						$pdf->text(174, 60, $ovr.' - '.$year.' - '.strtoupper($listitle).'- ATTENDANCE LIST'); 
						$pdf->setFillColor('rgb', 0, 0, 0); 
				
						$pdf->setFillColor('rgb', 0, 0, 0);   
						$pdf->setFont('Arial', 'B', 10);    
						$pdf->setFillColor('rgb', 0, 0, 0);   
					 
						$pdf->text($x, $y, 'S/N'); 
						$pdf->text($x+38, $y, 'Name'); 
						$pdf->text($x+170, $y, 'RegNo'); 
						$pdf->text($x+238, $y, 'Sex'); 
						$pdf->text($x+260, $y, 'Remarks'); 
						$pdf->text($x+310, $y, 'Invoice'); 
						$pdf->text($x+380, $y, 'Paid'); 
						$pdf->text($x+460, $y, 'Balance'); 
						$pdf->setFont('Arial', '', 8.6); 
						
						$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
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
					}
				}			
			}
    		$pdf->setFillColor('rgb', 0, 0, 0);
			$gt=$n-1;
			$pdf->text(50, $y+20, 'Grand Total: '.$gt);  
            if ($gt<>0){
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
            }

			 #output file
			 $filename = ereg_replace("[[:space:]]+", "",$degree);
			 $pdf->output($filename.'.pdf');
			 
}else{
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Attendance List';
	$szTitle = 'Printing Semester Attendance List Report';
	include('lecturerheader.php');
$editFormAction = $_SERVER['PHP_SELF'];

mysql_select_db($database_zalongwa, $zalongwa);
$query_studentlist = "SELECT RegNo, Name, ProgrammeofStudy FROM student ORDER BY ProgrammeofStudy  ASC";
$studentlist = mysql_query($query_studentlist, $zalongwa) or die(mysql_error());
$row_studentlist = mysql_fetch_assoc($studentlist);
$totalRows_studentlist = mysql_num_rows($studentlist);

mysql_select_db($database_zalongwa, $zalongwa);
$query_degree = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$degree = mysql_query($query_degree, $zalongwa) or die(mysql_error());
$row_degree = mysql_fetch_assoc($degree);
$totalRows_degree = mysql_num_rows($degree);

mysql_select_db($database_zalongwa, $zalongwa);
$query_sem = "SELECT Semester FROM terms ORDER BY Semester Limit 2";
$sem = mysql_query($query_sem, $zalongwa) or die(mysql_error());
$row_sem = mysql_fetch_assoc($sem);
$totalRows_sem = mysql_num_rows($sem);

mysql_select_db($database_zalongwa, $zalongwa);
$query_dept = "SELECT Faculty, DeptName FROM department ORDER BY DeptName, Faculty ASC";
$dept = mysql_query($query_dept, $zalongwa) or die(mysql_error());
$row_dept = mysql_fetch_assoc($dept);
$totalRows_dept = mysql_num_rows($dept);
	

$prog=$_POST['degree'];
$cohotyear = $_POST['cohot'];
$ayear = $_POST['ayear'];
$qprog= "SELECT ProgrammeCode, Title FROM programme WHERE ProgrammeCode='$prog'";
$dbprog = mysql_query($qprog);
$row_prog = mysql_fetch_array($dbprog);
$progname = $row_prog['Title'];
$qyear= "SELECT AYear FROM academicyear WHERE AYear='$cohotyear'";
$dbyear = mysql_query($qyear);
$row_year = mysql_fetch_array($dbyear);
$year = $row_year['AYear'];

?>

<form name="form1" method="post" action="<?php echo $editFormAction ?>">
            <div align="center">
			<table width="200" border="0" bgcolor="#CCCCCC">
            <tr>
                  <td colspan="3"><span class="style61">if you want to filter the results by  criteria <span class="style34">Tick the corresponding check box first</span> then select appropriately </span></td>
                </tr>
                <tr>
                  <td nowrap><input name="checkdegree" type="checkbox" id="checkdegree" value="on"></td>
                  <td nowrap><div align="left">Degree Programme:</div></td>
                  <td>
                      <div align="left">
                        <select name="degree" id="degree">
                          <?php
do {  
?>
                          <option value="<?php echo $row_degree['ProgrammeCode']?>"><?php echo $row_degree['ProgrammeName']?></option>
                          <?php
} while ($row_degree = mysql_fetch_assoc($degree));
  $rows = mysql_num_rows($degree);
  if($rows > 0) {
      mysql_data_seek($degree, 0);
	  $row_degree = mysql_fetch_assoc($degree);
  }
?>
                        </select>
                    </div></td></tr>
                <tr>
                  <td><input name="checkcohot" type="checkbox" id="checkcohot" value="on"></td>
                  <td nowrap><div align="left">Cohort of the  Year: </div></td>
                  <td><div align="left">
						<select name="cohot" id="cohot">
                        <?php
								mysql_select_db($database_zalongwa, $zalongwa);
								$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
								$ayear = mysql_query($query_ayear, $zalongwa);
								$row_ayear = mysql_fetch_assoc($ayear);
								$totalRows_ayear = mysql_num_rows($ayear);                       
							do {  
							?>
							<option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
							  <?php
							} while ($row_ayear = mysql_fetch_assoc($ayear));
							  $rows = mysql_num_rows($ayear);
							  if($rows > 0) {
							      mysql_data_seek($ayear, 0);
								  $row_ayear = mysql_fetch_assoc($ayear);
							  }
							?>
                    </select>
                  </div></td>
                </tr>

            	<tr>
                  <td><input name="checkyear" type="checkbox" id="checkyear" value="on"></td>
                  <td nowrap><div align="left">Results of the  Year: </div></td>
                  <td><div align="left">
                    <select name="ayear" id="ayear">
                        <?php
								mysql_select_db($database_zalongwa, $zalongwa);
								$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
								$ayear = mysql_query($query_ayear, $zalongwa);
								$row_ayear = mysql_fetch_assoc($ayear);
								$totalRows_ayear = mysql_num_rows($ayear);                       
							do {  
							?>
							<option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
							  <?php
							} while ($row_ayear = mysql_fetch_assoc($ayear));
							  $rows = mysql_num_rows($ayear);
							  if($rows > 0) {
							      mysql_data_seek($ayear, 0);
								  $row_ayear = mysql_fetch_assoc($ayear);
							  }
							?>
                    </select>
                  </div></td>
                </tr>     	

         <tr>
                  <td><input name="checksem" type="checkbox" id="checksem" value="on"></td>
                  <td nowrap><div align="left">Semester: </div></td>
                  <td><div align="left">
                    <select name="sem" id="sem">
                        <?php
mysql_select_db($database_zalongwa, $zalongwa);
$query_sem = "SELECT Semester FROM terms ORDER BY Semester Limit 2";
$sem = mysql_query($query_sem, $zalongwa) or die(mysql_error());
$row_sem = mysql_fetch_assoc($sem);
$totalRows_sem = mysql_num_rows($sem);
do {  
?>
                        <option value="<?php echo $row_sem['Semester']?>"><?php echo $row_sem['Semester']?></option>
                        <?php
} while ($row_sem = mysql_fetch_assoc($sem));
  $rows = mysql_num_rows($sem);
  if($rows > 0) {
      mysql_data_seek($sem, 0);
	  $row_sem = mysql_fetch_assoc($sem);
  }
?>
                    </select>
                  </div></td>
                </tr>
            	<tr>
                  <td><input name="checkrem" type="checkbox" id="checkrem" value="on"></td>
                  <td nowrap><div align="left">Overall Remarks </div></td>
                 
                 <td><div align="left">
                    <select name="ovrm" id="ovrm">
                       <option value="ALL">Print All</option>
                       <option value="PASS">PASS</option>
                       <option value="SUPP:">SUPP</option>
                       <option value="INCO">INCOMPLETE</option>
                       <option value="WITHHELD">WITH HELD</option>
                     </select>
                  </div>
                  </td>
                </tr>
               	<tr>
	                  <td><input name="checkrem" type="checkbox" id="checkrem" value="on"></td>
	                  <td colspan="3" nowrap><div align="left">Hide Billing Values </div></td>
	                  <td><div align="left">
	                  </div></td>
	                </tr> 
                <tr>
	                  <td colspan="2"><div align="center">
	                    <input type="submit" name="PDF"  id="PDF" value="Print PDF">
	                  </div></td>
	                  <td colspan="1"><div align="center">
	                    <input type="submit" name="HTML"  id="HTML" value="Print HTML">
	                  </div></td>
	              </tr>
              </table>
              <input name="MM_update" type="hidden" id="MM_update" value="form1">       
  </div>
</form>
<?php
}
include('../footer/footer.php');
?>
