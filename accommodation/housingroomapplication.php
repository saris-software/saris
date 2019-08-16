<?php 
#start pdf
if (isset($_POST['printPDF']) && ($_POST['printPDF'] == "Print PDF")) {
	
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php');
	
	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
	$dborg = mysql_query($qorg);
	$row_org = mysql_fetch_assoc($dborg);
	$org = $row_org['Name'];
	$post = $row_org['Address'];
	$phone = $row_org['tel'];
	$fax = $row_org['fax'];
	$email = $row_org['email'];
	$website = $row_org['website'];
	$city = $row_org['city'];
	
	
	include('includes/PDF.php');
	
		// get posted values
		@$year=addslashes($_POST['ayear']);
		@$all = addslashes($_POST['check']);
		@$citeria =addslashes($_POST['criteria']);
		
	if ($all =='on'){
		$sql = "SELECT s.Name, s.Sex, s.ProgrammeofStudy, s.Faculty, ra.RegNo, 
				ra.Hall, ra.AppYear, c.ShortName FROM student s, roomapplication ra, criteria c
				WHERE s.RegNo = ra.RegNo AND ra.AllCriteria = c.CriteriaID AND ra.AppYear='$year'
				ORDER BY s.ProgrammeofStudy, s.RegNo ";
	}else{
		$sql = "SELECT s.Name, s.Sex, s.ProgrammeofStudy, ra.RegNo, ra.Hall, ra.AppYear, c.ShortName
				FROM student s, roomapplication ra, criteria c
				WHERE s.RegNo = ra.RegNo AND ra.AllCriteria = c.CriteriaID 
				AND ra.AppYear='$year' AND c.ShortName = '$citeria' ORDER BY s.Name";
	 }
		$result = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
		$query = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
		$row_result = mysql_fetch_assoc($query);
	
		$pdf = &PDF::factory('p', 'a4');      // Set up the pdf object. 
		$pdf->open();                         // Start the document. 
		$pdf->setCompression(true);           // Activate compression. 
		$pdf->addPage();  
		#put page header
	
		$x=50;
		$y=190;
		$i=1;
	    $pg=1;
		
		#print header
		include '../includes/reportheader.php';

		
		$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
		$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
		$pdf->text(150, 152, $year.' - ROOM APPLICATION REPORT'); // Text at x=100 and y=200.
		$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
		
		$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
		$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
		$pdf->text(70, 164, $row_result["ShortName"]); // Text at x=100 and y=200.
		$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 

		$pdf->text($x, $y, 'S/N'); // Text at x=100 and y=200.
		$pdf->text($x+50, $y, 'Name'); // Text at x=100 and y=200.
		$pdf->text($x+250, $y, 'RegNo'); // Text at x=100 and y=200.
		$pdf->text($x+346, $y, 'Sex'); // Text at x=100 and y=200.
		$pdf->text($x+380, $y, 'Programme'); // Text at x=100 and y=200.

		$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
		$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
		$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
		$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
		$pdf->line($x+235, $y-15, $x+235, $y+3);               // most left side margin. 
		$pdf->line($x+340, $y-15, $x+340, $y+3);               // most left side margin. 
		$pdf->line($x+370, $y-15, $x+370, $y+3);               // most left side margin. 
 		$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
		$pdf->line($x, $y+19, 570.28, $y+19);       // bottom year summary line. 
	
	#minimize fonts for content printing
	$pdf->setFont('Arial', '', 9);  
	//$all_query = mysql_query($query);
	$totalRows_query = mysql_num_rows($query);
	/* Printing Results in html */
	while ($app_row = mysql_fetch_assoc($result)){
	
		//get degree name
		$degree = $app_row['ProgrammeofStudy'];
		$qdegree = "Select ProgrammeName from programme where ProgrammeCode = '$degree'";
		$dbdegree = mysql_query($qdegree);
		$row_degree = mysql_fetch_array($dbdegree);
		$programme = $row_degree['ProgrammeName'];
		
		
		$pdf->text($x, $y+15, $i); // Text at x=100 and y=200.
		$pdf->text($x+40, $y+15, $app_row['Name']); // Text at x=100 and y=200.
		$pdf->text($x+240, $y+15, $app_row['RegNo']); // Text at x=100 and y=200.
		$pdf->text($x+346, $y+15, $app_row['Sex']); // Text at x=100 and y=200.
		$pdf->text($x+376, $y+15, substr($programme,0,20)); // Text at x=100 and y=200.
		//$pdf->text($x+456, $y+12, $app_row['Faculty']); // Text at x=100 and y=200.

		#check if the page is full
		$x=$x;
		$y=$y+15;
		$pdf->line(50, $y-15, 50, $y);               // most left side margin. 
		$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
		$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
		$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
		$pdf->line($x+235, $y-15, $x+235, $y+3);               // most left side margin. 
		$pdf->line($x+340, $y-15, $x+340, $y+3);               // most left side margin. 
		$pdf->line($x+370, $y-15, $x+370, $y+3);               // most left side margin. 
 		$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
		//$pdf->line($x, $y+19, 570.28, $y+19);       // bottom year summary line. 
		if ($y>800){
			#put page header
			//include('PDFTranscriptPageHeader.inc');
			$pdf->addPage();  

		$x=50;
		$y=190;
	    $pg=$pg+1;
			
		#print header
		include '../includes/reportheader.php';
		
		$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
		$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
		$pdf->text(150, 152, $year.' - ROOM APPLICATION REPORT'); // Text at x=100 and y=200.
		$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
		
		$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
		$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
		$pdf->text(70, 164, $row_result["ShortName"]); // Text at x=100 and y=200.
		$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 

		$pdf->text($x, $y, 'S/N'); // Text at x=100 and y=200.
		$pdf->text($x+50, $y, 'Name'); // Text at x=100 and y=200.
		$pdf->text($x+250, $y, 'RegNo'); // Text at x=100 and y=200.
		$pdf->text($x+346, $y, 'Sex'); // Text at x=100 and y=200.
		$pdf->text($x+376, $y, 'Programme'); // Text at x=100 and y=200.
		
		$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
		$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
		$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
		$pdf->line($x+40, $y-15, $x+40, $y+3);               // most left side margin. 
		$pdf->line($x+240, $y-15, $x+240, $y+3);               // most left side margin. 
		$pdf->line($x+340, $y-15, $x+340, $y+3);               // most left side margin. 
		$pdf->line($x+370, $y-15, $x+370, $y+3);               // most left side margin. 
 		$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
		$pdf->line($x, $y+19, 570.28, $y+19);       // bottom year summary line. 
		
		}
		
		$i=$i+1;
		
	}
	//$pdf->text(200.28, 800.89, '.........................................................        ............................');   // Text at x=100 and y=100. 						
	//$pdf->text(200.28, 810.89, '          For Chief Academic Officer                    Date');   // Text at x=100 and y=100. 						
	$pdf->setFont('Arial', 'I', 8);     // Set font to arial bold italic 12 pt. 
	$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   // Text at x=100 and y=100. 

	$pdf->output($year.'-roomapp'.'.pdf');              // Output the 
}
#ends PDF printing
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Accommodation';
	$szSubSection = 'Application Report';
	$szTitle = 'Room Application Report';
	include('admissionheader.php');

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
if (isset($_POST['search']) && ($_POST['search'] == "Search")) 
{
	#get post variables
	$key = $_POST['key'];
	$sql = "SELECT student.Name, roomapplication.RegNo, roomapplication.Hall, roomapplication.AppYear, criteria.ShortName
		FROM (student INNER JOIN roomapplication ON student.RegNo = roomapplication.RegNo) INNER JOIN criteria ON roomapplication.AllCriteria = criteria.CriteriaID
    	WHERE (student.Name LIKE '%$key%') OR (student.RegNo LIKE '%$key%') ORDER BY student.Name ASC";
	
	$result = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
	$query = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
	
	$all_query = mysql_query($query);
	$totalRows_query = mysql_num_rows($query);
	/* Printing Results in html */
	if (mysql_num_rows($query) > 0)
	{
		echo "<p>Total Applications: $totalRows_query </p>";
		echo "<table border='1'cellpadding='0' cellspacing='0' bordercolor='#006600'>";
		echo "<tr><td> S/No </td><td> Name </td><td> RegNo </td><td> Application Criteria </td><td>Hostel</td></tr>";
		$i=1;
		while($result = mysql_fetch_array($query)) 
		{
				$Name = stripslashes($result["Name"]);
				$RegNo = stripslashes($result["RegNo"]);
				$hall = stripslashes($result["Hall"]);
				$citeria = stripslashes($result["ShortName"]);
					echo "<tr><td>$i</td>";
					echo "<td align=\"left\" valign=\"middle\">$Name</td>";
					echo "<td align=\"left\" valign=\"middle\">$RegNo</td>";
					echo "<td align=\"left\" valign=\"middle\">$citeria</td>";
					echo "<td align=\"left\" valign=\"middle\">$hall</td></tr>";
				$sql="UPDATE roomapplication SET Status = 1, Processed = now()";
				$result = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
			$i=$i+1;
		}
		echo "</table>";
	}else{
			$key= stripslashes($key);
			echo "Sorry, No Records Found <br>";
			echo "That Match With Your Searck Key \"$key \" ";
		  }
		  exit;
}

