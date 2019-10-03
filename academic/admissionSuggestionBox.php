<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
//	include('lecturerMenu.php');
include("communication.php");

	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Communication';
	$szSubSection = 'Suggestion Box';
	$szTitle = 'Suggestion Box';
	//include('lecturerheader.php');

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

mysqli_select_db($zalongwa, $database_zalongwa);
$query_lecturer = "SELECT UserName, FullName, Position FROM security WHERE Position = 'Lecturer' ORDER BY FullName";
$lecturer = mysqli_query($zalongwa, $query_lecturer) or die(mysqli_error($zalongwa));
$row_lecturer = mysqli_fetch_assoc($lecturer);
$totalRows_lecturer = mysqli_num_rows($lecturer);


	#chas
	//populate message receipient
	$chas = mysqli_query($zalongwa,"SELECT moduleid, modulename FROM modules");
	$row_fetch = mysqli_fetch_assoc($chas);
	$num_fetch = mysqli_num_rows($chas);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmsuggestion")) {

if(empty($_POST['message'])){
$error = urlencode("<p style='color:maroon'>Please write a message</p>");
		$location = "admissionSuggestionBox.php?error=$error";
		echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
		exit;
}
  $insertSQL = sprintf("INSERT INTO suggestion (received, fromid, toid, message) VALUES (now(), %s, %s, %s)",
                       //GetSQLValueString($_POST['received'], "text"),
                       GetSQLValueString($_POST['regno'], "text"),
                       GetSQLValueString($_POST['toid'], "text"),
                       GetSQLValueString($_POST['message'], "text"));

  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $insertSQL);

  $insertGoTo = "studentindex.php";
  if($Result1){
$error = urlencode("<p style='color:maroon'>Message Sent!!</p>");
		$location = "admissionSuggestionBox.php?error=$error";
		echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
		exit;
}else{
$error = urlencode("<p style='color:maroon'>Message Failed!!</p>");
		$location = "admissionSuggestionBox.php?error=$error";
		echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
		exit;
}


}

mysqli_select_db($zalongwa, $database_zalongwa);
$query_suggestionbox = "SELECT suggestion.received, suggestion.fromid, suggestion.toid, suggestion.message FROM suggestion";
$suggestionbox = mysqli_query($zalongwa, $query_suggestionbox) or die(mysqli_error($zalongwa));
$row_suggestionbox = mysqli_fetch_assoc($suggestionbox);
$totalRows_suggestionbox = mysqli_num_rows($suggestionbox);
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
<div class="container" style="width:55%">



<?php
if(isset($_GET['error'])){
echo $_GET['error'];
}
?>
 <form action="<?php echo $editFormAction; ?>" method="POST" name="frmsuggestion" id="frmsuggestion">
           
       <div class="form-group">
      <label for="institution">Send To:</label>
      <input name="regno" type="hidden" id="regno" value="<?php echo $RegNo; ?>">
      <select class="form-control" name="toid" id="toid">
            		<?php
if(isset($_GET['from'])){
$reg=$_GET['from'];
echo '<option value="'.$reg.'" selected="selected">'.$reg.'</option>';
}
							do {  
								if($row_fetch['modulename']=="Student" || $row_fetch['modulename']=="Blocked"){
								continue;
								}
								else{
									?>
            		<option value="<?php echo $row_fetch['moduleid']?>"><?php echo $row_fetch['modulename']?></option>
           				 <?php
									}
								} while ($row_fetch = mysqli_fetch_assoc($chas));
  								$rows = mysqli_num_rows($chas);
  								if($rows > 0) {
      								mysqli_data_seek($chas, 0);
	  								$row_chas = mysqli_fetch_assoc($chas);
  								}
						
						
						
						do {  
?>
                    <option value="<?php echo $row_lecturer['UserName']?>"><?php echo $row_lecturer['FullName']?></option>
                    <?php
} while ($row_lecturer = mysqli_fetch_assoc($lecturer));
  $rows = mysqli_num_rows($lecturer);
  if($rows > 0) {
      mysqli_data_seek($lecturer, 0);
	  $row_lecturer = mysqli_fetch_assoc($lecturer);
  }
?>
                </select>
  </div>         
     
     
           
            <table width="529" border="0">
  
       <div class="form-group">
              
                <label><strong>Message:</label>
                <textarea class="form-control" name="message" cols="50" rows="7" id="message"></textarea></td>
              </tr>
		           </table>
      
      
          <div class="form-group">
      <label for="institution">Post Massage:</label>
   <div align="left">
                    <button class="btn btn-outline-dark" name="Send" type="submit" value="">Post Message</button>
                    <span class="style64 style1">............................</span>
                    <button class="btn btn-outline-dark" type="reset" name="Reset" value="">Clear Message
                  </div>
     
     </div>
      
              <input type="hidden" name="MM_insert" value="frmsuggestion">
</form>
<?php
//}
include('../footer/footer.php');
mysqli_free_result($suggestionbox);
?>
