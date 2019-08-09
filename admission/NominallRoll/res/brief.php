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
$department=mysql_query("select * from department where Faculty='$f[FacultyID]'");
while($d=mysql_fetch_array($department))
{
$programme=mysql_query("select * from programme where Faculty='$d[DeptName]'");
while($p=mysql_fetch_array($programme))
{
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
}
}
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



