<?php
   require_once('../Connections/zalongwa.php');
include ('class.ezpdf.php');
$pdf = new Cezpdf();
$pdf->selectFont('../../php/extras/pdf-related/Helvetica.afm');
//Query Student Details
$student=mysql_query("SELECT * FROM student");
//Printing the Report barner
$pdf->ezText('DAR ES SALAAM INSTITUTE OF TECHNOLOGY',14);
$pdf->ezText('ADMITTED STUDENTS ACADEMIC YEAR 2009/2010',10);
$pdf->ezText('',12);
$s=mysql_fetch_array($student);
//Formatting Student Details
$jina=$s['FirstName']."  ".$s['LastName']."  ".$s['MiddleName'];
$record[$p]=array(
'Name'=>$jina,
'Address'=>'P.O.BOX '.$s['pobox'],
'Email'=>$s['email'],
'Mobile'=>$s['mobile']);
//Printing Student Details	
$pdf->ezTable($record,"","",array('width'=>500));	
//Fetching Course Details & Results
$result=mysql_query("SELECT * FROM course,selectedcourse where
course.CourseID=selectedCourse.CourseID and selectedCourse.regno='$regno';");

if(mysql_num_rows($result)==0)
{
//echo "Click&nbsp;<a href='./studentList.php'>here</a>to back";
}
else
{
$i=0;
while( $row=mysql_fetch_array($result) )
{
include './exam_regulation.php';
//Hapa pakuchunga sana
$k=$i+1;
$data[$i]=array(
'S/N'=>$k,
'RegNo'=>$row['regno'],
'Name'=>$row['Name'],
'Programme'=>$row['ProgrammeofStudy'],
'Level'=>$row['studylevel'],
'SN#'=>$row['Id']);
$i++;
}
$pdf->ezStream();
//GPA calculation
/*
$gpa=($sum/$tu);
$pdf->ezTable($data,"","",array('width'=>500));
$pdf->ezTable($data,"","",array('width'=>500));
$pdf->ezText('GPA:'.$gpa,14);
$pdf->ezStream();
*/
}
?>
</body>
</html>
