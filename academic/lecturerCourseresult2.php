<?php 
#start pdf
if (isset($_POST['PDF']) && ($_POST['PDF'] == "Print PDF")){
//if (isset($_POST['search']) && ($_POST['search'] == "Search Results")) { 

	#get post variables
	//$rawkey = addslashes(trim($_POST['key']));
	//$key = ereg_replace("[[:space:]]+", " ",$rawkey);
	$year = trim(addslashes($_POST['ayear']));
	$coursecode = trim(addslashes($_POST['Hall']));	
	$deg=addslashes($_POST['degree']);
	$layout = addslashes($_POST['layout']);
	$show = addslashes($_POST['show']);
	
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php');
				
	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
	$dborg = mysqli_query($zalongwa, $qorg);
	$row_org = mysqli_fetch_assoc($dborg);
	$org = $row_org['Name'];
	$address = $row_org['Address'];
	$phone = $row_org['tel'];
	$fax = $row_org['fax'];
	$email = $row_org['email'];
	$website = $row_org['website'];
	$city = $row_org['city'];
	
	# get all students for this course
	if ($deg==0){
	#print all students
	$qregno="SELECT DISTINCT examresult.RegNo FROM 
				 examresult LEFT JOIN student 
					 ON (examresult.RegNo) = (student.RegNo)
					  WHERE (AYear='$year' AND CourseCode = '$coursecode') ORDER BY student.Name";	
	}else{
	#print specific students
	$qregno="SELECT DISTINCT examresult.RegNo FROM 
				 examresult LEFT JOIN student 
					 ON (examresult.RegNo) = (student.RegNo)
					  WHERE (AYear='$year' AND CourseCode = '$coursecode' AND ProgrammeofStudy = '$deg') ORDER BY student.Name";	
	}
	
	$dbregno = mysqli_query($zalongwa, $qregno) or die("No Exam Results for the course - $coursecode - in the year - $year ");
	$total_rows = mysqli_num_rows($dbregno);
	
	if($total_rows>0){
		#getcourse information
		$qcourseinfo = "SELECT * FROM course WHERE coursecode = '$coursecode'";
		$dbcourseinfo = mysqli_query($zalongwa, $qcourseinfo);
		$row_courseinfo = mysqli_fetch_assoc($dbcourseinfo);
		$coursename=$row_courseinfo['CourseName'];
		$coursedept=$row_courseinfo['Department'];
		$courseprog=$row_courseinfo['Programme'];
		$courseunit=$row_courseinfo['Units'];
		$courseyear=$row_courseinfo['YearOffered'];
		$levelcode=$row_courseinfo['StudyLevel'];
		#get study level name
		$qlevel = "SELECT StudyLevel FROM programmelevel WHERE Code='$levelcode'";
		$dblevel = mysqli_query($zalongwa, $qlevel);
		$row_level = mysqli_fetch_assoc($dblevel);
		$level = $row_level['StudyLevel'];
		
		#start pdf
		include('includes/PDF.php');
		$pdf = &PDF::factory('p', 'a4');      // Set up the pdf object. 
		$pdf->open();                         // Start the document. 
		$pdf->setCompression(true);           // Activate compression. 
		$pdf->addPage();  
		$pdf->setFont('Arial', 'I', 8);     
		$pdf->text(530.28, 825.89, 'Page '.$pg);   
		$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   

		#put page header
	
		$x=60;
		$y=50;
		$i=1;
		$pg=1;
		$pdf->text(530.28, 825.89, 'Page '.$pg);   

		//$i=1;
		#count unregistered
		$j=0;
		#count sex
		$fmcount = 0;
		$mcount = 0;
		$fcount = 0;
		#print NACTE FORM EXAM 0.3
		$pdf->setFont('Arial', 'B', 8); 
		if (strtoupper($level)!='TRADITIONAL SYSTEM')  
		{
			$pdf->text(50,$y-12, 'NTI/NAC.EX-FORM 14');
		}

		#print header for landscape paper layout 
		include '../includes/orgname.php';
		
		$pdf->setFillColor('rgb', 0, 0, 0);    
		$pdf->setFont('Arial', '', 10);  
		$pdf->text($x+6, $y+14, 'DEPARTMENT OF '.strtoupper($coursedept)); 
		#get programme name
		$qcprog ="SELECT Title FROM programme WHERE ProgrammeCode='$deg'";
		$dbcprog = mysqli_query($zalongwa, $qcprog);
		$row_cprog =mysqli_fetch_assoc($dbcprog);
		$pdf->text($x+6, $y+28, 'PROGRAMME: '.strtoupper($row_cprog['Title'])); 
		$pdf->text($x+6, $y+42, 'SEMESTER EXAMINATION: '.strtoupper($level).' - '.strtoupper($courseyear).' - '.$year);
		
 		#reset values of x,y
		$x=50; $y=$y+48;
 		#table course details
		$pdf->line($x, $y, 570.28, $y);
		$pdf->line($x, $y+15, 570.28, $y+15); 
		$pdf->line($x, $y+30, 570.28, $y+30); 
		$pdf->line($x, $y, $x, $y+30); 
		$pdf->line($x+68, $y, $x+68, $y+30);
		$pdf->line($x+468, $y, $x+468, $y+30);
		$pdf->line(570.28, $y, 570.28, $y+30);
		$pdf->setFont('Arial', 'B', 13); 
			$pdf->text($x, $y+12, 'Code'); 
			$pdf->text($x+70, $y+12, 'Module Name'); 
			$pdf->text($x+470, $y+12, 'Credits'); 
		$pdf->setFont('Arial', '', 11); 
		$pdf->text($x, $y+27, $coursecode); 
		$pdf->text($x+70, $y+27, $coursename); 
		$pdf->text($x+470, $y+27, $courseunit);

		#reset the value of y
		$y=$y+40;
		
		if ($layout=='S')
		{
			include 'includes/courseresultsummary.php';
		}else{
			include 'includes/courseresultdetail.php';
		}
 }
	#calculate summary areas
	$yind = $y+25;
	$summaryarea = 820.89-$yind;
	if ($summaryarea<90){
			$pdf->addPage();  

			$x=50;
			$y=50;
			$pg=$pg+1;
			$tpg =$pg;
			$pdf->setFont('Arial', 'I', 8);     
			$pdf->text(530.28, 820.89, 'Page '.$pg);  
			$pdf->text(300, 820.89, $copycount);    
		    $pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   
			$yind = $y; 
			$pdf->setFont('Arial', 'I', 10);     
    }
	@$pdf->setFont('Arial', '', 10); 
	$b=$y+25;
	if ($b<820.89){
		include 'includes/courseresultstats.php';
	}					
 $filename = preg_replace("[[:space:]]+", "",$coursecode);
 $pdf->output($filename.'.pdf');
}#end if isset pdf
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Course Result';
	$szTitle = 'Course Record Sheet Examination Result';
	include('lecturerheader.php');
	
