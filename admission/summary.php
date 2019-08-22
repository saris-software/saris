<?php
   #POST connected to the database and verfy current session
    require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# initialise globals
	include('admissionMenu.php');
	# include the header
	global $szSection, $szSubSection;
        $szSection = 'Admission Process';
	$szSubSection = 'Statistics';
	$szTitle = 'Admission Record Filtering';
	include('admissionheader.php');
include('styles.inc');

echo "
<form action='$_SERVER[PHP_SELF]' method='POST'>
<table>
<tr>
<td class='formfield'>Academic Year:</td>
<td>";
?>
<select name="ayear" id="select" class="vform" <?php /** @var state4 $state4 */
echo $state4;?>>
<?php
echo"<option value=''>[Select Academic Year]</option>";
$nm=mysqli_query("SELECT AYear FROM academicyear where AYear!='$ayear' ORDER BY AYear DESC", $zalongwa);
while($show = mysqli_fetch_array($nm) )
{  										 
echo"<option  value='$show[AYear]'>$show[AYear]</option>";      
}
?>					                                        						 
</select>
</td>
<td>
</td>
</tr>
<tr>
<td class='formfield'>Department/Faculty:</td>
<td>
<select name="faculty" id="select" class="vform" <?php echo $state4;?>>
<?php
echo"<option value=''>[Select Department]</option>";
echo"<option  value='all'>All departments</option>";  
$nm=mysqli_query("SELECT * FROM faculty ORDER BY FacultyName DESC", $zalongwa);
while($show = mysqli_fetch_array($nm) )
{  										 
echo"<option  value='$show[FacultyID]'>$show[FacultyName]</option>";
}
echo"<option  value='all'>All departments</option>";   
?>							                                        				 
</select>
</td>
<td>
</td>
</tr>
<tr><td></td><td>
<input type='submit' name='Go' value='Go'>
</td>
</tr>
</table>
</form>

<?php
if(isset($_POST['Go']))
{
$faculty=$_POST['faculty'];
$ayear=$_POST['ayear'];

if($faculty)
{
if($faculty=="all")
{
$ct="select * from faculty";
$dept="ALL DEPARTMENTS";
$male_all=mysqli_query("SELECT * FROM student WHERE Sex='M' and EntryYear='$ayear'", $zalongwa);
$male_total=mysqli_num_rows($male_all);
$female_all=mysqli_query("SELECT * FROM student WHERE  Sex='F' and EntryYear='$ayear'", $zalongwa);
$female_total=mysqli_num_rows($female_all);
}else
{
$ct="select * from faculty  where FacultyID='$faculty'";
$dp=mysqli_query("select * from faculty where FacultyID='$faculty'", $zalongwa);
$d=mysqli_fetch_array($dp);
$facultyName=$d['FacultyName'];
$dept=strtoupper($d['FacultyName']);
$male_all=mysqli_query("SELECT * FROM student WHERE Faculty='$facultyName' and Sex='M' and EntryYear='$ayear'", $zalongwa);
$male_total=mysqli_num_rows($male_all);
$female_all=mysqli_query("SELECT * FROM student WHERE Faculty='$facultyName' and Sex='F' and EntryYear='$ayear'", $zalongwa);
$female_total=mysqli_num_rows($female_all);
}

$jumla=$female_total+$male_total;
if(($jumla>0))
{
$male_pecentage=($male_total/$jumla)*100;
$female_pecentage=($female_total/$jumla)*100;
}
else
{
$male_pecentage=0;
$female_pecentage=0;
}
}
else
{
$ct="select * from faculty";

}
$query=mysqli_query($zalongwa, $ct)or die(mysqli_error($zalongwa));
$pg=1;

echo "Male: $male_pecentage %<br>";
echo "Female: $female_pecentage %<br>";
echo"<table width='1000'><tr>";
echo"<th >ADMISSION SUMMARY FOR ACADEMIC YEAR $ayear UNDER $dept.</th></tr></table>";
echo"<table  border='1' cellspacing='0' cellpadding='0' width='950' class='dtable'>";
echo"<tr bgcolor='#ccccff'>
<th>S/N</th>
<th>Department</th>
<th colspan='2'>Programe</th>
<th>Male</th>
<th>Female</th>
<th>Total</th>
</tr>";
while($r=mysqli_fetch_array($query))
{
$cat=mysqli_query("SELECT  * FROM programme WHERE Faculty='$r[FacultyName]'", $zalongwa);
$num=mysqli_num_rows($cat);
$students=mysqli_query("SELECT * FROM student WHERE ProgrammeofStudy='$r[Title]' and EntryYear='$ayear'", $zalongwa) or die(mysqli_error($zalongwa));
$M=0;
$F=0;
while($count=mysqli_fetch_array($students))
{
if($count['Sex']=='M')
{
$M++;
}else
{
$F++;
}
}
echo "<tr>
<td rowspan='$num'>$pg</td>
<td rowspan='$num'>&nbsp;$r[FacultyName]</td>";
$g=mysqli_query("SELECT  * FROM programme where Faculty='$r[FacultyName]'");
$total=mysqli_num_rows($g);
if($total>0)
{
while($gl=mysqli_fetch_array($g))
{
//Count All students
$student_no=mysqli_num_rows($students);
//Count MALE STUDENTS
$male_students=mysqli_query("SELECT * FROM student WHERE ProgrammeofStudy='$gl[ProgrammeCode]' and Sex='M' and EntryYear='$ayear'", $zalongwa);
$male_student_no=mysqli_num_rows($male_students);
//Count FEMALE STUDENTS
$female_students=mysqli_query("SELECT * FROM student WHERE ProgrammeofStudy='$gl[ProgrammeCode]' and Sex='F' and EntryYear='$ayear'", $zalongwa);
$female_student_no=mysqli_num_rows($female_students);
$wote=$female_student_no+$male_student_no;
echo"<td>&nbsp;$gl[ProgrammeName]</td>
<td>&nbsp;$gl[Title]</td>
<td>&nbsp;$male_student_no</td>
<td>&nbsp;$female_student_no</td>";
echo "<td>&nbsp;$wote</td>";
echo"</tr>";
}
}else
{
    /** @var male_student $male_student_no */
    /** @var female_student $female_student_no */
    echo"<td>&nbsp;$gl[ProgrammeName]</td>
<td>&nbsp;$gl[Title]</td>
<td>&nbsp;$male_student_no</td>
<td>&nbsp;$female_student_no</td>";
    /** @var wote $wote */
    echo "<td>&nbsp;$wote</td>";
echo"</tr>";
}
$pg++;
}
echo"</table>";
}
else
{
}
?>
