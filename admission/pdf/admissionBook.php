<?php
#get connected to the database and verfy current session
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');

mysqli_select_db($database_zalongwa, $zalongwa);
	# initialise globals
	include('admissionMenu.php');
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Registration Form';
	$szTitle = 'Select Academic Year to view admitted Students';
	include('admissionheader.php');


echo "
<form action='admissionReport.php' method='POST'>
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
$nm=mysqli_query("SELECT * FROM faculty ORDER BY FacultyName DESC", $zalongwa);
while($show = mysqli_fetch_array($nm) )
{  										 
echo"<option  value='$show[FacultyID]'>$show[FacultyName]</option>";      
}
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
