<?php
session_start();
session_cache_limiter('nocache');
@$module  = $_SESSION['module'];
@$privilege  = $_SESSION['privilege'];
@$RegNo = $_SESSION['RegNo'];
@$username = $_SESSION['username'];
@$name = $_SESSION['loginName'];
@$userFaculty = $_SESSION['userFaculty'];

date_default_timezone_set('Africa/Dar_es_Salaam');
$today = date("Y-m-d");

if(!$username){
	echo ("Session Expired, <a href=\"../index.php\"> Click Here<a> to Re-Login");
	echo '<meta http-equiv = "refresh" content ="0; url = ../index.php">';
	exit;
}
?>
