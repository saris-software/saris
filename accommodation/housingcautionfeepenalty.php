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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmCautionFeepenalty")) {
  $insertSQL = sprintf("INSERT INTO tblcautionfee (user, Date, RegNo, Paytype, Amount, Description) VALUES ('$username', now(), %s, %s,  %s, %s)",
                       GetSQLValueString($_POST['candidate'], "text"),
					    GetSQLValueString($_POST['paytype'], "int"),
                       GetSQLValueString($_POST['amount'], "double"),
                       GetSQLValueString($_POST['comments'], "text"));

  mysqli_select_db($zalongwa,$database_zalongwa);
  $Result1 = mysqli_query($zalongwa,$insertSQL) or die(mysqli_error());
echo '<meta http-equiv = "refresh" content ="0; 
	url = housingindex.php">';
}

mysqli_select_db($zalongwa,$database_zalongwa);
$query_cautionfeepenaltypenalty = "SELECT Name, RegNo FROM student ORDER BY RegNo ASC";
$cautionfeepenaltypenalty = mysqli_query($zalongwa,$query_cautionfeepenaltypenalty) or die(mysqli_error());
$row_cautionfeepenaltypenalty = mysqli_fetch_assoc($cautionfeepenaltypenalty);
$totalRows_cautionfeepenaltypenalty = mysqli_num_rows($cautionfeepenaltypenalty);

?>
              <form action="<?php echo $editFormAction; ?>" method="POST" name="frmCautionFeepenalty" id="frmCautionFeepenalty">
                <table width="200" border="1" align="left" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                  <tr>
                    <td width="89"><div align="right"><span class="style24">Candidate</span>:</div></td>
                    <td width="95">                    <input name="candidate" type="hidden" id="candidate" value="<?php echo $_GET['RegNo']; ?>"><?php echo $_GET['RegNo']; ?>
                    <input name="paytype" type="hidden" id="paytype" value="2"></td>
                  </tr>
                  <tr>
                    <td><div align="right"><span class="style24">Amount:</span></div></td>
                    <td><div align="left">
                      <input name="amount" type="text" id="amount">
                    </div></td>
                  </tr>
                  <tr>
                    <td nowrap><div align="right"><span class="style24">Comments: </span></div></td>
                    <td><textarea name="comments" cols="40" rows="5" id="comments"></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="center">
                      <input type="submit" name="Submit" value="Save Payment">
                    </div></td>
                  </tr>
                </table>
                
                  <input type="hidden" name="MM_insert" value="frmCautionFeepenalty">
              </form>
       
<?php
mysqli_free_result($cautionfeepenaltypenalty);
?>
