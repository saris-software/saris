<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 

		<title>administration</title>
		<meta name="description" content="A sidebar menu as seen on the Google Nexus 7 website" />
		<meta name="keywords" content="google nexus 7 menu, css transitions, sidebar, side menu, slide out menu" />
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="js/modernizr.custom.js"></script>
	<!--	<script src="HorizontalSlideOutMenu/HorizontalSlideOutMenu/js/modernizr.custom.js"></script>
-->

	</head>
	<body>
		
		<!-- <div class="container">*/ -->
			<ul id="gn-menu" class="gn-menu-main">
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
					<nav class="gn-menu-wrapper">
						<div class="gn-scroller">
							<ul class="gn-menu">
								<li>
									<a href="lecturerUserManual.php" name="menu1" class="gn-icon gn-icon-download">Help</a>
									</li>
                               <li><a href="admissionpolicy.php" name="menu4" class="gn-icon gn-icon-cog">Policy Setup</a></li>
								<li><a href="lecturerAdministration.php" name="menu5" class="gn-icon gn-icon-help">Administration</a></li>
								<li><a href="./examination.php" name="menu4" class="gn-icon gn-icon-cog">Examination</a></li>
								<li><a href="./timetable.php" name="menu5" class="gn-icon gn-icon-help">Timetable</a></li>
								<li>
							<a href="./e_learning.php" name="menu6" class="gn-icon gn-icon-archive">E-Lerning</a></li>
                        	<li><a href="./communication.php" name="menu4" class="gn-icon gn-icon-cog">Communication</a></li>
								<li><a href="./security.php" name="menu5" class="gn-icon gn-icon-help">Security</a></li>
								<li>
							<a href="./signout.php" name="menu6" class="gn-icon gn-icon-archive">Sign out</a>
					</li>
							</ul>
						</div><!-- /gn-scroller -->
					</nav>
				</li >
			
			
				<div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
		<li><a href="lecturerStudentRegister.php" class='li-modal'>Student Register</a>
    </li>
	<li><a href="lecturerSemesterUpdate.php" class='li-modal'>Update Semister</a>
    </li>
	<li><a href="lecturerStudentRemarker.php" class='li-modal'>Student Remark</a>
    </li>
	<li><a href="lecturerexamnumberpublish.php" class='li-modal'>Exam Number</a>
    </li>
	<li><a href="lecturerExammaker.php" class='li-modal'>Exam Maker</a>
    </li>
	<li><a href="lecturerexamofficerpublishresults.php" class='li-modal'>Publish Exam</a>
    </li>
	<li><a href="lecturerexamofficerchangesemester.php" class='li-modal'>Change Semister</a>
    </li>
	<li><a href="lecturerCourseAllocation.php" class='li-modal'>Course Allocation</a>
    </li>
	<li><a href="admissionNominalRoll.php" class='li-modal'>Class list</a>
    </li>
		            	
					  </ul>
					  </div>
				
					   	</div>
				
				</ul>
				</li>
				
			</ul>
		</div><!-- /container -->
		<script src="js/classie.js"></script>
		<script src="js/gnmenu.js"></script>
		<script>
			new gnMenu( document.getElementById( 'gn-menu' ) );
		</script>
		<script src="js/cbpHorizontalSlideOutMenu.min.js"></script>
		<script>
			var menu = new cbpHorizontalSlideOutMenu( document.getElementById( 'cbp-hsmenu-wrapper' ) );
	</script> 
	</body>
</html>
