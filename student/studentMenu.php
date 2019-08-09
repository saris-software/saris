<?php
   if ($module <> 3) {
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
		
	//Help
	$arrStructure[$i] = array( 'name1' => 'Help', 'name2' => 'Usalama', 'url' => 'studentUserManual.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'User Manual', 'name2' => 'Usaidizi', 'url' => 'studentUserManual.php', 'width' => '', 'height' => '');
	$j++;
	$i++;
	
	// Profile
	$arrStructure[$i] = array( 'name1' => 'Profile', 'name2' => 'Profile', 'url' => 'admissionprofile.php', 'width' => '20', 'height' => '50');
	$i++;
	
	$arrStructure[$i] = array( 'name1' => 'Admission Process', 'name2' => 'Usaili Chuoni', 'url' => 'admissionRegistration.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Registration Form', 'name2' => 'Formu ya Kuandikishwa', 'url' => 'admissionRegistrationForm.php?id=id', 'width' => '', 'height' => '');
	$j++;
	$i++;
	
		// Academic records
	$arrStructure[$i] = array( 'name1' => 'Academic Records', 'name2' => 'Taaluma', 'url' => 'studentAcademic.php', 'image' => '',  'width' => '2', 'height' => '3');
	$arrStructure[$i]['subsections'] = array(); $j=1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Course Roster', 'name2' => 'Kitivo', 'url' => 'studentCourselist.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Exam Registered', 'name2' => 'Kitivo', 'url' => 'studentAcademic.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Exam Result', 'name2' => 'Kitivo', 'url' => 'studentexamresult.php', 'width' => '', 'height' => '');
	$j++;
	$i++;

	// Ficancial records
	$arrStructure[$i] = array( 'name1' => 'Financial Records', 'name2' => 'Malipo', 'url' => 'studentFinacial.php', 'image' => '',  'width' => '', 'height' => '');
	
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	/*$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Tuition Fee', 'name2' => 'Orodha ya Wanafunzi', 'url' => 'studentroomrent.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Caution Fee', 'name2' => 'Statistics', 'url' => 'studentcautionfee.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Penalty Charge', 'name2' => 'Formu ya Kuandikishwa', 'url' => 'studentpenaltcharges.php', 'width' => '', 'height' => '');
	$j++;*/
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Tuition Fee', 'name2' => 'Tafuta Mwanafunzi', 'url' => 'studentTuitionfee.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Transactions', 'name2' => 'Tafuta Mwanafunzi', 'url' => 'studentTransaction.php', 'width' => '', 'height' => '');
	$j++;
	$i++;
	
	// E-Learning
	$arrStructure[$i] = array( 'name1' => 'E-Learning', 'name2' => 'Mawasiliano', 'url' => 'studentElearning.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Lecture Note', 'name2' => 'Shahada', 'url' => 'studentcourseregisterednotes.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'e-Library', 'name2' => 'Shahada', 'url' => 'studentelibrary.php', 'width' => '', 'height' => '');
	$j++;
	$i++;
    
	// E-voting
	$arrStructure[$i] = array( 'name1' => 'E-Voting', 'name2' => 'Mawasiliano', 'url' => 'admissionVoting.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Election Voting', 'name2' => 'Shahada', 'url' => 'admissionVoting.php', 'width' => '', 'height' => '');
	$j++;
	$i++;
	
	// Communication
	$arrStructure[$i] = array( 'name1' => 'Communication', 'name2' => 'Mawasiliano', 'url' => 'admissionComm.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Suggestion Box', 'name2' => 'Sanduku la Maoni', 'url' => 'admissionSuggestionBox.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Check Message', 'name2' => 'Pata Habari', 'url' => 'admissionCheckMessage.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'News & Events', 'name2' => 'Pata Habari', 'url' => 'studentNews.php', 'width' => '', 'height' => '');
	$j++;
	$i++;
	
	//Security
	$arrStructure[$i] = array( 'name1' => 'Security', 'name2' => 'Usalama', 'url' => 'admissionSecurity.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Change Password', 'name2' => 'Badili Password', 'url' => 'admissionChangepassword.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Login History', 'name2' => 'Historia ya Kulogin', 'url' => 'admissionLoginHistory.php', 'width' => '', 'height' => '');
	$j++;
	$i++;
	$arrStructure[$i] = array( 'name1' => 'Sign Out', 'name2' => 'Funga Program', 'url' => '../signout.php', 'image' => '',  'width' => '', 'height' => '');
    $i++;
?>