if (isset($_POST['print']) && ($_POST['print'] == "PreView")) 
{
// get posted values
@$year=$_POST['ayear'];
@$all = $_POST['check'];
@$citeria =$_POST['criteria'];

	if ($all =='on'){
		$sql = "SELECT s.Name, s.Sex, s.ProgrammeofStudy, s.Faculty, ra.RegNo, 
				ra.Hall, ra.AppYear, c.ShortName FROM student s, roomapplication ra, criteria c
				WHERE s.RegNo = ra.RegNo AND ra.AllCriteria = c.CriteriaID AND ra.AppYear='$year'
				ORDER BY s.ProgrammeofStudy, s.RegNo ";
	}else{
		$sql = "SELECT s.Name, s.Sex, ra.RegNo, ra.Hall, ra.AppYear, c.ShortName
				FROM student s, roomapplication ra, criteria c
				WHERE s.RegNo = ra.RegNo AND ra.AllCriteria = c.CriteriaID 
				AND ra.AppYear='$year' AND c.ShortName = '$citeria' ORDER BY s.Name";
	 }
	$result = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
	$query = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
	
	$all_query = mysql_query($query);
	$totalRows_query = mysql_num_rows($query);
	/* Printing Results in html */
	if (mysql_num_rows($query) > 0)
	{
		echo '<b>Application Criteria: </b>'.$citeria;
		echo "<p><b>Total Applications:</b> $totalRows_query </p>";
		echo "<table border='1'cellpadding='0' cellspacing='0' bordercolor='#006600'>";
		echo "<tr><td> S/No </td><td> Name </td><td> RegNo </td><td> Sex </td><td> Criteria </td><td>Hostel</td></tr>";
		$i=1;
		while($result = mysql_fetch_array($query)) 
		{
				$Name = stripslashes($result["Name"]);
				$sex = stripslashes($result["Sex"]);
				$RegNo = stripslashes($result["RegNo"]);
				$hall = stripslashes($result["Hall"]);
				$citeria = stripslashes($result["ShortName"]);
					echo "<tr><td>$i</td>";
					echo "<td  align=\"left\" valign=\"middle\" norwap>$Name</td>";
					echo "<td align=\"right\" valign=\"middle\">$RegNo</td>";
					echo "<td align=\"left\" valign=\"middle\">$sex</td>";
					echo "<td align=\"left\" valign=\"middle\">$citeria</td>";
					echo "<td align=\"left\" valign=\"middle\">$hall</td></tr>";
				$sql="UPDATE roomapplication SET Status = 1, Processed = now()";
				$result = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
			$i=$i+1;
		}
		echo "</table>";
	}
	else{echo "Sorry, No One has Applied for a Room in This Year <br>";}
mysql_close($zalongwa);
exit;
}
#============================


