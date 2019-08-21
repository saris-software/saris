<?php
#if exam type is Final Exam
$pdf->setFont('Arial', 'B', 7);
$x = $x - 20;
$pdf->line($x, $y, $xpoint, $y);
$pdf->line($x, $y + 15, $xpoint, $y + 15);
$pdf->line($x, $y, $x, $y + 15);
$pdf->text($x + 2, $y + 12, 'S/No');
$pdf->line($x + 30, $y, $x + 30, $y + 15);
$pdf->text($x + 35, $y + 12, 'Name');
$pdf->line($x + 206, $y, $x + 206, $y + 15);
$pdf->text($x + 211, $y + 12, 'RegNo');

$pdf->line($x + 342, $y, $x + 342, $y + 15);
$pdf->text($x + 347, $y + 13, 'X/5');
$pdf->text($x + 347, $y + 6, 'HW1');
$pdf->line($x + 366, $y, $x + 366, $y + 15);
$pdf->text($x + 371, $y + 13, 'X/5');
$pdf->text($x + 371, $y + 6, 'HW2');
$pdf->line($x + 390, $y, $x + 390, $y + 15);
$pdf->text($x + 395, $y + 13, 'X/5');
$pdf->text($x + 395, $y + 6, 'QZ1');
$pdf->line($x + 414, $y, $x + 414, $y + 15);
$pdf->text($x + 419, $y + 13, 'X/5');
$pdf->text($x + 419, $y + 6, 'QZ2');
$pdf->line($x + 438, $y, $x + 438, $y + 15);
$pdf->text($x + 443, $y + 13, 'X/5');
$pdf->text($x + 443, $y + 6, 'GAS');
$pdf->line($x + 462, $y, $x + 462, $y + 15);
$pdf->text($x + 467, $y + 13, 'X/10');
$pdf->text($x + 467, $y + 6, 'PRO');
$pdf->line($x + 486, $y, $x + 486, $y + 15);
$pdf->text($x + 491, $y + 13, 'X/10');
$pdf->text($x + 491, $y + 6, 'CT1');
$pdf->line($x + 510, $y, $x + 510, $y + 15);
$pdf->text($x + 515, $y + 13, 'X/10');
$pdf->text($x + 515, $y + 6, 'CT2');
$pdf->line($x + 534, $y, $x + 534, $y + 15);
$pdf->text($x + 536, $y + 12, 'CA/40');

$pdf->setFont('Arial', 'B', 10);
$pdf->line($x + 558, $y, $x + 558, $y + 15);
$pdf->text($x + 563, $y + 12, 'Comments');
$pdf->line($x + 620, $y, $x + 620, $y + 15);
$pdf->text($x + 623, $y + 12, 'Signature');
$pdf->setFont('Arial', 'B', 7);
/*
				$pdf->line($x+422, $y, $x+422, $y+15);	$pdf->text($x+423, $y+12, 'SE/60'); 
				$pdf->line($x+446, $y, $x+446, $y+15);	$pdf->text($x+448, $y+12, 'Total'); 
				$pdf->line($x+470, $y, $x+470, $y+15);	$pdf->text($x+472, $y+12, 'Grade'); 
				$pdf->line($x+494, $y, $x+494, $y+15);	$pdf->text($x+496, $y+12, 'Remark');
*/
$pdf->line($xpoint, $y, $xpoint, $y + 15);

$pdf->setFont('Arial', '', 8);

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
$countgradeI = 0;

$countgradeAm = 0;
$countgradeBplusm = 0;
$countgradeBm = 0;
$countgradeCm = 0;
$countgradeDm = 0;
$countgradeEm = 0;
$countgradeIm = 0;

