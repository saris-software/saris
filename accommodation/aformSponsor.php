<?php require_once('../Connections/zalongwa.php'); ?>
<?php
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "staff")) {
  $insertSQL = sprintf("INSERT INTO sponsors (Name, Address, comment) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['szSponsor'], "text"),
                       GetSQLValueString($_POST['szAddress'], "text"),
                       GetSQLValueString($_POST['szTelephone'], "text"));

  mysqli_select_db($zalongwa,$database_zalongwa);
  $Result1 = mysqli_query($zalongwa,$insertSQL) or die(mysqli_error());
}
?>
<?php 
	include('../Connections/gt_functions.php');

	# include the header
	require_once('../Connections/sessioncontrol.php');
	# include the header
	include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Sponsor Details';
	$szSubSection = 'Sponsor';
	include("admissionheader.php");
	
?>
   <form name="staff" method="POST" action="<?php echo $editFormAction; ?>">
<table cellspacing="1" cellpadding="0" border="0" width=100% bgcolor="#CCCCCC">

 
		<input name="intApplicantID" id="intApplicantID" type="Hidden" value="<?=$_GET['intApplicantID']?>">
			<tr style="font-weight: bold;">
				<td align=right>Field</td>
				<td>Value</td>
			</tr>
    
              
  
              <TR bgcolor="ffffff">
                <TD align=right valign=top>Name of Sponsor</TD>
                <TD><input type="text" name="szSponsor" size="30" class="vform" id="szSponsor" value="<?=$arrSponsor['szSponsor']?>">
                </TD>
              </TR>
			  
			  	  
			  <TR bgcolor="ffffff">
                <TD align=right valign=top>Address</TD>
                <TD><input type="text" class="vform" size="30" name="szAddress" value="<?=$arrSponsor['szAddress']?>"></TD>
              </TR>
			  
			  <TR bgcolor="ffffff">
                <TD align=right valign=top>Telephone No.</TD>
                <TD><input type="text" class="vform" size="30" name="szTelephone" value="<?=$arrSponsor['szTelephone']?>"></TD>
              </TR>
			  
			  <tr>
				<td>&nbsp;</td>
				<td><input  class="vform" type="submit" name="action" value="update" onClick="return formValidator()"></td>
			  </tr>
    <!---->
</table>
<input type="hidden" name="MM_insert" value="staff">
</form>
<br>

<!-- A Separate Layer for the Calendar -->
<!--	form validation scripts	-->
<script language="JavaScript" type="text/javascript">
	var validator  = new Validator("staff");
	
	validator.addValidation("szSponsor","req","The Sponsor's name must be entered.");
	
	validator.addValidation("szAddress","req","Please enter the Address.");
	
	validator.addValidation("szTelephone","req","Please enter the Telephone Number.");

</script>	
<?php 
	include("../footer/footer.php");
?>
