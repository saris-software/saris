<?php

#get connected to the database and verfy current session

	require_once('../Connections/sessioncontrol.php');

    require_once('../Connections/zalongwa.php');

	
	# initialise globals
	include('admissionMenu.php');

	# include the header

	global $szSection, $szSubSection;

	$szSection = 'Admission Process';

	$szSubSection = 'Unregister Students';

	$szTitle = 'Search Student Record';

	include('admissionheader.php');
	
mysqli_select_db($database_zalongwa, $zalongwa);
$query_AcademicYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AcademicYear = mysqli_query($zalongwa, $query_AcademicYear) or die(mysqli_error());
$row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
$totalRows_AcademicYear = mysqli_num_rows($AcademicYear);

mysqli_select_db($database_zalongwa, $zalongwa);
$query_Hostel = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$Hostel = mysqli_query($zalongwa, $query_Hostel) or die(mysqli_error());
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);

mysqli_select_db($database_zalongwa, $zalongwa);
$query_sessions = "SELECT id, name FROM classstream";
$sessions = mysqli_query($zalongwa, $query_sessions) or die(mysqli_error());
$row_sesssions = mysqli_fetch_assoc($sessions);
$totalRows_Sessions = mysqli_num_rows($sessions);
?>

<script type="text/javascript" language="javascript">// <![CDATA[
function checkAll(formname, checktoggle)
{
  var checkboxes = new Array(); 
  checkboxes = document[formname].getElementsByTagName('input');
 
  for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].type == 'checkbox')   {
      checkboxes[i].checked = checktoggle;
    }
  }
}
// ]]></script>


<script type='text/javascript'>

function confirmupdate( data)

{

if(confirm("Are you sure you want to update the record      "+data+'\n Please review before submit'))

{

return true;

}else

{

return false;

}

}

</script>

<?php

if(isset($_POST['update']))

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
$c=0;
for($j=0;$j<$count;$j++)

{

#Fetch Records

  $sql = "SELECT * FROM student WHERE Id ='$Eq[$j]'"; 

  $update = mysqli_query($zalongwa, $sql) or die(mysqli_error($zalongwa));

  $update_row = mysqli_fetch_array($update)or die(mysqli_error($zalongwa));
  
	$regno = addslashes($update_row['RegNo']);
	$yearofstudy=addslashes($_POST['yearofstudy']);
	$ayear = addslashes($_POST['year']);
    $ActUser=$_SESSION['username'];
    $cohort = addslashes($_POST['cohot']);
    $status=$_POST['status'];
    

# check wrong yearofstudy for specific year
//$sqlcheck="SELECT YearofStudy FROM class WHERE AYear='$ayear' AND RegNo='$regno'";
//$resultcheck=mysql_query($sqlcheck);
//$numcheck=mysql_num_rows($resultcheck);
//$rowcheck=mysql_fetch_array($resultcheck);
//if($numcheck>0 && $rowcheck['YearofStudy']<>$yearofstudy){
 #update record
 $sql="UPDATE student SET Status='$status',user='$ActUser' WHERE  RegNo='$regno'";	
	

echo $sql;

$plg=mysqli_query($zalongwa, $sql);

if($plg)

{
$c++;

}else{
 echo "Student with Reg # $regno ->Fail to update<br/>";	
	}

}

}
if($c>0){
	echo '<meta http-equiv = "refresh" content ="0; 
							url = admissionUnregister.php?success=1&size='.$c.'">';
							exit;
	}

}




//Begin of Filter Panel

echo"<form action='$_SERVER[PHP_SELF]' method='POST'>

<table>

<tr>";
?>
<td><div align='right'><b>Programme:</b></div></td></td>

<td>
<select name="programme" id="programme">
				   <option value="">Select programme</option>
			            <?php
						do {  
							if(isset($_GET['programme']) && $_GET['programme']==$row_Hostel['ProgrammeCode']){
								$progselected=' selected="selected" ';
								}else{
							    $progselected='';	
									}
							
						?>
						            <option value="<?php echo $row_Hostel['ProgrammeCode']?>" <?php echo $progselected;?>><?php echo $row_Hostel['ProgrammeName']?></option>
						            <?php
						} while ($row_Hostel = mysqli_fetch_assoc($Hostel));
						  $rows = mysqli_num_rows($Hostel);
						  if($rows > 0) {
						      mysqli_data_seek($Hostel, 0);
							  $row_Hostel = mysqli_fetch_assoc($Hostel);
						  }
						?>
          			</select>

				   </td>
				   
<td><div align='right'><b>Entry Year:</b></div></td></td>

