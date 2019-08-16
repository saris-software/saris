<?php require_once('../Connections/zalongwa.php'); 
require_once('../Connections/sessioncontrol.php');
# include the header
include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Timetable';
	$szTitle = 'Timetable';
	include("lecturerheader.php");
?>

Use Menu in left panel to Create or View timetable