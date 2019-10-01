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

<head>
  <title>policy setup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>


<div class="container">

<br> <br><br>
Welcome, Please Use the Menus  to Navigate the System <br><br>
<?php

	# include the footer
	include("../footer/footer.php");
?>
