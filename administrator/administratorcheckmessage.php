<?php require_once('../Connections/zalongwa.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
session_start();
header("Cache-control: private"); // IE 6 Fix. 
@$auth_level = $_SESSION['auth_level'];
@$RegNo = $_SESSION['RegNo'];
@$username = $_SESSION['username'];
$maxRows_studentsuggestion = 1;
$pageNum_studentsuggestion = 0;
if (isset($_GET['pageNum_studentsuggestion'])) {
  $pageNum_studentsuggestion = $_GET['pageNum_studentsuggestion'];
}
$startRow_studentsuggestion = $pageNum_studentsuggestion * $maxRows_studentsuggestion;

$colname_studentsuggestion = "1";
if (isset($_COOKIE['RegNo'])) {
  $colname_studentsuggestion = (get_magic_quotes_gpc()) ? $_COOKIE['RegNo'] : addslashes($_COOKIE['RegNo']);
}
mysqli_select_db($database_zalongwa, $zalongwa);
$query_studentsuggestion = "SELECT id, received, fromid, toid, message FROM suggestion WHERE toid = 'admin' ORDER BY received DESC";
$query_limit_studentsuggestion = sprintf("%s LIMIT %d, %d", $query_studentsuggestion, $startRow_studentsuggestion, $maxRows_studentsuggestion);
$studentsuggestion = mysqli_query($query_limit_studentsuggestion, $zalongwa) or die(mysqli_error());
$row_studentsuggestion = mysqli_fetch_assoc($studentsuggestion);

if (isset($_GET['totalRows_studentsuggestion'])) {
  $totalRows_studentsuggestion = $_GET['totalRows_studentsuggestion'];
} else {

  $all_studentsuggestion = mysqli_query($zalongwa,$query_studentsuggestion);
  $totalRows_studentsuggestion = mysqli_num_rows($all_studentsuggestion);
}
$totalPages_studentsuggestion = ceil($totalRows_studentsuggestion/$maxRows_studentsuggestion)-1;

$queryString_studentsuggestion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_studentsuggestion") == false && 
        stristr($param, "totalRows_studentsuggestion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_studentsuggestion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_studentsuggestion = sprintf("&totalRows_studentsuggestion=%d%s", $totalRows_studentsuggestion, $queryString_studentsuggestion);

if(!$RegNo){
	echo ("Session Expired, <a href=\"Login.php\"> Click Here<a> to Re-Login");
	echo '<meta http-equiv = "refresh" content ="0; 
	url = Login.php">'; 
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

<title>OUT Student Information System</title>
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
.style64 {color: #FFFFCC}
-->
</style>
</head>

<body background-color="#FFFFCC">

<div align="center">
  <div style="text-align: center;">
    <tr> 
      <td width="100%" height="48"></td>
    </tr>
  </div>
</div>
<div align="center">
  <div style="text-align: center;">
    <table width="100%" height="100%" border="0" padding="0" border-spacing="0" border-color="#990000">

      <tr background-color="#99CCCC">
        <td height="69" colspan="7" text-align="center" vertical-align="middle"> <img src="/images/Nkurumah.gif" width="724" height="69" align="left"></td>
      </tr>
      <tr>
        <td width="55" rowspan="5" vertical-align="top">
            <table width="69%" height="100%" border="0" padding="0" border-spacing="0" border-color="#FFFFCC" background-color="#99CCCC">
          <tr class="style35">
            <td height="0" colspan="2" nowrap><div text-align="center" class="style47"><img src="/images/bd21312_.gif" alt="Your Profile" width="15" height="15"></div></td>
            <td colspan="3" nowrap class="style58"><div align="left" class="style58"><?php print "<a href=\"administratorprofile.php?username=$username\">Your Profile</a>";?><span class="style59"> <span
                                style="font-family: Verdana,serif; ">&nbsp;</span> </span></div></td>

            </tr>
         		  <tr class="style35">
            <td height="20" align="right" vertical-align="middle" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Room Application" width="15" height="15"></div></td>
            <td colspan="4" align="left" vertical-align="middle" nowrap class="style35"><span class="style58"><?php print "<a href=\"administratorcheckconnections.php?username=$username\">Check Connections</a>";?></span></td>
            </tr>
			 <tr class="style35">
            <td height="20" align="right" vertical-align="middle" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Room Application" width="15" height="15"></div></td>
            <td colspan="4" align="left" vertical-align="middle" nowrap class="style35"><span class="style58"><?php print "<a href=\"administratoradhocqueries.php?username=$username\">Database Maintenance</a>";?></span></td>
            </tr>
				  <tr class="style35">
            <td height="20" align="right" vertical-align="middle" nowrap><div align="center" class="style47"><img src="/images/bd21312_.gif" alt="Room Application" width="15" height="15"></div></td>
            <td colspan="4" align="left" vertical-align="middle" nowrap class="style35"><span class="style58"><?php print "<a href=\"adminmanageuser.php?username=$username\">Manage Users</a>";?></span></td>
            </tr>
          <tr class="style35">
            <td height="20" align="right" vertical-align="middle" nowrap><div align="center" class="style47"><img height=15 alt=Room Allocation
                  horizontal-space=4 src="/images/bd21312_.gif" width=15
                  vertical-space=5 border=0></div></td>
            <td colspan="4" align="left" valign="middle" nowrap class="style35"><span class="normaltext style24"><?php print "<a href=\"administratorWebStatistics.php?username=$username\">Web Statistics</a>";?> </span></td>
            </tr>
          <tr class="style35">
            <td height="20" colspan="2" align="right" vertical-align="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Suggestion Box
                  horizontal-space=4 src="/images/bd21312_.gif" width=15
                  vertical-space=5 border=0></strong></div></td>
            <td height="20" colspan="3" align="right" vertical-align="middle" nowrap class="style35"><div align="left" class="style24"><?php print "<a href=\"administratorcheckmessage.php?username=$username\">Suggestion Box</a>";?> </div></td>
            </tr>
           <tr class="style35">
            <td height="20" colspan="2" align="right" vertical-align="middle" nowrap><div align="center" class="style47"><strong><img height=15 alt=Change Password Network
                  hspace=4 src="/images/bd21312_.gif" width=15
                  vspace=5 border=0></strong></div></td>
            <td height="20" align="right" vertical-align="middle" nowrap class="style35"><div align="left" class="style24">
              <div align="left" class="style34"><?php print "<a href=\"changepassword.php?username=$username\">Change Password</a>";?></div>
                              
</div></td>
          </tr>
           <tr class="style35">
            <td height="2" colspan="2" nowrap><div align="center"><span class="style35"><span class="style35"><span class="style55"><span class="style55"><span class="style47"><span class="style47"><img src="/images/bd21312_.gif" alt="Sign Out" width="15" height="15"></span></span></span></span></span></span></div></td>
            <td colspan="3" nowrap class="style35"><div align="left" class="style24"><?php print "<a href=\"signout.php?username=$username\">Sign Out</a>";?> </div></td>
            </tr>
        </table></td>
        <td><div align="left">Your Messages: <span class="style64">.......................................<span class="style34"></span></span></div></td>
        <td background-color="#99CCCC">&nbsp;</td>
      </tr>
      <tr>
        <td width="672" vertical-align="top"><div align="left">
          <table style="width=669" border="1" border-color="#990000">
            <?php do { ?>
            <tr>
                <td width="66"><?php $id = $row_studentsuggestion['id']; ?><div align="right">Date:</div></td>
                <td width="593"><?php echo $row_studentsuggestion['received']; ?></td>
            </tr>
            <tr>
                <td><div lign="right">From:</div></td>
                <td><?php $from=$row_studentsuggestion['fromid']; echo $row_studentsuggestion['fromid']; ?></td>
            </tr>
            <tr>
                <td vertical-align="top"><div align="right">Message:</div></td>
                <td><?php echo $row_studentsuggestion['message']; ?></td>
            </tr>
            <?php } while ($row_studentsuggestion = mysqli_fetch_assoc($studentsuggestion)); ?>
          </table>
		    <p><a href="<?php printf("%s?pageNum_studentsuggestion=%d%s", $currentPage, max(0, $pageNum_studentsuggestion - 1), $queryString_studentsuggestion); ?>">Previous</a> Message: <?php echo min($startRow_studentsuggestion + $maxRows_studentsuggestion, $totalRows_studentsuggestion) ?> of <?php echo $totalRows_studentsuggestion ?> <span class="style64">...</span><a href="<?php printf("%s?pageNum_studentsuggestion=%d%s", $currentPage, min($totalPages_studentsuggestion, $pageNum_studentsuggestion + 1), $queryString_studentsuggestion); ?>">Next</a> <span class="style64">.......</span><?php echo "<a href=\"administratorsuggestionbox.php?from=$from\">Reply Message</a>" ?> <span class="style64">.......</span><?php echo "<a href=\"administratordeletemessage.php?id=$id\">Delete This Message</a>" ?> </p>
        </div></td>
        <td width="36" background-color="#99CCCC">&nbsp;</td>
      </tr>
    </table>
  </div>
</div>
<div align="center">
  <div style="text-align: center;">
  </div>
</div>

</body>

</html>
<?php
mysqli_free_result($studentsuggestion);
?>
