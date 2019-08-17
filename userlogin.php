<?php require_once('Connections/zalongwa.php'); ?>
<?php
session_start();
session_cache_limiter('nocache');

if (isset($accesscheck)) {
  $GLOBALS['PrevUrl'] = $accesscheck;
	session_is_register('PrevUrl');
}

if (isset($_POST['textusername'])) {
  $date = date('Y m d');
  $username = $_POST['textusername'];
  $password = $_POST['textpassword'];
  // Generate jlungo hash
 $hash = "{jlungo-hash}" . base64_encode(pack("H*", sha1($password )));
	$sql=sprintf("SELECT UserName, password, RegNo, Position, Module, PrivilegeID, FullName, Faculty FROM security WHERE UserName='%s' AND password='%s'",
 		get_magic_quotes_gpc() ? $username : addslashes($username), get_magic_quotes_gpc() ? $hash : addslashes($hash));
	$result = mysqli_query($zalongwa, $sql);
		$loginFoundUser = mysqli_num_rows($result);
		$row = mysqli_fetch_assoc($result);
		$UName = $row['UserName'];

		$sql = "SELECT page FROM stats WHERE page LIKE '$UName%'";
    		$active = mysqli_query($zalongwa, $sql);
    		$userLoggedIn = mysqli_num_rows($active);
    		if($userLoggedIn >0){

			$loginStrGroup = $row['password'];
			$loginName = $row['FullName'];
			$position = $row['Position'];
			$RegNo = $row['RegNo'];
			$module = $row['Module'];
			$userFaculty = $row['Faculty'];
			$userDept = $row['Dept'];
			$userDeptHead = $row['DeptHead'];
		        $privilege = $row['PrivilegeID'];
                        $mtumiaji = 3;
                        
			$_SESSION['username'] = $username; 
			$_SESSION['mtumiaji'] = $mtumiaji; 
			$_SESSION['RegNo'] = $RegNo; 
			$_SESSION['module'] = $module; 
			$_SESSION['privilege'] = $privilege; 
			$_SESSION['loginName'] = $loginName; 
			$_SESSION['userFaculty'] = $userFaculty; 
				
	 	$update_login = "UPDATE security SET LastLogin = now() WHERE UserName = '$username' AND Password = '$password'";
	 	$result = mysqli_query($zalongwa, $update_login) or die("Siwezi ku-update LastLogin, Zalongwa");
	
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
	 	}elseif ($module=='8') {
      			echo '<meta http-equiv = "refresh" content ="0; 
						url = timetable/lecturerindex.php">';
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
mysqli_close($zalongwa);
?>
