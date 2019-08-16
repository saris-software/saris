<?php 
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
# include the header
	include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Accommodation';
	$szTitle = 'Room Application Form';
	$szSubSection = 'Application Form';
	//$additionalStyleSheet = './general.css';
	include('admissionheader.php');
	
mysql_select_db($database_zalongwa, $zalongwa);
$query_AllocationCriteria = "SELECT CriteriaID, ShortName FROM criteria";
$AllocationCriteria = mysql_query($query_AllocationCriteria, $zalongwa) or die(mysql_error());
$row_AllocationCriteria = mysql_fetch_assoc($AllocationCriteria);
$totalRows_AllocationCriteria = mysql_num_rows($AllocationCriteria);

mysql_select_db($database_zalongwa, $zalongwa);
$query_Hostel = "SELECT HID, HName FROM hostel";
$Hostel = mysql_query($query_Hostel, $zalongwa) or die(mysql_error());
$row_Hostel = mysql_fetch_assoc($Hostel);
$totalRows_Hostel = mysql_num_rows($Hostel);

mysql_select_db($database_zalongwa, $zalongwa);
$query_RoomApplication = "SELECT RegNo, AppYear, AllCriteria, Hall FROM roomapplication";
$RoomApplication = mysql_query($query_RoomApplication, $zalongwa) or die(mysql_error());
$row_RoomApplication = mysql_fetch_assoc($RoomApplication);
$totalRows_RoomApplication = mysql_num_rows($RoomApplication);

mysql_select_db($database_zalongwa, $zalongwa);
$query_AYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AYear = mysql_query($query_AYear, $zalongwa) or die(mysql_error());
$row_AYear = mysql_fetch_assoc($AYear);
$totalRows_AYear = mysql_num_rows($AYear);
	
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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "editstudentRoomApplication")) {
#get criteria
$criteria = addslashes($_POST['AllCriteria']);
$regno = addslashes($_POST['regno']);
$appyear = addslashes($_POST['AppYear']);

$qupdate ="UPDATE roomapplication SET AllCriteria = '$criteria' WHERE RegNo='$regno' AND AppYear ='$appyear'";
$dbupdate = mysql_query($qupdate);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "studentRoomApplication")) {
//get academic year
$year = $_POST['AppYear'];
//query current Year
$qyear = "SELECT AYear from academicyear WHERE Status = 1";
$dbyear = mysql_query($qyear);
$row_year = mysql_fetch_assoc($dbyear);
$currentYear = $row_year['AYear'];
if($currentYear<>$year){
echo "You cannot Apply for This Year:".$year."<br> Application Rejected";
exit;
}else{
$regno = addslashes($_POST['regno']);
$appyear = addslashes($_POST['AppYear']);
//validate this regno
$qregno =  "select Name, RegNo from student where RegNo='$regno'";
$dbregno=mysql_query($qregno);
if(mysql_num_rows($dbregno)>0){
	#check if is already applied
	$qapp ="SELECT * FROM roomapplication WHERE RegNo='$regno' AND AppYear = '$appyear'";
	$dbapp = mysql_query($qapp);
	$app_total = mysql_num_rows($dbapp);
	if($app_total>0){
	$app_rows = mysql_fetch_assoc($dbapp);
	$criteria = $app_rows['AllCriteria'];
	$app_AllocationCriteria = "SELECT CriteriaID, ShortName FROM criteria WHERE CriteriaID = '$criteria'";
	$Criteria = mysql_query($app_AllocationCriteria, $zalongwa) or die(mysql_error());
	$row_Criteria = mysql_fetch_assoc($Criteria);
	echo 'OOPS! The RegNo '.$app_rows['RegNo'].' is already applied !';
	?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="editstudentRoomApplication" id="editstudentRoomApplication">
            <table width="284" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
               <tr bordercolor="#666666">
          <td nowrap bgcolor="#CCCCCC"><div align="right">Application Year:</div></td>
          <td width="157" bgcolor="#CCCCCC"><span class="style67">              
            <select name="AppYear" id="AppYear">
			<option value="<?php echo $app_rows['AppYear']?>"><?php echo $app_rows['AppYear']?></option>
               <?php
do {  
?>
              <option value="<?php echo $row_AYear['AYear']?>"><?php echo $row_AYear['AYear']?></option>
              <?php
} while ($row_AYear = mysql_fetch_assoc($AYear));
  $rows = mysql_num_rows($AYear);
  if($rows > 0) {
      mysql_data_seek($AYear, 0);
	  $row_AYear = mysql_fetch_assoc($AYear);
  }
?>
		  </select>
</span></td>
        </tr>
        <tr bordercolor="#666666">
          <td nowrap bgcolor="#CCCCCC"><div align="right"> RegNo:</div></td>
          <td bgcolor="#CCCCCC">          
			   <div style="position: relative; margin: 5px 0 5px 0; height: 30px;"> 
				 <div style="position: absolute; top: 0; left: 0; width: 200px; z-index: 1;">
				<input type="text" name="sug_regno" style="background-color: #fff; border: 1px solid #999; width: 200px; padding: 2px" disabled /> 
				 </div> 
				  <div style="position: absolute; top: 0; left: 0; width: 200px; z-index: 2;">
				  <input autocomplete="off" type="text" name="regno" value ="<?=$app_rows['RegNo']?>" style="background: none; color:#39f; border: 1px solid #999; width: 200px; padding: 2px">
		</td>        
		</tr>
        <tr bordercolor="#666666">
          <td nowrap bgcolor="#CCCCCC"><div align="right">Applicantion Category : </div></td>
          <td bgcolor="#CCCCCC"><select name="AllCriteria" id="select2">
              <option value="<?php echo $row_Criteria['CriteriaID']?>"><?php echo $row_Criteria['ShortName']?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_AllocationCriteria['CriteriaID']?>"><?php echo $row_AllocationCriteria['ShortName']?></option>
              <?php
} while ($row_AllocationCriteria = mysql_fetch_assoc($AllocationCriteria));
  $rows = mysql_num_rows($AllocationCriteria);
  if($rows > 0) {
      mysql_data_seek($AllocationCriteria, 0);
	  $row_AllocationCriteria = mysql_fetch_assoc($AllocationCriteria);
  }
?>
          </select></td>
        </tr>
        <tr bordercolor="#666666">
          <td nowrap bgcolor="#CCCCCC"><div align="right">Any Details:</div></td>
          <td bgcolor="#CCCCCC"><textarea name="Hall" value ="<?=$app_rows['Hall']?>" cols="48" rows="4" wrap="VIRTUAL" id="Hall" >

</textarea></td>
        </tr>
        <tr bordercolor="#666666">
          <td bgcolor="#CCCCCC"><div align="right">Submit to Save: </div></td>
          <td bordercolor="#000099" bgcolor="#CCCCCC">Please Re-check Your Entries; Should Any Form of Cheating Found, Your Application Will be Rejected 
            <input type="submit" name="Submit" value="Edit Form"></td>
        </tr>
  </table>
                    <p>
                      <input type="hidden" name="MM_insert" value="editstudentRoomApplication">
                    </p>
                    </form>
	
	<?php
	exit;
	}else{
			$insertSQL = sprintf("INSERT INTO roomapplication (RegNo, AppYear, AllCriteria, Hall, Received, Processed) VALUES (%s, %s, %s, %s, now(), now())",
							   GetSQLValueString($_POST['regno'], "text"),
							   GetSQLValueString($_POST['AppYear'], "date"),
							   GetSQLValueString($_POST['AllCriteria'], "text"),
							   GetSQLValueString($_POST['Hall'], "text"));
		  mysql_select_db($database_zalongwa, $zalongwa);
		  $Result1 = mysql_query($insertSQL, $zalongwa);
 	 }
  }else{
  echo 'OOPS! The RegNo '.$regno.' Does not Exist !';
  }
 }			
  $insertGoTo = "roomApplicationform.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
}


