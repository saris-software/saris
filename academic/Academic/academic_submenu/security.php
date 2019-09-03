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

		<title>policy</title>
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
									<a href="./help.php" name="menu1" class="gn-icon gn-icon-download">Help</a>
									</li>
                               <li><a href="./policy.php" name="menu4" class="gn-icon gn-icon-cog">Policy Setup</a></li>
								<li><a href="./administration.php" name="menu5" class="gn-icon gn-icon-help">Administration</a></li>
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
     
					        <li><a data-toggle="pill" href="#menu4">Change Password</a></li>
                        <li><a data-toggle="pill" href="#menu1">Login History</a></li>
				</ul>
				</div>		
					  
					  
					  <div class="tab-content">
						<div id="menu4" class="tab-pane fade">
						  <h3></h3>
						  <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
						</div>
						<div id="menu1" class="tab-pane fade">
						  <h3>Menu 3</h3>
						  <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
						</div>


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
