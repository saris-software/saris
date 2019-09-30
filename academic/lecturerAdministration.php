<?php 
require_once('../Connections/sessioncontrol.php');
# include the header

include('administration.php');

//include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Administration';
	$szTitle = 'Administration';
	$szSubSection = '';
	//$additionalStyleSheet = './general.css';
//	include("lecturerheader.php");
	
?>
<br>
<!DOCTYPE html>
<html lang="en">
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

Welcome, Please Use the Menus  to Navigate the System

<br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>
<div class="footer">
<?php

	# include the footer
	include("../footer/footer.php");
?>
</div>
