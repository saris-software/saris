<!DOCTYPE html>
<html lang="en">
<head>

	<title>SARIS Software</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="New_login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="New_login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="New_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="New_login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="New_login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="New_login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="New_login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="New_login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="New_login/css/util.css">
	<link rel="stylesheet" type="text/css" href="New_login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<FORM action="userlogin.php" method="post" onkeypress="return WebForm_FireDefaultButton(event, 'btnLogin')" id="idpform"
      name="idpform">

	<div class="limiter">
		<div class="container-login100" style="background-image: url('New_login/images/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<div class="login100-form validate-form p-b-30 p-t-0">
					<span class="login100-form-title p-b-0">
						<img src="New_login/images/logo.png" alt="">
					</span>
                      <div align="center" class="style1 p-t-10" style="color:lightgray;" >SARIS LOGIN FORM</div>
                                        
			<div class="wrap-input100 validate-input" data-validate = "Enter username">
	<input id="textusername" class="input100" type="text" placeholder="User name" name=textusername value="<?php  echo $_SESSION['username']?>">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input id="textpassword" class="input100" type="password" name=textpassword placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
<p>
		<?php 
		if (isset($loginerror ) && $loginerror !="")
		{
		?>
            <b class="small">
                <style
                =font-color:"Brown">
								<?php  echo $loginerror?>
								</font>
		  </b>
		<?php 
		session_cache_limiter('nocache');
		$_SESSION = array();
		session_unset(); 
		session_destroy(); 
		}
		?>
</p>


					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

 <div align="center">
<input type="checkbox" style="color:blue;">Remember me</input><br>
<a href="passwordrecover.php" class="style16"style="color:blue;"> Forgot your password ? </a><br>
 
        </div>
				
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
<SCRIPT type=text/javascript>
//<![CDATA[
WebForm_AutoFocus('txtUsername');//]]>
</SCRIPT>

</form>
</body>
</html>
