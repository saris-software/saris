<?php require_once('../Connections/zalongwa.php'); ?>
<?php
session_start();
header("Cache-control: private"); // IE 6 Fix. 
@$auth_level = $_SESSION['auth_level'];
@$RegNo = $_SESSION['RegNo'];
@$username = $_SESSION['username'];
//$key=$_GET['course'];
//$ayear=$_GET['ayear'];

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
//if ((isset($_POST["MM_edit"])) && ($_POST["MM_edit"] == "editnorminorol")) {
$all=$_POST['check'];
$ayear=$_POST['AllCriteria'];
$degree=$_POST['degree'];

$query_addexam = "SELECT student.Name,
       student.RegNo,
       student.Sex,
       student.DBirth,
       student.MannerofEntry,
       student.MaritalStatus,
       student.Campus,
       student.ProgrammeofStudy,
       student.Faculty,
       student.Department,
       student.Sponsor,
       student.GradYear,
       student.EntryYear,
       student.Status,
       student.YearofStudy,
       student.Address,
       student.comment,
       student.Photo,
       student.IDProcess,
       student.Nationality,
       student.Region,
       student.District,
       student.Country,
       student.ParentOccupation,
       student.Received,
       student.user
  FROM student
  WHERE student.EntryYear = '$ayear' ORDER BY RegNo ASC";
//}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$ExamNo = $_POST['ExamNo'];
	$coursecode = $_POST['coursecode'];
	$RegNo = $_POST['RegNo'];
	$cwk = $_POST['cwk'];
	$exam = $_POST['exam'];
	$total = $_POST['total'];
	$grade = $_POST['grade'];
	$remark = $_POST['remark'];
	@$checkbox = $_POST['checked'];
	$core=$_POST['core'];
		
	for($c = 0; $c < sizeof($ExamNo); $c++) {
			//check if student is blocked
						
			$updateSQL = "UPDATE student SET ExamNo='$ExamNo[$c]', Coursework = '$cwk[$c]', Exam = '$exam[$c]', 
			Total ='$total[$c]', Grade = '$grade[$c]', Remarks = '$remark[$c]', Status = '$core[$c]' 
			WHERE RegNo='$RegNo[$c]' AND CourseCode='$coursecode'";
            //mysql_select_db($database_zalongwa, $zalongwa);
  			$Result1 = mysql_query($updateSQL) or die(mysql_error()); 
			}
			
}	

$addexam = mysql_query($query_addexam, $zalongwa) or die(mysql_error());
$row_addexam = mysql_fetch_assoc($addexam);
$totalRows_addexam = mysql_num_rows($addexam);
 


if(!$auth_level){
	echo ("Session Expired, <a href=\"ReLogin.php\"> Click Here<a> to Re-Login");
	echo '<meta http-equiv = "refresh" content ="0; 
						url = ReLogin.php">';
					exit;
}
$browser  =  $_SERVER["HTTP_USER_AGENT"];   
$ip  =  $_SERVER["REMOTE_ADDR"];   

require_once('../Connections/zalongwa.php'); 