mysqli_select_db($zalongwa, $database_zalongwa);
$query_AcademicYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AcademicYear = mysqli_query($zalongwa, $query_AcademicYear) or die(mysqli_error($zalongwa));
$row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
$totalRows_AcademicYear = mysqli_num_rows($AcademicYear);
mysqli_select_db($zalongwa, $database_zalongwa);

$query_degree = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$degree = mysqli_query($zalongwa, $query_degree) or die(mysqli_error($zalongwa));
$row_degree = mysqli_fetch_assoc($degree);
$totalRows_degree = mysqli_num_rows($degree);

mysqli_select_db($zalongwa, $database_zalongwa);
//$query_Hostel = "SELECT CourseCode FROM course ORDER BY CourseCode";

#get current year
$qcurrentyear = 'SELECT AYear FROM academicyear where Status = 1';
$dbcurrentyear = mysqli_query($zalongwa, $qcurrentyear);
$row_current = mysqli_fetch_array($dbcurrentyear);
$ayear = $row_current['AYear'];

if ($privilege ==3) {
$query_Hostel = "
		SELECT DISTINCT course.CourseCode 
		FROM examregister 
			INNER JOIN course ON (examregister.CourseCode = course.CourseCode)
		WHERE (examregister.AYear ='$ayear') 
		AND (examregister.RegNo='$username')  ORDER BY course.CourseCode DESC";
}else{
$query_Hostel = "
		SELECT CourseCode FROM course ORDER BY CourseCode";
}

