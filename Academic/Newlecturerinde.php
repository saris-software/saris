<?php
 #block un privileged users
 if ($module <> 1) {
		session_start(); 
		session_cache_limiter('nocache');
		$_SESSION = array();
		session_unset(); 
		session_destroy(); 
		echo '<meta http-equiv = "refresh" content ="0;	url = ../index.php">';		
	}
	# start the session
	//session_start();
	
	# include the global settings
	
	require_once('../Connections/zalongwa.php'); 
	global $blnPrivateArea,$szHeaderPath,$szFooterPath,$szRootPath;
	$blnPrivateArea = false;
	$szHeaderPath = 'header.php';
	$szFooterPath = 'footer.php';


	# define Top level Navigation Array if not defined already
	
	$arrStructure = array();$i=1;
		
		//Help
	$arrStructure[$i] = array( 'name1' => 'Help', 'name2' => 'Usalama', 'url' => 'lecturerUserManual.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'User Manual', 'name2' => 'Usaidizi', 'url' => 'lecturerUserManual.php', 'width' => '', 'height' => '');
	$j++;
	$i++;
	// Profile
	$arrStructure[$i] = array( 'name1' => 'Profile', 'name2' => 'Profile', 'url' => 'admissionprofile.php', 'width' => '20', 'height' => '50');
	$i++;
	
	// Database Lookup Tables Setup
	#check if user is a manager
	if ($privilege==2){
			$arrStructure[$i] = array( 'name1' => 'Policy Setup', 'name2' => 'Plicy Setup', 'url' => 'admissionpolicy.php', 'image' => '',  'width' => '2', 'height' => '3');
			$arrStructure[$i]['subsections'] = array(); $j=1;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Institution', 'name2' => 'Chuo', 'url' => 'admissionInst.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Faculty', 'name2' => 'Kitivo', 'url' => 'admissionFaculty.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Department', 'name2' => 'Kitivo', 'url' => 'admissionDepartment.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Programme', 'name2' => 'Shahada', 'url' => 'admissionProgramme.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Module', 'name2' => 'Somo', 'url' => 'admissionSubject.php', 'width' => '', 'height' => '');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Combination', 'name2' => 'Somo', 'url' => 'admissionCombination.php', 'width' => '', 'height' => '');
			$j++;
			$i++;
	}
	// Administration Menus
	$arrStructure[$i] = array( 'name1' => 'Administration', 'name2' => 'Utawala', 'url' => 'lecturerAdministration.php', 'image' => '',  'width' => '2', 'height' => '3');
	
	$arrStructure[$i]['subsections'] = array(); $j=1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Student Register', 'name2' => 'Fomu ya Maombi', 'url' => 'lecturerStudentRegister.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Update Semester', 'name2' => 'Fomu ya Maombi', 'url' => 'lecturerSemesterUpdate.php', 'width' => '', 'height' => '');
	$j++;
	if ($privilege==2){
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Student Remarks', 'name2' => 'Fomu ya Maombi', 'url' => 'lecturerStudentRemarker.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Exam Numbers', 'name2' => 'Namba ya Mtihani', 'url' => 'lecturerexamnumberpublish.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Exam Marker', 'name2' => 'Orodha ya Maombi', 'url' => 'lecturerExammaker.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Publish Exam', 'name2' => 'Orodha ya Maombi', 'url' => 'lecturerexamofficerpublishresults.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Change Semester', 'name2' => 'Orodha ya Maombi', 'url' => 'lecturerexamofficerchangesemester.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Course Allocation', 'name2' => 'Orodha ya Maombi', 'url' => 'lecturerCourseAllocation.php', 'width' => '', 'height' => '');
		$j++;	
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Class Lists', 'name2' => 'Orodha ya Wanafunzi', 'url' => 'admissionNominalRoll.php', 'width' => '', 'height' => '');
		$j++;
	}

	//$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Class Size', 'name2' => 'Fomu ya Maombi', 'url' => 'lecturerClasssize.php', 'width' => '', 'height' => '');
	//$j++;

	$i++;
	
	// Examination Menu
	$arrStructure[$i] = array( 'name1' => 'Examination', 'name2' => 'Usaili Chuoni', 'url' => 'lecturerResults.php', 'image' => '',  'width' => '', 'height' => '');
	
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Search', 'name2' => 'Tafuta Mwanafunzi', 'url' => 'admissionExamResult.php', 'width' => '', 'height' => '');
	$j++;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Grade Book', 'name2' => 'Kitabu cha matokeo', 'url' => 'lecturerGradebook.php', 'width' => '', 'height' => '');
	$j++;
	/*
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Excel Import', 'name2' => 'Kitabu cha matokeo', 'url' => 'zalongwaimport.php', 'width' => '', 'height' => '');
	$j++;
	*/
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Course Result', 'name2' => 'Ada ya Chuo', 'url' => 'lecturerCourseresult.php', 'width' => '', 'height' => '');
	$j++;
	
	if ($privilege==2){ 
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Semester Results', 'name2' => 'GPA ya Idara', 'url' => 'lecturerSemesterresultsheet.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Annual Results', 'name2' => 'GPA ya Idara', 'url' => 'lecturerAnnualresultsheet.php', 'width' => '', 'height' => '');
		$j++;
		/*
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Board Reports', 'name2' => 'GPA ya Idara', 'url' => 'lecturerBoardsheet.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Attendance List', 'name2' => 'GPA ya Idara', 'url' => 'lecturerAttendancelist.php', 'width' => '', 'height' => '');
		$j++;		
		
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Boardsheet', 'name2' => 'GPA ya Idara', 'url' => 'lecturerResultsheet.php', 'width' => '', 'height' => '');
		$j++;
		
	
	if ($privilege==2){ 
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'NTA Annual Rpt', 'name2' => 'GPA ya Idara', 'url' => 'lecturerAnnualreport.php', 'width' => '', 'height' => '');
		$j++;
		
		
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => ' Trad. Annual Rpt', 'name2' => 'GPA ya Idara', 'url' => 'lecturerTraditionreport.php', 'width' => '', 'height' => '');
		$j++;

		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'NTA Semester Rpt', 'name2' => 'GPA ya Idara', 'url' => 'lecturerSemesterreport.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Trad. Semester Rpt', 'name2' => 'GPA ya Idara', 'url' => 'lecturerTradsemester.php', 'width' => '', 'height' => '');
		$j++;
		*/
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Cand. Transcript', 'name2' => 'Ada ya Chuo', 'url' => 'lecturerTranscript.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Cand. Statement', 'name2' => 'Ada ya Chuo', 'url' => 'lecturerProgress.php', 'width' => '', 'height' => '');
		$j++;
		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Cumulative Points', 'name2' => 'Jumla ya Points', 'url' => 'lecturerCumulativepoint.php', 'width' => '', 'height' => '');
		$j++;
	    $arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Elective Courses', 'name2' => 'Optional Courses', 'url' => 'lecturerCleangpa.php', 'width' => '', 'height' => '');
	    $j++;
	    $arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Graduates Report', 'name2' => 'Optional Courses', 'url' => 'lecturerGraduates.php', 'width' => '', 'height' => '');
	    $j++;
	}
	$i++;
	
		/**********TIMETABLE MENUs************/
	$arrStructure[$i] = array( 'name1' => 'Timetable', 'name2' => 'Utawala', 'url' => 'lecturerTimetable.php', 'image' => '',  'width' => '2', 'height' => '3');
	
	$arrStructure[$i]['subsections'] = array(); $j=1;
