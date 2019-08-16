<?php require_once('../Connections/zalongwa.php'); ?>
<?php
session_start();
header("Cache-control: private"); // IE 6 Fix. 
@$auth_level = $_SESSION['auth_level'];
@$RegNo = $_SESSION['RegNo'];
@$username = $_SESSION['username'];

if (isset($_POST["AYear"])){
$year=addslashes($_POST["AYear"]);
$query_cautionfeepaid = "SELECT student.Name, student.EntryYear, tblecautionfeedefaulter.RegNo, tblecautionfeedefaulter.DefaultCost, 
tblecautionfeedefaulter.Comments, tblecautionfeedefaulter.Date FROM student INNER JOIN tblecautionfeedefaulter ON 
student.RegNo = tblecautionfeedefaulter.RegNo WHERE student.EntryYear='$year' ORDER BY Name";
$cautionfeepaid = mysql_query($query_cautionfeepaid, $zalongwa) or die(mysql_error());
$row_cautionfeepaid = mysql_fetch_assoc($cautionfeepaid);
$totalRows_cautionfeepaid = mysql_num_rows($cautionfeepaid);
}
if (isset($_POST["candidate"])){
@$key=$_POST["candidate"];
@$query_cautionfeepaid = "SELECT student.Name, student.EntryYear, tblecautionfeedefaulter.RegNo, tblecautionfeedefaulter.DefaultCost, 
tblecautionfeedefaulter.Comments, tblecautionfeedefaulter.Date FROM student INNER JOIN tblecautionfeedefaulter ON 
student.RegNo = tblecautionfeedefaulter.RegNo WHERE ((student.Name LIKE '%$key%') 
OR (tblecautionfeedefaulter.RegNo LIKE '%$key%')) ORDER BY Name";
@$cautionfeepaid = mysql_query($query_cautionfeepaid, $zalongwa) or die(mysql_error());
@$row_cautionfeepaid = mysql_fetch_assoc($cautionfeepaid);
@$totalRows_cautionfeepaid = mysql_num_rows($cautionfeepaid);
}

if (isset($_GET["RegNo"])){
@$key=$_GET["RegNo"];
@$query_cautionfeepaid = "SELECT student.Name, student.EntryYear, tblecautionfeedefaulter.RegNo, tblecautionfeedefaulter.DefaultCost, 
tblecautionfeedefaulter.Comments, tblecautionfeedefaulter.Date FROM student INNER JOIN tblecautionfeedefaulter ON 
student.RegNo = tblecautionfeedefaulter.RegNo WHERE ((student.Name LIKE '%$key%') 
OR (tblecautionfeedefaulter.RegNo LIKE '%$key%')) ORDER BY Name";
@$cautionfeepaid = mysql_query($query_cautionfeepaid, $zalongwa) or die(mysql_error());
@$row_cautionfeepaid = mysql_fetch_assoc($cautionfeepaid);
@$totalRows_cautionfeepaid = mysql_num_rows($cautionfeepaid);
}

mysql_select_db($database_zalongwa, $zalongwa);
$query_Ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$Ayear = mysql_query($query_Ayear, $zalongwa) or die(mysql_error());
$row_Ayear = mysql_fetch_assoc($Ayear);
$totalRows_Ayear = mysql_num_rows($Ayear);


