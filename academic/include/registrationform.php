<?php
if (isset($_GET['id'])) 
{
#get post variables
$id = addslashes($_GET['id']);
$reg = addslashes($_GET['RegNo']);
$edit=$_GET['edit'];
if($edit==yes)
{
$state1="submit";
$state2="hidden";
$state3="readonly";
$state4="";
$label_edit="";
}
else
{
$state1="hidden";
$state2="hidden";
$state3="readonly";
$state4="disabled";
$label_edit="<a href='$_SERVER[PHP_SELF]?id=$id&RegNo=$reg&edit=yes'><img src='../includes/img/edit.png' alt='Click to Edit This Record'>Edit</a>";
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
	$country = $update_row['Nationality'];
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
}else
{
$state1="hidden";
$state2="submit";
$state3="";
$state4="";
}


if (isset($_POST['save']))
{       $disabilityCategory=$_POST['disabilityCategory'];
        $sponsorname=addslashes($_POST['sponsor']);
        $sponsor_phone=addslashes($_POST['sponsor_phone']);
        $sponsor_address=addslashes($_POST['sponsor_address']);
        $sponsor_job=addslashes($_POST['sponsor_job']);
        
		$kin=addslashes($_POST['kin']);
        $kin_phone=addslashes($_POST['kin_phone']);
        $kin_address=addslashes($_POST['kin_address']);
        $kin_job=addslashes($_POST['kin_job']);
	    $regno = addslashes($_POST['regno']);
		$stdid = addslashes($_POST['stdid']);
	    $AdmissionNo = addslashes($_POST['AdmissionNo']);   
		$degree = addslashes($_POST['degree']);
		$faculty = addslashes($_POST['faculty']);
		$ayear = addslashes($_POST['ayear']);
		$combi = addslashes($_POST['combi']);
		$campus = addslashes($_POST['campus']);
		$class = addslashes($_POST['class']);
		$manner = addslashes($_POST['manner']);
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
		$phone1 = $_POST['phone'];
		$email1 = $_POST['email'];
		$formsix = $_POST['formsix'];
		$formfour = $_POST['formfour'];
		$diploma = $_POST['diploma'];
		$studylevel= $_POST['studylevel'];
		$f4year= $_POST['f4year'];
		$f6year= $_POST['f6year'];
		$f7year= $_POST['f7year'];
		$denomination= $_POST['denomination'];
		$name = $surname.", ".$firstname." ".$middlename;

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
//*************
//FORMATING ERRORS
if(!$formsix||!$formfour||!$diploma||!$phone1||!$email1||!$regno||!$degree||!$faculty||!$ayear||!$combi||!$campus||!$manner||!$byear||!$bmon||!$bday||!$dtDOB||!$surname||!$firstname||!$dtDOB|| !$age||!$sex||!$sponsor||!$country||!$maritalstatus||!$address||!$religion||!$denomination||!$postaladdress||!$residenceaddress||!$status||!$gyear||!$name)
{ 
if(!$regno)
{
$regno_error="<font color='red'>*Registration Number Must be Filled</font>";
}
if(!$phone1)
{
//$phone1_error="<font color='red'>*Phone Number Must be Filled</font>";
}
if(!$studylevel)
{
//$studylevel_error="<font color='red'>*Study Level Must be Filled</font>";
}
if(!$email1)
{
//$email1_error="<font color='red'>*Email Must be Filled</font>";
}
if(!$formsix)
{
//$formsix_error="<font color='red'>*Form Six Necta Number Must be Filled</font>";
}
if(!$formfour)
{
//$formfour_error="<font color='red'>*Form Four Necta Number Must be Filled</font>";
}
	 
if(!$diploma)
{
//$diploma_error="<font color='red'>*Diploma Necta Number Must be Filled</font>";
}
if(!$degree)
{
$degree="<font color='red'>*Study Programme Must be Filled</font>";
}
 	 
	 
if(!$faculty)
{
//$faculty_error="<font color='red'>*Faculty  Must be Filled</font>";
}
	  
if(!$ayear)
{
$ayear_error="<font color='red'>*Date Must be Filled</font>";
}
	 
if(!$combi)
{
//$combination_error="<font color='red'>*Combination  Must be Filled</font>";
} 	 
if(!$campus)
{
$campus_error="<font color='red'>*Campus Name Must be Filled</font>";
}	 
if(!$manner)
{
//$manner_error="<font color='red'>*Manner Must be Filled</font>";
}
	 
	 
if(!$byear)
{
//$byear_error="<font color='red'>*Birth Date Must be Filled</font>";
}
if(!$bmon)
{
//$bmon_error="<font color='red'>*Month Must be Filled</font>";
}
if(!$sex)
{
//$sex_error="<font color='red'>*Gender Must be Filled</font>";
}
	 
if(!$bday)
{
//$bday_error="<font color='red'>*Birth day Must be Filled</font>";
}	
if(!$dtDOB)
{
$dtDOB_error="<font color='red'>*Date of birth Must be Filled</font>";
}
	 
if(!$surname)
{
$surname_error="<font color='red'>*Surname Must be Filled</font>";
}	 
	
if(!$firstname)
{
$firstname_error="<font color='red'>*First Name Must be Filled</font>";
}
/* 
if(!$middlename)
{
$middlename_error="<font color='red'>*Middle Name Must be Filled</font>";
}
*/
 
if(!$sponsor)
{
$sponsor_error="<font color='red'>*Sponsor Must be Filled</font>";
}
if(!$country)
{
$country_error="<font color='red'>*Country Must be Filled</font>";
}
if(!$region)
{
//$region_error="<font color='red'>*Region Must be Filled</font>";
}
if(!$maritalstatus)
{
$maritalstatus_error="<font color='red'>*Marital Status Must be Filled</font>";
}
if(!$address)
{
$address_error="<font color='red'>*Address Must be Filled</font>";
}
if(!$religion)
{
//$religion_error="<font color='red'>*Religion Must be Filled</font>";
}
if(!$denomination)
{
//$denomination_error="<font color='red'>*Denomination Must be Filled</font>";
}
if(!$postaladdress)
{
$postaladdress_error="<font color='red'>*Postal Address Must be Filled</font>";
}
if(!$residenceaddress)
{
$residenceaddress_error="<font color='red'>*Residentaddress Address Must be Filled</font>";
}
/*
if(!$disability)
{
$disability_error="<font color='red'>*Disability Must be Filled</font>";
}
*/
if(!$status)
{
$status_error="<font color='red'>*Status Address Must be Filled</font>";
}
if(!$gyear)
{
//$gyear_error="<font color='red'>*Gyear Address Must be Filled</font>";
}
if(!$name)
{
//$name_error="<font color='red'>*Name Address Must be Filled</font>";
}

}
form();
#check if RegNo Exist
$qRegNo = "SELECT RegNo FROM student WHERE RegNo = '$regno'";
$dbRegNo = mysql_query($qRegNo);
$total = mysql_num_rows($dbRegNo);
if ($total==1)
{
echo"
<table>
<tr><td><img src='../includes/img/error.gif'></td>
<td>
ZALONGWA SARIS database system has found this,<br> 
Registration Number $regno already in use.
<br><a href='./admissionRegistrationForm.php'>Go Back and Insert Newone!</a>
</td></tr></table>";
}
else
{
#insert record
$sql="INSERT INTO student
(Name,AdmissionNo,
Sex,DBirth,
MannerofEntry,MaritalStatus,
Campus,ProgrammeofStudy,
Faculty,
Sponsor,GradYear,
EntryYear,Status,
Address,Nationality,
Region,District,Country,
Received,user,
Denomination, Religion,
Disability,formfour,
formsix,diploma,
f4year,f6year,f7year,
relative,relative_phone,relative_address,relative_job,
kin,kin_phone,
kin_address,kin_job,
disabilityCategory,Subject,
account_number,
bank_branch_name,
bank_name,
form4no,
form4name,
form6name,
form6no,
form7name,
form7no,
paddress,
Phone,
Email,
currentaddaress,
RegNo,
Class,
studylevel
) 
VALUES
('$name','$AdmissionNo',
'$sex','$dtDOB',
'$manner','$maritalstatus',
'$campus','$degree',
'$faculty',' $sponsor',
'$gyear','$ayear',
'$status','$address',
'$country',
'$region','$district',
'$country',now(),
'$username','$denomination', 
'$religion','$disability',
'$formfour','$formsix',
'$diploma','$f4year',
'$f6year','$f7year',
'$sponsorname','$sponsor_phone','$sponsor_address','$sponsor_job',
'$kin','$kin_phone',
'$kin_address','$kin_job',
'$disabilityCategory','$Subject',
'$account_number',
'$bank_branch_name',
'$bank_name',
'$form4no',
'$form4name',
'$form6name',
'$form6no',
'$form7name',
'$form7no',
'$paddress',
'$phone1',
'$email1',
'$currentaddaress',
'$regno',
'$class',
'$studylevel'
)";   
//echo $sql;
$dbstudent = mysql_query($sql);
if(!$dbstudent)
{
echo "Admision Record Cannot be Saved";
}else
{
echo "Admision Record Saved Successfuly";
}		
}
}
else
{
form();	
}
?>
<?php


//*************REGISTRATION FORM
function form()
{
global $state1,$state2,$state3,$label_edit,$state4,$AdmissionNo,$stdid, $studylevel;
global $disabilityCategory,$studylevel,$father,$father_job,$mother,$mother_job,$father_address,
$father_phone,$mother_address,$mother_phone,
$brother,$brother_phone,$brother_address,$brother_job,$class,
$sister,$sister_phone,$sister_address,$sister_job,
$spouse,$spouse_phone,$spouse_address,$spouse_job,
$kin,$kin_phone,$kin_address,$kin_job,$School_attended_olevel,$School_attended_to_alevel,$School_attended_alevel,$School_attended_from_alevel,
$relative,$relative_phone,$relative_address,$relative_job,$School_attended_to_olevel,$School_attended_from_olevel,
$txtYear,$txtDay,$txtMonth,$sponsor,$maritalstatus,$country,$formsix,$formfour,$diploma,$phone1,$email1,$regno,$degree,$faculty,$ayear,$combi,$campus,$manner,$byear,$bmon,$bday,$dtDOB,$surname,$firstname,$middlename,$dtDOB,$age,$sex,$sponsor,$country,$district,$region,$maritalstatus,$address,$religion,$denomination,$postaladdress,$residenceaddress,$disability,$status,$gyear,$name,$ayear,$campus,
$kin,$kin_phone,$kin_address,$kin_job,$f4year,$f6year,$f7year;
global $disabilityCategory_erro,$studylevel_error,$maritalstatus_error,$country_error,$ayear_error,$formsix_error,$formfour_error,$diploma_error,$phone1_error,$email1_error,$regno_error,$degree_error,$faculty_error,$ayear_error,$combi_error,$campus_error,$manner_error,$byear_error,$bmon_error,$bday_error,$dtDOB_error,$surname_error,$firstname_error,$middlename_error,$dtDOB_error,$age_error,$sex_error,$sponsor_error,$country_error,$district_error,$region_error,$maritalstatus_error,$address_error,$religion_error,$denomination_error,$postaladdress_error,$residenceaddress_error,$disability_error,$status_error,$gyear_error,$name_error;
global $account_number,$bank_branch_name,$bank_name,$form4no,$form4name,$form6name,$form6no,$form7name,$form7no,$paddress,$currentaddaress;
?> 
<form action=" <?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name='admission'>

<table align="center" cellspacing='2' >
<tr>
<td> 
<?php echo $label_edit;?>&nbsp;
</td>
<td class='zatable'>
<input name="actionupdate" type="<?php echo $state1;?>" value="Save Changes">
<input name="save" type="<?php echo $state2;?>" value="Save Record" >
</td>
</tr>
</table>

<table  cellpadding='0' cellspacing='0' bgcolor='#DBDBDB' class='ztable'>

  <tr>
    <td colspan="4" nowrap="nowrap" class="hseparator">
	Study Programme Information    </td>
    </tr>
  <tr>
    <td nowrap="nowrap" class='formfield'>Year of Admission:<span class="style2">*</span></td>
   <td class='ztable'>
<select name="ayear" id="select" class="vform" <?php echo $state4;?>>
<?php
if(!$ayear)
{
echo"<option value=''>[Select Year]</option>";
}else
{
echo"<option value='$ayear'>$ayear</option>";
}
$nm=mysql_query("SELECT AYear FROM academicyear where AYear!='$ayear' ORDER BY AYear DESC");
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[AYear]'>$show[AYear]</option>";      
}
?>										                                        												 
</select>
<?php echo $ayear_error; 
?>
</td>


    <td nowrap="nowrap" class="formfield">Admission No:<span class="style2">*</span>	</td>
   <td class='ztable'>
         <input name="hiddenregno" type="hidden" id="hiddenregno" value = "7070"    <?php echo $state3;?> <?php echo $state4;?> />
		 <input name="stdid" type="hidden" id="stdid" value = "<?php echo $stdid;?>" <?php echo $state3;?> <?php echo $state4;?> />
	<input name="AdmissionNo" type="text" id="AdmissionNo" value = "<?php echo $AdmissionNo;?>"   <?php echo $state3;?> <?php echo $state4;?> />
 
      <?php echo $regno_error;?> </td>
  </tr>
<tr>
<td nowrap="nowrap" class='formfield'>Campus:<span class="style2">*</span></td>
<td class='ztable'>
<select name="campus" <?php echo $state4;?>>
<?php
if(!$campus)
{
echo"<option value=''>[Select Campus]</option>";
}
else
{
$query_campus1 = mysql_query("SELECT CampusID, Campus FROM campus where CampusID='$campus'");
$camp=mysql_fetch_array($query_campus1);
echo"<option value='$campus'>$camp[Campus]</option>";
} 
$query_campus = "SELECT CampusID, Campus FROM campus ORDER BY Campus ASC";
$nm=mysql_query($query_campus);
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[CampusID]'>$show[Campus]</option>";      
}   
?>										                                        												 
</select>
<?php echo $campus_error;  ?></td>
  <td class='formfield'>Registration No:<span class="style2">*</span></td>
  <td class='ztable'>
  <input name="regno" type="text" id="regno" value = "<?php echo $regno;?>"<?php echo $state3;?> <?php echo $state4;?>>
  <?php ?>
  </td>
