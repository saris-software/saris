<?php
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# initialise globals
	include('studentMenu.php');
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Registration Form';
	$szTitle = 'Student Registration Form';
	include('studentheader.php');
		
	//payment details inclusion
	include("../includes/pastel.class.php");
	$odbcfile = 'http://172.31.0.94:8090/saris/odbc.php';
	$pastelurl = $odbcfile;
	$pastelobj = new pastel();

	$reg=$RegNo;
	
	#get registration date of birth
	$sqldate = "SELECT * FROM security WHERE RegNo='$RegNo'"; 
	$getd = mysqli_query($zalongwa,$sqldate) or die(mysqli_error($zalongwa));
	$getdate = mysqli_fetch_array($getd)or die(mysqli_error($zalongwa));
	$securityDOB=$getdate['DBirth'];

	#get current Academic Year 
	$qayr = "SELECT AYear FROM academicyear WHERE Status = '1'";
	$aYearCurrent = mysqli_query($zalongwa,$qayr);
	$getcryear=mysqli_fetch_array($aYearCurrent);
	$cryear=$getcryear['AYear'];

	//find if student already exist to update
	$qRegNo1 = "SELECT Id FROM student WHERE RegNo = '$RegNo'";
	$dbRegNo1 = mysqli_query($zalongwa,$qRegNo1);
	$total1 = mysqli_num_rows($dbRegNo1);
	$getID = mysqli_fetch_array($dbRegNo1);
	$id=$getID['Id'];
	$x=$total1;

    #include calendar and other stylesheets
	include('../includes/javascript.inc');
        
        $regno=$RegNo;
	include ('../includes/registrationform.php');
	//include ('edit_form.php');