if(!$auth_level){
	echo ("Session Expired, <a href=\"ReLogin.php\"> Click Here<a> to Re-Login");
	header("Location: ReLogin.php"); 
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
.style29 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style31 {color: #000066}
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
.style42 {color: #000000}
.style47 {font-size: small}
.style55 {font-size: 10px}
.style58 {color: #993300; font-size: 12px; }
.style59 {color: #993300}
.style60 {font-size: 11px; color: #990000;}
.style61 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style63 {font-size: 12px; color: #990000;}
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
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr bgcolor="#99CCCC"> 
        <td height="69" colspan="5" align="center" valign="middle"> 
          <div align="left"><img src="/images/Nkurumah.gif" width="735" height="69" align="absmiddle"></div></td>
      </tr>
      <tr bgcolor="#FFFFCC" class="normaltext"> 
        <td height="28" colspan="3" align="center" valign="middle" nowrap> 
          <div align="left" class="style24"><span class="style29"><font face="Verdana" color="#FFFF00"><b><font color="006699"><a href="/index.html">Welcome</a> </font></b></font><font face="Verdana"><b><span class="style42">--&gt;</span></b></font></span><span class="style24"><font face="Verdana"><b>User Menu</b></font></span></div>        </td>
        <td colspan="2" align="center" valign="middle" nowrap><form action="/accommodation/housingcautionfeepaidpenaltyreport.php" method="post" name="searchcandidate" id="searchcandidate">
              <table width="390" border="0">
                <tr>
                  <td width="155" height="32" nowrap><div align="right"><span class="style24">Search Candidate:</span></div></td>
                  <td width="225" nowrap><div align="right">
                    <input name="candidate" type="text" id="candidate">
                    <input name="search" type="submit" id="search" value="Search">
                  </div></td>
                </tr>
            </table>
            </form> 
        </td>
      </tr>
      <tr> 
        <td width="120" valign="top"><table width="62%" height="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFCC" bgcolor="#99CCCC">
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
        </table> 
        </td>
        <td colspan="4" align="left" valign="top">
        <div align="center"></div>        <div align="left">
            <form action="/accommodation/housingcautionfeepaidpenaltyreport.php" method="post" name="yearsearchform" id="yearsearchform">
              <table width="679" border="0">
                <tr>
                  <td width="182" height="32" nowrap bgcolor="#CCCCCC">Create Report Starting Date:</td>
                  <td width="177" nowrap bgcolor="#CCCCCC">                  <select name="AYear" id="AYear">
                    <?php
do {  
?>
                    <option value="<?php echo $row_Ayear['AYear']?>"><?php echo $row_Ayear['AYear']?></option>
                    <?php
} while ($row_Ayear = mysql_fetch_assoc($Ayear));
  $rows = mysql_num_rows($Ayear);
  if($rows > 0) {
      mysql_data_seek($Ayear, 0);
	  $row_Ayear = mysql_fetch_assoc($Ayear);
  }
?>
                  </select>
                  <input name="search" type="submit" id="search" value="Search"></td>
                  <td width="306" nowrap bgcolor="#CCFFFF"><div align="center">                  <a href="/accommodation/housingcautionfeereport.php">Add Penalty Charges or Caution Fee </a></div></td>
                </tr>
                <tr>
                  <td colspan="3">                        <div align="left">
                  </div></td>
                </tr>
              </table>
            </form>
            
            <?php if (@$totalRows_cautionfeepaid > 0) {  echo @"Penalty Charges Payment Report For:  \"$year $key \""; // Show if recordset not empty ?>
		
            <table width="200" border="1">
              <tr>
                <td>Candidate</td>
                <td>RegNo</td>
                <td nowrap>Penalty</td>
				 <td nowrap>Reason</td>
				  <td nowrap>Date Recorded </td>
                </tr>
			  <?php $amount =0;?>
              <?php do { ?>
              <tr>
                <td nowrap><?php echo $row_cautionfeepaid['Name']; ?></td>
                <td nowrap><?php echo $row_cautionfeepaid['RegNo']; ?></td>
                <td nowrap><?php $j=$row_cautionfeepaid['DefaultCost']; echo $row_cautionfeepaid['DefaultCost']; ?></td>
                <td nowrap><?php echo $row_cautionfeepaid['Comments']; ?></td>
                <td nowrap><?php echo $row_cautionfeepaid['Date']; ?></td>
                </tr>
              <?php $amount = $amount+$j;} while ($row_cautionfeepaid = mysql_fetch_assoc($cautionfeepaid)); ?>
            </table>
            <?php } if (@$amount >0){ echo "Penalty Charges Grand Total:  $amount";}// Show if recordset not empty ?>
            <p>&nbsp;</p>
        </div>        <div align="center" class="normaltext style31"></div></td>
      </tr>
      <tr> 
        <td></td>
        <td width="252"></td>
        <td width="218"></td>
        <td width="305"></td>
        <td width="94"></td>
      </tr>
      <tr> 
        <td><img height="1" width="120" src="/images/spacer.gif"></td>
        <td><img height="1" width="5" src="/images/spacer.gif"></td>
        <td><img height="1" width="168" src="/images/spacer.gif"></td>
        <td></td>
        <td><img height="1" width="10" src="/images/spacer.gif"></td>
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
<?php
@

mysql_free_result($cautionfeepaid);

mysql_free_result($Ayear);
?>
