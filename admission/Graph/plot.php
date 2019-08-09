<?php
include('./Connections/zalongwa_data.php');
include("phpgraphlib.php"); 
$graph=new PHPGraphLib(500,300); 
$data=array();
$sql="SELECT faculty.FacultyID, COUNT(*) AS 'count' FROM student,faculty where faculty.FacultyName=student.Faculty and student.Sex='M' GROUP BY student.Faculty";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());	
if($result)
{
while($row = mysql_fetch_assoc($result))
{	
$salesgroup=$row["FacultyID"];
$count=$row["count"];
//ADD TO ARRAY
$data[$salesgroup]=$count;
}
}
$graph->addData($data);
$graph->setTitle("PLOT GRAPH STUDENTS AGAINTS DEPARTMENTS");
$graph->setBars(false);
$graph->setLine(true);
$graph->setDataPoints(true);
$graph->setDataPointColor("maroon");
$graph->setDataValues(true);
$graph->setDataValueColor("maroon");
$graph->setGoalLine(.0025);
$graph->setGoalLineColor("red");
$graph->createGraph();
?>
