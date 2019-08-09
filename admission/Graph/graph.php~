<?php 
include('./Connections/zalongwa_data.php');
include("phpgraphlib.php");
$graph=new PHPGraphLib(500,300); 
$dataArray=array();
$sql="SELECT faculty.FacultyID, COUNT(*) AS 'count' FROM student,faculty where faculty.FacultyName=student.Faculty GROUP BY student.Faculty";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());	
if($result)
{
while($row = mysql_fetch_assoc($result))
{	
$salesgroup=$row["FacultyID"];
$count=$row["count"];
//ADD TO ARRAY
$dataArray[$salesgroup]=$count;
}
}
$graph->addData($dataArray);
$graph->setTitle("STUDENTS BY DEPARTMENT");
$graph->setTitleLocation("left");
$graph->setGradient("lime", "olive");
$graph->setBarOutlineColor("black");
$graph->setLegend(true);
$graph->setLegendTitle("Students No.");
$graph->createGraph();
?>