$leo = date("F");
if ($leo = 'January'|| $leo ='February' ||$leo='March'||$leo='April'||$leo='May'||$leo='June'){
	$today = date("Y")-1; 
	$kesho = date("Y"); 
}else{
	$today = date("Y"); 
	$kesho = date("Y")+1; 
}
?>

<form action="<?php echo $editFormAction; ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">
            <table width="284" border="1" cellpadding="0" cellspacing="0" bordercolor="#006600">
               <tr bordercolor="#666666">
          <td nowrap bgcolor="#CCCCCC"><div align="right">Application Year:</div></td>
          <td width="157" bgcolor="#CCCCCC"><span class="style67">              
            <select name="AppYear" id="AppYear">
               <?php
do {  
?>
              <option value="<?php echo $row_AYear['AYear']?>"><?php echo $row_AYear['AYear']?></option>
              <?php
} while ($row_AYear = mysql_fetch_assoc($AYear));
  $rows = mysql_num_rows($AYear);
  if($rows > 0) {
      mysql_data_seek($AYear, 0);
	  $row_AYear = mysql_fetch_assoc($AYear);
  }
?>
		  </select>
</span></td>
        </tr>
        <tr bordercolor="#666666">
          <td nowrap bgcolor="#CCCCCC"><div align="right"> RegNo:</div></td>
          <td bgcolor="#CCCCCC"> <input name ="regno" id = "regno" type = "text"></td>
		</tr>
        <tr bordercolor="#666666">
          <td nowrap bgcolor="#CCCCCC"><div align="right">Applicantion Category : </div></td>
          <td bgcolor="#CCCCCC"><select name="AllCriteria" id="select2">
              <?php
do {  
?>
              <option value="<?php echo $row_AllocationCriteria['CriteriaID']?>"><?php echo $row_AllocationCriteria['ShortName']?></option>
              <?php
} while ($row_AllocationCriteria = mysql_fetch_assoc($AllocationCriteria));
  $rows = mysql_num_rows($AllocationCriteria);
  if($rows > 0) {
      mysql_data_seek($AllocationCriteria, 0);
	  $row_AllocationCriteria = mysql_fetch_assoc($AllocationCriteria);
  }
?>
          </select></td>
        </tr>
        <tr bordercolor="#666666">
          <td nowrap bgcolor="#CCCCCC"><div align="right">Any Details:</div></td>
          <td bgcolor="#CCCCCC"><textarea name="Hall" cols="48" rows="4" wrap="VIRTUAL" id="Hall">

</textarea></td>
        </tr>
        <tr bordercolor="#666666">
          <td bgcolor="#CCCCCC"><div align="right">Submit to Save: </div></td>
          <td bordercolor="#000099" bgcolor="#CCCCCC">          Please Re-check Your Entries; Should Any Form of Cheating Found, Your Application Will be Rejected 
            <input type="submit" name="Submit" value="Submit  Form"></td>
        </tr>
  </table>
                    <p>
                      <input type="hidden" name="MM_insert" value="studentRoomApplication">
                    </p>
                    </form>
<?php

	# include the footer
	include("../footer/footer.php");
?>
