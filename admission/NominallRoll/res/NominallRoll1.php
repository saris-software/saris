<?php
mysql_connect('localhost','root','deo');
mysql_select_db('zalongwamuco');


$ayear=$_POST['ayear'];
$sponsors="HSLB";

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
VARIOUS UNDERGRADUATE DEGREE AND NON-DEGREE 
PROGRAMMES FOR THE <?php echo $ayear;?> ACADEMIC YEAR<br>
Compiled by-<br>
THE OFFICE OF THE DEPUTY VICE CHANCELOR FOR ACADEMIC,RESEARCH AND CONSULTANCY
DIRECTOR OF UNDERGRADUATE STUDIES MATRICULATION AND ADMISSIONS SECTION
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
//echo"<bookmark title='$d[DeptName]' level='1' ></bookmark>";
$programme=mysql_query("select * from programme where Faculty='$d[DeptName]'");
while($p=mysql_fetch_array($programme))
{
echo"<bookmark title='$p[ProgrammeName]' level='1' ></bookmark>";
echo"<br>";




$ent=mysql_query("select DISTINCT(EntryYear) from student where ProgrammeofStudy='$p[ProgrammeCode]'"); 
while($e=mysql_fetch_array($ent))
{	

$cohotyear=$e['EntryYear'];


$entry = intval(substr($cohotyear,0,4));
$current = intval(substr($ayear,0,4));
$yearofstudy=$current-$entry;


if($yearofstudy==0)
{
		$class="First Year";
		}elseif($yearofstudy==1){
		$class="Second Year";
		}elseif($yearofstudy==2){
		$class="Third Year";
		}elseif($yearofstudy==3){
		$class="Fourth Year";
		}elseif($yearofstudy==4){
		$class="Fifth Year";
		}elseif($yearofstudy==5){
		$class="Sixth Year";
		}elseif($yearofstudy==6){
		$class="Seventh Year";
		}else{
		$class="$yearofstudy";
}
if($entry&& $yearofstudy>0)
{
echo"<bookmark title='$class' level='2' ></bookmark>";
echo"<h5>$class:&nbsp;$p[Title]-$p[ProgrammeName]</h5>";

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
<?php
echo"<table cellspacing='1' cellpadding='1'><tr>";
echo"<th >REPORT SUMMARY.</th>
</tr></table>";
$M=0;
$F=0;
$U=0;
$Total=0;
$HSLB=0;
$Private=0;
$Total_Mkopo=0;
$U_MKOPO=0;
$T_mkopo=0;
$T_men=0;
$T_women=0;
if($faculty='all')
{
$ct="select * from faculty";
}else
{
$ct="select * from faculty where  FacultyID='$faculty'";
}
$query_last=mysql_query($ct);
echo"<table  cellspacing='0' cellpadding='0' width='1000' class='dtable'>";
echo"<tr class='dhead'>
<th>S/N</th>
<th>Faculty</th>
<th>Male</th>
<th>Female</th>
<th>Total</th>
<th>$sponsors Sponsorship</th>
<th>OTHER</th>
<th>Total</th>
</tr>";
$pg=1;
while($sm=mysql_fetch_array($query_last))
{
$cat=mysql_query("SELECT  * FROM programme WHERE Faculty='$sm[FacultyName]'");
$num=mysql_num_rows($cat);
//Count Genders
$male=mysql_query("SELECT count(Name)as male FROM student WHERE Faculty='$sm[FacultyName]' and Sex='M' and EntryYear='$ayear'");
$female=mysql_query("SELECT count(Name)as female  FROM student WHERE Faculty='$sm[FacultyName]' and Sex='F' and EntryYear='$ayear'");
$me=mysql_fetch_array($male);
$ke=mysql_fetch_array($female);
$men=$me['male'];
$women=$ke['female'];
$T=$men+$women;
///Mkopo
$hslb=mysql_query("SELECT count(Name)as hslb FROM student WHERE Faculty='$sm[FacultyName]'and Sponsor='$sponsors' and EntryYear='$ayear'");
$others=mysql_query("SELECT count(Name)as other  FROM student WHERE Faculty='$sm[FacultyName]' and (Sponsor !='$sponsors') and EntryYear='$ayear'");
$hs=mysql_fetch_array($hslb);
$other=mysql_fetch_array($others);
$HSLB=$hs['hslb'];
$OTHER=$other['other'];
$T_mkopo=$OTHER+$HSLB;
echo "<tr>
<td>$pg</td>
<td>$sm[FacultyName]</td>
<td>$men</td>
<td>$women</td>";
echo "<td>$T</td>
<td>$HSLB</td>
<td>$OTHER</td>
<td>$T_mkopo</td>
</tr>";
$T_men=$T_men+$men;
$T_women=$T_women+$women;
$T_hslb=$T_hslb+$HSLB;
$T_other=$T_other+$OTHER;
$pg++;
}
$Total_main=$T_men+$T_women;
$T_all=$T_hslb+$T_other;
echo "<tr>
<td colspan='2'>TOTAL</td><td>$T_men</td><td>$T_women</td>
<td>$Total_main</td>
<td>$T_hslb</td>
<td>$T_other</td>
<td>$T_all</td>
</tr>";
echo"</table>";
?>
</page>
