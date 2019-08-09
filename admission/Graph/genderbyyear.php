<?php
include('./Connections/zalongwa_data.php');
include("phpgraphlib.php"); 
$graph=new PHPGraphLib(500,300); 
$data=array();
$sql="SELECT EntryYear, COUNT(*) AS 'count' FROM student where student.Sex='M' GROUP BY student.EntryYear";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());	
if($result)
{
while($row = mysql_fetch_assoc($result))
{	
$salesgroup=$row["EntryYear"];
$count=$row["count"];
//ADD TO ARRAY
$data[$salesgroup]=$count;
}
}


$data2=array();
$sql1="SELECT EntryYear, COUNT(*) AS 'count' FROM student where student.Sex='F' GROUP BY student.EntryYear";
$result1 = mysql_query($sql1) or die('Query failed: ' . mysql_error());	
if($result1)
{
while($row1 = mysql_fetch_assoc($result1))
{	
$salesgroup1=$row1["EntryYear"];
$count1=$row1["count"];
//ADD TO ARRAY
$data2[$salesgroup1]=$count1;
}
}



$graph->addData($data,$data2);
$graph->setBarColor("blue", "green");
$graph->setTitle("STUDENTS  ADMITTED BY ACADEMIC YEAR BY GENDER");
$graph->setupYAxis(12, "blue");
$graph->setupXAxis(20);
$graph->setGrid(true);
$graph->setLegend(true);
$graph->setTitleLocation("left");
$graph->setTitleColor("blue");
$graph->setLegendOutlineColor("white");
$graph->setLegendTitle("MALE", "FEMALE");
$graph->setXValuesHorizontal(true);
$graph->createGraph();
?>
