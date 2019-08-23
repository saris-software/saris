<?php
#reset gpa calculation values
$point = '';
$grade = '';
$remark = '';

#query Annual Exam
$qae = "SELECT ExamCategory, Examdate, ExamScore, AYear FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=5";
$dbae = mysqli_query($zalongwa, $qae);
$total_ae = mysqli_num_rows($dbae);
$row_ae = mysqli_fetch_array($dbae);
$value_aescore = $row_ae['ExamScore'];
if (($total_ae > 0) && ($value_aescore <> '')) {
    $aedate = $row_ae['ExamDate'];
    $aescore = $value_aescore;
} else {
    $remarks = "Inc";
    $aescore = '';
}

#get total marks
if (($row_sup_total > 0) && ($supscore <> '')) {
    $tmarks = $supscore;
    if ($tmarks >= 50) {
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
$marks = number_format($tmarks, 0);

#grade marks
if ($nullca == 1 and $test2score == 0) {
    $grade = 'I';
    $remark = 'Inc.';
    $point = 0;
    $sgp = $point * $unit;
} elseif ($remarks == 'Inc') {
    $grade = 'I';
    $remark = 'Inc.';
    $point = 0;
    $sgp = $point * $unit;
} else {
    if ($marks >= 80) {
        $grade = 'A';
        $remark = 'PASS';
        $point = 5;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
    } elseif ($marks >= 70) {
        $grade = 'B+';
        $remark = 'PASS';
        $point = 4;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
    } elseif ($marks >= 60) {
        $grade = 'B';
        $remark = 'PASS';
        $point = 3;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
    } elseif ($marks >= 50) {
        $grade = 'C';
        $remark = 'PASS';
        $point = 2;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
    } else {
        $grade = 'F';
        $remark = 'FAIL';
        $fsup = '!';
        $supp = '!';
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


#prohibit the printing of zeros in coursework and exam
if ($grade == 'I' and $marks == 0) {
    $marks = '';
    $remark = 'ABSC';
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
#get semester ID
$qsemid = "SELECT Id FROM terms WHERE Semester = '$semname'";
$dbsemid = mysqli_query($zalongwa, $qsemid);
$row_semid = mysqli_fetch_assoc($dbsemid);
$semid = $row_semid['Id'];
?>