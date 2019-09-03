<?php

require_once('../Connections/zalongwa.php');
/*
	This is the header to be included for all files.
	Variables to be set before including this file are as follows:
	
	szSection - the name of the section.
	szSubSection - the name of the subsection.
*/

# this script will use the following globals
	global $szSection, $szSubSection, $szSubSubSection,$intSectionID,$intSubSectionID,$szSubSubSectionTitle,$szSubSectionTitle, $szTitle, $additionalStyleSheet, $arrStructure, $szRootURL, $blnHideNav, $arrVariations;

	//if (!isset($blnHideNav)){$blnHideNav = false;}
	if (isset($_GET['hidenav'])){$blnHideNav=true;}else{$blnHideNav = false;}
	
	// change language if necessary...
	if (isset($_GET['chooselang']) && isset($arrVariations[$_GET['chooselang']])){
		if ($_GET['chooselang'] ==1){
			$_SESSION['arrVariationPreference'] = array (
				1 => 1,
				2 => 2
			);
		}elseif ($_GET['chooselang'] ==2){
			$_SESSION['arrVariationPreference'] = array (
				1 => 2,
				2 => 1
			);
		}
	}
	
	$intDisplayLanguage = $_SESSION['arrVariationPreference'][1];
	
	// Need to figure out what section we are currently in, to be able to display the relevant colours.
	for ( $i=1; $i<= count( $arrStructure ); $i++ ){	
		# is this the current section?
		if ( $arrStructure[$i]['name1'] == $szSection ) $intCurrentSectionID = $i;
	}
	#get organisation name


	$qname = 'SELECT Name, Address FROM organisation';
	$dbname = mysqli_query($zalongwa, $qname);
	$name_row = mysqli_fetch_assoc($dbname);
	$dbname = mysqli_query($zalongwa, $qname);
	$name_row = mysqli_fetch_assoc($dbname);

	
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
    <link href="Academic/card.css?v=1.0" rel="stylesheet" type="text/css" />
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
   color:black;
}
    </style>
    <title>SARIS</title>

    <!--modernaizer here-->
    <script src="modernizr-custom.js">
    </script>
</head>
<body>
<div class="images" id="">
       <img width="100%" height="250px" src="mnma.jpeg "/>
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
        <a class="navbar-brand nav-link" href="lecturerindex.php"><img width="50" src="Academic/log.png"/>  SARIS SYSTEM</a>

<br><p style="font-size: 22px;"> Welcome to the Academic Module.</p><br><br>

    </div>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex flex-row flex-nowrap ml-auto mr-sm-5 mr-md-5 mr-lg-0">
            <li class="nav-item ">
                <a class="navbar-brand nav-link" href="#"><img class="rounded-circle" width="40"
                                                               src="./images/profile.png"/></a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand nav-link" href="../signout.php"><!--<img class="rounded-circle" width="40"
                                                                             src="./img/user.svg"/>--> Logout</a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand nav-link" href="lecturerUserManual.php"> Help</a>
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
                <a href="lecturerUserManual.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./images/help.jpeg"></a>
                <div class="card-block">
                    <a href="lecturerUserManual.php"><h5 class="card-title">Help</h5></a>
                </div>
            </div>
        </div> <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="admissionpolicy.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./images/setup.jepg"></a>
                <div class="card-block">
                    <a href="admissionpolicy.php"><h5 class="card-title">Policy Setup</h5></a>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="lecturerAdministration.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./images/administration.jpeg"></a>
                <div class="card-block">
                    <a href="lecturerAdministration.php"><h5 class="card-title">Administration</h5></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-md-4">
            <div class="card" align="center">

                <a href="Academic/academic_submenu/examination.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./images/exam.jpeg"></a>

                <div class="card-block">
                    <a href="lecturerResults.php"><h5 class="card-title">Examination</h5></a>

                </div>
            </div>
        </div>
<div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="Academic/academic_submenu/timetable.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./images/timetable.jpeg"></a>

                <div class="card-block">
                    <a href="lecturerTimetable.php"><h5 class="card-title">Timetable</h5></a>

                </div>
            </div>
        </div>


        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="Academic/academic_submenu/e_learning.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./images/e_learning.jpeg"></a>

                <div class="card-block">
                    <a href="lecturerElearning.php"><h5 class="card-title">E-Learning</h5></a>

                </div>
            </div>
        </div>


    </div>
          <div class="row">
        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="lecturercomm.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./images/comm.jpeg"></a>

                <div class="card-block">
                    <a href="lecturercomm.php"><h5 class="card-title">Communication</h5></a>

                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">

                <a href="lecturerSecurity.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./images/security1.png"></a>

                <div class="card-block">

                    <a href="lecturerSecurity.php"><h5 class="card-title">Security</h5></a>
                </div>
            </div>
        </div>
    <div class="col-sm-4 col-md-4 ">
            <div class="card" align="center">
                <a href="admissionprofile.php"> <img class="card-img-top img-fluid "
                                 style="width: 112px; height: inherit; padding-top: 15px; "
                                 src="./images/profile.png"></a>
                <div class="card-block">
                    <a href="admissionprofile.php"><h5 class="card-title">Profile</h5></a>
                </div>
            </div>
       
    </div>

</div>
</div><!-- end .container -->
<br><br><br>
<!--footer-->
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

