<?php
require_once('../Connections/zalongwa.php'); 

#update course
$qcourse = "SELECT ProgrammeCode, Faculty FROM programme";
$dbcourse = mysqli_query($zalongwa,$qcourse);
while ($row_course = mysqli_fetch_assoc($dbcourse))
{
	$dept = $row_course['Faculty'];
	$progcode = $row_course['ProgrammeCode'];

	#update course
	$qcprog = "UPDATE course SET Programme = '$progcode' WHERE Department = '$dept'";
	$dbcprog = mysqli_query($zalongwa,$qcprog);
}
echo 'Mission Completed !!';
?>