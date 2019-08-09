<?php
#start pdf
if(isset($_POST['print']))
{
	#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
    require('../includes/PDF_Label.php');
	
    $Eq=$_POST[Eq];
	$count=count($Eq);
	if($count<=0)
	{
	echo "<table>
	<tr><td>
	<font color='red'>Choose Student please, umeelewa?.</font>
	</td></tr>
	</table>";
	}
	else
	{
			//***********             
			 #print lables
			
			/*------------------------------------------------
			To create the object, 2 possibilities:
			either pass a custom format via an array
			or use a built-in AVERY name
			------------------------------------------------*/
			
			// Example of custom format
			$pdf = new PDF_Label(array('paper-size'=>'A4', 'metric'=>'mm', 'marginLeft'=>24, 'marginTop'=>24, 'NX'=>2, 'NY'=>7, 'SpaceX'=>0, 'SpaceY'=>0, 'width'=>99, 'height'=>38, 'font-size'=>8));
			
			// Standard format
			//$pdf = new PDF_Label('L7163');
			
			$pdf->AddPage();	
		
		
		$e=1;
		for($i=0;$i<$count;$i++)
		{
			#Fetch Records
			$sql = "SELECT * FROM student WHERE Id ='$Eq[$i]'"; 
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
			#get degree programme
			$qprogram = "SELECT ProgrammeName FROM programme WHERE ProgrammeCODE ='$degree'";
			$dbprogram = mysql_query($qprogram);
			$row_program = mysql_fetch_assoc($dbprogram);
			$degree = $row_program['ProgrammeName'];
			
		$photo = $update_row['Photo'];
		$checkit = strlen($photo);
		
		if ($checkit > 8){
		
		$imgfile = '../admission/'.$photo;
		#resize photo
			$full_url = $photo;
			$imageInfo = @getimagesize($imgfile);
			$src_width = $imageInfo[0];
			$src_height = $imageInfo[1];
			
			$dest_width = 40;//$src_width / $divide;
			$dest_height = 40;//$src_height / $divide;
			
			$src_img = @imagecreatefromjpeg($imgfile);
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			@imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
			@imagejpeg($dst_img,$full_url);
			@imagedestroy($src_img);
		#new resized image file
		$imgfile = $full_url;
		#NB: ili hii ifanye kazi lazima images folder kwenye academic liwe writable!!!
		
		}else{
		$nophoto = 1;
		}
		
			// Print labels
			//for($i=1;$i<=$count;$i++) {
				$text = sprintf("%s\n%s\n%s %s\n%s %s\n%s %s\n%s %s\n %s\n %s\n", "$org", 'STUDENT IDENTITY CARD', 'RegNo.:', "$regno", 'Name:  ', "$surname", 'Course:', "$degree", 'Expiry date:', '31 July 2013', '__________________________', '        Student\'s Signature');
				$pdf->Image($imgfile, $posX+76, $posY+25); 
				$pdf->Add_Label($text);
			//}
		}
					$pdf->Output();
			# end of label printing
	}
}
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Identity Card';
	$szTitle = 'Print Student Identity Card';
	include('admissionheader.php');
?>

<script type="text/javascript">
checked=false;
function checkedAll (frm1) {
	var aa= document.getElementById('frm1');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
      }
</script>

<script type='text/javascript'>
function confirmdelete( data)
{
if(confirm("Are you sure you want to Print Identity Card of this Candidate "+data))
{
return true;
}else
{
return false;
}
}
</script>
<?php

//Begin of Filter Panel
echo"<form action='$_SERVER[PHP_SELF]' method='GET'>
<table>
<tr>
<td>Enter RegNo or Name</td>
<td><input type='text' name='key'></td>
<td>";
?>
<input type='submit' name='search' value='Go' style='background-color:lightblue;color:black ;font-size:9pt;font-weight:bold'>

