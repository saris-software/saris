<?php
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Import Student';
	$szTitle = 'Import Students Class List';
	include('admissionheader.php');

if (isset($_POST['import']) && ($_POST['import'] == "Import Data")) {
	
	#STEP 1.0 Upload data file
	
	#constants
	$fileavailable=0;
	
	#validate the file
	$file_name = ($_POST['userfile']);
	$overwrite = addslashes($_POST['checkbox']);
			
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
	// In PHP earlier than 4.1.0, $HTTP_POST_FILES  should be used instead of $_FILES.
	if (is_uploaded_file($filetmp)) {
		$filename=time().$file;
	    copy($filetmp, "$filename");
	} else {
	   echo "File not uploaded, see the error: <br>".$filetype_error .' for file '.$file_name;
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
			echo '<meta http-equiv = "refresh" content ="10; url = admissionImport.php">';
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
		
		echo $file." Import Progress Status.............<br>"; 

			#get impo year
			  $impayear = addslashes($_POST['cohort']);
			  
		  #get impo programme
		 	  $impprog = addslashes($_POST['programme']);
		  
		  $fcontents = file ("./temp/$filename"); 
		  # expects the csv file to be in the same dir as this script
		  for($i=1; $i<sizeof($fcontents); $i++) 
		  { 
			  $line = trim($fcontents[$i], ',');
			  $arr = explode(",", $line); 
			  #if your data is comma separated
			  # instead of tab separated, 
			  # change the '\t' above to ',' 
			  $nam1=addslashes($arr[1]);
			  $nam2=addslashes($arr[2]);
			  $name=$nam1.", ".$nam2;
			  if ($overwrite==1){
			  $sql ="REPLACE INTO student SET
			  									EntryYear='$impayear',
												ProgrammeofStudy = '$impprog',
												user = '$username',
												Received = '$today',
												RegNo = '$arr[0]',
												Sex = '$arr[3]',
												Name = '$name',
												Status =''
												";
			  }else{
			  $sql ="INSERT INTO student SET
			  									EntryYear='$impayear',
												ProgrammeofStudy = '$impprog',
												user = '$username',
												Received = '$today',
												RegNo = '$arr[0]',
												Sex = '$arr[3]',
												Name = '$name',
												Status =''
												";
			  }
			  mysqli_query($zalongwa, $sql);
			   
			  if(mysqli_error()) {
					 echo $arr[0]. "- Record ".$i." is Not Imported! Due to ".mysqli_error()."<br>\n";
				  }else{
					 echo "Record ".$i." Imported Successfuly!<br>\n"; 
				  }
		  }
		echo "<br /><br /><strong>Zalongwa Data Import Process Completed</strong>"; 
		unlink("./temp/$filename");
		unlink("$filename");
	}
}else{
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

mysqli_select_db($database_zalongwa, $zalongwa);
$query_AcademicYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AcademicYear = mysqli_query($zalongwa, $query_AcademicYear) or die(mysqli_error());
$row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
$totalRows_AcademicYear = mysqli_num_rows($AcademicYear);

mysqli_select_db($database_zalongwa, $zalongwa);
$query_Hostel = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$Hostel = mysqli_query($zalongwa, $query_Hostel) or die(mysqli_error());
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);
	
?>
<form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentclasslist" id="studentclasslist">
    <table width="300" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
          <td colspan="2" nowrap><div align="center">IMPORTING STUDENTS CLASS LIST </div></td>
          </tr>
		  <tr>
			  <td rowspan="1" nowrap><div align="right">Programme:</div></td>
			  <td colspan="1" bgcolor="#CCCCCC"><select name="programme" id="programme">
				   <option value="0">--------------------------------</option>
			            <?php
						do {  
						?>
						            <option value="<?php echo $row_Hostel['ProgrammeCode']?>"><?php echo $row_Hostel['ProgrammeName']?></option>
						            <?php
						} while ($row_Hostel = mysqli_fetch_assoc($Hostel));
						  $rows = mysqli_num_rows($Hostel);
						  if($rows > 0) {
						      mysqli_data_seek($Hostel, 0);
							  $row_Hostel = mysqli_fetch_assoc($Hostel);
						  }
						?>
          			</select></td>
		  </tr>
  		  <tr>
			  <td rowspan="1" nowrap><div align="right">Group Cohort:</div></td>
					<td colspan="1" bgcolor="#CCCCCC"><select name="cohort" id="cohort">
					  <option value="0">--------------------------------</option>
			            <?php
					do {  
					?>
			            <option value="<?php echo $row_AcademicYear['AYear']?>"><?php echo $row_AcademicYear['AYear']?></option>
			            <?php
					} while ($row_AcademicYear = mysqli_fetch_assoc($AcademicYear));
					  $rows = mysqli_num_rows($AcademicYear);
					  if($rows > 0) {
					      mysqli_data_seek($AcademicYear, 0);
						  $row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
					  }
					?>
				   </select></td>
		   </tr>     
   		  <tr>
			  <td rowspan="1" nowrap><div align="right">Student CSV File:</div></td>
				<td colspan="1" bgcolor="#CCCCCC">
					<input type="hidden" name="MAX_FILE_SIZE" value="55646039">
					<input name="userfile" type="file" size="25">
				</td>
		   </tr>
		   <tr>
			  <td rowspan="1" nowrap><div align="right">Existing Data:</div></td>
				<td colspan="1" bgcolor="#CCCCCC"><input name="checkbox" type="checkbox" value="1">Yes Overwrite</td>
		   </tr>
        <tr>
         <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">
		    <div align="center">
		       <input name="import" type="submit" id="import" value="Import Data">
            </div></td>
	        </tr>
	      </table>
        </form>
<?php
}
mysqli_free_result($AcademicYear);

mysqli_free_result($Hostel);
include('../footer/footer.php');
?>
