<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Financial Reports';
	$szSubSection = 'Payment Reports';
	$szTitle = 'Candidates Payment Reports';
	include('admissionheader.php');

if (isset($_POST["AYear"])){
$year=addslashes($_POST["AYear"]);

#Get all student in this cohot
$qstudent = "SELECT Name, RegNo from student WHERE EntryYear = '$year'";
$dbstudent = mysqli_query($zalongwa,$qstudent);
$totalstudent = mysqli_num_rows($dbstudent);

 if ($totalstudent > 0) {
	?>
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>

	<span class="style1">Caution Fees and Penalty Charges Reports:</span> <br>
	<strong>Candidates Started On: 
	<?=$year?>
	</strong>
	<table border='1'cellpadding='0' cellspacing='0' bordercolor='#006600'>
	<tr>
		<td><strong>S/No. </strong></td>
		<td nowrap><strong>Candidate Name </strong></td>
		<td nowrap><strong>RegNo</strong></td>
		<td nowrap><strong> Caution Fee </strong></td>
		<td><strong> Penalty</strong></td>
		<td><strong>Balance </strong></td>
		<td><strong>Refunded </strong></td>
	</tr>
	<?php 
	$i=1;
	$grandtotalpaid=0;
	$grandtotalpenalty=0;
		
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			$totalpaid =0;
						
			//query caution fee paid
			$qcautionfee = "SELECT Amount FROM tblcautionfee WHERE RegNo = '$regno' AND Paytype = 2";
			$dbcautionfee = mysqli_query($zalongwa,$qcautionfee);
						
			//sum up caution fee payments
			while ($rowcautionfee = mysqli_fetch_array($dbcautionfee)){
				$amount = $rowcautionfee['Amount'];
				$totalpaid = $totalpaid+$amount;
				}
				$grandtotalpaid = $grandtotalpaid+$totalpaid;
			//query penalty fee paid
			$qpenalty = "SELECT Amount FROM tblcautionfee WHERE RegNo = '$regno' AND Paytype = 3";
			$dbpenalty = mysqli_query($zalongwa,$qpenalty);
			$totalpenalty =0;
			
			//sum up penalty payments
			while ($rowpenalty = mysqli_fetch_array($dbpenalty)){
				$penaltyamount = $rowpenalty['Amount'];
				$totalpenalty = $totalpenalty+$penaltyamount;
				}
				$grandtotalpenalty=$grandtotalpenalty+$totalpenalty;
			//print student report
			if(number_format($totalpaid - $totalpenalty,2,'.',',')>0){
			?>
			<tr>
				<td> <?php echo $i ?> </td>
				<td nowrap> <?php echo $name ?> </td>
				<td nowrap> <?php echo $regno ?> </td>
				<td> <?php echo number_format($totalpaid,2,'.',',') ?> <div align="right"></div></td>
				<td> <?php echo number_format($totalpenalty,2,'.',',') ?> <div align="right"></div></td>
				<td> <?php echo number_format($totalpaid - $totalpenalty,2,'.',',') ?> <div align="right"></div></td>
			  <td nowrap> 
			  <?php $qrefund = "select RegNo FROM tblcautionfee WHERE (RegNo = '$regno' AND Paytype > 9) Order By Received Desc";
			  		$refund = mysqli_query($zalongwa,$qrefund);
					$row_refund= mysqli_fetch_array($refund);
					$row_num = mysqli_num_rows($refund);
						if($row_num>0){
									echo "<a href=\"housingRefundReport.php?id=$regno\">Yes</a>";
									}else{
									echo "No";
							}					
			   ?> 
			  <div align="right"></div></td>
			</tr>
    	<? 
		$i=$i+1;
		}
	}
 }?> 
	<tr>
	<td colspan="3"><strong>Grand Total: </strong></td>
	<td><div align="right"><strong><?php echo number_format($grandtotalpaid,2,'.',',') ?></strong> </div></td>
	<td><div align="right"><strong><?php echo number_format($grandtotalpenalty,2,'.',',') ?></strong></div></td>
	<td><div align="right"><strong><?php echo number_format($grandtotalpaid-$grandtotalpenalty,2,'.',',') ?></strong></div></td>
	</tr>
	</table> 
	<?php
	exit;
 } 			

