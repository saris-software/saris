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

$graph->setBackgroundColor("white");
$graph->addData($data);
$graph->setBarColor("255,255,204");
$graph->setTitle("PLOT BAR GRAPH FOR STUDENT AGAINST DEPARTMENTS");
$graph->setTitleColor("blue");
$graph->setupYAxis(12, "blue");
$graph->setupXAxis(20, "blue");
$graph->setGrid(true);
$graph->setGradient("silver", "gray");
$graph->setBarOutlineColor("black");
$graph->setTextColor("black");
$graph->setDataPoints(true);
$graph->setDataPointColor("blue");
$graph->setLine(true);
$graph->setLineColor("blue");
$graph->createGraph();
?>
