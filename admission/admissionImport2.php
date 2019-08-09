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
	}
	else {
	   echo "<p style='color:maroon'>File not uploaded, error(".$filetype_error .") <br>The chosen file is not a CSV file</p>";
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
		  
		  #get registration number format
			  $format = addslashes($_POST['format']);
		  
		  if($impprog==0 && $impayear==0){
			  echo "<p style='color:maroon'><b>ERROR:</b> Select Study Programme and Intake Year First</p>";
			  include('../footer/footer.php');
			  exit;
			  }
			  
		  if($impprog==0){
			  echo "<p style='color:maroon'><b>ERROR:</b> Select Study Programme First</p>";
			  include('../footer/footer.php');
			  exit;
			  }
			  
		  if($impayear==0){
			  echo "<p style='color:maroon'><b>ERROR:</b> Select Study Intake Year First</p>";
			  include('../footer/footer.php');
			  exit;
			  }
		
		  $fcontents = file ("./temp/$filename"); 
		  # expects the csv file to be in the same dir as this script
		  for($i=1; $i<sizeof($fcontents); $i++) { 
			  $line = trim($fcontents[$i], ',');
			  $arr = explode(",", $line); 
			  #if your data is comma separated
			  # instead of tab separated, 
			  # change the '\t' above to ',' 
			  
			  #arrange the name in the right format.
			  $nem=addslashes($arr[1]);
			  $nemu=addslashes($arr[2]);
			  
			  $name=strtoupper($nem).", ".ucwords($nemu);
			  if ($overwrite==1 AND sizeof($arr)>4){
				#arrange the name in the right format.
				$nem=addslashes($arr[2]);
				$nemu=addslashes($arr[3]);
				$name=strtoupper($nem).", ".ucwords($nemu);			  
				
				$chas = mysql_query("SELECT RegNo FROM student WHERE RegNo='$arr[1]'");
				if($fetch = mysql_num_rows($chas) == 0){
					$sql ="REPLACE INTO student SET
			  									EntryYear='$impayear',
												ProgrammeofStudy = '$impprog',
												user = '$username',
												Received = '$today',
												AdmissionNo = '$arr[1]',
												RegNo = '$arr[1]',
												Sex = '$arr[4]',
												Name = '$name',
												Status =''
												";
					}
					
				elseif($overwrite==1 AND sizeof($arr)<5){
					echo "<p style='color:maroon'>ERROR: You can not overwrite student(s) without registration number(s)</p>";					
					}
					
				else{
					$sql ="UPDATE student SET
			  									EntryYear='$impayear',
												ProgrammeofStudy = '$impprog',
												user = '$username',
												Received = '$today',
												AdmissionNo = '$arr[1]',
												RegNo = '$arr[1]',
												Sex = '$arr[4]',
												Name = '$name',
												Status =''
												WHERE RegNo = '$arr[1]'";
					}
			  }
			  else{
				  //registration number automation
									
					#take the entry year
					$sub = substr($impayear,0,4);
					$sufx = substr($sub,-2);
					
					#get the programme name
					$progname = mysql_query("SELECT ProgrammeName FROM programme WHERE ProgrammeCode='$impprog'");
					$catch = mysql_fetch_array($progname);
					$kifupi = $catch['ProgrammeName'];
					$chunk = explode(" ",$kifupi);
					
					#initialize the registrayion number
					$assign = ($chunk[0] == 'BD.')? "BD.".$chunk[1]:$chunk[1];
					$control = "MNMA/".$assign;
					
					#get the last entered registration number under the speciefied study programme
					$chas = mysql_query("SELECT RegNo FROM student WHERE RegNo like '$control%' ORDER BY RegNo DESC LIMIT 1");
					
					if($fetchs=mysql_num_rows($chas)==0){
						#assign the first registration number under tha new study programme
						$regno = $control."/0001/".$sufx;
						}
					else{
						
						//get student's unique number
						$fetch = mysql_fetch_assoc($chas);
						$numx = substr($fetch['RegNo'],-7);
						$numo = substr($numx,0,4);
						
						#increment registration number under the specified study programme
						if(substr($numo,0,1)==0 AND substr($numo,1,1)==0 AND substr($numo,2,1)==0){
							$temp = (integer)substr($numo,-1);
							//echo "temporary holder ".$temp."</br>";
							$reg = $temp + 1;						
							//echo "regnum number ".$reg."</br>";
							if($reg>9){
								$regno = $control."/00".$reg."/".$sufx;
								}
							else{
								$regno = $control."/000".$reg."/".$sufx;							
								}
							}
						elseif(substr($numo,0,1)==0 AND substr($numo,1,1)==0 AND substr($numo,2,1)!=0){
							$temp = (integer)substr($numo,-2);
							//echo "temporary holder ".$temp."</br>";
							$reg = $temp + 1;						
							//echo "regnum number ".$reg."</br>";
							if($reg>99){
								$regno = $control."/0".$reg."/".$sufx;
								}
							else{
								$regno = $control."/00".$reg."/".$sufx;
								}
							}
						elseif(substr($numo,0,1)==0 AND substr($numo,1,1)!=0){
							$temp = (integer)substr($numo,-3);
							//echo "temporary holder ".$temp."</br>";
							$reg = $temp + 1;						
							//echo "regnum number ".$reg."</br>";
							if($reg>999){
								$regno = $control."/".$reg."/".$sufx;
								}
							else{
								$regno = $control."/0".$reg."/".$sufx;
								}
							}
						elseif(substr($numo,0,1)!=0 AND $numo<9999){
							$reg = $numo + 1;
							$regno = $control."/".$reg."/".$sufx;
							}
						else{
							//$numo==9999
							//the upper bound for the specific study programme has been reached
							echo "<span style='color:maroon>'<h2>System Evolution Required</h2>
									Registration number auto generation has reached end...<br></span>";
									
							unlink("./temp/$filename");
							unlink("$filename");
							exit();
						}			
					}
					//end of registration number automation
				
				$sql ="INSERT INTO student SET
			  									EntryYear='$impayear',
												ProgrammeofStudy = '$impprog',
												user = '$username',
												Received = '$today',
												AdmissionNo = '$regno',
												RegNo = '$regno',
												Sex = '$arr[3]',
												Name = '$name',
												Status =''
												";//RegNo = '$arr[0]',Sex = '$arr[2]',
				}
			  mysql_query($sql);
			   
			  if(mysql_error()) {
					 echo $name. "- Record ".$i." is Not Imported! Due to ".mysql_error()."<br>\n"; //$arr[0]
				  }else{
					 echo "Record ".$i." Imported Successfuly!<br>\n"; 
				  }
			}
		echo "<br /><br /><strong>Zalongwa Data Import Process Completed</strong>"; 
		unlink("./temp/$filename");
		unlink("$filename");
		}
	}