#process Rental Charges Report

if (isset($_POST["RentalAYear"])){
$year=addslashes($_POST["RentalAYear"]);

#Get all student in this cohot
$qstudent = "SELECT Name, RegNo from student WHERE EntryYear = '$year' ORDER BY Name ASC";
$dbstudent = mysqli_query($zalongwa,$qstudent);
$totalstudent = mysqli_num_rows($dbstudent);

 if ($totalstudent > 0) {
	?>
		<span class="style1">Accommodation Rental Charges Reports:</span> <br>
	<strong>Candidates Started On: 
	<?=$year?>
	</strong>
	<table border='1'cellpadding='0' cellspacing='0' bordercolor='#006600'>
	<tr>
		<td><strong>S/No. </strong></td>
		<td><strong>Candidate Name </strong></td>
		<td><strong>RegNo</strong></td>
		<td><strong> Amount </strong></td>
		<td><strong> Receipt No</strong></td>
		<td><strong>Receipt Date </strong></td>
		<td><strong>Recorder </strong></td>
		<td><strong>Recorded On </strong></td>
	</tr>
	<?php 
	$i=1;
	$grandtotalpaid=0;
	$totalpaid =0;
	while($rowstudent = mysqli_fetch_array($dbstudent)) {
			$name = $rowstudent['Name'];
			$regno = $rowstudent['RegNo'];
			
						
			//query caution fee paid
			$qcautionfee = "SELECT * FROM tblcautionfee WHERE RegNo = '$regno' AND Paytype = 1";
			$dbcautionfee = mysqli_query($zalongwa,$qcautionfee);
			$rowcautionfee = mysqli_fetch_array($dbcautionfee);
						
					
			//print student report
			if (intval($rowcautionfee['Amount'])>0){
			?>
			<tr>
				<td> <?php echo $i ?> </td>
				<td nowrap>  <?php echo $name ?> </td>
				<td nowrap>  <?php echo $regno ?> </td>
				<td nowrap>  <?php echo $rowcautionfee['Amount'];
										$amount = $rowcautionfee['Amount'];
										$totalpaid = $totalpaid+$amount;
				//number_format($totalpaid,2,'.',',') ?> <div align="right"></div></td>
				<td nowrap>  <?php echo $rowcautionfee['ReceiptNo'] ?> <div align="right"></div></td>
				<td nowrap>  <?php echo $rowcautionfee['ReceiptDate'] ?> <div align="right"></div></td>
				<td nowrap>  <?php echo $rowcautionfee['user'] ?> <div align="right"></div></td>
				<td nowrap>  <?php echo $rowcautionfee['Received'] ?> <div align="right"></div></td>
				
	  </tr>
    	<? 
		$i=$i+1;
		}
	}
 }?> 
	<tr>
	<td colspan="3"><strong>Grand Total: </strong></td>
	<td><div align="right"><strong><?php echo number_format($totalpaid,2,'.',',') ?></strong> </div></td>
	<td colspan="5"><strong>End of Report </strong></td>
	</tr>
	</table> 
	<?php
	exit;
 } 			