</tr>
   <tr>
     <td nowrap="nowrap" class='formfield'>Program Registered:<span class="style2">*</span></td> 
    <td class='ztable'>
	 <select name="degree" id="degree"  <?php echo $state3;?> <?php echo $state4;?>>
       <?php
if(!$degree)
{
echo"<option value=''>[Select Programme]</option>";
}else
{
$take=mysql_query("select * from programme where ProgrammeCode='$degree'")or die(mysql_error());
$t=mysql_fetch_array($take);
echo"<option value='$degree'>$t[ProgrammeName]</option>";
}  
$query_degree = "SELECT ProgrammeCode,ProgrammeName,Faculty FROM programme ORDER BY ProgrammeName";
$nm=mysql_query($query_degree);
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[ProgrammeCode]'>$show[ProgrammeName]</option>";      
     
}
?> 
     </select>
       <?php 
echo $degree_error;  
?></td>  
<td nowrap="nowrap" class="formfield" >Graduation Date:</td>
<td class='ztable'>
<input type="text" name="dtDate" value="<?php echo $gyear;?>" <?php echo $state4;?> />
  <script type="text/javascript" src="./calendars.js"></script>
  <script language="JavaScript">
	new tcal ({'formname': 'admission','controlname': 'dtDate'});
	   </script>
  <?php echo $date_error;  ?> </td>