$sql="INSERT INTO stats(ip,browser,received,page) VALUES('$ip','$browser',now(),'$username')";   
//$sqldel = "delete from stats where (YEAR(CURRENT_DATE)-YEAR(received))- (RIGHT(CURRENT_DATE,5)<RIGHT(received,5))>1";
$result = mysql_query($sql) or die("Siwezi kuingiza data.<br>" . mysql_error());
mysql_close($zalongwa);
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
.style25 {
	color: #3366CC;
	font-weight: bold;
}
.style26 {color: #FFFF00}
.style29 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
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
.style64 {font-size: 24px}
.style65 {font-size: 18px}
.style67 {font-size: 16}
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
  </center>
</div>
<div align="center">
  <center>
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr bgcolor="#66CCCC">
        <td height="69" colspan="4" align="center" valign="middle">
          <div align="left"><img src="/images/Nkurumah.gif" width="735" height="69" align="absmiddle"></div></td>
      </tr>
      <tr bgcolor="#FFFFCC" class="normaltext">
        <td height="28" colspan="3" align="center" valign="middle" nowrap>
          <div align="left" class="style24"><span class="style29"><font face="Verdana" color="#FFFF00"><b><font color="006699"><a href="/index.html">Welcome</a> </font></b></font><font face="Verdana"><b><span class="style42">--&gt;</span></b></font></span><font face="Verdana"><b> User Menu</b></font><span class="style29"><font face="Verdana"> </font> </span> </div>
          <form action="/academic/lecturerexamofficerpublishresults.php" method="get" class="style24">
            <div align="right"><span class="style42"><font face="Verdana"><b>Search</b></font></span> <font color="006699" face="Verdana"><b>
              <input type="text" name="content" size="15">
              </b></font><font color="#FFFF00" face="Verdana"><b>
              <input type="submit" value="GO" name="go">
            </b></font> </div>
          </form></td>
      </tr>
      <tr>
        <td height="236" colspan="2" valign="top"><table width="62%" height="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFCC" bgcolor="#99CCCC">
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
            <td height="20" align="right" valign="middle" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Nominal Roll" width="15" height="15"></div></td>
            <td colspan="4" align="left" valign="middle" nowrap class="style35"><span class="style58"><?php print "<a href=\"housingeditnorminalroll.php?username=$username\">Edit Nominal Roll</a>";?></span></td>
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
            <div align="center"></div></td>
        <td width="874" height="236" valign="top"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
            <p align="center">&nbsp;</p>
            <p>  
			
		    <table width="100%" border="1" align="center">
              <tr>
                <td>S/No</td>
				 <td>Sex</td>
                <td>Name</td>
                <td>RegNo</td>
                <td>ExamNo</td>
                <td>Coursework</td>
                <td>Exam</td>
                <td>Total</td>
                <td>Grade</td>
                <td>Remarks</td>
				  <td>Core/Option</td>
				  <td>Drop</td>
              </tr>
              <?php $i=1;do { ?>
              <tr>
                <td align="left" valign="middle"><div align="left"> <?php echo $i; ?> </div></td>
				 <td>
                  <input name="Name[]" type="text" id="Name[]" value="<?php echo $row_addexam['Name']; ?>">
                </td>
				<td>
                  <input name="sex[]" type="text" id="sex[]" value="<?php echo $row_addexam['Sex']; ?>">
                </td>
				<td>
                  <input name="RegNo[]" type="text" id="RegNo[]" value="<?php echo $row_addexam['RegNo']; ?>">
                </td>
				<td>
                  <input name="DBirth[]" type="text" id="DBirth[]" value="<?php echo $row_addexam['DBirth']; ?>">
                </td>
				                <td align="left" valign="middle" nowrap>&nbsp;</td>
                <td align="left" valign="middle"><input name="RegNo[]" type="hidden" id="RegNo[]" value="<?php echo $row_addexam['RegNo']; ?>">                    </td>
                <td>&nbsp;                </td>
                <td>&nbsp;                </td>
                <td>&nbsp;                </td>
                <td>
                <input name="total[]" type="hidden" id="total[]"></td>
                <td>
                <input name="grade[]" type="hidden" id="grade[]"></td>
                <td><select name="remark[]" id="remark[]">
                  <option value="<?php echo $row_addexam['Remarks']?>"><?php echo $row_addexam['Remarks']?></option>
				  <option value="Pass">Pass</option>
                  <option value="Fail">Fail</option>
                  <option value="Incomplete">Incomplete</option>
                  <option value="Discontinued">Discontinued</option>
 </select></td>
                <td><select name="core[]" id="core[]">
                  <option value="<?php echo $row_addexam['Status']?>"><?php echo $row_addexam['Status']?></option>
				  <option value="Core" >Core Course</option>
                  <option value="Option">Option Course</option>
                </select></td>
                <td><?php print "<a href=\"lecturerexalresultdelete.php?RegNo=$regno&ayear=$ayear&key=$key\">Drop</a>";?></td>
              </tr>
              <?php $i=$i+1;} while ($row_addexam = mysql_fetch_assoc($addexam)); ?>
            </table>
		
		
            <p></p>
            <p>
              <input type="submit" name="Submit" value="Update Records">
              <input type="hidden" name="MM_update" value="form1">
            </p>
        </form></td>
      </tr>
      <tr>
        <td width="87" height="2"></td>
      </tr>
    </table>
  </center>
</div>

</body>

</html>
<?php
mysql_free_result($addexam);
?>
