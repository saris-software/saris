	<style type="text/css">
		#table{
			border-radius:5px;
			background:#ceceff;
			font-family:Courier New, Monospace;
			}
		#table tr th{
			background:#bdbdd5;
			}
		#table tr td{							
			font-size:14px;
			font-family:Courier New, Monospace;
			}
		.total{
			background:#bdbdd5;
			}
	</style>
	
<?php

	#get post variables
	//$id = addslashes($_GET['id']);
	//$reg = addslashes($_GET['RegNo']);
	$edit=$_GET['edit'];
	if($edit=='yes'){
		$state1="submit";
		$state2="hidden";
		$state3="readonly";
		$state4="";
		$label_edit="";
		}
	elseif(isset($_POST['actionupdate'])){
		$state5 = "hidden";
		}
	else{
		$state5 = "hidden";
		//$state1="hidden";
		//$state2="hidden";
		//$state3="readonly";
		//$state4="disabled";
		//$label_edit="<a href='$_SERVER[PHP_SELF]?id=$id&RegNo=$reg&edit=yes'><img src='./img/edit.png' alt='Click to Edit This Record'>Edit</a>";
		}
	
	$sql = "SELECT * FROM student WHERE Id ='$id' and RegNo='$reg'"; 
	$update = mysql_query($sql);
	$update_row = mysql_fetch_array($update);
	$totalRows_update = mysql_num_rows($update);
	
	$regno = $update_row['RegNo'];
	$stdid = $update_row['Id'];
	$AdmissionNo = $update_row['AdmissionNo'];     
	$degree = $update_row['ProgrammeofStudy'];
	$faculty = $update_row['Faculty'];
	$ayear = $update_row['EntryYear'];
	$combi = $update_row['Subject'];
	$campus = $update_row['Campus'];
	$class = $update_row['Class'];
	$manner = $update_row['MannerofEntry'];
	$rawname = $update_row['Name'];
	$expsurname = explode(",",$rawname);
	$surname = strtoupper($expsurname[0]);
	$othername = $expsurname[1];
	$expothername = explode(" ", $othername);
	$firstname = $expothername[1];
	$middlename = $expothername[2].' '.$expothername[3];
	$dtDOB = $update_row['DBirth'];
	$age = $update_row['age'];
	$sex = $update_row['Sex'];
	$sponsor = $update_row['Sponsor'];
	$nationality = $update_row['Nationality'];
	$country = $update_row['Country'];
	$district =$update_row['District'];
	$region =$update_row['Region'];
	$maritalstatus = $update_row['MaritalStatus'];
	$address = $update_row['Address'];
	$religion = $update_row['Religion'];
	$denomination = $update_row['Denomination'];
	$postaladdress =$update_row['postaladdress'];
	$residenceaddress = addslashes($update_row['residenceaddress']);
	$disabilityCategory = $update_row['disabilityCategory'];
	$status = $update_row['Status'];
	$gyear = $update_row['GradYear'];
	$phone1 = $update_row['Phone'];
	$email1 = $update_row['Email'];
	$formsix = $update_row['formsix'];
	$formfour = $update_row['formfour'];
	$diploma = $update_row['diploma'];
	$School_attended_olevel = $update_row['School_attended_olevel'];
	$School_attended_alevel = $update_row['School_attended_alevel'];
	$name = $surname.", ".$firstname." ".$middlename;
	//Added fields
	$account_number=$update_row['account_number'];
	$bank_branch_name=$update_row['bank_branch_name'];
	$bank_name=$update_row['bank_name'];
	$form4no=$update_row['form4no'];
	$form4name=$update_row['form4name'];
	$form6name=$update_row['form6name'];
	$form6no=$update_row['form6no'];
	$form7name=$update_row['form7name'];
	$form7no=$update_row['form7no'];
	$paddress=$update_row['paddress'];
	$currentaddaress=$update_row['currentaddaress'];
	$f4year=$update_row['f4year'];
	$f6year=$update_row['f6year'];
	$f7year=$update_row['f7year'];
	#sponsor info
	$relative=$update_row['relative'];
	$relative_phone=$update_row['relative_phone'];
	$relative_address=$update_row['relative_address'];
	$relative_job=$update_row['relative_job'];
	#next of kin info
	$kin=$update_row['kin'];
	$kin_phone=$update_row['kin_phone'];
	$kin_address=$update_row['kin_address'];
	$kin_job=$update_row['kin_job'];
	$studylevel=$update_row['studylevel'];
	//***********             
	
	//get student payment balance status
	$regno = trim(strtoupper($regno));
	$view_type = 3;
	$inst = $pastelobj->resultCode($pastelurl, $regno, $view_type);

	form($inst);
	//chas here for insertion
	#check if RegNo Exist

