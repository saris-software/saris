<?php 
#start pdf
if (isset($_POST['printPDF']) && ($_POST['printPDF'] == "Print PDF")) {
	
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php');
	
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
	
	#get post values
	$year=$_POST['AllCriteria'];
	$hall=$_POST['Hall'];
		$sql = "SELECT student.Name, 
		student.Sex, 
		allocation.RegNo, 
		hostel.HName, 
		allocation.RNumber, 
		allocation.AYear, 
		allocation.CheckIn, 
		allocation.CheckOut, 
		hostel.HID
		FROM (allocation INNER JOIN student ON allocation.RegNo = student.RegNo) 
		INNER JOIN hostel ON allocation.HID = hostel.HID
		WHERE hostel.HName='$hall' AND allocation.AYear='$year' 
		ORDER BY student.Name ASC";

		$result = @mysqli_query($zalongwa,$sql);
		$query = @mysqli_query($zalongwa,$sql);
		
		$all_query = mysqli_query($zalongwa,$query);
		$totalRows_query = mysqli_num_rows($query);
		/* Printing Results in html */
		if (mysqli_num_rows($query) > 0)
		{
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
				$pdf->text(150, 152, $year.' - ROOM ALLOCATION REPORT'); // Text at x=100 and y=200.
				$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
				
				$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
				$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
				$pdf->text(70, 164, $row_result["ShortName"]); // Text at x=100 and y=200.
				$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
		
				$pdf->text($x, $y, 'S/N'); // Text at x=100 and y=200.
				$pdf->text($x+50, $y, 'Name'); // Text at x=100 and y=200.
				$pdf->text($x+250, $y, 'RegNo'); // Text at x=100 and y=200.
				$pdf->text($x+346, $y, 'Sex'); // Text at x=100 and y=200.
				$pdf->text($x+380, $y, 'Room Number'); // Text at x=100 and y=200.
				
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
				
			while($result = mysqli_fetch_array($query)) 
			{
					$id = stripslashes($result["Id"]);
					$Name = stripslashes($result["Name"]);
					$RegNo = stripslashes($result["RegNo"]);
					$hall = stripslashes($result["HName"]);
					$criteria = stripslashes($result["RNumber"]);
					$sex = stripslashes($result["Sex"]);
					//$checkout = stripslashes($result["CheckOut"]);

					$pdf->text($x, $y+15, $i); // Text at x=100 and y=200.
					$pdf->text($x+40, $y+15, $Name); // Text at x=100 and y=200.
					$pdf->text($x+240, $y+15, $RegNo); // Text at x=100 and y=200.
					$pdf->text($x+346, $y+15, $sex); // Text at x=100 and y=200.
					$pdf->text($x+376, $y+15, $criteria); // Text at x=100 and y=200.
					
					$i=$i+1;
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
						$pdf->text(150, 152, $year.' - ROOM ALLOCATION REPORT'); // Text at x=100 and y=200.
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
						$pdf->setFont('Arial', '', 13);     // Set font to arial bold italic 12 pt. 
						$pdf->text(70, 164, $row_result["ShortName"]); // Text at x=100 and y=200.
						$pdf->setFillColor('rgb', 0, 0, 0);   // Set text color to blue. 
				
						$pdf->text($x, $y, 'S/N'); // Text at x=100 and y=200.
						$pdf->text($x+50, $y, 'Name'); // Text at x=100 and y=200.
						$pdf->text($x+250, $y, 'RegNo'); // Text at x=100 and y=200.
						$pdf->text($x+346, $y, 'Sex'); // Text at x=100 and y=200.
						$pdf->text($x+380, $y, 'Room Number'); // Text at x=100 and y=200.
						
						$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
						$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
						$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
						$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
						$pdf->line($x+235, $y-15, $x+235, $y+3);               // most left side margin. 
						$pdf->line($x+340, $y-15, $x+340, $y+3);               // most left side margin. 
						$pdf->line($x+370, $y-15, $x+370, $y+3);               // most left side margin. 
						$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
						$pdf->line($x, $y+19, 570.28, $y+19);       // bottom year summary line. 			
					}
			 }
			 
			//$pdf->text(200.28, 800.89, '.........................................................        ............................');   // Text at x=100 and y=100. 						
			//$pdf->text(200.28, 810.89, '          For Chief Academic Officer                    Date');   // Text at x=100 and y=100. 						
			$pdf->setFont('Arial', 'I', 8);     // Set font to arial bold italic 12 pt. 
			$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   // Text at x=100 and y=100. 
			$pdf->output($year.'-roomallocation'.'.pdf');              // Output the 
		}else{echo "Sorry, No One has Applied for a Room in This Year <br>";
	}
	exit;
	
}
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Accommodation';
	$szSubSection = 'Allocation Report';
	$szTitle = 'Room Allocation Reports';
	include('admissionheader.php');
