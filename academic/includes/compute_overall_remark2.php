<?php
#get Total Credit Count
$reason = '';
$coursecount = 0;
$qcoursecount = "SELECT CourseCount FROM coursecountprogramme WHERE (ProgrammeID='$deg') AND (YearofStudy ='$yearofstudy') AND (Semester ='$curr_semester')";
$dbcoursecount = mysqli_query($zalongwa,$qcoursecount) or die (mysqli_error($zalongwa) . 'mimi na wewe');
$row_coursecount = mysqli_fetch_array($dbcoursecount);
$coursecount = $row_coursecount ['CourseCount'];

#get total credit of the programme
$halfsubjects = number_format($subjecttaken / 2, 1);
if ($semval == 1) {
    $sem1totalcredits = $coursecount;
    $ptc = $sem1unittaken / $sem1totalcredits * 100;
    $avg = number_format($gmarks / $subjecttaken, 0);
    $gpa = @number_format($sem1totalsgp / $sem1unittaken, 4);
} elseif ($semval == 2) {
    $sem2totalcredits = $coursecount;
    $ptc = $sem2unittaken / $sem2totalcredits * 100;
    $avg = number_format($gmarks / $subjecttaken, 0);
    $gpa = @number_format($sem2totalsgp / $sem2unittaken, 4);
}

if (($unittaken > 0) && ($totalinccount == 0)) {
    //	$avg = number_format($gmarks/$subjecttaken,0);
    $gpa = @number_format($totalsgp / $unittaken, 4);
    #calculate courses column width
    $cw = $cwf * $totalcolms;
    $x = $x + 235;
    if ($reportgroup == 'sheet') {
        $pdf->line($x + $cw, $y, $x + $cw, $y + 15);
        $pdf->text($x + $cw + 4, $y + 12, $unittaken);  #print total subject candidate taken
        $pdf->line($x + $cw + 30, $y, $x + $cw + 30, $y + 15);
        $pdf->text($x + $cw + 32, $y + 12, $totalsgp);
        $pdf->line($x + $cw + 60, $y, $x + $cw + 60, $y + 15);
        $pdf->text($x + $cw + 63, $y + 12, $gpa);
    }

    if ($reportgroup == 'annualsheet') {
        if ($semval == 2) {
            $pdf->line($x + $cw, $y, $x + $cw, $y + 15);
            $pdf->text($x + $cw + 4, $y + 12, $gpa);
            $sem2avg = $avg;
            $sem2gpa = $gpa;
            $pdf->line($x + $cw + 30, $y, $x + $cw + 30, $y + 15);
            $pdf->line($xpoint + 25, $y, $xpoint + 25, $y + 15);
            $pdf->line($x + $cw + 170, $y, $x + $cw + 170, $y + 15);
            $ovavg = ($sem1avg + $sem2avg) / 2;
            $ovgpa = ($sem1gpa + $sem2gpa) / 2;
            if ($ovavg > 0) {
                $pdf->text($x + $cw + 335 - $ovrw, $y + 12, number_format($ovgpa, 4, '.', ''));
            }
        } elseif ($semval == 1) {
            $pdf->text($x + $cw + 173, $y + 12, $gpa);
            $sem1avg = $avg;
            $sem1gpa = $gpa;
            $pdf->line($x + $cw + 355 - $ovrw, $y, $x + $cw + 355 - $ovrw, $y + 15); #prints second line from right
            $pdf->line($x + $cw + 200, $y, $x + $cw + 200, $y + 15);
            $pdf->line($x + $cw + 330 - $ovrw, $y, $x + $cw + 330 - $ovrw, $y + 15); #prints third line from right
        }
    }
    #get student remarks
    $qremarks = "SELECT Remark FROM studentremark WHERE RegNo='$RegNo'";
    $dbremarks = mysqli_query($zalongwa,$qremarks);
    $row_remarks = mysqli_fetch_assoc($dbremarks);
    $totalremarks = mysqli_num_rows($dbremarks);
    $studentremarks = $row_remarks['Remark'];

    if (($totalremarks > 0) && ($studentremarks <> '')) {
        $ovremark = $studentremarks;
    } else {
        include 'overall_remarks.php';
    }
    if ($reportgroup == 'sheet') {
        $pdf->line($x + $cw + 60, $y, $x + $cw + 60, $y + 15);
        $pdf->line($xpoint + 25, $y, $xpoint + 25, $y + 15);
        $pdf->line($x + $cw + 60, $y + 15, $x + $cw + 95, $y + 15);
        $pdf->line($x + $cw + 95, $y, $x + $cw + 95, $y + 15);
    }

    if ($reportgroup == 'annualsheet') {
        $pdf->line($xpoint + 25, $y, $xpoint + 25, $y + 15);
    }
} else {

    $avg = '';
    $gpa = '';
    $subjecttaken = '';
    $unittaken = '';
    $gmarks = '';
    $ovremark = 'ABSC';

    #calculate courses column width
    $cw = $cwf * $totalcolms;
    $x = $x + 235;
    if ($reportgroup == 'sheet') {
        $pdf->line($x + $cw, $y, $x + $cw, $y + 15);
        $pdf->text($x + $cw + 4, $y + 12, $unittaken);
        $pdf->line($x + $cw + 30, $y, $x + $cw + 30, $y + 15);
        $pdf->text($x + $cw + 32, $y + 12, $totalsgp);
        $pdf->line($x + $cw + 60, $y, $x + $cw + 60, $y + 15);
        $pdf->text($x + $cw + 63, $y + 12, $gpa);

        $pdf->line($x + $cw + 60, $y, $x + $cw + 60, $y + 15);
        $pdf->line($xpoint + 25, $y, $xpoint + 25, $y + 15);

        $pdf->line($x + $cw + 60, $y + 15, $x + $cw + 95, $y + 15);
        $pdf->line($x + $cw + 95, $y, $x + $cw + 95, $y + 15);
    }
    if ($reportgroup == 'annualsheet') {
        if ($semval == 2) {
            $pdf->line($x + $cw, $y, $x + $cw, $y + 15);
            $pdf->text($x + $cw + 4, $y + 12, $gpa);
            $sem2avg = $avg;
            $sem2gpa = $gpa;
            $pdf->line($x + $cw + 30, $y, $x + $cw + 30, $y + 15);
            $pdf->line($xpoint + 25, $y, $xpoint + 25, $y + 15);
            $pdf->line($x + $cw + 170, $y, $x + $cw + 170, $y + 15);
            $ovavg = ($sem1avg . $sem2avg) / 2;
            $ovgpa = ($sem1gpa . $sem2gpa) / 2;
            if ($ovavg > 0) {
                $pdf->text($x + $cw + 336 - $ovrw, $y + 12, number_format($ovgpa, 4, '.', ''));
            }
        } elseif ($semval == 1) {
            $pdf->text($x + $cw + 38, $y + 12, $gpa);
            $sem1avg = $avg;
            $sem1gpa = $gpa;
            $pdf->line($x + $cw + 355 - $ovrw, $y, $x + $cw + 355 - $ovrw, $y + 15); #prints second line from right
            $pdf->line($x + $cw + 200, $y, $x + $cw + 200, $y + 15);
            $pdf->line($x + $cw + 330 - $ovrw, $y, $x + $cw + 330 - $ovrw, $y + 15);    #prints third line from right
        }
    }
}
