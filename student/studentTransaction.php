<?php 
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php'); 
	# include the header
	include('studentMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Financial Records';
	$szTitle = 'Financial Transactions';
	$szSubSection = 'Transactions';
	include("studentheader.php");
	include("../includes/pastel.class.php");
	
	$regno = trim(strtoupper($RegNo));
	$odbcfile = 'http://172.31.0.94:8090/saris/odbc.php';
	$pastelurl = $odbcfile;
	$view_type = 2;
	$pastelobj = new pastel();
	$result = $pastelobj->currentTransaction($pastelurl, $regno, $view_type);
       // echo $result;
	include('../footer/footer.php');

