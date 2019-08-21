<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Grade Book';
	$szTitle = 'Examination Grade Book';
	include('lecturerheader.php');

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$key=addslashes($_POST['coursecode']);
	$ayear=addslashes($_POST['ayear']);
	$RegNo = $_POST['RegNo'];
	$cwk = $_POST['cwk'];
	$examcat = addslashes($_POST['examcat']);
	$examdate = addslashes($_POST['examdate']);
	$exammarker = addslashes($_POST['exammarker']);
	//$core=$_POST['core'];
	$comment = $_POST['comment'];
	$max = sizeof($RegNo);
	$_SESSION['max']=$max;

	#start for loop to treat each candidate
	for($c = 0; $c < $max; $c++) {
	$score1 = $cwk[$c];
	$score2 = floatval($cwk[$c]);
	$sql_check ="SELECT * FROM examresult WHERE RegNo='$RegNo[$c]' AND CourseCode='$key' AND AYear = '$ayear' AND ExamCategory='$examcat'";
               
                 $result_sql =mysqli_query($zalongwa, $sql_check);
                    $num_row = mysqli_num_rows($result_sql);

                    if($num_row == 0){

// insert data
$updateSQL = "REPLACE INTO examresult(AYear, Marker, CourseCode, ExamCategory, ExamDate, Recorder, RecordDate, RegNo, ExamScore, Status, Comment)


						 VALUES ('$ayear', '$exammarker', '$key', '$examcat', '$examdate', '$username', now(), '$RegNo[$c]', '$cwk[$c]', '1', '$comment[$c]')";
}else{
//update

$value_exist = mysqli_fetch_array($result_sql);

if($value_exist['ExamScore'] <> $cwk[$c]){
 $updateSQL = "UPDATE examresult SET  Marker='$exammarker',  ExamDate='$examdate', Recorder='$username', RecordDate='".date('Y-m-d')."', ExamScore='$cwk[$c]', Status='1', Comment='$comment[$c]'  WHERE RegNo='$RegNo[$c]' AND CourseCode='$key' AND AYear = '$ayear' AND ExamCategory='$examcat'";
}
}
				//$updateSQL = "REPLACE INTO examresult(AYear, Marker, CourseCode, ExamCategory, ExamDate, Recorder, RecordDate, RegNo, ExamScore, Status, Comment)
						 //VALUES ('$ayear', '$exammarker', '$key', '$examcat', '$examdate', '$username', now(), '$RegNo[$c]', '$cwk[$c]', '1', '$comment[$c]')";
					mysqli_select_db($zalongwa, $database_zalongwa);
				switch ($examcat) {
									case 1:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>40){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;

									case 2:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>40){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;

									case 3:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>40){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;
									case 4:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>40){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;
										
									case 5:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>100){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;

									case 6:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>40){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;
									case 7:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>100){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;
									case 8:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>40){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;
									case 9:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>40){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;
									case 10:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>40){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;
									case 11:
										if (("$score2"!="$score1" && "$score1" <> "") || $score1>100){
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
					                       }else{
					                       $Result1 = mysqli_query($zalongwa, $updateSQL);
					                     }
										break;

									default:
										   $_SESSION['err'.$c] =  $score1.' is invalid exam score entry to: '.$RegNo[$c].'<br>';
										   $err = 1;
								}
				}//close for loop
			#session error
			$_SESSION['err']=$err;
			echo "<br>Database updated successfully";
			#open data entry form again
	 	    echo '<meta http-equiv = "refresh" content ="0; 
				 url = lecturerGradebookAdd.php?r=1">';
	exit;
			
}else{		
		$key=addslashes($_POST['course']);
		$ayear=addslashes($_POST['ayear']);
		$examcat=addslashes($_POST['examcat']);
		$exammarker=addslashes($_POST['exammarker']);
		$examdate=addslashes($_POST['examdate']);
		$sem=addslashes($_POST['sem']);
		$r=addslashes($_GET['r']);

		#implements session, so that the grade book comes back
		if ($r==1){
		  $key=$_SESSION['key'];
		  $ayear=$_SESSION['ayear'];
		  $examcat=$_SESSION['examcat'];
		  $examdate=$_SESSION['examdate'] ;
		  $_POST["view"] = 'Edit Records';
		  
		  #print out errors from last gradebook posting
		  if($_SESSION['err']==1){
		  $i=0;
				  ?>
				  Ooops! Data Entry Errors: <br>
				  <?php 
			  while ($i<$_SESSION['max']){
				  ?>
				  <span class="style1">
				  <?php 
				  echo $_SESSION['err'.$i];
				  echo '</span>';
				  #update session to null
				  $_SESSION['err'.$i]='';
				  $i=$i+1;
			  }
		  }
		}else{
			#put data in sessions
			$_SESSION['key'] = $key;
			$_SESSION['ayear'] = $ayear;
			$_SESSION['examcat'] = $examcat;
			$_SESSION['examdate'] = $examdate;
		}
		
		//chas 
		//check if the course and exam selections are done 
		if(($examcat==0) && ((strlen($key)<6) || (strlen($key)>9))){
			echo "<b>ERROR:</b> Choose the <b>Exam Category</b> and <b>Course Code</b> first";
			exit;
		}
		if($examcat==0){
			echo "<b>ERROR:</b> Choose the <b>Exam Category</b> for \"$key\" first";
			exit;
		}
		if((strlen($key)<6) || (strlen($key)>9)){
			echo "<b>ERROR:</b> Choose the <b>Course Code</b> first";
			exit;
		}
		//end  of exam and course selection check

		if(strlen($examdate)<4){
			echo '<b>Warning:-</b> You must specify Exam Date <br> Click on Pick Date command to get calendar <br> if you proceed the system will use this date: ';
			$today = date("Y-m-d");
			echo $today;
			$examdate = $today;
		}
}

