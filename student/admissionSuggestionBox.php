<?php 

#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');


	# initialise globals
	include('studentMenu.php');


	# include the header
	global $szSection, $szSubSection;

	$szSection = 'Communication';
	$szSubSection = 'Suggestion Box';
	$szTitle = 'Suggestion Box';

	include('studentheader.php');


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



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmsuggestion")) {

  $insertSQL = sprintf("INSERT INTO suggestion (received, fromid, toid, message) VALUES (now(), %s, %s, %s)",

                       //GetSQLValueString($_POST['received'], "text"),

                       GetSQLValueString($_POST['regno'], "text"),

                       GetSQLValueString($_POST['toid'], "text"),

                       GetSQLValueString($_POST['message'], "text"));



  mysqli_select_db($zalongwa, $database_zalongwa);

  $Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error($zalongwa));



  $insertGoTo = "admissionSuggestionBox.php";

  if (isset($_SERVER['QUERY_STRING'])) {

    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";

    $insertGoTo .= $_SERVER['QUERY_STRING'];

  }

echo '<meta http-equiv = "refresh" content ="0; url = admissionSuggestionBox.php">';

}

$regnos = $RegNo;

mysqli_select_db($zalongwa, $database_zalongwa);

$query_suggestionbox = "SELECT suggestion.received, suggestion.fromid, suggestion.toid, suggestion.message FROM suggestion";
$suggestionbox = mysqli_query($zalongwa, $query_suggestionbox) or die(mysqli_error($zalongwa));
$row_suggestionbox = mysqli_fetch_assoc($suggestionbox);
$totalRows_suggestionbox = mysqli_num_rows($suggestionbox);


if(isset($_GET['ID'])){
	$id = urldecode($_GET['ID']);
	$name = urldecode($_GET['name']);
?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmsuggestion" id="frmsuggestion">

            <table width="529" border="0">

              <tr>
                <td width="95" height="21"><div align="right"><strong>Send To:</strong></div></td>
				<!--
                <td width="424" nowrap>System Administrator 
                  <input name="regno" type="hidden" id="regno" value="<?php //echo $RegNo; ?>">
                  <input name="toid" type="hidden" id="toid" value="admin">
                  <input name="received" type="hidden" id="received" value="<?php //$today = date("F j, Y"); echo $RegNo; ?>"></td>
				-->
				<td><?php 											
						echo "<input type='text' name='name' value='$name' readonly style='width:300px'>";
						echo "<input type='hidden' name='toid' value='$id' readonly style='width:200px'>";
						echo "<input type='hidden' name='regno' value='$RegNo'>";
				?></td>
              </tr>

              <tr>
                <td height="136"><div align="right"><strong>Message:</strong></div></td>
                <td><textarea name="message" cols="50" rows="7" class="normaltext" id="message"></textarea></td>
              </tr>

			  <tr>
                <td height="28" nowrap><div align="right"><strong>Post Message:</strong></div></td>
                <td nowrap>
                  <div align="left">
                    <input name="Send" type="submit" value="Post Message">
                    <span class="style64 style1">............................</span>
                    <input type="reset" name="Reset" value="Clear Message">
                  </div>
                </td>
              </tr>

            </table>

              <input type="hidden" name="MM_insert" value="frmsuggestion">

</form>

<?php

//}

include('../footer/footer.php');

//mysqli_free_result($suggestionbox);
}
?>

<?php
function viewers()
{
echo"<select name='toid'>";
$v=array("Admission","Academic","Accommodation","Billing/Accounts","Database Administrator");
for($k=0;$k<count($v);$k++)
{
echo"<option value='$k'>$v[$k]</option>";
}
echo"</select>";
}
?>

 <form action="<?php echo $editFormAction; ?>" method="POST" name="frmsuggestion" id="frmsuggestion">

            <table width="529" border="0">

              <tr>
                <td width="95" height="21"><div align="right"><strong>Send To:</strong></div></td>
				<!--
                <td width="424" nowrap>System Administrator 
                  <input name="regno" type="hidden" id="regno" value="<?php //echo $RegNo; ?>">
                  <input name="toid" type="hidden" id="toid" value="admin">
                  <input name="received" type="hidden" id="received" value="<?php //$today = date("F j, Y"); echo $RegNo; ?>"></td>
				-->
				<td>
					<?php viewers();?>
					<input type="hidden" name="regno" value="<?php echo $RegNo; ?>">
				</td>
              </tr>

              <tr>
                <td height="136"><div align="right"><strong>Message:</strong></div></td>
                <td>
					<textarea name="message" cols="50" rows="7" class="normaltext" id="message"></textarea>					
					</td>
              </tr>

			  <tr>
                <td height="28" nowrap><div align="right"><strong>Post Message:</strong></div></td>
                <td nowrap>
                  <div align="left">
                    <input name="Send" type="submit" value="Post Message">
                    <span class="style64 style1">............................</span>
                    <input type="reset" name="Reset" value="Clear Message">
                  </div>
                </td>
              </tr>

            </table>

              <input type="hidden" name="MM_insert" value="frmsuggestion">

</form>

<?php

//}

include('../footer/footer.php');

mysqli_free_result($suggestionbox);

?>
