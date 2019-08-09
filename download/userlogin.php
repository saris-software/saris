<?php require_once('Connections/zalongwa.php'); ?>
<?php
session_start();
session_cache_limiter('nocache');

if (isset($accesscheck)) {
  $GLOBALS['PrevUrl'] = $accesscheck;
  session_register('PrevUrl');
}

if (isset($_POST['textusername'])) {
  $date = date('Y m d');
  $username = $_POST['textusername'];
  $password = $_POST['textpassword'];
  // Generate jlungo hash
 $hash = "{jlungo-hash}" . base64_encode(pack("H*", sha1($password )));
//$hash = $password;
	$sql=sprintf("SELECT UserName, password, RegNo, Position, Module, PrivilegeID, FullName, Faculty FROM security WHERE UserName='%s' AND password='%s'",
 		get_magic_quotes_gpc() ? $username : addslashes($username), get_magic_quotes_gpc() ? $hash : addslashes($hash)); 
		
		$result = @mysql_query($sql, $zalongwa);
		$loginFoundUser = mysql_num_rows($result);
 		if ($loginFoundUser) {
       		$loginStrGroup  = mysql_result($result,0,'password');
    		$loginName		= mysql_result($result,0,'FullName');
			$position 		= mysql_result($result,0,'Position');
			$RegNo 		= mysql_result($result,0,'RegNo');
			$module 	= mysql_result($result,0,'Module');
			$userFaculty 	= mysql_result($result,0,'Faculty');
			$privilege  = mysql_result($result,0,'PrivilegeID');
			$mtumiaji = 3;
			
			$_SESSION['username'] = $username; 
			$_SESSION['mtumiaji'] = $mtumiaji; 
			$_SESSION['RegNo'] = $RegNo; 
			$_SESSION['module'] = $module; 
			$_SESSION['privilege'] = $privilege; 
			$_SESSION['loginName'] = $loginName; 
			$_SESSION['userFaculty'] = $userFaculty; 
						
	 	$update_login = "UPDATE security SET LastLogin = now() WHERE UserName = '$username' AND Password = '$password'";
	 	$result = mysql_query($update_login) or die("Siwezi ku-update LastLogin, Zalongwa");
	
if ($module=='1') 
         {
		   echo '<meta http-equiv = "refresh" content ="0; 
				url = academic/lecturerindex.php">';
					exit;
     	 }elseif ($module=='2') {
	 	   echo '<meta http-equiv = "refresh" content ="0; 
				 url = accommodation/housingindex.php">';
					exit;
		 }elseif ($module=='3') {
	 	   echo '<meta http-equiv = "refresh" content ="0; 
				 url = student/studentindex.php">';
					exit;
		 }elseif ($module=='4') {
	 	   echo '<meta http-equiv = "refresh" content ="0; 
				 url = admission/admissionindex.php">';
					exit;
 	 	 }elseif ($module=='5') {
      			echo '<meta http-equiv = "refresh" content ="0; 
						url = administrator/administratorindex.php">';
		exit;
 	 }elseif ($module=='6') { 
			echo "Your Are Currently Blocked from Using ZALONGWA database!<br> To Restore Services, Please Contact the System Administrator";
			exit;
	 }elseif ($module=='7') {
      			echo '<meta http-equiv = "refresh" content ="0; 
						url = billing/billingindex.php">';
		exit;
		}
	}else{
    $_SESSION['loginerror'] = 'Sign in Failed, Try Again!'; 
  	echo '<meta http-equiv = "refresh" content ="0; 
		url = index.php">';
		exit;
  	}
} 
?>
<?php
mysql_close($zalongwa);
?>