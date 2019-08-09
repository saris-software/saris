<?php
#get connected to the database and verfy current session
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
# initialise globals
include('admissionMenu.php');
# include the header
global $szSection, $szSubSection;
$szSection = 'Admission Process';
$szSubSection = 'Add form four Results';
$szTitle = 'Student List Four Form Results Recording';
include('admissionheader.php');

$rowPerPage=20;
$pageNum=1;

echo"<form action='$_SERVER[PHP_SELF]' method='GET'>";
echo"<table>
<tr><td>Search by Admission No /Reg No</td>
<td><input type='text' name='regno'></td>
<td><input type='submit' name='Go' value='Go'></td></tr>
</table>";
echo"</form>";

if(isset($_GET['page']))
{
$pageNum=$_GET['page'];
}
$offset=($pageNum-1)*$rowPerPage;
$sn=$offset+1;

if(isset($_GET['regno']))
{
$regno=$_GET['regno'];
$student="SELECT * FROM student where AdmissionNo  like '%$regno'";
}else
{
$student="SELECT * FROM student";
}
include('styles.inc');

$cat=mysql_query($student ." LIMIT $offset,$rowPerPage");
$num=mysql_num_rows($cat);
echo "<table class='dtable' width='750' cellspacing='0' cellpadding='0'>";
echo"<tr>
<th>S/N</th>
<th>Name</th>
<th>AdmissionNo</th>
<th>OPTION</th>
</tr>";
while($j=mysql_fetch_array($cat))
{
echo"<form action='olevel.php' method='GET'>
<tr class='dhead'>
<td>&nbsp;$sn</td>
<td>&nbsp;$j[Name]</td>
<td>&nbsp;$j[AdmissionNo]</td>
<td>
<input type='hidden' name='index' value='$j[form4no]'>
<input type='hidden' name='regno' value='$j[AdmissionNo]'>
<input type='submit' value='Add form four Results'>
</td>
</tr></form>";
$sn++;
}
echo "</table>";
$rec=mysql_query($student);
$numrows=mysql_num_rows($rec);
$resu=mysql_query($rec);
$row=mysql_fetch_array($rec);
$maxPage=ceil($numrows/$rowPerPage);
$self=$_SERVER['PHP_SELF'];
$nav='';
for($page=1;$page<=$maxPage;$page++)
{
if($page==$pageNum)
{
$nav.=" $page";
$nm=$page;
}else
{
$nav.="<a href=\"$self?page=$page\" class='mymenu'>$page</a>";

}
}
if($pageNum>1)
{
$page=$pageNum-1;
$prev="<a href=\"$self?page=$page\"><img src='./images/previous.gif'></a>";
$first="<a href=\"$self?page=1\" class='mymenu'>[First]</a>";
}
else
{
$prev='&nbsp;';
$first='&nbsp;';
}

if($pageNum<$maxPage)
{
$page=$pageNum+1;
$next="<a href=\"$self?page=$page\" class='mymenu'><img src='./images/next.gif'></a>";
$last="<a href=\"$self?page=$maxPage\" class='mymenu'>[Last Page]</a>";
}
else
{
$next='&nbsp;';
$last='&nbsp;';
}
$d=date('Y');
$cd=date('d/m/y');
echo"<center><table>
<tr>
<td>&nbsp;$prev&nbsp; </td>
<td>&nbsp;&nbsp;Page $nm of $maxPage&nbsp;</td>
<td>&nbsp;$next&nbsp;</td>
</tr></table></center>";
?>


