<?php
	session_start();
	session_cache_limiter('nocache');       
	@$loginerror  = $_SESSION['loginerror'];
	$_SESSION['loginerror'] = "";

 require_once('Connections/zalongwa.php'); 
	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
$dborg = mysqli_query($zalongwa, $qorg);
$row_org = mysqli_fetch_assoc($dborg);
	$org = $row_org['Name'];
	$post = $row_org['Address'];
	$phone = $row_org['tel'];
	$fax = $row_org['fax'];
	$email = $row_org['email'];
	$website = $row_org['website'];
	$city = $row_org['city'];
	
header("Cache-control: private"); // IE 6 Fix. 
if (isset($accesscheck)) {
  $GLOBALS['PrevUrl'] = $accesscheck;
    session_is_register('PrevUrl');
}
#update userpassword
if (isset($_POST["save"]) && ($_POST["save"] == "Save Password")) {
$txtusername = addslashes($_POST['username']);
$newpass = addslashes($_POST['txtnewPWD']);
$_SESSION['username'] = $txtusername;
  // Generate jlungo hash for new password
 $hashnew = "{jlungo-hash}" . base64_encode(pack("H*", sha1($newpass)));
if(strlen($newpass)<5){
	$_SESSION['loginerror'] = 'Password too short, Password must be at least 5 characters! '; 
	$_POST['ok'] ="OK";
	$_SESSION['thisuser'] = $txtusername;
}
  $updateSQL = "UPDATE security SET password='$hashnew' WHERE UserName='$txtusername'";
    mysqli_select_db($database_zalongwa, $zalongwa);
    $Result1 = mysqli_query($zalongwa, $updateSQL) or die(mysqli_error($updateSQL));

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  if($_POST['ok'] <>"OK"){
  echo '<meta http-equiv = "refresh" content ="0; 
						url ='. $updateGoTo.'">';
					exit;
	}
}

#end update user password
#change password
if (isset($_POST['ok']) && $_POST['ok'] !="") {
$colname_changepassword = "1";
$thisuser = $_SESSION['thisuser'];
$query_changepassword = sprintf("SELECT UserName, FullName, RegNo FROM security WHERE UserName = '$thisuser'", $colname_changepassword);
$changepassword = mysql_query($query_changepassword, $zalongwa);
$row_changepassword = mysql_fetch_assoc($changepassword);
$totalRows_changepassword = mysql_num_rows($changepassword);

$browser  =  $_SERVER["HTTP_USER_AGENT"];   
$ip  =  $_SERVER["REMOTE_ADDR"];   
$today = date("F j, Y, g:i a");
$msg = $thisuser.' - Recovered  a Password';
$sql="INSERT INTO stats(ip,browser,received,page) VALUES('$ip','$browser',now(),'$msg')";   
$result = mysql_query($sql) or die("Siwezi kuingiza data.<br>");
}
#end of change passsword

if (isset($_POST['Submit']) && $_POST['Submit'] !="") {
	#get post variables
	$rawkey = addslashes(trim($_POST['txtRegNo']));
	$userregno = ereg_replace("[[:space:]]+", " ",$rawkey);
	$email = addslashes($_POST['txtemail']);
	
	//ensure it retrieve records for students only, lecturers and housing officers cannot retrieve their passwords
$check_reg ="SELECT * FROM security WHERE RegNo='$userregno'";
$result_regno = mysqli_query($zalongwa, $check_reg);
$check_num = mysqli_num_rows($result_regno);
if($check_num == 1){
// check bday
 $check_reg ="SELECT * FROM student WHERE RegNo='$userregno' AND (email='$email')";
    $result_regno = mysqli_query($zalongwa, $check_reg);
    $check_num = mysqli_num_rows($result_regno);

if($check_num == 1){
	if($bdate){
	$sql=sprintf("SELECT student.email,
					  security.UserName,
					  security.password,
					  security.RegNo,
					  security.Module,
					  security.Position
                FROM security,student
                WHERE security.RegNo = '$userregno' AND (student.email = '$email' OR student.email = '$email')",
 		get_magic_quotes_gpc() ? $userregno : addslashes($userregno), get_magic_quotes_gpc() ? $email : addslashes($email));

        $result = @mysqli_query($sql, $zalongwa);
        $loginFoundUser = mysqli_num_rows($result);
 		
						if ($loginFoundUser) {
							$loginName		= mysql_result($result,0,'UserName');
							$password 		= mysql_result($result,0,'password');
							$module 		= mysql_result($result,0,'Module');
							if ($module==3){
							$_SESSION['loginerror'] = "no";
							}else{
							$_SESSION['loginerror'] = "Only Students can Retrieve Password, <br> Please Contact Your Local ZALONGWA HelpDesk Officers";
							}
													
						}else{
								$_SESSION['loginerror'] =  'Please, You Must Enter Your Correct Registration Number!<br> Year of Birth Date Should Be in 4 digits e.g. 1982'; 
					}
		}else{
								$_SESSION['loginerror'] =  'Please, You Must Enter Your Correct Registration Number!<br> Year of Birth Date Should Be in 4 digits e.g. 1982'; 
	}
        
}else{
    $_SESSION['loginerror'] =  'Invalid Date of Birth compare with the date registered in the system. Please Contact with your admission office';     
}
}else{
$_SESSION['loginerror'] =  'Invalid Registration Number';     
}
        
        
        
}


//new algorithim

if(isset($_POST) & !empty($_POST)){
	$username = mysqli_real_escape_string($connection, $_POST['usern']);
	$sql = "SELECT * FROM `` WHERE (username = '$regno') && (email='$email')";
	$res = mysqli_query($zalongwa, $sql);
	$count = mysqli_num_rows($res);
	if($count == 1){
		echo "Send email to account with password";
	}else{
		echo "User name does not exist in database";
	}
}
$r = mysqli_fetch_assoc($res);
$password = $r['password'];
$to = $r['email'];
$subject = "Your Recovered Password";

$message = "Please use this password to login " . $password;
$headers = "From : zalongwa@gmail.com";
if(mail($to, $subject, $message, $headers)){
	echo "Your Password has been sent to your email id";
}else{
	#echo "Failed to Recover your password, try again";
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
	<title>foget password</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="ResetPassword/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ResetPassword/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ResetPassword/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ResetPassword/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ResetPassword/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="ResetPassword/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ResetPassword/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ResetPassword/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="ResetPassword/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="ResetPassword/css/util.css">
	<link rel="stylesheet" type="text/css" href="ResetPassword/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-26">
					Recover Password
					
					</span>
					<span class="login100-form-title p-b-48 height-50 width-50">
						<img src="ResetPassword/images/log.png" class="img-rounded" alt="">

					</span>

					<div class="wrap-input100 validate-input" data-validate="Enter Reg No">
						User name:<input class="input100" type="username" name="txtRegNo">
						<span class="focus-input100" data-placeholder=""></span>
					</div>


					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						Email:<input class="input100" type="text" name="txtemail">
						<span class="focus-input100" data-placeholder=""></span>
					</div>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="Submit">
							 Submit
							</button>
						</div>
					</div>

					
				</form>
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

</body>
</html>
