<?php
#convert entries to float values for validation purposes
$hw1score1 = floatval($hw1score);
$hw2score1 = floatval($hw2score);
$qz1score1 = floatval($qz1score);
$qz2score1 = floatval($qz2score);
$aescore1 = floatval($aescore);
$gascore1 = floatval($gascore);
$supscore1 = floatval($supscore);
$proscore1 = floatval($proscore);
$ct1score1 = floatval($ct1score);
$ct2score1 = floatval($ct2score);
$spscore1 = floatval($spscore);

$semq = "SELECT Semester from examregister where CourseCode='$key' and AYear='$ayear'";
$qsem = mysqli_query($zalongwa, $semq);
$qqsem = mysqli_fetch_array($qsem);
$wsem = $qqsem['Semester'];

$qstatus = "SELECT Status FROM examresult WHERE CourseCode='$key' AND RegNo='$regno' AND AYear='$ayear'";
$dbstatus = mysqli_query($zalongwa, $qstatus);
$row_status = mysqli_fetch_array($dbstatus);
$status = $row_status['Status'];

#update hw1
if (("$hw1score1" != "$hw1score" && "$hw1score" <> "") || $hw1score > 40) {
    echo $hw1score . ' Is Invalid CWK Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 1";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester='$wsem', 
							ExamScore = '$hw1score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 1";
        mysqli_select_db($zalongwa, $database_zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 1,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$hw1score'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

#update hw2
if (("$hw2score1" != "$hw2score" && "$hw2score" <> "") || $hw2score > 40) {
    echo $hw2score . ' Is Invalid CWK Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 2";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester='$wsem', 
							ExamScore = '$hw2score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 2";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 2,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$hw2score'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

#update qz1
if (("$qz1score1" != "$qz1score" && "$qz1score" <> "") || $qz1score > 40) {
    echo $qz1score . ' Is Invalid CWK Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 3";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester='$wsem', 
							ExamScore = '$qz1score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 3";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 3,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$qz1score'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

#update qz2
if (("$qz2score1" != "$qz2score" && "$qz2score" <> "") || $qz2score > 40) {
    echo $qz2score . ' Is Invalid CWK Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 4";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester='$wsem', 
							ExamScore = '$qz2score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 4";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 4,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$qz2score'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

#update Semester Exam
if (("$aescore1" != "$aescore" && "$aescore" <> "") || $aescore > 100) {
    echo $aescore . ' Is Invalid Semester Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 5";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester='$wsem', 
							ExamScore = '$aescore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 5";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 5,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$aescore'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

#update ga
if (("$gascore1" != "$gascore" && "$gascore" <> "") || $gascore > 40) {
    echo $gascore . ' Is Invalid CWK Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 6";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester='$wsem', 
							ExamScore = '$gascore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 6";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 6,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$gascore'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}


#update supplimentary
if (("$supscore1" != "$supscore" && "$supscore" <> "") || $supscore > 100) {
    echo $supscore . ' Is Invalid Semester Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 7";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester='$wsem', 
							ExamScore = '$supscore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 7";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL) or die("<br>Officer huwezi ku-update");
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 7,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							ExamScore = '$supscore'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

#update proj
if (("$proscore1" != "$proscore" && "$proscore" <> "") || $proscore > 100) {
    echo $proscore . ' Is Invalid CWK Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 8";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester='$wsem', 
							ExamScore = '$proscore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 8";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 8,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$proscore'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

#update TT1
if (("$ct1score1" != "$ct1score" && "$ct1score" <> "") || $ct1score > 40) {
    echo $ct1score . ' Is Invalid CWK Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 9";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							Semester='$wsem',
							ExamScore = '$ct1score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 9";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 9,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$ct1score'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

#update TT2
if (("$ct2score1" != "$ct2score" && "$ct2score" <> "") || $ct2score > 40) {
    echo $ct2score . ' Is Invalid CWK Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 10";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							Semester='$wsem',
							ExamScore = '$ct2score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 10";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 10,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$ct2score'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

#update Special
if (("$spscore1" != "$spscore" && "$spscore" <> "") || $spscore > 100) {
    echo $spscore . ' Is Invalid CWK Exam Score Entry <br>';
} else {
    #check whether to update or to insert
    $qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 11";
    $chkdb = mysqli_query($zalongwa, $qchk);
    if (mysqli_num_rows($chkdb) > 0) {
        #update
        $updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							Semester='$wsem',
							ExamScore = '$spscore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 11";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    } else {
        #insert
        $updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamCategory = 11,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Semester='$wsem',
							Status='$status',
							ExamScore = '$spscore'
						";
        mysqli_select_db($database_zalongwa, $zalongwa);
        $Result1 = mysqli_query($zalongwa, $updateSQL);
    }
}

?>