$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Get TimeTable', 'name2' => 'Fomu ya Maombi', 'url' => 'gettimetable.php', 'width' => '', 'height' => '');
	$j++;
        if ($privilege==2){
$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Find Allocated', 'name2' => 'Orodha ya Maombi', 'url' => 'lecturerSearchtimetable.php', 'width' => '', 'height' => '');
		$j++;
	

		$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Create Timetable', 'name2' => 'Orodha ya Maombi', 'url' => 'createtimetable.php', 'width' => '', 'height' => '');
		$j++;	

	
	
$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Venue Utilization', 'name2' => 'Orodha ya Maombi', 'url' => 'roomutilization.php', 'width' => '', 'height' => '');
	$j++;
	}
	$i++;
	
	
	// E-Learning
	$arrStructure[$i] = array( 'name1' => 'E-Learning', 'name2' => 'Mawasiliano', 'url' => 'lecturerElearning.php', 'image' => '',  'width' => '', 'height' => '');
	$arrStructure[$i]['subsections'] = array(); $j = 1;
	$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Lecture Note', 'name2' => 'Shahada', 'url' => 'lecturercourseregisterednotes.php', 'width' => '', 'height' => '');
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

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="./card.css?v=1.0" rel="stylesheet" type="text/css" />
    <style>


        .row {
            margin-top: 20px;
        }
        .card {
            border-top: 7px solid #263238;
            padding-top: 5%;
        }
        .card:focus, .card:hover {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 2px 5px 0 rgba(0, 0, 0, 0.20);
            /*box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.20);*/
        }
        .card-inverse .card-img-overlay {
            background-color: rgba(51, 51, 51, 0.85);
            border-color: rgba(51, 51, 51, 0.85);
        }
     .images{
height:150px;


}
h1{
  font-family: "Times New Roman", Times, serif;
   color:white;
   background-color:#b88cef;
}
    </style>
    <title>SARIS</title>

    <!--modernaizer here-->
    <script src="modernizr-custom.js">
    </script>
