<?php
#reset gpa calculation values
$point = '';
$grade = '';
$remark = '';

#query Homework One
$qhw1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=1";
$dbhw1 = mysqli_query($zalongwa, $qhw1);
$total_hw1 = mysqli_num_rows($dbhw1);
$row_hw1 = mysqli_fetch_array($dbhw1);
$value_hw1score = $row_hw1['ExamScore'];
if (($total_hw1 > 0) && ($value_hw1score <> '')) {
    $hw1date = $row_hw1['ExamDate'];
    $hw1score = number_format($value_hw1score, 1);
} else {
    $hw1score = '';
}

#query Homework Two
$qhw2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=2";
$dbhw2 = mysqli_query($zalongwa, $qhw2);
$total_hw2 = mysqli_num_rows($dbhw2);
$row_hw2 = mysqli_fetch_array($dbhw2);
$value_hw2score = $row_hw2['ExamScore'];
if (($total_hw2 > 0) && ($value_hw2score <> '')) {
    $hw2date = $row_hw2['ExamDate'];
    $hw2score = number_format($value_hw2score, 1);
} else {
    $hw2score = '';
}

#query Quiz One
$qqz1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=3";
$dbqz1 = mysqli_query($zalongwa, $qqz1);
$total_qz1 = mysqli_num_rows($dbqz1);
$row_qz1 = mysqli_fetch_array($dbqz1);
$value_qz1score = $row_qz1['ExamScore'];
if (($total_qz1 > 0) && ($value_qz1score <> '')) {
    $qz1date = $row_qz1['ExamDate'];
    $qz1score = number_format($value_qz1score, 1);
} else {
    $qz1score = '';
}

#query Quiz Two
$qqz2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=4";
$dbqz2 = mysqli_query($zalongwa, $qqz2);
$total_qz2 = mysqli_num_rows($dbqz2);
$row_qz2 = mysqli_fetch_array($dbqz2);
$value_qz2score = $row_qz2['ExamScore'];
if (($total_qz2 > 0) && ($value_qz2score <> '')) {
    $qz2date = $row_qz2['ExamDate'];
    $qz2score = number_format($value_qz2score, 1);
} else {
    $qz2score = '';
}

#query Semester Examination
$qae = "SELECT ExamCategory, Examdate, ExamScore, AYear FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=5";
$dbae = mysqli_query($zalongwa, $qae);
$total_ae = mysqli_num_rows($dbae);
$row_ae = mysqli_fetch_array($dbae);
$value_aescore = $row_ae['ExamScore'];
if (($total_ae > 0) && ($value_aescore <> '')) {
    $aedate = $row_ae['ExamDate'];
    $aescore = number_format($value_aescore, 1);
} else {
    $remarks = "Inc";
    $aescore = '';
}

#query Group Assignment
$qga = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=6";
$dbga = mysqli_query($zalongwa, $qga);
$total_ga = mysqli_num_rows($dbga);
$row_ga = mysqli_fetch_array($dbga);
$value_gascore = $row_ga['ExamScore'];
if (($total_ga > 0) && ($value_gascore <> '')) {
    $gadate = $row_ga['ExamDate'];
    $gascore = number_format($value_gascore, 1);
}

#query Supplimentatary Exam
$qsup = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=7";
$dbsup = mysqli_query($zalongwa, $qsup);
$row_sup = mysqli_fetch_array($dbsup);
$row_sup_total = mysqli_num_rows($dbsup);
$supdate = $row_sup['ExamDate'];
$supscore = $row_sup['ExamScore'];
if (($row_sup_total > 0) && ($supscore <> '')) {
    $remarks = '';
    $aescore = number_format($supscore, 1);
    #empty coursework
    $test2score = 'n/a';
}


#query Project Exam
$qpro = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=8";
$dbpro = mysqli_query($zalongwa, $qpro);
$row_pro = mysqli_fetch_array($dbpro);
$row_pro_total = mysqli_num_rows($dbpro);
$prodate = $row_pro['ExamDate'];
$proscore = $row_pro['ExamScore'];
if (($row_pro_total > 0) && ($proscore <> '')) {
    $remarks = '';
    $proscore = number_format($proscore, 1);
}

#query Classroom Test One (1)
$qct1 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=9";
$dbct1 = mysqli_query($zalongwa, $qct1);
$row_ct1 = mysqli_fetch_array($dbct1);
$row_ct1_total = mysqli_num_rows($dbct1);
$ct1date = $row_ct1['ExamDate'];
$ct1score = $row_ct1['ExamScore'];
if (($row_ct1_total > 0) && ($ct1score <> '')) {
    $remarks = '';
    $ct1score = number_format($ct1score, 1);
}

#query Classroom Test Two (2)
$qct2 = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=10";
$dbct2 = mysqli_query($zalongwa, $qct2);
$row_ct2 = mysqli_fetch_array($dbct2);
$row_ct2_total = mysqli_num_rows($dbct2);
$ct2date = $row_ct2['ExamDate'];
$ct2score = $row_ct2['ExamScore'];
if (($row_ct2_total > 0) && ($ct2score <> '')) {
    $remarks = '';
    $ct2score = number_format($ct2score, 1);
}