mysql_select_db($database_zalongwa, $zalongwa);
$query_AcademicYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AcademicYear = mysql_query($query_AcademicYear, $zalongwa) or die(mysql_error());
$row_AcademicYear = mysql_fetch_assoc($AcademicYear);
$totalRows_AcademicYear = mysql_num_rows($AcademicYear);

mysql_select_db($database_zalongwa, $zalongwa);
$query_Hostel = "SELECT HID, HName FROM hostel";
$Hostel = mysql_query($query_Hostel, $zalongwa) or die(mysql_error());
$row_Hostel = mysql_fetch_assoc($Hostel);
$totalRows_Hostel = mysql_num_rows($Hostel);

mysql_select_db($database_zalongwa, $zalongwa);
$query_criteria = "SELECT ShortName FROM criteria ORDER BY ShortName";
$criteria = mysql_query($query_criteria, $zalongwa) or die(mysql_error());
$row_criteria = mysql_fetch_assoc($criteria);
$totalRows_criteria = mysql_num_rows($criteria);
if(!$username){
	echo ("Session Expired, <a href=\"ReLogin.php\"> Click Here<a> to Re-Login");
	
	echo '<meta http-equiv = "refresh" content ="0; 
	url = ReLogin.php">';
	exit;
}
?><form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">
            <table width="284" border="0" align="left">
        <tr>
          <td colspan="2" nowrap><div align="center"></div>
		  </td>
		  <td>
          </td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCCCCC"><div align="right"><span class="style67">Name or RegNo:</span></div></td>
          <td width="157" bordercolor="#ECE9D8" bgcolor="#CCCCCC">
          <input name="key" type="text" id="key" size="20" maxlength="40">          </td>
		  <td bgcolor="#CCCCCC"><input type="submit" name="search" value="Search"></td>
        </tr>
  </table>
                   
