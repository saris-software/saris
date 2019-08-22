<?php 
#get connected to the database and verify current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Manage Users';
	$szSubSection = '';
	$szTitle = 'List of Database Users';
	include('admissionheader.php')
?>
<form action="adminmanageuser.php" method="get" class="style24">
            <div align="right"><span class="style67"><span style="font-family: Verdana; "><b>Search</b></span></span>
              <span style="color: #006699; font-family: Verdana; "><b>
              <input type="text" name="content" size="15">
              </b></span><span style="color: #FFFF00; font-family: Verdana; "><b>
              <input type="submit" value="GO" name="go">
              </b></span>            </div>
        </form>
        <?php
require_once('../Connections/zalongwa.php'); 
if (isset($_GET["content"])){
$key=addslashes($_GET['content']);
$sql = "SELECT FullName, RegNo, UserName, Password, Position, AuthLevel, LastLogin
FROM security 
WHERE FullName LIKE '%$key%' OR UserName LIKE '%$key%' OR RegNo LIKE '%$key%' ORDER BY FullName";
$result = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
$query = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
}else{
$sql = "SELECT FullName, RegNo, UserName, Password, Position, AuthLevel, LastLogin
FROM security ORDER BY FullName";
//(((roomapplication.Hall)='$hall') And
$result = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
$query = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
}
$all_query = mysqli_query($query , $zalongwa);
$totalRows_query = mysqli_num_rows($query);
/* Printing Results in html */
if (mysqli_num_rows($query) > 0){
echo "<p>Total Records Found: $totalRows_query </p>";
echo "<table border='1'>";
echo "<tr><td> S/No </td><td> Name </td><td> RegNo </td><td> UserName </td><td> Position </td><td> Last Login</td><td> Edit</td><td>Delete</td></tr>";
$i=1;
while($result = mysqli_fetch_array($query)) {
		$login = stripslashes($result["UserName"]);
		$Name = stripslashes($result["FullName"]);
		$RegNo = stripslashes($result["RegNo"]);
		$pwd = stripslashes($result["Password"]);
		$position = stripslashes($result["Position"]);
		$last = stripslashes($result["LastLogin"]);
			echo "<tr><td>$i</td>";
			echo "<td><a href=\"administratoruservisitdetails.php?login=$login\">$Name</a></td>";
			echo "<td>$RegNo</td>";
			echo "<td>$login</td>";
			echo "<td>$position</td>";
			echo "<td>$last</td>";
			echo "<td><a href=\"adminmanageuseredit.php?login=$login\">Edit</a></td>";
			echo "<td><a href=\"adminmanageuserdelete.php?login=$login\">Delete</a></td></tr>";
		$i=$i+1;
		}
echo "</table>";
}else{
$key= stripslashes($key);
echo "Sorry, No Records Found <br>";
echo "That Match With Your Searck Key \"$key \" ";
}
mysqli_close($zalongwa);
?>
		 <?php

	# include the footer
	include('../footer/footer.php');
?>
