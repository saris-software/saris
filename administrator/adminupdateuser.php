<?php
require_once('../Connections/zalongwa.php'); 
$position=addslashes($_POST['position']);
$priv=addslashes($_POST['priv']);
$login=addslashes($_POST['login']);
$sql="UPDATE security Set Position='$position', AuthLevel='$priv' WHERE UserName='$login'";
$result = @mysqli_query($zalongwa,$sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
echo '<meta http-equiv = "refresh" content ="0; 
	url = adminmanageuser.php?content='.$login.'">';
	exit;
mysqli_free_result($result);
mysqli_close($zalongwa);
?>