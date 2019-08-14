<?php 
	session_start();
	session_cache_limiter('nocache');       
	@$loginerror  = $_SESSION['loginerror'];
	
	require_once('Connections/zalongwa.php');
	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
<<<<<<< HEAD
	$dborg = mysqli_query($qorg);
=======
	$dborg = mysqli_query($zalongwa, $qorg);
>>>>>>> 80d9e2142351871928501cd59c77a1fcb3d4ab4b
	$row_org = mysqli_fetch_assoc($dborg);
	$org = $row_org['Name'];
	$post = $row_org['Address'];
	$phone = $row_org['tel'];
	$fax = $row_org['fax'];
	$email = $row_org['email'];
	$website = $row_org['website'];
	$city = $row_org['city'];
	
	include 'loginform.php';

?>
