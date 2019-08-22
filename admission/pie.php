<?php 
include('./Connections/zalongwa_data.php');
include("phpgraphlib.php");
include("phpgraphlib_pie.php");
$graph=new PHPGraphLibPie(450,280);

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
$graph->setTitle("PIE CHART SHOWING DEPARTMENTS STUDENTS DISTRIBUTION");
$graph->setLabelTextColor("blue");
$graph->createGraph();
?>
