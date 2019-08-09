<?php
mysql_connect('localhost','root','20ifm09');
mysql_select_db('zalongwaifm');


include('style.inc');

include('graph.php');
##################################################################
function  titleCase($string) 
 { 
        $len=strlen($string); 
        $i=0; 
        $last= ""; 
        $new= ""; 
        $string=strtoupper($string); 
        while  ($i<$len): 
                $char=substr($string,$i,1); 
                if  (ereg( "[A-Z]",$last)): 
                        $new.=strtolower($char); 
                else: 
                        $new.=strtoupper($char); 
                endif; 
                $last=$char; 
                $i++; 
        endwhile; 
        return($new); 
}


####################################################

echo"<form action='$_SERVER[PHP_SELF]' method='POST'>";
echo"<select name='mwaka'>";
for($w=2000;$w<date('Y');$w)
{
$y=$w+1;
$k=$w."/".$y;
echo"<option value='$k'>$k</option>";
}
echo"</select>";
echo"<input type='submit' name='data' value='View'>";
echo"</form>";

if(isset($_POST['data']))
{
$ayear=$_POST['mwaka'];

?>

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt">
<page_header>
<table class="page_header">
<tr>
<td style="width: 50%; text-align: left">
SARIS
</td>
<td style="width: 50%; text-align: right">
INSTITUTE OF FINANCE MANAGEMENT
</td>
</tr>
</table>
</page_header>

<page_footer>
<table class="page_footer">
<tr>
<td style="width: 33%; text-align: left;">
Institute of Finance Management
</td>
<td style="width: 34%; text-align: center">
Page [[page_cu]]/[[page_nb]]
</td>
<td style="width: 33%; text-align: right">
Printed on <?php echo date('d/y/m');?>
</td>
</tr>
</table>
</page_footer>


<!-- COVER PAGE--->

<bookmark title="Cover Page" level="0" ></bookmark>	
<div style="text-align: center; width: 100%;">
<br>
<img src="./images/logo.jpg" width='700' height='800'>
<br>
</div>
<br><br>
<div class="note">
NOMINALL ROLL FOR STUDENTS REGISTERED INTO THE
VARIOUS DEGREE AND NON-DEGREE 
PROGRAMMES FOR THE <?php echo $ayear;?> ACADEMIC YEAR<br>
Compiled by-<br>
Registrar
</div>
</page>



<!-- FIRST PAGE--->

<!-- PREFACE--->
<page pageset='old'>
<bookmark title="Preface" level="0" ></bookmark>	
<div style="width: 100%;float:center';">
<h4>&nbsp;PREFACE</h4><br>
<table width='100%'>
<tr><td>1</td><td>The Institute of Finance Management is hereby releasing the Nominall Roll for all registered Undergraduate students at the Institute 	 of Finance Management for the <?php echo $ayear;?> academic year.<br>
</td></tr>
<tr><td>2.</td><td>This Nonimall Roll comprises students pursuing various courses/programmes tenable at the Institute of Finance Management.
</td></tr>
<tr><td>3.</td><td>The Undergraduate programmes offered by the Institute of Finance Management in its various academic Units are as listed below:-</td>
</tr>
</table><br>
<?php
$course=mysql_query("select * from faculty");

while($c=mysql_fetch_array($course))
{
$program=mysql_query("select * from programme where Faculty='$c[FacultyName]'");
$n=mysql_num_rows($program);
if($n>0)
{
echo"<table class='dtable'>";
echo "<tr class='dhead'>";
echo"<th>SNO</th>";
echo"<th colspan='2'>$c[FacultyName]</th>";
echo"</tr>";
$w=1;
while($d=mysql_fetch_array($program))
{
echo"<tr>";
echo"<td>$w</td>";
echo "<td>$d[Title]</td><td>$d[ProgrammeName]</td>";
echo"</tr>";
$w++;
}
echo"</table><br>";
}
}
?>
</div>
</page>









<?php
//calculate year of study
$faculty=mysql_query("select * from faculty");
while($f=mysql_fetch_array($faculty))
{
$test=mysql_query("select * from student,programme where student.ProgrammeofStudy=programme.ProgrammeCode and programme.Faculty='$f[FacultyName]' group by student.EntryYear");

$test_no=mysql_num_rows($test);
$in=mysql_fetch_array($test);
if($test_no==0)
{
//SKIP NULL STUDENTS
}else
{
echo"<page pageset='old'>";
echo"<bookmark title='$f[FacultyName]' level='0' ></bookmark>";
$department=mysql_query("select * from department where Faculty='$f[FacultyID]'");
while($d=mysql_fetch_array($department))
{
echo"<bookmark title='$d[DeptName]' level='1' ></bookmark>";
$programme=mysql_query("select * from programme where Faculty='$d[DeptName]'");
while($p=mysql_fetch_array($programme))
{
echo"<bookmark title='$p[ProgrammeName]' level='2' ></bookmark>";
echo"<br>";




$ent=mysql_query("select DISTINCT(EntryYear) from student where ProgrammeofStudy='$p[ProgrammeCode]'"); 
while($e=mysql_fetch_array($ent))
{	

$cohotyear=$e['EntryYear'];

//$ayear="2010/2011";
$entry = intval(substr($cohotyear,0,4));
$current = intval(substr($ayear,0,4));
$yearofstudy=$current-$entry;


if($yearofstudy==0)
{
		$class="FIRST YEAR";
		}elseif($yearofstudy==1){
		$class="SECOND YEAR";
		}elseif($yearofstudy==2){
		$class="THIRD YEAR";
		}elseif($yearofstudy==3){
		$class="FOURTH YEAR";
		}elseif($yearofstudy==4){
		$class="FIFTH YEAR";
		}elseif($yearofstudy==5){
		$class="SIXTH YEAR";
		}elseif($yearofstudy==6){
		$class="SEVENTHND YEAR";
		}else{
		$class="$yearofstudy";
}



if($entry)
{

echo"<bookmark title='$class' level='3' ></bookmark>";
echo"<h2>$class:&nbsp;$p[Title]-$p[ProgrammeName]</h2>";

echo"<table width='990' class='dtable' cellspacing='1' cellpadding='1'>";
$query=mysql_query("select * from student where ProgrammeofStudy='$p[ProgrammeCode]' and EntryYear='$e[EntryYear]'");
echo"<tr class='dhead'>";
echo"<th>S/No</th>
<th>Name</th>
<th>Sex</th>
<th>Nationality</th>
<th>RegNo.</th>
<th>Entry</th>
<th>Programme</th>
<th>Sponsor</th>";
echo"</tr>";
$k=1;
while($r=mysql_fetch_array($query))
{
$st=mysql_query("select * from mannerofentry where ID='$r[MannerofEntry]'");
$s=mysql_fetch_array($st);

$pr=mysql_query("select * from programme where ProgrammeCode='$r[ProgrammeofStudy]'");
$p=mysql_fetch_array($pr);
$status=$s['Status'];
//NAMES
$rawname = $r['Name'];
$expsurname = explode(",",$rawname);
$surname = strtoupper($expsurname[0]);
$othername = $expsurname[1];
$expothername = explode(" ", $othername);
$firstname = $expothername[1];
$middlename = $expothername[2].' '.$expothername[3];
$sn=strtoupper($surname);
$fn=titleCase($firstname);
$ln=titleCase($middlename);


$study=$yearofstudy+1;

echo"<tr>
<td>$k</td>
<td>$sn,&nbsp;$fn&nbsp;$ln</td>
<td>$r[Sex]</td>
<td>$r[Nationality]</td>
<td>$r[RegNo]</td>
<td>$s[MannerofEntry]</td>
<td>$study &nbsp;$p[ProgrammeName]</td>
<td>$r[Sponsor]</td>
</tr>";
$k++;
}
echo"</table><br><br><br>
<br><br><br>";

}
else
{
//NO ENTRY YEAR HAVE BEEN SPECIFIED FOR THIS STUDENTS
}
}
}
}
echo"</page>";
}
}
?>	
<page pageset="old">
<bookmark title="Summary" level="0" ></bookmark>	
<div class="note">
<?php
echo"<table><tr>";
echo"<th >ADMISSION SUMMARY REPORT.</th></tr></table>";
echo"<table class='dtable'>";
echo"<tr><td>S/NO</td>
<td>Department</td>
<td>Description</td>
<td>No.Students</td></tr>";
//$a=mysql_query("select Faculty,count(*) as 'idadi' from student group by Faculty");
$l="select faculty.FacultyID as 'degree', COUNT(*) AS 'idadi' from student,faculty where student.Faculty=faculty.FacultyName GROUP BY student.faculty";

$a=mysql_query($l);
$j=1;
while($h=mysql_fetch_array($a))
{
$pw=mysql_query("select * from student,faculty where student.Faculty=faculty.FacultyName and faculty.FacultyID='$h[degree]' GROUP BY student.faculty");
$d=mysql_fetch_array($pw);
echo"<tr>
<td>$j</td>
<td>$h[degree]</td>
<td>$d[FacultyName]</td>
<td>$h[idadi]</td></tr>";
$j++;
}
echo"</table>";
?>
</div>

<br>
<img src='./images/graph.jpeg'>

</page>

<?php
}
?>

