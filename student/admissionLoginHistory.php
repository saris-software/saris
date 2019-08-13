<?php 
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
# include the header
include('studentMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Security';
	$szTitle = 'Security';
	$szSubSection = 'Security';
	//$additionalStyleSheet = './general.css';
	include("studentheader.php");
//page content starts here

@$username = $_SESSION['username'];
$sql = "SELECT stats.ip,
       stats.page,
       stats.received,
       stats.page
FROM stats WHERE stats.page LIKE '$username%'  ORDER BY stats.received DESC LIMIT 10";

//(((roomapplication.Hall)='$hall') And
$result = @mysqli_query($zalongwa,$sql) or die("Cannot query the database.<br>" . mysqli_error());
$query = @mysqli_query($zalongwa,$sql) or die("Cannot query the database.<br>" . mysqli_error());

$all_query = mysqli_query($zalongwa,$query);
$totalRows_query = mysqli_num_rows($query);
/* Printing Results in html */
if (mysqli_num_rows($query) >// User configurable variables
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
	$dborg = mysqli_query($zalongwa,$qorg);
	$row_org = mysqli_fetch_assoc($dborg);
	$dborg = mysqli_query ($zalongwa,$qorg);
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
$dbcyear = mysqli_query($zalongwa,$qcyear);
$row_cyear = mysqli_fetch_array($dbcyear);
$cyear=$row_cyear['AYear'];

 ?>
$dbcyear = mysqli_query ($qcyear);
$row_cyear = mysqli_fetch_array ($dbcyear);
$cyear=$row_cyear['AYear'];
  mysqli_close($zalongwa);
?>
 0){
echo "Frequencies of User \"$username\" in Visiting the Website";
echo "<table border='1'>";
echo "<tr><td> S/No </td><td> Computer Used</td><td> Webpage </td><td> Date of Visit </td></tr>";
$i=1;
while($result = mysql_fetch_array($query)) {
		$ip = stripslashes($result["ip"]);
		$browser = stripslashes($result["page"]);
		$received = stripslashes($result["received"]);
		
			echo "<tr><td>$i</td>";
			echo "<td>$ip</td>";
			echo "<td>$browser</td>";
			echo "<td>$received</td></tr>";
		$i=$i+1;
		}
echo "</table>";
}else{
echo "User \"$username\" has never visited the Website <br>";
}
mysql_close($zalongwa);
?>
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
	$dborg = mysqli_query($zalongwa,$qorg);
	$row_org = mysqli_fetch_assoc($dborg);
	$dborg = mysqli_query ($zalongwa,$qorg);
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
$dbcyear = mysqli_query($zalongwa,$qcyear);
$row_cyear = mysqli_fetch_array($dbcyear);
$cyear=$row_cyear['AYear'];

 ?>
$dbcyear = mysqli_query ($qcyear);
$row_cyear = mysqli_fetch_array ($dbcyear);
$cyear=$row_cyear['AYear'];
  mysqli_close($zalongwa);
?>

	# include the footer
	include("../footer/footer.php");
?>