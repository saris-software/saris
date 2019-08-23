<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    # initialise globals
	include('../academic/lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Excel Import';
	$szTitle = 'Import MS Excel Database Data';
	include('../academic/lecturerheader.php');
?>
<?php
#STEP 1.0 Upload data file

# delete old files
@unlink("./temp/zalongwa.csv");
#constants
$fileavailable=0;

#validate the file
$file_name = ($_POST['userfile']);
$overwrite = addslashes($_POST['radiobutton']);

		
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
?>
<?php 
// In PHP earlier then 4.1.0, $HTTP_POST_FILES  should be used instead of $_FILES.
if (is_uploaded_file($filetmp)) {
	$filename=time().$file;
    copy($filetmp, "$filename");
} 
else {
   echo "File not uploaded, see the error: <br>".$filetype_error;
}
  move_uploaded_file($filetmp, "./temp/$filename");

#check file extension

    $str = $filename;
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	
    $pext = strtolower($ext);
   if ($pext != "csv")
    {
     
	    print "<h2>ERROR</h2>File Extension Unknown.<br>";
        print "<p>Please Upload a File with the Extension .csv ONLY<br>";
		print "To convert your Excel File to csv, go to File -> Save As, then Select Save as Type CSV (Comma delimeded) (*.csv)</p>\n";
        print "The file you uploaded have this extension: $pext</p>\n";
		echo '<meta http-equiv = "refresh" content ="10; url = zalongwaimport.php">';
	    include('../footer/footer.php');
		unlink($filename);
        exit();
		
    }

?>
<?php 
if ($pext == "csv") {
$fileavailable=1;
}

#STEP 2.0 exceute sql scripts
if ($fileavailable==1){
	echo "<strong>Data Import in Process</strong><br /><br>"; 
	
	echo "Progress Status.............<br>"; 
	  $fcontents = file ("./temp/$filename"); 
	  # expects the csv file to be in the same dir as this script

	  #get impo year
		  /*
	      $line = trim($fcontents[0], ',');
		  $arr = explode(",", $line); 
		  $impayear = trim($arr[1]);
		  */
		  $impayear = addslashes($_POST['ayear']);
		  
	  #get impo semester
	 	 /*
	      $line = trim($fcontents[1], ',');
		  $arr = explode(",", $line); 
		  $impsem = trim($arr[1]);
		  */
		  $impsem = addslashes($_POST['sem']);
	  #get impo coursecode
	  	/*
	      $line = trim($fcontents[2], ',');
		  $arr = explode(",", $line); 
		  $impcourse = trim($arr[1]);
		  */
		  $impcourse = addslashes($_POST['coursecode']);
		 
	  #get impo examcategory
	  /*
	      $line = trim($fcontents[3], ',');
		  $arr = explode(",", $line); 
		  $impexamcat = trim($arr[1]);
		  */
		  $impexamcat = addslashes($_POST['examcat']);
		  /*
		  $impexamcat = strtolower($impexamcat);
		  if ($impexamcat == 'cwk'){
		  		$impexamcat = 4;
		  }elseif($impexamcat=='exam'){
		   		$impexamcat = 5;
		  }else{
		 		$impexamcat = $impexamcat;
		  }
		  */
	  echo "<table border='0' cellpadding='3' cellspacing='0'>";
	  for($i=1; $i<sizeof($fcontents); $i++) 
	  { 
		  $line = trim($fcontents[$i], ',');
		  $arr = explode(",", $line); 
		  #if your data is comma separated
		  # instead of tab separated, 
		  # change the '\t' above to ','
		  		  		  
		  #fetching registration number
		  $exnum = explode("/", $arr[1]);
		  $exno = $exnum[0];
		  $table = "examnumber_".$exno;
		  
		  $tabs = mysqli_query($zalongwa, "CREATE TABLE IF NOT EXISTS $table 
											(RegNo varchar(50) PRIMARY KEY, ExamNo varchar(50) UNIQUE KEY, 
											EntryYear varchar(9),AYear varchar(9), Semester varchar(11))");
											
		  $usajili = mysqli_query($zalongwa, "SELECT RegNo FROM $table WHERE AYear='2010/2011' AND Semester='Semester II' AND ExamNo='$arr[0]'");
		  $rows = mysqli_num_rows($usajili);
		  
		  if($rows != 0){
			  $sql ="REPLACE INTO $table SET
										RegNo ='$arr[0]',
										ExamNo = '$arr[1]',
										EntryYear = '$arr[2]',
										AYear = '2010/2011',
										Semester = 'Semester II'";			  
			  }
		  else{
			  $sql ="INSERT INTO $table SET
										RegNo ='$arr[0]',
										ExamNo = '$arr[1]',
										EntryYear = '$arr[2]',
										AYear = '2010/2011',
										Semester = 'Semester II'";
			  }
				  
			mysqli_query($zalongwa,$sql);
			if(mysqli_error($zalongwa)) {
					  echo "<tr><td nowrap>Record ".$i."</td><td nowrap>(<b>$arr[0]</b>) is a Duplicate Entry</td><td nowrap>- Not Imported!</td></tr>"; 				 				 
				  }
				  else{
					  echo "<tr><td nowrap>Record ".$i." </td><td nowrap>Imported Successfuly!</td><td></td></tr>"; 
					}		  			 
			 }			 
	  echo "</table>";
	  echo "<br /><br /><strong>Zalongwa Data Import Process Completed</strong>"; 
	  unlink("./temp/$filename");
	  unlink("$filename");
	  }
	include('../footer/footer.php');
	exit;
?> 
