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
			  $overwrite=1;
			  if ($overwrite==1 AND sizeof($arr)>6){
					#arrange the name in the right format.
					$nem=addslashes($arr[2]);
					$nemu=addslashes($arr[3]);
					$name=strtoupper($nem).", ".ucwords($nemu);			  

					$chas = mysqli_query($zalongwa, "SELECT RegNo FROM student WHERE RegNo='$arr[1]'", $zalongwa);
												
					if($overwrite==1 AND sizeof($arr)<7){
						echo "<p style='color:maroon'>ERROR: You can not overwrite student(s) without registration number(s)</p>";					
						}
						
					else{
						$year = str_replace(" ","",$arr[5]);
						$month = str_replace(" ","",$arr[6]);
						$day = str_replace(" ","",$arr[7]);
						
						if($year>1950 && $month>0 && $month<13 && $day>0 && $day<32){
							
							if($fetch = mysqli_num_rows($chas) == 0){
								$month = (strlen($month)>1)? $month:'0'.$month;
								$day = (strlen($day)>1)? $day:'0'.$day;
								
								$DBirth = $year.'-'.$month.'-'.$day;
								$sql ="REPLACE INTO student SET
															EntryYear='$impayear',
															ProgrammeofStudy = '$impprog',
															user = '$username',
															Received = '$today',
															AdmissionNo = '$arr[1]',
															RegNo = '$arr[1]',
															Sex = '$arr[4]',
															Name = '$name',
															DBirth = '$DBirth',
															Status =''
															";
								}
								
							else{							
								
								$month = (strlen($month)>1)? $month:'0'.$month;
								$day = (strlen($day)>1)? $day:'0'.$day;
								
								$DBirth = $year.'-'.$month.'-'.$day;
								
								$sql ="UPDATE student SET
															EntryYear='$impayear',
															ProgrammeofStudy = '$impprog',
															user = '$username',
															Received = '$today',
															AdmissionNo = '$arr[1]',
															RegNo = '$arr[1]',
															Sex = '$arr[4]',
															Name = '$name',
															Status ='',
															DBirth = '$DBirth'
															WHERE RegNo = '$arr[1]'";
								}
															
							mysqli_query($zalongwa, $sql);
							if(mysqli_error()) {
								 echo $name. "- Record ".$i." is Not Imported! Due to ".mysqli_error()."<br>\n"; //$arr[0]
								}
							else{
								echo "Record ".$i." Imported Successfuly!<br>\n";
								}
							}
							
						else{	
							//echo "<p style='color:maroon'>ERROR Record ".$i.": Date of birth for the student is not valid</p>";
							}
						}				    
				  }
			  
			  else{
				  //registration number automation
									
					#take the entry year
					$sub = substr($impayear,0,4);
					$sufx = substr($sub,-2);
					
					#get the programme name
					$progname = mysqli_query("SELECT ProgrammeName FROM programme WHERE ProgrammeCode='$impprog'", $zalongwa);
					$catch = mysqli_fetch_array($progname);
					$kifupi = $catch['ProgrammeName'];
					$chunk = explode(" ",$kifupi);
					
					#initialize the registrayion number
					//$a ? $b : ( $c ? $d : ( $e ? $f : $g ) )
					$assign = $chunk[0] == 'BD.'? "BD.".$chunk[1] : ($chunk[0] == 'BDZ.'? "BDZ.".$chunk[1]: ($chunk[0] == 'BTC.'? "BTC.".$chunk[1] : ($chunk[0] == 'C.'? "C.".$chunk[1] : ($chunk[0] == 'HD.'? "HD.".$chunk[1] :($chunk[0] == 'BT.'? "BT.".$chunk[1] : ($chunk[0] == 'OD.'? "OD.".$chunk[1] : ($chunk[0] == 'ODZ.'? "ODZ.".$chunk[1]: $chunk[1] )))))));
					
					/*if ($assign = ($chunk[0] == 'BD.'){
						"BD.".$chunk[1]
					}
					elseif($assign = ($chunk[0] == 'BTC.'){
						"BTC.".$chunk[1]
					}elseif($assign = ($chunk[0] == 'OD.'){
						"OD.".$chunk[1]
					}elseif($assign = ($chunk[0] == 'HD.'){
						"HD.".$chunk[1]
					}elseif($assign = ($chunk[0] == 'C.'){
						"C.".$chunk[1]} */
						
			
					$control = "MNMA/".$assign;
					
					
					#get the last entered registration number under the speciefied study programme
					$chas = mysqli_query("SELECT RegNo FROM student WHERE RegNo like '$control%' ORDER BY RegNo DESC", $zalongwa);
					
					if($fetchs=mysqli_num_rows($chas)==0){
						#assign the first registration number under tha new study programme
						$regno = $control."/0001/".$sufx;
						}
					else{
						
						$numo = '';
						while($fetch = mysqli_fetch_assoc($chas)){
							//$nums = substr($numx,0,4);
							$numx = explode("/", $fetch['RegNo']);
							$nums = $numx[2];
							
							$nums = ($nums >= 10000)? 0:$nums;
							$numo = ($numo > $nums)? $numo:$nums;
							}						
						
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
					
					$year = str_replace(" ","",$arr[4]);
					$month = str_replace(" ","",$arr[5]);
					$day = str_replace(" ","",$arr[6]);
					
					if($year>1950 && $month>0 && $month<13 && $day>0 && $day<32){
						
						$month = (strlen($month)>1)? $month:'0'.$month;
						$day = (strlen($day)>1)? $day:'0'.$day;
						$DBirth = $year.'-'.$month.'-'.$day;
						
						$sql ="INSERT INTO student SET
													EntryYear='$impayear',
													ProgrammeofStudy = '$impprog',
													user = '$username',
													Received = '$today',
													AdmissionNo = '$regno',
													RegNo = '$regno',
													Sex = '$arr[3]',
													Name = '$name',
													DBirth = '$DBirth',
													Status =''
													";//RegNo = '$arr[0]',Sex = '$arr[2]',
						mysqli_query($zalongwa, $sql);
					   
						if(mysqli_error()) {
							 echo $name. "- Record ".$i." is Not Imported! Due to ".mysqli_error()."<br>\n"; //$arr[0]
							}
						else{							
							#get surname
							$surname = explode(",",$name);
							$PWD = strtoupper(trim($surname[0]));
							$hash = "{jlungo-hash}" . base64_encode(pack("H*", sha1($PWD)));							
										
							mysqli_query("INSERT INTO security 
										(UserName, Password, FullName, RegNo, Position, AuthLevel, Email, LastLogin, Registered)
										VALUES 
										('$regno', '$hash', '$name', '$regno', 'student', 'user', '', now(), now())"); 
							
							echo "Record ".$i." Imported Successfuly!<br>".mysqli_error()." \n";
							}
						}
					else{
						echo "<p style='color:maroon'>ERROR Record ".$i.": Date of birth for the student is not valid</p>";
						}
					}
				}
			echo "<br /><br /><strong>Zalongwa Data Import Process Completed</strong>"; 
			unlink("./temp/$filename");
			unlink("$filename");
			}
		}
		
	else{
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
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
		$AcademicYear = mysqli_query($zalongwa, $query_AcademicYear) or die(mysqli_error($zalongwa));
		$row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
		$totalRows_AcademicYear = mysqli_num_rows($AcademicYear);

		mysqli_select_db($database_zalongwa, $zalongwa);
		$query_Hostel = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
		$Hostel = mysqli_query($zalongwa, $query_Hostel) or die(mysqli_error($zalongwa));
		$row_Hostel = mysqli_fetch_assoc($Hostel);
		$totalRows_Hostel = mysqli_num_rows($Hostel);
			
		?>

		<form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentclasslist" id="studentclasslist">
			<table width="300" border="1" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
				<tr>
				  <th colspan="2" nowrap><div align="center">IMPORTING STUDENTS CLASS LIST </div></th>
				</tr>
				<tr>
				  <td colspan="2" nowrap>
					  <div align="center">
						  <b>
						  DOWNLOAD STUDENT IMPORT TEMPLATE HERE: <br/>
						  <a href='../download/AdmissionImportFormat.xls'>NEW STUDENTS TEMPLATE</a> | 
						  <a href='../download/AdmissionImportOldFormat.xls'>EXISTING STUDENTS TEMPLATE</a>
						  </b>
					  </div>
				  </td>
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
					  <td rowspan="1" nowrap><div align="right">Intake Year:</div></td>
							<td colspan="1" bgcolor="#CCCCCC"><select name="cohort" id="cohort" style='width:190px'>
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

	@mysqli_free_result($AcademicYear);

	@mysqli_free_result($Hostel);
	include('../footer/footer.php');
?>
