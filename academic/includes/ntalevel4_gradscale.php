<?php
#get raw results
include 'getrawresult.php';

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
    if ($tmarks >= 50) {
        $unittaken = $unittaken - $unit;
        $totalsgp = $totalsgp - $sgp;
        $grade = 'C'; // put the fixed value of a supplimentary grade
        $point = 2; // put the fixed value for SUPP point whic is equivalent to 50 marks
        $sgp = $point * $unit;
        $totalsgp = $totalsgp + $sgp;
        $unittaken = $unittaken + $unit;
        #empty gradesupp
        $gradesupp = '';
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

#test if CA>=10
if (($test2score < 10) && ($test2score <> 'n/a')) {
    $grade = 'F';
    $remark = 'F-CWK';
    $egrade = '*';
    $fsup = '!';
    $supp = '!';
} elseif ($remarks == 'Inc') {
    $grade = 'I';
    $remark = 'ABSC';
    $igrade = 'I';
} elseif ($marks == -2) {
    $grade = 'PASS';
    $remark = 'PASS';
} else {
}

#test Final Exam
/*if(($aescore < 20) && ($nullae==0))
{
    $grade='F';
    $remark = 'F-EXM';
    $egrade='*';
    $fsup='!';
    $supp='!';
}*/
if (($aescore < 20) && ($nullae == 1) && ($spscore == '')) {
    $grade = 'I';
    $igrade = 'I';
    $remark = 'ABSC';
}


#prohibit the printing of zeros in coursework and exam
if ($nullca == 1 and $test2score == 0) {
    $test2score = '';
    $remark = 'ABSC';
}
if ($grade == 'I' and $marks == 0) {
    $marks = '';
    $remark = 'ABSC';
}

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
