<?php 
	require_once('../Connections/sessioncontrol.php');
	# include the header
	include('studentMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Admission Process';
	$szTitle = 'Student Registration';
	$szSubSection = '';
	include("studentheader.php");
	
?>
<p><br><br><em>Please Fill the <font color="#C11B17">Regisration Form</font> provided 
<br> Make sure you provide the <font color="#C11B17">CORRECT INFORMATION</font></em></p>
<br><br>
<?php

	# include the footer
	include("../footer/footer.php");
?>