</tr>
<?php /* ?>
<tr><td class='formfield'>Faculty:<span class="style2">*</span>
</td><td class='ztable'>
<select name="faculty" id="faculty" <?php echo $state4;?>>
  <?php
if(!$faculty)
{
echo"<option value=''>[Select Faculty]</option>";
}else
{

echo"<option value='$faculty'>$faculty</option>";
}  
$query_faculty = "SELECT FacultyName FROM faculty ORDER BY FacultyName DESC";
$nm=mysql_query($query_faculty);
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[FacultyName]'>$show[FacultyName]</option>";      
        
}
?>
   </select>
       <?php 
echo $faculty_error;
*/
?>

<tr><td class='formfield'>Class Stream:<span class="style2">*</span>
</td><td class='ztable'>
<select name="class" id="class" class="vform" <?php echo $state4;?>>
<?php
if(!$class)
{
echo"<option value=''>[Select Class]</option>";
}else
{
echo"<option value='$class'>$class</option>";
}
$nm=mysql_query("SELECT name FROM classstream where name!='$class' ORDER BY name ASC");
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[name]'>$show[name]</option>";      
}
?>										                                        												 
</select>
<?php echo $ayear_error; 
?>
</td>
     <td nowrap="nowrap" class="formfield">Sponsorship:	 </td>
    <td class='ztable'>
	 <select name="txtSponsor" id="txtSponsor" <?php echo $state4;?>>
       <?php
