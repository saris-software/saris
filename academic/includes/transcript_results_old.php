<?php
#initialize x and y
$x = 50;
$y = $ytitle + 83;
#initialise total units and total points
$annualUnits = 0;
$annualPoints = 0;

$yval = $y + 33;
$y = $y + 33;

#set page body content fonts
$pdf->setFont('Arial', '', 9.3);

//query academeic year
$qayear = "SELECT DISTINCT AYear FROM examresult WHERE RegNo = '$regno' and checked=1 ORDER BY AYear ASC";
$dbayear = mysqli_query($zalongwa, $qayear);

#query project
/*
$qproject = "SELECT ayear, thesis FROM thesis WHERE RegNo = '$key'";
$dbproject = mysql_query($qproject);
$row_project = mysqli_fetch_assoc($dbproject);
$thesisresult = mysqli_num_rows($dbproject);
$thesis = $row_project['thesis'];
$thesisyear = $row_project['ayear'];
*/
#initialise ayear
$acyear = 0;

//query exam results sorted per years
while ($rowayear = mysqli_fetch_object($dbayear)) {
    $acyear = $acyear + 1;
    $currentyear = $rowayear->AYear;

    //query semester
    $qsemester = "SELECT DISTINCT Semester FROM examresult WHERE RegNo = '$regno' AND AYear = '$currentyear' ORDER BY Semester ASC";
    $dbsemester = mysqli_query($zalongwa, $qsemester);

    //query exam results sorted per semester
    while ($rowsemester = mysqli_fetch_object($dbsemester)) {
        $currentsemester = $rowsemester->Semester;

        # get all courses for this candidate
        $query_examresult = "SELECT DISTINCT course.CourseName, 
						  course.Units, 
						  course.StudyLevel, 
						  course.Department, 
						  examresult.CourseCode, 
						  examresult.Semester
						  
					  FROM 
							course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
					  WHERE (examresult.RegNo='$regno') AND 
							(examresult.AYear = '$currentyear') AND
							(examresult.Semester = '$currentsemester') AND  
							(examresult.Checked='1') 
				      ORDER BY examresult.AYear DESC, examresult.Semester ASC";

        $result = mysqli_query($zalongwa, $query_examresult);
        $query = @mysqli_query($zalongwa, $query_examresult);
        $dbcourseUnit = mysqli_query($zalongwa, $query_examresult);

        $totalunit = 0;
        $unittaken = 0;
        $sgp = 0;
        $totalsgp = 0;
        $gpa = 0;
        #check if u need to sart a new page
        $blank = $y - 12;
        $space = 820.89 - $blank;
        if ($space < 150) {
            #start new page
            $pdf->addPage();

            $x = 50;
            $yadd = 50;

            $y = 80;
            $pg = $pg + 1;
            $tpg = $pg;
            #insert transcript footer
            include 'transcriptfooter.php';
        }

        #line7
        $arr = array("NTA LEVEL 4", "NTA LEVEL 7", "NTA LEVEL 8", "NTA LEVEL 9");
        if (in_array($ntalevel, $arr, true)) {
            $semno = ' - ' . $currentsemester;
        } else {
            $semno = ' ';
        }

        #create table header
        if ($acyear == 1) {
            if ($award == 3) {
                $pdf->text($x, $y - $rh, 'EXAMINATIONS RESULTS: ');
            } else {
                if ($temp == 2) {
                    $pdf->text($x, $y - $rh, 'FIRST YEAR EXAMINATIONS RESULTS: ' . $rowayear->AYear . $semno);
                } else {
                    $pdf->text($x, $y - $rh, 'FIRST YEAR EXAMINATIONS RESULTS: ' . $rowayear->AYear . $semno);
                }
            }
        } elseif ($acyear == 2) {
            if ($temp == 2) {
                $pdf->text($x, $y - $rh, 'SECOND YEAR EXAMINATIONS RESULTS: ' . $rowayear->AYear . $semno);
            } else {
                $pdf->text($x, $y - $rh, 'SECOND YEAR EXAMINATIONS RESULTS: ' . $rowayear->AYear . $semno);
            }
        } elseif ($acyear == 3) {
            $pdf->text($x, $y - $rh, 'THIRD YEAR EXAMINATIONS RESULTS: ' . $rowayear->AYear . $semno);
        } elseif ($acyear == 4) {
            $pdf->text($x, $y - $rh, 'FOURTH YEAR EXAMINATIONS RESULTS: ' . $rowayear->AYear . $semno);
        } elseif ($acyear == 5) {
            $pdf->text($x, $y - $rh, 'FIFTH YEAR EXAMINATIONS RESULTS: ' . $rowayear->AYear . $semno);
        } elseif ($acyear == 6) {
            $pdf->text($x, $y - $rh, 'SIXTH YEAR EXAMINATIONS RESULTS: ' . $rowayear->AYear . $semno);
        } elseif ($acyear == 7) {
            $pdf->text($x, $y - $rh, 'SEVENTH YEAR EXAMINATIONS RESULTS: ' . $rowayear->AYear . $semno);
        }
        #check result tables to use
        if ($temp == 2) {
            #use muchs format
            include 'muchs_result_tables.php';
        } else {
            #use general format
            $pdf->text($x + 10, $y, 'Code');
            $pdf->text($x + 70, $y, 'Module Name');
            $pdf->text($x + 402, $y, 'Credits');
            $pdf->text($x + 436, $y, 'Grade');
            $pdf->text($x + 471, $y, 'Points');
            $pdf->text($x + 499, $y, 'GPA');

            #calculate results
            $i = 1;
            while ($row_course = mysqli_fetch_array($dbcourseUnit)) {
                $course = $row_course['CourseCode'];
                $unit = $row_course['Units'];
                $cname = $row_course['CourseName'];
                $coursefaculty = $row_course['Department'];
                $sn = $sn + 1;
                $remarks = 'remarks';
                $grade = '';
                /*
                #get specific ourse units
                $qcunits = "select Units from course where (course.Programme = '$degree') AND coursecode = '$course'";
                $dbcunits = mysql_query($qcunits);
                $count = mysqli_num_rows($dbcunits);
                if ($count > 0)
                {
                    $unit = $row_cunits['Units'];
                }
                */
                # grade marks
                $RegNo = $regno;
                include 'choose_studylevel.php';

                $coursecode = $course;

                #print results
                $pdf->text($x + 3, $y + $rh, substr($coursecode, 0, 10));
                $pdf->text($x + 55, $y + $rh, substr($cname, 0, 73));
                $pdf->text($x + 413, $y + $rh, $unit);
                $pdf->text($x + 445, $y + $rh, $grade);
                $pdf->text($x + 477, $y + $rh, $sgp);
                if ($grade == 'I') {
                    $gpacomp = 1;
                } elseif ($grade == 'F') {
                    $gpacomp = 1;
                }
                #check if the page is full
                $x = $x;
                #draw a line
                $pdf->line($x, $y - $rh + 2, 570.28, $y - $rh + 2);
                $pdf->line($x, $y - $rh + 2, $x, $y);
                $pdf->line(570.28, $y - $rh + 2, 570.28, $y);
                $pdf->line($x, $y - $rh + 2, $x, $y + $rh + 4);
                $pdf->line(570.28, $y - $rh + 2, 570.28, $y + $rh + 4);
                $pdf->line($x + 498, $y - $rh + 2, $x + 498, $y + $rh + 4);
                $pdf->line($x + 468, $y - $rh + 2, $x + 468, $y + $rh + 4);
                $pdf->line($x + 434, $y - $rh + 2, $x + 434, $y + $rh + 4);
                $pdf->line($x + 400, $y - $rh + 2, $x + 400, $y + $rh + 4);
                $pdf->line($x + 53, $y - $rh + 2, $x + 53, $y + $rh + 2);
                #get space for next year
                $y = $y + $rh;

                if ($y > 800) {
                    #put page header
                    //include('PDFTranscriptPageHeader.inc');
                    $pdf->addPage();

                    $x = 50;
                    $y = 100;
                    $pg = $pg + 1;
                    $tpg = $pg;
                    #insert transcript footer
                    include 'transcriptfooter.php';
                }
                #draw a line
                $pdf->line($x, $y + $rh + 2, 570.28, $y + $rh + 2);
                $pdf->line($x, $y - $rh + 2, $x, $y + $rh + 2);
                $pdf->line(570.28, $y - $rh + 2, 570.28, $y + $rh + 2);
                $pdf->line($x + 498, $y - $rh + 2, $x + 498, $y + $rh + 2);
                $pdf->line($x + 468, $y - $rh + 2, $x + 468, $y + $rh + 2);
                $pdf->line($x + 434, $y - $rh + 2, $x + 434, $y + $rh + 2);
                $pdf->line($x + 400, $y - $rh + 2, $x + 400, $y + $rh + 2);
                $pdf->line($x + 53, $y - $rh + 2, $x + 53, $y + $rh + 2);
            }//ends while loop
            #check degree
            //if(($degree==632)||($degree==633)||($degree==635)){
            if ($gpacomp <> 1) {
                $pdf->setFont('Arial', 'BI', 9.5);
                $pdf->text($x + 2, $y + $rh + 1, 'Sub-total');
                $pdf->text($x + 413, $y + $rh + 1, $unittaken);
                $pdf->text($x + 470, $y + $rh + 1, $totalsgp);
                #compute gpa
                $semgpa = @substr($totalsgp / $unittaken, 0, 3);
                if ($semgpa == 1) {
                    $semgpa = '1.0';
                } elseif ($semgpa == 2) {
                    $semgpa = '2.0';
                } elseif ($semgpa == 3) {
                    $semgpa = '3.0';
                } elseif ($semgpa == 4) {
                    $semgpa = '4.0';
                } elseif ($semgpa == 5) {
                    $semgpa = '5.0';
                }
                $pdf->text($x + 504, $y + $rh + 1, $semgpa);
                $pdf->setFont('Arial', '', 9.5);

                #get annual units and Points
                $annualUnits = $annualUnits + $unittaken;
                $annualPoints = $annualPoints + $totalsgp;
            }
        } //ends while rowsemester
        #check x,y values
        $y = $y + 3.5 * $rh;
        //$x=$y+22;
        if ($y == 800) {
            $pdf->addPage();

            #put page header
            $x = 50;
            $y = 80;
            $pg = $pg + 1;
            $tpg = $pg;
            #insert transcript content header
            include 'transcriptheader.php';
        }

    } //ends while rowayear

}
$avgGPA = @substr($annualPoints / $annualUnits, 0, 3);
if ($avgGPA == 1) {
    $avgGPA = '1.0';
} elseif ($avgGPA == 2) {
    $avgGPA = '2.0';
} elseif ($avgGPA == 3) {
    $avgGPA = '3.0';
} elseif ($avgGPA == 4) {
    $avgGPA = '4.0';
} elseif ($avgGPA == 5) {
    $avgGPA = '5.0';
}
?>
