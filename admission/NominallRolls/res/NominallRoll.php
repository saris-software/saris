<?php
mysql_connect('localhost','root','deo');
mysql_select_db('zalongwamuco');


include('style.inc');

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


<!-- COVER PAGE--->

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


<!-- FIRST PAGE--->

<!-- COVER PAGE--->
<page pageset='old'>
<bookmark title="First Page" level="0" ></bookmark>	
<div style="width: 100%;float:center';">
<table width='100%' border='0'cellspacing='3' cellpadding='0'>
<tr>
<td width='150'>&nbsp;</td>
<td width='850'>
INSTITUTE&nbsp; OF&nbsp; FINANCE MANAGEMENT&nbsp;&nbsp;
</td>
<td width='50'>&nbsp;</td>
</tr>
<tr>
<td width='200'>&nbsp;</td>
<td width='800'><img src='./images/fontlogo.jpg'></td>
<td width='200'>&nbsp;</td>
</tr>
</table>

<table width='100%' border='0'cellspacing='3' cellpadding='0'>
<tr>
<td width='50'>&nbsp;</td>
<td width='900'>
NOMINALL ROLL FOR STUDENTS REGISTERED INTO THE
VARIOUS UNDERGRADUATE DEGREE AND NON-DEGREE 
PROGRAMMES FOR THE 2009/2010 ACADEMIC YEAR
</td>
<td width='50'>&nbsp;</td>
</tr>
</table>


<table width='100%' border='0'cellspacing='3' cellpadding='0'>
<tr>
<td width='50'>
Compiled by-
</td>
<td width='900'>

THE OFFICE OF THE DEPUTY VICE CHANCELOR FOR ACADEMIC,RESEARCH AND CONSULTANCY
DIRECTOR OF UNDERGRADUATE STUDIES MATRICULATION AND ADMISSIONS SECTION
</td>
<td width='50'>
&nbsp;
</td>
</tr>

</table>

</div>
<br><br>
<div class="note" style="text-align: center;">
<?php
echo date('M').",".date('Y');
?>
</div>
</page>


<!-- FIRST PAGE--->

<!-- PREFACE--->
<page pageset='old'>
<bookmark title="Preface" level="0" ></bookmark>	
<div style="width: 100%;float:center';">
PREFACE PREFACE PREFACE
</div>
<br><br>
<div class="note" style="text-align: center;">
<?php
echo date('M').",".date('Y');
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

$ayear="2010/2011";
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

echo"<table width='1000' class='dtable' cellspacing='1' cellpadding='1'>";
$query=mysql_query("select * from student where ProgrammeofStudy='$p[ProgrammeCode]' and EntryYear='$e[EntryYear]' limit 20");
echo"<tr class='dhead'>";
echo"<th>S/No</th>
<th>Name</th>
<th>SEX</th>
<th>NATIONALITY</th>
<th>REGNO</th>
<th>ENTERY</th>
<th>PROGRAMME</th>
<th>SPONSOR</th>";
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
?>
</div>
<?php
$M=0;
$F=0;
$U=0;
$Total=0;
$HSLB=0;
$Private=0;
$Total_Mkopo=0;
$U_MKOPO=0;
$T_mkopo=0;
$ct="select * from faculty";
$query_last=mysql_query($ct);
echo"<table  cellspacing='0' cellpadding='0' width='1000' class='dtable'>";
echo"<tr class='dhead'>
<th>S/N</th>
<th>Faculty</th>
<th>Male</th>
<th>Female</th>
<th>Total</th>
<th>Private</th>
<th>HSLB</th>
<th>Total</th>
</tr>";
$pg=1;
while($sm=mysql_fetch_array($query_last))
{
$cat=mysql_query("SELECT  * FROM programme WHERE Faculty='$sm[FacultyName]'");
$num=mysql_num_rows($cat);
//Count Genders
$students=mysql_query("SELECT * FROM student WHERE Faculty='$sm[FacultyName]'");
$sk=mysql_fetch_array($students);
if($sk['Sex']=='M')
{
$M++;
}else
{
if($sk['Sex']=='F')
{
$F++;
}else
{
$U++;
}
}
//END OF GENDER COUNTING

//Count MKOPO
if($sk['Sponsor']=='Private')
{
$Private++;
}else
{
if($sk['Sponsor']=='HSLB')
{
$HSLB++;
}else
{
$U_MKOPO++;
}
}
//END OF MKOPO


echo "<tr>
<td>$pg</td>
<td>$sm[FacultyName]</td>
<td>$M</td>
<td>$F</td>";
$T=$F+$M;
$Total=$Total+$T;
$T_mkopo=$HSLB+$Private+$U_MKOPO;
$Total_Mkopo=$Total_faculty+$T_mkopo;
echo "<td>$T</td>
<td>$Private</td>
<td>$HSLB</td>
<td>$T_Mkopo</td>
</tr>";

$pg++;
}
echo "<tr>
<td colspan='4'>TOTAL</td><td>$Total</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td colspan='7'>TOTAL</td><td>$Total_Mkopo</td>";
echo"</tr>";

echo"</table>";




?>

</page>