if(!$sponsor)
{
echo"<option value=''>[Select Sponsor]</option>";
}else
{
echo"<option value='$sponsor'>$sponsor</option>";
}  
$query_sponsor = "SELECT Name FROM sponsors ORDER BY SponsorID ASC";
$nm=mysql_query($query_sponsor);
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[Name]'>$show[Name]</option>";      
    
}
?>
     </select>
       <?php 
echo $sponsor_error;
?></td>
   </tr>
<tr>
<td nowrap="nowrap" class="formfield">Level of Study Registered for:</td>
  <td class='ztable'>
 
 <select name="studylevel" id="studylevel" <?php echo $state4;?>>
<?php
if(!$studylevel)
{
echo"<option value=''>[Select Level of Study]</option>";
}else
{
$take=mysql_query("select * from studylevel where LevelCode='$studylevel'");
$t=mysql_fetch_array($take);
echo"<option value='$studylevel'>$t[LevelName]</option>";
}  
$query_studylevel = "SELECT LevelCode,LevelName FROM studylevel ORDER BY LevelName";
$nm=mysql_query($query_studylevel);
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[LevelCode]'>$show[LevelName]</option>";      
 
}
?>										                                        												 
</select>
<?php ?>
 
  </td>
 
     <td nowrap="nowrap"class="formfield">Manner of Entry:</td>
    <td class='ztable'>
	 <select name="manner" id="manner" <?php echo $state4;?>>
       <?php
