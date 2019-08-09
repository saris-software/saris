<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# initialise globals
	include('../administrator/administratorMenu.php');

	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Database Maintenance';
	$szSubSection = 'Import Data';
	$szTitle = 'Restore/Import MySQL Database Data Dumps';
	include('../administrator/administratorheader.php');
?>
<?php
#constants
$fileavailable=0;

#validate the file
$file_name = addslashes($_POST['userfile']);

$file = $_FILES['userfile']['name'];
//The original name of the file on the client machine. 
$filetype = $_FILES['userfile']['type'];
//The mime type of the file, if the browser provided this information. An example would be "image/gif". 

$filesize = $_FILES['userfile']['size'];
//The size, in bytes, of the uploaded file. 

$filetmp = $_FILES['userfile']['tmp_name'];
//The temporary filename of the file in which the uploaded file was stored on the server. 

$filetype_error = $_FILES['userfile']['error'];

$filename=time().$_FILES['userfile']['name'];
//The error code associated with this file upload. ['error'] was added in PHP 4.2.0 
    $pext = getFileExtension($file);
    $pext = strtolower($pext);
   if (($pext != "zip")  && ($pext != "sql"))
    {
        print "<h2>ERROR</h2>File Extension Unknown.<br>";
        print "<p>Please Upload a File with the Extension .sql or .zip ONLY<br>";
        print "The file you uploaded had this extension: $pext</p>\n";
        exit();
    }

?>
<?php 
// In PHP earlier then 4.1.0, $HTTP_POST_FILES  should be used instead of $_FILES.
if (is_uploaded_file($filetmp)) {
	$filename=time().$file;
    copy($filetmp, "$filename");
} else {
   echo "File not uploaded, see the error: <br>".$filetype_error;
}
  move_uploaded_file($filetmp, "$filename");

?>
<?php #unzip the file first
if ($pext == "zip") {
rename("$filename", "zalongwa.zip");
require_once('tar.php');
$fileavailable=1;
}else{
rename("$filename", "zalongwa.sql");
$fileavailable=1;
}
?>
<?php
#STEP 2.0 exceute sql scripts
if ($fileavailable==1){
	echo "<strong>Data Import in Process</strong><br /><br />"; 
	
	echo "Progress Status............."; 
	executeSQLFromFile("zalongwa.sql",$zalongwa); 
	// Finished 
	echo "<br /><br /><strong>Import Complete</strong>"; 
	unlink("zalongwa.sql");
}
#function get file extension
function getFileExtension($str) {

        $i = strrpos($str,".");
        if (!$i) { return ""; }

        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);

        return $ext;
}

function executeSQLFromFile($filename,$zalongwa) { 
$success = true; 
$fp = fopen($filename,"r"); 
$sql = fread($fp,filesize($filename)); 
fclose($fp); 

// Make Array of SQL items 
$sqlArr = explode(";\r",$sql); 
for($k=0; $k < count($sqlArr)-1; $k++) { 
if (!@mysql_query($sqlArr[$k],$zalongwa)) { 
$success = false; 
die(mysql_error()); 
} 
} 

if ($success) { 
echo "Success!<br />"; 
} else { 
echo "Failed<br />"; 
} 
} 
	include('../footer/footer.php');
?> 