<?php 
require_once('../Connections/sessioncontrol.php');
# include the header
//include('lecturerMenu.php');
	include("communication.php");

	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Communication';
	$szTitle = 'Communication';
	$szSubSection = 'User Communication';
	//$additionalStyleSheet = './general.css';
	//include("lecturerheader.php");
	
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
<h2>Information:</h2>
<p> Please Use Your "Suggestion Box" to Send any Comments on the Design and Missing Information to the System Engineer. </p>

<p> Use "Check Message" to get Messages from Other Users.</p>
<?php

	# include the footer
	include("../footer/footer.php");
?>