else{
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

mysql_select_db($database_zalongwa, $zalongwa);
$query_AcademicYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AcademicYear = mysql_query($query_AcademicYear, $zalongwa) or die(mysql_error());
$row_AcademicYear = mysql_fetch_assoc($AcademicYear);
$totalRows_AcademicYear = mysql_num_rows($AcademicYear);

mysql_select_db($database_zalongwa, $zalongwa);
$query_Hostel = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$Hostel = mysql_query($query_Hostel, $zalongwa) or die(mysql_error());
$row_Hostel = mysql_fetch_assoc($Hostel);
$totalRows_Hostel = mysql_num_rows($Hostel);
	
?>
<form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentclasslist" id="studentclasslist">
    <table width="300" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
          <td colspan="2" nowrap><div align="center">IMPORTING STUDENTS CLASS LIST </div></td>
          </tr>
		  <tr>
			  <td rowspan="1" nowrap><div align="right">Programme:</div></td>
			  <td colspan="1" bgcolor="#CCCCCC"><select name="programme" id="programme" style='width:190px'>
				   <option value="0">--------------------------------</option>
			            <?php
						do {  
						?>
						            <option value="<?php echo $row_Hostel['ProgrammeCode']?>"><?php echo $row_Hostel['ProgrammeName']?></option>
						            <?php
						} while ($row_Hostel = mysql_fetch_assoc($Hostel));
						  $rows = mysql_num_rows($Hostel);
						  if($rows > 0) {
						      mysql_data_seek($Hostel, 0);
							  $row_Hostel = mysql_fetch_assoc($Hostel);
						  }
						?>
          			</select></td>
		  </tr>
  		  <tr>
			  <td rowspan="1" nowrap><div align="right">Intake Year:</div></td>
					<td colspan="1" bgcolor="#CCCCCC"><select name="cohort" id="cohort" style='width:190px'>
					  <option value="0">--------------------------------</option>
			            <?php
					do {  
					?>
			            <option value="<?php echo $row_AcademicYear['AYear']?>"><?php echo $row_AcademicYear['AYear']?></option>
			            <?php
					} while ($row_AcademicYear = mysql_fetch_assoc($AcademicYear));
					  $rows = mysql_num_rows($AcademicYear);
					  if($rows > 0) {
					      mysql_data_seek($AcademicYear, 0);
						  $row_AcademicYear = mysql_fetch_assoc($AcademicYear);
					  }
					?>
				   </select></td>
		   </tr>  			
		  <tr>
			  <td rowspan="1" nowrap><div align="right">Registration Number Format:</div></td>
				<td colspan="1" bgcolor="#CCCCCC">
					<input type="text" name="format" value="E.g. (MNMA/YW/0000/11)" style="background:#CCCCCC; width:190px;" readonly>
					<!--
					<select name='format' id='format' readonly>						
						<option value="1" readonly>With Slash (e.g. MNMA/YW/0000/11)</option>						
					</select>
					-->
				</td>
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
@mysql_free_result($AcademicYear);

@mysql_free_result($Hostel);
include('../footer/footer.php');
?>
