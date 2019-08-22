<?php
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# include the header
	include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'E-Voting System';
	$szTitle = 'Register Candidates';
	$szSubSection = 'Set Candidates';
	include("admissionheader.php");

	$currentPage = $_SERVER["PHP_SELF"];
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
		}

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
		
		$code = $_POST['txtRegNo'];
		$academic = $_POST['ayear'];
		
		#check if candidate exist
		$sql ="SELECT RegNo FROM electioncandidate WHERE (RegNo='$code' AND Period='$academic')";
		$result = mysqli_query($zalongwa, $sql) or die("Service not available.<br>");
		$coursecodeFound = mysqli_num_rows($result);
		
		if ($coursecodeFound) {
			$coursefound   = mysqli_result($result,0,'RegNo');
			$error = urlencode("This Candidate: $coursefound Do Exists!!");
			$url = "admissionSetcandidate.php?error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
			exit;
			}
		else{
			#check if the candidate exists in student table
			$check_exists = mysqli_query("SELECT Name FROM student WHERE RegNo='$code'", $zalongwa);
			
			if(@mysqli_num_rows($check_exists) <>'0'){
				$insertSQL = sprintf("INSERT INTO electioncandidate (RegNo, Post, Faculty, Institution, Period) VALUES (%s, %s, %s, %s, %s)",
				GetSQLValueString($_POST['txtRegNo'], "text"),
				GetSQLValueString($_POST['cmbPost'], "text"),
				GetSQLValueString($_POST['cmbFac'], "text"),
				GetSQLValueString($_POST['cmbInst'], "text"),
				GetSQLValueString($_POST['ayear'], "text"));

				mysqli_select_db($database_zalongwa, $zalongwa);
				$Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error($zalongwa));
				}
			else{
				$error = urlencode("There is no student with RegNo: $code");
				$url = "admissionSetcandidate.php?new=1&error=$error";
				echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
				exit;
				}
			}
		}

	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
		
		$code = $_POST['txtRegNo'];
		$year = $_POST['ayear'];
		$id = $_POST['id'];
		
		#check if candidate exist
		$sql ="SELECT RegNo FROM electioncandidate WHERE (RegNo='$code') AND (Period='$year') AND id<>'$id'";
		$result = mysqli_query($zalongwa, $sql) or die("Service not available.<br>");
		$coursecodeFound = mysqli_num_rows($result);
		
		if ($coursecodeFound) {
			$coursefound   = mysqli_result($result,0,'RegNo');
			print " This Candidate: '".$coursefound."' contests for a different post!!"; 
			exit;
			}
		else{
			#check if the candidate exists in student table
			$check_exists = mysqli_query("SELECT Name FROM student WHERE RegNo='$code'", $zalongwa);
			
			if(@mysqli_num_rows($check_exists) <>'0'){
				//$updateSQL = sprintf("UPDATE electioncandidate SET Post=%s, Faculty=%s, Institution=%s, Period=%s, Name=%s WHERE Id=%s",
				$updateSQL = sprintf("UPDATE electioncandidate SET RegNo=%s, Post=%s, Faculty=%s, Institution=%s, Period=%s WHERE Id=%s",
				GetSQLValueString($_POST['txtRegNo'], "text"),
				GetSQLValueString($_POST['cmbPost'], "text"),
				GetSQLValueString($_POST['cmbFac'], "text"),
				GetSQLValueString($_POST['cmbInst'], "text"),
				GetSQLValueString($_POST['ayear'], "text"),
				GetSQLValueString($_POST['id'], "int"));

				mysqli_select_db($database_zalongwa, $zalongwa);
				$Result1 = mysqli_query($zalongwa, $updateSQL) or die(mysqli_error($zalongwa));
				}
			else{
				$error = urlencode("There is no student with RegNo: $code");
				$url = "admissionSetcandidate.php?edit=$id&error=$error";
				echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
				exit;
				}
			}
		}
 
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
		
	//control the display table
	@$new=2;

	mysqli_select_db($database_zalongwa, $zalongwa);
	$query_campus = "SELECT * FROM campus ORDER BY Campus ASC";
	$campus = mysqli_query($zalongwa, $query_campus) or die(mysqli_error($zalongwa));
	$row_campus = mysqli_fetch_assoc($campus);
	$totalRows_campus = mysqli_num_rows($campus);

	mysqli_select_db($database_zalongwa, $zalongwa);
	$query_faculty = "SELECT * FROM faculty ORDER BY FacultyName ASC";
	$faculty = mysqli_query($zalongwa, $query_faculty) or die(mysqli_error($zalongwa));
	$row_faculty = mysqli_fetch_assoc($faculty);
	$totalRows_faculty = mysqli_num_rows($faculty);

	mysqli_select_db($database_zalongwa, $zalongwa);
	$query_post = "SELECT * FROM electionpost ORDER BY Post ASC";
	$post = mysqli_query($zalongwa, $query_post) or die(mysqli_error($zalongwa));
	$row_post = mysqli_fetch_assoc($post);
	$totalRows_post = mysqli_num_rows($post);

	mysqli_select_db($database_zalongwa, $zalongwa);
	$query_ayear = "SELECT * FROM academicyear ORDER BY AYear DESC";
	$ayear = mysqli_query($zalongwa, $query_ayear) or die(mysqli_error($zalongwa));
	$row_ayear = mysqli_fetch_assoc($ayear);
	$totalRows_ayear = mysqli_num_rows($ayear);

	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
		}

	$maxRows_inst = 10;
	$pageNum_inst = 0;
	if (isset($_GET['pageNum_inst'])) {
		$pageNum_inst = $_GET['pageNum_inst'];
		}

	$startRow_inst = $pageNum_inst * $maxRows_inst;
	mysqli_select_db($database_zalongwa, $zalongwa);

	$query_inst = "SELECT el.id, el.RegNo,el.Post,el.Faculty,el.Institution,el.Period,el.Photo,el.Size,st.Name 
					FROM electioncandidate el, student st WHERE st.RegNo=el.RegNo
					ORDER BY Period DESC, Name DESC";
		
	$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
	$inst = mysqli_query($zalongwa, $query_limit_inst) or die(mysqli_error($zalongwa));
	$row_inst = mysqli_fetch_assoc($inst);

	if (isset($_GET['totalRows_inst'])) {
		$totalRows_inst = $_GET['totalRows_inst'];
		} 
	else {
		$all_inst = mysqli_query($zalongwa, $query_inst);
		$totalRows_inst = mysqli_num_rows($all_inst);
		}
	$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;


	echo "<p><a href=\"admissionSetcandidate.php?new=1\">Add New Candidate </a></p>";
	@$new=$_GET['new'];

	if(isset($_POST['course'])){
		$key=$_POST['course'];
		$query_inst = mysqli_query("SELECT el.id, el.RegNo,el.Post,el.Faculty,el.Institution,el.Period,
									el.Photo,el.Size,st.Name FROM electioncandidate el, student st 
									WHERE el.RegNo Like '%$key%' AND st.RegNo=el.RegNo
									ORDER BY Period, Name DESC", $zalongwa);
		
		if(@mysqli_num_rows($query_inst) > 0){
			
			echo "<table border='1' cellpadding='3' cellspacing='0'>
				  <tr>
					<td><strong>SNo</strong></td>
					<td><strong>RegNo</strong></td>
					<td><strong>Name</strong></td>
					<td><strong>Post</strong></td>
					<td><strong>Faculty</strong></td>					
					<td><strong>Period</strong></td>
					<td><strong>Photo</strong></td>
				  </tr>";
		
			$index=1;
			while($results = mysqli_fetch_array($query_inst)){
				echo "<tr>
						<td nowrap>$index</td>
						<td nowrap>$results[RegNo]</td>
						<td nowrap><a href=admissionSetcandidate.php?edit=$results[id]>$results[Name]</a></td>
						<td nowrap>$results[Post]</td>
						<td nowrap>$results[Faculty]</td>						
						<td nowrap>$results[Period]</td>";
				
				if($results['Size']<'1'){
					$id = $results['RegNo'].'['.$results['Period'];
					
					echo "<td>
							<form action='img.php' method='POST' enctype='multipart/form-data'>
							<input type='hidden' name='MAX_FILE_SIZE' value='5300000'/>
							<input type='hidden' name='regno' value='".$id."'/>
							<input type='file' name='fileUp' id='fileUp' size='10'/>
							<input type='submit' name='Upload' value='Upload' />
						 </td></tr>";
					}

				else{
					$id = $results['RegNo'].'['.$results['Period'];
					echo '<td>
							<img src="img.php?id='.$id.'" height="120" width="100">
							<br/><a href="admissionSetcandidate.php?upload='.$id.'" style="color:blue">Change Photo</a>
						  </td></tr>';			 
					} 
				$index++;
				}
				
			echo "</table>";
			}
		else{
			$error = urlencode("There is no student with RegNo: $key");
			$url = "admissionSetcandidate.php?error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
			exit;
			}
		}

	elseif(isset($_GET['edit'])){
		#get post variables
		$key = $_GET['edit'];

		mysqli_select_db($database_zalongwa, $zalongwa);
		$query_instEdit = "SELECT * FROM electioncandidate WHERE Id ='$key'";
		$instEdit = mysqli_query($zalongwa, $query_instEdit) or die(mysqli_error($zalongwa));
		$row_instEdit = mysqli_fetch_assoc($instEdit);
		$totalRows_instEdit = mysqli_num_rows($instEdit);

		$queryString_inst = "";
		if (!empty($_SERVER['QUERY_STRING'])) {
		  $params = explode("&", $_SERVER['QUERY_STRING']);
		  $newParams = array();
		  foreach ($params as $param) {
			if (stristr($param, "pageNum_inst") == false && 
				stristr($param, "totalRows_inst") == false) {
			  array_push($newParams, $param);
			}
		  }
		  if (count($newParams) != 0) {
			$queryString_inst = "&" . htmlentities(implode("&", $newParams));
		  }
		}
		$queryString_inst = sprintf("&totalRows_inst=%d%s", $totalRows_inst, $queryString_inst);

		?>
		<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInstEdit" id="frmInstEdit">
		 <table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
			<tr bgcolor="#CCCCCC">
			  <th scope="row"><div align="right">Campus:</div></th>
		<td><select name="cmbInst" id="cmbInst" title="<?php echo $row_campus['Campus']; ?>" required>
		<option value="<?php echo $row_instEdit['Institution']?>"><?php echo $row_instEdit['Institution']?></option>
		  <?php
		do {  
		?>
		<option value="<?php echo $row_campus['Campus']?>"><?php echo $row_campus['Campus']?></option>
		  <?php
		} while ($row_campus = mysqli_fetch_assoc($campus));
		  $rows = mysqli_num_rows($campus);
		  if($rows > 0) {
			  mysqli_data_seek($campus, 0);
			  $row_campus = mysqli_fetch_assoc($campus);
		  }
		?>
			  </select></td>
			</tr>
			<tr bgcolor="#CCCCCC">
			  <th scope="row"><div align="right">Faculty:</div></th>
			  <td><select name="cmbFac" id="cmbFac" title="<?php echo $row_faculty['FacultyName']; ?>" required>
			  <option value="<?php echo $row_instEdit['Faculty']?>"><?php echo $row_instEdit['Faculty']?></option>
			   <option value="[All Faculties]">[All Faculties]</option>
				<?php
		do {  
		?>
				<option value="<?php echo $row_faculty['FacultyName']?>"><?php echo $row_faculty['FacultyName']?></option>
				<?php
		} while ($row_faculty = mysqli_fetch_assoc($faculty));
		  $rows = mysqli_num_rows($faculty);
		  if($rows > 0) {
			  mysqli_data_seek($faculty, 0);
			  $row_faculty = mysqli_fetch_assoc($faculty);
		  }
		?>
			  </select></td>
			</tr>
			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Post:</div></th>
			  <td><select name="cmbPost" id="cmbPost" title="">
				  <option value="<?php echo $row_instEdit['Post']?>"><?php echo $row_instEdit['Post']?></option>
				<?php
		do {  
		?>
				<option value="<?php echo $row_post['Post']?>"><?php echo $row_post['Post']?></option>
				<?php
		} while ($row_post = mysqli_fetch_assoc($post));
		  $rows = mysqli_num_rows($post);
		  if($rows > 0) {
			  mysqli_data_seek($post, 0);
			  $row_post = mysqli_fetch_assoc($post);
		  }
		?>
			  </select></td>
			</tr>
					<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Period:</div></th>
			  <td><select name="ayear" id="ayear" title="<?php echo $row_ayear['AYear']; ?>" required>
					  <option value="<?php echo $row_instEdit['Period']?>"><?php echo $row_instEdit['Period']?></option>

				<?php
		do {  
		?>
				<option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
				<?php
		} while ($row_ayear = mysqli_fetch_assoc($ayear));
		  $rows = mysqli_num_rows($ayear);
		  if($rows > 0) {
			  mysqli_data_seek($ayear, 0);
			  $row_ayear = mysqli_fetch_assoc($ayear);
		  }
		?>
			  </select></td>
			</tr>

			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">RegNo:</div></th>
			  <td><input name="txtRegNo" type="text" id="txtRegNo" value="<?php echo $row_instEdit['RegNo']; ?>" size="40" required></td>
			</tr>
			<tr bgcolor="#CCCCCC">
			  <th scope="row"><input name="id" type="hidden" id="id" value="<?php echo $key ?>"></th>
			  <td><div align="center">
				<input type="submit" name="Submit" value="Edit Record">
			  </div></td>
			</tr>
		  </table>
		  <input type="hidden" name="MM_update" value="frmInstEdit">
		</form>
		<?php
		
		if(isset($_GET['error'])){
			$error = urldecode($_GET['error']);
			echo "<p style='color:maroon'>$error</p>";
			} 
		}
	
	elseif(isset($_POST['Upload'])){
		#format student credentials
		$ID = $_POST['regno'];
		$det = explode("[",$ID);
		$num = $det[0];
		$per = $det[1];

		#known file extensions array
		$known_extensions = array('png','jpg','jpeg','gif');

		$max_size = $_POST['MAX_FILE_SIZE'];
				
		$fileName = $_FILES['fileUp']['name'];
		$tmpName  = $_FILES['fileUp']['tmp_name'];
		$fileSize = $_FILES['fileUp']['size'];
		$fileType = $_FILES['fileUp']['type'];
		
		
		#check if the file size has zero bytes
		if($fileSize <= 0){
			$error = urlencode("Please select photo to upload first");
			$location = "admissionSetcandidate.php?upload=$ID&error=$error";
			
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		
		#check if the file size has exceeded the maximum upload limit size
		if($fileSize > $max_size){
			$error = urlencode("The uploaded file has exceeded the maximum upload size limit");
			$location = "admissionSetcandidate.php?upload=$ID&error=$error";
			
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		
		#get file information
		$file_info = pathinfo($_FILES['fileUp']['name']); 
		$ext = strtolower($file_info['extension']);
		
		#check if the file extension is among the predefined file extensions
		if(!in_array($ext, $known_extensions, true)){
			$error = urlencode("File selected ($fileName) is not of a valid file type");
			$location = "admissionSetcandidate.php?upload=$ID&error=$error";
			
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		
		#read contents of the file
		$fp = fopen($tmpName, r);
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
		
		if(!get_magic_quotes_gpc()){
			$fileName = addslashes($fileName);
			}
			
		mysqli_query("UPDATE electioncandidate SET Photo='$content', Size='$fileSize' WHERE RegNo='$num' AND Period='$per'", $zalongwa);
		
		if(mysqli_error()){
			$error = urlencode("The file $fileName failed to upload");
			$location = "index.php?error=$error";
			
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		else{
			$location = "admissionSetcandidate.php";
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		}

	elseif(isset($_GET['upload'])){
		$id = $_GET['upload'];
		
		echo "<table border='1' cellpadding='3' cellspacing='0'>
				<form action='img.php' method='POST' enctype='multipart/form-data'>
				<tr>
					<td>
					 <input type='hidden' name='MAX_FILE_SIZE' value='5300000'/>
					 <input type='hidden' name='regno' value='".$id."'/>
					 <input type='file' name='fileUp' id='fileUp' size=10/>
					<td>
						<input type='submit' name='Upload' value='Upload' />
					</form>
					</td>
				</tr>
			  </table>";
			  
		if(isset($_GET['error'])){
			$error = urldecode($_GET['error']);
			echo "<p style='color:maroon'>$error</p>";
			} 
		}
		
	elseif($new=='1'){
			?>
		<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
		  <table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
			<tr bgcolor="#CCCCCC">
			  <th scope="row"><div align="right">Campus:</div></th>
			  <td><select name="cmbInst" id="cmbInst" title="<?php echo $row_campus['Campus']; ?>" required>
				<?php
		do {  
		?>
				<option value="<?php echo $row_campus['Campus']?>"><?php echo $row_campus['Campus']?></option>
				<?php
		} while ($row_campus = mysqli_fetch_assoc($campus));
		  $rows = mysqli_num_rows($campus);
		  if($rows > 0) {
			  mysqli_data_seek($campus, 0);
			  $row_campus = mysqli_fetch_assoc($campus);
		  }
		?>
			  </select></td>
			</tr>
			<tr bgcolor="#CCCCCC">
			  <th scope="row"><div align="right">Faculty:</div></th>
			  <td><select name="cmbFac" id="cmbFac" title="<?php echo $row_faculty['FacultyName']; ?>" required>
			  <option value="[All Faculties]">[All Faculties]</option>
				<?php
		do {  
		?>
				<option value="<?php echo $row_faculty['FacultyName']?>"><?php echo $row_faculty['FacultyName']?></option>
				<?php
		} while ($row_faculty = mysqli_fetch_assoc($faculty));
		  $rows = mysqli_num_rows($faculty);
		  if($rows > 0) {
			  mysqli_data_seek($faculty, 0);
			  $row_faculty = mysqli_fetch_assoc($faculty);
		  }
		?>
			  </select></td>
			</tr>
			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Post:</div></th>
			  <td><select name="cmbPost" id="cmbPost" title="<?php echo $row_post['Post']; ?>" required>
				<?php
		do {  
		?>
				<option value="<?php echo $row_post['Post']?>"><?php echo $row_post['Post']?></option>
				<?php
		} while ($row_post = mysqli_fetch_assoc($post));
		  $rows = mysqli_num_rows($post);
		  if($rows > 0) {
			  mysqli_data_seek($post, 0);
			  $row_post = mysqli_fetch_assoc($post);
		  }
		?>
			  </select></td>
			</tr>
				<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Period:</div></th>
			  <td><select name="ayear" id="ayear" title="<?php echo $row_ayear['AYear']; ?>" required>
				<?php
		do {  
		?>
				<option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
				<?php
		} while ($row_ayear = mysqli_fetch_assoc($ayear));
		  $rows = mysqli_num_rows($ayear);
		  if($rows > 0) {
			  mysqli_data_seek($ayear, 0);
			  $row_ayear = mysqli_fetch_assoc($ayear);
		  }
		?>
			  </select></td>
			</tr>

			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">RegNo:</div></th>
			  <td><input name="txtRegNo" type="text" id="txtRegNo" size="40" required></td>
			</tr>
			<tr bgcolor="#CCCCCC">
			  <th scope="row">&nbsp;</th>
			  <td><div align="center">
				<input type="submit" name="Submit" value="Add Record">
			  </div></td>
			</tr>
		  </table>
			<input type="hidden" name="MM_insert" value="frmInst">
		</form>
		<?php
		
		if(isset($_GET['error'])){
			$error = urldecode($_GET['error']);
			echo "<p style='color:maroon'>$error</p>";
			} 
		}

	elseif($new<>'1'){
		?>
		<form name="form1" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
		  Search by RegNo:
			<input name="course" type="text" id="course" maxlength="50" required>
		  <input type="submit" name="Submit" value="Search">
		</form>
			   
		<table border="1" cellpadding="3" cellspacing="0">
		  <tr>
			<td><strong>SNo</strong></td>
			<td><strong>RegNo</strong></td>
			<td><strong>Name</strong></td>
			<td><strong>Post</strong></td>
			<td><strong>Faculty</strong></td>
			<td><strong>Period</strong></td>
			<td><strong>Photo</strong></td>
		  </tr>
		  <?php
		  $counter=1; 
		  do { ?>
		  <tr>
			<td nowrap><?php echo $counter; ?></td>
			<td nowrap><?php echo $row_inst['RegNo']; ?></td>
			<td nowrap><?php $id = $row_inst['id']; echo "<a href=admissionSetcandidate.php?edit=$row_inst[id]>$row_inst[Name]</a>"?></td>
			<td nowrap><?php echo $row_inst['Post'];?></td>
			<td nowrap><?php echo $row_inst['Faculty'] ?></td>
			<td nowrap><?php echo $row_inst['Period']; ?></td>
			
		<?php
			if($row_inst['Size']<'1'){
				$id = $row_inst['RegNo'].'['.$row_inst['Period'];
				echo '<td>
						<img src="img.php?id='.$id.'" height="120" width="100">
						<br/><a href="admissionSetcandidate.php?upload='.$id.'" style="color:blue">Change Photo</a>
				   </td>';
		?>
			 <!--
			 <td>
			 <form action="img.php" method="POST" enctype="multipart/form-data">
			 <input type="hidden" name="MAX_FILE_SIZE" value="5300000"/>
			 <input type="hidden" name="regno" value="<?php echo $id;?>"/>
			 <input type="file" name="fileUp" id="fileUp" size="10"/><br/>
			 <input type="submit" name="Upload" value="Upload" />
			 </td>-->
	<?php
			 }
			 
		 else{
			 $id = $row_inst['RegNo'].'['.$row_inst['Period'];
			 echo '<td>
						<img src="img.php?id='.$id.'" height="120" width="100">
						<br/><a href="admissionSetcandidate.php?upload='.$id.'" style="color:blue">Change Photo</a>
				   </td>';			 
			 }
			 
		?>
		  </tr>
		  <?php 
		  $counter++;
		  } while ($row_inst = mysqli_fetch_assoc($inst));
		  ?>
		</table>
		<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1">......<span class="style2"><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> </span>..........</span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
						
		<?php
		if(isset($_GET['error'])){
			$error = urldecode($_GET['error']);
			echo "<p style='color:maroon'>$error</p>";
			} 
		}

	# include the footer
	include("../footer/footer.php");

@mysqli_free_result($inst);

@mysqli_free_result($instEdit);

@mysqli_free_result($faculty);

@mysqli_free_result($campus);
?>
