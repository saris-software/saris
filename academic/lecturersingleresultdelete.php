<?php
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Search';
	$szTitle = 'Examination Result';
	include('lecturerheader.php');

$regno=$_GET['RegNo'];
$ayear=$_GET['ayear'];
$key=$_GET['key'];
$examcat=$_GET['examcat'];
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

if ((isset($_GET['RegNo'])) && ($_GET['RegNo'] != "")) {
  #delete in examregister 
  $deleteSQL = "DELETE FROM examregister WHERE  (RegNo='$regno') AND (CourseCode = '$key')";                   
  mysqli_select_db($zalongwa,$database_zalongwa);
  $Result1 = mysqli_query($zalongwa,$deleteSQL) or die(mysqli_error($zalongwa));
  
  #delete in examresult
  $deleteSQL2 = "DELETE FROM examresult WHERE  (RegNo='$regno') AND (CourseCode = '$key')";                    
  mysqli_select_db($zalongwa,$database_zalongwa);
  $Result1 = mysqli_query($zalongwa,$deleteSQL2) or die(mysqli_error($zalongwa));

  echo $key.' --> Deleted Successfully !';
  echo '<meta http-equiv = "refresh" content ="3; url = admissionExamResult.php">';
}
?>