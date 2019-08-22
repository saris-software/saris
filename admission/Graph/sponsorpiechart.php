<?php 
include('./Connections/zalongwa_data.php');
include("phpgraphlib.php");
include("phpgraphlib_pie.php");
$graph=new PHPGraphLibPie(450,280);

$data=array();
$sql="SELECT Sponsor,COUNT(*) AS 'count' FROM student GROUP BY student.Sponsor";
$result = mysqli_query($zalongwa, $sql) or die('Query failed: ' . mysqli_error($zalongwa));
if($result)
{
while($row = mysqli_fetch_assoc($result))
{	
$salesgroup=$row["Sponsor"];
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
