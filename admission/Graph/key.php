<?php
$sql="SELECT * FROM faculty ORDER BY FacultyName";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());	
echo"<table class='dtable' cellspacing='0' cellpadding='0'>";
echo"<tr>";
echo"<th>Code</th>";
echo"<th>Description</th>";
echo"</tr>";
while($s=mysql_fetch_array($result))
{
echo"<tr>";
echo"<th>$s[FacultyID] -></th><td>$s[FacultyName]</td>";
echo"</tr>";
}
echo"</table>";
?>
