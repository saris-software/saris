<?php require_once('../Connections/zalongwa.php'); ?>
<?php
$rawmajor=$_GET['prog'];
$major = ereg_replace("[[:space:]]+", " ",$rawmajor);
$rawkey=$_GET['sem'];
$key = ereg_replace("[[:space:]]+", " ",$rawkey);
$rawyrs=$_GET['year'];
$yrs = ereg_replace("[[:space:]]+", " ",$rawyrs);
$rawayear=$_GET['ayear'];
$ayear = ereg_replace("[[:space:]]+", " ",$rawayear);

if ((isset($_GET['sem'])) && ($_GET['prog'] != "")) {
  $deleteSQL = "DELETE FROM coursecountprogramme WHERE (ProgrammeID='$major') AND (Semester = '$key') AND (YearofStudy = '$yrs') AND (AYear = '$ayear')";
                    
  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($deleteSQL, $zalongwa);

  $deleteGoTo = "lecturerProgrammecoursecount.php?edit=$major";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>