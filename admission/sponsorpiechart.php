<?php 
include('./Connections/zalongwa_data.php');
include("phpgraphlib.php");
include("phpgraphlib_pie.php");
$graph=new PHPGraphLibPie(450,350);

$data=array();
$sql="SELECT Sponsor,COUNT(*) AS 'count' FROM student GROUP BY student.Sponsor";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());	
if($result)
{
while($row = mysql_fetch_assoc($result))
{	
$salesgroup=$row["Sponsor"];
$count=$row["count"];
//ADD TO ARRAY
$data[$salesgroup]=$count;
}
}
$graph->addData($data); 
$graph->setTitle("PIE CHART OF DEPARTMENTS  BY STUDENTS");
$graph->setLabelTextColor("blue");
$graph->createGraph();
?>
