<?php
#get connected to the database and verfy current session
mysqli_connect('localhost','root','');
mysqli_select_db($zalongwa,'zalongwaifm');
echo "
<form action='admissionBookReport.php' method='POST'>
<table>
<tr>
<td class='formfield'>Academic Year:</td>
<td>";
?>
<select name="ayear" id="select" class="vform" <?php echo $state4;?>>
<?php
echo"<option value=''>[Select Academic Year]</option>";
$nm=mysqli_query($zalongwa,"SELECT AYear FROM academicyear where AYear!='$ayear' ORDER BY AYear DESC");
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
$nm=mysqli_query($zalongwa,"SELECT * FROM faculty ORDER BY FacultyName DESC");
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
