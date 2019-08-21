<?php require_once('../Connections/zalongwa.php'); ?>
<?php
$rawmajor=$_GET['prog'];
$major = preg_replace("[[:space:]]+", " ",$rawmajor);
$rawkey=$_GET['sem'];
$key = preg_replace("[[:space:]]+", " ",$rawkey);
$rawyrs=$_GET['year'];
$yrs = preg_replace("[[:space:]]+", " ",$rawyrs);
$rawayear=$_GET['ayear'];
$ayear = preg_replace("[[:space:]]+", " ",$rawayear);

if ((isset($_GET['sem'])) && ($_GET['prog'] != "")) {
  $deleteSQL = "DELETE FROM coursecountprogramme WHERE (ProgrammeID='$major') AND (Semester = '$key') AND (YearofStudy = '$yrs') AND (AYear = '$ayear')";
                    
  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $deleteSQL);

  $deleteGoTo = "lecturerProgrammecoursecount.php?edit=$major";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>