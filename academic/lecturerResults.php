<?php 
require_once('../Connections/sessioncontrol.php');
# include the header
include('examination.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Examination';
	$szTitle = 'Examination';
	$szSubSection = '';
	//$additionalStyleSheet = './general.css';
	//include("lecturerheader.php");
	
?>

<br> <br><br>
Welcome, Please Use the Menus  to Navigate the System <br><br>
<?php

	# include the footer
	include("../footer/footer.php");
?>
