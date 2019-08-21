<?php
require('include/rotation.php');

class PDF extends PDF_Rotate
{
function RotatedText($x,$y,$txt,$angle)
{
	//Text rotated around its origin
	$this->Rotate($angle,$x,$y);
	$this->Text($x,$y,$txt);
	$this->Rotate(0);
}

function RotatedImage($file,$x,$y,$w,$h,$angle)
{
	//Image rotated around its upper-left corner
	$this->Rotate($angle,$x,$y);
	$this->Image($file,$x,$y,$w,$h);
	$this->Rotate(0);
}
}

#start pdf
if (isset($_POST['PDF']) && ($_POST['PDF'] == "Print PDF")){
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php');


	//create table temp for used courses
	$temp=mysqli_query($zalongwa, "DROP TABLE temp");
	$temp1=mysqli_query($zalongwa, "CREATE TABLE temp (Code varchar(9) NOT NULL, Name varchar(200) NOT NULL, PRIMARY KEY (Code))");

	//@$paper = addslashes($_POST['paper']);
	//@$layout = addslashes($_POST['layout']);
	@$paper = 'a4';
	@$layout = 'L' ;
	//$_POST['size']='a3';
	if($paper=='a3'){
		@$hsize='1125.00';
		@$vsize='835.89';
		}
	else if($paper=='a4'){
		@$hsize='800.89';
		@$vsize='580.28';
	}

	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
	$dborg = mysqli_query($zalongwa, $qorg);
	$row_org = mysqli_fetch_assoc($dborg);
	$org = $row_org['Name'];

	@$checkdegree = addslashes($_POST['checkdegree']);
	@$checkyear = addslashes($_POST['checkyear']);
	@$checkdept = addslashes($_POST['checkdept']);
	@$checkcohot = addslashes($_POST['checkcohot']);

	$prog=$_POST['degree'];
	$cohotyear = $_POST['cohot'];
	$ayear = $_POST['ayear'];
	$qprog= "SELECT ProgrammeCode, Title FROM programme WHERE ProgrammeCode='$prog'";
	$dbprog = mysqli_query($zalongwa, $qprog);
	$row_prog = mysqli_fetch_array($dbprog);
	$progname = $row_prog['Title'];
		
	//calculate year of study
	$entry = intval(substr($cohotyear,0,4));
	$current = intval(substr($ayear,0,4));
	$yearofstudy=$current-$entry;
	
	if($yearofstudy==0){
		$class="FIRST YEAR";$ryr=1;
		}elseif($yearofstudy==1){
		$class="SECOND YEAR"; $ryr=2;
		}elseif($yearofstudy==2){
		$class="THIRD YEAR"; $ryr=3;
		}elseif($yearofstudy==3){
		$class="FOURTH YEAR"; $ryr=4;
		}elseif($yearofstudy==4){
		$class="FIFTH YEAR"; $ryr=5;
		}elseif($yearofstudy==5){
		$class="SIXTH YEAR"; $ryr=6; 
		}elseif($yearofstudy==6){
		$class="SEVENTHND YEAR";$ryr=7;
		}else{
		$class="";
	}

	
	if (($checkdegree=='on') && ($checkyear == 'on')&& ($checkcohot == 'on')){
		$deg=addslashes($_POST['degree']);
		$year = addslashes($_POST['ayear']);
		$cohot = addslashes($_POST['cohot']);
		$dept = addslashes($_POST['dept']);
		$sem = addslashes($_POST['sem']);
		
		if ($checkcombin=='on'){
			$combin = addslashes($_POST['combin']);
		}
		
		###########GET TOTAL CREDITS for this programme############
		if($deg=='2001'){
			$tyrs='1';
			}
		else{
			$tyrs='3';
			}
		
		$sCredt=0;$yCredt=0;
		for($y=1;$y<=$tyrs;$y++){
			for($s=1;$s<=2;$s++){
				$qcredt= "SELECT * FROM coursecountprogramme WHERE ProgrammeID='$deg' AND YearofStudy='$y' AND Semester='$s'";
				$dcredt = mysqli_query($zalongwa, $qcredt);
				$row_credt = mysqli_fetch_array($dcredt);
				$gCredt=$row_credt['CourseCount'];
				}
			$sCredt=$sCredt + $gCredt;
		}
		$yCredt=$yCredt + $sCredt;

		#############COUNT CORE COURSES DONE #########
		if($deg=='2100' || $deg=='2101' || $deg=='2103' || $deg=='1002'){
			$qcountcoz= "SELECT * FROM courseprogramme WHERE ProgrammeID='$deg' AND Combination='$combin' AND Status=1";
			$dcountcoz = mysqli_query($zalongwa, $qcountcoz);
			$row_countcoz = mysqli_num_rows($dcountcoz);
			}
		else{
			$qcountcoz= "SELECT * FROM courseprogramme WHERE ProgrammeID='$deg' AND Status=1";
			$dcountcoz = mysqli_query($zalongwa, $qcountcoz);
			$row_countcoz = mysqli_num_rows($dcountcoz);
			}

		##########GET AWARD LEVEL #############
		$qawrd = "SELECT NtaLevel FROM programme WHERE (ProgrammeCode = '$deg')";
		$dbaward = mysqli_query($zalongwa, $qawrd);
		$gaward = mysqli_fetch_array($dbaward);
		$award=$gaward['NtaLevel'];
				
		##################
		#determine total number of columns
		$qstd = "SELECT RegNo FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
		$dbstd = mysqli_query($zalongwa, $qstd);
		$totalcolms = 0;
		while($rowstd = mysqli_fetch_array($dbstd)) {
			$stdregno = $rowstd['RegNo'];
			$qstdcourse = "SELECT DISTINCT coursecode FROM examresult WHERE RegNo='$stdregno' and AYear='$year'";
			$dbstdcourse = mysqli_query($zalongwa, $qstdcourse);
			$totalstdcourse = mysqli_num_rows($dbstdcourse);
			if ($totalstdcourse>$totalcolms){
				$totalcolms = $totalstdcourse;
				}
			}

		#Start PDF
		$pdf= new PDF('L','pt',$paper);
		$pdf->open();                         
		$pdf->setCompression(true);           
		$pdf->addPage();  
		$pdf->setFont('Arial', 'I', 8);     
		$pdf->text(50, $vsize, 'Printed On '.$today = date("d-m-Y H:i:s"));  		
 	
		
		#put page header
		$x=60;
		$y=64;
		$i=1;
		$pg=1;
		$pdf->text($hsize,$vsize, 'Page '.$pg);
		$cscorewidth=16;   
		
		#count unregistered
		$j=0;
		#count sex
		$fmcount = 0;
		$mcount = 0;
		$fcount = 0;
		
		#print header for landscape paper layout 
		$playout ='l'; 
		include '../includes/orgname.php';
		
		$pdf->setFillColor('rgb', 0, 0, 0);    
		$pdf->setFont('Arial', '', 13);      
		$pdf->text($x+20, $y+14, strtoupper($progname).' AWARDS '.$year); 
		$pdf->setFont('Arial', 'I', 9); 
		$pdf->text(250, $vsize, $progname .' AWARDS   '.$year ); 
		$pdf->setFont('Arial', '', 13); 
		#reset values of x,y
		$x=50; $y=$y+54; 


		#set table header
		$pdf->setFont('Arial', 'B', 8); 
		$pdf->line($x, $y, $hsize, $y); 
		$pdf->line($x, $y+40, $hsize, $y+40); $pdf->text($x+$mvsp, $y-90, $currentyear);
        $pdf->line($x, $y, $x, $y+40);

		$mvsp = $mvsp + 60;		 
		$e1=$entry+1;$e2=$entry+2;$e3=$entry+3;$e4=$entry+4;$e5=$entry+5;
		$pdf->line($x+260, $y, $x+260, $y+40);$pdf->line($x+260, $y, $x+260, $y+40);
		$pdf->line($x+260, $y, $x+260, $y+40);$pdf->line($x+260, $y, $x+260, $y+40);
		$pdf->text($x+267, $y+38, '1ST YEAR'); $pdf->text($x+267, $y+16, $entry.'/'.$e1);

		if(($deg<>'2001')){
			$pdf->line($x+320, $y, $x+320, $y+40);$pdf->line($x+320, $y, $x+320, $y+40);
			$pdf->line($x+320, $y, $x+320, $y+40);$pdf->text($x+327, $y+16, $e1.'/'.$e2);
			$pdf->text($x+327, $y+38, '2ND YEAR');
			$pdf->line($x+380, $y, $x+380, $y+40);$pdf->line($x+380, $y, $x+380, $y+40);
			$pdf->line($x+380, $y, $x+380, $y+40);$pdf->line($x+380, $y, $x+380, $y+40);
			$pdf->line($x+380, $y, $x+380, $y+40);

		
			$pdf->line($x+380, $y, $x+380, $y+40);$pdf->line($x+380, $y, $x+380, $y+40);
			$pdf->line($x+380, $y, $x+380, $y+40);$pdf->line($x+380, $y, $x+380, $y+40);
			$pdf->line($x+380, $y, $x+380, $y+40);$pdf->text($x+387, $y+16, $e2.'/'.$e3);
			$pdf->text($x+387, $y+38, '3RD YEAR');

			$pdf->line($x+440, $y, $x+440, $y+40);$pdf->line($x+440, $y, $x+440, $y+40);
			$pdf->line($x+440, $y, $x+440, $y+40);$pdf->line($x+440, $y, $x+440, $y+40);
			$pdf->line($x+440, $y, $x+440, $y+40);
			}

		if($deg=='1100'){
			$pdf->line($x+440, $y, $x+440, $y+40);$pdf->line($x+440, $y, $x+440, $y+40);
			$pdf->line($x+440, $y, $x+440, $y+40);$pdf->line($x+440, $y, $x+440, $y+40);
			$pdf->line($x+440, $y, $x+440, $y+40);$pdf->text($x+447, $y+16, $e3.'/'.$e4);
			$pdf->text($x+447, $y+38, '4TH YEAR');
			$pdf->line($x+500, $y, $x+500, $y+40);$pdf->line($x+500, $y, $x+500, $y+40);
			$pdf->line($x+500, $y, $x+500, $y+40);$pdf->line($x+500, $y, $x+500, $y+40);
			$pdf->line($x+500, $y, $x+500, $y+40);$pdf->text($x+507, $y+16, $e4.'/'.$e5);
			$pdf->text($x+507, $y+38, '5TH YEAR');
			$pdf->line($x+560, $y, $x+560, $y+40);$pdf->line($x+560, $y, $x+560, $y+40);
			$pdf->line($x+560, $y, $x+560, $y+40);$pdf->line($x+560, $y, $x+560, $y+40);
			$pdf->line($x+560, $y, $x+560, $y+40);
			}

		$pdf->line($hsize, $y, $hsize, $y+40);  
		$y=$y+40;
		
		#set table Column header
		#reset x value
		$x=50;
		$pdf->setFont('Arial', 'B', 7); 
		$pdf->line($x, $y, $hsize, $y); 
		$pdf->line($x, $y+58, $hsize, $y+58); 
		$pdf->line($x, $y, $x, $y+58); 	$pdf->text($x+2, $y+12, 'S/No');
		$pdf->line($x+20, $y, $x+20, $y+58);	$pdf->text($x+30, $y+12, 'REGNo.');
		$pdf->line($x+107, $y, $x+107, $y+58);	$pdf->text($x+144, $y+12, 'Name');
		$pdf->line($x+240, $y, $x+240, $y+58);	$pdf->text($x+243, $y+12, 'Sex');

		$pdf->line($x+260, $y, $x+260, $y+58);$pdf->line($x+260, $y, $x+260, $y+58); $pdf->line($x+260, $y, $x+260, $y+58);
		$pdf->line($x+260, $y, $x+260, $y+58);
		$pdf->line($x+260, $y, $x+260, $y+58); $pdf->RotatedText($x+267, $y+52, 'Sub Credits',90);
		$pdf->line($x+280, $y, $x+280, $y+58); $pdf->RotatedText($x+287, $y+52, 'Sub Points',90);
		$pdf->line($x+300, $y, $x+300, $y+58); $pdf->RotatedText($x+307, $y+52, 'GPA',90);
		$pdf->line($x+320, $y, $x+320, $y+58);$pdf->line($x+320, $y, $x+320, $y+58);$pdf->line($x+320, $y, $x+320, $y+58);
		$pdf->line($x+320, $y, $x+320, $y+58); $pdf->RotatedText($x+327, $y+52, 'Sub Credits',90);
		$pdf->line($x+340, $y, $x+340, $y+58); $pdf->RotatedText($x+347, $y+52, 'Sub Points',90);
		$pdf->line($x+360, $y, $x+360, $y+58); $pdf->RotatedText($x+367, $y+52, 'GPA',90);
		
		if($deg=='1100'){
			$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);
			$pdf->line($x+380, $y, $x+380, $y+58);
			$pdf->line($x+380, $y, $x+380, $y+58); $pdf->RotatedText($x+387, $y+52, 'Sub Credits',90);

			$pdf->line($x+400, $y, $x+400, $y+58); $pdf->RotatedText($x+407, $y+52, 'Sub Points',90);
			$pdf->line($x+420, $y, $x+420, $y+58); $pdf->RotatedText($x+427, $y+52, 'GPA',90);

			$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);
			$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);
			$pdf->line($x+440, $y, $x+440, $y+58); $pdf->RotatedText($x+447, $y+52, 'Sub Credits',90);
			$pdf->line($x+460, $y, $x+460, $y+58); $pdf->RotatedText($x+467, $y+52, 'Sub Points',90);
			$pdf->line($x+480, $y, $x+480, $y+58); $pdf->RotatedText($x+487, $y+52, 'GPA',90);

			$pdf->line($x+500, $y, $x+500, $y+58);$pdf->line($x+500, $y, $x+500, $y+58);
			$pdf->line($x+500, $y, $x+500, $y+58);$pdf->line($x+500, $y, $x+500, $y+58);
			$pdf->line($x+500, $y, $x+500, $y+58); $pdf->RotatedText($x+507, $y+52, 'Sub Credits',90);
			$pdf->line($x+520, $y, $x+520, $y+58); $pdf->RotatedText($x+527, $y+52, 'Sub Points',90);
			$pdf->line($x+540, $y, $x+540, $y+58); $pdf->RotatedText($x+547, $y+52, 'GPA',90);

			$pdf->line($x+560, $y, $x+560, $y+58);$pdf->line($x+560, $y, $x+560, $y+58);
			$pdf->line($x+560, $y, $x+560, $y+58);$pdf->line($x+560, $y, $x+560, $y+58);
			$pdf->line($x+560, $y, $x+560, $y+58);	$pdf->RotatedText($x+567, $y+57, 'TOTAL CREDITS',90);
			$pdf->line($x+580, $y, $x+580, $y+58);	$pdf->RotatedText($x+587, $y+57, 'TOTAL POINTS',90);
			$pdf->line($x+600, $y, $x+600, $y+58);	$pdf->RotatedText($x+607, $y+57, 'GPA',90);
			$pdf->line($x+620, $y, $x+620, $y+58);  $pdf->line($x+620, $y, $x+620, $y+58);
			$pdf->line($x+620, $y, $x+620, $y+58);	$pdf->text($x+627, $y+52, 'CLASSIFICATION');
			}
			
		elseif(($deg=='2001') ||($deg=='1200')){
			$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);
			$pdf->line($x+380, $y, $x+380, $y+58);
			$pdf->line($x+380, $y, $x+380, $y+58); $pdf->RotatedText($x+387, $y+57, 'TOTAL CREDITS',90);
			$pdf->line($x+400, $y, $x+400, $y+58); $pdf->RotatedText($x+407, $y+57, 'TOTAL POINTS',90);
			$pdf->line($x+420, $y, $x+420, $y+58); $pdf->RotatedText($x+427, $y+57, 'GPA',90);
			$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);
			$pdf->line($x+440, $y, $x+440, $y+58);$pdf->text($x+447, $y+52, 'CLASSIFICATION');
			}
		else{
			$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);
			$pdf->line($x+380, $y, $x+380, $y+58);
			$pdf->line($x+380, $y, $x+380, $y+58); $pdf->RotatedText($x+387, $y+52, 'Sub Credits',90);

			$pdf->line($x+400, $y, $x+400, $y+58); $pdf->RotatedText($x+407, $y+52, 'Sub Points',90);
			$pdf->line($x+420, $y, $x+420, $y+58); $pdf->RotatedText($x+427, $y+52, 'GPA',90);
			$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);
			$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);

			$pdf->line($x+440, $y, $x+440, $y+58);$pdf->RotatedText($x+447, $y+57, 'TOTAL CREDITS',90);
			$pdf->line($x+460, $y, $x+460, $y+58);	$pdf->RotatedText($x+467, $y+57, 'TOTAL POINTS',90);
			$pdf->line($x+480, $y, $x+480, $y+58);	$pdf->RotatedText($x+487, $y+57, 'GPA',90);
			$pdf->line($x+500, $y, $x+500, $y+58);$pdf->line($x+500, $y, $x+500, $y+58);
			$pdf->line($x+500, $y, $x+500, $y+58);	$pdf->text($x+507, $y+52, 'CLASSIFICATION');
			 }
			 
		$pdf->line($hsize, $y, $hsize, $y+58);  
		$y=$y+58;

		$pdf->setFont('Arial', '', 9); 

		#query student list
		$qstudent = "SELECT Name, RegNo, Sex, ProgrammeofStudy,studylevel FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY RegNo";
		$dbstudent = mysqli_query($zalongwa, $qstudent);
		$totalstudent = mysqli_num_rows($dbstudent);
		$i=1;

		while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$dctotal=0;
			$dptotal=0;
			$dgtotal=0;
			$avgGPA=0;
			$totalCcount=0;
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$sex = $rowstudent['Sex'];
					
			#print student info
			$pdf->setFont('Arial', '', 7); 
			$pdf->line($x, $y, $hsize, $y); 
			$pdf->line($x, $y+20, $hsize, $y+20);
			$pdf->line($x, $y, $x, $y+20); 	$pdf->text($x+2, $y+16, $i);
			$pdf->line($x+20, $y, $x+20, $y+20);$pdf->text($x+23, $y+17, strtoupper($regno)); 
			$pdf->line($x+107, $y, $x+107, $y+20);$pdf->text($x+110, $y+17, strtoupper($name));
			$pdf->line($x+240, $y, $x+240, $y+20);	$pdf->text($x+243, $y+17, strtoupper($sex));

			$pdf->line($x+260, $y, $x+260, $y+20);
			$pdf->line($x+260, $y, $x+260, $y+20);
			$pdf->line($x+260, $y, $x+260, $y+20);
			$pdf->line($x+280, $y, $x+280, $y+20);
			$pdf->line($x+300, $y, $x+300, $y+20);
			$pdf->line($x+320, $y, $x+320, $y+20);
			$pdf->line($x+320, $y, $x+320, $y+20);
			$pdf->line($x+320, $y, $x+320, $y+20);
			$pdf->line($x+340, $y, $x+340, $y+20);
			$pdf->line($x+360, $y, $x+360, $y+20);

			if($deg=='1100'){
				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+460, $y, $x+460, $y+20);
				$pdf->line($x+480, $y, $x+480, $y+20);
				$pdf->line($x+500, $y, $x+500, $y+20);
				$pdf->line($x+500, $y, $x+500, $y+20);
				$pdf->line($x+500, $y, $x+500, $y+20);
				$pdf->line($x+520, $y, $x+520, $y+20);
				$pdf->line($x+540, $y, $x+540, $y+20);
				$pdf->line($x+560, $y, $x+560, $y+20);
				$pdf->line($x+560, $y, $x+560, $y+20);
				$pdf->line($x+560, $y, $x+560, $y+20);
				$pdf->line($x+580, $y, $x+580, $y+20);
				$pdf->line($x+600, $y, $x+600, $y+20);
				$pdf->line($x+620, $y, $x+620, $y+20);
				$pdf->line($x+620, $y, $x+620, $y+20);
				$pdf->line($x+620, $y, $x+620, $y+20);
				}
			elseif(($deg=='2200') ||($deg=='1200')){
				$pdf->line($x+380, $y, $x+380, $y+20);
				$pdf->line($x+380, $y, $x+380, $y+20);
				$pdf->line($x+380, $y, $x+380, $y+20);
				$pdf->line($x+400, $y, $x+400, $y+20);
				$pdf->line($x+420, $y, $x+420, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);
				}
			else{
				$pdf->line($x+380, $y, $x+380, $y+20);
				$pdf->line($x+380, $y, $x+380, $y+20);
				$pdf->line($x+380, $y, $x+380, $y+20);
				$pdf->line($x+400, $y, $x+400, $y+20);
				$pdf->line($x+420, $y, $x+420, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);

				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+440, $y, $x+440, $y+20);
				$pdf->line($x+460, $y, $x+460, $y+20);
				$pdf->line($x+480, $y, $x+480, $y+20);
				$pdf->line($x+500, $y, $x+500, $y+20);
				$pdf->line($x+500, $y, $x+500, $y+20);
				$pdf->line($x+500, $y, $x+500, $y+20);
				}
			###########SELECT YEARLY###############
			#query academeic year
			$qayear = "SELECT DISTINCT AYear from examresult WHERE RegNo = '$regno' ORDER BY examresult.AYear ASC";
			$dbayear = mysqli_query($zalongwa, $qayear);
			
			#initialise
			$unit=0;
			$totalunit=0;
			$unittaken=0;
			$sgp=0;
			$totalsgp=0;
			$gpa=0;
			$cntD=0;
			$cntE=0;
			$key = $regno; 
            $checksupp = 0;
            $sp=0;

            $mvsp=267;
            
			//query exam results sorted per years
			while($rowayear = mysqli_fetch_object($dbayear)){
				$currentyear = $rowayear->AYear;
				
				$unit=0;
				$totalunit=0;
				$unittaken=0;
				$sgp=0;
				$totalsgp=0;
				$gpa=0;
				$cntD=0;
				$cntE=0;
				$key = $regno; 
					
				# get all courses for this candidate
				$qcourse="SELECT DISTINCT course.CourseName, 
										  course.Units, 
										  course.Department, 
										  course.StudyLevel,
										  examresult.Semester,
										  examresult.CourseCode 
										   
						  FROM 
								course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
						  WHERE (examresult.RegNo='$regno') AND 
								(examresult.AYear = '$currentyear') AND (examresult.Checked='1') 
						  ORDER BY examresult.AYear ASC, examresult.Semester ASC";	
				$dbcourse = mysqli_query($zalongwa, $qcourse);
				if(!$dbcourse){
					//or die("No Exam Results for the Candidate - $regno ");
					$error = urlencode("No Exam Results for the Candidate - $regno");
					$location = "lecturerGraduates.php?error=$error";
					echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
					exit();
					} 
				$total_rows = mysqli_num_rows($dbcourse);

				while($row_course = mysqli_fetch_array($dbcourse)){
					$course= $row_course['CourseCode'];
					$unit= $row_course['Units'];
					$sem= $row_course['Semester'];
					$coursename= $row_course['CourseName'];
					$coursefaculty = $row_course['Department'];
					
					if($row_course['Status']==1){
						$status ='Core';
						}
					else{
						$status = 'Elective';
						}
					
					$sn=$sn+1;
					$remarks = 'remarks';
					$RegNo = $regno;
					include '../academic/includes/choose_studylevel.php';
					
					//Check if core course(COUNT CORE DONE)
					$qCore= mysqli_query($zalongwa, "SELECT Status FROM course WHERE CourseCode='$course'");
					$gCore = mysqli_fetch_array($qCore);
					$czstatus= $gCore['Status'];
					
					if($czstatus=='1'){
						$totalCcount=$totalCcount+1;
					}

					$gpa = @substr($totalsgp/$unittaken, 0,3);
				}

				$x=$x+240;
				$pdf->text($x+23+$sp, $y+10, substr($unittaken,0,3));
				$pdf->text($x+41+$sp, $y+10, $totalsgp);
				$pdf->text($x+63+$sp, $y+10, $gpa); 
				$x=$x-240;
				$sp=$sp+60;
				$dctotal=$dctotal+$unittaken;
				$dptotal=$dptotal+$totalsgp;
				$avgGPA=@substr($dptotal/$dctotal, 0,3);

				}//end year

			$x=50;
			if($deg=='1100'){	
				$pdf->text($x+563, $y+15, $dctotal);
				$pdf->text($x+583, $y+15, $dptotal);
				$pdf->text($x+603, $y+15, $avgGPA);
				}
			elseif(($deg=='2001')||($deg=='1200')){	
				$pdf->text($x+387, $y+15, $dctotal);
				$pdf->text($x+407, $y+15, $dptotal);
				$pdf->text($x+427, $y+15, $avgGPA);
				}
			else{
				$pdf->text($x+443, $y+15, $dctotal);
				$pdf->text($x+463, $y+15, $dptotal);
				$pdf->text($x+483, $y+15, $avgGPA);
				}
				
			#get student remarks
			$qremarks = "SELECT Remark FROM studentremark WHERE RegNo='$regno'";
			$dbremarks = mysqli_query($zalongwa, $qremarks);
			$row_remarks = mysqli_fetch_assoc($dbremarks);
			$totalremarks = mysqli_num_rows($dbremarks);
			$studentremarks = $row_remarks['Remark'];
				
			if(($totalremarks>0)&&($studentremarks<>'')){
					$remark = $studentremarks;
				}
			else{
				//CHECK IF DONE ALL CORE COURSES
				if ($totalCcount < $row_countcoz){
						$skipcoz = 1;
						}
				//CHECK IF COMPLETED THE REQUIRED CREDITS
				if ($dctotal < $yCredt){
						$belwCredt = 1;
						}
															
				if(($skipcoz !='1') && ($belwCredt !='1')){
					#specify degree classification
					if (($award=='NTA Level 7')||($award=='7')){
						if($avgGPA>=4.4){
							if ($checksupp ==1){
								$degree = 'FIRST CLASS';
								}
							else{
								$degree = 'FIRST CLASS (Hons)';
								}
							}
						elseif($avgGPA>=3.5){
							if ($checksupp ==1){
								$degree = 'UPPERSECOND CLASS';
								}
							else{
								$degree = 'UPPERSECOND CLASS (Hons)';
								}
							}
						elseif($avgGPA>=2.7){
							if ($checksupp ==1){
								$degree = 'LOWERSECOND CLASS';
								}
							else{
								$degree = 'LOWERSECOND CLASS (Hons)';
								}
							}
						elseif($avgGPA>=2.0){
							$degree = 'PASS';
							}
						else{
							$degree = 'FAIL';
							}
						}
							
					elseif($award=='NTA Level 6'){
						if($avgGPA>=4.4){
							if ($checksupp ==1){
								$degree = 'First Class';
								}
							else{
								$degree = 'First Class (Honours)';
								}
							}
						elseif($avgGPA>=3.5){
							if ($checksupp ==1){
								$degree = 'Uppersecond Class';
								}
							else{
								$degree = 'Uppersecond Class (Honours)';
								}
							}
						elseif($avgGPA>=2.7){
							if ($checksupp ==1){
								$degree = 'Lowersecond Class';
								}
							else{
								$degree = 'Lowersecond Class (Honours)';
								}
							}
						elseif($avgGPA>=2.0){
							$degree = 'Pass';
							}
						else{
							$degree = 'FAIL';
							}                              
						}
					
					elseif($award=='NTA Level 5'){
						if($avgGPA>=4.4){
							if ($checksupp ==1){
								$degree = 'First Division';
								}
							else{
								$degree = 'First Division  (Honours)';
								}
							}
						elseif($avgGPA>=3.5){
							if ($checksupp ==1){
								$degree = 'Second Division';
								}
							else{
								$degree = 'Second Division (Honours)';
								}
							}
						elseif($avgGPA>=2.7){
							if ($checksupp ==1){
								$degree = 'Third Division';
								}
							else{
								$degree = 'Third Division (Honours)';
								}
							}
						elseif($avgGPA>=2.0){
							$degree = 'Pass';
							}
						else{
							$degree = 'FAIL';
							}
						}
					}
				else{
					// IF NOT DONE ALL CORE COURSES
					if ($skipcoz == '1'){
						$degree='SKIP COURSE';
						if($deg=='1100'){
							$pdf->text($x+623, $y+7, $degree);
							}
						elseif($deg=='2200'||$deg=='1200'){
							$pdf->text($x+4473, $y+7, $degree);
							}
						else{
							 $pdf->text($x+503, $y+7, $degree);
							}
						$degree=''; 
						$skipcoz='';
						}
					//IF NOT COMPLETED THE REQUIRED CREDITS
					if ($belwCredt == '1'){
						$degree='INCO. CREDITS';
						if($deg=='1100'){
							$pdf->text($x+623, $y+17, $degree);
						}
						elseif($deg=='2200'||$deg=='1200'){
							$pdf->text($x+447, $y+7, $degree);
							}
						else{
							$pdf->text($x+503, $y+17, $degree);
							}
						}
					$degree=''; 
					$belwCredt='';
					}
				}
			if($deg=='1100'){
				$pdf->text($x+623, $y+15, $degree);
				}
			elseif($deg=='2200'||$deg=='1200'){
				$pdf->text($x+447, $y+7, $degree);
				}
			else{
				$pdf->text($x+503, $y+15, $degree);
				}
				
			$pdf->line($hsize, $y, $hsize, $y+20); $y=$y-25;
					
			$i=$i+1;
			$y=$y+45;

			if($y>=$vsize-50){
				#start new page
				$pdf->addPage();  
				$pdf->setFont('Arial', 'I', 8);     
				$pdf->text(50, $vsize, 'Printed On '.$today = date("d-m-Y H:i:s"));   
					
				$x=50;
				$y=50;
				$pg=$pg+1;
				$pdf->text($hsize,$vsize, 'Page '.$pg);  
				$pdf->text(300, $vsize, $progname .' AWARDS   '.$year ); 
 
 				#count unregistered
				$j=0;
				#count sex
				$fmcount = 0;
				$mcount = 0;
				$fcount = 0;

				#set table header
				$pdf->setFont('Arial', 'B', 8);
				$pdf->line($x, $y, $hsize, $y);
				$pdf->line($x, $y+40, $hsize, $y+40);
				$pdf->line($x, $y, $x, $y+40);

				$mvsp = $mvsp + 60;
				$e1=$entry+1;$e2=$entry+2;$e3=$entry+3;$e4=$entry+4;$e5=$entry+5;
				$pdf->line($x+260, $y, $x+260, $y+40);$pdf->line($x+260, $y, $x+260, $y+40);
				$pdf->line($x+260, $y, $x+260, $y+40);$pdf->line($x+260, $y, $x+260, $y+40);
				$pdf->text($x+267, $y+38, '1ST YEAR'); $pdf->text($x+267, $y+16, $entry.'/'.$e1);
				
				if(($deg<>'2001')){
					$pdf->line($x+320, $y, $x+320, $y+40);$pdf->line($x+320, $y, $x+320, $y+40);
					$pdf->line($x+320, $y, $x+320, $y+40);$pdf->text($x+327, $y+16, $e1.'/'.$e2);
					$pdf->text($x+327, $y+38, '2ND YEAR');
					$pdf->line($x+380, $y, $x+380, $y+40);$pdf->line($x+380, $y, $x+380, $y+40);
					$pdf->line($x+380, $y, $x+380, $y+40);$pdf->line($x+380, $y, $x+380, $y+40);
					$pdf->line($x+380, $y, $x+380, $y+40);

					$pdf->line($x+380, $y, $x+380, $y+40);$pdf->line($x+380, $y, $x+380, $y+40);
					$pdf->line($x+380, $y, $x+380, $y+40);$pdf->line($x+380, $y, $x+380, $y+40);
					$pdf->line($x+380, $y, $x+380, $y+40);$pdf->text($x+387, $y+16, $e2.'/'.$e3);
					$pdf->text($x+387, $y+38, '3RD YEAR');

					$pdf->line($x+440, $y, $x+440, $y+40);$pdf->line($x+440, $y, $x+440, $y+40);
					$pdf->line($x+440, $y, $x+440, $y+40);$pdf->line($x+440, $y, $x+440, $y+40);
					$pdf->line($x+440, $y, $x+440, $y+40);
					}

				if($deg=='1100'){
					$pdf->line($x+440, $y, $x+440, $y+40);$pdf->line($x+440, $y, $x+440, $y+40);
					$pdf->line($x+440, $y, $x+440, $y+40);$pdf->line($x+440, $y, $x+440, $y+40);
					$pdf->line($x+440, $y, $x+440, $y+40);$pdf->text($x+447, $y+16, $e3.'/'.$e4);
					$pdf->text($x+447, $y+38, '4TH YEAR');
					$pdf->line($x+500, $y, $x+500, $y+40);$pdf->line($x+500, $y, $x+500, $y+40);
					$pdf->line($x+500, $y, $x+500, $y+40);$pdf->line($x+500, $y, $x+500, $y+40);
					$pdf->line($x+500, $y, $x+500, $y+40);$pdf->text($x+507, $y+16, $e4.'/'.$e5);
					$pdf->text($x+507, $y+38, '5TH YEAR');
					$pdf->line($x+560, $y, $x+560, $y+40);$pdf->line($x+560, $y, $x+560, $y+40);
					$pdf->line($x+560, $y, $x+560, $y+40);$pdf->line($x+560, $y, $x+560, $y+40);
					$pdf->line($x+560, $y, $x+560, $y+40);
					}

				$pdf->line($hsize, $y, $hsize, $y+40);  
				$y=$y+40;
				
				#set table Column header
				#reset x value
				$x=50;
				$pdf->setFont('Arial', 'B', 7); 
				$pdf->line($x, $y, $hsize, $y); 
				$pdf->line($x, $y+58, $hsize, $y+58); 
				$pdf->line($x, $y, $x, $y+58); 	$pdf->text($x+2, $y+12, 'S/No');
				$pdf->line($x+20, $y, $x+20, $y+58);	$pdf->text($x+30, $y+12, 'REGNo.');
				$pdf->line($x+107, $y, $x+107, $y+58);	$pdf->text($x+144, $y+12, 'Name');
				$pdf->line($x+240, $y, $x+240, $y+58);	$pdf->text($x+243, $y+12, 'Sex');

				$pdf->line($x+260, $y, $x+260, $y+58);$pdf->line($x+260, $y, $x+260, $y+58); $pdf->line($x+260, $y, $x+260, $y+58);
				$pdf->line($x+260, $y, $x+260, $y+58);
				$pdf->line($x+260, $y, $x+260, $y+58); $pdf->RotatedText($x+267, $y+52, 'Sub Credits',90);
				$pdf->line($x+280, $y, $x+280, $y+58); $pdf->RotatedText($x+287, $y+52, 'Sub Points',90);
				$pdf->line($x+300, $y, $x+300, $y+58); $pdf->RotatedText($x+307, $y+52, 'GPA',90);
				$pdf->line($x+320, $y, $x+320, $y+58);$pdf->line($x+320, $y, $x+320, $y+58);$pdf->line($x+320, $y, $x+320, $y+58);
				$pdf->line($x+320, $y, $x+320, $y+58); $pdf->RotatedText($x+327, $y+52, 'Sub Credits',90);
				$pdf->line($x+340, $y, $x+340, $y+58); $pdf->RotatedText($x+347, $y+52, 'Sub Points',90);
				$pdf->line($x+360, $y, $x+360, $y+58); $pdf->RotatedText($x+367, $y+52, 'GPA',90);
					
				if($deg=='1100'){
					$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);
					$pdf->line($x+380, $y, $x+380, $y+58);
					$pdf->line($x+380, $y, $x+380, $y+58); $pdf->RotatedText($x+387, $y+52, 'Sub Credits',90);
					$pdf->line($x+400, $y, $x+400, $y+58); $pdf->RotatedText($x+407, $y+52, 'Sub Points',90);
					$pdf->line($x+420, $y, $x+420, $y+58); $pdf->RotatedText($x+427, $y+52, 'GPA',90);

					$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);
					$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);
					$pdf->line($x+440, $y, $x+440, $y+58); $pdf->RotatedText($x+447, $y+52, 'Sub Credits',90);
					$pdf->line($x+460, $y, $x+460, $y+58); $pdf->RotatedText($x+467, $y+52, 'Sub Points',90);
					$pdf->line($x+480, $y, $x+480, $y+58); $pdf->RotatedText($x+487, $y+52, 'GPA',90);

					$pdf->line($x+500, $y, $x+500, $y+58);$pdf->line($x+500, $y, $x+500, $y+58);
					$pdf->line($x+500, $y, $x+500, $y+58);$pdf->line($x+500, $y, $x+500, $y+58);
					$pdf->line($x+500, $y, $x+500, $y+58); $pdf->RotatedText($x+507, $y+52, 'Sub Credits',90);
					$pdf->line($x+520, $y, $x+520, $y+58); $pdf->RotatedText($x+527, $y+52, 'Sub Points',90);
					$pdf->line($x+540, $y, $x+540, $y+58); $pdf->RotatedText($x+547, $y+52, 'GPA',90);

					$pdf->line($x+560, $y, $x+560, $y+58);$pdf->line($x+560, $y, $x+560, $y+58);
					$pdf->line($x+560, $y, $x+560, $y+58);$pdf->line($x+560, $y, $x+560, $y+58);
					$pdf->line($x+560, $y, $x+560, $y+58);	$pdf->RotatedText($x+567, $y+57, 'TOTAL CREDITS',90);
					$pdf->line($x+580, $y, $x+580, $y+58);	$pdf->RotatedText($x+587, $y+57, 'TOTAL POINTS',90);
					$pdf->line($x+600, $y, $x+600, $y+58);	$pdf->RotatedText($x+607, $y+57, 'GPA',90);
					$pdf->line($x+620, $y, $x+620, $y+58);  $pdf->line($x+620, $y, $x+620, $y+58);
					$pdf->line($x+620, $y, $x+620, $y+58);	$pdf->text($x+627, $y+52, 'CLASSIFICATION');
					}
						
				elseif(($deg=='2001') ||($deg=='1200')){
					$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);
					$pdf->line($x+380, $y, $x+380, $y+58);
					$pdf->line($x+380, $y, $x+380, $y+58); $pdf->RotatedText($x+387, $y+57, 'TOTAL CREDITS',90);
					$pdf->line($x+400, $y, $x+400, $y+58); $pdf->RotatedText($x+407, $y+57, 'TOTAL POINTS',90);
					$pdf->line($x+420, $y, $x+420, $y+58); $pdf->RotatedText($x+427, $y+57, 'GPA',90);
					$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);
					$pdf->line($x+440, $y, $x+440, $y+58);$pdf->text($x+447, $y+52, 'CLASSIFICATION');
					}
				else{
					$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);$pdf->line($x+380, $y, $x+380, $y+58);
					$pdf->line($x+380, $y, $x+380, $y+58);
					$pdf->line($x+380, $y, $x+380, $y+58); $pdf->RotatedText($x+387, $y+52, 'Sub Credits',90);
					$pdf->line($x+400, $y, $x+400, $y+58); $pdf->RotatedText($x+407, $y+52, 'Sub Points',90);
					$pdf->line($x+420, $y, $x+420, $y+58); $pdf->RotatedText($x+427, $y+52, 'GPA',90);
					$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);
					$pdf->line($x+440, $y, $x+440, $y+58);$pdf->line($x+440, $y, $x+440, $y+58);

					$pdf->line($x+440, $y, $x+440, $y+58);$pdf->RotatedText($x+447, $y+57, 'TOTAL CREDITS',90);
					$pdf->line($x+460, $y, $x+460, $y+58);	$pdf->RotatedText($x+467, $y+57, 'TOTAL POINTS',90);
					$pdf->line($x+480, $y, $x+480, $y+58);	$pdf->RotatedText($x+487, $y+57, 'GPA',90);
					$pdf->line($x+500, $y, $x+500, $y+58);$pdf->line($x+500, $y, $x+500, $y+58);
					$pdf->line($x+500, $y, $x+500, $y+58);	$pdf->text($x+507, $y+52, 'CLASSIFICATION');
					}
				
				$pdf->line($hsize, $y, $hsize, $y+58);  
				$y=$y+58;
				} 

			}//ends $rowstudent loop

		#output file
		$filename = preg_replace("[[:space:]]+", "",$progname);

		$pdf->Output();
		}
	}//end of print pdf
