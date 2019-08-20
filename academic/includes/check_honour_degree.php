<?php
	#query Supplementatary Exam
	$qsup = "SELECT ExamCategory, Examdate, ExamScore FROM examresult WHERE RegNo='$key' AND ExamCategory=7 AND ExamScore>0";
	$dbsup=mysql_query($qsup);
	$row_sup=mysql_fetch_array($dbsup);
	$row_sup_total=mysql_num_rows($dbsup);
	$supdate=$row_sup['ExamDate'];
	$supscore=$row_sup['ExamScore'];
	if(($row_sup_total>0)&&($supscore<>'')){
		#flag no honour degree value
		$checksupp ='1';
	}
?>
