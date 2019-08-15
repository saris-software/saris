	<?php 
	require_once('../Connections/zalongwa.php'); 
	require_once('../Connections/sessioncontrol.php');
	$course = $_POST['course'];
	$venue = $_POST['venue'];
	$venuecapacity = trim ($_POST['venuecapa'],")(");
	$coursepacity = trim ($_POST['coursecapa'],")(");
	$start = $_POST["start"];
	$end =$_POST["end"];
	$day= $_POST['day'];
	$lecturer= $_POST['lecturer'];
	$ayear = $_POST['ayear'];
	$programme = $_POST['programme'];
	$type = $_POST['type'];
	$teaching=$_POST['teaching'];
	$id = $_POST['id'];
	$actio = $_POST['action'];
	
	$error = FALSE;
	if(empty($course)){
		$error =TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Drag Course first</div>';
	}
	if(empty($venue)){
		$error =TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Drag Venue first</div>';
	}
	if(empty($start)){
		$error =TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Select start time</div>';
	}
	if(empty($end)){
		$error =TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Select End time </div>';
	}
	if(empty($day)){
		$error =TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Select Day please</div>';
	}
	
	if(empty($teaching)){
		$error =TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Select Teaching type</div>';
	}
	
	if($coursepacity > $venuecapacity){
	
		//$error =TRUE;
		//echo '<div  style="color:red; margin:0px 0px 0px 20px;">Venue Capacity is not enough to accomodate total number of student in that course</div>';
	
	}
	
	if($start > $end || ($start == $end)){
		$error =TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Start time should be less that end time</div>';
	}
	
	
	if($id == 0 && $actio =="SAVE"){

      $get_year_of_study ="SELECT * FROM courseprogramme WHERE ProgrammeID='$programme' AND AYear='$ayear' AND CourseCode='$course'";
      $class=0;
      $result = mysql_query($get_year_of_study);
	$found = mysql_num_rows($result);
	if($found == 1){
	$ftchclass= mysql_fetch_array($result);
	$class = $ftchclass['YearofStudy'];
     } 

	// check if venue is free at that time 
	if($error ==FALSE){
		
	//check kama venue inatumika kwa mda huo, (hapa ni case start time ipo katikati ya kipind kingine)
	$sql_check = "SELECT * FROM timetable WHERE   end <='$end' AND venue='$venue' AND day='$day' AND timetable_category='$type' AND AYear='$ayear' AND CourseCode !='$course'"; 
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);
	if($found > 0){
	
	$test = TRUE;
	
	while($ftch = mysql_fetch_array($result)){
	$strt_time = $ftch['start'];
	$endtest_time = $ftch['end'];
	if($strt_time < $start && $endtest_time > $start){
	$test = false;
	break;
	}
	}
	
	if($test == FALSE){
	$error =TRUE;
	echo '<div  style="color:red; margin:0px 0px 0px 20px;">Venue occupied in that time</div>';
	
	}
	
	}
	
	
	$sql_check = "SELECT * FROM timetable WHERE start>='$start' AND end <='$end' AND venue='$venue' AND day='$day' AND timetable_category='$type' AND AYear='$ayear' AND CourseCode !='$course'";
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);
	// check kama venue inatumika
	if($found > 0){
		$error = TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Venue occupied in that time</div>';
	}

	
