<?php
	# find course's examninationregulation
	$qexamreg = "SELECT StudyLevel FROM course  WHERE  CourseCode = '$course'";
	$dbexamreg = mysqli_query($zalongwa, $qexamreg);
	$row_result_sheet = mysqli_fetch_array($dbexamreg);
	$studylevel= $row_result_sheet['StudyLevel'];

	if($studylevel == 1){
		include'ntalevel1_gradscale.php';
	}elseif($studylevel == 2){
		include'ntalevel2_gradscale.php';
	}elseif($studylevel == 3){
		include'ntalevel3_gradscale.php';
	}elseif($studylevel == 4){
		include'ntalevel4_gradscale.php'; 
	}elseif($studylevel == 5){
		include'ntalevel5_gradscale.php'; 
	}elseif($studylevel == 6){
		include'ntalevel6_gradscale.php'; 
	}elseif($studylevel == 7){
		include'ntalevel7_gradscale.php'; 
	}elseif($studylevel == 8){
		include'ntalevel8_gradscale.php'; 
	}elseif($studylevel == 9){
		include'ntalevel9_gradscale.php'; 
	}elseif($studylevel == 10){
		include'traditional_gradscale.php'; 
	}elseif($studylevel == 11){
		include'traditional_industrial_gradscale.php'; 
	}elseif($studylevel == 12){
		include'project_gradscale.php';
	}elseif($studylevel == 13){
		include'ntalevel4_industrial_gradscale.php';
	}elseif($studylevel == 14){
		include'ntalevel5_industrial_gradscale.php';
	}elseif($studylevel == 15){
		include'ntalevel7_industrial_gradscale.php';
	}elseif($studylevel == 16){
		include'ntalevel6_project_gradscale.php';
	}elseif($studylevel == 17){
		include'ntalevel8_project_gradscale.php';
	}elseif($studylevel == 18){
		include'postgraduate_system_gradscale.php';
	}elseif($studylevel == 19){
		include'postgraduate_research_gradscale.php';
	}else{ 
		# print nothing if no grading
		//include'ntalevel7_gradscale.php';
	}
	$studylevel= '';

?>