</head>
<body>
<div class="images" id="">
       <img width="100%" height="200px" src="./mnma.jpeg "/>
    </div>
<div class="header" id="">
<h1 style="font-size:40px; text-align:center; ">THE MWALIMU NYERERE MEMORIAL ACADEMY</h1>
    </div>
<!-- navbar -->

<nav class="navbar  navbar-default navbar-toggleable-md navbar-light bg-faded  sticky-top">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon "></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <a class="navbar-brand nav-link" href="studentindex.php"><img width="70" src="./logo.png "/>  SARIS SYSTEM</a>
    </div>



    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex flex-row flex-nowrap ml-auto mr-sm-5 mr-md-5 mr-lg-0">
            <li class="nav-item ">
                <a class="navbar-brand nav-link" href="#"><img class="rounded-circle" width="40"
                                                               src="./img/user.svg"/></a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand nav-link" href="../signout.php"><!--<img class="rounded-circle" width="40"
                                                                             src="./img/user.svg"/>--> Logout</a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand nav-link" href="studentUserManual.php"> Help</a>
            </li>
        </ul>

    </div>


</nav>
<nav class="breadcrumb">
    <a class="breadcrumb-item" href="studentindex.php">Home</a>
    <a class="breadcrumb-item" href="javascript:history.back();">Back</a>
    <span class="breadcrumb-item active">Home</span>
</nav>

<div class="container text-muted">
    <!-- cards -->
    <div class="row">

        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="admissionRegistrationForm.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/admission.svg"></a>
                <div class="card-block">
                    <a href="academic_submenu/help.php"><h5 class="card-title">Help</h5></a>
                </div>
            </div>
        </div> <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="academic_submenu/security.php.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/accomodation.svg"></a>
                <div class="card-block">
                    <a href="academic_submenu/policy.php"><h5 class="card-title">Policy Setup</h5></a>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="gettimetable.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/timetable.svg"></a>
                <div class="card-block">
                    <a href="academic_submenu/administration.php"><h5 class="card-title">Administration</h5></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-md-4">
            <div class="card" align="center">

                <a href="academicRecord.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/accademicrecord.svg"></a>

                <div class="card-block">
                    <a href="academic_submenu/examination.php"><h5 class="card-title">Examination</h5></a>

                </div>
            </div>
        </div>
<div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="studentcourseregisterednotes.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/elearning.svg"></a>

                <div class="card-block">
                    <a href="academic_submenu/timetable.php"><h5 class="card-title">Timetable</h5></a>

                </div>
            </div>
        </div>


        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="studentcourseregisterednotes.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/elearning.svg"></a>

                <div class="card-block">
                    <a href="academic_submenu/e_learning.php"><h5 class="card-title">E-Learning</h5></a>

                </div>
            </div>
        </div>


    </div>
          <div class="row">
        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="admissionComm.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./img/communication.svg"></a>

                <div class="card-block">
                    <a href="academic_submenu/communication.php"><h5 class="card-title">Communication</h5></a>

                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="admissionSecurity.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./logo.png"></a>

                <div class="card-block">
                    <a href="academic_submenu/security.php"><h5 class="card-title">Security</h5></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- end .container -->
<br><br><br>
<!--footer-->
		<div class="copyright"><hr noshade style="color:#B9C2C6" size=1>

        <em>ZALONGWA-SARIS v5.0.2 

        </tr>

        </table>

        </body>

        </html>

        </em>
<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
        integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
        crossorigin="anonymous"></script>
<!--adding tooltip-->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<!--Modernaizer here check if not svg supported replace with png-->
<script>
    if (!Modernizr.svg) var i = document.getElementsByTagName("img"), j, y;
    for (j = i.length; j--;) y = i[j].src, y.match(/svg$/) && (i[j].src = y.slice(0, -3) + "png")
</script>
</body>
</html>

