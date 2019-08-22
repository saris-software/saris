<?php
include('./Connections/zalongwa_data.php');
include("phpgraphlib.php"); 
$graph=new PHPGraphLib(500,300); 
$data=array();
$sql="SELECT faculty.FacultyID, COUNT(*) AS 'count' FROM student,faculty where faculty.FacultyName=student.Faculty and student.Sex='M' GROUP BY student.Faculty";
$result = mysqli_query($zalongwa, $sql) or die('Query failed: ' . mysqli_error($zalongwa));
if($result)
{
while($row = mysqli_fetch_assoc($result))
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