#process Search Results Report
if (isset($_POST["candidate"])){
@$key=trim($_POST["candidate"]);
@$query_cautionfeepaid = "SELECT student.Name, 
							  student.ProgrammeofStudy, 
							  student.EntryYear, 
							  tblcautionfee.RegNo, 
							  tblcautionfee.Amount, 
							  tblcautionfee.ReceiptNo, 
							  tblcautionfee.Paytype, 
							  tblcautionfee.ReceiptDate, 
							  tblcautionfee.Received, 
							  tblcautionfee.user,
							  tblcautionfee.Description 
						FROM student 
						INNER JOIN tblcautionfee ON 
								student.RegNo = tblcautionfee.RegNo 
						WHERE (student.RegNo = '$key') 
								ORDER BY tblcautionfee.Received DESC";
@$cautionfeepaid = mysqli_query($zalongwa,$query_cautionfeepaid) or die(mysqli_error());
@$row_cautionfeepaid = mysqli_fetch_assoc($cautionfeepaid);
@$totalRows_cautionfeepaid = mysqli_num_rows($cautionfeepaid);
}

mysqli_select_db($zalongwa,$database_zalongwa);
$query_Ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$Ayear = mysqli_query($zalongwa,$query_Ayear) or die(mysqli_error());
$row_Ayear = mysqli_fetch_assoc($Ayear);
$totalRows_Ayear = mysqli_num_rows($Ayear);

?>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="search" id="search">
			<fieldset>
   			 <legend>Search Candidate </legend>
   			 <table width="200" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td nowrap><div align="right"><strong>Enter RegNo:</strong></div></td>
    <td><input name="candidate" type="text" id = "candidate" value="" size = "25" maxlength="20"></td>
    <td><input type="submit" name="Submit" value="GO"></td>
  </tr>
</table>
</fieldset>
</form>
			 
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="yearsearchform" id="yearsearchform">
			<fieldset>
   			 <legend>Caution Fee and Penalty Charges Report </legend>
              <table width="449" border="0" align="right" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                <tr>
                  <td width="251" height="2" nowrap bgcolor="#CCCCCC"><div align="right">Entry Year:</div></td>
                  <td width="114" nowrap bgcolor="#CCCCCC"><select name="AYear" id="AYear">
				  <option value="0">SelectEntryYear</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_Ayear['AYear']?>"><?php echo $row_Ayear['AYear']?></option>
                    <?php
} while ($row_Ayear = mysqli_fetch_assoc($Ayear));
  $rows = mysqli_num_rows($Ayear);
  if($rows > 0) {
      mysqli_data_seek($Ayear, 0);
	  $row_Ayear = mysqli_fetch_assoc($Ayear);
  }
?>
                  </select>
                  </td>
                  <td width="84" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <tr>
                  <td height="2" nowrap bgcolor="#CCCCCC"><div align="right">Graduate Year: </div></td>
                  <td width="114" nowrap bgcolor="#CCCCCC"><select name="GYear" id="GYear">
				  <option value="0">Graduation Year</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_Ayear['AYear']?>"><?php echo $row_Ayear['AYear']?></option>
                    <?php
} while ($row_Ayear = mysqli_fetch_assoc($Ayear));
  $rows = mysqli_num_rows($Ayear);
  if($rows > 0) {
      mysqli_data_seek($Ayear, 0);
	  $row_Ayear = mysqli_fetch_assoc($Ayear);
  }
?>
                  </select></td>
                  <td width="84" nowrap bgcolor="#CCCCCC"><input name="search" type="submit" id="search3" value="Print Report"></td>
                </tr>
                <tr>
                  <td colspan="3">                        <div align="left">
                  </div></td>
                </tr>
            </table>
  </fieldset>
</form>

<!-- Filtering form for Rental Charges -->
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="yearsearchform" id="yearsearchform">
			<fieldset>
   			 <legend>Accommodation Rental Charges Report </legend>
              <table width="449" border="0" align="right" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                <tr>
                  <td width="251" height="2" nowrap bgcolor="#CCCCCC"><div align="right">Entry Year:</div></td>
                  <td width="114" nowrap bgcolor="#CCCCCC"><select name="RentalAYear" id="RentalAYear">
				  <option value="0">SelectEntryYear</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_Ayear['AYear']?>"><?php echo $row_Ayear['AYear']?></option>
                    <?php
} while ($row_Ayear = mysqli_fetch_assoc($Ayear));
  $rows = mysqli_num_rows($Ayear);
  if($rows > 0) {
      mysqli_data_seek($Ayear, 0);
	  $row_Ayear = mysqli_fetch_assoc($Ayear);
  }
