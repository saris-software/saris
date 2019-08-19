<?php require_once('../Connections/zalongwa.php'); 

$currentPage = $_SERVER["PHP_SELF"];
global $queryString_inst;
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

mysqli_select_db($zalongwa, $database_zalongwa);
$query_Hostel = "SELECT HID, HName FROM hostel";
$Hostel = mysqli_query($zalongwa, $query_Hostel);
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);

mysqli_select_db($zalongwa, $database_zalongwa);
//the query was wrong, there is no Id field in block table
//$query_Block = "SELECT Id, HID, BName FROM block";



//control the display table
@$new=2;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmInst")) {
	$block=$_POST['cmbBlock'];
	echo 'block -> '.$block;
	if ($block!='0'){
	 $rnumber=$block.'-'.$_POST['txtRNumber'];
	}else{
		$rnumber=$_POST['txtRNumber'];
	}
	 $hall=$_POST['cmbHall'];
	 $capacity=$_POST['txtCapacity'];
	 $flr=$_POST['txtFlr'];
	 
	 if(empty($rnumber) || empty($hall) || empty($capacity) || empty($block) || empty($flr)){
			$error = urlencode("Please make sure you fill all the fields before submission");
			$updateGoTo = "roomRegister.php?new=1&error=$error";
			echo '<meta http-equiv = "refresh" content ="0; url ='. $updateGoTo.'">';								
		 }
		 else{
			 $insertSQL = "INSERT INTO room SET RNumber='$rnumber',
                           HID='$hall', Capacity='$capacity', BID='$block', FloorName='$flr'";
                           
			 mysqli_select_db($zalongwa, $database_zalongwa);
			 $Result1 = mysqli_query($zalongwa, $insertSQL);
			 }
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmInstEdit")) {
	 $rnumber=$_POST['txtRNumber'];
	 $hall=$_POST['cmbHall'];
	 $capacity=$_POST['txtCapacity'];
	 $block=$_POST['cmbBlock'];
	 $flr=$_POST['txtFlr'];
	 
  $updateSQL = "UPDATE room SET 
                                    Capacity='$capacity',
                                    BID='$block',
                                    FloorName='$flr'
  				WHERE HID='$hall' AND RNumber=' $rnumber'";

  mysqli_select_db($zalongwa, $database_zalongwa);
  $Result1 = mysqli_query($zalongwa, $updateSQL);

  $updateGoTo = "roomRegister.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_inst = 100;
$pageNum_inst = 0;
if (isset($_GET['pageNum_inst'])) {
  $pageNum_inst = $_GET['pageNum_inst'];
}
$startRow_inst = $pageNum_inst * $maxRows_inst;

mysqli_select_db($zalongwa, $database_zalongwa);
$query_inst = "SELECT HID, BID, RNumber, Capacity, FloorName FROM room ORDER BY HID, BID, RNumber ASC";
$query_limit_inst = sprintf("%s LIMIT %d, %d", $query_inst, $startRow_inst, $maxRows_inst);
$inst = mysqli_query($zalongwa, $query_limit_inst) or die(mysqli_error());
$row_inst = mysqli_fetch_assoc($inst);

if (isset($_GET['totalRows_inst'])) {
  $totalRows_inst = $_GET['totalRows_inst'];
} else {
  $all_inst = mysqli_query($zalongwa, $query_inst);
  $totalRows_inst = mysqli_num_rows($all_inst);
}
$totalPages_inst = ceil($totalRows_inst/$maxRows_inst)-1;

require_once('../Connections/sessioncontrol.php');
# include the header
include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Hostel Room Information';
	$szSubSection = 'Room Register';
	include("admissionheader.php");
	
	
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>


<p><?php echo "<a href=\"roomRegister.php?new=1\">"?>Add New Room</a> </p>
<?php @$new=$_GET['new'];
if (@$new<>1){
?>

<table border="1" cellpadding="1" cellspacing="0">
  <tr>
    <td nowrap><strong>Room Number</strong></td>
    <td><strong>Capacity</strong></td>
    <td><strong>Hostel</strong></td>
    <td><strong>Block</strong></td>
    <td><strong>Floor</strong></td>
  </tr>
  <?php do { ?>
  <tr>
    <td nowrap><?php $id = $row_inst['HID']; $name = $row_inst['HID']; $rnumber = $row_inst['RNumber']; 
	echo "<a href=\"roomRegister.php?edit=$id&rnumber=$rnumber\">$rnumber</a>"?></td>
	<td nowrap><?php echo $row_inst['Capacity']; ?></td>
    <td nowrap><?php echo $row_inst['HID']; ?></td>
	<td nowrap><?php echo $row_inst['BID']; ?></td>
    <td nowrap><?php echo $row_inst['FloorName']; ?></td>
  </tr>
  <?php } while ($row_inst = mysqli_fetch_assoc($inst)); ?>
</table>
<a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, max(0, $pageNum_inst - 1), $queryString_inst); ?>">Previous</a><span class="style1">.............</span><?php echo min($startRow_inst + $maxRows_inst, $totalRows_inst) ?>/<?php echo $totalRows_inst ?> <span class="style1">..............</span><a href="<?php printf("%s?pageNum_inst=%d%s", $currentPage, min($totalPages_inst, $pageNum_inst + 1), $queryString_inst); ?>">Next</a><br>
<?php }

