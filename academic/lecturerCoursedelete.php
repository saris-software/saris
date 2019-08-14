<?php require_once('../Connections/zalongwa.php'); ?>
<?php
$rawid=$_GET['id'];
$id = ereg_replace("[[:space:]]+", " ",$rawid);

if ((isset($_GET['code'])) && ($_GET['id'] != "")) {
  $deleteSQL = "DELETE FROM course WHERE  (id='$id') ";
                    
  mysql_select_db($database_zalongwa, $zalongwa);
  $Result1 = mysql_query($deleteSQL, $zalongwa);

  $deleteGoTo = "admissionSubject.php?course=$id";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>