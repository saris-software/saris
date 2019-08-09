<?php 
	require_once('../Connections/sessioncontrol.php');
	# include the header
	include('studentMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Profile';
	$szTitle = 'Profile';
	$szSubSection = 'Profile';
	include("studentheader.php");
	
?>
<br>
	<style type="text/css">
		#table{
			border-radius:5px;
			background:#ceceff;
			font-family:Courier New, Monospace;
			}
		#table tr th{
			background:#bdbdd5;
			}
		#table tr td{							
			font-size:14px;
			font-family:Courier New, Monospace;
			}
		.total{
			background:#bdbdd5;
			}
		</style>
		
<?php
	require_once('../Connections/zalongwa.php');

	$sql = "SELECT FullName, Email, Position, UserName, LastLogin FROM security WHERE UserName = '$username'";
	$query = @mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
	echo "<table border='1' cellpadding='3' cellspacing='0' id='table' bordercolor='#006600'>";
	echo "<tr><td> Name </td><td> Login ID </td><td> Status </td><td> E-Post </td><td> Last Login </td></tr>";
	while($result = mysql_fetch_array($query)) {
			$Name = stripslashes($result["FullName"]);
			$username = stripslashes($result["UserName"]);
			$position = stripslashes($result["Position"]);
			$email = stripslashes($result["Email"]);
			$registered = stripslashes($result["LastLogin"]);
				echo "<tr bgcolor='#ffffff'>
						<td nowrap>$Name</td>
						<td nowrap>$username</td>
						<td nowrap>$position</td>
						<td nowrap>$email</td>
						<td nowrap>$registered</td>
					 </tr>";
			}
	echo "</table>";
	#Store Login History	
	$browser  =  $_SERVER["HTTP_USER_AGENT"];   
	$ip  =  $_SERVER["REMOTE_ADDR"];
	$jina = $username." - Visited the Student Page";   
	//$username = $username." "."Visited ".$szTitle;
	$sql="INSERT INTO stats(ip,browser,received,page) VALUES('$ip','$browser',now(),'$jina')";   
	$result = mysql_query($sql) or die("Siwezi kuingiza data.<br>" . mysql_error());
	# include the footer
	include("../footer/footer.php");
?>