if(!$manner)
{
echo"<option value=''>[Select Manner of Entry]</option>";
}else
{
$query_Manner =mysql_query("SELECT ID, MannerofEntry FROM mannerofentry where ID='$manner'");
$mana=mysql_fetch_array($query_Manner);
echo"<option value='$manner'>$mana[MannerofEntry]</option>";
}  
$query_MannerofEntry = "SELECT ID, MannerofEntry FROM mannerofentry ORDER BY MannerofEntry ASC";
$nm=mysql_query($query_MannerofEntry);
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[ID]'>$show[MannerofEntry]</option>";      
}       

?>
     </select>
<?php 
echo $manner_error;
?></td>  
  
</tr>
  <tr>
    <td colspan="4" nowrap="nowrap" class="hseparator">
	Personal Information    </td>
    </tr>
    <tr><td class='formfield'>Surname:<span class="style2">*</span></td><td class='ztable'>
	<input name="surname" type="text" id="surname" value = "<?php echo $surname;?>" size="30"  <?php //echo $state3;?> <?php echo $state4;?>/>
      <?php echo $surname_error;  ?></td>
     <td class="formfield">Religion:     </td>
     <td class='ztable'>
<?php
 echo"<select name='denomination' id='denomination'  $state4  $state4 >";
if(!$denomination)
{
echo"<option value=''>[Select Sect of Religion ]</option>";
}else
{
?>
        <option value="<?php echo $denomination;?>"><?php echo $denomination;?></option>
        <?
}  

$query_denomination2 = "SELECT * FROM religion";
$nr=mysql_query($query_denomination2);
while($l=mysql_fetch_array($nr))
{
//echo"<optgroup label='$l[Religion]'>";
//$query_denomination = "SELECT * FROM denomination where ReligionID='$l[ReligionID]' ORDER BY denomination ASC";
$query_denomination = "SELECT * FROM religion where ReligionID='$l[ReligionID]' ORDER BY Religion ASC";
$nm=mysql_query($query_denomination);
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[Religion]'>$show[Religion]</option>";      
}
//echo"</optgroup>";
}       
?>
      </select>
        <?php 
echo $denomination_error; 
?></td>
    </tr>
    
   <tr>
   <td class='formfield' norwap>Middlename:</td> 
  <td class='ztable'>
 <input name="middlename" type="text" id="middlename" value="<?php echo $middlename;?>" size="15" maxlength="50"  <?php //echo $state3;?> <?php echo $state4;?>/>
     <?php echo $middlename_error;  ?> </td>
  <td class="formfield">Marital Status:</td>
  <td class='ztable'>
   <select name="maritalstatus" id="maritalstatus" <?php echo $state4;?>>
     <?php
if($maritalstatus)
{
echo "<option value='$maritalstatus'>$maritalstatus</option>";
}else
{
echo "<option value=''>[Select Marital Status]</option>";
}
?>
     <option value="Single">Single</option>
     <option value="Married">Married</option>
     <option value="Divorced">Divorced</option>
     <option value="Widowed">Widowed</option>
   </select>
     <?php    
echo $maritalstatus_error; 
?></td>
   </tr>
   <tr>
   <td class='formfield'>Firstname:<span class="style2">*</span></td>
  <td class='ztable'>
   <input name="firstname" type="text" value="<?php echo $firstname;?>" id="firstname" size="30" <?php echo $state4;?>/>
     <?php echo $firstname_error;  ?> </td>
  <td class="formfield">Disability:</td>
  <td class='ztable'>
   <select name='disabilityCategory' <?php echo $state4;?>>
     <?php
