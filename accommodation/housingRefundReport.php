<?php
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Financial Reports';
	$szSubSection = 'Refund Candidate';
	$szTitle = 'Refund Candidate';
	include('admissionheader.php');

	//display privious refund report
if(isset($_GET['id'])){
$key = $_GET['id'];
$qrefunded = "SELECT * FROM tblcautionfee WHERE (RegNo = '$key' AND Paytype > 9) Order By Received Desc";
$refunded = mysql_query($qrefunded);
$num_row_refunded = mysql_num_rows($refunded);
if ($num_row_refunded > 0) {
		?>
		This Candidate was Previously Refunded the Following:
<table border='1'cellpadding='0' cellspacing='0' bordercolor='#006600'>
	<tr>
		<td><strong>S/No. </strong></td>
		<td><strong>RegNo</strong></td>
		<td><strong> Amount </strong></td>
		<td><strong>PayType</strong></td>
		<td><strong>Recorded</strong></td>
		<td><strong>Recorder</strong></td>
		<td><strong>Comments</strong></td>
	</tr>
	<?php 
	$i=1;
	
		while($row_refunded = mysql_fetch_assoc($refunded)) {
			//search payment category
			$pay=$row_refunded['Paytype'];
			$qpay="select Description from paytype where Id='$pay'";
			$dbpay=mysql_query($qpay);
			$row_pay=mysql_fetch_assoc($dbpay);
			//print student report
			?>
			<tr>
				<td> <?php echo $i ?> </td>
				<td> <?php echo $row_refunded['RegNo'] ?> </td>
				<td> <?php echo $row_refunded['Amount'] ?> </td>
				<td nowrap> <?php echo $row_pay['Description'] ?></td>
				<td nowrap> <?php echo $row_refunded['Received'] ?></td>
				<td> <?php echo $row_refunded['user'] ?></td>
			    <td nowrap> <?php echo $row_refunded['Description'] ?></td>
			</tr>
    	<? 
		$i=$i+1;
		}
	?> 
		</table> 
	<?php
	//exit;
  }
 }
	# include the footer
	include('../footer/footer.php');
?>