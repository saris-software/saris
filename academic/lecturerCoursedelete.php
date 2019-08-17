<?php require_once('../Connections/zalongwa.php'); ?>
<?php
$rawid=$_GET['id'];
$id = preg_replace("[[:space:]]+", " ",$rawid);

if ((isset($_GET['code'])) && ($_GET['id'] != "")) {
  $deleteSQL = "DELETE FROM course WHERE  (id='$id') ";
                    
  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $deleteSQL);

  $deleteGoTo = "admissionSubject.php?course=$id";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>