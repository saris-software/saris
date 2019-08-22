<?php 
include('./Connections/zalongwa_data.php');
include("phpgraphlib.php");
$graph=new PHPGraphLib(500,300); 
$data=array();
$sql="SELECT EntryYear, COUNT(*) AS 'count' FROM student where student.Sex='M' GROUP BY student.EntryYear";
$result = mysqli_query($zalongwa, $sql) or die('Query failed: ' . mysqli_error($zalongwa));
if($result)
{
while($row = mysqli_fetch_assoc($result))
{	
$salesgroup=$row["EntryYear"];
$count=$row["count"];
//ADD TO ARRAY
$data[$salesgroup]=$count;
}
}


$data2=array();
$sql1="SELECT EntryYear, COUNT(*) AS 'count' FROM student where student.Sex='F' GROUP BY student.EntryYear";
$result1 = mysqli_query($zalongwa, $sql1) or die('Query failed: ' . mysqli_error($zalongwa));
if($result1)
{
while($row1 = mysqli_fetch_assoc($result1))
{	
$salesgroup1=$row1["EntryYear"];
$count1=$row1["count"];
//ADD TO ARRAY
$data2[$salesgroup1]=$count1;
}
}
$graph->addData($data,$data2);

$graph->setTitle("STUDENTS BY ENTRY YEAR");
$graph->setTitleLocation("left");
//$graph->setGradient("blue", "olive");
$graph->setBarColor("green", "blue");
$graph->setBarOutlineColor("black");
$graph->setLegend(true);
$graph->setLegendTitle("MALE", "FEMALE");
$graph->createGraph();
?>
