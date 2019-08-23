<?php 
#start pdf
if (isset($_POST['PrintPDF']) && ($_POST['PrintPDF'] == "Print PDF")) {
	#get post variables
	$rawkey = addslashes(trim($_POST['key']));
	$key = preg_replace("[[:space:]]+", " ",$rawkey);
	#get content table raw height
	$rh= addslashes(trim($_POST['sex']));
	$temp= addslashes(trim($_POST['temp']));
	$award= addslashes(trim($_POST['award']));
	$realcopy= addslashes(trim($_POST['real']));
	
	#CONVERT NTA LEVEL
	if($award==1){
		$ntalevel='NTA LEVEL 8';
	}elseif($award==6){
		$ntalevel='NTA LEVEL 7';
		$award=1;
	}elseif($award==2){
		$ntalevel='NTA LEVEL 6';
	}elseif($award==3){
		$ntalevel='NTA LEVEL 5';
	}elseif($award==4){
		$ntalevel='NTA LEVEL 4';
	}elseif($award==5){
		$ntalevel='Short Course';
	}
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php');
	# check if is a trial print
	if($realcopy==1){
		$copycount = 'TRIAL COPY';
	}
	#check if is a reprint
	$qtranscounter = "SELECT RegNo, received FROM transcriptcount where RegNo='$key'";
	$dbtranscounter = mysqli_query($zalongwa,$qtranscounter);
	@$transcounter = mysqli_num_rows($dbtranscounter);
	
	if ($transcounter>0){
		$row_transcounter = mysqli_fetch_array($dbtranscounter);
		$lastprinted = $row_result['received'];
	}
	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
	$dborg = mysqli_query($zalongwa,$qorg);
	$row_org = mysqli_fetch_assoc($dborg);
	$org = $row_org['Name'];
	$post = $row_org['Address'];
	$phone = $row_org['tel'];
	$fax = $row_org['fax'];
	$email = $row_org['email'];
	$website = $row_org['website'];
	$city = $row_org['city'];

	include('includes/PDF.php');

	$i=0;
	$pg=1;
	$tpg =$pg;

	$qstudent = "SELECT * from student WHERE regno = '$key'";
	$dbstudent = mysqli_query($zalongwa,$qstudent);
	$row_result = mysqli_fetch_array($dbstudent);
		$sname = $row_result['Name'];
		$regno = $row_result['RegNo'];
		$degree = $row_result['ProgrammeofStudy'];
		$sex = $row_result['Sex'];
		$dbirth = $row_result['DBirth'];
		$entry = $row_result['EntryYear'];
		$citizen = $row_result['Nationality'];
		$address = $row_result['Address'];
		$gradyear = $row_result['GradYear'];
		$admincriteria = $row_result['MannerofEntry'];
		$campusid = $row_result['Campus'];
		$subjectid = $row_result['Subject'];
		$photo = $row_result['Photo'];
		$checkit = strlen($photo);
		#get campus name
		$qcampus = "SELECT * FROM campus where CampusID='$campusid'";
		$dbcampus = mysqli_query($zalongwa,$qcampus);
		$row_campus= mysqli_fetch_assoc($dbcampus);
		$campus = $row_campus['Campus'];
		
		if ($checkit > 8){
			include '../includes/photoformat.php';
		}else{
			$nophoto = 1;
		}
		#get degree name
		$qdegree = "Select Title, Faculty FROM programme WHERE ProgrammeCode = '$degree'";
		$dbdegree = mysqli_query($zalongwa,$qdegree);
		$row_degree = mysqli_fetch_array($dbdegree);
		$programme = $row_degree['Title'];
		$faculty = $row_degree['Faculty'];
		
		#get subject combination
		$qsubjectcomb = "SELECT SubjectName FROM subjectcombination WHERE SubjectID='$subjectid'";
		$dbsubjectcom = mysqli_query($zalongwa,$qsubjectcomb);
		$row_subjectcom = mysqli_fetch_assoc($dbsubjectcom);
		$counter = mysqli_num_rows($dbsubjectcom );
		if ($counter>0){
		$subject = $row_subjectcom['SubjectName'];
		}

	//require 'PDF.php';                    // Require the lib. 
	$pdf = &PDF::factory('p', 'a4');      // Set up the pdf object. 
	$pdf->open();                         // Start the document. 
	$pdf->setCompression(true);           // Activate compression. 
	$pdf->addPage();  
	
	#include transcript address
	include 'includes/transtemplate.php';
	
	$ytitle = $yadd+72;
	$pdf->setFillColor('rgb', 1, 0, 0);   
	$pdf->setFont('Arial', '', 10); 
  
	$pdf->text(140, $ytitle, 'TRANSCRIPT OF EXAMINATIONS RESULTS'); 
	$pdf->setFillColor('rgb', 0, 0, 0);    

	#title line
	$pdf->line(50, $ytitle+3, 570, $ytitle+3);

	$pdf->setFont('Arial', 'B', 10.3);     
	#set page header content fonts
	#line1
	$pdf->line(50, $ytitle+3, 50, $ytitle+15);       
	$pdf->line(333, $ytitle+3, 333, $ytitle+15);       
	$pdf->line(382, $ytitle+3, 382, $ytitle+15);
	$pdf->line(570, $ytitle+3, 570, $ytitle+15);       
	$pdf->line(50, $ytitle+15, 570, $ytitle+15); 
	#format name
	$candname = explode(",",$sname);
	$surname = $candname[0];
	$othername = $candname[1];

	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(52, $ytitle+13, 'NAME:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(92, $ytitle+13, strtoupper($surname).', '.ucwords(strtolower($othername))); 
	$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text(335, $ytitle+13, 'SEX:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(365, $ytitle+13, $sex); 
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(385, $ytitle+13, 'RegNo.:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(432, $ytitle+13, $regno); 
	
	#line2
	$pdf->line(50, $ytitle+15, 50, $ytitle+27);       
	$pdf->line(188, $ytitle+15, 188, $ytitle+27);       
	$pdf->line(570, $ytitle+15, 570, $ytitle+27);       
	$pdf->line(50, $ytitle+27, 570, $ytitle+27); 
	
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(52, $ytitle+25, 'CITIZENSHIP:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(120, $ytitle+25, $citizen); 
	$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text(190, $ytitle+25, 'ADDRESS:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(252, $ytitle+25, $address); 
	#line3
	$pdf->line(50, $ytitle+27, 50, $ytitle+39);       
	$pdf->line(188, $ytitle+27, 188, $ytitle+39);       
	$pdf->line(383, $ytitle+27, 383, $ytitle+39);       
	$pdf->line(570, $ytitle+27, 570, $ytitle+39);       
	$pdf->line(50, $ytitle+39, 570, $ytitle+39); 
	
	#Format grad year
	$graddate = explode("-",$gradyear);
	$gradday = $graddate[2];
	$gradmon = $graddate[1];
	$grady = $graddate[0];

	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(52, $ytitle+37, 'BIRTH DATE:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(120, $ytitle+37, $dbirth); 
	$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text(190, $ytitle+37, 'ADMITTED:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(250, $ytitle+37, $entry); 
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(385, $ytitle+37, 'COMPLETED:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(456, $ytitle+37, $gradday.' - '.$gradmon.' - '.$grady); 
/*
	#line4
	$pdf->line(50, $ytitle+39, 50, $ytitle+51);       
	$pdf->line(570, $ytitle+39, 570, $ytitle+51);       
	$pdf->line(50, $ytitle+51, 570, $ytitle+51); 
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(50, $ytitle+49, 'ADMITTED ON THE BASIS OF:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(205, $ytitle+49, $admincriteria); 
	*/
	#line5
	$pdf->line(50, $ytitle+39, 50, $ytitle+51);       
	$pdf->line(310, $ytitle+39, 310, $ytitle+51);       
	$pdf->line(570, $ytitle+39, 570, $ytitle+51);       
	$pdf->line(50, $ytitle+51, 570, $ytitle+51); 

	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(52, $ytitle+49, 'CAMPUS:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(100, $ytitle+49, $campus); 
	$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text(312, $ytitle+49, 'DEPARTMENT:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(387, $ytitle+49, $faculty); 

	#line6
	$pdf->line(50, $ytitle+51, 50, $ytitle+63);       
	$pdf->line(570, $ytitle+51, 570, $ytitle+63);       
	$pdf->line(50, $ytitle+63, 570, $ytitle+63); 
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(52, $ytitle+61, 'NAME OF PROGRAMME:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(175, $ytitle+61, $programme); 

	#line7
	$pdf->line(50, $ytitle+63, 50, $ytitle+75);       
	$pdf->line(570, $ytitle+63, 570, $ytitle+75);       
	$pdf->line(50, $ytitle+75, 570, $ytitle+75); 
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(52, $ytitle+73, 'AWARDS LEVEL:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(175, $ytitle+73, $ntalevel); 
	
	$sub =$subjectid;
	if($sub<>0){
		#line7
		$pdf->line(50, $ytitle+75, 50, $ytitle+87);       
		$pdf->line(570, $ytitle+75, 570, $ytitle+87);       
		$pdf->line(50, $ytitle+87, 570, $ytitle+87); 
		$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(50, $ytitle+85, 'MAJOR STUDY AREA:'); $pdf->text(175, $ytitle+85,$subject); 
	}
	#initialize x and y
	$x=50;
	$y=$ytitle+83;
	#initialise total units and total points
	$annualUnits=0;
	$annualPoints=0;
	
	$yval=$y+33;
	$y=$y+33;

	#set page body content fonts
	$pdf->setFont('Arial', '', 9.5);     
	
	//query academeic year
	$qayear = "SELECT DISTINCT AYear FROM examresult WHERE RegNo = '$regno' and checked=1 ORDER BY AYear ASC";
	$dbayear = mysqli_query($zalongwa,$qayear);
	
	#query project
	/*
	$qproject = "SELECT ayear, thesis FROM thesis WHERE RegNo = '$key'";
	$dbproject = mysqli_query($zalongwa,$qproject);
	$row_project = mysqli_fetch_assoc($dbproject);
	$thesisresult = mysqli_num_rows($dbproject);
	$thesis = $row_project['thesis'];
	$thesisyear = $row_project['ayear'];
	*/
	#initialise ayear
	$acyear = 0;
	
	//query exam results sorted per years
	while($rowayear = mysqli_fetch_object($dbayear)){
		$acyear = $acyear +1;
		$currentyear = $rowayear->AYear;
		if ($temp ==2)
		{
			#use muchs sorting order by semester
			$query_examresult = "
					  SELECT DISTINCT course.CourseName, 
									  course.Units, 
									  course.StudyLevel, 
									  course.Department, 
									  examresult.CourseCode, 
									  examresult.Status 
					  FROM 
							course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
					  WHERE (examresult.RegNo='$regno') AND 
							(examresult.AYear = '$currentyear') AND 
							(examresult.Checked='1') 
				      ORDER BY examresult.AYear DESC, course.YearOffered";	
		}else
		{
			$query_examresult = "
					  SELECT DISTINCT course.CourseName, 
									  course.Units, 
									  course.StudyLevel, 
									  course.Department, 
									  examresult.CourseCode, 
									  examresult.Status 
					  FROM 
							course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
					  WHERE (examresult.RegNo='$regno') AND 
							(examresult.AYear = '$currentyear') AND 
							(examresult.Checked='1') 
					  ORDER BY examresult.AYear, examresult.coursecode ASC";	
		}

		$result = mysqli_query($zalongwa,$query_examresult);
		$query = @mysqli_query($zalongwa,$query_examresult);
		$dbcourseUnit = mysqli_query($zalongwa,$query_examresult);
		
		if (mysqli_num_rows($query) > 0){
				
						$totalunit=0;
						$unittaken=0;
						$sgp=0;
						$totalsgp=0;
						$gpa=0;
				#check if u need to sart a new page
				$blank=$y-12;
				$space = 820.89 - $blank;
				if ($space<150){
				#start new page
				$pdf->addPage();  
				
					$x=50;
					$yadd=50;
	
					$y=80;
					$pg=$pg+1;
					$tpg =$pg;
					#insert transcript footer
					include 'includes/transcriptfooter.php';
				}
				#create table header
				if($acyear==1){
					if ($award==3){
						$pdf->text($x, $y-$rh, 'EXAMINATIONS RESULTS: '.$rowayear->AYear);
					}else{
						if($temp==2){
						$pdf->text($x, $y-$rh, 'FIRST YEAR EXAMINATIONS RESULTS: '.$rowayear->AYear); 
						}else{
						$pdf->text($x, $y-$rh, 'FIRST YEAR EXAMINATIONS RESULTS: '.$rowayear->AYear); 
						}
					}
				}elseif($acyear==2){
					if($temp==2){
					$pdf->text($x, $y-$rh, 'SECOND YEAR EXAMINATIONS RESULTS: '.$rowayear->AYear); 
					}else{
					$pdf->text($x, $y-$rh, 'SECOND YEAR EXAMINATIONS RESULTS: '.$rowayear->AYear); 
					}
				}elseif($acyear==3){
					$pdf->text($x, $y-$rh, 'THIRD YEAR EXAMINATIONS RESULTS: '.$rowayear->AYear); 
				}elseif($acyear==4){
					$pdf->text($x, $y-$rh, 'FOURTH YEAR EXAMINATIONS RESULTS: '.$rowayear->AYear); 
				}elseif($acyear==5){
					$pdf->text($x, $y-$rh, 'FIFTH YEAR EXAMINATIONS RESULTS: '.$rowayear->AYear); 
				}elseif($acyear==6){
					$pdf->text($x, $y-$rh, 'SIXTH YEAR EXAMINATIONS RESULTS: '.$rowayear->AYear); 
				}elseif($acyear==7){
					$pdf->text($x, $y-$rh, 'SEVENTH YEAR EXAMINATIONS RESULTS: '.$rowayear->AYear); 
				}
				#check result tables to use
				if ($temp ==2)
				{
					#use muchs format
					include 'includes/muchs_result_tables.php';
				}else
				{
					#use udsm format
					$pdf->text($x+10, $y, 'Code'); 
					$pdf->text($x+70, $y, 'Module Name'); 
					$pdf->text($x+402, $y, 'Credits'); 
					$pdf->text($x+436, $y, 'Grade'); 
					$pdf->text($x+471, $y, 'Points'); 
					$pdf->text($x+499, $y, 'GPA'); 
					
					#calculate results
					$i=1;
					while($row_course = mysqli_fetch_array($dbcourseUnit)){
						$course= $row_course['CourseCode'];
						$unit = $row_course['Units'];
						$cname = $row_course['CourseName'];
						$coursefaculty = $row_course['Department'];
						$sn=$sn+1;
						$remarks = 'remarks';
						$grade='';
						/*
						#get specific ourse units
						$qcunits = "select Units from course where (course.Programme = '$degree') AND coursecode = '$course'";
						$dbcunits = mysql_query($qcunits);
						$count = mysql_num_rows($dbcunits);
						if ($count > 0) 
						{
							$unit = $row_cunits['Units'];
						}
						*/
						# grade marks
						$RegNo = $regno;
						include'includes/choose_studylevel.php';
							
							$coursecode = $course;
							
							#print results
							$pdf->text($x+3, $y+$rh, substr($coursecode,0,10)); 
							$pdf->text($x+55, $y+$rh, substr($cname,0,73)); 
							$pdf->text($x+413, $y+$rh, $unit); 
							$pdf->text($x+445, $y+$rh, $grade); 
							$pdf->text($x+477, $y+$rh, $sgp); 
							if ($grade=='I'){
								$gpacomp = 1;
							}elseif($grade=='F'){
								$gpacomp = 1;
							}
							#check if the page is full
							$x=$x;
							#draw a line
							$pdf->line($x, $y-$rh+2, 570.28, $y-$rh+2);        
							$pdf->line($x, $y-$rh+2, $x, $y);       
							$pdf->line(570.28, $y-$rh+2, 570.28, $y);      
							$pdf->line($x, $y-$rh+2, $x, $y+$rh+4);              
							$pdf->line(570.28, $y-$rh+2, 570.28, $y+$rh+4);      
							$pdf->line($x+498, $y-$rh+2, $x+498, $y+$rh+4);       
							$pdf->line($x+468, $y-$rh+2, $x+468, $y+$rh+4);     
							$pdf->line($x+434, $y-$rh+2, $x+434, $y+$rh+4);       
							$pdf->line($x+400, $y-$rh+2, $x+400, $y+$rh+4);       
							$pdf->line($x+53, $y-$rh+2, $x+53, $y+$rh+2); 
							#get space for next year
							$y=$y+$rh;
	
							if ($y>800){
								#put page header
								//include('PDFTranscriptPageHeader.inc');
								$pdf->addPage();  
	
								$x=50;
								$y=100;
								$pg=$pg+1;
								$tpg =$pg;
							#insert transcript footer
							include 'includes/transcriptfooter.php';
							}
							#draw a line
							$pdf->line($x, $y+$rh+2, 570.28, $y+$rh+2);       
							$pdf->line($x, $y-$rh+2, $x, $y+$rh+2); 
							$pdf->line(570.28, $y-$rh+2, 570.28, $y+$rh+2);      
							$pdf->line($x+498, $y-$rh+2, $x+498, $y+$rh+2);       
							$pdf->line($x+468, $y-$rh+2, $x+468, $y+$rh+2);       
							$pdf->line($x+434, $y-$rh+2, $x+434, $y+$rh+2);      
							$pdf->line($x+400, $y-$rh+2, $x+400, $y+$rh+2); 
							$pdf->line($x+53, $y-$rh+2, $x+53, $y+$rh+2);      
					  }//ends while loop
					  #check degree
					  //if(($degree==632)||($degree==633)||($degree==635)){
					  if ($gpacomp<>1){
							$pdf->setFont('Arial', 'BI', 9.5);     
							$pdf->text($x+2, $y+$rh+1, 'Sub-total');
							$pdf->text($x+413, $y+$rh+1, $unittaken); 
							$pdf->text($x+470, $y+$rh+1, $totalsgp); 
							$pdf->text($x+504, $y+$rh+1,@substr($totalsgp/$unittaken, 0,3)); 
							$pdf->setFont('Arial', '', 9.5); 
					  }
					  //}#end check degree   
				   } #end check result tables
						#check x,y values
						$y=$y+3.5*$rh;
						//$x=$y+22;
						if ($y==800){
							$pdf->addPage();  

							#put page header
							$x=50;
							$y=80;
							$pg=$pg+1;
							$tpg =$pg;
							#insert transcript content header
							include 'includes/transcriptheader.php';						}
						
	 }
						#get annual units and Points
						$annualUnits = $annualUnits+$unittaken;
						$annualPoints = $annualPoints+$totalsgp;

  }
	$avgGPA=@substr($annualPoints/$annualUnits, 0,3);
	#specify degree classification
	if ($award==1){
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
	}elseif($award==2){
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
	}elseif($award==3){
		if($avgGPA>=3.5){
				$degreeclass = 'First Class';
			}elseif($avgGPA>=3.0){
				$degreeclass = 'Second Class';
			}elseif($avgGPA>=2.0){
				$degreeclass = 'Pass';
			}else{
				$degreeclass = 'FAIL';
			}
	}
	$sblank=$y-20;
	$sspace = 820.89 - $sblank;
	if ($sspace<80){
			#start new page
			#put page header
			$pdf->addPage();  

			$x=50;
			$y=80;
			$pg=$pg+1;
			$tpg =$pg;
			#insert transcript footer
			include 'includes/transcriptfooter.php';
	}
	$sub =$subject;
	if($thesisresult>0){
		#print final year project title
		$pdf->line($x, $y-20, 570, $y-20); 
		$pdf->line($x, $y-20, $x, $y-8);       
		$pdf->line(570, $y-20, 570, $y-8);       
		$pdf->line($x, $y-8, 570, $y-8); 
		$pdf->setFont('Arial', 'B', 10.3);  $pdf->text($x+70, $y-10, 'Title of the Final Year Project/Independent Study/Thesis of '.$thesisyear);  
		
		$pdf->line($x, $y-8, $x, $y+4);       
		$pdf->line(570, $y-8, 570, $y+4);       
		$pdf->line($x, $y+4, 570, $y+4); 
		$pdf->setFont('Arial', 'I', 10.3); $pdf->text($x, $y+2, substr($thesis,0,107)); 
	}
	#print gpa
	
	//if(($degree==632)||($degree==633)||($degree==635)){
	if ($gpacomp<>1){
		$pdf->setFont('Arial', 'B', 10.3);  $pdf->text($x, $y+24, 'OVERALL G.P.A.:'); $pdf->text($x+95, $y+24, @substr($annualPoints/$annualUnits, 0,3));
		$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text($x+220, $y+24, 'CLASSIFICATION:'); $pdf->text($x+320, $y+24, $degreeclass);
		$pdf->line($x, $y+27, 570.28, $y+27); 
	}
	/*	
	}else{
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text($x, $y+24, 'OVERALL PERFORMANCE:'); $pdf->text($x+145, $y+24, 'PASS');
	$pdf->line($x, $y+27, 570.28, $y+27); 
	}
	*/
	$b=$y+27;
	if ($b<820.89){
	#print signature lines
	$pdf->text(59.28, $y+57, '.........................                        .........................................                            ................................');    						
	$pdf->text(60.28, $y+67, $signatory);    	
	}					
	$pdf->setFont('Arial', 'I', 8);      
	$pdf->text(50, 820.89, $city.', '.$today = date("d-m-Y H:i:s"));    
	#print the key index
	$pdf->setFont('Arial', 'I', 9); 
	$yind = $y+87;
	
	#check if there is enough printing area
	$indarea = 820.89-$yind;
	if ($indarea< 203){
			$pdf->addPage();  

			$x=50;
			$y=80;
			$pg=$pg+1;
			$tpg =$pg;
			$pdf->setFont('Arial', 'I', 8);     
			$pdf->text(530.28, 820.89, 'Page '.$pg);  
			$pdf->text(300, 820.89, $copycount);    
			$pdf->text(50, 820.89, $city.', '.$today = date("d-m-Y H:i:s")); 
			$yind = $y; 
    }
	
	include 'includes/transcriptkeys.php';
	#delete imgfile
	@unlink($imgfile); 
	#print the file
	$pdf->output($key.'.pdf');              // Output the 
}/*ends is isset*/
#ends pdf
#get connected to the database and verfy current session
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
# initialise globals
require_once('lecturerMenu.php');

# include the header
global $szSection, $szSubSection;
$szSection = 'Examination';
$szSubSection = 'Cand. Transcript';
$szTitle = 'Transcript of Examination Results';
require_once('lecturerheader.php');

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['search']) && ($_POST['search'] == "PreView")) {
#get post variables
$rawkey = $_POST['key'];
$key = preg_replace("[[:space:]]+", " ",$rawkey);

//select student
$qstudent = "SELECT * from student WHERE regno = '$key'";
$dbstudent = mysqli_query($zalongwa,$qstudent) or die("Mwanafunzi huyu hana matokeo".  mysqli_error($zalongwa));
$row_result = mysqli_fetch_array($dbstudent);
			$name = $row_result['Name'];
			$regno = $row_result['regno'];
			$degree = $row_result['ProgrammeofStudy'];
			$RegNo = $regno;
			
			//get degree name
			$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
			$dbdegree = mysqli_query($zalongwa,$qdegree);
			$row_degree = mysqli_fetch_array($dbdegree);
			$programme = $row_degree['Title'];
			
			echo  "$name - $regno <br> $programme";	

				
//query academeic year
$qayear = "SELECT DISTINCT AYear FROM examresult WHERE RegNo = '$RegNo' ORDER BY AYear ASC";
$dbayear = mysqli_query($zalongwa,$qayear);

//query exam results sorted per years
while($rowayear = mysqli_fetch_object($dbayear)){
$currentyear = $rowayear->AYear;

			# get all courses for this candidate
			$qcourse="SELECT DISTINCT course.Units, course.Department, course.CourseName, course.StudyLevel, examresult.CourseCode FROM 
						course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
							 WHERE (RegNo='$RegNo') AND 
							 (course.Programme = '$degree') AND 
							 AYear='$currentyear'";	
			$dbcourse = mysqli_query($zalongwa,$qcourse) or die("No Exam Results for the Candidate - $key ");
			$total_rows = mysqli_num_rows($dbcourse);
			
			if($total_rows>0){
			#initialise s/no
			$sn=0;
			#print name and degree
			//select student
				$qstudent = "SELECT Name, RegNo, ProgrammeofStudy from student WHERE RegNo = '$RegNo'";
				$dbstudent = mysqli_query($zalongwa,$qstudent) or die("Mwanafunzi huyu hana matokeo".  mysqli_error($zalongwa));
				$row_result = mysqli_fetch_array($dbstudent);
				$name = $row_result['Name'];
				$regno = $row_result['RegNo'];
				$degree = $row_result['ProgrammeofStudy'];
				
				//get degree name
				$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
				$dbdegree = mysqli_query($zalongwa,$qdegree);
				$row_degree = mysqli_fetch_array($dbdegree);
				$programme = $row_degree['Title'];
							
							#initialise
							$totalunit=0;
							$unittaken=0;
							$sgp=0;
							$totalsgp=0;
							$gpa=0;
							?>
<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="63" scope="col"><?php echo $rowayear->AYear;?></td>
	<td width="350" nowrap scope="col">Course</td>
    <td width="30" nowrap scope="col">Unit</td>
    <td width="38" nowrap scope="col">Grade</td>
    <td width="31" nowrap scope="col">Point</td>
    <td width="31" nowrap scope="col">GPA</td>
  </tr>
  <?php
		while($row_course = mysqli_fetch_array($dbcourse)){
				$course= $row_course['CourseCode'];
				$unit= $row_course['Units'];
				$coursename= $row_course['CourseName'];
				$coursefaculty = $row_course['Department'];
				if($row_course['Status']==1){
					$status ='Core';
				}else{
					$status = 'Elective';
				}
					$sn=$sn+1;
					$remarks = 'remarks';
			   
				include'includes/choose_studylevel.php';
				
				#display results

				?>
	<tr>
     <td nowrap scope="col"><div align="left"><?php echo $course?></div></td>
     <td width="350" nowrap scope="col"><div align="left"><?php echo $coursename;?></div></td>
     <td width="30" nowrap scope="col"><div align="center"><?php echo $row_course['Units']?></div></td>
     <td width="38" nowrap scope="col"><div align="center"><?php echo $grade?></div></td>
	 <td width="31" nowrap scope="col"><div align="center"><?php echo $sgp?></div></td>
    <td width="31" nowrap scope="col"></td>
  </tr>
  <?php }?>
  	<tr>
     <td scope="col"></td>
     <td width="350" nowrap scope="col"></td>
     <td width="30" nowrap scope="col"><div align="center"><?php echo $unittaken;?></div></td>
     <td width="38" nowrap scope="col"></td>
	 <td width="31" nowrap scope="col"><div align="center"><?php echo $totalsgp;?></div></td>
    <td width="31" nowrap scope="col"><div align="center"><?php echo @substr($totalsgp/$unittaken, 0,3);?></div></td>
  </tr>
</table>
<?php }else{ 
					if(!@$reg[$c]){}else{
					echo "$c". ".Sorry, No Records Found for '$reg[$c]'<br><hr>";
							}
						}
				}//ends while rowayear	
mysqli_close($zalongwa);

}else{

?>
<a href="lecturerTranscriptcount.php">Transcript Report</a>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">
<table width="284" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
          <td colspan="9" nowrap><div align="left"></div></td>
        </tr>
        <tr>
          <td nowrap><div align="right"><strong>Award:
            </strong></div>            <div align="center"></div></td>
          <td colspan="8" nowrap><div align="left">
          <input type="hidden" value="1" id="temp" name="temp">
            <select name="award" id="award">
              <option value="1" selected>NTA Level 8</option>
              <option value="6">NTA Level 7</option>
              <option value="2">NTA Level 6 </option>
              <option value="3">NTA Level 5</option>
              <option value="4">NTA Level 4</option>
              <option value="5">Short Course</option>
            </select>
            </div>            <div align="right"></div>            <div align="right"></div></td>
        </tr>
        <tr>
          <td align="right" nowrap><strong> RegNo:</strong></td>
          <td colspan="8" bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
          <input name="key" type="text" id="key" size="40" maxlength="40">
          </span></td>
        </tr>
		<tr> 
			<td align="right" nowrap><strong>Table:</strong></td> 
			<td width="35"><div align="center">11<input type="radio" value="11" id="sex" name="sex"></div></td> 
			<td width="35"><div align="center">12<input type="radio" value="12" id="sex" name="sex" checked></div></td> 
			<td width="35"><div align="center">13<input type="radio" value="13" id="sex" name="sex" ></div></td> 
			<td width="35"><div align="center">14<input type="radio" value="14" id="sex" name="sex" ></div></td> 
			<td width="35"><div align="center">15<input type="radio" value="15" id="sex" name="sex" ></div></td> 
			<td width="35"><div align="center">16<input type="radio" value="16" id="sex" name="sex" ></div></td> 
			<td width="35"><div align="center">-</div></td> 
			<td><div align="left">17<input type="radio" value="17" id="sex" name="sex" ></div></td>
		</tr>
        <tr>
          <td nowrap><div align="right"><strong>Confirmed:
            </strong></div>            
            <div align="center"></div></td>
          <td colspan="3" nowrap><div align="right">No</div></td>
          <td nowrap><input type="radio" value="1" id="real" name="real" checked></td>
          <td colspan="2" nowrap><div align="right"></div></td>
          <td nowrap><div align="right">Yes</div></td>
          <td nowrap><div align="left">
            <input type="radio" value="2" id="real" name="real" >
          </div></td>
        </tr>
        <tr>
          <td nowrap><div align="right"> </div></td>
          <td colspan="4" bgcolor="#CCCCCC">
            <div align="left">
              <input type="submit" name="search" value="PreView">
            </div>            <div align="right">
            </div></td>
          <td colspan="4" nowrap bgcolor="#CCCCCC">
            <div align="right">
              <input name="PrintPDF" type="submit" id="PrintPDF" value="Print PDF">
            </div></td>
        </tr>
  </table>
</form>
<p>&nbsp;</p>
<?php
}
include('../footer/footer.php');
?>