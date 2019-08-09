<?php
mysql_connect('localhost','root','deo');
mysql_select_db('zalongwamuco');
include('style.inc');


echo"<form action='NominallRoll.php' method='POST'>
?>
<table>
<tr>
<td nowrap="nowrap" class='formfield'>Year of Admission:<span class="style2">*</span></td>
<td class='ztable'>
<select name="ayear" id="select" class="vform" <?php echo $state4;?> title="Select Year of Admission">
<?php
if(!$ayear)
{
echo"<option value=''>[Select Academic Year]</option>";
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
<input type='submit' value='Go'>
</td>
</table>
</form>
