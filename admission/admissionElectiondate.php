<?php
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# include the header
	include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'E-Voting System';
	$szTitle = 'Set Election dates';
	$szSubSection = 'Election Date';
	include('admissionheader.php');
	$today = date('Y-m-d');


	mysqli_select_db($database_zalongwa, $zalongwa);
	$query_post = "SELECT ed.PostId, ed.Period, ed.StartDate, ed.EndDate, ep.Post 
					FROM electiondate ed, electionpost ep WHERE ep.Id=ed.PostId 
					ORDER BY ed.Period DESC, ep.Post DESC";
					
	$post = mysqli_query($zalongwa, $query_post) or die(mysqli_error());
	$row_post = mysqli_fetch_assoc($post);
	$totalRows_post = mysqli_num_rows($post);
	
	mysqli_select_db($database_zalongwa, $zalongwa);
	$elct_post = "SELECT * FROM electionpost ORDER BY Post DESC";
					
	$elct = mysqli_query($zalongwa, $elct_post) or die(mysqli_error());
	$row_elct = mysqli_fetch_assoc($elct);
	$totalRows_elct = mysqli_num_rows($elct);

	mysqli_select_db($database_zalongwa, $zalongwa);
	$query_ayear = "SELECT * FROM academicyear ORDER BY AYear DESC";
	$ayear = mysqli_query($zalongwa, $query_ayear) or die(mysqli_error());
	$row_ayear = mysqli_fetch_assoc($ayear);
	$totalRows_ayear = mysqli_num_rows($ayear);

	$currentPage = $_SERVER["PHP_SELF"];
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
		}

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
		$rawcode = $_POST['cmbPost'];
		$code = preg_replace("[[:space:]]+", " ",$rawcode);
		$rawperiod = $_POST['ayear'];
		$period = preg_replace("[[:space:]]+", " ",$rawperiod);

		#check if subject name exist
		$namesql ="SELECT * FROM electioncandidate WHERE Period='$period' AND 
					Post IN (SELECT Post FROM electionpost WHERE Id='$code')";
		
		$nameresult = mysqli_query($zalongwa, $namesql) or die("Service not available.<br>");
		$coursenameFound = mysqli_num_rows($nameresult);
		if($coursenameFound<1) {
			$error = urlencode("Please set candidates for the post first");
			$url = "admissionElectiondate.php?new=1&error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
			exit;
			}
			
		#insert records	   				   
		$insertSQL = sprintf("INSERT INTO electiondate (PostId,Period,StartDate,EndDate) VALUES (%s, %s, %s, %s)",
		GetSQLValueString($_POST['cmbPost'], "text"),
		GetSQLValueString($_POST['ayear'], "text"),
		GetSQLValueString($_POST['txtStart'], "text"),
		GetSQLValueString($_POST['textEnd'], "text"));                   
		mysqli_select_db($database_zalongwa, $zalongwa);
		$Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error());
		}

	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
 					   $updateSQL = sprintf("UPDATE electiondate SET StartDate=%s, EndDate=%s WHERE PostId=%s AND Period=%s",
                       GetSQLValueString($_POST['txtStart'], "text"),
                       GetSQLValueString($_POST['textEnd'], "text"),                       
                       GetSQLValueString($_POST['cmbPost'], "text"),
                       GetSQLValueString($_POST['ayear'], "text"));

		mysqli_select_db($database_zalongwa, $zalongwa);
		$Result1 = mysqli_query($zalongwa, $updateSQL) or die(mysqli_error());
		}
 
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
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
	if (isset($_GET['course'])) {
		$rawkey=$_GET['course'];
		$key = addslashes($rawkey);
		$query_inst = "SELECT ed.PostId, ed.Period, ed.StartDate, ed.EndDate,ep.Post 
						FROM electiondate ed, electionpost ep WHERE (ep.Post LIKE '%$key%' AND ep.Id=ed.PostId) 
						ORDER BY ed.Period DESC, ep.Post DESC";
		}
	else{
		$query_inst = "SELECT ed.PostId, ed.Period, ed.StartDate, ed.EndDate, ep.Post 
					FROM electiondate ed, electionpost ep WHERE ep.Id=ed.PostId 
					ORDER BY ed.Period DESC, ep.Post DESC";
		}

	//$query_inst = "SELECT * FROM course ORDER BY CourseCode ASC";
	$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
	$inst = mysqli_query($zalongwa, $query_limit_inst) or die(mysqli_error());
	$row_inst = mysqli_fetch_assoc($inst);

	if (isset($_GET['totalRows_inst'])) {
		$totalRows_inst = $_GET['totalRows_inst'];
		} 
	else{
		$all_inst = mysqli_query($zalongwa, $query_inst);
		$totalRows_inst = mysqli_num_rows($all_inst);
		}
	$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;

	echo"<p><a href='admissionElectiondate.php?new=1'>Add New Election Date</a></p>";

	@$new=$_GET['new'];

	if (@$new<>1){
?>
		<form name="form1" method="get" action="<?php echo $editFormAction; ?>">
              Search by Post Name: 
                <input name="course" type="text" id="course" maxlength="50">
              <input type="submit" name="Submit" value="Search">
		</form>
	   
		<table border="1" cellpadding="3" cellspacing="0">
		  <tr>
			<td><strong>SNo</strong></td>
			<td><strong>Post Name</strong></td>
			<td nowrap><strong>Election Period</strong></td>
			<td><strong>Start Date</strong></td>
			<td><strong>End Date</strong></td>
		  </tr>
		  <?php
		  $x=1; 
		  do { ?>
		  <tr>
			 <td><?php echo "<a href=\"admissionElectiondate.php?edit=$row_inst[PostId]&period=$row_inst[Period]\">$x</a>"; ?></td>
			 <td nowrap><?php  echo $row_inst['Post'];?></td>
			 <td><?php echo $row_inst['Period'] ?></td>
			 <td nowrap><?php echo $row_inst['StartDate'] ?></td>
			 <td nowrap><?php echo $row_inst['EndDate'] ?></td>
		  </tr>
		  <?php 
			$x++;
			} while ($row_inst = mysqli_fetch_array($inst)); ?>
		</table>
		<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1">......<span class="style2"><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> </span>..........</span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>		
<?php
		}

	else{
		?>
		<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
		  <table width="200" border="1" cellpadding="3" cellspacing="0" bordercolor="#006600">
			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Post:</div></th>
			  <td colspan='2'><select name="cmbPost" id="cmbPost" title="<?php echo $row_post['Post']; ?>" required>
				<?php
		do {  
		?>
				<option value="<?php echo $row_post['Id']?>"><?php echo $row_post['Post']?></option>
				<?php
		} while ($row_post = mysqli_fetch_assoc($elct));
		  $rows = mysqli_num_rows($post);
		  if($rows > 0) {
			  mysqli_data_seek($elct, 0);
			  $row_post = mysqli_fetch_assoc($elct);
		  }
		?>
			  </select></td>
			</tr>
				<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Period:</div></th>
			  <td colspan='2'><select name="ayear" id="ayear" title="<?php echo $row_ayear['AYear']; ?>" required>
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
			
			<!-- A Separate Layer for the Calendar -->
			<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script> 
			
			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">StartDate:</div></th>
			  <td>
				  <input type="text" name="txtStart" id="txtStart" size="20" value="<?php echo $today ?>" required>			
			  </td>
			  <td>
				  <input type="button" class="button" name="dtDate_button" value="Calendar" 
				  onClick="show_calendar('save.txtStart', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')">
			  </td>
			</tr>
			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">EndDate:</div></th>
			  <td>
				  <input type="text" name="textEnd" size="20" id="textEnd" value="<?php $date = date('Y-m-d', strtotime("+1 months")); echo trim($date);?>" required>				  
			  </td>
			  <td>
				  <input type="button" class="button" name="dtDate_button" value="Calendar" 
				  onClick="show_calendar('save.textEnd', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')">
			  </td>
			</tr>
			<!-- End of Dates -->
			
			<tr bgcolor="#CCCCCC">
			  <td colspan='3' align='center'>
				<input type="submit" name="Submit" value="Add Record">
			  </td>
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
	 
	if (isset($_GET['edit'])){
		#get post variables
		$key = $_GET['edit'];
		$period = $_GET['period'];
		
		$get_detail = mysqli_query("SELECT ed.PostId, ed.Period, ed.StartDate, ed.EndDate,ep.Post 
								FROM electiondate ed, electionpost ep 
								WHERE (ed.PostId='$key' AND ed.Period ='$period' AND ep.Id=ed.PostId) 
								ORDER BY ed.Period DESC, ep.Post DESC", $zalongwa);
		
		$post_detail = mysqli_fetch_array($get_detail);
		?>
		<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
		  <table width="200" border="1" cellpadding="3" cellspacing="0" bordercolor="#006600">
			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Post:</div></th>
			  <td colspan='2'>
				  <select name="cmbPost" id="cmbPost" title="<?php echo $post_detail['Post']; ?>" required>
					<option value="<?php echo $post_detail['PostId']?>"><?php echo $post_detail['Post']?></option>
				  </select>
			  </td>
			</tr>
				<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Period:</div></th>
			  <td colspan='2'>
				  <select name="ayear" id="ayear" title="<?php echo $post_detail['Period']; ?>" required>
					<option value="<?php echo $post_detail['Period']?>"><?php echo $post_detail['Period']?></option>
				  </select>
			  </td>
			</tr>
			
			<!-- A Separate Layer for the Calendar -->
			<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script> 
			
			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">StartDate:</div></th>
			  <td>
				  <input type="text" name="txtStart" id="txtStart" size="20" value="<?php echo $post_detail['StartDate'] ?>" required>			
			  </td>
			  <td>
				  <input type="button" class="button" name="dtDate_button" value="Calendar" 
				  onClick="show_calendar('save.txtStart', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')">
			  </td>
			</tr>
			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">EndDate:</div></th>
			  <td>
				  <input type="text" name="textEnd" size="20" value="<?php echo $post_detail['EndDate']?>" required>				  
			  </td>
			  <td>
				  <input type="button" class="button" name="dtDate_button" value="Calendar" 
				  onClick="show_calendar('save.textEnd', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')">
			  </td>
			</tr>
			<!-- End of Dates -->
			
			<tr bgcolor="#CCCCCC">
			  <td colspan='3' align='center'>
				<input type="submit" name="Submit" value="Update Record">
			  </td>
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
	# include the footer
	include("../footer/footer.php");

@mysqli_free_result($inst);

/** @var instEdit $instEdit */
@mysqli_free_result($instEdit);

@mysqli_free_result($faculty);

@mysqli_free_result($campus);
?>