else{

	if(isset($_GET['error'])){
		$error = urldecode($_GET['error']);
		echo "<p style='color:maroon'>$error</p>";
		}
	else{	
	?>
<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
	<table bgcolor="#cccccc" border="1" cellpadding="3" cellspacing="0">
		<tr>
			<td nowrap>Select Hostel</td>
			<td>
			<select name="hostel">
			<option value="0">Select Hostel</option>
		            <?php
				do {  
				?>
				            <option value="<?php echo $row_Hostel['HID']?>"><?php echo $row_Hostel['HName']?></option>
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
			<td colspan="2" align="center"><input type="submit" name="Hostel" value="Sumit Hostel" /></td>
		</tr>
	</table>
</form>

<?php 
	if(isset($_POST['Hostel'])){
		$hostel = $_POST['hostel'];
		
		$query_Block = "SELECT HID, BName FROM block WHERE HID='$hostel'";
		$Block = mysqli_query($zalongwa, $query_Block);
		$row_Block = mysqli_fetch_assoc($Block);
		$totalRows_Block = mysqli_num_rows($Block);
		
?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frmInst" id="frmInst">
  <table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Room Number:</div></th>
      <td><input name="txtRNumber" type="text" id="txtRNumber" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Capacity:</div></th>
      <td><input name="txtCapacity" type="text" id="txtCapacity" size="40"></td>
    </tr>    
    <tr bgcolor="#CCCCCC">
      <td></td>
     </tr>
      <!--
      <td bgcolor="#CCCCCC"><select name="cmbHall" id="cmbHall">
				  <option value="0">Select Hostel</option>
		            <?php
				/*do {  
				?>
				            <option value="<?php echo $row_Hostel['HID']?>"><?php echo $row_Hostel['HName']?></option>
				              <?php
		} while ($row_Hostel = mysql_fetch_assoc($Hostel));
		  $rows = mysql_num_rows($Hostel);
		  if($rows > 0) {
		      mysql_data_seek($Hostel, 0);
			  $row_Hostel = mysql_fetch_assoc($Hostel);
		  }*/
		?>
		 </select></td>
    </tr>-->
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Block:</div></th>
      <td bgcolor="#CCCCCC"><select name="cmbBlock" id="cmbBlock">
      
				  <option value="0">Select Block</option>
		            <?php
				do {  
				?>
				<option value="<?php echo $row_Block['BName'];?>"><?php echo $row_Block['HID'].' - '.$row_Block['BName']?></option>		
				<?php 
		} while ($row_Block = mysqli_fetch_assoc($Block));
		  $rows = mysqli_num_rows($Block);
		  if($rows > 0) {
		      mysqli_data_seek($Block, 0);
			  $row_Block = mysqli_fetch_assoc($Block);
		  }
		?>
		 </select></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Floor:</div></th>
      <td><input name="txtFlr" type="text" id="txtFlr" size="40"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row">&nbsp;</th>
      <td><div align="center">
		<input type="hidden" name="cmbHall" value="<?php echo $hostel?>">
        <input type="submit" name="Submit" value="Add Record">
      </div></td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="frmInst">
    
</form>
<?php
	}	
	}
 } 
if (isset($_GET['edit'])){
#get post variables
$key = $_GET['edit'];
$rumber = $_GET['rnumber'];
mysqli_select_db($zalongwa, $database_zalongwa);
$query_instEdit = "SELECT * FROM room WHERE HID='$key' AND RNumber='$rumber'";
$instEdit = mysqli_query($zalongwa, $query_instEdit) or die(mysqli_error());
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
      <th nowrap scope="row"><div align="right">Room Number:</div></th>
      <td><?php echo $row_instEdit['RNumber']; ?><input name="txtRNumber" type="hidden" id="txtRNumber" value="<?php echo $row_instEdit['RNumber']; ?>"></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Capacity:</div></th>
      <td><input name="txtCapacity" type="text" id="txtCapacity" value="<?php echo $row_instEdit['Capacity']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Hostel: </div></th>
      <td><?php echo $row_instEdit['HID']; ?><input name="txtHall" type="hidden" id="txtHall" value="<?php echo $row_instEdit['HID']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right">Block:</div></th>
      <td><input name="txtBlock" type="text" id="txtBlock" value="<?php echo $row_instEdit['BID']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th nowrap scope="row"><div align="right"> Floor:</div></th>
      <td><input name="txtFlr" type="text" id="txtFlr" value="<?php echo $row_instEdit['FloorName']; ?>" size="40" ></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <th scope="row"><input name="id" type="hidden" id="id" value="<?php echo $key ?>"><input name="id" type="hidden" id="id" value="<?php echo $rumber ?>"></th>
      <td><div align="center">
        <input type="submit" name="edit" value="Edit Record">
      </div></td>
    </tr>
  </table>
      <input type="hidden" name="MM_update" value="frmInstEdit">
</form>
  <?php
}
	# include the footer
	include("../footer/footer.php");

@mysqli_free_result($inst);

@mysqli_free_result($instEdit);
?>