if((isset($_POST["view"])) && ($_POST["view"] == "Edit Records")){
$query_addexam_edit = "
                SELECT DISTINCT student.Name,
								course.CourseCode,
								course.CourseName, 
								examresult.ExamSitting,
								examresult.CourseCode,
								examresult.ExamScore,
								examresult.ExamCategory,
								examresult.ExamDate,
								examresult.Status,
								examresult.RegNo,
								examresult.Comment,
								examresult.Checked,
								programme.ProgrammeName
			   FROM programme, course
					   INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
					   INNER JOIN student ON (examresult.RegNo = student.RegNo)
					   WHERE ( (examresult.CourseCode='$key') AND (examresult.AYear='$ayear') 
							 AND (examresult.ExamCategory = '$examcat') AND (student.ProgrammeofStudy = programme.ProgrammeCode) )
					   ORDER BY programme.ProgrammeName, examresult.RegNo ASC";

$query_addexam_add = "
                SELECT DISTINCT student.Name,
				                course.CourseCode,
								course.CourseName, 
								examregister.CourseCode,
								examregister.RegNo,
								examregister.Checked,
								programme.ProgrammeName
			   FROM programme, course
					   INNER JOIN examregister ON (course.CourseCode = examregister.CourseCode)
					   INNER JOIN student ON (examregister.RegNo = student.RegNo)
							 WHERE ( 
									  (examregister.CourseCode='$key') 
									 AND  
									  (examregister.AYear='$ayear') 
									  AND 
									  (student.ProgrammeofStudy = programme.ProgrammeCode)
								   )
							ORDER BY programme.ProgrammeName, examregister.RegNo ASC";
}			
$addexam = mysqli_query($zalongwa, $query_addexam_add) or die('Problem: Check the Add Query!');
$row_addexam = mysqli_fetch_array($addexam);
#get course code and course title
$qcourse = "SELECT CourseCode, CourseName from course WHERE CourseCode = '$key'";
$dbcourse = mysqli_query($zalongwa, $qcourse);
$row_course = mysqli_fetch_assoc($dbcourse);
$coursecode = $row_course['CourseCode'];
$coursename = $row_course['CourseName'];