?>
<?php 
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Graduates Report';
	$szTitle = ' Degree Awards Results';
	include('lecturerheader.php');
	$editFormAction = $_SERVER['PHP_SELF'];

	mysqli_select_db($zalongwa, $database_zalongwa);
	$query_studentlist = "SELECT RegNo, Name, ProgrammeofStudy FROM student ORDER BY ProgrammeofStudy  ASC";
	$studentlist = mysqli_query($zalongwa, $query_studentlist) or die(mysqli_error($zalongwa));
	$row_studentlist = mysqli_fetch_assoc($studentlist);
	$totalRows_studentlist = mysqli_num_rows($studentlist);

	mysqli_select_db($zalongwa, $database_zalongwa);
	$query_degree = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
	$degree = mysqli_query($zalongwa, $query_degree) or die(mysqli_error($zalongwa));
	$row_degree = mysqli_fetch_assoc($degree);
	$totalRows_degree = mysqli_num_rows($degree);

	mysqli_select_db($zalongwa, $database_zalongwa);
	$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
	$ayear = mysqli_query($zalongwa, $query_ayear) or die(mysqli_error($zalongwa));
	$row_ayear = mysqli_fetch_assoc($ayear);
	$totalRows_ayear = mysqli_num_rows($ayear);

	mysqli_select_db($zalongwa, $database_zalongwa);
	$query_sem = "SELECT Semester FROM terms ORDER BY Semester";
	$sem = mysqli_query($zalongwa, $query_sem) or die(mysqli_error($zalongwa));
	$row_sem = mysqli_fetch_assoc($sem);
	$totalRows_sem = mysqli_num_rows($sem);

	mysqli_select_db($zalongwa, $database_zalongwa);
	$query_dept = "SELECT Faculty, DeptName FROM department ORDER BY DeptName, Faculty ASC";
	$dept = mysqli_query($zalongwa, $query_dept) or die(mysqli_error($zalongwa));
	$row_dept = mysqli_fetch_assoc($dept);
	$totalRows_dept = mysqli_num_rows($dept);

	if(isset($_POST['programme'])){

	$prgcomb=$_POST['degree'];
	?>
	<fieldset> 
	 <table class='resView' width="200">               
	<form name="form2" method="post" action="<?php echo $editFormAction ?>">
				
				
					<tr>
					  <td class='resViewhd' nowrap><div align="left">Degree Programme:</div></td>
					  <td class='resViewtd'>
						  <div align="left">
							<select name="degree" id="degree">
							  <?php
	do {  
	?>
							  <option value="<?php echo $row_degree['ProgrammeCode']?>"><?php echo $row_degree['ProgrammeName']?></option>
							  <?php
	} while ($row_degree = mysqli_fetch_assoc($degree));
	  $rows = mysqli_num_rows($degree);
	  if($rows > 0) {
		  mysqli_data_seek($degree, 0);
		  $row_degree = mysqli_fetch_assoc($degree);
	  }
	?>
							</select>
						</td>


					 
					  <td class='resViewhd' nowrap><input type="submit" name="programme"  id="programme" value="GO"onmouseover="this.style.background='#DEFEDE'"
	onmouseout="this.style.background='lightblue'" style='background-color:lightblue;color:black;font-size:9pt;font-weight:bold' title="Click to Continue Create a PDF File"></td>
					</tr>
				  
				  <input name="MM_updatep" type="hidden" id="MM_update" value="form2">       
	</form>
	</table>
	<?php
	$qprogn= "SELECT ProgrammeCode, Title FROM programme WHERE ProgrammeCode='$prgcomb'";
	$dbprogn = mysqli_query($zalongwa, $qprogn);
	$row_progn = mysqli_fetch_array($dbprogn);
	$progname = $row_progn['Title'];

	?>
				  
	<form name="form1" method="post" action="<?php echo $editFormAction ?>">

	<h2> <?php echo '&nbsp; <em><font color=#000000 >' .strtoupper($progname). '&nbsp;&nbsp;</font></em> Graduates Report'  ?> </h2>
				
				<br><table class='resView' width="200">
				<input name="checkdegree" type="hidden" id="checkdegree" value="on" checked>
		   <input name="degree" type="hidden" id="degree" value="<?php echo $prgcomb; ?>">
				   
	<?php
	if(($prgcomb=='2100') || ($prgcomb=='2101') || ($prgcomb=='2103') || ($prgcomb=='1002')){

	mysqli_select_db($zalongwa, $database_zalongwa);
	$query_combin = "SELECT * FROM subjectcombination where ProgrammeID='$prgcomb' ORDER BY Description ASC";
	$combin = mysqli_query($zalongwa, $query_combin) or die(mysqli_error($zalongwa));
	$row_combin = mysqli_fetch_assoc($combin);
	$totalRows_combin = mysqli_num_rows($combin);
	?>
	<tr>
					 
					  <td class='resViewhd' nowrap><div align="left">Combination:</div></td>
					  <td class='resViewtd'>
						  <div align="left">
							<select name="combin" id="combin">
							  <?php
	do {  
	?>
							  <option value="<?php echo $row_combin['subjectCode']?>"><?php echo $row_combin['Description']?></option>
							  <?php
	} while ($row_combin = mysqli_fetch_assoc($combin));
	  $rows = mysqli_num_rows($combin);
	  if($rows > 0) {
		  mysqli_data_seek($combin, 0);
		  $row_combin = mysqli_fetch_assoc($combin);
	  }
	?>
							</select>
						</div></td></tr>
	<?php
	}
	?>
					<tr>
					 
					  <td class='resViewhd' nowrap><div align="left">Cohort of the  Year: </div></td>
					  <td class='resViewtd'><div align="left">
						<select name="cohot" id="cohot">
							<?php
	do {  
	?>
							<option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
							<?php
	} while ($row_ayear = mysqli_fetch_assoc($ayear));
	  $rows = mysqli_num_rows($ayear);
	  if($rows > 0) {
		  mysqli_data_seek($ayear, 0);
		  $row_ayear = mysqli_fetch_assoc($ayear);
	  }
	?>
						</select>
					  </div></td>
					</tr>
	<tr><td class='resViewhd' nowrap><div align="left">Graduating Year: </div></td>
					  <td class='resViewtd'><div align="left">
						<select name="ayear" id="ayear">
							<?php
	do {  
	?>
							<option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
							<?php
	} while ($row_ayear = mysqli_fetch_assoc($ayear));
	  $rows = mysqli_num_rows($ayear);
	  if($rows > 0) {
		  mysqli_data_seek($ayear, 0);
		  $row_ayear = mysqli_fetch_assoc($ayear);
	  }
	?>
						</select>
					  </div></td>
					</tr>
					
					<tr>
					 
					  <td class='resViewhd' nowrap colspan='2'><input type="submit" name="PDF"  id="PDF" value="Print PDF"onmouseover="this.style.background='#DEFEDE'"
	onmouseout="this.style.background='lightblue'" style='background-color:lightblue;color:black;font-size:9pt;font-weight:bold' title="Click to Create a PDF File"></td>
					</tr>
				  </table>
	<input name="checkyear" type="hidden" id="checkyear" value="on" checked>
	<input name="checkcombin" type="hidden" id="checkcombin" value="on" checked>
	<input name="checkcohot" type="hidden" id="checkcohot" value="on" checked>
	<input name="layout" type="hidden" value="L" checked>
	<input name="paper" type="hidden" value="a4" checked>
				  <input name="MM_update" type="hidden" id="MM_update" value="form1">       
	 
	</form>
	</fieldset>
	<?php
	}
	else{

	?>
	<fieldset>
	<legend>Select a Degree Programme </legend>
					
	<form name="form2" method="post" action="<?php echo $editFormAction ?>">
				<table class='resView' width="200">
				
					<tr>
					  <td class='resViewhd' nowrap><div align="left">Degree Programme:</div></td>
					  <td class='resViewtd'>
						  <div align="left">
							<select name="degree" id="degree">
							  <?php
	do {  
	?>
							  <option value="<?php echo $row_degree['ProgrammeCode']?>"><?php echo $row_degree['ProgrammeName']?></option>
							  <?php
	} while ($row_degree = mysqli_fetch_assoc($degree));
	  $rows = mysqli_num_rows($degree);
	  if($rows > 0) {
		  mysqli_data_seek($degree, 0);
		  $row_degree = mysqli_fetch_assoc($degree);
	  }
	?>
							</select>
						</td>

					 
					  <td class='resViewhd' nowrap><input type="submit" name="programme"  id="programme" value="GO"onmouseover="this.style.background='#DEFEDE'"
	onmouseout="this.style.background='lightblue'" style='background-color:lightblue;color:black;font-size:9pt;font-weight:bold' title="Click to Continue Create a PDF File"></td>
					</tr>
				  </table>
				  <input name="MM_updatep" type="hidden" id="MM_update" value="form2">       
	</form>
	</fieldset>
	<?php
		if(isset($_GET['error'])){
			$errors = urldecode($_GET['error']);
			echo "<p style='color:maroon'>".$errors."</p>";
			}
	}
	echo"<br><br>";
	include('../footer/footer.php');
?>


