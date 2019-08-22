<?php 
	require_once('../Connections/sessioncontrol.php');
	require_once('../Connections/zalongwa.php'); 
	# include the header
	include('studentMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Financial Records';
	$szTitle = 'Financial Transactions';
	$szSubSection = 'Tuition Fee';
	include("studentheader.php");
	include("../includes/pastel.class.php");
	
	$regno = trim(strtoupper($RegNo));
	$odbcfile = 'http://172.31.0.94:8090/saris/odbc.php';
	$pastelurl = $odbcfile;
	$view_type = 1;
	$pastelobj = new pastel();
	$result = $pastelobj->currentPayment($pastelurl, $regno, $view_type);

	$split_result = explode('-',$result);
        if(count($split_result)  == 2){
		echo 'Your Balance is <b>'.$split_result[0].'</b><br> Your Invoice is <b>'.$split_result[1].'</b>';
		}
	elseif(count($split_result) > 2){
                echo 'Your Balance is <b> -'.$split_result[1].'</b><br> Your Invoice is <b>'.$split_result[2].'</b>';
                }
        else{
		echo 'Your Balance is: '.$result;
		}

	include('../footer/footer.php');