#display form for updating records
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $key ?></title>
	<style type="text/css">
			body{font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px}
			h1, h2{font-size:20px;}
			.style1 {color: #990000}
	</style>
</head>
<body>
	<?php
				#display Exam Category
					$qcat="select Id,Description from examcategory where Id='$examcat'";
					$dbcat=mysqli_query($zalongwa, $qcat);
					$row_cat=mysqli_fetch_array($dbcat);
				#display Exam Marker
					$qmaker="select * from exammarker where Id='$exammarker'";
					$dbmarker=mysqli_query($zalongwa, $qmaker);
					$row_marker=mysqli_fetch_array($dbmarker);
				?>
            <?php // echo "<b> Course: </b>".$row_addexam['CourseCode']; </span>: ?><?php //echo $row_addexam['CourseName']."<br>"; ?>
            <?php echo "<b> Course: </b>".$coursecode; ?></span>: <?php echo $coursename."<br>"; ?>
			<?php echo "<b> Category: </b>".$row_cat['Description']."<br>"; ?>
			<?php echo "<b> Exam Date: </b>".$examdate."<br>"; ?>
			<?php
			#display import functionality
			include 'zalongwaimport.php';
			?>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">

                   <span class="style71"> <span class="style67">EXAMINATION RESULTS  BLACKSHEET FOR, <?php echo $ayear ?></span><br>
 <hr>
            <input name="coursecode" type="hidden" id="coursecode" value="<?php echo $coursecode //$row_addexam['CourseCode']; ?>">
			<input name="exammarker" type="hidden" id="exammarker" value="<?php echo $exammarker; ?>">
			<input name="examcat" type="hidden" id="examcat" value="<?php echo $examcat; ?>">
			<input name="examdate" type="hidden" id="examdate" value="<?php echo $examdate ?>">
			<input name="ayear" type="hidden" id="ayear" value="<?php echo $ayear ?>">
	           <p>  
			
			<?php 
			if ($privilege == '2') {
			?>   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <tr bgcolor="#CCCCCC">
                <td width="4%"><strong>S/No</strong></td>
				<td width="20%" nowrap><strong>Degree Course</strong></td>
                <td width="12%"><strong>Name</strong></td>
                <td width="15%"><strong>RegNo</strong></td>
                <td width="4%"><strong>Score</strong></td>
                <td width="6%"><strong>Sitting </strong></td>
				<td width="4%"><strong>Drop</strong></td>
              </tr>
              <?php $i=1;
			  $addexam_add = mysqli_query($zalongwa, $query_addexam_add) or die('Problem: Check the Add Query!');
			  while ($row_addexam = mysqli_fetch_assoc($addexam_add)){
			    $currentreg = $row_addexam['RegNo'];
			    $currentcourse = $row_addexam['CourseCode'];

			  //check for duplicates
				$qduplicate="SELECT RegNo FROM examresult WHERE RegNo='$currentreg' AND ExamCategory='$examcat' AND CourseCode='$currentcourse'";
				$dbduplicate=mysqli_query($zalongwa, $qduplicate) or die('Problem');
				$total_row = mysqli_num_rows($dbduplicate);
				if($total_row < 1){
			  ?>
              <tr bgcolor="#CCCCCC">
                <td align="left" valign="middle"><div align="left"> <?php echo $i; ?> </div></td>
				<td align="left" valign="middle" nowrap><?php echo $row_addexam['ProgrammeName']; ?></td>
                <td align="left" valign="middle" nowrap><?php echo $row_addexam['Name']; ?></td>
                <td align="left" valign="middle" nowrap>
				<input name="RegNo[]" type="hidden" id="RegNo[]" value="<?php echo $row_addexam['RegNo']; ?>">
				<input name="sitting[]" type="hidden" id="sitting[]" value="1">
                <?php $regno=$row_addexam['RegNo']; echo $row_addexam['RegNo']; ?></td>
                <td nowrap>
                <input name="cwk[]" type="text" id="cwk[]" value="<?php echo $row_addexam['ExamScore']; ?>" size="3"></td>
                <td nowrap><select name="comment[]" id="comment[]">
                  <?php
				#populate stitting combo box
					$sit=$row_addexam['Comment'];
					$qsitting="select Id,Description from sitting where Id='$sit'";
					$dbsitting=mysqli_query($zalongwa, $qsitting);
					$row_sitting=mysqli_fetch_array($dbsitting);
					if($sit==''){
				?>
				<option value="1">First</option>
				<?php }else{ ?>
                  <option value="<?php echo $row_sitting['Id'] ?>"><?php echo $row_sitting['Description'] ?></option>
				  <?php } ?>
                  <option value="1">First</option>
				  <option value="4">Repeater</option>
                  <option value="2">Supp</option>
				  <option value="3">Special</option>
                </select></td>
                
                <td><?php print "<a href=\"lecturerexalresultdelete.php?RegNo=$regno&ayear=$ayear&key=$key\">Drop</a>";?></td>
              </tr>
              <?php $i=$i+1;
			    }
			  }  #ends while add loops
			  #starts edit row display
			  $addexam = mysqli_query($zalongwa, $query_addexam_edit) or die('Problem: Check the Add Query!');
			  while ($row_addexam = mysqli_fetch_assoc($addexam)){ ?>
			  
              <tr bgcolor="#CCCCCC">
                <td align="left" valign="middle"><div align="left"> <?php echo $i; ?> </div></td>
				<td align="left" valign="middle" nowrap><?php echo $row_addexam['ProgrammeName']; ?></td>
                <td align="left" valign="middle" nowrap><?php echo stripslashes($row_addexam['Name']); ?></td>
                <td align="left" valign="middle">
				<input name="RegNo[]" type="hidden" id="RegNo[]" value="<?php echo $row_addexam['RegNo']; ?>">
				<input name="sitting[]" type="hidden" id="sitting[]" value="1">
                <?php $regno=$row_addexam['RegNo']; echo $row_addexam['RegNo']; ?></td>
                <td>
                <input name="cwk[]" type="text" id="cwk[]" value="<?php echo $row_addexam['ExamScore']; ?>" size="3"></td>
                <td><select name="comment[]" id="comment[]">
                  <?php
				#populate stitting combo box
					$sit=$row_addexam['Comment'];
					$qsitting="select Id,Description from sitting where Id='$sit'";
					$dbsitting=mysqli_query($zalongwa, $qsitting);
					$row_sitting=mysqli_fetch_array($dbsitting);
					if($sit==''){
				?>
				<option value="1">First</option>
				<?php }else{ ?>
                  <option value="<?php echo $row_sitting['Id'] ?>"><?php echo $row_sitting['Description'] ?></option>
				  <?php } ?>
                  <option value="1">First</option>
				  <option value="4">Repeater</option>
                  <option value="2">Supp</option>
				  <option value="3">Special</option>
                </select></td>
                <td><?php print "<a href=\"lecturerexalresultdelete.php?RegNo=$regno&ayear=$ayear&key=$key\">Drop</a>";?></td>
              </tr>
              <?php $i=$i+1;
			   }  #ends while edit row
			   ?>
			  
            </table>
		
		<?php }else{?>
			
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <tr bgcolor="#CCCCCC">
                <td width="4%"><strong>S/No</strong></td>
				<td width="20%" nowrap><strong>Degree Course</strong></td>
                <td width="13%"><strong>Name</strong></td>
                <td width="16%"><strong>RegNo</strong></td>
                <td width="4%"><strong>Score</strong></td>
                <td width="6%"><strong>Sitting </strong></td>
              </tr>
              <?php $i=1;
			  $addexam_add = mysqli_query($zalongwa, $query_addexam_add) or die('Problem: Check the Add Query!');
			  while ($row_addexam = mysqli_fetch_assoc($addexam_add)){
			    $currentreg = $row_addexam['RegNo'];
				$checked = $row_addexam['Checked'];
			    $currentcourse = $row_addexam['CourseCode'];

			  //check for duplicates
				$qduplicate="SELECT RegNo FROM examresult WHERE RegNo='$currentreg' AND ExamCategory='$examcat' AND CourseCode='$currentcourse'";
				$dbduplicate=mysqli_query($zalongwa, $qduplicate) or die('Problem');
				$total_row = mysqli_num_rows($dbduplicate);
				if(($total_row < 1) && ($checked==0)){
			  ?>
              <tr bgcolor="#CCCCCC">
                <td align="left" valign="middle"><div align="left"> <?php echo $i; ?> </div></td>
				<td align="left" valign="middle" nowrap><?php echo $row_addexam['ProgrammeName']; ?></td>
                <td align="left" valign="middle" nowrap><?php echo $row_addexam['Name']; ?></td>
                <td align="left" valign="middle"><input name="RegNo[]" type="hidden" id="RegNo[]" value="<?php echo $row_addexam['RegNo']; ?>">
                <?php $regno=$row_addexam['RegNo']; echo $row_addexam['RegNo']; ?></td>
                <td>
                <input name="cwk[]" type="text" id="cwk[]" value="<?php echo $row_addexam['ExamScore']; ?>" size="3"></td>
				<input name="sitting[]" type="hidden" id="sitting[]" value="1">
                <td><select name="comment[]" id="comment[]">
                  <?php
				#populate stitting combo box
					$sit=$row_addexam['Comment'];
					$qsitting="select Id,Description from sitting where Id='$sit'";
					$dbsitting=mysqli_query($zalongwa, $qsitting);
					$row_sitting=mysqli_fetch_array($dbsitting);
					if($sit==''){
				?>
				<option value="1">First</option>
				<?php }else{ ?>
                  <option value="<?php echo $row_sitting['Id'] ?>"><?php echo $row_sitting['Description'] ?></option>
				  <?php } ?>
                  <option value="1">First</option>
				  <option value="4">Repeater</option>
                  <option value="2">Supp</option>
				  <option value="3">Special</option>
                </select></td>
              </tr>
              <?php $i=$i+1;
			   }
			  } #ends while add row exam
			  $addexam = mysqli_query($zalongwa, $query_addexam_edit) or die('Problem: Check the Add Query!');
			  while ($row_addexam = mysqli_fetch_assoc($addexam)) {
			  $checked = $row_addexam['Checked'];
			  if ($checked==0){
			  ?>
              <tr bgcolor="#CCCCCC">
                <td align="left" valign="middle"><div align="left"> <?php echo $i; ?> </div></td>
				<td align="left" valign="middle" nowrap><?php echo $row_addexam['ProgrammeName']; ?></td>
                <td align="left" valign="middle" nowrap><?php echo $row_addexam['Name']; ?></td>
                <td align="left" valign="middle"><input name="RegNo[]" type="hidden" id="RegNo[]" value="<?php echo $row_addexam['RegNo']; ?>">
                <?php $regno=$row_addexam['RegNo']; echo $row_addexam['RegNo']; ?></td>
                <td>
                <input name="cwk[]" type="text" id="cwk[]" value="<?php echo $row_addexam['ExamScore']; ?>" size="3"></td>
				<input name="sitting[]" type="hidden" id="sitting[]" value="1">
                <td><select name="comment[]" id="comment[]">
                  <?php
				#populate stitting combo box
					$sit=$row_addexam['Comment'];
					$qsitting="select Id,Description from sitting where Id='$sit'";
					$dbsitting=mysqli_query($zalongwa, $qsitting);
					$row_sitting=mysqli_fetch_array($dbsitting);
					if($sit==''){
				?>
				<option value="1">First</option>
				<?php }else{ ?>
                  <option value="<?php echo $row_sitting['Id'] ?>"><?php echo $row_sitting['Description'] ?></option>
				  <?php } ?>
                  <option value="1">First</option>
				  <option value="4">Repeater</option>
                  <option value="2">Supp</option>
				  <option value="3">Special</option>
                </select></td>
              </tr>
              <?php $i=$i+1;
			    } //ends checked ==0
			  }
			  ?>
    </table> 
            <?php } ?>
            <p>
              <input name="cmdEdit" type="submit" id="cmdEdit" value="Update Records">
              <input type="hidden" name="MM_update" value="form1">
            </p>
</form>
<?php
// } 
include('../footer/footer.php');
?>
