<?php
#convert entries to float values for validation purposes
$hw1score1=floatval($hw1score);
$hw2score1=floatval($hw2score);
$qz1score1=floatval($qz1score);
$qz2score1=floatval($qz2score);
$aescore1=floatval($aescore);
$gascore1=floatval($gascore);
$supscore1=floatval($supscore);
$proscore1=floatval($proscore);
$ct1score1=floatval($ct1score);
$ct2score1=floatval($ct2score);
$spscore1=floatval($spscore);

#Get result semester and if results are published
$sem_sql = "SELECT DISTINCT Semester, Checked FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' ORDER BY Checked DESC";
$sem_db = mysql_query($sem_sql);
$row_sem = mysql_fetch_object($sem_db);
$course_sem = $row_sem->Semester;
$course_published = $row_sem->Checked;

#update hw1
	if (("$hw1score1"!="$hw1score" && "$hw1score" <> "") || $hw1score>40){
	   echo $hw1score.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 1";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(), 
							ExamScore = '$hw1score',
							Semester = '$course_sem',
							Checked = '$course_published'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 1";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 1,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$hw1score'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}

#update hw2
	if (("$hw2score1"!="$hw2score" && "$hw2score" <> "") || $hw2score>40){
	   echo $hw2score.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 2";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$hw2score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 2";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 2,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$hw2score'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}

	#update qz1
	if (("$qz1score1"!="$qz1score" && "$qz1score" <> "") || $qz1score>40){
	   echo $qz1score.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 3";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$qz1score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 3";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 3,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$qz1score'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}

	#update qz2
	if (("$qz2score1"!="$qz2score" && "$qz2score" <> "") || $qz2score>40){
	   echo $qz2score.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 4";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$qz2score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 4";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 4,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$qz2score'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}

	#update Semester Exam
	if (("$aescore1"!="$aescore" && "$aescore" <> "") || $aescore>100){
	   echo $aescore.' Is Invalid Semester Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 5";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$aescore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 5";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 5,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$aescore'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}

	#update ga
	if (("$gascore1"!="$gascore" && "$gascore" <> "") || $gascore>40){
	   echo $gascore.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 6";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$gascore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 6";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 6,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$gascore'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}


	#update supplimentary
	if (("$supscore1"!="$supscore" && "$supscore" <> "") || $supscore>100){
	   echo $supscore.' Is Invalid Semester Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 7";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$supscore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 7";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL) or die("<br>Officer huwezi ku-update");
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 7,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$supscore'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
   }

   	#update proj
	if (("$proscore1"!="$proscore" && "$proscore" <> "") || $proscore>100){
	   echo $proscore.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 8";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$proscore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 8";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 8,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$proscore'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}

   	#update TT1
	if (("$ct1score1"!="$ct1score" && "$ct1score" <> "") || $ct1score>40){
	   echo $ct1score.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 9";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$ct1score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 9";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 9,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$ct1score'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}

   	#update TT2
	if (("$ct2score1"!="$ct2score" && "$ct2score" <> "") || $ct2score>40){
	   echo $ct2score.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 10";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$ct2score'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 10";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 10,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$ct2score'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}

   	#update Special
	if (("$spscore1"!="$spscore" && "$spscore" <> "") || $spscore>100){
	   echo $spscore.' Is Invalid CWK Exam Score Entry <br>';
	   }else{
	    #check whether to update or to insert
		$qchk = "SELECT ExamScore FROM examresult WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 11";
		$chkdb = mysql_query($qchk);
		if (mysql_num_rows($chkdb)>0) {
			#update
			$updateSQL = "UPDATE examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamScore = '$spscore'
						WHERE RegNo='$regno' AND CourseCode='$key' AND ExamCategory = 11";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
			}else{
				#insert
				$updateSQL = "INSERT INTO examresult 
						SET 
							Recorder = '$username', 
							RecordDate = now(),
							Semester = '$course_sem', 
							ExamCategory = 11,
							RegNo='$regno',
							CourseCode='$key',
							AYear = '$ayear',
							Checked = '$course_published',
							ExamScore = '$spscore'
						";
			mysql_select_db($database_zalongwa, $zalongwa);
			$Result1 = mysql_query($updateSQL);
		}
	}

?>
