<?php
?>
<style type="text/css">
<!--
	table.page_header 
	{
	width: 100%;
	border: 0px; 
	background-color: #F7F7F4; 
	border-bottom:1px solid #F7F7F4;
	padding: 2mm 
	}
	.page_table 
	{
	width: 100%;
	border: 1px solid black; 
	background-color: #F7F7F4; 
	}
	table.page_footer
	{
	width: 100%; 
	border: none; 
	background-color:white;
	border-top: solid 1px white;
	padding: 2mm
       
        }
	div.note {
	border: solid 1mm #F7F7F4;
	background-color: #F7F7F4; 
	padding: 2mm; 
	border-radius: 2px 2px;
	width: 100%;
	}
	h1 {
	text-align: center; 
	font-size: 2px;
	}
	h3 {
	text-align: center; 
	font-size: 1px;
	}

table.dtable td{
border-left: 1px solid #cfcfcfc; 
border-top: 1px solid #cfcfcfc; 

}
.dtable{
border-right: 1px solid black;
border-bottom: 1px solid black;  
background-color:white ;
width:100%;
}
.dhead th
{
background-color: #F7F7F4; 
border-left:1px solid black;
border-top:1px solid black;
text-align:center;
}
-->
</style>
<?php

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
$ayear=$_POST['ayear'];
$faculty=$_POST['faculty'];
//$sponsors=$_POST['sponsors'];
if($faculty=="all")
{
$db=mysql_query("select * from faculty ORDER by FacultyName");
$db_down=mysql_query("select * from faculty ORDER by FacultyName");

$dept="";//strtoupper('ALL DEPARTMENTS');
}else
{
$db=mysql_query("select * from faculty where FacultyID='$faculty'");
$dp=mysql_query("select * from faculty where FacultyID='$faculty'");
$db_down=mysql_query("select * from faculty where FacultyID='$faculty'");
$d=mysql_fetch_array($dp);
$dept="";//strtoupper($d['FacultyName']);
}
?>

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt">
<page_header>
<table class="page_header">
<tr>
<td style="width: 50%; text-align: left">
SARIS
</td>
<td style="width: 50%; text-align: right">
Institute of Finance Management
</td>
</tr>
</table>
</page_header>

<page_footer>
<table class="page_footer">
<tr>
<td style="width: 33%; text-align: left;">
Institute of Finance Management <?php echo $dept;?>
</td>
<td style="width: 34%; text-align: center">
Page [[page_cu]]/[[page_nb]]
</td>
<td style="width: 20%; text-align: right">
Printed On<?php echo date('d/m/y');?>
</td>
</tr>
</table>
</page_footer>

<bookmark title="Cover Page" level="0" ></bookmark>	
<div style="text-align: center; width: 100%;">
<br>
<img src="./images/makumira.jpg" width='700' height='800'>

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

while($f=mysql_fetch_array($db))
{
$registered=mysql_query("select * from student,programme where programme.ProgrammeCode=student.ProgrammeofStudy  and programme.Faculty='$f[FacultyName]' and student.EntryYear='$ayear'")or die(mysql_error());
$nms=mysql_num_rows($registered);
if($nms>0)
{
echo"<page pageset='old'>";
echo"<bookmark title='$f[FacultyName]' level='0' ></bookmark>";
$department=mysql_query("select * from programme where Faculty='$f[FacultyName]'  ORDER by ProgrammeName");	
while($p=mysql_fetch_array($department))
{

//$query=mysql_query("select * from student where ProgrammeofStudy='$p[ProgrammeCode]' and Sponsor='$sponsors' and student.EntryYear='$ayear'");

$query=mysql_query("select * from student where ProgrammeofStudy='$p[ProgrammeCode]' and EntryYear='$ayear'");
$ntest=mysql_num_rows($query);
if($ntest>0)
{
echo"<bookmark title='$p[ProgrammeName]' level='1' ></bookmark>";
echo"<h2>$p[Title]-$p[ProgrammeName]</h2>";
echo"<br>";

echo"<table width='990' class='dtable' cellspacing='1' cellpadding='1'>";

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
<td>$r[AdmissionNo]</td>
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
//echo"No Students have be enrolled in this course";
}

}
echo"</page>";

}
}
?>	
<page pageset="old">
<bookmark title="Summary" level="0" ></bookmark>	
<?php
echo"<table><tr>";
echo"<th >ADMISSION SUMMARY REPORT.</th></tr></table>";
echo"<table class='dtable'>";
echo"<tr class='dhead'><td>S/NO</td>
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

</page>
