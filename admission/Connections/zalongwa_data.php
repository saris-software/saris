<?php
// User configurable variables
$szSiteTitle = 'zalongwaSARIS';
$szWebmasterEmail = '< jlungo@udsm.ac.tz >';



@$hostname_zalongwa = "localhost";
@$database_zalongwa = "zalongwadit";
@$username_zalongwa = "password";
@$password_zalongwa = "password";
$zalongwa = mysqli_connect($hostname_zalongwa, strrev($username_zalongwa), strrev($password_zalongwa));
if (!$zalongwa)
	 echo("Tunasikitika Kuwa Hatuwezi Kutoa Huduma Kwa Sasa,\rTafadhari Jaribu Tena Baadaye!".mysqli_connect_error());
	 exit();
	}
mysqli_select_db ($database_zalongwa, $zalongwa);


global $szRootURL,$szRootPath,$szSiteTitle,$szWebmasterEmail,$arrStructure,$arrVariations,$intDefaultVariation;
global $szDBName,$szDBUsername,$szDBPassword,$szDiscussionAdmin,$szDiscussionPassword;
if (!$zalongwa){
	 echo("Tunasikitika Kuwa Hatuwezi Kutoa Huduma Kwa Sasa,\rTafadhari Jaribu Tena Baadaye!");
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
	
	if (!isset($_SESSION['arrVariationPreference'])){
		// store it in the session variable
		$_SESSION['arrVariationPreference']=$arrVariationPreference;
	}
	
	// define the default variation
	$intDefaultVariation = 1;

	#Get Organisation Name and address
	$qorg = "SELECT * FROM organisation";
	$dborg = mysqli_query($qorg,$database_zalongwa);
	$row_org = mysqli_fetch_assoc($dborg);
	$org = $row_org['Name'];
	$post = $row_org['Address'];
	$phone = $row_org['tel'];
	$fax = $row_org['fax'];
	$email = $row_org['email'];
	$website = $row_org['website'];
	$city = $row_org['city'];
?>
