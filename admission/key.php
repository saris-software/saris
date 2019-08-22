<?php
$sql="SELECT * FROM faculty ORDER BY FacultyName";
$result = mysqli_query($zalongwa, $sql) or die('Query failed: ' . mysqli_error($zalongwa));
echo"<table class='dtable' cellspacing='0' cellpadding='0'>";
echo"<tr>";
echo"<th>Code</th>";
echo"<th>Description</th>";
echo"</tr>";
while($s=mysqli_fetch_array($result))
{
echo"<tr>";
echo"<th>$s[FacultyID] -></th><td>$s[FacultyName]</td>";
echo"</tr>";
}
echo"</table>";
?>