if($disabilityCategory)
{?>
     <option value="<?php echo $disabilityCategory;?>"> <?php echo $disabilityCategory;?></option>
     <?
}else
{
echo"<option value='None'>[Select Disability]</option>";
} 
$query_disability3 = "SELECT * FROM disability"; 
$nm3=mysql_query($query_disability3);
while($s= mysql_fetch_array($nm3))
{
echo"<optgroup label='$s[disability]'>";      
$query_disability2 = "SELECT * FROM disabilitycategory where DisabilityCode='$s[DisabilityCode]'";
$nm2=mysql_query($query_disability2);
while($show = mysql_fetch_array($nm2) )
{ 	 
echo"<option  value='$show[disabilityCategory]'>$show[disabilityCategory]</option>";      
}
echo"<optgroup>";
}       
?>
   </select>
     <?php 
echo $disability_error; 
?></td>
   </tr>
   
    <tr><td class='formfield' norwap>Sex:<span class="style2">*</span></td>
  <td class='ztable'>
   <select name="sex" id="sex" <?php echo $state4;?>>
     <?php
if(!$sex)
{
echo"<option value=''>[Select Gender]</option>";
}else
{
if($sex=='F')
{
?>
     <option value="<?php echo $sex;?>">Female</option>
     <?php
}else
{
?>
     <option value="<?php echo $sex;?>">Male</option>
     <?php
}
}
?>
     <option value="M">Male</option>
     <option value="F">Female</option>
   </select>
     <?php 
echo $sex_error;
?></td>
   <td nowrap="nowrap" class="formfield">Permanent Address:<span class="style2">*</span>  </td>
   <td nowrap="nowrap" class="ztable">
<input name="paddress" type="text" id="paddress" size="30" value = "<?php echo $paddress;?>" <?php echo $state4;?> />
     <?php ?></td>
    </tr>
   <tr><td class='formfield'>Date of Birth:</td>
  <td class='ztable'>
   <input type="text" name="dtDOB" value="<?php echo $dtDOB;?>" <?php echo $state4;?> />
     <script language="JavaScript">
	new tcal ({'formname': 'admission','controlname': 'dtDOB'});
	 </script>
     <?php echo $dbirth_error;?> </td>
   <td class="formfield">Current Address:<span class="style2">*</span></td>
  <td class='ztable'>
<input name="currentaddaress" type="text" id="currentaddaress" size="30" value = "<?php echo $currentaddaress;?>" <?php echo $state4;?> />
     <?php?></td>
   </tr>

<tr>
  <td class='formfield'>District of Birth:</td> 
<td class='ztable'>
<input name="district" type="text" id="district" value = "<?php echo $district;?>" size="30" <?php echo $state4;?> />
  <?php echo $district_error;  ?> </td>
<td class="formfield">Phone:</td>
<td class='ztable'>
<input name="phone" type="text"  size="30" value = "<?php echo $phone1;?>" <?php echo $state4;?> />
  <?php 
echo $phone1_error; 
?></td>
</tr>

<tr>
  <td class='formfield'>Region of Birth:</td> 
<td class='ztable'>
<input name="region" type="text" id="region" size="30" value = "<?php echo $region;?>" <?php echo $state4;?> />
  <?php echo $region_error;?></td>
<td class="formfield">E-mail:</td>
<td class='ztable'>
<input name="email" type="text"  size="30" value = "<?php echo $email1;?>" <?php echo $state4;?> />
  <?php 
echo $email1_error; 
?></td>
</tr>


<tr><td class='formfield'>Country of Birth:<span class="style2">*</span></td> 
<td class='ztable'>
<select name="select" <?php echo $state4;?>>
  <?php
if($country)
{
echo "<option value='$country'>$country</option>";
}
else
{
echo "<option value='Tanzania'>Tanzania</option>";
}
$query_country = "SELECT szCountry FROM country ORDER BY szCountry";
$countrys = mysql_query($query_country);
while ($row_country = mysql_fetch_array($countrys))
{
?>
  <option value="<?php echo $row_country['szCountry']?>"> <?php echo $row_country['szCountry']?></option>
  <?php
}
?>
</select>
  <?php 
echo $country_error;   ?></td>
<td class="formfield">Name of Bank:</td>
<td class='ztable'>
<input name="bank_name" size="30" value = "<?php echo $bank_name;?>" <?php echo $state4;?> />
  <?php ?></td>
