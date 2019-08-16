<?php 
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
# include the header
	include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Accommodation';
	$szTitle = 'Room Allocation for the Current Year ';
	$szSubSection = 'Current Allocation';
	//$additionalStyleSheet = './general.css';
	include('admissionheader.php');
	

//get current year
$qyear="SELECT AYear FROM academicyear WHERE Status=1";	
$dbyear = mysql_query($qyear) or die("No Single year umeliwa");
$row_year = mysql_fetch_array($dbyear);
$currentyear = $row_year['AYear'];

# get all users
$quser="SELECT RegNo FROM allocation WHERE AYear='$currentyear' ORDER BY HID,RegNo";	
$dbuser = mysql_query($quser) or die("No Single User umeliwa");
$dbusertenant = mysql_query($quser) or die("No Single User Hujaliwa");
$row_usertenant = mysql_fetch_array($dbuser);
		
$sn = 0;
	?>
	<table width="200" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="center"><strong>S/No</strong></div></td>
					 <td><div align="left"><strong>Name</strong></div></td>
                    <td nowrap><div align="center"><strong>RegNo</strong></div></td>
					<td nowrap><div align="center"><strong>RoomNo</strong></div></td>
					<td><div align="center"><strong>Hostel</strong></div></td>
					<td><div align="center"><strong>Year</strong></div></td>
                  </tr>
	<?php
	while($row_user = mysql_fetch_array($dbusertenant)){

		$regno= $row_user['RegNo'];
		$qtenant = "SELECT student.Name, allocation.RegNo, hostel.HName, allocation.RNumber, allocation.AYear, hostel.HID
                    FROM (allocation INNER JOIN student ON allocation.RegNo = student.RegNo) INNER JOIN hostel ON allocation.HID = hostel.HID
		            WHERE (allocation.RegNo='$regno') ORDER BY hostel.HName, allocation.RegNo ";
		$dbtenant = mysql_query($qtenant) or die("No Single User");
		$total_rows = mysql_num_rows($dbtenant);
		if($total_rows==1){
		$sn = $sn+1;
			$row_tenant = mysql_fetch_array($dbtenant);
			$tenantname= $row_tenant['Name'];
			$room= $row_tenant['RNumber'];
			$hall= $row_tenant['HName'];
			$mwaka= $row_tenant['AYear'];
			?>
			 <tr>
						<td><div align="center"><?php echo $sn?></div></td>
						<td nowrap><div align="left"><?php echo $tenantname?></div></td>
						<td nowrap><div align="center"><?php echo $regno?></div></td>
						<td nowrap><div align="right"><?php echo $room?></div></td>
						<td nowrap><div align="left"><?php echo $hall?></div></td>
						<td><div align="center"><?php echo $mwaka?></div></td>
					  </tr>
			<?php
		}
}
	echo "</table>";

?>