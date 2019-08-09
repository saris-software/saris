<?php
#get connected to the database and verfy current session
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
	# initialise globals
	include('admissionMenu.php');
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Registration Form';
	$szTitle = 'Student Registration Form';
	include('admissionheader.php');







//ZALONGWA SARIS ACCOUNT CREATING

$sql = "SELECT * FROM student"; 
$update = mysql_query($sql) or die(mysql_error());
$students=mysql_num_rows($update);
while($update_row = mysql_fetch_array($update))
{
$rawname = $update_row['Name'];
$rawname=strtolower($rawname);
$expsurname =explode(",",$rawname);
$surname =$expsurname[0];
$othername = $expsurname[1];
$expothername = explode(" ", $othername);
$firstname = $expothername[1];
$middlename = $expothername[2].' '.$expothername[3];


$UserName=$surname.".".$firstname;
$FullName=$rawname;
$RegNo=$update_row['RegNo'];
$Position="student";
$Email=$update_row['Email'];
$password=$surname;
// Generate SSHA jlungo hash
$part1=base64_encode(pack("H*",sha1($password)));
$part2= "{jlungo-hash}";
$hash=$part2.$part1;
$UserName=addslashes($UserName);
//TEST EXISTENSE
$test=mysql_query("select * from security where UserName='$UserName'");
if(!$test)
{
///CREATING......
$plug="insert into security(UserName,FullName,RegNo,Position,Email,password)
 values('$UserName','$FullName','$RegNo','$Position','$Email','$hash')";

$pl=mysql_query($plug)or die(mysql_error());
}else
{
//UserName already Exist
}
}

echo "Done for $students";



?>
