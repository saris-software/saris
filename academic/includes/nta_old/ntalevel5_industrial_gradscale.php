<?php
#reset gpa calculation values
$point = '';
$grade = '';
$remark = '';

#query Project Exam
$qproj = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE CourseCode='$course' AND RegNo='$RegNo' AND ExamCategory=5";
$dbproj = mysqli_query($zalongwa, $qproj);
$row_proj = mysqli_fetch_array($dbproj);
$row_proj_total = mysqli_num_rows($dbproj);
$projdate = $row_proj['ExamDate'];
$projscore = $row_proj['ExamScore'];
if (($row_proj_total > 0) && ($projscore <> '')) {
    $remarks = '';
    $aescore = number_format($projscore, 1);
    #empty coursework
    $test2score = 'n/a';
} else {
    $remarks = "Inc";
    $test2score = '';
    $aescore = '';
}

#get total marks
if (($row_sup_total > 0) && ($supscore <> '')) {
    $tmarks = $supscore;
    if ($tmarks >= 50) {
        $gradesupp = 'C';
        $remark = 'PASS';
    }
} elseif (($row_proj_total > 0) && ($projscore <> '')) {
    $tmarks = $projscore;
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
if ($remarks == 'Inc') {
    $grade = 'I';
    $igrade = 'I';
    $remark = 'Inc.';
    $point = 0;
    $sgp = $point * $unit;
} else {
    if ($marks >= 80) {
        $grade = 'A';
        $remark = 'PASS';
        $point = 4;
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
    } elseif ($marks >= 65) {
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
    } elseif ($marks >= 40) {
        $grade = 'D';
        $remark = 'FAIL';
        $fsup = '!';
        $supp = '!';
        $point = 1;
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

#test Final Exam
if (($aescore < 20) && ($nullae == 0)) {
    $grade = 'F';
    $remark = 'F-EXM';
    $egrade = '*';
    $fsup = '!';
    $supp = '!';
} elseif (($aescore < 20) && ($nullae == 1)) {
    $grade = 'I';
    $igrade = 'I';
    $remark = 'ABSC';
}


#prohibit the printing of zeros in coursework and exam
if ($grade == 'I' and $marks == 0) {
    $marks = '';
    $remark = 'ABSC';
}

#manage $aescore100
$aescore100 = $aescore;
$aescore = '';

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