<?php
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Accommodation';
	$szSubSection = 'Allocation Report';
	$szTitle = 'Room Allocation Reports';
	include('admissionheader.php');
//control form display
?>
<?php
if(isset($_GET['login'])){
//validate received get value

$user = addslashes($_GET['login']);
$year = addslashes($_GET['ayear']);
echo "Deleting Candidate - ".$user;

$qdelete="DELETE FROM allocation WHERE RegNo = '$user' AND AYear='$year'";
$dbdelete_user = mysql_query($qdelete)or die('Cannot delete this user account!!');

//after deleting go back to user list
echo '<meta http-equiv = "refresh" content ="0; url = housingroomallocation.php">';
}
?>
<?php
	# include the footer
	include('../footer/footer.php');
?>