$Hostel = mysqli_query($zalongwa, $query_Hostel) or die('query ,$query_Hostel, not executed');
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);

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

if (isset($_POST['print']) && ($_POST['print'] == "PreView")) {
#get post variables
$year = trim(addslashes($_POST['ayear']));
$coursecode = trim(addslashes($_POST['Hall']));

# get all students for this course
$qregno="SELECT DISTINCT RegNo FROM 
			 examresult 
				 WHERE (AYear='$year' AND CourseCode = '$coursecode') ORDER BY RegNo";	
$dbregno = mysqli_query($zalongwa, $qregno) or die("No Exam Results for the course - $coursecode - in the year - $year ");
$total_rows = mysqli_num_rows($dbregno);

	if($total_rows>0){
	#initialise the table
	?>


<?php
	//close if total statement
	}else{
			echo 'No Results Founds, Try Again <br>';
			# redisplay the form incase results werenot found
			?>
		
			   <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" name="courseresults" id="courseresults">
					<fieldset bgcolor="#CCCCCC">
						<legend>Search Course Results</legend>
					<table width="255" border="0" bgcolor="#CCCCCC">
				<tr>
				  <td width="113" nowrap><div align="right"></div></td>
				  <td width="132" bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
				  </span></td>
				</tr>
				<tr>
				  <td nowrap><div align="right">Academic Year: </div></td>
				  <td bgcolor="#CCCCCC"><select name="ayear" id="select2">
				  <option value="0">SelectAcademicYear</option>
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
				  <td nowrap><div align="right"> Course Code:</div></td>
				  <td bgcolor="#CCCCCC"><select name="Hall" id="select">
				  <option value="0">Select Course Code</option>
					<?php
		do {  
		?>
					<option value="<?php echo $row_Hostel['CourseCode']?>"><?php echo $row_Hostel['CourseCode']?></option>
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
          <td nowrap><div align="right"></div></td>
          <td colspan="2" nowrap><div align="center">
            <input type="submit" name="PDF2"  id="PDF2" value="Print PDF" />
          </div></td>
          </tr>
			  </table>
			  </fieldset>
</form>
		<?php
		}
}else{

?>

       <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" name="courseresult" id="housingvacantRoom">
            <fieldset bgcolor="#CCCCCC">
				<legend>Search Course Results</legend>
			<table width="255" border="0" bgcolor="#CCCCCC">
        <tr>
          <td width="113" nowrap><div align="right"></div></td>
          <td width="132" colspan="2" bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
          </span></td>
        </tr>
        <tr>
          <td nowrap><div align="right">Academic Year: </div></td>
          <td colspan="2" bgcolor="#CCCCCC"><select name="ayear" id="select2">
		  <option value="0">SelectAcademicYear</option>
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
          <td nowrap><div align="right"> Course Code:</div></td>
          <td colspan="2" bgcolor="#CCCCCC"><select name="Hall" id="select">
		  <option value="0">Select Course Code</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Hostel['CourseCode']?>"><?php echo $row_Hostel['CourseCode']?></option>
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
                  <td nowrap><div align="left">Study Programme:</div></td>
                  <td>
                      <div align="left">
                        <select name="degree" id="degree">
<option value="0">Select All Candidate</option>                          
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
                    </div></td></tr>
					
                <tr>
                  <td rowspan="3" nowrap><div align="right">Report Details:</div>                    <div align="right"></div></td>
                  <td>
                    <input name="layout" type="radio" value="S" checked>	
					CA in Summary
				</div></td>
				</tr>
                <tr>
                  <td> <input name="layout" type="radio" value="D">	
					CA in Detailed
                   </div></td>
				</tr>
                <tr>
                  <td> Show Names:<br>
					Yes 
                    <input name="show" type="radio" value="Y" checked>	
					No
					<input name="show" type="radio" value="N">
                   </td>
				</tr>

        <tr>
          <td nowrap><div align="right"></div></td>
          <td colspan="2" nowrap><div align="center">
            <input type="submit" name="PDF"  id="PDF" value="Print PDF">
          </div></td>
          </tr>
      </table>
	  </fieldset>
                    <input type="hidden" name="MM_search" value="room">
</form>
<?php
}
include('../footer/footer.php');
?>