//control form display

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


//Print Room Allocation Report
if (isset($_POST['search']) && ($_POST['search'] == "Search")) 
{
	#get post variables
	$key = $_POST['key'];
				
	require_once('../Connections/zalongwa.php'); 
	$sql = "SELECT student.Id, student.Name, student.Sex, student.ProgrammeofStudy, student.Faculty, student.Sponsor, student.EntryYear, student.RegNo, hostel.HName, allocation.RNumber, allocation.AYear, hostel.HID
	FROM (allocation RIGHT JOIN student ON allocation.RegNo = student.RegNo) LEFT JOIN hostel ON allocation.HID = hostel.HID
	WHERE (student.Name LIKE '%$key%') OR (student.RegNo LIKE '%$key%') ORDER BY student.Name, allocation.AYear ASC";
	
	$result = @mysqli_query($zalongwa,$sql) or die("Cannot query the database.<br>" . mysqli_error());
	$query = @mysqli_query($zalongwa,$sql) or die("Cannot query the database.<br>" . mysqli_error());
	
	$all_query = mysqli_query($zalongwa,$query);
	$totalRows_query = mysqli_num_rows($query);
	/* Printing Results in html */
	if (mysqli_num_rows($query) > 0)
	{
		echo "<p>Total Records Found: $totalRows_query </p>";
		echo "<table border='1'cellpadding='0' cellspacing='0' bordercolor='#006600'>";
		echo "<tr><td> S/No </td><td> Name </td><td> RegNo </td><td> Sex </td><td> Degree </td><td> Sponsor </td><td> Registered </td><td> Hostel </td><td> Room No.: </td><td> Academic Year </td><td>Delete</td></tr>";
		$i=1;
		while($result = mysqli_fetch_array($query)) 
		{
				$id = stripslashes($result["Id"]);
				$year = stripslashes($result["AYear"]);
				$Name = stripslashes($result["Name"]);
				$RegNo = stripslashes($result["RegNo"]);
				$sex = stripslashes($result["Sex"]);
				$degree = stripslashes($result["ProgrammeofStudy"]);
				//$faculty = stripslashes($result["Faculty"]);
				$sponsor = stripslashes($result["Sponsor"]);
				$entryyear = stripslashes($result["EntryYear"]);
				$hall = stripslashes($result["HName"]);
				$citeria = stripslashes($result["RNumber"]);
				//search degree name
				$qdegree = "SELECT ProgrammeName from programme WHERE ProgrammeCode='$degree'";
				$dbdegree = mysqli_query($zalongwa,$qdegree);
				$row_degree = mysqli_fetch_array($dbdegree);
				$degreename = $row_degree['ProgrammeName'];
					echo "<tr><td>$i</td>";
					echo "<td nowrap>$Name</td>";
					echo "<td nowrap>$RegNo</td>";
					echo "<td nowrap>$sex</td>";
					echo "<td nowrap>$degreename</td>";
					//echo "<td nowrap>$faculty</td>";
					echo "<td nowrap>$sponsor</td>";
					echo "<td nowrap>$entryyear</td>";
					echo "<td nowrap>$hall</td>";
					echo "<td nowrap>$citeria</td>";
					echo "<td nowrap>$year</td>";
					echo "<td><a href=\"housingallocationdelete.php?login=$RegNo&ayear=$year\">Delete</a></td></tr>";
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

mysqli_select_db($zalongwa,$database_zalongwa);
$query_AcademicYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AcademicYear = mysqli_query($zalongwa,$query_AcademicYear) or die(mysqli_error());
$row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
$totalRows_AcademicYear = mysqli_num_rows($AcademicYear);

mysqli_select_db($zalongwa,$database_zalongwa);
$query_Hostel = "SELECT HID, HName FROM hostel";
$Hostel = mysqli_query($zalongwa,$query_Hostel) or die(mysqli_error());
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);
?>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">
            <table width="284" border="0" align="left">
        <tr>
          <td colspan="2" nowrap><div align="center"></div>
		  </td>
		  <td>
          </td>
        </tr>
        <tr>
          <td bgcolor="#CCCCCC" nowrap><div align="right"><span class="style67">Name or RegNo:</span></div></td>
          <td width="157" bordercolor="#ECE9D8" bgcolor="#CCCCCC" nowrap>
          <input name="key" type="text" id="key" size="20" maxlength="40">          </td>
		  <td bgcolor="#CCCCCC" nowrap><input type="submit" name="search" value="Search"></td>
        </tr>
  </table>
                   
</form>

			
<?php
if (isset($_POST['print']) && ($_POST['print'] == "PreView")) 
{
		$year=$_POST['AllCriteria'];
		$hall=$_POST['Hall'];
		$sql = "SELECT student.Name, allocation.RegNo, hostel.HName, allocation.RNumber, allocation.AYear, allocation.CheckIn, allocation.CheckOut, hostel.HID
		FROM (allocation INNER JOIN student ON allocation.RegNo = student.RegNo) INNER JOIN hostel ON allocation.HID = hostel.HID
		WHERE hostel.HName='$hall' AND allocation.AYear='$year' ORDER BY allocation.RegNo ASC";
		//(((roomapplication.Hall)='$hall') And
		$result = @mysqli_query($zalongwa,$sql) or die("Cannot query the database.<br>" . mysqli_error());
		$query = @mysqli_query($zalongwa,$sql) or die("Cannot query the database.<br>" . mysqli_error());
		
		$all_query = mysqli_query($zalongwa,$query);
		$totalRows_query = mysqli_num_rows($query);
		/* Printing Results in html */
		if (mysqli_num_rows($query) > 0)
		{
			echo "<p style='margin-top:50px'>$year ACADEMIC YEAR: ROOM ALLOCATION REPORT</p>";
			echo "<p>Total Occupants: $totalRows_query </p>";
			echo "<table border='1'cellpadding='0' cellspacing='0' bordercolor='#006600'>";
			echo "<tr><td> S/No </td><td nowrap> Name </td><td> RegNo </td><td> Hall/Hostel </td><td nowrap> Room No.</td><td nowrap> Check In</td><td nowrap> Check Out</td></tr>";
			$i=1;
			while($result = mysqli_fetch_array($query)) 
			{
					$id = stripslashes($result["Id"]);
					$Name = stripslashes($result["Name"]);
					$RegNo = stripslashes($result["RegNo"]);
					$hall = stripslashes($result["HName"]);
					$citeria = stripslashes($result["RNumber"]);
					$checkin = stripslashes($result["CheckIn"]);
					$checkout = stripslashes($result["CheckOut"]);
						echo "<tr><td>$i</td>";
						echo "<td nowrap align=\"left\" valign=\"middle\">$Name</td>";
						echo "<td nowrap align=\"left\" valign=\"middle\">$RegNo</td>";
						echo "<td nowrap>$hall</td>";
						echo "<td nowrap>$citeria</td>";
						echo "<td nowrap>$checkin</td>";
						echo "<td nowrap>$checkout</td>
						</tr>";
					$i=$i+1;
			 }
			echo "</table>";
		}
		else{
			echo "<p style='color:maroon; margin-top:50px;'>";
			echo "Sorry, There are no allocations made for $hall in the $year Academic Year</p>";
		}
		exit;
}
?>

<p>&nbsp;</p>
<hr>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">
            <table width="358" border="0" bgcolor="#CCCCCC">
        <tr>
          <td colspan="2" nowrap><span class="style65">...PRINTING ROOM ALLOCATION REPORT </span> <hr/></td>
          </tr>
        <tr>
          <td width="144" nowrap><div align="right"></div></td>
          <td width="204" bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
          </span></td>
        </tr>
        <tr>
          <td nowrap><div align="right">Application Year: </div></td>
          <td bgcolor="#CCCCCC"><select name="AllCriteria" id="select2">
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
          <td nowrap><div align="right"> Hall/Hostel:</div></td>
          <td bgcolor="#CCCCCC"><select name="Hall" id="select">
            <?php
do {  
?>
            <option value="<?php echo $row_Hostel['HName']?>"><?php echo $row_Hostel['HName']?></option>
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
          <td nowrap><div align="right">Click Submit to Save: </div></td>
          <td norwap bgcolor="#CCCCCC"><input name="print" type="submit" id="print" value="PreView">
		  ......<input name="printPDF" type="submit" id="printPDF" value="Print PDF">
		  </td>
        </tr>
      </table>
                    <input type="hidden" name="MM_insert" value="housingRoomApplication">
</form>
<?php
mysqli_free_result($AcademicYear);
mysqli_free_result($Hostel);
mysqli_close($zalongwa);
include('../footer/footer.php');
?>