<?php
echo"</td>
<tr>
</table></form>";
if(isset($_GET['search'])||$_GET['key'])
{
$key=addslashes($_GET['key']);
$look="SELECT * FROM  student where RegNo like '%$key'OR Name like '%$key%' OR AdmissionNo like '%$key'";
}
else
{
$look="SELECT * FROM  student order by Name";
}

//Begin of Pagination
///START DISPLAYING RECORDS
$rowPerPage=20;
$pageNum=1;
if(isset($_GET['page']))
{
$pageNum=$_GET['page'];
}
$offset=($pageNum-1)*$rowPerPage;
$k=$offset+1;
$query=$look." LIMIT $offset,$rowPerPage";
$result=mysql_query($query);

echo"<form action='$_SERVER[PHP_SELF]' method='POST' name='frm1'>";
echo"<center>
<table width='950' cellspacing='0' cellpadding='0'>
<tr><th>Select Students to Delete</th></tr></table>
</center>";
echo "<table cellspacing='0' border='1' width='950' cellpadding='0'>
<tr bgcolor='#ccccf'>
<th>V</th>
<th>#</th>
<th>Student Name</th>
<th>Sex</th>
<th>RegNo</th>
<th>Study Programme</th>
<th>Registered</th>
</tr>";
while($r=mysql_fetch_array($result))
{
		$degree =$r[ProgrammeofStudy];
		#get degree programme
		$qprogram = "SELECT ProgrammeName FROM programme WHERE ProgrammeCODE ='$degree'";
		$dbprogram = mysql_query($qprogram);
		$row_program = mysql_fetch_assoc($dbprogram);
		$degree = $row_program['ProgrammeName'];
echo "<tr>
<td><input type='checkbox' name='Eq[]' value='$r[Id]'></td>
<td>&nbsp;$k</td>
<td>&nbsp;$r[Name]</td>
<td>&nbsp;$r[Sex]</td>
<td>&nbsp;$r[RegNo]</td>
<td>&nbsp;$degree</td>
<td>&nbsp;$r[EntryYear]</td>
</tr>";
$k++;
}
echo"</table>";


$data=mysql_query($look);
$numrows=mysql_num_rows($data);
$result=mysql_query($data);
$row=mysql_fetch_array($data);


$maxPage=ceil($numrows/$rowPerPage);

$self=$_SERVER['PHP_SELF'];
$nav='';
for($page=1;$page<=$maxPage;$page++)
{
if($page==$pageNum)
{
$nav.=" $page";
$nm=$page;
}else
{
$nav.="<a href=\"$self?page=$page&key=$key\">$page</a>";
}
}
if($pageNum>1)
{
$page=$pageNum-1;
$prev="<a href=\"$self?page=$page&key=$key\">Previous</a>";
$first="<a href=\"$self?page=1\">[First]</a>";
}
else
{
$prev='&nbsp;';
$first='&nbsp;';
}

if($pageNum<$maxPage)
{
$page=$pageNum+1;
$next="<a href=\"$self?page=$page&key=$key\">Next</a>";
$last="<a href=\"$self?page=$maxPage\" class='mymenu'>[Last Page]</a>";
}
else
{
$next='&nbsp;';
$last='&nbsp;';
}
echo"<table>
<tr>
<td width='200'>&nbsp;&nbsp;&nbsp;&nbsp;$prev&nbsp;&nbsp;</td>
<td width='200'>&nbsp;&nbsp;Page $nm of $maxPage&nbsp;&nbsp;</td>
<td width='200'>&nbsp;&nbsp;$next&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;<font color='#CCCCCC'></font></td>
</tr></table></center>";
//End of Pagination


echo"<table><tr><td colspan='5'>";
?>
<input type='submit' name='print' value='Print PDF' style='background-color:lightblue;color:black ;font-size:9pt;font-weight:bold'>
<?php
echo"</td></tr></table>";
echo"</form>";


include('../footer/footer.php');
?>