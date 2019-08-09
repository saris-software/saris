<?php
mysql_connect('localhost','root','deo');
mysql_select_db('zalongwamuco');
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
&copy;SARIS <?php echo date('Y');?>
</td>
</tr>
</table>
</page_footer>

<bookmark title="Cover Page" level="0" ></bookmark>	
<div style="text-align: center; width: 100%;">
<br>
<img src="./images/logo.jpg" width='700' height='800'>
<br>
</div>
<br><br>
<div class="note">
Email:&nbsp;dvc@africaonline.com<br>
Url:&nbsp;http://www.ifm.ac.tz<br>
Postal Address:&nbsp;78890 DAR ES SALAAM<br>
</div>
</page>


<?php
$faculty=mysql_query("select * from faculty");
while($f=mysql_fetch_array($faculty))
{
$test=mysql_query("select * from student,programme where student.ProgrammeofStudy=programme.ProgrammeCode and programme.Faculty='$f[FacultyName]'");

$test_no=mysql_num_rows($test);
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
echo"<h2>$p[Title]-$p[ProgrammeName]</h2>";

echo"<table width='1000' class='dtable' cellspacing='1' cellpadding='1'>";
$query=mysql_query("select * from student where ProgrammeofStudy='$p[ProgrammeCode]' limit 20");
echo"<tr class='dhead'>";
echo"<th>S/N</th>
<th>Name</th>
<th>REGNO</th>
<th>SEX</th>
<th>SPONSOR</th>
<th>STATUS</th>";
echo"</tr>";
$k=1;
while($r=mysql_fetch_array($query))
{
$st=mysql_query("select * from studentstatus where StatusID='$r[Status]'");
$s=mysql_fetch_array($st);
$status=$s['Status'];
//NAMES
$rawname = $r['Name'];
$expsurname = explode(",",$rawname);
$surname = strtoupper($expsurname[0]);
$othername = $expsurname[1];
$expothername = explode(" ", $othername);
$firstname = $expothername[1];
$middlename = $expothername[2].' '.$expothername[3];
$sn=titleCase($surname);
$fn=titleCase($firstname);
$ln=titleCase($middlename);


echo"<tr>
<td>$k</td>
<td>$sn &nbsp;$fn,$ln</td>
<td>$r[RegNo]</td>
<td>$r[Sex]</td>
<td>$r[Sponsor]</td>
<td>$status</td>
</tr>";
$k++;
}
echo"</table><br><br><br>
<br><br><br>";
}
}
echo"</page>";
}
}
?>	
<page pageset="old">
<bookmark title="Summary" level="0" ></bookmark>	
<div class="note">
</div>
<?php
$ct="select * from faculty";
$query=mysql_query($ct);
echo"<table  border='1' cellspacing='0' cellpadding='0' width='1000' class='dtable'>";
echo"<tr bgcolor='#ccccff'>
<th>S/N</th>
<th colspan='2'>Faculty</th>
<th colspan='2'>Programe</th>
<th>Male</th>
<th>Female</th>
<th>Total</th>
</tr>";
while($r=mysql_fetch_array($query))
{
$cat=mysql_query("SELECT  * FROM programme WHERE Faculty='$r[FacultyName]'");
$num=mysql_num_rows($cat);

$students=mysql_query("SELECT * FROM student WHERE ProgrammeofStudy='$r[Title]'");
$M=0;
$F=0;
while($count=mysql_fetch_array($students))
{
if($count['Sex']=='M')
{
$M++;
}else
{
$F++;
}
}
echo "<tr>
<td rowspan='$num'>$pg</td>
<td rowspan='$num'>$r[FacultyID]</td>
<td rowspan='$num'>$r[FacultyName]</td>";
$g=mysql_query("SELECT  * FROM programme where Faculty='$r[FacultyName]'");
$total=mysql_num_rows($g);
if($total>0)
{
while($gl=mysql_fetch_array($g))
{
//Count All students
$student_no=mysql_num_rows($students);
//Count MALE STUDENTS
$male_students=mysql_query("SELECT * FROM student WHERE ProgrammeofStudy='$gl[ProgrammeCode]' and Sex='M'");
$male_student_no=mysql_num_rows($male_students);
//Count FEMALE STUDENTS
$female_students=mysql_query("SELECT * FROM student WHERE ProgrammeofStudy='$gl[ProgrammeCode]' and Sex='F'");
$female_student_no=mysql_num_rows($female_students);
$wote=$female_student_no+$male_student_no;
echo"<td>$gl[ProgrammeName]</td>
<td>$gl[Title]</td>
<td>$male_student_no</td>
<td>$female_student_no</td>";
echo "<td>$wote</td>";
echo"</tr>";
}
}else
{
echo"<td>$gl[ProgrammeName]</td>
<td>$gl[Title]</td>
<td>$male_student_no</td>
<td>$female_student_no</td>";
echo "<td>$wote</td>";
echo"</tr>";
}
$pg++;
}
echo"</table>";
?>
</page>


