<?php
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');

$pdf= new PDF_TOC(); 
$pdf->SetFont('Times','',12);
$pdf->AddPage();
//$pdf->Cell(0,5,'DAR ES SALAAM INSTITUTE OF TECHNOLOGY',0,1,'C');
$pdf->Image('logo.jpg',10,0,'C');
//$pdf->Cell(0,175,'LIST OF ADMITTED STUDENTS 2009/2010',0,2,'C');
$pdf->AddPage();
//Preface
//End of Preface
$pdf->startPageNums();
$faculty=mysqli_query($zalongwa, "select * from faculty ORDER by FacultyName");
while($f=mysqli_fetch_array($faculty))
{
$registered=mysqli_query($zalongwa, "select * from student,programme where programme.ProgrammeCode=student.ProgrammeofStudy  and programme.Faculty='$f[FacultyName]'", $zalongwa)or die(mysqli_error());
$nms=mysqli_num_rows($registered);
if($nms>0)
{
$department=$f['FacultyName'];	
$pdf->TOC_Entry($department, 0);
$query=mysqli_query($zalongwa, "select * from programme where Faculty='$f[FacultyName]' ORDER by ProgrammeName");
while($r=mysqli_fetch_array($query))
{
$Ename=$r['Title']." ".$r['ProgrammeName'];
$darasa=mysqli_query($zalongwa, "select * from student where ProgrammeofStudy='$r[ProgrammeCode]' ORDER by Name");
$num=mysqli_num_rows($darasa);
if($num>0)
{
$pdf->head($Ename);
$pdf->TOC_Entry($Ename, 1);
//$pdf->TOC_Entry($Ename, 2);
$k=1;
while($c=mysqli_fetch_array($darasa))
{
$coname=$k.". ".addslashes($c['Name'])." ( RegNo"." ".$c['RegNo'].")";
$pdf->Cell(0,5,$coname,0,1,'L');
//$pdf->TOC_Entry($coname, 1);
$k++;
}
$pdf->AddPage();
}else
{
//Skip Courses with No Students
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
