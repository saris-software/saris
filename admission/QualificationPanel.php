<?php
   #POST connected to the database and verify current session
    require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# initialise globals
	include('admissionMenu.php');
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Admission Process';
	$szSubSection = 'Qualification Entry';
	$szTitle = 'Four Form Results Recording';
	include('admissionheader.php');
include('styles.inc');

echo"<table cellpadding='0' cellspacing='0'>";
echo"<tr>
<td>
<fieldset>
<legend>Form  four Results</legend>
<form action='studentlist.php' method='POST'>
<input type='hidden' name='category' value='1'>
<input type='submit' value='Add Form Four Results'>
</legend>
</form>
</fieldset>
</td>

<td>
<fieldset>
<legend>Form  Six Results</legend>
<form action='studentlist.php' method='POST'>
<input type='hidden' name='category' value='2'>
<input type='submit' value='Add Form Six Results'>
</legend>
</form>
</fieldset>
</td>

<td>
<fieldset>
<legend>Equivalent Results</legend>
<form action='studentlist.php' method='POST'>
<input type='hidden' name='category' value='3'>
<input type='submit' value='Add Equivalent Results'>

</legend>
</form>
</fieldset>
</td>

</tr>
</table>";

?>



