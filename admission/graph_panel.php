<?php
include('./Connections/zalongwa_data.php');
include('styles.inc');
$data1=array(
"gender.php",
"graph.php",
"pie.php",
"plot.php",
"plotbar.php",
"genderbyyear.php",
"sponsor.php",
"sponsorpiechart.php",
"admissionbyyear.php"
);

$data2=array("Students by Gender Bar Graph",
"Students By Department",
"Students by Department Pie Chart",
"Students by Department plot graph",
"Students By Department plot+Bar Graph",
"Students By Gender By Year",
"Students By Sponsorship Bar Graph",
"Students By Sponsorship Pie Chart",
"Admission By Year"
);

//Panel for selection
echo"<center>";
echo"<form action='$_SERVER[PHP_SELF]' method='POST'>";
echo"<select name='graph'>";
echo"<option value=''>[Select Graph Type]</option>";
for($g=0;$g<count($data1);$g++)
{
echo"<option value='$data1[$g]'>$data2[$g]</option>";
}
echo"</select>";
echo"<input type='submit' name='ok' value='ok'>";
echo"</form>";
echo"</center>";
echo"<a href='summary.php'>Summary Admission Report</a>";
//Display Graph here
if(isset($_POST['ok']))
{
$graph=$_POST['graph'];
if($graph)
{

echo"<table class='dtable' cellspacing='5' cellpadding='0' width='1000'>";
echo"<tr>";
echo"<td width='500'>";
echo"<img src='$graph' />";
echo"<br><br><br>";
echo"</td>";
//echo"</tr><tr>";
echo"<td>";
echo"KEYS";
include('key.php');
echo"</td>";
echo"</tr>";
echo"</table>";
}else
{
echo"Choose Graph Please";
}
}


?>