</tr>

<tr>
<td class='formfield'>Nationality:<span class="style2">*</span></td>
<td class='ztable'>
<select name="country" <?php echo $state4;?>>
  <?php
if($country)
{
echo "<option value='$country'>$country</option>";
}
else
{
echo "<option value='Tanzania'>Tanzania</option>";
}
$query_country = "SELECT szCountry FROM country ORDER BY szCountry";
$countrys = mysql_query($query_country) or die(mysql_error());
while ($row_country = mysql_fetch_array($countrys))
{
?>
  <option value="<?php echo $row_country['szCountry']?>"> <?php echo $row_country['szCountry']?></option>
  <?php
}
?>
</select>
  <?php 
echo $country_error;   ?></td>
<td class="formfield">Name of Branch:</td>
<td class='ztable'>
<input name="bank_branch_name" size="30" value = "<?php echo $bank_branch_name;?>" <?php echo $state4;?> />
  <?php ?></td>
</tr> 

<tr><td class='formfield'>Student Status:<span class="style2">*</span></td>
<td class='ztable'>
<select name="status" id="status" <?php echo $state4;?>>
  <?php
if(!$status)
{
echo"<option value=''>[Select Status]</option>";
}else
{
$query_studentStatus1 = mysql_query("SELECT StatusID,Status FROM studentstatus where StatusID='$status'");
$stat=mysql_fetch_array($query_studentStatus1);
echo"<option value='$status'>$stat[Status]</option>";
}  
$query_studentStatus = "SELECT StatusID,Status FROM studentstatus ORDER BY StatusID";
$nm=mysql_query($query_studentStatus);
while($show = mysql_fetch_array($nm) )
{  										 
echo"<option  value='$show[StatusID]'>$show[Status]</option>";      
      
}
?>
</select>
  <?php 
echo $status_error; 
?></td>
<td class="formfield">Account Number:</td>
<td class='ztable'>
<input name="account_number" size="30" value = "<?php echo $account_number;?>"  <?php echo $state4;?>/>
  <?php ?></td>
</tr>

<tr>
    <td colspan="4" nowrap="nowrap" class="hseparator">
	Sponsor Information   </td>
    </tr>
    
<tr><td nowrap="nowrap" class='formfield'>Name of Sponsor:</td> 
<td class='ztable'>
<input name="sponsor" size="30" value = "<?php echo $relative;?>" <?php echo $state4;?> />
  <?php ?></td>
<td class="formfield">Sponsor Phone:</td>
<td class='ztable'>
<input name="sponsor_phone" size="30" value = "<?php echo $relative_phone;?>" <?php echo $state4;?> />
  <?php ?></td>
</tr>

   <tr>
     <td nowrap="nowrap" class='formfield'>Sponsor Occupation:</td> 
     <td class='ztable'>
<input name="sponsor_job" size="30" value = "<?php echo $relative_job;?>" <?php echo $state4;?>/>
  <?php ?></td>
<td class="formfield">Sponsor Address:</td>
<td class='ztable'>
<input name="sponsor_address" size="30" value = "<?php echo $relative_address;?>" <?php echo $state4;?> />
  <?php ?></td>
   </tr>
   
<tr>
    <td colspan="4" nowrap="nowrap" class="hseparator">
	Next of Kin Information   </td>
    </tr>

<tr><td nowrap="nowrap" class='formfield'>Name of Next of Kin:</td> 
<td class='ztable'>
<input name="kin" size="30" value = "<?php echo $kin;?>" <?php echo $state4;?> />
  <?php ?></td>
<td class="formfield">Next of Kin Phone:</td>
<td class='ztable'>
<input name="kin_phone" size="30" value = "<?php echo $kin_phone;?>" <?php echo $state4;?> />
  <?php ?></td>
</tr>

   <tr>
     <td nowrap="nowrap" class='formfield'>Next of Kin Occupation:</td> 
     <td class='ztable'>
<input name="kin_job" size="30" value = "<?php echo $kin_job;?>" <?php echo $state4;?>/>
  <?php ?></td>
<td class="formfield">Next of Kin Address:</td>
<td class='ztable'>
<input name="kin_address" size="30" value = "<?php echo $kin_address;?>" <?php echo $state4;?> />
  <?php ?></td>
   </tr>


<tr>
<td colspan="4" nowrap="nowrap" class="hseparator">
Entry Qualifications Information</td>
</tr>

