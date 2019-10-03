<?php 

#get connected to the database and verfy current session

	require_once('../Connections/sessioncontrol.php');

    require_once('../Connections/zalongwa.php');

	

	# initialise globals

	include('communication.php');

	

	# include the header

	global $szSection, $szSubSection;

	$szSection = 'Communication';

	$szSubSection = 'News & Events';

	$szTitle = 'Institute News & Events';

//	include('lecturerheader.php');



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

  mysqli_select_db($zalongwa, $database_zalongwa);

  $Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error($zalongwa));



  //$insertGoTo = "housingcheckmessage.php";

  if (isset($_SERVER['QUERY_STRING'])) {

    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";

    $insertGoTo .= $_SERVER['QUERY_STRING'];

  }

  echo '<meta http-equiv = "refresh" content ="0; url = studentNews.php">';

}



mysqli_select_db($zalongwa, $database_zalongwa);

$query_suggestionbox = "SELECT received, fromid, toid, message FROM news ORDER BY received DESC";

$suggestionbox = mysqli_query($zalongwa, $query_suggestionbox) or die(mysqli_error($zalongwa));
$row_suggestionbox = mysqli_fetch_assoc($suggestionbox);
$totalRows_suggestionbox = mysqli_num_rows($suggestionbox);


$regnos = $RegNo;
$RegNo = $_GET['from'];

 ?>
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div align select="center">
<div class="container" style="width:60%">

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


  
<div class="form-group">
      <label for="address">Name or ID(Registration) Number::</label>
        <input class="form-control"  name="key" type="text" id="key">
					</div>
<div align="center"><button class="btn btn-outline-dark" type="submit" name="search" value="">Search</button></div>
    

    </form>
    
    <?php
		if(isset($_POST['search'])){
			$key = stripslashes($_POST['key']);
			
			$query = mysqli_query($zalongwa,"SELECT * FROM security WHERE FullName like '%$key%' OR RegNo like '%$key%'");
			$rows = mysqli_num_rows($query);
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
				while($val = mysqli_fetch_array($query)){
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



<div class="form-group">
<input type="checkbox" name="specific" value="S">
      <label for="address">Specify Username:</label>
      			<input name="key" type="text" id="key" value="" class="form-control">
					</div>

<div class="form-group">
 <label for="address">Message:</label>
 
          <textarea class="form-control" name="message" cols="75" rows="13" class="normaltext" id="message"></textarea>
				<input name="regno" type="hidden" id="regno" value="<?php echo $regnos?>">
			</div>

<div class="form-group">
      <label for="institution">Recepients(Viewers) Group:</label>
      <?php viewers();?> 
				  </div>
			<div align="center">
				  <button class="btn btn-outline-dark" name="Send" type="submit" value="">Post Message</button>
                  <span class="style64 style1">........</span>
                  <button class="btn btn-outline-dark" type="reset" name="Reset" value="">Clear Message</button>
	</div>
              <input type="hidden" name="MM_insert" value="frmsuggestion">
</form>

<?php

//}

include('../footer/footer.php');

mysqli_free_result($suggestionbox);

?>
