<?php
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# include the header
	include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'E-Voting System';
	$szTitle = 'Register Election Posts';
	$szSubSection = 'Election Posts';
	include("admissionheader.php");


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
		$rawcode = $_POST['txtCode'];
		$code = preg_replace("[[:space:]]+", " ",$rawcode);
		$rawname = $_POST['txtTitle'];
		$name = preg_replace("[[:space:]]+", " ",$rawname);

		#check if subject name exist
		$namesql ="SELECT Post FROM electionpost WHERE (Post  = '$name')";
		
		$nameresult = mysqli_query($zalongwa, $namesql) or die("Tunasikitika Kuwa Hatuwezi Kukuhudumia Kwa Sasa.<br>");
		$coursenameFound = mysqli_num_rows($nameresult);
		if ($coursenameFound) {
			$namefound   = mysqli_result($nameresult,0,'Post');
			print " This Post: '".$namefound."' Do Exists!!"; 
			exit;
			}
			
		#insert records	   				   
		$insertSQL = sprintf("INSERT INTO electionpost (Post) VALUES (%s)",GetSQLValueString($_POST['txtTitle'], "text"));                   
		mysqli_select_db($database_zalongwa, $zalongwa);
		$Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error());
		}

	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
 					   $updateSQL = sprintf("UPDATE electionpost SET Post=%s  WHERE Id=%s",
                       GetSQLValueString($_POST['txtTitle'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

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
		$query_inst = "SELECT * FROM electionpost WHERE Post Like '%$key%' ORDER BY Id ASC";
		}
	else{
		$query_inst = "SELECT * FROM electionpost ORDER BY Id ASC";
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

	echo"<p><a href='admissionElectionpost.php?new=1'>Add New Election Post </a></p>";

	@$new=$_GET['new'];

	if (@$new<>1){
?>
<form name="form1" method="get" action="<?php echo $editFormAction; ?>">
              Search by Post: 
                <input name="course" type="text" id="course" maxlength="50">
              <input type="submit" name="Submit" value="Search">
</form>
	   
<table border="1" cellpadding="3" cellspacing="0">
  <tr>
    <td><strong>PostID</strong></td>
	<td><div align="center"><strong>Post Name</strong></div></td>
  </tr>
  <?php
  $x=1; 
  do { ?>
  <tr>
	 <td nowrap><?php $name = $row_inst['Id']; echo "<a href=\"admissionElectionpost.php?edit=$name\">$name</a>"?></td>
	 <td><?php echo $row_inst['Post'] ?></td>
  </tr>
  <?php 
	$x++;
	} while ($row_inst = mysqli_fetch_assoc($inst)); ?>
</table>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1">......<span class="style2"><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> </span>..........</span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
       
	   
			
<?php
	}

	else{
		?>
		<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
		  <!-- A Separate Layer for the Calendar -->
		  <script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>
		  <table width="200" border="1" cellpadding="3" cellspacing="0" bordercolor="#006600">
			<tr bgcolor="#CCCCCC">
			</tr>
			<tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Post Name:</div></th>
			  <td><input name="txtTitle" type="text" id="txtTitle" size="40" required></td>
			</tr>
			<tr bgcolor="#CCCCCC">
			  <td colspan='2' align='center'>
				<input type="submit" name="Submit" value="Add Record">
			  </td>
			</tr>
		  </table>
			<input type="hidden" name="MM_insert" value="frmInst">
		</form>
		<?php 
		}
	 
	if (isset($_GET['edit'])){
		#get post variables
		$key = $_GET['edit'];

		mysqli_select_db($database_zalongwa, $zalongwa);
		$query_instEdit = "SELECT * FROM electionpost WHERE Id ='$key'";
		$instEdit = mysqli_query($zalongwa, $query_instEdit) or die(mysqli_error());
		$row_instEdit = mysqli_fetch_assoc($instEdit);
		$totalRows_instEdit = mysqli_num_rows($instEdit);

		$queryString_inst = "";
		if (!empty($_SERVER['QUERY_STRING'])) {
			$params = explode("&", $_SERVER['QUERY_STRING']);
			$newParams = array();
			
			foreach ($params as $param) {
				if (stristr($param, "pageNum_inst") == false && stristr($param, "totalRows_inst") == false) {
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
		  <!-- A Separate Layer for the Calendar -->
		  <script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>
		  <div align="left">
			<table width="200" border="1" cellpadding="3" cellspacing="0" bordercolor="#006600">
			  <tr bgcolor="#CCCCCC">
				
			</tr>
			  <tr bgcolor="#CCCCCC">
				<th nowrap scope="row"><div align="right">Post Code:</div></th>
				<td><input name="txtCode" type="hidden" id="txtCode" value="<?php echo $row_instEdit['Id']; ?>" size="40" required><?php echo $row_instEdit['Id']; ?></td>
			  </tr>
			  <tr bgcolor="#CCCCCC">
				<th nowrap scope="row"><div align="right">Post Name:</div></th>
				<td><input name="txtTitle" type="text" id="txtTitle" value="<?php echo $row_instEdit['Post']; ?>" size="40" required></td>
			  </tr>
			  <tr bgcolor="#CCCCCC">
				<th scope="row"><input name="id" type="hidden" id="id" value="<?php echo $key ?>"></th>
				<td>
				  <div align="left">
					<input type="submit" name="Submit" value="Edit Record">
				  </div></td>
			  </tr>
			</table>
			<input type="hidden" name="MM_update" value="frmInstEdit">
		  </div>
		</form>
	<?php
		}
	# include the footer
	include("../footer/footer.php");

@mysqli_free_result($inst);

@mysqli_free_result($instEdit);

@mysqli_free_result($faculty);

@mysqli_free_result($campus);
?>
