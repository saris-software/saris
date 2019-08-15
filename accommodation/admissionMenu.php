<?php
 if ($module <> 2) {
		session_start(); 
		session_cache_limiter('nocache');
		$_SESSION = array();
		session_unset(); 
		session_destroy(); 
		echo '<meta http-equiv = "refresh" content ="0;	url = ../index.php">';		
	}

	# start the session
	session_start();
	
	# include the global settings
	
require_once('../Connections/zalongwa.php'); 
	global $blnPrivateArea,$szHeaderPath,$szFooterPath,$szRootPath;
	$blnPrivateArea = false;
	$szHeaderPath = 'header.php';
	$szFooterPath = 'footer.php';

	# define Top level Navigation Array if not defined already
	
	$arrStructure = array();$i=1;
		
	// Profile
	$arrStructure[$i] = array( 'name1' => 'Profile', 'name2' => 'Profile', 'url' => 'admissionprofile.php', 'width' => '20', 'height' => '50');
	$i++;
	
	// Policy Setup
	#check if user is a manager
	if ($privilege==2){
			$arrStructure[$i] = array( 'name1' => 'Policy Setup', 'name2' => 'Plicy Setup', 'url' => 'admissionpolicy.php', 'image' => '',  'width' => '2', 'height' => '3');
			$arrStructure[$i]['subsections'] = array(); $j=1;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Hostel Register', 'name2' => 'Shahada', 'url' => 'hostelRegister.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Block Register', 'name2' => 'Shahada', 'url' => 'blockRegister.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Room Register', 'name2' => 'Chuo', 'url' => 'roomRegister.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Hostel Report', 'name2' => 'Shahada', 'url' => 'hostelReport.php', 'width' => '', 'height' => '');
			$j++;
			$i++;
	}
	// Accommodation reports
	#check if user is a manager
	if ($privilege==2){
			$arrStructure[$i] = array( 'name1' => 'Accommodation', 'name2' => 'Plicy Setup', 'url' => 'housingroomallocation.php', 'image' => '',  'width' => '2', 'height' => '3');
			$arrStructure[$i]['subsections'] = array(); $j=1;
			//$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Application Form', 'name2' => 'Form ya Maombi', 'url' => 'roomApplicationform.php', 'width' => '', 'height' => '');
			//$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Application Report', 'name2' => 'Ripoti ya Maombi', 'url' => 'housingroomapplication.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Allocation Form', 'name2' => 'Kitivo', 'url' => 'housingroomAllocationform.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Allocation Report', 'name2' => 'Kitivo', 'url' => 'housingroomallocation.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Vacant Rooms', 'name2' => 'Shahada', 'url' => 'housingvacantroom.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Current Allocation', 'name2' => 'Shahada', 'url' => 'housingCurrentallocation.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Checkout Room', 'name2' => 'Shahada', 'url' => 'housingCheckout.php', 'width' => '', 'height' => '');
			$j++;
			$i++;
	}
		// Financial reports
		/*
	#check if user is a manager
	if ($privilege==2){
			$arrStructure[$i] = array( 'name1' => 'Financial Reports', 'name2' => 'Plicy Setup', 'url' => 'housingcautionfeepaidreport.php', 'image' => '',  'width' => '2', 'height' => '3');
			$arrStructure[$i]['subsections'] = array(); $j=1;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Payment Reports', 'name2' => 'Chuo', 'url' => 'housingcautionfeepaidreport.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Rental Charges', 'name2' => 'Chuo', 'url' => 'housingrentalchargereport.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Caution Fees', 'name2' => 'Kitivo', 'url' => 'housingcautionfeeregister.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Penalty Charges', 'name2' => 'Kitivo', 'url' => 'housingpenaltychargereport.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Refund Candidate', 'name2' => 'Shahada', 'url' => 'housingpaymentrefund.php', 'width' => '', 'height' => '');
			$j++;
			$i++;
	}
	*/
	// Communication
	$arrStructure[$i] = array( 'name1' => 'Communication', 'name2' => 'Mawasiliano', 'url' => 'admissionCheckMessage.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Check Message', 'name2' => 'Pata Habari', 'url' => 'admissionCheckMessage.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'News & Events', 'name2' => 'Pata Habari', 'url' => 'studentNews.php', 'width' => '', 'height' => '');
	$j++;
	$i++;
	//Security
	$arrStructure[$i] = array( 'name1' => 'Change Password', 'name2' => 'Usalama', 'url' => 'admissionSecurity.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Change Password', 'name2' => 'Badili Password', 'url' => 'admissionChangepassword.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Login History', 'name2' => 'Historia ya Kulogin', 'url' => 'admissionLoginHistory.php', 'width' => '', 'height' => '');
	$j++;
	$i++;
	$arrStructure[$i] = array( 'name1' => 'Sign Out', 'name2' => 'Funga Program', 'url' => '../signout.php', 'image' => '',  'width' => '', 'height' => '');
    $i++;
?>
