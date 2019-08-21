<?php
#if exam type is Final Exam
$pdf->setFont('Arial', 'B', 9);
$pdf->line($x, $y, 570.28, $y);
$pdf->line($x, $y + 30, 570.28, $y + 30);
$pdf->line($x, $y, $x, $y + 30);
$pdf->text($x + 2, $y + 12, 'S/No');
$pdf->line($x + 30, $y, $x + 30, $y + 30);
$pdf->text($x + 35, $y + 12, 'Name');
$pdf->line($x + 186, $y, $x + 186, $y + 30);
$pdf->text($x + 188, $y + 12, 'Sex');
$pdf->line($x + 210, $y, $x + 210, $y + 30);
$pdf->text($x + 212, $y + 12, 'RegNo');
//$pdf->line($x+310, $y, $x+310, $y+30);	$pdf->text($x+312, $y+12, 'CA/40'); //$pdf->text($x+312, $y+24, 'X/40');
$pdf->line($x + 340, $y, $x + 340, $y + 30);
$pdf->text($x + 342, $y + 12, 'CA/40'); //$pdf->text($x+342, $y+24, 'X/100');
$pdf->line($x + 373, $y, $x + 373, $y + 30);
$pdf->text($x + 374, $y + 12, 'SE/60'); //$pdf->text($x+374, $y+24, 'X/60');
$pdf->line($x + 400, $y, $x + 400, $y + 30);
$pdf->text($x + 402, $y + 12, 'Total'); //$pdf->text($x+402, $y+24, 'X/100');
$pdf->line($x + 430, $y, $x + 430, $y + 30);
$pdf->text($x + 432, $y + 12, 'Grade');
$pdf->line($x + 463, $y, $x + 463, $y + 30);
$pdf->text($x + 465, $y + 12, 'Remark');
$pdf->line(570.28, $y, 570.28, $y + 30);
$pdf->setFont('Arial', '', 9);

#get coursename
$qcourse = "Select CourseName, Department, StudyLevel from course where CourseCode = '$coursecode'";
$dbcourse = mysqli_query($zalongwa, $qcourse);
$row_course = mysqli_fetch_array($dbcourse);
$coursename = $row_course['CourseName'];
$coursefaculty = $row_course['Department'];

#initiate grade counter
$countgradeA = 0;
$countgradeBplus = 0;
$countgradeB = 0;
$countgradeC = 0;
$countgradeD = 0;
$countgradeE = 0;
$countgradeF = 0;
$countgradeI = 0;

$countgradeAm = 0;
$countgradeBplusm = 0;
$countgradeBm = 0;
$countgradeCm = 0;
$countgradeDm = 0;
$countgradeEm = 0;
$countgradeFm = 0;
$countgradeIm = 0;

