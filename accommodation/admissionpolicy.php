<?php 
require_once('../Connections/sessioncontrol.php');
# include the header
include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Policy Setup';
	$szSubSection = 'Policy Setup';
	include("admissionheader.php");
	
	echo "<br>";
	
require_once('../Connections/zalongwa.php');

$sql = "SELECT FullName, Email, Position, UserName, Registered FROM security WHERE UserName = '$username'";
<<<<<<< HEAD

$query = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error());
$query = @mysqli_query($sql) or die("Cannot query the database.<br>" . mysqli_error());
=======
<<<<<<< HEAD
$query = @mysqli_query($sql) or die("Cannot query the database.<br>" . mysqli_error());
=======
$query = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error());
>>>>>>> 3dfbbc4521634b23849cd93202dc83ae5532b4a4
>>>>>>> 764a54c278a7827951170c679a82817e2de8dff2
echo "<table border='1'>";
echo "<tr><td> Name </td><td> Login ID </td><td> Status </td><td> E-Post </td><td> Registered </td></tr>";
while($result = mysqli_fetch_array($query)) {
		$Name = stripslashes($result["FullName"]);
		$username = stripslashes($result["UserName"]);
		$position = stripslashes($result["Position"]);
		$email = stripslashes($result["Email"]);
		$registered = stripslashes($result["Registered"]);
			echo "<tr><td>$Name</td>";
			echo "<td>$username</td>";
			echo "<td>$position</td>";
			echo "<td>$email</td>";
			echo "<td>$registered</td></tr>";
		}
echo "</table>";

	# include the footer
	include("../footer/footer.php");
?>