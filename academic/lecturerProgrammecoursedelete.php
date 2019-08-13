<?php require_once('../Connections/zalongwa.php'); ?>
<?php
$rawmajor=$_GET['major'];
$major = ereg_replace("[[:space:]]+", " ",$rawmajor);
$rawkey=$_GET['course'];
$key = ereg_replace("[[:space:]]+", " ",$rawkey);
$rawayear=$_GET['ayear'];
$ayear = ereg_replace("[[:space:]]+", " ",$rawayear);

if ((isset($_GET['course'])) && ($_GET['major'] != "")) {
  $deleteSQL = "DELETE FROM courseprogramme WHERE  (ProgrammeID='$major') AND (CourseCode = '$key') AND (AYear = '$ayear')";
                    
  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($deleteSQL, $zalongwa);

  $deleteGoTo = "lecturerProgrammecourselist.php?edit=$major";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>