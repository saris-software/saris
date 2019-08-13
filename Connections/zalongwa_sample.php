<?php
// User configurable variables
$szSiteTitle = 'zalongwaSARIS';
$szWebmasterEmail = '< jlungo@udsm.ac.tz >';
@$hostname_zalongwa = "localhost";
@$database_zalongwa = "zalongwamnma";
@$username_zalongwa = "toor";
@$password_zalongwa = "toor";
$zalongwa = mysqli_connect($hostname_zalongwa, strrev($username_zalongwa), strrev($password_zalongwa));
if (!$zalongwa){
	 printf(mysqli_connect_error()."Tunasikitika Kuwa Hatuwezi Kutoa Huduma Kwa Sasa,\rTafadhari Jaribu Tena Baadaye!");
	 exit;
	}
	@mysqli_select_db($zalongwa, "zalongwamnma");


$zalongwa = mysqli_connect($hostname_zalongwa, strrev($username_zalongwa), strrev($password_zalongwa)); 
if (!$zalongwa){
	 printf(mysqli_error($zalongwa)."Tunasikitika Kuwa Hatuwezi Kutoa Huduma Kwa Sasa,\rTafadhari Jaribu Tena Baadaye!");
	 exit;
	}
mysqli_select_db ($zalongwa, "zalongwamnma")
$zalongwa = mysqli_connect ($hostname_zalongwa, strrev ($username_zalongwa), strrev ($password_zalongwa)); 
if (!$zalongwa){
 die("Tunasikitika Kuwa Hatuwezi Kutoa Huduma Kwa Sasa,\rTafadhari Jaribu Tena Baadaye!" . mysqli_connect_error());
	 exit();
	}
//change in selection of database as mysqli
mysqli_select_db ($zalongwa, "zalongwamnma");


global $szRootURL,$szRootPath,$szSiteTitle,$szWebmasterEmail,$arrStructure,$arrVariations,$intDefaultVariation;
global $szDBName,$szDBUsername,$szDBPassword,$szDiscussionAdmin,$szDiscussionPassword;
if (!$zalongwa){
	 echo("Tunasikitika Kuwa Hatuwezi Kutoa Huduma Kwa Sasa,\rTafadhari Jaribu Tena Baadaye!" . mysqli_connect_error());
	 exit();
	}

	$arrVariations = array (
		1 => array( 'name' => 'English', 'shortname' => 'Eng'),
		2 => array( 'name' => 'Kiswahili', 'shortname' => 'Sw'),
	);
	
	$arrVariationPreference = array (
		1 => 1,
		2 => 2
	);
	
	if (!isset ($_SESSION['arrVariationPreference'])){
		// store it in the session variable
		$_SESSION['arrVariationPreference']=$arrVariationPreference;
	}
	
	// define the default variation
	$intDefaultVariation = 1;

	#Get Organisation Name and address
	$qorg = "SELECT * FROM organisation";
	$dborg = mysqli_query($qorg);
	$row_org = mysqli_fetch_assoc($dborg);
	$dborg = mysqli_query ($qorg);
	$row_org = mysqli_fetch_assoc ($dborg);
	$org = $row_org['Name'];
	$post = $row_org['Address'];
	$phone = $row_org['tel'];
	$fax = $row_org['fax'];
	$email = $row_org['email'];
	$website = $row_org['website'];
	$city = $row_org['city'];

#get current year
$qcyear = "SELECT AYear FROM academicyear where status=1";
$dbcyear = mysqli_query($qcyear);
$row_cyear = mysqli_fetch_array($dbcyear);
$cyear=$row_cyear['AYear'];
	
 ?>
$dbcyear = mysqli_query ($qcyear);
$row_cyear = mysqli_fetch_array ($dbcyear);
$cyear=$row_cyear['AYear'];
  mysqli_close($zalongwa);
?>
