<?php
require('ifms.php');
 require_once('../Connections/zalongwa.php');
$pdf= new PDF_TOC(); 
$pdf->SetFont('Times','',12);
$pdf->AddPage();
//$pdf->Cell(0,5,'DAR ES SALAAM INSTITUTE OF TECHNOLOGY',0,1,'C');
$pdf->Image('logo1.jpg',10,0,'C');
//$pdf->Cell(0,175,'LIST OF ADMITTED STUDENTS 2009/2010',0,2,'C');
$pdf->AddPage();
//Preface
//End of Preface

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
##################################################################

$pdf->startPageNums();
$faculty=mysqli_query("select * from faculty ORDER by FacultyName", $zalongwa);
while($f=mysqli_fetch_array($faculty))
{
$registered=mysqli_query("select * from course,programme where programme.ProgrammeCode=course.Programme and programme.Faculty='$f[FacultyName]'", $zalongwa)or die(mysqli_error($zalongwa));
$nms=mysqli_num_rows($registered);
if($nms>0)
{
$department=$f['FacultyName'];	
$pdf->TOC_Entry($department, 0);
$query=mysqli_query("select * from programme where Faculty='$f[FacultyName]' ORDER by ProgrammeName", $zalongwa);
while($r=mysqli_fetch_array($query))
{
$Ename=$r['Title']." ".$r['ProgrammeName'];
$darasa=mysqli_query("select * from course where Programme='$r[ProgrammeCode]' ORDER by CourseName", $zalongwa);
$num=mysqli_num_rows($darasa);
if($num>0)
{
$Ename=strtoupper($Ename);
//$labelSize=12;
//$entrySize=9;
//$tocfont='Times';
//$pdf->SetFont($tocfont,'B',$labelSize);
$pdf->head($Ename);
$lines="                                      ";
$pdf->head($lines);
$Ename=titleCase($Ename);
$pdf->SetFont('Times','',10);
$pdf->TOC_Entry($Ename, 1);
$k=1;
while($c=mysqli_fetch_array($darasa))
{
$coname=$k.". ".$c['CourseName']." (".$c['CourseCode'].")";
$pdf->Cell(0,5,$coname,0,1,'L');
//$pdf->TOC_Entry($coname, 1);
$k++;
}
$pdf->AddPage();
}else
{
//Skip Courses with No Courses
}
}
}else
{
//Skip Null Department
}
}
//Generate and insert TOC at page 2
$pdf->insertTOC(2);
//Summarization
$pdf->Output();
?>
