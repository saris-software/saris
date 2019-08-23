<?php
session_start();
header("Cache-control: private"); // IE 6 Fix. 
@$auth_level = $_SESSION['auth_level'];
@$RegNo = $_SESSION['RegNo'];
@$username = $_SESSION['username'];
@$year=$_POST['ayear'];
@$all = $_POST['check'];
@$citeria =$_POST['criteria'];

if(!$username){
	echo ("Session Expired, <a href=\"ReLogin.php\"> Click Here<a> to Re-Login");
	
	echo '<meta http-equiv = "refresh" content ="0; 
	url = ReLogin.php">';
	exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang=en-US>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="ZALONGWA, zalongwa, Student Information System (SIS), accommodation information system, database system, examination database system, student records system, database system">
<meta name="description" content="School Management Information System, Database System, Juma Lungo Lungo Lungo Lungo, Database System , Student Information System (SIS), Accommodation Record Keeping, Examination Results System, student Normninal Roll Database">
<meta name="rating" content="General">
<meta name="Generator" content="Macromedia Dreamweaver  UtraDev 4.1">
<meta name="authors" content="Juma Hemed Lungo">
<meta name="robots" content="all">

<meta http-equiv="Content-Language" content="pt">
<meta name="VI60_defaultClientScript" content="JavaScript">

<title>UDSM Student Information System</title>
<link rel="stylesheet" type="text/css" href="/master.css">

<style type="text/css">
<!--
.style24 {font-size: 12px}
.style34 {color: #990000}
.style35 {
	color: #993300;
	font-size: 11px;
}
a:link {
	text-decoration: none;
	color: #000099;
}
a:visited {
	text-decoration: none;
	color: #000099;
}
a:hover {
	text-decoration: underline;
	color: #CC0000;
}
a:active {
	text-decoration: none;
	color: #CC0000;
}
.style47 {font-size: small}
.style55 {font-size: 10px}
.style58 {color: #993300; font-size: 12px; }
.style59 {color: #993300}
.style61 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style29 {font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style42 {color: #000000;
	font-weight: bold;
}
.style64 {font-weight: bold; font-size: 12px;}
.style68 {font-size: 18px}
.style69 {font-size: 14px}
-->
</style>
</head>

<body bgcolor="#FFFFCC">
<div align="center">
  <center>
    <tr> 
      <td width="100%" height="48"></td>
    </tr>
  </center>
</div>
<div align="center">
  <center>
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#990000">
      <tr bgcolor="#99CCCC">
        <td height="69" colspan="7" align="center" valign="middle"> <img src="/images/Nkurumah.gif" width="724" height="69" align="left"></td>
      </tr>
      <tr>
        <td width="56" rowspan="5" valign="top">
            <table width="62%" height="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFCC" bgcolor="#99CCCC">
          <tr class="style35">
            <td height="0" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Your Profile" width="15" height="15"></div></td>
            <td nowrap></td>
            <td colspan="3" nowrap class="style58"><div align="left" class="style58"><?php print "<a href=\"housingprofile.php?username=$username\">Your Profile</a>";?><span class="style59"> <font face="Verdana">&nbsp;</font> </span></div></td>
            </tr>
			<tr class="style35">
            <td height="20" align="right" valign="middle" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Room Application" width="15" height="15"></div></td>
            <td colspan="4" align="left" valign="middle" nowrap class="style35"><span class="style58"><?php print "<a href=\"housingroomapplication.php?username=$username\">Room Application</a>";?></span></td>
            </tr>
			<tr class="style35">
            <td height="20" align="right" valign="middle" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Nominal Roll" width="15" height="15"></div></td>
            <td colspan="4" align="left" valign="middle" nowrap class="style35"><span class="style58"><?php print "<a href=\"housingnorminalroll.php?username=$username\">Nominal Roll</a>";?></span></td>
            </tr>
          <tr class="style35">
            <td height="20" align="right" valign="middle" nowrap><div align="center" class="style47"><img height=15 alt=Room Allocation 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></div></td>
            <td colspan="4" align="left" valign="middle" nowrap class="style35"><span class="normaltext style24"><?php print "<a href=\"housingroomallocation.php?username=$username\">Room Allocation</a>";?></span></td>
            </tr>
          
          <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><span class="style34"><img height=15 alt=Caution Fees 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></span></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><span class="style34"><?php print "<a href=\"housingcautionfeepaidreport.php?username=$username\">Caution Fees</a>";?></span></div></td>
            </tr>
          <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><span class="style34"><img height=15 alt=Penalty Fees 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></span></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><span class="style34"><?php print "<a href=\"housingcautionfeepaidpenaltyreport.php?username=$username\">Penalty Charges</a>";?></span></div></td>
            </tr>
          <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Rent Fees 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><span class="style34"><span class="style61"><?php print "<a href=\"housingroomrents.php?username=$username\">Room Rent Fees</a>";?></span></span></div></td>
            </tr>
			<tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Suggestion Box 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><?php print "<a href=\"housingcheckmessage.php?username=$username\">Check Messages</a>";?></div></td>
            </tr>
          <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Suggestion Box 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></strong></div></td>
            <td height="20" colspan="3" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24"><?php print "<a href=\"housingsuggestionbox.php?username=$username\">Suggestion Box</a>";?></div></td>
            </tr>
           <tr class="style35">
            <td height="20" colspan="2" align="right" valign="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Change Password Network 
                  hspace=4 src="/images/bd21312_.gif" width=15 
                  vspace=5 border=0></strong></div></td>
            <td height="20" align="right" valign="middle" nowrap class="style35"><div align="left" class="style24">
              <div align="left" class="style34"><?php print "<a href=\"changepassword.php?username=$username\">Change Password</a>";?></div>
                              
</div></td>
          </tr>
           <tr class="style35">
            <td height="2" nowrap><div align="center"><span class="style35"><span class="style35"><span class="style55"><span class="style55"><span class="style47"><span class="style47"><img src="/images/bd21312_.gif" alt="Sign Out" width="15" height="15"></span></span></span></span></span></span></div></td>
            <td nowrap class="style14 style9 normaltext style47"></td>
            <td colspan="3" nowrap class="style35"><div align="left" class="style24"><?php print "<a href=\"signout.php?username=$username\">Sign Out</a>";?></div></td>
            </tr>
        </table></td>
        <td height="80" align="left" valign="top"><p class="style42"><span class="style64"><font face="Verdana">Welcome</font></span><span class="style29"><font face="Verdana"> --&gt; </font></span><span class="style24"><font face="Verdana"><b>Login --&gt; <a href="/accommodation/housingindex.php">Start Page</a> </b></font></span>--&gt; Room Application Report </p>
        <p align="center" class="style42 style68">UDSM Student Information System</p>
        <p align="center" class="style42"><span class="style69">ROOM APPLICATION REPORT FOR:</span> <?php echo $year ?></p></td>
        <td bgcolor="#99CCCC">&nbsp;</td>
      </tr>
      <tr>
        <td width="671" align="center" valign="top">       	  <?php
require_once('../Connections/zalongwa.php'); 
if ($all =='on'){
$sql = "SELECT student.Name, roomapplication.RegNo, roomapplication.Hall, roomapplication.AppYear, criteria.ShortName
FROM (student INNER JOIN roomapplication ON student.RegNo = roomapplication.RegNo) INNER JOIN criteria ON roomapplication.AllCriteria = criteria.CriteriaID
WHERE (((roomapplication.AppYear)='$year')) ORDER BY criteria.ShortName";
}else{
$sql = "SELECT student.Name, roomapplication.RegNo, roomapplication.Hall, roomapplication.AppYear, criteria.ShortName
FROM (student INNER JOIN roomapplication ON student.RegNo = roomapplication.RegNo) INNER JOIN criteria ON roomapplication.AllCriteria = criteria.CriteriaID
WHERE (roomapplication.AppYear='$year') AND (criteria.ShortName = '$citeria') ORDER BY criteria.ShortName";
 }
$result = @mysqli_query($zalongwa,$sql) or die("Cannot query the database.<br>" . mysqli_error());
$query = @mysqli_query($zalongwa,$sql) or die("Cannot query the database.<br>" . mysqli_error());

$all_query = mysqli_query($zalongwa,$query);
$totalRows_query = mysqli_num_rows($query);
/* Printing Results in html */
if (mysqli_num_rows($query) > 0){
echo "<p>Total Applications: $totalRows_query </p>";
echo "<table border='1'>";
echo "<tr><td> S/No </td><td> Name </td><td> RegNo </td><td> Allocation Criteria </td><td>Description</td></tr>";
$i=1;
while($result = mysqli_fetch_array($query)) {
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
		$result = @mysqli_query($sql) or die("Cannot query the database.<br>" . mysqli_error());
	$i=$i+1;
	}
echo "</table>";

}else{
echo "Sorry, No One has Applied for a Room in This Year <br>";
}
mysqli_close($zalongwa);
?>
		  
          <div align="center"></div></td><td width="34" bgcolor="#99CCCC">&nbsp;</td>
      </tr>
    </table>
  </center>
</div>
<div align="center">
  <center>
  </center>
</div>

</body>

</html>
