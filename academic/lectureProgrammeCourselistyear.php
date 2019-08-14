<?php 
	require_once('../Connections/zalongwa.php');
	require_once('../Connections/sessioncontrol.php');

	include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Programme Information';
	$szSubSection = 'Programme';
	include("lecturerheader.php");
	
?>

<div style="height:30px; color:blue; width:900px;"><?php
     
$key = $_GET['edit'];
mysqli_select_db($zalongwa, $database_zalongwa);
$prog_sql = "SELECT * FROM programme WHERE ProgrammeCode ='$key'";
$prog_result = mysqli_query($zalongwa, $prog_sql);
$fetc_prog = mysqli_fetch_assoc($prog_result);

echo 'Course Configuration - '.$fetc_prog['ProgrammeName'].' : '.$fetc_prog['Title'];
?></div>

<?php 
echo '<div style="display:block; padding:10px; 0px 0px 10px;"><a style="color:black; text-decoration:underline;" href="lecturerProgrammecourselist.php?edit='.$key.'&ayear=no">Set New Configuration </a></div>';
$sql = "SELECT DISTINCT AYear FROM courseprogramme WHERE ProgrammeID='$key'";
$result = mysqli_query($zalongwa, $sql);
$num_row = mysqli_num_rows($result);
if($num_row > 0){
	while ($row = mysqli_fetch_array($result)) {
		echo '<div style="display:block; padding:10px; 0px 0px 10px;"><a style="color:black; text-decoration:underline;" href="lecturerProgrammecourselist.php?edit='.$key.'&ayear='.$row['AYear'].'">Configuration Academic Year - '. $row['AYear'].' </a></div>';
	}
}

include('../footer/footer.php');

?>