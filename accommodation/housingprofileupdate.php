<?php require_once('../Connections/zalongwa.php'); ?>
<?php
$username = @$_GET['RegNo'];

$name = addslashes($_POST['textName']);
$status = addslashes($_POST['textStatus']);
$email = addslashes($_POST['textEmail']);

if(!empty($name)) {

$sql = "UPDATE Security SET FullName='$name', Position='$status', Email='$email' WHERE UserName = '$username'";
$query = mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
if ($query)echo "Database Updated:";
	echo '<meta http-equiv = "refresh" content ="0; 
		url = housingprofile.php">';
} else {
echo '<meta http-equiv = "refresh" content ="0; 
	url = housingprofileEdit.php">';
}
mysql_close($zalongwa);
?>
