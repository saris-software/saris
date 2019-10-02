<?php require_once('../Connections/zalongwa.php'); 
require_once('../Connections/sessioncontrol.php');
# include the header
// include('lecturerMenu.php');

include('timetable.php');

	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Timetable';
	$szTitle = 'Timetable';
	// include("lecturerheader.php");
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

Use Menu in top panel to Create or View timetable
