<?php
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');
require('ifms.php');
$ayear=$_POST['ayear'];
$faculty=$_POST['faculty'];
if($faculty=="all")
{
$db=mysqli_query("select * from faculty ORDER by FacultyName");
$dept=strtoupper('ALL DEPARTMENTS');
}else
{
$dp=mysqli_query("select * from faculty where FacultyID='$faculty'");
$d=mysqli_fetch_array($dp);
$dept=strtoupper($d['FacultyName']);
}
$pdf= new PDF_TOC(); 
$pdf->SetFont('Times','',20);
$pdf->AddPage();
$pdf->Cell(0,15,'MWALIMU NYERERE MEMORIAL ACADEMY',0,10,'C');
//$pdf->Cell(0,5,'MAKUMIRA UNIVERSITY COLLEGE',0,1,'C');
$pdf->Cell(0,29,''.$dept,0,1,'C');
$pdf->Image('logo.jpg',60,60,'C');
$pdf->Cell(0,180,'LIST OF ADMITTED STUDENTS  '.$ayear,0,1,'C');
$pdf->AddPage();
//Preface
//End of Preface
$pdf->startPageNums();
if($faculty=="all")
{
$faculty=mysqli_query("select * from faculty ORDER by FacultyName");
}else
{
$faculty=mysqli_query("select * from faculty  where FacultyID='$faculty' ORDER by FacultyName");
}
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
                if  (preg( "[A-Z]",$last)):
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
while($f=mysqli_fetch_array($faculty))
{
$registered=mysqli_query("select * from student,programme where programme.ProgrammeCode=student.ProgrammeofStudy  and programme.Faculty='$f[FacultyName]' and student.EntryYear='$ayear'")or die(mysqli_error());
$nms=mysqli_num_rows($registered);
if($nms>0)
{
$department=strtoupper($f['FacultyName']);	
$pdf->TOC_Entry($department, 0);
$query=mysqli_query("select * from programme where Faculty='$f[FacultyName]' ORDER by ProgrammeName");
while($r=mysqli_fetch_array($query))
{
$Ename=$r['Title']." ".$r['ProgrammeName'];
$darasa=mysqli_query("select * from student where ProgrammeofStudy='$r[ProgrammeCode]' and student.EntryYear='$ayear' and regno!='' ORDER by Name");
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
//$pdf->TOC_Entry($Ename, 2);
$k=1; 
while($c=mysqli_fetch_array($darasa))
{
#################TITLE CASE FUNCTION
if($c['Sex']=='M'){
    /** @var male $male */
    $male++;
}
else{
if($c['Sex']=='F'){
    /** @var female $female */
    $female++;
}
else
{
    /** @var unknown $unknown */
    $unknown++;
}
}
	        $rawname = $c['Name'];
		$expsurname = explode(",",$rawname);
		$surname = strtoupper($expsurname[0]);
		$othername = $expsurname[1];
		$expothername = explode(" ", $othername);
		$firstname = $expothername[1];
		$middlename = $expothername[2].' '.$expothername[3];



$sn=titleCase($surname);
$fn=titleCase($firstname);
$ln=titleCase($middlename);
######################END OF ALGORITHM




//$pdf->Line($x,$y,$x+$add,$y);//Horizontal TOP line
//$pdf->Line($x,$y,$x,$y+$add);//Vertical LEFT line
//$pdf->Line($x,$y+$add,$x+$add,$y+$add);//Horizontal BOTTOM line
//$pdf->Line($x+$add,$y,$x+$add,$y+$add);//Vertical RIGHT line
//$pdf->Text()
//$coname=$k.". ".$surname." ".$fn." ".$ln." ( RegNo"." ".$c['RegNo'].")";
$nm=$surname." ".$fn." ".$ln;
if($k < 10){
	$pdf->MultiCell(0,5,$k.".         ".$c['RegNo']."             ".$nm,1,'L');
	}
elseif($k < 100){
	$pdf->MultiCell(0,5,$k.".       ".$c['RegNo']."             ".$nm,1,'L');
	}
else{
	$pdf->MultiCell(0,5,$k.".     ".$c['RegNo']."             ".$nm,1,'L');
	}

//$pdf->MultiCell(0,28,$c['RegNo'],28,'L');
//$pdf->MultiCell(12,0,$nm,12,'L');
//$pdf->Cell(0,5,$coname,0,1,'L');
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
$pdf->SetFont('Times','',14);
//Summarization
$pdf->Cell(0,5,'SUMMARY',0,1,'L');
$pdf->Cell(0,5,'------------------------------------------------------------',0,1,'L');
$pdf->Cell(0,5,'Male = '.$male,0,1,'L');
$pdf->Cell(0,5,'Female = '.$female,0,1,'L');
if($unknown=='') 
{
$unknown=0;
}
$pdf->Cell(0,5,'Unknown = '.$unknown,0,1,'L');
$pdf->Output();

?>