$countgradeAf = 0;
$countgradeBplusf = 0;
$countgradeBf = 0;
$countgradeCf = 0;
$countgradeDf = 0;
$countgradeEf = 0;
$countgradeFf = 0;
$countgradeIf = 0;
#print title
$sn = 0;
while ($row_regno = mysqli_fetch_array($dbregno)) {
    $key = $row_regno['RegNo'];
    $course = $coursecode;
    $ayear = $year;
    $units = $row_course['Units'];
    $sn = $sn + 1;
    $remarks = 'remarks';
    $grade = '';

    #get name and sex of the candidate
    $qstudent = "SELECT Name, Sex from student WHERE RegNo = '$key'";
    $dbstudent = mysqli_query($zalongwa,$qstudent);
    $row_result = mysqli_fetch_array($dbstudent);
    $name = $row_result['Name'];
    $sex = strtoupper($row_result['Sex']);

    # grade marks
    $RegNo = $key;
    include 'choose_studylevel.php';

    #update grade counter
    if ($grade == 'A') {
        $countgradeA = $countgradeA + 1;
        if ($sex == 'M') {
            $countgradeAm = $countgradeAm + 1;
        } else {
            $countgradeAf = $countgradeAf + 1;
        }
    } elseif ($grade == 'B+') {
        $countgradeBplus = $countgradeBplus + 1;
        if ($sex == 'M') {
            $countgradeBplusm = $countgradeBplusm + 1;
        } else {
            $countgradeBplusf = $countgradeBplusf + 1;
        }
    } elseif ($grade == 'B') {
        $countgradeB = $countgradeB + 1;
        if ($sex == 'M') {
            $countgradeBm = $countgradeBm + 1;
        } else {
            $countgradeBf = $countgradeBf + 1;
        }
    } elseif ($grade == 'C') {
        $countgradeC = $countgradeC + 1;
        if ($sex == 'M') {
            $countgradeCm = $countgradeCm + 1;
        } else {
            $countgradeCf = $countgradeCf + 1;
        }
    } elseif ($grade == 'D') {
        $countgradeD = $countgradeD + 1;
        if ($sex == 'M') {
            $countgradeDm = $countgradeDm + 1;
        } else {
            $countgradeDf = $countgradeDf + 1;
        }
    } elseif ($grade == 'E') {
        $countgradeE = $countgradeE + 1;
        if ($sex == 'M') {
            $countgradeEm = $countgradeEm + 1;
        } else {
            $countgradeEf = $countgradeEf + 1;
        }
    } elseif ($grade == 'F') {
        $countgradeF = $countgradeF + 1;
        if ($sex == 'M') {
            $countgradeFm = $countgradeFm + 1;
        } else {
            $countgradeFf = $countgradeFf + 1;
        }
    } else {
        $countgradeI = $countgradeI + 1;
        if ($sex == 'M') {
            $countgradeIm = $countgradeIm + 1;
        } else {
            $countgradeIf = $countgradeIf + 1;
        }
    }
    // }


    #display results

    #calculate summary areas
    $yind = $y + 15;
    $dataarea = 820.89 - $yind;
    if ($dataarea < 20) {
        $pdf->addPage();

        $x = 50;
        $y = 50;
        $pg = $pg + 1;
        $tpg = $pg;
        $pdf->setFont('Arial', 'I', 8);
        $pdf->text(530.28, 820.89, 'Page ' . $pg);
        $pdf->text(300, 820.89, $copycount);
        $pdf->text(50, 825.89, 'Printed On ' . $today = date("d-m-Y H:i:s"));
        $yind = $y;
        $pdf->setFont('Arial', '', 10);
        #reset the value of y
        #if exam type is Final Exam
        $pdf->setFont('Arial', 'B', 9);
        $pdf->line($x, $y, 570.28, $y);
        $pdf->line($x, $y + 30, 570.28, $y + 30);
        $pdf->line($x, $y, $x, $y + 30);
        $pdf->text($x + 2, $y + 12, 'S/No');
        $pdf->line($x + 30, $y, $x + 30, $y + 30);
        $pdf->text($x + 35, $y + 12, 'Name');
        $pdf->line($x + 186, $y, $x + 186, $y + 30);
        $pdf->text($x + 188, $y + 12, 'Sex');
        $pdf->line($x + 210, $y, $x + 210, $y + 30);
        $pdf->text($x + 212, $y + 12, 'RegNo');
        //$pdf->line($x+310, $y, $x+310, $y+30);	$pdf->text($x+312, $y+12, 'CA/40'); //$pdf->text($x+312, $y+24, 'X/40');
        $pdf->line($x + 340, $y, $x + 340, $y + 30);
        $pdf->text($x + 342, $y + 12, 'CA/40'); //$pdf->text($x+342, $y+24, 'X/100');
        $pdf->line($x + 373, $y, $x + 373, $y + 30);
        $pdf->text($x + 374, $y + 12, 'SE/60'); //$pdf->text($x+374, $y+24, 'X/60');
        $pdf->line($x + 400, $y, $x + 400, $y + 30);
        $pdf->text($x + 402, $y + 12, 'Total'); //$pdf->text($x+402, $y+24, 'X/100');
        $pdf->line($x + 430, $y, $x + 430, $y + 30);
        $pdf->text($x + 432, $y + 12, 'Grade');
        $pdf->line($x + 463, $y, $x + 463, $y + 30);
        $pdf->text($x + 465, $y + 12, 'Remark');
        $pdf->line(570.28, $y, 570.28, $y + 30);
        $pdf->setFont('Arial', '', 9);
    }
    if ($test2score == -1) {
        $test2score = 'PASS';
    }
    if ($aescore == -1) {
        $aescore = 'PASS';
    }
    if ($marks == -2) {
        $marks = 'PASS';
    }
    $y = $y + 15;
    $pdf->setFont('Arial', '', 8.7);
    $pdf->line($x, $y, 570.28, $y);
    $pdf->line($x, $y + 15, 570.28, $y + 15);
    $pdf->line($x, $y, $x, $y + 15);
    $pdf->text($x + 2, $y + 12, $sn);
    $pdf->line($x + 30, $y, $x + 30, $y + 15);
    if ($show == 'Y') {
        $stname = explode(',', $name);
        $pdf->text($x + 35, $y + 12, strtoupper($stname[0]) . ', ' . ucwords(strtolower($stname[1])));
    }

    $pdf->line($x + 186, $y, $x + 186, $y + 15);
    $pdf->text($x + 192, $y + 12, strtoupper($sex));
    $pdf->line($x + 210, $y, $x + 210, $y + 15);
    $pdf->text($x + 212, $y + 12, strtoupper($key));
    //$pdf->line($x+310, $y, $x+310, $y+15);	$pdf->text($x+315, $y+12, $test2score);
    $pdf->line($x + 340, $y, $x + 340, $y + 15);
    $pdf->text($x + 345, $y + 12, $test2score);//$aescore100);
    $pdf->line($x + 373, $y, $x + 373, $y + 15);
    $pdf->text($x + 377, $y + 12, $aescore);//$aescore);
    $pdf->line($x + 400, $y, $x + 400, $y + 15);
    $pdf->text($x + 405, $y + 12, $marks);
    $pdf->line($x + 430, $y, $x + 430, $y + 15);
    $pdf->text($x + 439, $y + 12, $grade);
    #check CA specific remarks
    if ($caremark == 1) {
        $remark = 'Failed CWK';
    }
    $pdf->line($x + 463, $y, $x + 463, $y + 15);
    $pdf->text($x + 465, $y + 12, $remark);
    $pdf->line(570.28, $y, 570.28, $y + 15);
    $pdf->setFont('Arial', '', 10);
    $remark = '';
}
#calculate summary areas
$yind = $y + 25;
$summaryarea = 820.89 - $yind;
if ($summaryarea < 90) {
    $pdf->addPage();

    $x = 50;
    $y = 50;
    $pg = $pg + 1;
    $tpg = $pg;
    $pdf->setFont('Arial', 'I', 8);
    $pdf->text(530.28, 820.89, 'Page ' . $pg);
    $pdf->text(300, 820.89, $copycount);
    $pdf->text(50, 825.89, 'Printed On ' . $today = date("d-m-Y H:i:s"));
    $yind = $y;
    $pdf->setFont('Arial', 'I', 10);
}
@$pdf->setFont('Arial', '', 10);
$b = $y + 25;
if ($b < 820.89) {
    include 'courseresultstats.php';
}
?>
