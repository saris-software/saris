<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Financial Reports';
	$szSubSection = 'Caution Fees';
	$szTitle = 'Financial Reports';
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmCautionFee")) {
  $insertSQL = sprintf("INSERT INTO tblcautionfee (user, Date, RegNo, Paytype, Amount, ReceiptNo) VALUES ('$username', now(), %s, %s,  %s, %s)",
                       GetSQLValueString($_POST['candidate'], "text"),
					   GetSQLValueString($_POST['paytype'], "int"),
                       GetSQLValueString($_POST['amount'], "double"),
                       GetSQLValueString($_POST['receipt'], "text"));

  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($insertSQL, $zalongwa) or die(mysql_error());
  //echo '<meta http-equiv = "refresh" content ="0; 
	//url = housingindex.php">';
}

mysql_select_db($database_zalongwa, $zalongwa);
$query_cautionfeeform = "SELECT RegNo, Amount, ReceiptNo, `Date` FROM tblcautionfee";
$cautionfeeform = mysql_query($query_cautionfeeform, $zalongwa) or die(mysql_error());
$row_cautionfeeform = mysql_fetch_assoc($cautionfeeform);
$totalRows_cautionfeeform = mysql_num_rows($cautionfeeform);

mysql_select_db($database_zalongwa, $zalongwa);
$query_cautionfee = "SELECT Name, RegNo FROM student ORDER BY RegNo ASC";
$cautionfee = mysql_query($query_cautionfee, $zalongwa) or die(mysql_error());
$row_cautionfee = mysql_fetch_assoc($cautionfee);
$totalRows_cautionfee = mysql_num_rows($cautionfee);

mysql_select_db($database_zalongwa, $zalongwa);
$query_Ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$Ayear = mysql_query($query_Ayear, $zalongwa) or die(mysql_error());
$row_Ayear = mysql_fetch_assoc($Ayear);
$totalRows_Ayear = mysql_num_rows($Ayear);
 ?>
 
              <form action="<?php echo $editFormAction; ?>" method="POST" name="frmCautionFee" id="frmCautionFee">
                <table width="200" border="1" align="left" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                  <tr>
                    <td width="89">Candidate:</td>
                    <td width="95">                    <input name="candidate" type="hidden" id="candidate" value="<?php echo $_GET['RegNo']; ?>"><?php echo $_GET['RegNo']; ?>
                    <input name="paytype" type="hidden" id="paytype" value="1"></td>
                  </tr>
                  <tr>
                    <td>Amount:</td>
                    <td><input name="amount" type="text" id="amount"></td>
                  </tr>
                  <tr>
                    <td nowrap>Receipt No.: </td>
                    <td><input name="receipt" type="text" id="receipt"></td>
                  </tr>
				  <tr>
                    <td colspan="2"><div align="center">
                      <input type="submit" name="button" value="Save Payment" onClick="check_form();">
                    </div></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="frmCautionFee">
              </form>
        
<?php
mysql_free_result($cautionfeeform);

mysql_free_result($cautionfee);

mysql_free_result($Ayear);
?>
