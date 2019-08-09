<?php
if(isset($_POST['print']))
{
	$Eq=$_POST[Eq];
	$count=count($Eq);
	if($count<=0)
	{
	echo "<table>
	<tr><td>
	<font color='red'>Choose Student please.</font>
	</td></tr>
	</table>";
	}
	else
	{
	$e=1;
	for($j=0;$j<$count;$j++)
	{
		#Fetch Records
		$sql = "SELECT * FROM student WHERE Id ='$Eq[$j]'"; 
		$update = mysql_query($sql);
		$update_row = mysql_fetch_array($update);
		$regno = addslashes($update_row['RegNo']);
		$stdid = addslashes($update_row['Id']);
		$AdmissionNo = addslashes($update_row['AdmissionNo']);     
		$degree = addslashes($update_row['ProgrammeofStudy']);
		$faculty = addslashes($update_row['Faculty']);
		$ayear = addslashes($update_row['EntryYear']);
		$combi = addslashes($update_row['Subject']);
		$campus = addslashes($update_row['Campus']);
		$manner = addslashes($update_row['MannerofEntry']);
		$surname = addslashes($update_row['Name']);
		$dtDOB = addslashes($update_row['DBirth']);
		$age = addslashes($update_row['age']);
		$sex = addslashes($update_row['Sex']);
		$sponsor = addslashes($update_row['Sponsor']);
		$country = addslashes($update_row['Nationality']);
		$district =addslashes($update_row['District']);
		$region =addslashes($update_row['Region']);
		$maritalstatus = addslashes($update_row['MaritalStatus']);
		$address = addslashes($update_row['Address']);
		$religion = addslashes($update_row['Religion']);
		$denomination = addslashes($update_row['Denomination']);
		$postaladdress =addslashes($update_row['postaladdress']);
		$residenceaddress = addslashes($update_row['residenceaddress']);
		$disabilityCategory = addslashes($update_row['disabilityCategory']);
		$status = addslashes($update_row['Status']);
		$gyear = addslashes($update_row['GradYear']);
		$phone1 = addslashes($update_row['Phone']);
		$email1 = addslashes($update_row['Email']);
		$formsix = addslashes($update_row['formsix']);
		$formfour = addslashes($update_row['formfour']);
		$diploma = addslashes($update_row['diploma']);
		$School_attended_olevel = addslashes($update_row['School_attended_olevel']);
		$School_attended_alevel =addslashes($update_row['School_attended_alevel']);
		$name = $surname;//", ".$firstname." ".$middlename;
		//Added fields
		$account_number=addslashes($update_row['account_number']);
		$bank_branch_name=addslashes($update_row['bank_branch_name']);
		$bank_name=addslashes($update_row['bank_name']);
		$form4no=addslashes($update_row['form4no']);
		$form4name=addslashes($update_row['form4name']);
		$form6name=addslashes($update_row['form6name']);
		$form6no=addslashes($update_row['form6no']);
		$form7name=addslashes($update_row['form7name']);
		$form7no=addslashes($update_row['form7no']);
		$paddress=addslashes($update_row['paddress']);
		$currentaddaress=addslashes($update_row['currentaddaress']);
		$f4year=addslashes($update_row['f4year']);
		$f6year=addslashes($update_row['f6year']);
		$f7year=addslashes($update_row['f7year']);
		#next of kin info
		$kin=addslashes($update_row['kin']);
		$kin_phone=addslashes($update_row['kin_phone']);
		$kin_address=addslashes($update_row['kin_address']);
		$kin_job=addslashes($update_row['kin_job']);
		$studylevel=addslashes($update_row['studylevel']);
		$ActUser=$_SESSION['username'];
		$Action="Deleted";
		//***********             
		 #print lables
		
		/*------------------------------------------------
		To create the object, 2 possibilities:
		either pass a custom format via an array
		or use a built-in AVERY name
		------------------------------------------------*/
		
		// Example of custom format
		// $pdf = new PDF_Label(array('paper-size'=>'A4', 'metric'=>'mm', 'marginLeft'=>1, 'marginTop'=>1, 'NX'=>2, 'NY'=>7, 'SpaceX'=>0, 'SpaceY'=>0, 'width'=>99, 'height'=>38, 'font-size'=>14));
		
		// Standard format
		require('../includes/PDF_Label.php');
		$pdf = new PDF_Label('L7163');
		
		$pdf->AddPage();
		
		// Print labels
		for($i=1;$i<=20;$i++) {
			$text = sprintf("%s\n%s\n%s\n%s %s, %s", "Laurent $i", 'Immeuble Toto', 'av. Fragonard', '06000', 'NICE', 'FRANCE');
			$pdf->Add_Label($text);
		}
	
		 $pdf->Output();
		# end of label printing
		
	}
}
?>