<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Search Student';
	$szTitle = 'Search Student Record';
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


//Print Room Allocation Report
if (isset($_POST['search']) && ($_POST['search'] == "Search")) {
#get post variables
$rawkey = addslashes($_POST['key']);
$key = preg_replace("[[:space:]]+", " ",$rawkey);
			
require_once('../Connections/zalongwa.php'); 
$stdsql = "SELECT student.Id, student.Name, student.Sex, student.ProgrammeofStudy, student.Faculty, student.Sponsor, student.EntryYear, student.RegNo, student.AdmissionNo, student.Photo
FROM student
WHERE (student.Name LIKE '%$key%')OR (student.AdmissionNo LIKE '%$key%') OR (student.RegNo LIKE '%$key%') ORDER BY student.Name";

$stdquery = @mysqli_query($zalongwa, $stdsql);

$all_query = mysqli_query($zalongwa, $stdquery);
$totalRows_query = mysqli_num_rows($stdquery);
/* Printing Results in html */
if (mysqli_num_rows($stdquery) > 0){
echo "<p>Total Records Found: $totalRows_query </p>";
echo "<table border='1' cellpadding='0' cellspacing='0'>";
echo "<tr>
<th> S/No </th>
<th> Name </th>
<th> RegNo </th>
<th> Sex </th>
<th> Programme</th>
<th> Sponsorship </th>
<th> Cohort</th>
<th> Invoice </th>
<th> Paid </th>
<th> Balance</th>
<th> Photo </th>
</tr>";
$i=1;
while($result = mysqli_fetch_array($stdquery))
 {
		$id = stripslashes($result["Id"]);
		$year = stripslashes($result["AYear"]);
		$Name = stripslashes($result["Name"]);
		$RegNo = stripslashes($result["RegNo"]);
		$AdmNo = stripslashes($result["AdmissionNo"]);
		$sex = stripslashes($result["Sex"]);
		$degree = stripslashes($result["ProgrammeofStudy"]);
		$class = stripslashes($result["Class"]);
		$sponsor = stripslashes($result["Sponsor"]);
		$entryyear = stripslashes($result["EntryYear"]);
		$photo = stripslashes($result["Photo"]);
		$citeria = stripslashes($result["RNumber"]);
			//get degree name
			$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
			$dbdegree = mysqli_query($zalongwa, $qdegree);
			$row_degree = mysqli_fetch_array($dbdegree);
			$programme = $row_degree['Title'];
			#get Billing Information
			$regno=$RegNo;
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
			include('../billing/includes/getgrandtotalpaid.php');
				$invoice = number_format($invoice,2,'.',',');
				$paid = number_format($paid,2,'.',',');
     /** @var due $due */
     $due = number_format($due,2,'.',',');
					
				echo "<tr><td><a href=\"admissionRegistrationForm.php?id=$id&RegNo=$RegNo\">$i</a></td>";
					echo "<td>&nbsp;$Name</td>";
					echo "<td>&nbsp;$RegNo</td>";
					echo "<td>&nbsp;$sex</td>";
					echo "<td>&nbsp;$programme</td>";
					echo "<td>&nbsp;$sponsor</td>";
					echo "<td>&nbsp;$entryyear</td>";
					echo "<td>&nbsp;$invoice</td>";
					echo "<td>&nbsp;$paid</td>";
					echo "<td>&nbsp;$due</td>";
					echo "<td><a href=\"studentphoto.php?id=$id&RegNo=$RegNo\">edit</a><img src='$photo' width='50' height='50'></td>";
					echo "</tr>";
				$i=$i+1;

}
echo "</table>";
}else{
$key= stripslashes($key);
echo "Sorry, No Records Found <br>";
echo "That Match With Your Searck Key \"$key \" ";
}
mysqli_close($zalongwa);

}else{

?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentsearch" id="studentsearch">
            <table width="284" border="0">
        <tr>
          <td colspan="2" nowrap><div align="center"></div>
          </td>
        </tr>
        <tr>
          <td nowrap>Name or Admission No:</td>
          <td bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
          <input name="key" type="text" id="key" size="40" maxlength="40">
          </span></td>
        </tr>
        <tr>
          <td nowrap><div align="right"></div></td>
          <td bgcolor="#CCCCCC"><div align="center">
            <input type="submit" name="search" value="Search">
          </div></td>
        </tr>
      </table>
                    </form>
<?php
}
include('../footer/footer.php');
?>