$countgradeAf = 0;
$countgradeBplusf = 0;
$countgradeBf = 0;
$countgradeCf = 0;
$countgradeDf = 0;
$countgradeEf = 0;
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
    include 'includes/choose_studylevel.php';

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
    } elseif ($grade == 'F') {
        $countgradeE = $countgradeE + 1;
        if ($sex == 'M') {
            $countgradeEm = $countgradeEm + 1;
        } else {
            $countgradeEf = $countgradeEf + 1;
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
    $dataarea = $ypoint - $yind;
    if ($dataarea < 20) {
        $pdf->addPage();

        $x = 50;
        $y = 50;
        $pg = $pg + 1;
        $tpg = $pg;
        $pdf->setFont('Arial', 'I', 8);
        $pdf->text($xpoint - 100, $ypoint, 'Page ' . $pg);
        $pdf->text(300, 820.89, $copycount);
        $pdf->text(50, $ypoint, 'Printed On ' . $today = date("d-m-Y H:i:s"));
        $yind = $y;
        $pdf->setFont('Arial', '', 10);
        #reset the value of y
        #if exam type is Final Exam
        $pdf->setFont('Arial', 'B', 7);
        $x = $x - 20;
        $pdf->line($x, $y, $xpoint, $y);
        $pdf->line($x, $y + 15, $xpoint, $y + 15);
        $pdf->line($x, $y, $x, $y + 15);
        $pdf->text($x + 2, $y + 12, 'S/No');
        $pdf->line($x + 30, $y, $x + 30, $y + 15);
        $pdf->text($x + 35, $y + 12, 'Name');
        $pdf->line($x + 206, $y, $x + 206, $y + 15);
        $pdf->text($x + 211, $y + 12, 'RegNo');

        $pdf->line($x + 342, $y, $x + 342, $y + 15);
        $pdf->text($x + 347, $y + 13, 'X/5');
        $pdf->text($x + 347, $y + 6, 'HW1');
        $pdf->line($x + 366, $y, $x + 366, $y + 15);
        $pdf->text($x + 371, $y + 13, 'X/5');
        $pdf->text($x + 371, $y + 6, 'HW2');
        $pdf->line($x + 390, $y, $x + 390, $y + 15);
        $pdf->text($x + 395, $y + 13, 'X/5');
        $pdf->text($x + 395, $y + 6, 'QZ1');
        $pdf->line($x + 414, $y, $x + 414, $y + 15);
        $pdf->text($x + 419, $y + 13, 'X/5');
        $pdf->text($x + 419, $y + 6, 'QZ2');
        $pdf->line($x + 438, $y, $x + 438, $y + 15);
        $pdf->text($x + 443, $y + 13, 'X/5');
        $pdf->text($x + 443, $y + 6, 'GAS');
        $pdf->line($x + 462, $y, $x + 462, $y + 15);
        $pdf->text($x + 467, $y + 13, 'X/10');
        $pdf->text($x + 467, $y + 6, 'PRO');
        $pdf->line($x + 486, $y, $x + 486, $y + 15);
        $pdf->text($x + 491, $y + 13, 'X/10');
        $pdf->text($x + 491, $y + 6, 'CT1');
        $pdf->line($x + 510, $y, $x + 510, $y + 15);
        $pdf->text($x + 515, $y + 13, 'X/10');
        $pdf->text($x + 515, $y + 6, 'CT2');
        $pdf->line($x + 534, $y, $x + 534, $y + 15);
        $pdf->text($x + 536, $y + 12, 'CA/40');

        $pdf->setFont('Arial', 'B', 10);
        $pdf->line($x + 558, $y, $x + 558, $y + 15);
        $pdf->text($x + 563, $y + 12, 'Comments');
        $pdf->line($x + 620, $y, $x + 620, $y + 15);
        $pdf->text($x + 623, $y + 12, 'Signature');
        $pdf->setFont('Arial', 'B', 7);
        /*
                        $pdf->line($x+422, $y, $x+422, $y+15);	$pdf->text($x+423, $y+12, 'SE/60');
                        $pdf->line($x+446, $y, $x+446, $y+15);	$pdf->text($x+448, $y+12, 'Total');
                        $pdf->line($x+470, $y, $x+470, $y+15);	$pdf->text($x+472, $y+12, 'Grade');
                        $pdf->line($x+494, $y, $x+494, $y+15);	$pdf->text($x+496, $y+12, 'Remark');
        */
        $pdf->line($xpoint, $y, $xpoint, $y + 15);

        $pdf->setFont('Arial', '', 8);
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
    $pdf->line($x, $y, $xpoint, $y);
    $pdf->line($x, $y + 15, $xpoint, $y + 15);
    $pdf->line($x, $y, $x, $y + 15);
    $pdf->text($x + 2, $y + 12, $sn);
    $pdf->line($x + 30, $y, $x + 30, $y + 15);
    $pdf->text($x + 35, $y + 12, $name);
    $pdf->line($x + 206, $y, $x + 206, $y + 15);
    $pdf->text($x + 211, $y + 12, $key);

    $pdf->line($x + 342, $y, $x + 342, $y + 15);
    $pdf->text($x + 345, $y + 12, $hw1score);
    $pdf->line($x + 366, $y, $x + 366, $y + 15);
    $pdf->text($x + 369, $y + 12, $hw2score);
    $pdf->line($x + 390, $y, $x + 390, $y + 15);
    $pdf->text($x + 393, $y + 12, $qz1score);
    $pdf->line($x + 414, $y, $x + 414, $y + 15);
    $pdf->text($x + 417, $y + 12, $qz2score);
    $pdf->line($x + 438, $y, $x + 438, $y + 15);
    $pdf->text($x + 441, $y + 12, $gascore);
    $pdf->line($x + 462, $y, $x + 462, $y + 15);
    $pdf->text($x + 465, $y + 12, $proscore);
    $pdf->line($x + 486, $y, $x + 486, $y + 15);
    $pdf->text($x + 489, $y + 12, $ct1score);
    $pdf->line($x + 510, $y, $x + 510, $y + 15);
    $pdf->text($x + 513, $y + 12, $ct2score);
    $pdf->line($x + 534, $y, $x + 534, $y + 15);
    $pdf->text($x + 537, $y + 12, $test2score);
    $pdf->line($x + 558, $y, $x + 558, $y + 15);
    if ($test2score >= 16) {
        $comments = 'PASS';
    } else {
        $comments = 'FAIL';
    }

    $pdf->text($x + 563, $y + 12, $comments);
    $pdf->line($x + 620, $y, $x + 620, $y + 15);
    /*
            $pdf->line($x+422, $y, $x+422, $y+15);	$pdf->text($x+424, $y+12, $aescore);
            $pdf->line($x+446, $y, $x+446, $y+15);	$pdf->text($x+448, $y+12, $marks);
            $pdf->line($x+470, $y, $x+470, $y+15);	$pdf->text($x+472, $y+12, $grade);
            $pdf->line($x+494, $y, $x+494, $y+15);	$pdf->text($x+496, $y+12, $remark);
    */
    $pdf->line($xpoint, $y, $xpoint, $y + 15);

    $pdf->setFont('Arial', '', 10);
}
?>