//*************REGISTRATION FORM
function form($inst){
	global $state1,$state2,$state3,$label_edit,$state4,$AdmissionNo,$stdid, $studylevel;
	global $disabilityCategory,$studylevel,$father,$father_job,$mother,$mother_job,$father_address,
	$father_phone,$mother_address,$mother_phone, $postaladdress, $age,
	$brother,$brother_phone,$brother_address,$brother_job,$class,
	$sister,$sister_phone,$sister_address,$sister_job, $postaladdress, $residenceaddress,
	$spouse,$spouse_phone,$spouse_address,$spouse_job, $disability, $formsix, $formfour, $diploma,
	$kin,$kin_phone,$kin_address,$kin_job,$School_attended_olevel,$School_attended_to_alevel,$School_attended_alevel,$School_attended_from_alevel,
	$relative,$relative_phone,$relative_address,$relative_job,$School_attended_to_olevel,$School_attended_from_olevel,
	$txtYear,$txtDay,$txtMonth,$sponsor,$maritalstatus,$country,$formsix,$formfour,$diploma,$phone1,$email1,$regno,$degree,$faculty,$ayear,$combi,$campus,$manner,$byear,$bmon,$bday,$dtDOB,$surname,$firstname,$middlename,$dtDOB,$age,$sex,$sponsor,$country,$district,$region,$maritalstatus,$address,$religion,$denomination,$postaladdress,$residenceaddress,$disability,$status,$gyear,$name,$ayear,$campus,
	$kin,$kin_phone,$kin_address,$kin_job,$f4year,$f6year,$f7year, $nationality;
	global $disabilityCategory_erro,$studylevel_error,$maritalstatus_error,$date_error,$dbirth_error,$country_error,$ayear_error,$formsix_error,$formfour_error,$diploma_error,$phone1_error,$email1_error,$regno_error,$degree_error,$faculty_error,$ayear_error,$combi_error,$campus_error,$manner_error,$byear_error,$bmon_error,$bday_error,$dtDOB_error,$surname_error,$firstname_error,$middlename_error,$dtDOB_error,$age_error,$sex_error,$sponsor_error,$country_error,$district_error,$region_error,$maritalstatus_error,$address_error,$religion_error,$denomination_error,$postaladdress_error,$residenceaddress_error,$disability_error,$status_error,$gyear_error,$name_error;
	global $account_number,$bank_branch_name,$bank_name,$form4no,$form4name,$form6name,$form6no,$form7name,$form7no,$paddress,$currentaddaress;
	
	$page_redirection = $_SERVER['PHP_SELF'];
	$reg_form =<<<EOD
	<form action="$page_redirection" method="POST" name="admission">
	<table align="center" cellspacing="2" >
		<tr>
			<td>&nbsp;</td>
			<td class="zatable" style="padding-left:300px"><input name="actionupdate" type="Submit" value="Save Changes"></td>
		</tr>
	</table>
	
	<table  border="1" cellpadding="0" cellspacing="0" bordercolor="#006600" id="table">
		<tr>
			<td colspan="4" nowrap="nowrap" class="hseparator">Study Programme Information</td>
	    </tr>
	    <tr>
			<td nowrap="nowrap" class="formfield">Year of Admission:<span class="style2">*</span></td>
			<td class="ztable">
				<input type="text" name="ayear" id="ayear" value="$ayear" class="vform" style="background:gray" readonly />
				$ayear_error
			</td>
			<td nowrap="nowrap" class="formfield">Admission No:	</td>
			<td class="ztable">
				<input name="hiddenregno" type="hidden" id="hiddenregno" value = "7070" $state3 $state4 />
				<input name="stdid" type="hidden" id="stdid" value = "$stdid" $state3 $state4 />
				<input name="AdmissionNo" type="text" id="AdmissionNo" value = "$AdmissionNo"  style="background:gray" readonly />
				$regno_error
			</td>
		</tr>
		<tr>
			<td nowrap="nowrap" class="formfield">Campus:<span class="style2">*</span></td>
			<td class="ztable">
				<select name="campus" style="background:gray" readonly > 
EOD;

	if(!$campus){
		$reg_form .=<<<EOD
			<option value="">[Select Campus]</option>
EOD;
		}
	else{
		$query_campus1 = mysql_query("SELECT CampusID, Campus FROM campus where CampusID='$campus'");
		$camp=mysql_fetch_array($query_campus1);
		
		$reg_form .=<<<EOD
				<option value="$campus">$camp[Campus]</option>
EOD;
		} 
	 
	 $reg_form .=<<<EOD
				</select>
				$campus_error
			</td>
			<td class="formfield">Registration No:<span class="style2">*</span></td>
			<td class="ztable">		  
			  <input name="hiddenregno" type="hidden" id="hiddenregno" value = "7070" $state3 $state4 />
			  <input name="stdid" type="hidden" id="stdid" value = "$stdid" $state3 $state4 />
			  <input name="regno" type="text" id="regno" value = "$regno" style="background:gray" readonly />
			</td>
		</tr>
		<tr>
			<td nowrap="nowrap" class="formfield">Program Registered:<span class="style2">*</span></td> 
			<td class="ztable">
				<select name="degree" id="degree" style="background:gray" readonly >
EOD;
	
	if(!$degree){
		$reg_form .=<<<EOD
				<option value="">[Select Programme]</option>
EOD;
		}
	else{
		$take=mysql_query("select * from programme where ProgrammeCode='$degree'")or die(mysql_error());
		$t=mysql_fetch_array($take);
		
		$reg_form .=<<<EOD
				<option value="$degree">$t[ProgrammeName]</option>
EOD;
		}
	
	$reg_form .=<<<EOD
				</select>
				$degree_error
			</td>
			<td nowrap="nowrap" class="formfield" >Graduation Date:</td>
			<td class="ztable">
				<input type="text" name="dtDate" value="$gyear" style="background:gray" readonly />
				$date_error
			</td>
		</tr>
		<tr>
			<td class="formfield">Class Stream:<span class="style2">*</span></td>
			<td class="ztable">
				<select name="class" id="class" class="vform" style="background:gray" readonly >
EOD;
	
	if(!$class){
		$reg_form .=<<<EOD
				<option value="">[Select Class]</option>
EOD;
		}
	else{
		$reg_form .=<<<EOD
				<option value="$class">$class</option>
EOD;
		}
	
	$reg_form .=<<<EOD
				</select>
				$ayear_error
			</td>
			<td nowrap="nowrap" class="formfield">Sponsorship: </td>
			<td class="ztable">
				<select name="txtSponsor" id="txtSponsor" style="background:gray" readonly >
EOD;
	if(!$sponsor){
		$reg_form .=<<<EOD
				<option value="">[Select Sponsor]</option>
EOD;
		}
	else{
		$reg_form .=<<<EOD
				<option value="$sponsor">$sponsor</option>
EOD;
		}
	
	$reg_form .=<<<EOD
				</select>
				$sponsor_error
			</td>
		</tr>
		<tr>
			<td nowrap="nowrap" class="formfield">Level of Study Registered for:</td>
			<td class="ztable">
				<select name="studylevel" id="studylevel" style="background:gray" readonly >
EOD;
  
	if(!$studylevel){
		$reg_form .=<<<EOD
				<option value="">[Select Level of Study]</option>
EOD;
		}
	else{
		$take=mysql_query("select * from studylevel where LevelCode='$studylevel'");
		$t=mysql_fetch_array($take);
		
		$reg_form .=<<<EOD
				<option value="$studylevel">$t[LevelName]</option>
EOD;
		}
	  
	$reg_form .=<<<EOD
				</select>
			</td>
			<td nowrap="nowrap"class="formfield">Manner of Entry:</td>
			<td class="ztable">
				<select name="manner" id="manner" style="background:gray" readonly >
EOD;
	
	if(!$manner){
		$reg_form .=<<<EOD
				<option value="">[Select Manner of Entry]</option>
EOD;
		}
	else{
		$query_Manner =mysql_query("SELECT ID, MannerofEntry FROM mannerofentry where ID='$manner'");
		$mana=mysql_fetch_array($query_Manner);
		
		$reg_form .=<<<EOD
				<option value="$manner">$mana[MannerofEntry]</option>
EOD;
		}  
	
	$reg_form .=<<<EOD
				</select>
				$manner_error
			</td>
			</tr>
			<tr>
				<td colspan="4" nowrap="nowrap" class="hseparator">Personal Information</td>
			</tr>
			<tr>
				<td class="formfield">Surname:<span class="style2">*</span></td>
				<td class="ztable">
					<input name="surname" type="text" id="surname" value ="$surname" style="background:gray" readonly />
					$surname_error
				</td>
				<td class="formfield">Religion:</td>
				<td class="ztable">
					<select name="denomination" id="denomination" $state4  $state4 >
EOD;
 
	if(!$denomination){
		$reg_form .=<<<EOD
				<option value="">[Select Sect of Religion]</option>
EOD;
		}
	else{
		$reg_form .=<<<EOD
				<option value="$denomination">$denomination</option>
EOD;
		}  

	$query_denomination2 = "SELECT * FROM religion";
	$nr=mysql_query($query_denomination2);
	
	while($l=mysql_fetch_array($nr)){
		$query_denomination = "SELECT * FROM religion where ReligionID='$l[ReligionID]' ORDER BY Religion ASC";
		$nm=mysql_query($query_denomination);
		while($show = mysql_fetch_array($nm)){
			$reg_form .=<<<EOD
				<option value="$show[Religion]">$show[Religion]</option>
EOD;
			}
		}
	$reg_form .=<<<EOD
				</select>
				$denomination_error
			</td>
		</tr>
		<tr>
			<td class="formfield" norwap>Middlename:</td> 
			<td class="ztable">
				<input name="middlename" type="text" id="middlename" value="$middlename" style="background:gray" readonly />
				$middlename_error
			</td>
			<td class="formfield">Marital Status:</td>
			<td class="ztable">
				<select name="maritalstatus" id="maritalstatus" $state4 >
EOD;

	if($maritalstatus){
		$reg_form .=<<<EOD
				<option value="$maritalstatus">$maritalstatus</option>
EOD;
		}
	else{
		$reg_form .=<<<EOD
				<option value="">[Select Marital Status]</option>
EOD;
		}
	
	$reg_form .=<<<EOD
				<option value="Single">Single</option>
				<option value="Married">Married</option>
				<option value="Divorced">Divorced</option>
				<option value="Widowed">Widowed</option>
				</select>
				$maritalstatus_error
			</td>
		</tr>
		<tr>
			<td class="formfield">Forenames:<span class="style2">*</span></td>
			<td class="ztable">
				<input name="firstname" type="text" value="$firstname" id="firstname" style="background:gray" readonly />
				$firstname_error
			</td>
			<td class="formfield">Disability:</td>
			<td class="ztable">
				<select name='disabilityCategory' readonly $state4 >
EOD;
	
	if($disabilityCategory){
		$reg_form .=<<<EOD
				<option value="$disabilityCategory">$disabilityCategory</option>
EOD;
		}
	else{
		$reg_form .=<<<EOD
				<option value="None">[Select Disability]</option>
EOD;
		}
		 
	$query_disability3 = "SELECT * FROM disability"; 
	$nm3=mysql_query($query_disability3);
	
	while($s= mysql_fetch_array($nm3)){
		
		$reg_form .=<<<EOD
				<optgroup label="$s[Disability]">
EOD;
     	$query_disability2 = "SELECT * FROM disabilitycategory where DisabilityCode='$s[DisabilityID]'";
		$nm2 = mysql_query($query_disability2);
		
		while($show = mysql_fetch_array($nm2) ){ 	 
			$reg_form .=<<<EOD
				<option value="$show[disabilityCategory]">$show[disabilityCategory]</option>
EOD;
			}
		$reg_form .=<<<EOD
				</optgroup>
EOD;
		}       
	$reg_form .=<<<EOD
				</select>
				$disability_error
			</td>
		</tr>
			<tr><td class="formfield" norwap>Sex:<span class="style2">*</span></td>
			<td class="ztable">
				<select name="sex" id="sex" $state4 >
EOD;
	  
	if(!$sex){
		$reg_form .=<<<EOD
				<option value="">[Select Gender]</option>
EOD;
		}
	else{
		$sex_name = ($sex=='F')? "Female":"Male";
		
		$reg_form .=<<<EOD
				<option value="$sex">$sex_name</option>
EOD;
		}
	
	$reg_form .=<<<EOD
				<option value="M">Male</option>
				<option value="F">Female</option>
				</select>
				$sex_error
			</td>
			<td nowrap="nowrap" class="formfield">Permanent Address:<span class="style2">*</span>  </td>
			<td nowrap="nowrap" class="ztable">
				<input name="paddress" type="text" id="paddress" size="30" value = "$paddress" $state4 />
			</td>
		</tr>
		<tr>
			<td class="formfield">Date of Birth:</td>
			<td class="ztable">
				<input type="text" name="dtDOB" readonly value="$dtDOB" style="background:gray" readonly />
				<script language="JavaScript">
					//new tcal ({'formname': 'admission','controlname': 'dtDOB'});
				</script>
				$dbirth_error 
			</td>
			<td class="formfield">Current Address:<span class="style2">*</span></td>
			<td class="ztable">
				<input name="currentaddaress" type="text" id="currentaddaress" size="30" value="$currentaddaress" $state4 />
			</td>
		</tr>
		<tr>
			<td class="formfield">District of Birth:</td> 
			<td class="ztable">
				<input name="district" type="text" id="district" value = "$district" size="30" $state4 />
				$district_error
			</td>
			<td class="formfield">Phone:</td>
			<td class="ztable">
				<input name="phone" type="text" size="30" value = "$phone1" $state4 />
				$phone1_error
			</td>
		</tr>
		<tr>
			<td class="formfield">Region of Birth:</td> 
			<td class="ztable">
				<input name="region" type="text" id="region" size="30" value = "$region" $state4 />
				$region_error
			</td>
			<td class="formfield">E-mail:</td>
			<td class="ztable">
				<input name="email" type="text"  size="30" value = "$email1" $state4 /> 
				$email1_error
			</td>
		</tr>
		<tr>
			<td class="formfield">Country of Birth:<span class="style2">*</span></td> 
			<td class="ztable">
				<input name="country" size="20" value="$country" style="background:gray" readonly />
			</td>
			<td class="formfield">Name of Bank:</td>
			<td class="ztable">
				<input name="bank_name" size="30" value="$bank_name" $state4 />
			</td>
		</tr>
		<tr>
			<td class="formfield">Nationality:<span class="style2">*</span></td>
			<td class="ztable">
				<input name="nationality" size="20" value="$nationality" style="background:gray" readonly />
			</td>
			<td class="formfield">Name of Branch:</td>
			<td class="ztable">
				<input name="bank_branch_name" size="30" value="$bank_branch_name" $state4 />
			</td>
		</tr> 
		<tr>
			<td class="formfield">Student Status:<span class="style2">*</span></td>
			<td class="ztable">
EOD;
	
	//update admission status
	$acc_id = ($inst==md5(0))? 3: (($inst==md5(1))? 2:8);
	
	//an array for unchangeable statuses
	$registration_status = array(1, 4, 5, 6, 7);
	
	//update registration status
	if(!in_array($status,$registration_status,true)){
		mysql_query("UPDATE student SET Status='$acc_id' WHERE RegNo='$regno' AND Id='$id'");
		$status = $acc_id;
		}
		
	$query_studentStatus1 = mysql_query("SELECT StatusID,Status FROM studentstatus where StatusID='$status'");
	$stat=mysql_fetch_array($query_studentStatus1);
	$status2 = ($stat['Status'] == '')? "Active":$stat[Status];
	
	$reg_form .=<<<EOD
				<input type="hidden" name="status" value="$status" />
				<input type="text" name="status2" value="$status2" style="background:gray" readonly />
				$status_error
			</td>
			<td class="formfield">Account Number:</td>
			<td class="ztable">
				<input name="account_number" size="30" value="$account_number" $state4 />
			</td>
		</tr>
			<tr>
			<td colspan="4" nowrap="nowrap" class="hseparator">Sponsor Information</td>
		</tr>
		<tr>
			<td nowrap="nowrap" class="formfield">Name of Sponsor:</td> 
			<td class="ztable">
				<input name="sponsor" size="30" value="$relative" style="background:gray" readonly />
			</td>
			<td class="formfield">Sponsor Phone:</td>
			<td class="ztable">
				<input name="sponsor_phone" size="30" value="$relative_phone" style="background:gray" readonly />
			</td>
		</tr>
		<tr>
			<td nowrap="nowrap" class="formfield">Sponsor Occupation:</td> 
			<td class="ztable">
				<input name="sponsor_job" size="30" value = "$relative_job" style="background:gray" readonly />
			</td>
			<td class="formfield">Sponsor Address:</td>
			<td class="ztable">
				<input name="sponsor_address" size="30" value="$relative_address" style="background:gray" readonly />
			</td>
		</tr>
		<tr>
			<td colspan="4" nowrap="nowrap" class="hseparator">Next of Kin Information</td>
		</tr>
		<tr>
			<td nowrap="nowrap" class="formfield">Name of Next of Kin:</td> 
			<td class="ztable">
				<input name="kin" size="30" value="$kin" $state4 />
			</td>
			<td class="formfield">Next of Kin Phone:</td>
			<td class="ztable">
				<input name="kin_phone" size="30" value="$kin_phone" $state4 />
			</td>
		</tr>
		<tr>
			<td nowrap="nowrap" class="formfield">Next of Kin Occupation:</td> 
			<td class="ztable">
				<input name="kin_job" size="30" value="$kin_job" $state4 />
			</td>
			<td class="formfield">Next of Kin Address:</td>
			<td class="ztable">
				<input name="kin_address" size="30" value="$kin_address" $state4 />
			</td>
		</tr>
		<tr>
			<td colspan="4" nowrap="nowrap" class="hseparator">Entry Qualifications Information</td>
		</tr>
		<tr>
			<td class="formfield">Form IV School Name:</td>
			<td class="ztable">
				<input name="form4name" type="text" id="form4name" size="30" value ="$form4name" style="background:gray" readonly />
			</td>
			<td nowrap="nowrap" class="formfield">Form IV NECTA No:<span class="style2">*</span></td>
			<td nowrap="nowrap" class="ztable" >
				<input name="form4no" type="text" id="formfour3"  value ="$form4no" style="background:gray" readonly />
				<select name="f4year" $state4>
					<option value="$f4year">$f4year</option>
				</select>
			</td>
		</tr>
		<tr>
			<td nowrap="nowrap" class="formfield">Form VI School Name:<span class="style2"></span></td> 
			<td class="ztable">
				<input name="form6name" type="text" id="formfour4" size="30" value ="$form6name" style="background:gray" readonly />
			</td>
			<td nowrap="nowrap"  class="formfield">Form VI NECTA No:</td>
			<td nowrap="nowrap" class="ztable" >
				<input name="form6no" type="text" id="formsix" value="$form6no" style="background:gray" readonly />
				<select name="f6year" $state4>
					<option value="$f6year">$f6year</option>
				</select>
				$formsix_error
			</td>
		</tr>
		<tr>
			<td nowrap="nowrap" class="formfield">Equivalent Institute Name:<span class="style2"></span>
			<td class="ztable">
				<input name="form7name" type="text" id="formfour" size="30" value ="$form7name" style="background:gray" readonly />
			</td>
			<td nowrap="nowrap" class="formfield"> Equivalent Qualification: </td>
			<td nowrap="nowrap" class="ztable" >
				<input name="form7no" type="text" id="diploma" value="$form7no" style="background:gray" readonly />
				<select name="f7year" $state4>
					<option value="$f7year">$f7year</option>
				</select>
				$diploma_error
			</td>
		</tr>
		<tr class='total'>
			<td colspan="4" align="center">
				<span class="style2">*</span> Must be filled           
				<input name="actionupdate" type="Submit" value="Save Changes">
			</td>
		</tr>
	</table>
	</form>
EOD;

	echo $reg_form;
	}