</form>
<form action="<?php echo $editFormAction; ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">
            <table width="300" border="0" style="margin-top:0px;" align="left">
        <tr>
          <td colspan="2" nowrap><div align="center"> </div>
            <hr></td>
          </tr>
        <tr>
          <td width="153" height="21" nowrap bgcolor="#CCCCCC"><div align="right"><span class="style67">Print All Records: </span></div></td>
          <td width="137" nowrap bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
            <input name="check" type="checkbox" id="check">
            </span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCCCCC"><div align="right">Application Year: </div></td>
          <td bgcolor="#CCCCCC"><select name="ayear" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_AcademicYear['AYear']?>"><?php echo $row_AcademicYear['AYear']?></option>
            <?php
} while ($row_AcademicYear = mysql_fetch_assoc($AcademicYear));
  $rows = mysql_num_rows($AcademicYear);
  if($rows > 0) {
      mysql_data_seek($AcademicYear, 0);
	  $row_AcademicYear = mysql_fetch_assoc($AcademicYear);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCCCCC"><div align="right">Room Allocation Citeria: </div></td>
          <td bgcolor="#CCCCCC"><select name="criteria" id="criteria">
		  <?php
do {  
?>
            <option value="<?php echo $row_criteria['ShortName']?>"><?php echo $row_criteria['ShortName']?></option>
            <?php
} while ($row_criteria = mysql_fetch_assoc($criteria));
  $rows = mysql_num_rows($criteria);
  if($rows > 0) {
      mysql_data_seek($criteria, 0);
	  $row_criteria = mysql_fetch_assoc($criteria);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCCCCC"><div align="right"> </div></td>
          <td bgcolor="#CCCCCC"><input type="submit" name="print" value="PreView">
		  ......................<input type="submit" name="printPDF" value="Print PDF"></td>

        </tr>
      </table>
                    <input type="hidden" name="MM_insert" value="housingRoomApplication">
          </form>


<?php
mysql_free_result($AcademicYear);

mysql_free_result($Hostel);

?>
