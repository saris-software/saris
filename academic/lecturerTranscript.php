<?php 
#start pdf
if (isset($_POST['PrintPDF']) && ($_POST['PrintPDF'] == "Print PDF")) {
	#get post variables
	$rawkey = addslashes(trim($_POST['key']));
	$key = preg_replace("[[:space:]]+", " ",$rawkey);
	
	$fby=$_POST['fbyyear'];
	$compareyear=$_POST['compareyear'];
    $yearofstudy=$_POST['studyYear'];
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
	$certarray = array();
	#query list of basic certificate programs
	$qcert = mysqli_query($zalongwa, "SELECT programmecode FROM programme WHERE title LIKE '%certificate%'") or die(mysqli_error($zalongwa));
	$qcertnum = mysqli_num_rows($qcert);
	while($row_cert = mysqli_fetch_assoc($qcert)){
		$certarray[] = $row_cert['programmecode'];
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
                $sponsor = $row_result['Sponsor'];
		$dbirth = $row_result['DBirth'];
		$entry = $row_result['EntryYear'];
		$citizen = $row_result['Nationality'];
		$address = $row_result['paddress'];
		$gradyear = $row_result['GradYear'];
		$admincriteria = $row_result['MannerofEntry'];
		$campusid = $row_result['Campus'];
		$subjectid = $row_result['Subject'];
		$photo = $row_result['Photo'];
		$checkit = strlen($photo);
		#get campus name
		$qcampus = "SELECT Campus FROM campus where CampusID='$campusid'";
		$dbcampus = mysqli_query($zalongwa,$qcampus);
		$row_campus= mysqli_fetch_assoc($dbcampus);
		$campus = $row_campus['Campus'];
		
		if ($checkit > 8){
			include '../includes/photoformat.php';
		}else{
			$nophoto = 1;
		}
	#resize photo

	
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
       $rawkey = $_POST['key'];
$fby=$_POST['fbyyear'];
$yearofstudy=$_POST['studyYear'];
$award= addslashes(trim($_POST['award']));
$key = preg_replace("[[:space:]]+", " ",$rawkey);
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
  
	$pdf->text(170, $ytitle, 'TRANSCRIPT OF EXAMINATIONS RESULTS'); 
	$pdf->setFillColor('rgb', 0, 0, 0);    

	#title line
	$pdf->line(50, $ytitle+3, 570, $ytitle+3);

	$pdf->setFont('Arial', 'B', 10.3);     
	#set page header content fonts
	#line1
	$pdf->line(50, $ytitle+3, 50, $ytitle+18);       
	$pdf->line(333, $ytitle+3, 333, $ytitle+18);       
	$pdf->line(382, $ytitle+3, 382, $ytitle+18);
	$pdf->line(570, $ytitle+3, 570, $ytitle+18);       
	$pdf->line(50, $ytitle+18, 570, $ytitle+18); 
	#format name
	$candname = explode(",",$sname);
	$surname = $candname[0];
	$othername = $candname[1];

	$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(52, $ytitle+15, 'AWARD HOLDER:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(136, $ytitle+15, strtoupper(stripslashes($surname)).', '.ucwords(strtolower(stripslashes($othername)))); 
	$pdf->setFont('Arial', 'B', 9.3); 	$pdf->text(335, $ytitle+15, 'SEX:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(365, $ytitle+15, $sex); 
	$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(385, $ytitle+15, 'REGNO.:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(430, $ytitle+15, $regno); 
	
	#line2
	$pdf->line(50, $ytitle+18, 50, $ytitle+30);       
	$pdf->line(188, $ytitle+18, 188, $ytitle+30);       
	$pdf->line(570, $ytitle+18, 570, $ytitle+30);       
	$pdf->line(50, $ytitle+30, 570, $ytitle+30); 
	
	$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(52, $ytitle+27, 'CITIZENSHIP:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(118, $ytitle+27, $citizen); 
	$pdf->setFont('Arial', 'B', 9.3); 	$pdf->text(190, $ytitle+27, 'ADDRESS:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(250, $ytitle+27, $address); 
	#line3
	$pdf->line(50, $ytitle+30, 50, $ytitle+42);       
	$pdf->line(188, $ytitle+30, 188, $ytitle+42);       
	$pdf->line(383, $ytitle+30, 383, $ytitle+42);       
	$pdf->line(570, $ytitle+30, 570, $ytitle+42);       
	$pdf->line(50, $ytitle+42, 570, $ytitle+42); 
	
	#Format grad year
	$graddate = explode("-",$gradyear);
	$gradday = $graddate[2];
	$gradmon = $graddate[1];
	$grady = $graddate[0];

	$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(52, $ytitle+39, 'BIRTH DATE:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(120, $ytitle+39, $dbirth); 
	$pdf->setFont('Arial', 'B', 9.3); 	$pdf->text(190, $ytitle+39, 'ADMITTED:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(250, $ytitle+39, $entry); 
	$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(385, $ytitle+39, 'COMPLETED:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(456, $ytitle+39, $gradday.' - '.$gradmon.' - '.$grady); 
/*
	#line4
	$pdf->line(50, $ytitle+39, 50, $ytitle+51);       
	$pdf->line(570, $ytitle+39, 570, $ytitle+51);       
	$pdf->line(50, $ytitle+51, 570, $ytitle+51); 
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(50, $ytitle+49, 'ADMITTED ON THE BASIS OF:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(205, $ytitle+49, $admincriteria); 
	*/
	#line5
	$pdf->line(50, $ytitle+42, 50, $ytitle+54);       
	$pdf->line(310, $ytitle+42, 310, $ytitle+54);       
	$pdf->line(570, $ytitle+42, 570, $ytitle+54);       
	$pdf->line(50, $ytitle+54, 570, $ytitle+54); 

	$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(52, $ytitle+51, 'CAMPUS:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(100, $ytitle+51, $campus); 
	$pdf->setFont('Arial', 'B', 9.3); 	$pdf->text(312, $ytitle+51, 'DEPARTMENT:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(387, $ytitle+51, $faculty); 

	#line6
	$pdf->line(50, $ytitle+54, 50, $ytitle+66);       
	$pdf->line(570, $ytitle+54, 570, $ytitle+66);       
	$pdf->line(50, $ytitle+66, 570, $ytitle+66); 
	$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(52, $ytitle+63, 'NAME OF PROGRAMME:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(175, $ytitle+63, $programme); 

	#line7
 
		$pdf->line(50, $ytitle+66, 50, $ytitle+78);       
		$pdf->line(570, $ytitle+66, 570, $ytitle+78);       
		$pdf->line(50, $ytitle+78, 570, $ytitle+78); 
		$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(52, $ytitle+75, 'AWARDS LEVEL:'); $pdf->setFont('Arial', 'I', 9.3); $pdf->text(135, $ytitle+75, $ntalevel.' (Programme Accredited by the National Council for Technical Education)'); 


$pdf->line(50, $ytitle+78, 50, $ytitle+90);       

		$pdf->line(570, $ytitle+78, 570, $ytitle+90);       

		$pdf->line(50, $ytitle+90, 570, $ytitle+90); 

		$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(52, $ytitle+87, 'SPONSOR:'); 

		$pdf->setFont('Arial', 'I', 9.3); $pdf->text(120, $ytitle+87, $sponsor); 




	$sub =$subjectid;
	if($sub<>0){
		#line7
		$pdf->line(50, $ytitle+78, 50, $ytitle+90);       
		$pdf->line(570, $ytitle+78, 570, $ytitle+90);       
		$pdf->line(50, $ytitle+90, 570, $ytitle+90); 
		$pdf->setFont('Arial', 'B', 9.3);  $pdf->text(50, $ytitle+87, 'MAJOR STUDY AREA:'); $pdf->text(175, $ytitle+87,$subject); 
	}
	if ($compareyear == 'yes'){
	include 'includes/transcript_results_less2012.php';
	}else{
	include 'includes/transcript_results.php';
}
	#specify degree classification
	// check_if_qualify to honour degree
	include 'includes/check_honour_degree.php';
	if ($award==1){
		if($avgGPA>=4.4){
             if ($cheksupp == 1){
				$degreeclass = 'First Class';
			}else{ 
				$degreeclass = 'First Class';
			}}elseif($avgGPA>=3.5){
				if ($cheksupp == 1){
				$degreeclass = 'Upper Second Class';
			}else{
				$degreeclass = 'Upper Second Class';
			}}elseif($avgGPA>=2.7){
				if ($cheksupp == 1){
				$degreeclass = 'Lower Second Class';
			}else{
				$degreeclass = 'Lower Second Class';
			}}elseif($avgGPA>=2.0){
				$degreeclass = 'Pass';
			}else{
				$degreeclass = 'FAIL';
			}
	}elseif($award==2){
	if($avgGPA>=4.4){
             if ($cheksupp == 1){
				$degreeclass = 'First Class';
			}else{ 
				$degreeclass = 'First Class';
			     }
			}elseif($avgGPA>=3.5){
				if ($cheksupp == 1){
				$degreeclass = 'Upper Second Class';
			}else{
				$degreeclass = 'Upper Second Class';
			    }
			}elseif($avgGPA>=2.7){
				if ($cheksupp == 1){
				$degreeclass = 'Lower Second Class';
			}else{
				$degreeclass = 'Lower Second Class';
				}
			}elseif($avgGPA>=2.0){
				$degreeclass = 'Pass';
			}else{
				$degreeclass = 'FAIL';
			}
	}elseif($award==3){
		if($avgGPA>=3.5){
			if ($checksupp==1){
				$degreeclass = 'First Class';
			}else{
				$degreeclass = 'First Class';
			}
			}elseif($avgGPA>=3.0){
				if ($checksupp==1){
				$degreeclass = 'Second Class';
			}else{
				$degreeclass = 'Second Class';
			}
			}elseif($avgGPA>=2.0){
				$degreeclass = 'Pass';
			}else{
				$degreeclass = 'FAIL';
			}
	}elseif($award==4){
		if($avgGPA>=3.5){
			if ($checksupp==1){
				$degreeclass = 'First Class';
			}else{
				$degreeclass = 'First Class';
				}
			}elseif($avgGPA>=3.0){
				if ($checksupp==1){
				$degreeclass = 'Second Class';
			}else{
				$degreeclass = 'Second Class';
				}
			}elseif($avgGPA>=2.0){
				$degreeclass = 'Pass';
			}else{
				$degreeclass = 'FAIL';
			}
	}elseif($award==5){
		if($avgGPA>=3.5){
			if ($checksupp==1){
				$degreeclass = 'First Class';
			}else{
				$degreeclass = 'First Class';
				}
			}elseif($avgGPA>=3.0){
				if ($checksupp==1){
				$degreeclass = 'Second Class';
			}else{
				$degreeclass = 'Second Class';
				}
			}elseif($avgGPA>=2.0){
				$degreeclass = 'Pass';
			}else{
				$degreeclass = 'FAIL';
			}
	}elseif($award==6){
		if($avgGPA>=3.5){
			if ($checksupp==1){
				$degreeclass = 'First Class';
			}else{
				$degreeclass = 'First Class';
				}
			}elseif($avgGPA>=3.0){
				if ($checksupp==1){
				$degreeclass = 'Second Class';
			}else{
				$degreeclass = 'Second Class';
				}
			}elseif($avgGPA>=2.0){
				$degreeclass = 'Pass';
			}else{
				$degreeclass = 'FAIL';
			}
	}elseif($award==7){
		if($avgGPA>=3.5){
			if ($checksupp==1){
				$degreeclass = 'First Class';
			}else{
				$degreeclass = 'First Class';
			}
			}elseif($avgGPA>=3.0){
				if ($checksupp==1){
				$degreeclass = 'Second Class';
			}else{
				$degreeclass = 'Second Class';
			}
			}elseif($avgGPA>=2.0){
				$degreeclass = 'Pass';
			}else{
				$degreeclass = 'FAIL';
			}
	}elseif($award==8){
		if($avgGPA>=3.5){
			if ($checksupp==1){
				$degreeclass = 'First Class';
			}else{
				$degreeclass = 'First Class';
			}
			}elseif($avgGPA>=3.0){
				if ($checksupp==1){
				$degreeclass = 'Second Class';
			}else{
				$degreeclass = 'Second Class';
			}
			}elseif($avgGPA>=2.0){
				$degreeclass = 'Pass';
			}else{
				$degreeclass = 'FAIL';
			}
	}elseif($award==9){
		if($avgGPA>=3.5){
			if ($checksupp==1){
				$degreeclass = 'First Class';
			}else{
				$degreeclass = 'First Class';
			}
			}elseif($avgGPA>=3.0){
				if ($checksupp==1){
				$degreeclass = 'Second Class';
			}else{
				$degreeclass = 'Second Class';
			}
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
		$pdf->setFont('Arial', 'B', 10.3);  $pdf->text($x, $y+24, 'OVERALL G.P.A.:'); $pdf->text($x+95, $y+24, $avgGPA);
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
	$pdf->text(59.28, $y+57, '.........................                             .........................................                       ................................');
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
require_once('examination.php');

# include the header
global $szSection, $szSubSection;
$szSection = 'Examination';
$szSubSection = 'Cand. Transcript';
$szTitle = 'Transcript of Examination Results';
//require_once('lecturerheader.php');

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
include 'includes/showexamresults.php';

}else{

?>



<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div align select="center">
<div class="container" style="width:55%">


<div class="form-group">

<button><a href="lecturerTranscriptcount.php">Transcript Report</a></button>
</div>


<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">


<div class="form-group">
  <input type="hidden" value="1" id="temp" name="temp">
              <label for="institution">Award:</label>
      <select class="form-control" name="award" id="award">
              <option value="1" selected>NTA Level 8</option>
              <option value="6">NTA Level 7</option>
              <option value="2">NTA Level 6 </option>
              <option value="3">NTA Level 5</option>
              <option value="4">NTA Level 4</option>
              <option value="5">Certificate</option>
              <option value="7">Diploma</option>
              <option value="8">Adv. Diploma</option>
              <option value="9">Short Course</option>
            </select>
            </div>  


<div class="form-group">
  <input type="hidden" value="1" id="temp" name="temp">
              <label for="institution">Year:</label>
      <select class="form-control" name="year" id="year">
      <option value="1" selected>2012/2013</option>
              <option value="6">2013/2014</option>
              <option value="2">2014/2015 </option>
              <option value="3">2015/2016</option>
              <option value="4">2016/2017</option>
              <option value="5">2017/2018</option>
              <option value="7">2018/2019</option>
              <option value="8">2019/2020</option>
            </select>
            </div>
      
      
<div class="form-group">
  <input type="hidden" value="1" id="temp" name="">
              <label for="institution">:</label>
  <label>Yes<input type="radio" name="compareyear" value="yes" id="lessthan"/>No<input type="radio" name="compareyear" value="no" id="greaterthan" checked="checked"/></label>
        </div>
       
<div class="form-group">
  <input type="hidden" value="1" id="temp" name="">
              <label for="institution">
              By Year:</label>
      <select class="form-control" name="fbyyear" id="fbyyear">
      <option value="yes" selected>Yes</option>
              <option value="no">No</option>
      </div>     
              
<div class="form-group">
  <input type="hidden" value="1" id="temp" name="">
              <label for="institution">
              Study Year:</label>
          <select class="form-control" name='studyYear' id="ayearsel">
              <option value="1">First Year</option>
			  <option value="2">Second Year</option>
			  <option value="3">Third Year</option>
			  <option value="4">Fourth Year</option>
          </select>
         </div>
<div class="form-group">
  <input type="hidden" value="1" id="temp" name="">
              <label for="institution">Reg No:</label>
          <input  class="form-control" name="key" type="text" id="key" size="40" maxlength="40">
</div>


<div class="form-group">
  <input type="hidden" value="1" id="temp" name="temp">
              <label for="institution">Table:</label>
      <select class="form-control" name="sex" id="sex">
      <option value="11" selected>11</option>
              <option value="12">12</option>
              <option value="13">13 </option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option>-</option>
              <option value="17">17</option>
            </select>
            </div>
      

          <!--  <td nowrap><div align="right"><strong>2012/2013:</td>
            </strong></div></td><td>Yes</td><td nowrap colspan="2"><input type="radio" name="compareyear" value="yes" id="lessthan"/></td><td>No</td><td nowrap colspan="1"><input type="radio" name="compareyear" value="no" id="greaterthan" checked="checked"/></td></tr>
        </tr>-->
  
<div class="form-group">
  <input type="hidden" value="1" id="temp" name="">
              <label for="institution">
              Confirmed:</label>
      <select class="form-control" name="real" id="real">
      <option value="1" selected>Yes</option>
              <option value="2">No</option>
     </select>
      </div>     
        
            <div style="text-align:center">
            
<div class="form-group" s>
  
            <label>  <input  type="submit" name="search" value="PreView"> </label>
             <label> <input   name="PrintPDF" type="submit" id="PrintPDF" value="Print PDF"> </label>
            </div></div>
</form>
<p>&nbsp;</p>
<?php
}
include('../footer/footer.php');
?>
