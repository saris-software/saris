<?php
#get connected to the database and verify current session
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
	# initialise globals
	include('admissionMenu.php');
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Sponsorship Book';
	$szTitle = 'Select Category to view Report';
	include('admissionheader.php');
include('styles.inc');

echo "
<form action='report.php' method='POST'>
<table class='dtable' border='0'>
<tr>
<td>Academic Year:</td>
<td>";
?>
<label for="select"></label><select class="vform" id="select" name="ayear" <?php /** @var state4 $state4 */
echo $state4;?>>
<?php
echo"<option value=''>[Select Academic Year]</option>";
$nm=mysqli_query("SELECT AYear FROM academicyear where AYear!='$ayear' ORDER BY AYear DESC" , $zalongwa);
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
<td>Department/Faculty:</td>
<td>

<select name="faculty" id="select" class="vform" <?php echo $state4;?>>
<?php
echo"<option value=''>[Select Department]</option>";
echo"<option  value='all'>All departments</option>";  
$nm=mysqli_query("SELECT * FROM faculty ORDER BY FacultyName DESC" , $zalongwa);
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

<tr>
<td>Sponsor:</td>
<td>
<select name="sponsors" id="select" class="vform" <?php echo $state4;?>>
<?php
echo"<option value=''>[Select Sponsor]</option>";
$nm=mysqli_query("SELECT * FROM sponsors" , $zalongwa);
while($show = mysqli_fetch_array($nm) )
{  										 
echo"<option  value='$show[Name]'>$show[Name]</option>";  
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