<tr>
  <td class="formfield">Form IV School Name:</td>
 <td class='ztable'>
<input name="form4name" type="text" id="form4name" size="30" value ="<?php echo $form4name;?>" <?php echo $state4;?> />
    <?php  ?></td>
<td nowrap="nowrap" class="formfield">Form IV NECTA No:<span class="style2">*</span></span></div></td>
<td nowrap="nowrap" class='ztable' >
<input name="form4no" type="text" id="formfour3"  value ="<?php echo $form4no;?>" <?php echo $state4;?>/>
  <?php
echo"<select name='f4year' $state4>";
if($f4year)
{
echo"<option value='$f4year'>$f4year</option>";
}
echo"<option value='None'>None</option>";
for($k=date('Y');$k>=1960;$k--)
{
echo"<option value='$k'>$k</option>";
}
echo"</select>";
?>
  <?php  ?></td>
</tr>
<tr><td nowrap="nowrap" class='formfield'>Form VI School Name:<span class="style2"></span></td> 
<td class='ztable'>
<input name="form6name" type="text" id="formfour4" size="30" value ="<?php echo $form6name;?>"  <?php echo $state4;?>/>
  <?php  ?></td>
<td nowrap="nowrap"  class="formfield">Form VI NECTA No:</td>
<td nowrap="nowrap" class='ztable' >
<input name="form6no" type="text" id="formsix"  value ="<?php echo $form6no;?>" <?php echo $state4;?> />
  <?php
echo"<select name='f6year' $state4>";
if($f6year)
{
echo"<option value='$f6year'>$f6year</option>";
}
echo"<option value='None'>None</option>";
for($k=date('Y');$k>=1960;$k--)
{
echo"<option value='$k'>$k</option>";
}
echo"</select>";
?>
  <?php echo $formsix_error;   ?></td>
</tr>

<tr>
  <td nowrap="nowrap" class='formfield'>Equivalent Institute Name:<span class="style2"></span>
 <td class='ztable'>
<input name="form7name" type="text" id="formfour" size="30" value ="<?php echo $form7name;?>" <?php echo $state4;?>/>
    <?php ?></td>
  <td nowrap="nowrap" class="formfield"> Equivalent Qualification: </td>
  <td nowrap="nowrap" class='ztable' >
<input name="form7no" type="text" id="diploma" value ="<?php echo $form7no;?>" <?php echo $state4;?>/>
    <?php
echo"<select name='f7year' $state4>";
if($f7year)
{

echo"<option value='$f7year'>$f7year</option>";
}
echo"<option value='None'>None</option>";
for($k=date('Y');$k>=1960;$k--)
{
echo"<option value='$k'>$k</option>";
}
echo"</select>";
?>
    <?php echo $diploma_error;   ?></td>
</tr>

<tr bgcolor='white'>
  <td colspan="4" ><div align="center">
  <span class="style2">*</span> Must be filled           
      <input name="actionupdate" type="<?php echo $state1;?>" value="Save Changes">
        <input name="save" type="<?php echo $state2;?>" value="Save Record" > 
  </div></td>
	</td>
  </tr>
</table>
    
</form>

<?php 
}


#Updating Records
if(isset($_POST['actionupdate']))
{
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
		$name = $surname.", ".$firstname." ".$middlename;

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

$qRegNo = "SELECT RegNo FROM student WHERE RegNo = '$regno'";
$dbRegNo = mysql_query($qRegNo);
$total = mysql_num_rows($dbRegNo);
if ($total>1) 
{
echo "ZALONGWA SARIS database system has detected that,<br> this Registration ". $regno. " is already in use";
echo "<br> Go Back and Insert Newone!<hr><br>";
}
else
{
	#update record
	$sql="update student set Name='$name',
	Sex='$sex',DBirth='$dtDOB',
	MannerofEntry='$manner',
	MaritalStatus='$maritalstatus',
	Campus='$campus',ProgrammeofStudy='$degree',
	Faculty='$faculty',Sponsor='$sponsor',
	GradYear='$gyear',EntryYear='$ayear',
	Status='$status',
	Address='$address',Nationality='$country',
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
	where Id='$stdid'";
$dbstudent = mysql_query($sql) or die(mysql_error().' - mmeona wenyewe?');
if(!$dbstudent)
{
echo "Admision Record Cannot be Updated - ".$dbstudent;
}else
{
echo "Admision Record Updated Successfuly";
}		
}
}
//***********END OF REGISTRATION FORM******************