#query Special Exam
$qsp = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=11";
$dbsp = mysqli_query($zalongwa, $qsp);
$total_sp = mysqli_num_rows($dbsp);
$row_sp = mysqli_fetch_array($dbsp);
$value_spscore = $row_sp['ExamScore'];
if (($total_sp > 0) && ($value_spscore <> '')) {
    $spdate = $row_sp['ExamDate'];
    $spscore = number_format($value_spscore, 1);
    $remarks = "sp";
    $aescore = $spscore;
} else {
    $spscore = '';
}

#get Continuous Assessment (C.A)
$test2score = $hw1score . $hw2score . $qz1score . $qz2score . $gascore . $prscore . $ct1score . $ct2score;
$test2score = number_format($test2score, 1);

#get total marks
if (($row_sup_total > 0) && ($supscore <> '')) {
    $tmarks = $supscore;
    if ($tmarks >= 40) {
        $gradesupp = 'C';
        $remark = 'PASS';
    }
} elseif (($row_pro_total > 0) && ($proscore <> '')) {
    $tmarks = $proscore;
} elseif (($row_tp_total > 0) && ($tpscore <> '')) {
    $tmarks = $tpscore;
} elseif (($row_pt_total > 0) && ($ptscore <> '')) {
    $tmarks = $ptscore;
} elseif (($total_sp > 0) && ($spscore <> '')) {
    $tmarks = $test2score . $spscore;
} else {
    $tmarks = $test2score . $aescore;
}

#round marks
//$marks = round($tmarks);
$marks = number_format($tmarks, 1);


#grade marks
if ($remarks == 'Inc') {
    $grade = 'I';
    $remark = 'Inc.';
    $point = 0;
    $sgp = $point * $unit;
} else {
    if ($marks >= 79.5) {
        $grade = 'A';
        $remark = 'PASS';
        $margin = 80 - $marks;
        $point = 5;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
        if (($margin <= 0.5) && ($margin > 0)) {
            $marks = 80;
        }
    } elseif ($marks >= 64.5) {
        $grade = 'B';
        $remark = 'PASS';
        $margin = 65 - $marks;
        $point = 4;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
        if (($margin <= 0.5) && ($margin > 0)) {
            $marks = 65;
        }
    } elseif ($marks >= 49.5) {
        $grade = 'C';
        $remark = 'PASS';
        $margin = 50 - $marks;
        $point = 3;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
        if (($margin <= 0.5) && ($margin > 0)) {
            $marks = 50;
        }
    } elseif ($marks >= 39.5) {
        $grade = 'D';
        $remark = 'PASS';
        $margin = 40 - $marks;
        $point = 2;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
        if (($margin <= 0.5) && ($margin > 0)) {
            $marks = 40;
        }
    } else {
        $grade = 'F';
        $remark = 'SUPP';
        $point = 0;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
    }
}

#check if ommited
$qcount = "SELECT DISTINCT Count FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo'";
$dbcount = mysqli_query($zalongwa, $qcount);
$row_count = mysqli_fetch_array($dbcount);
$count = $row_count['Count'];
if ($count == 1) {
    $sgp = 0;
    $unit = 0;
    $coursename = '*' . $coursename;
}

#compute gpa values
//$sgp=$point*$unit;
//$totalsgp=$totalsgp+$sgp;
//$unittaken=$unittaken+$unit;


if (($test2score < 16) && ($test2score <> 'n/a')) {
    //$grade='E*';
    //$remark = 'C/Repeat';
    //$egrade='*';
} elseif ($remarks == 'Inc') {
    $grade = 'I';
    $remark = 'Inc.';
    $igrade = 'I';
} elseif ($marks == -2) {
    $grade = 'PASS';
    $remark = 'PASS';
} else {
}

#manage supplimentary exams
if ($gradesupp == 'C') {
    $unittaken = $unittaken - $unit;
    $totalsgp = $totalsgp - $sgp;
    $grade = 'C'; // put the fixed value of a supplimentary grade
    $point = 2; // put the fixed value for SUPP point whic is equivalent to 50 marks
    $sgp = $point * $unit;
    $totalsgp = $totalsgp + $sgp;
    $unittaken = $unittaken + $unit;
    #empty gradesupp
    $gradesupp = '';
}

#format sgp and totalsgp
$sgp = number_format($sgp, 1, '.', ',');
$totalsgp = number_format($totalsgp, 1, '.', ',');

#get course semester
$qsem = "SELECT YearOffered FROM course WHERE CourseCode = '$course'";
$dbsem = mysqli_query($zalongwa, $qsem);
$row_sem = mysqli_fetch_assoc($dbsem);
$semname = $row_sem['YearOffered'];
#get semester IDs
$qsemid = "SELECT Id FROM terms WHERE Semester = '$semname'";
$dbsemid = mysqli_query($zalongwa, $qsemid);
$row_semid = mysqli_fetch_assoc($dbsemid);
$semid = $row_semid['Id'];
?>