?>
                  </select>
                  </td>
                  <td width="84" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <tr>
                  <td height="2" nowrap bgcolor="#CCCCCC"><div align="right">Graduate Year: </div></td>
                  <td width="114" nowrap bgcolor="#CCCCCC"><select name="RentalGYear" id="RentalGYear">
				  <option value="0">Graduation Year</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_Ayear['AYear']?>"><?php echo $row_Ayear['AYear']?></option>
                    <?php
} while ($row_Ayear = mysqli_fetch_assoc($Ayear));
  $rows = mysqli_num_rows($Ayear);
  if($rows > 0) {
      mysqli_data_seek($Ayear, 0);
	  $row_Ayear = mysqli_fetch_assoc($Ayear);
  }
?>
                  </select></td>
                  <td width="84" nowrap bgcolor="#CCCCCC"><input name="search" type="submit" id="search3" value="Print Report"></td>
                </tr>
                <tr>
                  <td colspan="3">                        <div align="left">
                  </div></td>
                </tr>
            </table>
  </fieldset>
</form>
            
            <?php if (@$totalRows_cautionfeepaid > 0) {  echo @"Payment Report for Candidate:  \"$key \" <hr>"; // Show if recordset not empty 
			//search degree code
			$dcode=$row_cautionfeepaid['ProgrammeofStudy'];
			$qdegree="select ProgrammeName from programme where ProgrammeCode='$dcode'";
			$dbdegre = mysqli_query($zalongwa,$qdegree);
			$row_degree=mysqli_fetch_assoc($dbdegre);
			
						
		 echo $row_cautionfeepaid['Name'].": ".$row_cautionfeepaid['RegNo']."; ".$row_degree['ProgrammeName']; ; ?>
            <table width="200" border="1" cellpadding="0" cellspacing="0">
              <tr>
                 <td nowrap><strong> Category </strong></td>
				 <td nowrap><strong>Amount</strong></td>
				  <td nowrap><strong>Receipt No. </strong></td>
				  <td nowrap><strong>Receipt Date </strong></td>
                <td nowrap><strong> Recorded On </strong></td>
				<td nowrap><strong> Recorder </strong></td>
				<td nowrap><strong> Description </strong></td>
              </tr>
			  
			  <?php $amount =0;
			  		$penalty = 0;
					$balance =0;
			  ?>
              <?php do { 
			  
					//search payment category
					$pay=$row_cautionfeepaid['Paytype'];
					$qpay="select Description from paytype where Id='$pay'";
					$dbpay=mysqli_query($zalongwa,$qpay);
					$row_pay=mysqli_fetch_assoc($dbpay);
			  ?>
              <tr>
                <td nowrap><?php  echo $row_pay['Description']; ?></td>
				<td nowrap><?php echo $row_cautionfeepaid['Amount']; ?></td>
                <td nowrap><?php  echo $row_cautionfeepaid['ReceiptNo']; ?></td>
				<td nowrap><?php  echo $row_cautionfeepaid['ReceiptDate']; ?></td>
				<td nowrap><?php  echo $row_cautionfeepaid['Received']; ?></td>
				<td nowrap><?php  echo $row_cautionfeepaid['user']; ?></td>
                <td><?php echo $row_cautionfeepaid['Description'];?></td>
              </tr>
              <?php 
			  } while ($row_cautionfeepaid = mysqli_fetch_assoc($cautionfeepaid)); ?>
</table>
            <?php }?>
            
<?php
@

mysqli_free_result($cautionfeepaid);

mysqli_free_result($Ayear);
?>
