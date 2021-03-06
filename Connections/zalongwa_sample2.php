<?php
// User configurable variables
$szSiteTitle = 'zalongwaSARIS';
$szWebmasterEmail = '< jlungo@udsm.ac.tz >';
@$hostname_zalongwa = "localhost";
@$database_zalongwa = "saris_students";
@$username_zalongwa = "siras";
@$password_zalongwa = "54321otod";


$zalongwa = new mysqli($hostname_zalongwa, strrev($username_zalongwa), strrev($password_zalongwa), $database_zalongwa);

if (!$zalongwa){
    printf("Tunasikitika Kuwa Hatuwezi Kutoa Huduma Kwa Sasa,\rTafadhari Jaribu Tena Baadaye!");
    exit;
}

global $szRootURL,$szRootPath,$szSiteTitle,$szWebmasterEmail,$arrStructure,$arrVariations,$intDefaultVariation;
global $szDBName,$szDBUsername,$szDBPassword,$szDiscussionAdmin,$szDiscussionPassword;
if (!$zalongwa){
    printf("Tunasikitika Kuwa Hatuwezi Kutoa Huduma Kwa Sasa,\rTafadhari Jaribu Tena Baadaye!");
    exit;
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
$dborg = $zalongwa->query($qorg);
$row_org = $dborg->fetch_assoc();
$org = $row_org['Name'];
$post = $row_org['Address'];
$phone = $row_org['tel'];
$fax = $row_org['fax'];
$email = $row_org['email'];
$website = $row_org['website'];
$city = $row_org['city'];

#get current year
$qcyear = "SELECT AYear FROM academicyear where status=1";
$dbcyear = $zalongwa->query($qcyear);
$row_cyear = $dbcyear->fetch_array();
$cyear=$row_cyear['AYear'];

?>
