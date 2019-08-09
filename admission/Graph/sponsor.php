<?php 
include('./Connections/zalongwa_data.php');
include("phpgraphlib.php");
$graph=new PHPGraphLib(500,300); 
$dataArray=array();
$sql="SELECT Sponsor,COUNT(*) AS 'count' FROM student GROUP BY student.Sponsor";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());	
if($result)
{
while($row = mysql_fetch_assoc($result))
{	
$salesgroup=$row["Sponsor"];
$count=$row["count"];
//ADD TO ARRAY
$dataArray[$salesgroup]=$count;
}
}
$graph->addData($dataArray);
$graph->setTitle("STUDENTS BY SPONSORSHIP");
$graph->setTitleLocation("left");
$graph->setGradient("lime", "olive");
$graph->setBarOutlineColor("black");
$graph->setLegend(true);
$graph->setLegendTitle("Students No.");
$graph->createGraph();
?>
