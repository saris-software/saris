<?php 
#start pdf
if (isset($_POST['PrintPDF']) && ($_POST['PrintPDF'] == "Print PDF")) {
	#get post variables
	$rawkey = addslashes(trim($_POST['key']));
	$inst= addslashes(trim($_POST['cmbInst']));
	$cat= addslashes(trim($_POST['cat']));
	$award= addslashes(trim($_POST['award']));
	$key = preg_replace("[[:space:]]+", " ",$rawkey);
	#get content table raw height
	$rh= addslashes(trim($_POST['sex']));

	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php');
	
	#process report title
	if($cat=='1'){
	$rtitle='STATEMENT OF EXAMINATIONS RESULTS';
	$xtitle = 180;
	}elseif($cat=='2'){
	$rtitle='PROGRESS REPORT ON STUDENT ACADEMIC PERFORMANCE';
	$xtitle = 130;
	}
	$titlelenth = strlen($inst);
	if ($titlelenth<30){
	$xinst = 190;
	}else{
	$xinst = 161;
	}
	
	#check if u belongs to this faculty
	$qFacultyID = "SELECT FacultyID from faculty WHERE FacultyName = '$inst'";
	$dbFacultyID = mysqli_query($zalongwa, $qFacultyID);
	$rowFacultyID = mysqli_fetch_array($dbFacultyID);
	$studentFacultyID = $rowFacultyID['FacultyID'];

	include('includes/PDF.php');
	$i=0;
	$pg=1;
	$tpg =$pg;
	//select student
	$qstudent = "SELECT * from student WHERE RegNo = '$key'";
	$dbstudent = mysqli_query($zalongwa, $qstudent) or die("Mwanafunzi huyu hana matokeo".  mysqli_error());
	$row_result = mysqli_fetch_array($dbstudent);
		$sname = $row_result['Name'];
		$regno = $row_result['RegNo'];
		$deg = $row_result['ProgrammeofStudy'];
		$sex = $row_result['Sex'];
		$dbirth = $row_result['DBirth'];
		$entry = $row_result['EntryYear'];
		$faculty = $row_result['Faculty'];
		$citizen = $row_result['Nationality'];
		$address = $row_result['paddress'];
		$gradyear = $row_result['GradYear'];
		$admincriteria = $row_result['MannerofEntry'];
		$campusid = $row_result['Campus'];
		$faculty = $row_result['Faculty'];
		$subject = $row_result['Subject'];
		#get campus name
		$qcampus = "SELECT Campus FROM campus where CampusID='$campusid'";
		$dbcampus = mysqli_query($zalongwa, $qcampus);
		$row_campus= mysqli_fetch_assoc($dbcampus);
		$campus = $row_campus['Campus'];

		//get degree name
		$qdegree = "Select Title, Ntalevel from programme where ProgrammeCode = '$deg'";
		$dbdegree = mysqli_query($zalongwa, $qdegree);
		$row_degree = mysqli_fetch_array($dbdegree);
		$programme = $row_degree['Title'];
                $nta = $row_degree['Ntalevel'];
$award= addslashes(trim($_POST['award']));
$rawkey = $_POST['key'];


	$fby=$_POST['fbyyear'];
    $yearofstudy=$_POST['studyYear'];
	#get content table raw height
	$rh= addslashes(trim($_POST['sex']));
	
#CONVERT NTA LEVEL
	if($award==1){
		$nta='NTA LEVEL 8';
	}elseif($award==6){
		$nta='NTA LEVEL 7';
		$award=1;
	}elseif($award==2){
		$nta='NTA LEVEL 6';
	}elseif($award==3){
		$nta='NTA LEVEL 5';
	}elseif($award==4){
		$nta='NTA LEVEL 4';
	}elseif($award==5){
		$nta='Short Course';
	}

    
	$pdf = &PDF::factory('p', 'a4');      // Set up the pdf object. 
	$pdf->open();                         // Start the document. 
	$pdf->setCompression(true);           // Activate compression. 
	$pdf->addPage();  
	#put page header
	
	#print header
	$pdf->image('../images/logo.jpg', 45, 41);   
	$pdf->setFont('Arial', 'I', 8);      
	$pdf->text(530.28, 820.89, 'Page '.$pg);   
	#print header for landscape paper layout 
	$pdf->setFont('Arial', 'B', 21.5); 
	$pdf->text(50, 50, strtoupper($org));   
	
	#University Addresses
	$pdf->setFont('Arial', '', 13.3);    
	$pdf->text($xinst-10, 90, 'DEPARTMENT OF '.strtoupper($faculty));
	$pdf->setFont('Arial', '', 13);    
	$pdf->text($xtitle, 129, $rtitle); 
	$pdf->setFillColor('rgb', 0, 0, 0);   

	#title line
	$pdf->line(50, 135, 570, 135);

	$pdf->setFont('Arial', 'B', 10.3);     
	#set page header content fonts
	#line1
	$pdf->line(50, 135, 50, 147);       
	$pdf->line(333, 135, 333, 147);       
	$pdf->line(382, 135, 382, 147);
	$pdf->line(570, 135, 570, 147);       
	$pdf->line(50, 147, 570, 147); 

	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(50, 145, 'NAME:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(90, 145, $sname); 
	$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text(335, 145, 'SEX:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(365, 145, $sex); 
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(385, 145, 'RegNo.:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(430, 145, $regno); 
	
	
	#line2
	$pdf->line(50, 147, 50, 159);       
	$pdf->line(188, 147, 188, 159);       
	$pdf->line(570, 147, 570, 159);       
	$pdf->line(50, 159, 570, 159); 
	
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(50, 157, 'CITIZENSHIP:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(118, 157, $citizen); 
	$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text(190, 157, 'ADDRESS:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(250, 157, $address); 
	
	#line3
	$pdf->line(50, 159, 50, 171);       
	$pdf->line(188, 159, 188, 171);       
	//$pdf->line(383, 159, 383, 171);       
	$pdf->line(570, 159, 570, 171);       
	$pdf->line(50, 171, 570, 171); 

	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(50, 169, 'BIRTH DATE:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(120, 169, $dbirth); 
	$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text(190, 169, 'ADMITTED:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(250, 169, $entry); 
	#line5
	$pdf->line(50, 171, 50, 183);       
	//$pdf->line(268, 183, 268, 194);       
	$pdf->line(570, 171, 570, 183);       
	$pdf->line(50, 183, 570, 183); 

	$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text(50, 181, 'CAMPUS:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(110, 181, $campus); 
    
	#line6
	$pdf->line(50, 183, 50, 195);       
	$pdf->line(570, 183, 570, 195);       
	$pdf->line(50, 195, 570, 195); 
	$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(50, 193, 'NAME OF PROGRAMME:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(175, 193, $programme); 
       #line 7
        #line7
 
		$pdf->line(50,195 , 50, 210);       
		$pdf->line(570, 195, 570, 210);       
		$pdf->line(50, 210, 570, 210); 
		$pdf->setFont('Arial', 'B', 10.3);  $pdf->text(50, 205, 'AWARDS LEVEL:'); $pdf->setFont('Arial', 'I', 10.3); $pdf->text(140, 205, $nta.' (Programme Accredited by the National Council for Technical Education)'); 

        
        $ytitle = 130;
	include 'includes/transcript_results.php';

				if ($award==1){
					if($avgGPA>=4.4){
							if ($checksupp ==1){
								$degree = 'First Class';
							}else{
								$degree = 'First Class (Honours)';
							}
						}elseif($avgGPA>=3.5){
							if ($checksupp ==1){
								$degree = 'Uppersecond Class';
							}else{
								$degree = 'Uppersecond Class (Honours)';
							}
						}elseif($avgGPA>=2.7){
							if ($checksupp ==1){
								$degree = 'Lowersecond Class';
							}else{
								$degree = 'Lowersecond Class (Honours)';
							}
						}elseif($avgGPA>=2.0){
							$degree = 'Pass';
						}else{
							$degree = 'FAIL';
						}
				}elseif($award==2){
					if($avgGPA>=4.4){
							if ($checksupp ==1){
								$degree = 'First Class';
							}else{
								$degree = 'First Class (Honours)';
							}
						}elseif($avgGPA>=3.5){
							if ($checksupp ==1){
								$degree = 'Uppersecond Class';
							}else{
								$degree = 'Uppersecond Class (Honours)';
							}
						}elseif($avgGPA>=2.7){
							if ($checksupp ==1){
								$degree = 'Lowersecond Class';
							}else{
								$degree = 'Lowersecond Class (Honours)';
							}
						}elseif($avgGPA>=2.0){
							$degree = 'Pass';
						}else{
							$degree = 'FAIL';
						}
				}elseif($award==3){
					if($avgGPA>=4.4){
							if ($checksupp ==1){
								$degree = 'First Division';
							}else{
								$degree = 'First Division  (Honours)';
							}
						}elseif($avgGPA>=3.5){
							if ($checksupp ==1){
								$degree = 'Second Division';
							}else{
								$degree = 'Second Division (Honours)';
							}
						}elseif($avgGPA>=2.7){
							if ($checksupp ==1){
								$degree = 'Third Division';
							}else{
								$degree = 'Third Division (Honours)';
							}
						}elseif($avgGPA>=2.0){
							$degree = 'Pass';
						}else{
							$degree = 'FAIL';
						}
				}

				if($cat=='1'){
					//if(($degree==632)||($degree==633)||($degree==635)){
					$gpa = substr($annualPoints/$annualUnits, 0,3);
					
					if($gpa == '5'){
						$gpa = '5.0';
						}
					elseif($gpa == '4'){
						$gpa = '4.0';
						}
					elseif($gpa == '3'){
						$gpa = '3.0';
						}
					elseif($gpa == '2'){
						$gpa = '2.0';
						}
					elseif($gpa == '1'){
						$gpa = '1.0';
						}
					$pdf->setFont('Arial', 'B', 10.3);  $pdf->text($x, $y+24, 'OVERALL G.P.A.:'); $pdf->text($x+95, $y+24, $gpa);
					//$pdf->setFont('Arial', 'B', 10.3); 	$pdf->text($x+220, $y+24, 'CLASSIFICATION:'); $pdf->text($x+320, $y+24, $degreeclass);
					$pdf->line($x, $y+27, 570.28, $y+27); 
					}else{
					$pdf->setFont('Arial', 'B', 10.3);  $pdf->text($x, $y+24, 'OVERALL PERFORMANCE:'); $pdf->text($x+145, $y+24, 'PASS');
					$pdf->line($x, $y+27, 570.28, $y+27); 
					//}
				}
				
				#get officer fullname
				$qname="SELECT FullName FROM security WHERE UserName='$username'";
				$dbname=mysqli_query($zalongwa, $qname);
				$row_name=mysqli_fetch_assoc($dbname);
				$ofname=$row_name['FullName'];
				#see if we have a space to rint signature
				$b=$y+17;
				if ($b<820.89){
				#print signature lines
				$pdf->text($x+190, $y+47, '.................................................');    						
				$pdf->text($x+200, $y+57, strtoupper($ofname));  
				$pdf->text($x+195, $y+70, 'EXAMINATIONS OFFICER');   						
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
			$pdf->text(50, 820.89, $city.', '.$today = date("d-m-Y H:i:s")); 
			$yind = $y; 
    }
	include 'includes/transcriptkeys.php';
	#print the file
	$pdf->output($key.'.pdf');              // Output the 
}/*ends is isset*/
#ends pdf
#get connected to the database and verfy current session
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
# initialise globals
include('lecturerMenu.php');

# include the header
global $szSection, $szSubSection;
$szSection = 'Examination';
$szSubSection = 'Cand. Statement';
$szTitle = 'Student\'s Statement of Examination Results';
include('lecturerheader.php');

mysqli_select_db($zalongwa, $database_zalongwa);
$query_campus = "SELECT FacultyName FROM faculty WHERE FacultyID='$userFaculty' ORDER BY FacultyName ASC";
$campus = mysqli_query($zalongwa, $query_campus) or die(mysqli_error());
$row_campus = mysqli_fetch_assoc($campus);
$totalRows_campus = mysqli_num_rows($campus);


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

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">
            <table width="284" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
          <td colspan="9" nowrap><div align="center"></div>
          </td>
        </tr>
        <tr>
          <td width="110"><div align="right"><strong></strong></div></td>
          <td colspan="8" bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
            <input name="cmbInst" type="hidden" id="cmbInst" value="<?php echo $row_campus['FacultyName']?>">
          </span></td>
        </tr>
        <tr>
          <td nowrap><div align="right"><strong>Programme:
            </strong></div>            <div align="center"></div></td>
          <td colspan="2" nowrap><div align="right">Degree</div></td>
          <td width="31" nowrap><input type="radio" value="1" id="award1" name="award" checked></td>
          <td colspan="2" nowrap><div align="right">Diploma</div></td>
          <td width="31" nowrap><input type="radio" value="2" id="award2" name="award" ></td>
          <td width="89" nowrap><div align="right">Certificate</div></td>
		  <td width="30" nowrap><input type="radio" value="3" id="award2" name="award" ></td>
        </tr>
		<tr> 
		<td align="right"><strong>Category:</strong></td> 
		<td colspan="4">Finalist:
		  <input type="radio" value="1" id="cat" name="cat" >  </td> 
		<td colspan="4">Continuing:
		  <input type="radio" value="2" id="cat" name="cat" checked>
		</td>
		</tr> 
		<tr>
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
              <option value="5">Certificate</option>
              <option value="7">Diploma</option>
              <option value="8">Adv. Diploma</option>
              <option value="9">Short Course</option>
            </select>
            </div>            <div align="right"></div>            <div align="right"></div></td>
        </tr>
        <tr><td><div align="right"><strong>By Year:
            </strong></div></td><td>Yes</td><td nowrap colspan="3"><input type="radio" name="fbyyear" value="yes" id="fby1"/></td><td>No</td><td nowrap colspan="3"><input type="radio" name="fbyyear" value="no" id="fby2" checked="checked"/></td></tr>
        <tr>
         <tr id="transyear">
          <td align="right" nowrap><strong>Study Year:</strong></td>
          <td colspan="8" bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
          <select name='studyYear' id="ayearsel">
              <option value="1">First Year</option>
			  <option value="2">Second Year</option>
			  <option value="3">Third Year</option>
			  <option value="4">Fourth Year</option>
          </select>
          </span></td>
        </tr>
         
          <td><div align="right"><strong><span class="style67">RegNo:</span></strong></div></td>
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
			<td width="35"> <div align="center">-</div></td> 
			<td><div align="left">17
		      <input type="radio" value="17" id="sex" name="sex" >
			</div></td>
		</tr>
        <tr>
          <td nowrap><div align="right"><strong> </strong></div></td>
          <td bgcolor="#CCCCCC" colspan="4">
            <div align="left">
              <input type="submit" name="search" value="PreView">
            </div></td>
          <td bgcolor="#CCCCCC" colspan="4"><div align="right">
            <input name="PrintPDF" type="submit" id="PrintPDF" value="Print PDF">
          </div></td>
        </tr>
  </table>
</form>
<?php
}
include('../footer/footer.php');
?>