#Updating Records
if(isset($_POST['actionupdate'])){
	$disabilityCategory=$_POST['disabilityCategory'];

	$sponsorname=addslashes($_POST['sponsor']);
	$sponsor_phone=addslashes($_POST['sponsor_phone']);
	$sponsor_address=addslashes($_POST['sponsor_address']);
	$sponsor_job=addslashes($_POST['sponsor_job']);  
	
	$kin=$_POST['kin'];
	$kin_phone=$_POST['kin_phone'];
	$kin_address=$_POST['kin_address'];
	$kin_job=$_POST['kin_job'];
	$regno = addslashes($_POST['regno']);
	$AdmissionNo = addslashes($_POST['AdmissionNo']);   
	$stdid = $_POST['stdid'];
	$degree = $_POST['degree'];
	$faculty = $_POST['faculty'];
	$ayear = $_POST['ayear'];
	$combi = $_POST['combi'];
	$campus = $_POST['campus'];
	$class = $_POST['class'];
	$manner = $_POST['manner'];
	$byear = addslashes($_POST['txtYear']);
	$bmon = addslashes($_POST['txtMonth']);
	$bday = addslashes($_POST['txtDay']);
	$dtDOB = $bday . " - " . $bmon . " - " . $byear;
	$surname = strtoupper(addslashes($_POST['surname']));
	$firstname = addslashes($_POST['firstname']);
	$middlename = addslashes($_POST['middlename']);
	$dtDOB = $_POST['dtDOB'];
	$age = $_POST['age'];
	$sex = $_POST['sex'];
	$sponsor = $_POST['txtSponsor'];
	$country = $_POST['country'];
	$nationality = $_POST['nationality'];
	$district = addslashes($_POST['district']);
	$region = addslashes($_POST['region']);
	$maritalstatus = $_POST['maritalstatus'];
	$address = strtoupper($_POST['address']);
	$religion = $_POST['religion'];
	$denomination = $_POST['denomination'];
	$postaladdress = strtoupper(addslashes($_POST['postaladdress']));
	$residenceaddress = strtoupper(addslashes($_POST['residenceaddress']));
	$disability = $_POST['disability'];
	$status = $_POST['status'];
	$gyear = $_POST['dtDate'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$formsix = $_POST['formsix'];
	$formfour = $_POST['formfour'];
	$diploma = $_POST['diploma'];
	$studylevel= $_POST['studylevel'];
	$f4year= $_POST['f4year'];
	$f6year= $_POST['f6year'];
	$f7year= $_POST['f7year'];
	$denomination= $_POST['denomination'];
	$name = strtoupper($surname).", ".ucwords($firstname)." ".ucwords($middlename);

	//Added fields
	$account_number=$_POST['account_number'];
	$bank_branch_name=$_POST['bank_branch_name'];
	$bank_name=$_POST['bank_name'];
	$form4no=$_POST['form4no'];
	$form4name=$_POST['form4name'];
	$form6name=$_POST['form6name'];
	$form6no=$_POST['form6no'];
	$form7name=$_POST['form7name'];
	$form7no=$_POST['form7no'];
	$paddress=$_POST['paddress'];
	$currentaddaress=$_POST['currentaddaress'];
		
	$qRegNo = "SELECT RegNo FROM student WHERE Id = '$stdid'";//chas WHERE RegNo = '$regno'
	//$qRegNo = "SELECT RegNo FROM student WHERE RegNo = '$regno'";
	$dbRegNo = mysql_query($qRegNo);
	$dbRegNof = mysql_fetch_assoc($dbRegNo);
	$dbRegNofs = $dbRegNof['RegNo'];
	$total = mysql_num_rows($dbRegNo);
	
	if ($total>1) {
		echo "ZALONGWA SARIS database system has detected that,<br> this Registration ". $regno. " is already in use";
		echo "<br> Go Back and Insert Newone!<hr><br>";
		}
	else{
		#update record
		$sql="update student set Name='$name',
		Sex='$sex',DBirth='$dtDOB',
		MannerofEntry='$manner',
		MaritalStatus='$maritalstatus',
		Campus='$campus',ProgrammeofStudy='$degree',
		Faculty='$faculty',Sponsor='$sponsor',
		GradYear='$gyear',EntryYear='$ayear',
		Status='$status',
		Address='$address',Nationality='$nationality',
		Region='$region',District='$district',
		Country='$country',
		Received=now(),user='$username',
		Denomination='$denomination',
		Religion='$religion',Disability='$disability',
		formfour='$formfour',formsix='$formsix',
		diploma='$diploma',f4year='$f4year',
		f6year='$f6year',f7year='$f7year',
		kin='$kin',kin_phone='$kin_phone',
		kin_address='$kin_address',kin_job='$kin_job',
		relative='$sponsorname',relative_phone='$sponsor_phone',relative_address='$sponsor_address',relative_job='$sponsor_job',
		disabilityCategory='$disabilityCategory',
		Subject='$combi',
		account_number='$account_number',
		bank_branch_name='$bank_branch_name',
		bank_name='$bank_name',
		form4no='$form4no',
		form4name='$form4name',
		form6name='$form6name',
		form6no='$form6no',
		form7name='$form7name',
		form7no='$form7no',
		paddress='$paddress',
		Phone='$phone',
		Email='$email',
		AdmissionNo='$AdmissionNo',
		RegNo='$regno',
		Class='$class',
		currentaddaress='$currentaddaress'
		where RegNo='$dbRegNofs'";//Id='$stdid'";
		
		$dbstudent = mysql_query($sql);
		if($dbstudent){
			//echo "Admision Record Cannot be Updated - ".$dbstudent;
			echo "Admision Record Updated Successfuly<br/>";
			}
		else{
			echo mysql_error();
			}		
		}
	}
//***********END OF REGISTRATION FORM******************
?>