<td>
<select name="cohot" id="cohot">
			            <option value="">Select Entry year</option>
			            <?php
					do {  
						if(isset($_GET['cohot']) && $_GET['cohot']==$row_AcademicYear['AYear']){
								$yearselected=' selected="selected" ';
								}else{
							    $yearselected='';	
									}
					?>
			            <option value="<?php echo $row_AcademicYear['AYear']?>" <?php echo $yearselected;?>><?php echo $row_AcademicYear['AYear']?></option>
			            <?php
					} while ($row_AcademicYear = mysqli_fetch_assoc($AcademicYear));
					  $rows = mysqli_num_rows($AcademicYear);
					  if($rows > 0) {
					      mysqli_data_seek($AcademicYear, 0);
						  $row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
					  }
					?>
					?>
				   </select>
				   </td>				   				   				   
				   <td>
				   
<td><div align='right'><b>Year:</b></div></td></td>

<td>
<select name="year" id="year">
			            <option value="">Select academic year</option>
			            <?php
					do {  
						if(isset($_GET['year']) && $_GET['year']==$row_AcademicYear['AYear']){
								$yearselected=' selected="selected" ';
								}else{
							    $yearselected='';	
									}
					?>
			            <option value="<?php echo $row_AcademicYear['AYear']?>" <?php echo $yearselected;?>><?php echo $row_AcademicYear['AYear']?></option>
			            <?php
					} while ($row_AcademicYear = mysqli_fetch_assoc($AcademicYear));
					  $rows = mysqli_num_rows($AcademicYear);
					  if($rows > 0) {
					      mysqli_data_seek($AcademicYear, 0);
						  $row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
					  }
					?>
				   </select>
				   </td>				   				   				   
				   <td>

			   				   				   
				   <td>

<input type='submit' name='search' value='Go' style='background-color:lightblue;color:black ;font-size:9pt;font-weight:bold'>



<?php

echo"</td>

<tr>

</table></form>";

echo isset($_GET['success']) ? '<div style="color:#00FF00">'.$_GET['size'].' records updated successfully</div>': '';

if(isset($_POST['search'])||$_GET['key'])
{
	$programme=$_POST['programme'];
	//$yearofstudy=$_POST['yearofstudy'];
	$year=$_POST['year'];
	$cohort=$_POST['cohot'];
	$key=$_POST['key'];
	$status=$_POST['status'];
	
		$query="SELECT * FROM  student where ProgrammeofStudy='$programme' AND EntryYear='$cohort'";	
	
	$result=mysqli_query($zalongwa, $query) or die(mysqli_error($zalongwa));

	echo"<form action='$_SERVER[PHP_SELF]' method='POST' name='frm1'>";
?>
<table><tr><td colspan='5'>
				   
<td><div align='right'><b>Status</b></div></td></td>
<td>
<select name="status" id="status">
			            <option value="">Select option</option>
			         
			            <option value="8" >Not Registered</option>
			            <option value="3" >Registered</option>
			            
				   </select>
				   </td>				   				   
				   <td>
	<input type='submit' name='update' value='Update' style='background-color:lightblue;color:black ;font-size:9pt;font-weight:bold'

id="All selected Students ?" onClick="return confirmupdate(this.id)">
</td>
</tr>
</table>
<br/>
<?php

echo"<center>

<table width='950' cellspacing='0' cellpadding='0'>

<tr><th>Select Student(s) to Update</th>
<th>
<a onclick=\"javascript:checkAll('frm1', true);\" href=\"javascript:void();\">check all</a>
|
<a onclick=\"javascript:checkAll('frm1', false);\" href=\"javascript:void();\">uncheck all</a>
</th></tr></table>

</center>";

echo "<table cellspacing='0' border='1' width='950' cellpadding='0'>

<tr bgcolor='#E9EFF5'>

<th>sN</th>

<th>Student Name</th>
<th>RegNo</th>
<th>Programme</th>

<th>Select
</th>

</tr>";

while($r=mysqli_fetch_array($result))

{
$result_prog=mysqli_query("SELECT Title FROM programme WHERE ProgrammeCode='$r[ProgrammeofStudy]'", $zalongwa);
$row_prog=mysqli_fetch_array($result_prog);
$prog=$row_prog['Title'];
echo "<tr>

<td>&nbsp;$k</td>

<td>&nbsp;$r[Name]</td>

<td>&nbsp;$r[RegNo]</td>
<td>&nbsp;$prog</td>

<td>

<input type='checkbox' name='Eq[]' value='$r[Id]' class='cb-element'>

</td>

</tr>";

$k++;

}

echo"</table>";





$data=mysqli_query($zalongwa, $look);

$numrows=mysqli_num_rows($data);

$result=mysqli_query($zalongwa, $data);

$row=mysqli_fetch_array($data);




$self=$_SERVER['PHP_SELF'];







echo"<table>

<tr>

<td>&nbsp;&nbsp;&nbsp;<font color='#CCCCCC'></font></td>

</tr></table></center>";

//End of Pagination




?>

<?php



}


echo"</form>";


include('../footer/footer.php');
?>
