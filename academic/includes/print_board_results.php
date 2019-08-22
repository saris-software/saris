<?php
$cw = 163;
$pdf->text($x + 1, $y + 15, $n);
$stname = explode(',', $name);
$pdf->text($x + 36, $y + 15, strtoupper(stripslashes($stname[0])) . ', ' . ucwords(strtolower(stripslashes($stname[1]))));
$pdf->text($x + 169, $y + 15, $RegNo);
$pdf->text($x + 241, $y + 15, $sex);

if ($fexm == '#') {
    //$pdf->text($x+$cw+97, $y+26, $fexm.' = Fail Exam');
    $fexm = '';
    $remark = '';
}
#check failed exam
if (($totalremarks > 0) && ($studentremarks <> '')) {
    $pdf->text($x + $cw + 97, $y + 15, $ovremark);
    $remark = '';
    $fexm = '';
    $fcwk = '';
    $fsup = '';
    $igrade = '';
    $egrade = '';
    $supp = '';
} else {
    //$ovremark='SUPP';
    $k = 0;
    if ($ovremark == 'SUPP:') {
        $pdf->text($x + $cw + 97, $y + 15, $ovremark);
        #print supplementaries
        $k = 25;
        #determine total number of columns
        $qsupp = "SELECT DISTINCT CourseCode, Status FROM courseprogramme WHERE  (ProgrammeID='$deg') 
							AND (YearofStudy='$yearofstudy') 
								AND (Semester = '$semval') ORDER BY CourseCode";
        $dbsupp = mysqli_query($zalongwa, $qsupp);
        while ($row_supp = mysqli_fetch_array($dbsupp)) {
            $course = $row_supp['CourseCode'];
            $coption = $row_supp['Status'];
            $grade = '';
            $supp = '';
            //$RegNo = $regno;
            #include grading scale
            include 'choose_studylevel.php';
            if (($supp == '!') && ($tmarks > 0)) {
                $pdf->text($x + $k + $cw + 99, $y + 15, ',' . $course);
                $k = $k + 35;
            }
            #empty option value
            $coption = '';
            $course = '';
        }
    } else {
        $pdf->text($x + $cw + 97, $y + 15, $ovremark);
    }
    if ($igrade <> 'I') {
    }
    if ($fsup == '!') {
        if ($totalinccount > 0) {
            $igrade = '';
            //$overallinccount = $overallinccount+1;
        }
        //$overallsuppcount = $overallsuppcount+1;
    } elseif (($igrade <> 'I') || ($fsup <> '!')) {
        //$overallpasscount= $overallpasscount+1;
    }

    if ($totalinccount > 0) {
        $igrade = '';

        //$overallinccount = $overallinccount+1;
    }
}
if ($checkbill <> 'on') {
    $pdf->text($x + 310, $y + 15, number_format($invoice, 2, '.', ','));
    $pdf->text($x + 379, $y + 15, number_format($paid, 2, '.', ','));
    $pdf->text($x + 460, $y + 15, number_format($due, 2, '.', ','));
}
$n++;
if ($sex == 'F') {
    $fcount = $fcount + 1;
} elseif ($sex == 'M') {
    $mcount = $mcount + 1;
} else {
    $fmcount = $fmcount + 1;
}
$x = $x;
$y = $y + 15;
$pdf->line($x, $y + 3, 570.28, $y + 3);       // top year summary line.
$pdf->line($x, $y - 15, $x, $y + 3);               // most left side margin.
$pdf->line($x + 35, $y - 15, $x + 35, $y + 3);               // most left side margin.
$pdf->line($x + 168, $y - 15, $x + 168, $y + 3);              // most left side margin.
$pdf->line($x + 236, $y - 15, $x + 236, $y + 3);              // most left side margin.
$pdf->line($x + 258, $y - 15, $x + 258, $y + 3);
if ($checkbill <> 'on') {
    $pdf->line($x + 306, $y - 15, $x + 306, $y + 3);
    $pdf->line($x + 374, $y - 15, $x + 374, $y + 3);
    $pdf->line($x + 458, $y - 15, $x + 458, $y + 3);             // most left side margin.
}
$pdf->line(570.28, $y - 15, 570.28, $y + 3);       // most right side margin.
?>