//check kama hiyo programme inakipind kingine mda huo
$sql_check = "SELECT * FROM timetable WHERE start>='$start' AND end <='$end' AND Programme='$programme' AND day='$day' AND timetable_category='$type' AND AYear='$ayear' AND YoS='$class'";
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);
	// check kama venue inatumika
	if($found > 0){
		$error = TRUE;
		$cl ='';
		if($class =1){
		$cl ='FIRST YEAR ' ;
		}else if($class =2){
		$cl ='SECOND YEAR ' ;
		}else if($class =3){
		$cl ='THIRD YEAR ' ;
		}else if($class =4){
		$cl ='FOURTH YEAR ' ;
		}else if($class =5){
		$cl ='FIFTH YEAR ' ;
		}else if($class =6){
		$cl ='SIXTH YEAR ' ;
		}
		$cl .=' student has another Lecture in that Time';
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">'.$cl.'</div>';
	}

	//check kama venue inatumika kwa mda huo, (hapa ni case start time ipo katikati ya kipind kingine)
	$sql_check = "SELECT * FROM timetable WHERE  end <='$end' AND Programme='$programme' AND day='$day' AND timetable_category='$type' AND AYear='$ayear' AND YoS='$class'";
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);
	if($found > 0){
	
	$test = TRUE;
	
	while($ftch = mysql_fetch_array($result)){
	$strt_time = $ftch['start'];
	$endtest_time = $ftch['end'];
	if($strt_time < $start && $endtest_time > $start){
	$test = false;
	break;
	}
	}
	
	if($test == FALSE){
	$error =TRUE;
	$cl ='';
		if($class =1){
		$cl ='FIRST YEAR '; 
		}else if($class =2){
		$cl ='SECOND YEAR '; 
		}else if($class =3){
		$cl ='THIRD YEAR ' ;
		}else if($class =4){
		$cl ='FOURTH YEAR ' ;
		}else if($class =5){
		$cl ='FIFTH YEAR ' ;
		}else if($class =6){
		$cl ='SIXTH YEAR ' ;
		}
		$cl .=' student has another Lecture in that Time';
	echo '<div  style="color:red; margin:0px 0px 0px 20px;">'.$cl.'</div>';
	
	}
	
	}






	//check kama mwalimu anakipindi kingine kwa wakati huo
	if($error == FALSE){
	$sql_check = "SELECT * FROM timetable WHERE start>='$start' AND end <='$end' AND timetable_category='$type' AND day='$day' AND  AYear='$ayear' AND lecturer='$lecturer' AND CourseCode !='$course'";
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);	
	if($found > 0){
		$error = TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Lecturer has the Period in that time</div>';
	}
	
	
	
	
	$sql_check = "SELECT * FROM timetable WHERE <='$end' AND timetable_category='$type' AND day='$day' AND  AYear='$ayear' AND lecturer='$lecturer' AND CourseCode !='$course'";
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);
	if($found > 0){
	
	$test = TRUE;
	
	while($ftch = mysql_fetch_array($result)){
	$strt_time = $ftch['start'];
	$endtest_time = $ftch['end'];
	if($strt_time < $start && $endtest_time > $start){
	$test = false;
	break;
	}
	}
	
	if($test == FALSE){
	$error =TRUE;
	echo '<div  style="color:red; margin:0px 0px 0px 20px;">Lecturer has the Period in that time</div>';
	
	}
	
	}
	
	
	
	
	
	
	
	//check kama mwanafunz ana course nyingine kwa mda huo
	// hapa haijakaa vizur ina tatizo
	$sem = '';
	
	if($type == 1){
		$sem .=" AND Semester ='1'";
	}else if($type == 2){
		$sem .=" AND Semester ='2'";
	}
	
	
	//get year of the CourseCode
	$sql_check = "SELECT * FROM courseprogramme WHERE CourseCode='$course' AND ProgrammeID = '$programme' AND AYear='$ayear' ".$sem;
	$result = mysql_query($sql_check);
	$course_code = mysql_fetch_array($result);
	$co_code = $course_code['YearofStudy'];
	
	
	// get all course study of that level either is first Year or Second Year or Third year etc 
	$sql_check = "SELECT DISTINCT CourseCode,ProgrammeID FROM courseprogramme WHERE YearofStudy='$co_code'  AND AYear ='$ayear' ".$sem;
	$get_course = mysql_query($sql_check);
	$num = mysql_num_rows($get_course);
	
	if($num > 0){
	while ($row = mysql_fetch_array($get_course)) { // loop in all course 
	    $error = FALSE;
		$course_shared_name = $row['CourseCode']; 
		// check if there is two Programme study that course
		$sql_check = "SELECT *  FROM courseprogramme WHERE CourseCode='$course_shared_name' AND AYear ='$ayear' ".$sem;
		$result = mysql_result($sql_check);
		$num = mysql_num_rows($result);
		if($num > 1){
		     // the course is study by more than one programme
			//check if the other programme has period on that time
		   while ($sh = mysql_fetch_array($result)) {
		    $prog = $sh['ProgrammeID'];
		    $sql_check = "SELECT * FROM timetable WHERE start>='$start' AND end <='$end' AND timetable_category='$type'  AND AYear='$ayear' AND day='$day' AND Programme='$prog'";
		    $res = mysql_query($sql_check);
		    $num = mysql_num_rows($res);
		      if($num > 0){
		      	$error = TRUE;
		      	echo '<div  style="color:red; margin:0px 0px 0px 20px;">Wanafunzi wanaochukua Programme ya'.$prog.' Wanakipind mda kama huu</div>';
		      	exit;
		      }
		    }	
		}
		
		
	if($error == TRUE){
		exit;
	}
	}
	
	}
	
	
	
	if($error == TRUE){
		exit;
	}
	
	
	
	
	if($error == FALSE){
		$interval = $end - $start;
		$sql_insert = "INSERT INTO timetable(AYear,Programme,timetable_category,CourseCode,start,end,venue,lecturer,Recorder,start_end,day,teachingtype,YoS) VALUE('$ayear','$programme','$type','$course','$start','$end','$venue','$lecturer','$username','$interval','$day','$teaching','$class')";
		$insert = mysql_query($sql_insert);
		if($insert){
						echo '<div  style="color:green; margin:0px 0px 0px 20px;">Data successfully saved, CourseCode:'.$course.'</div>';
		}else{
			echo '<div  style="color:red; margin:0px 0px 0px 20px;">Data fail to saved!!!!</div>';
		}
	}
	
	
	
	
	
	}
	
	}
	
	}else if($id > 0 && $actio =="EDIT"){ // start editing from here
		
		  $get_year_of_study ="SELECT * FROM courseprogramme WHERE ProgrammeID='$programme' AND AYear='$ayear' AND CourseCode='$course'";
      $class=0;
      $result = mysql_query($get_year_of_study);
	$found = mysql_num_rows($result);
	if($found == 1){
	$ftchclass= mysql_fetch_array($result);
	$class = $ftchclass['YearofStudy'];
     }
		
		
		
		
	$sql_check = "SELECT * FROM timetable WHERE   end <='$end' AND venue='$venue' id !='$id' AND day='$day' AND timetable_category='$type' AND AYear='$ayear'"; 
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);
	if($found > 0){
	
	$test = TRUE;
	
	while($ftch = mysql_fetch_array($result)){
	$strt_time = $ftch['start'];
	$endtest_time = $ftch['end'];
	if($strt_time < $start && $endtest_time > $start){
	$test = false;
	break;
	}
	}
	
	if($test == FALSE){
	$error =TRUE;
	echo '<div  style="color:red; margin:0px 0px 0px 20px;">Venue occupied in that time</div>';
	
	}
	
	}
	
	
	
		
		
		
	
	// check if venue is free at that time
	if($error ==FALSE){
	$sql_check = "SELECT * FROM timetable WHERE start>='$start' AND end <='$end' AND id !='$id' AND venue='$venue' AND day='$day' AND timetable_category='$type' AND AYear='$ayear'";
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);
	// check kama venue inatumika
	if($found > 0){
		$error = TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Venue occupied in that time</div>';
	}
	
	//check kama mwalimu anakipindi kingine kwa wakati huo
	if($error == FALSE){
	$sql_check = "SELECT * FROM timetable WHERE start>='$start' AND end <='$end' AND id !='$id' AND timetable_category='$type' AND day='$day' AND  AYear='$ayear' AND lecturer='$lecturer'";
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);	
	if($found > 0){
		$error = TRUE;
		echo '<div  style="color:red; margin:0px 0px 0px 20px;">Lecturer has the Period in that time</div>';
	}
	
		$sql_check = "SELECT * FROM timetable WHERE <='$end' AND timetable_category='$type' AND id !='$id' AND day='$day' AND  AYear='$ayear' AND lecturer='$lecturer'";
	$result = mysql_query($sql_check);
	$found = mysql_num_rows($result);
	if($found > 0){
	
	$test = TRUE;
	
	while($ftch = mysql_fetch_array($result)){
	$strt_time = $ftch['start'];
	$endtest_time = $ftch['end'];
	if($strt_time < $start && $endtest_time > $start){
	$test = false;
	break;
	}
	}
	
	if($test == FALSE){
	$error =TRUE;
	echo '<div  style="color:red; margin:0px 0px 0px 20px;">Lecturer has the Period in that time</div>';
	
	}
	
	}
	
	
	//check kama mwanafunz ana course nyingine kwa mda huo
	// hapa haijakaa vizur ina tatizo
	$sem ='';
	if($type == 1){
		$sem."= AND Semester ='1'";
	}else if($type == 2){
		$sem."= AND Semester ='2'";
	}
	
	
	//get year of the CourseCode
	$sql_check = "SELECT * FROM courseprogramme WHERE CourseCode='$course' AND ProgrammeID = '$programme' AND AYear='$ayear' ".$sem;
	$result = mysql_query($sql_check);
	$course_code = mysql_fetch_array($result);
	$co_code = $course_code['YearofStudy'];
	
	
	// get all course study of that level either is first Year or Second Year or Third year etc 
	$sql_check = "SELECT DISTINCT CourseCode,ProgrammeID FROM courseprogramme WHERE YearofStudy='$co_code'  AND AYear ='$ayear' ".$sem;
	$get_course = mysql_query($sql_check);
	$num = mysql_num_rows($get_course);
	if($num > 0){
	while ($row = mysql_fetch_array($get_course)) { // loop in all course 
		$course_shared_name = $row['CourseCode']; 
		// check if there is two Programme study that course
		$sql_check = "SELECT *  FROM courseprogramme WHERE CourseCode='$course_shared_name' AND AYear ='$ayear' ".$sem;
		$result = mysql_result($sql_check);
		$num = mysql_num_rows($result);
		if($num > 1){
			// the course is study by more than one programme
			//check if the other programme has period on that time
		   while ($sh = mysql_fetch_array($result)) {
		    $prog = $sh['ProgrammeID'];
		    $sql_check = "SELECT * FROM timetable WHERE start>='$start' AND end <='$end' AND timetable_category='$type'  AND AYear='$ayear' AND day='$day' AND Programme='$prog'";
		    $res = mysql_query($sql_check);
		    $num = mysql_num_rows($res);
		      if($num > 0){
		      	$error = TRUE;
		      	echo '<div  style="color:red; margin:0px 0px 0px 20px;">Wanafunzi wanaochukua Programme ya'.$prog.' Wanakipind mda kama huu</div>';
		      	exit;
		      }
		     
		    }	
			
		}
		if($error == TRUE){
			exit;
		}
	}
	}
	if($error == TRUE){
		exit;
	}
	// haijakaa vizuri
	
	
	if($error == FALSE){
		$interval = $end - $start;
		$sql_update = "UPDATE timetable SET CourseCode = '$course', start ='$start',end='$end',venue='$venue',lecturer='$lecturer',Recorder='$username',start_end='$interval',day='$day', teachingtype='$teaching', YoS='$class' WHERE id='$id'";
		$update = mysql_query($sql_update);
		if($update){
			echo '<div  style="color:green; margin:0px 0px 0px 20px;">Data successfully Updated, CourseCode:'.$course.'</div>';
		}else{
			echo '<div  style="color:red; margin:0px 0px 0px 20px;">Fail to update!!!!</div>';
		}
	}
	
	
	
	
	
	}
	}
		
	}
	
	
	?>
	
