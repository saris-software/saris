<?php 
#get connected to the database and verfy current session	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# initialise globals
	include('admissionMenu.php');
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Communication';
	$szSubSection = 'News & Events';
	$szTitle = 'Institute News & Events';
	include('admissionheader.php');

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
  switch ($theType) {
    case "text":      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";      break;    	case "long":
    case "int":      $theValue = ($theValue != "") ? intval($theValue) : "NULL";      break;
    case "double":      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";      break;
    case "defined":      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;      break;  }  return $theValue;}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmsuggestion")) {
	
	if($_POST['specific']=='S'){
		if($_POST['key']==""){
			$error = urlencode("You have to specify desired username or userID!");
			$goto = "admissionPostNews.php?error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$goto.'">';
			exit;
			}
		elseif($_POST['message']==""){
			$error = urlencode("You can not send an empty message!");
			$goto = "admissionPostNews.php?error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$goto.'">';
			exit;
			}
		else{
			$insertSQL = sprintf("INSERT INTO suggestion (received, fromid, toid, message) VALUES (now(), %s, %s, %s)",

                       GetSQLValueString($_POST['regno'], "text"),
                       GetSQLValueString($_POST['key'], "text"),
                       GetSQLValueString($_POST['message'], "text"));
			}		
		}
	else{
		if($_POST['message']==""){
			$error = urlencode("You can not broadcast an empty message!");
			$goto = "admissionPostNews.php?error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$goto.'">';
			exit;
			}
		else{
		$insertSQL = sprintf("INSERT INTO news (received, fromid, toid, message) VALUES (now(), %s, %s, %s)",

                       GetSQLValueString($_POST['regno'], "text"),
                       GetSQLValueString($_POST['recepient'], "text"),
                       GetSQLValueString($_POST['message'], "text"));
             }
		} 
		
  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($insertSQL, $zalongwa) or die(mysql_error());

  //$insertGoTo = "housingcheckmessage.php";
  if (isset($_SERVER['QUERY_STRING'])) {    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";    $insertGoTo .= $_SERVER['QUERY_STRING'];  }
  echo '<meta http-equiv = "refresh" content ="0; url = studentNews.php">';
}

mysql_select_db($database_zalongwa, $zalongwa);
$query_suggestionbox = "SELECT received, fromid, toid, message FROM news ORDER BY received DESC";
$suggestionbox = mysql_query($query_suggestionbox, $zalongwa) or die(mysql_error());
$row_suggestionbox = mysql_fetch_assoc($suggestionbox);
$totalRows_suggestionbox = mysql_num_rows($suggestionbox);$regnos = $RegNo;
$RegNo = $_GET['from'];
 ?>

<?php
function viewers()
{
echo"<select name='recepient'>";
$v=array("Admission","Academic","Accommodation","Billing/Accounts","Database Administrator","Students");
for($k=0;$k<count($v);$k++)
{
echo"<option value='$k'>$v[$k]</option>";
}
echo"</select>";
}
?>

	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="usersearch" id="usersearch">
		<table width="284" border="0">
			<tr>
				<td colspan="2" nowrap><div align="center"></div></td>
			</tr>
			<tr>
				<td nowrap>Name or ID(Registration) Number:				
					<span class="style67" border="#ECE9D8" bgcolor="#CCCCCC"><input name="key" type="text" id="key" size="20" maxlength="20"></span>
				</td>
				<td >
					<div align="center"><input type="submit" name="search" value="Search"></div>
				</td>
			</tr>			
      </table>
    </form>
    
    <?php
		if(isset($_POST['search'])){
			$key = stripslashes($_POST['key']);
			
			$query = mysql_query("SELECT * FROM security WHERE FullName like '%$key%' OR RegNo like '%$key%'");
			$rows = mysql_num_rows($query);
			if($rows == 0){
				echo "<p style='color:maroon'>Sorry the user $key is not registered in the SARIS system</p>";
				}
			else{
				echo "<table border='1' cellpadding='2' cellspacing='0'>
						<tr style='font-weight:bold'>
							<td nowrap>S/No</td>
							<td nowrap>Name</td>
							<td nowrap>ID(Registration) Number</td>
							<td nowrap>SARIS Username</td>
						</tr>";
				$sn = 1;
				while($val = mysql_fetch_array($query)){
					echo "<tr>
							<td nowrap>$sn</td>
							<td nowrap>".$val['FullName']."</td>
							<td nowrap>".$val['RegNo']."</td>
							<td nowrap>".$val['UserName']."</td>
						 </tr>";
					$sn += 1;
					}
				echo "</table>";
				}
			}
    echo "<hr>";
    
    if(isset($_GET['error'])){
		$error = urldecode($_GET['error']);
		echo "<p style='color:maroon'>$error</p>";
		}
    ?>

<form action="<?php echo $editFormAction; ?>" method="POST" name="frmsuggestion" id="frmsuggestion">

            <table width="529" border="0" style="padding-top:20px">
			  
			  <tr>
				<td class='formfield' nowrap><input type="checkbox" name="specific" value="S"><b>Specify Username</b></td>
                <td><input name="key" type="text" id="key" size="20" maxlength="20"></td>
              </tr>
              
			  <tr>

              <tr>
                <td width="95" height="189"><div align="right"><strong>Message:</strong></div></td>
                <td width="424"><textarea name="message" cols="75" rows="13" class="normaltext" id="message"></textarea></td>
				<input name="regno" type="hidden" id="regno" value="<?php echo $regnos?>">
              </tr>
              
              <tr>
				<td class='formfield' nowrap>Recepients(Viewers) Group</td>
                <td><?php viewers();?> 
				  <span class="style64 style1">............</span>
				  <input name="Send" type="submit" value="Post Message">
                  <span class="style64 style1">........</span>
                  <input type="reset" name="Reset" value="Clear Message"></td></tr>
			  <tr>
			<!--
			  <tr>
                <td height="28" nowrap><div align="right"><strong>Post Message:</strong></div></td>
                <td nowrap><div align="center">
                  <input name="Send" type="submit" value="Post Message">
                  <span class="style64 style1">................................................</span>
                  <input type="reset" name="Reset" value="Clear Message">
                </div></td>
              </tr>
			-->

            </table>            
              <input type="hidden" name="MM_insert" value="frmsuggestion">
</form>

<?php

//}

include('../footer/footer.php');

mysql_free_result($suggestionbox);

?>
