<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Communication';
	$szSubSection = 'News & Events';
	$szTitle = 'University News & Events';
	include('lecturerheader.php');

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

  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }

  echo '<meta http-equiv = "refresh" content ="0; url = studentNews.php">';
}


mysql_select_db($database_zalongwa, $zalongwa);
$query_suggestionbox = "SELECT received, fromid, toid, message FROM news ORDER BY received DESC";
$suggestionbox = mysql_query($query_suggestionbox, $zalongwa) or die(mysql_error());
$row_suggestionbox = mysql_fetch_assoc($suggestionbox);
$totalRows_suggestionbox = mysql_num_rows($suggestionbox);

$regnos = $RegNo;
$RegNo = $_GET['from'];


function viewers()
{
echo"<select name='recepient'>";
$v=array("Admission","Academic","Accommodation","Billing/Accounts","Database Administrator","Students","Timetable");
for($k=0;$k<count($v);$k++)
{
echo"<option value='$k'>$v[$k]</option>";
}
echo"</select>";
}
 ?>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="usersearch" id="usersearch">
		<table class="resView" border="0" align="left">			
			<tr>
				<td class="resViewhd" nowrap align="left">Name or ID(Registration) Number:<input name="key" type="text" id="key" size="20" maxlength="20">
				</td>
				<td class="resViewhd">
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
				//echo "<p style='color:maroon'>Sorry the user $key is not registered in the SARIS system</p>";
				$error = urlencode("Sorry the user <b>$key</b> is not registered in the SARIS system");
				$goto = "admissionPostNews.php?error=$error";
				echo '<meta http-equiv="refresh" content="0; url='.$goto.'">';
				exit;
				}
			else{
				echo "<table class='resView' border='0' style='margin-left:40px; margin-top:80px'>
						<tr style='font-weight:bold'>
							<td class='resViewhd' nowrap>S/No</td>
							<td class='resViewhd' nowrap>Name</td>
							<td class='resViewhd' nowrap>ID(Registration) Number</td>
							<td class='resViewhd' nowrap>SARIS Username</td>
						</tr>";
				$sn = 1;
				while($val = mysql_fetch_array($query)){
					echo "<tr>
							<td class='resViewtd' nowrap>$sn</td>
							<td class='resViewtd' nowrap>".$val['FullName']."</td>
							<td class='resViewtd' nowrap>".$val['RegNo']."</td>
							<td class='resViewtd' nowrap>".$val['UserName']."</td>
						 </tr>";
					$sn += 1;
					}
				echo "</table>";
				}
			}
    
    ?>

<form action="<?php echo $editFormAction; ?>" method="POST" name="frmsuggestion" id="frmsuggestion">

            <table class='resView' border="0" align="left">			  
			  <tr>
				<td class='resViewhd' nowrap><input type="checkbox" name="specific" value="S"><b>Specify Username</b></td>
                <td class='resViewtd'><input name="key" type="text" id="key" size="20" maxlength="20"></td>
              </tr>              
			  <tr>
              <tr>
                <td class='resViewhd'><div align="right"><strong>Message:</strong></div></td>
                <td class='resViewtd' width="100"><textarea name="message" cols="75" rows="13" id="message"></textarea></td>
				<input name="regno" type="hidden" id="regno" value="<?php echo $regnos?>">
              </tr>              
              <tr>
				<td class='resViewhd' nowrap>Recepients(Viewers) Group</td>
                <td class='resViewhd' nowrap><?php viewers();?> 
				  <input name="Send" type="submit" value="Post Message" onmouseover="this.style.background='#DEFEDE'"
onmouseout="this.style.background='lightblue'" title="Click to Post Message" style='background-color:lightblue;color:black;font-size:9pt;font-weight:bold'>
                  ..........................
                  <input type="reset" name="Reset" value="Clear Message" onmouseover="this.style.background='#DEFEDE'"
onmouseout="this.style.background='lightblue'" title="Click to Clear Message" style='background-color:lightblue;color:black;font-size:9pt;font-weight:bold'>
                </div></td>
			  <tr>			
            </table>            
              <input type="hidden" name="MM_insert" value="frmsuggestion">
</form>
<?php
	
	if(isset($_GET['error'])){
		$error = urldecode($_GET['error']);
		echo "<table align='left' border='0'>
				  <tr>
					  <td> <p style='color:maroon; align:left'>ERROR: $error</p></td>
				  </tr>
			  </table>";
		}
//}
include('../footer/footer.php');
mysql_free_result($suggestionbox);
?>
