<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
    include('includes/choose_studylevel.php');
	
	# initialise globals
	include('examination.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Search';
	$szTitle = 'Examination Result';
	//include('lecturerheader.php');

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

if (isset($_POST['search']) && ($_POST['search'] == "Search")) {
#get post variables
$rawkey = trim(addslashes($_POST['key']));
$key = preg_replace("[[:space:]]+", " ",$rawkey);
#get student info
$qstudent = "SELECT Name, RegNo, ProgrammeofStudy from student WHERE regno = '$key'";
$dbstudent = mysqli_query($zalongwa, $qstudent);
$row_result = mysqli_fetch_array($dbstudent);
$name = $row_result['Name'];
$regno = $row_result['RegNo'];
$degree = $row_result['ProgrammeofStudy'];
/*
# get all courses for this candidate
$qcourse="SELECT DISTINCT course.Units, 
						  course.Department, 
						  course.StudyLevel, 
						  examresult.AYear, 
						  examresult.CourseCode 
          FROM 
			course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
          WHERE 
				(course.Programme = '$degree') AND 
				(RegNo='$key')
		  ORDER BY examresult.AYear, examresult.CourseCode";	
*/

# get all courses for this candidate
$qcourse="SELECT DISTINCT c.Units, c.Department, c.StudyLevel, e.AYear, 
						  e.CourseCode, e.Semester FROM course c, examresult e
						  WHERE c.CourseCode = e.CourseCode	AND e.RegNo='$key'
						  ORDER BY e.AYear";
							
$dbcourse = mysqli_query($zalongwa, $qcourse) or die("No Exam Results for the Candidate - $key ");
$total_rows = mysqli_num_rows($dbcourse);

if($total_rows>0){
#initialise s/no
$sn=0;
	
	//get degree name
	$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
	$dbdegree = mysqli_query($zalongwa, $qdegree);
	$row_degree = mysqli_fetch_array($dbdegree);
	$programme = $row_degree['Title'];
	echo  "$name - $regno <br> $programme";	
?>

<table width="200" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="center"><strong>S/No</strong></div></td>
					<td nowrap><div align="center"><strong>Year</strong></div></td>
                    <td nowrap><div align="center"><strong>Course Code</strong></div></td>
					<td><div align="center"><strong>CW </strong></div></td>
					<td><div align="center"><strong>Exam </strong></div></td>
					<td><div align="center"><strong>Sup </strong></div></td>
					<td><div align="center"><strong>Spec </strong></div></td>
					<td><div align="center"><strong>TP </strong></div></td>
					<td><div align="center"><strong>PT </strong></div></td>
					<td><div align="center"><strong>Proj </strong></div></td>
                    <td><div align="center"><strong>Total</strong></div></td>
                    <td><div align="center"><strong>Grade</strong></div></td>
                    <td><div align="center"><strong>Remarks</strong></div></td>
                  </tr>
<?php
		while($row_course = mysqli_fetch_array($dbcourse)){
				$course= $row_course['CourseCode'];
				$units= $row_course['Units'];
				$ayear= $row_course['AYear'];
				$coursefaculty = $row_course['Department'];
				$semtr = $row_course['Semester'];
				$sn=$sn+1;
				$remarks = 'remarks';
				$RegNo = $key;
				#include grading system
				include 'includes/choose_studylevel.php';
				
				#display results
				?>
                  <tr>
				  <td>
				  	<?php if ($privilege==2){
					echo "<a href=\"lecturerEditsingleresult.php?Candidate=$regno&Course=$course&AYear=$ayear&Semester=$semtr\">$sn</a>" ;
					}else{
					echo $sn;
					}?>
					</td>
                    <td><div align="center"><?php echo $ayear ?> </div></td>
					<td><div align="center"><?php echo $course ?> </div></td>
					<td><div align="center"><?php echo $test2score ?> </div></td>
					<td><div align="center"><?php echo $aescore ?> </div></td>
					<td><div align="center"><?php echo $supscore ?> </div></td>
					<td><div align="center"><?php echo $spscore ?> </div></td>
					<td><div align="center"><?php echo $tpscore ?></div></td>
					<td><div align="center"><?php echo $ptscore ?></div></td>
					<td><div align="center"><?php echo $proscore ?></div></td>
                    <td><div align="center"><?php echo $marks ?> </div></td>
                    <td><div align="center"><?php echo $grade ?> </div></td>
                    <td><div align="center"><?php echo $remark ?></div></td>
                  </tr>
				<?php
			//close while loop
		}
		?>
</table>
		=================================<br>
		Student Exam Results View<br>
		=================================<br>
		<?php
		$RegNo=$regno;
		$examofficer=1;
		include('../student/studentexamresult.php');
		//include('../student/studentexamresult_exm.php');
	//close if total statement
	}
}elseif (isset($_GET['search'])){
#get post variables
$key = $_SESSION['search'];
#get student info
$qstudent = "SELECT Name, RegNo, ProgrammeofStudy from student WHERE regno = '$key'";
$dbstudent = mysqli_query($zalongwa, $qstudent);
$row_result = mysqli_fetch_array($dbstudent);
$name = $row_result['Name'];
$regno = $row_result['RegNo'];
$degree = $row_result['ProgrammeofStudy'];
/*
# get all courses for this candidate
$qcourse="SELECT DISTINCT course.Units, 
						  course.Department, 
						  course.StudyLevel, 
						  examresult.AYear, 
						  examresult.CourseCode 
          FROM 
			course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
          WHERE 
				(course.Programme = '$degree') AND 
				(RegNo='$key')
		  ORDER BY examresult.AYear";	
*/

# get all courses for this candidate
$qcourse="SELECT DISTINCT c.Units, c.Department, c.StudyLevel, e.AYear, 
						  e.CourseCode, e.Semester FROM course c, examresult e
						  WHERE c.CourseCode = e.CourseCode	AND e.RegNo='$key'
						  ORDER BY e.AYear";
						  
$dbcourse = mysqli_query($zalongwa, $qcourse) or die("No Exam Results for the Candidate - $key ");
$total_rows = mysqli_num_rows($dbcourse);

if($total_rows>0){
#initialise s/no
$sn=0;
	
	//get degree name
	$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
	$dbdegree = mysqli_query($zalongwa, $qdegree);
	$row_degree = mysqli_fetch_array($dbdegree);
	$programme = $row_degree['Title'];
	echo  "$name - $regno <br> $programme";	
?>

<table width="200" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="center"><strong>S/No</strong></div></td>
					<td nowrap><div align="center"><strong>Year</strong></div></td>
                    <td nowrap><div align="center"><strong>Course Code</strong></div></td>
					<td><div align="center"><strong>CW </strong></div></td>
					<td><div align="center"><strong>Exam </strong></div></td>
					<td><div align="center"><strong>Sup </strong></div></td>
					<td><div align="center"><strong>Spec </strong></div></td>
					<td><div align="center"><strong>TP </strong></div></td>
					<td><div align="center"><strong>PT </strong></div></td>
					<td><div align="center"><strong>Proj </strong></div></td>
                    <td><div align="center"><strong>Total</strong></div></td>
                    <td><div align="center"><strong>Grade</strong></div></td>
                    <td><div align="center"><strong>Remarks</strong></div></td>
                  </tr>
<?php
		while($row_course = mysqli_fetch_array($dbcourse)){
				$course= $row_course['CourseCode'];
				$units= $row_course['Units'];
				$ayear= $row_course['AYear'];
				$coursefaculty = $row_course['Department'];
				$semtr = $row_course['Semester'];
				$sn=$sn+1;
				$remarks = 'remarks';
				$RegNo = $key;
				#include grading system
				include 'includes/choose_studylevel.php';
				
				#display results
				?>
                  <tr>
				  <td>
				  	<?php if ($privilege==2){
					echo "<a href=\"lecturerEditsingleresult.php?Candidate=$regno&Course=$course&AYear=$ayear&Semester=$semtr\">$sn</a>" ;
					}else{
					echo $sn;
					}?>
					</td>
                    <td><div align="center"><?php echo $ayear ?> </div></td>
					<td><div align="center"><?php echo $course ?> </div></td>
					<td><div align="center"><?php echo $test2score ?> </div></td>
					<td><div align="center"><?php echo $aescore ?> </div></td>
					<td><div align="center"><?php echo $supscore ?> </div></td>
					<td><div align="center"><?php echo $spscore ?> </div></td>
					<td><div align="center"><?php echo $tpscore ?></div></td>
					<td><div align="center"><?php echo $ptscore ?></div></td>
					<td><div align="center"><?php echo $proscore ?></div></td>
                    <td><div align="center"><?php echo $marks ?> </div></td>
                    <td><div align="center"><?php echo $grade ?> </div></td>
                    <td><div align="center"><?php echo $remark ?></div></td>
                  </tr>
				<?php
			//close while loop
		}
		?>
	</table>
	<?php
	}
}else{

?>
  

<head>
  <title>policy setup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>


<div align select="center">
<div class="container" style="width:30%">




              <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentRoomApplication" id="studentRoomApplication">
  
          
<div class="form-group">
      <label for="address">Reg No:</label>
        <input class="form-control" name="key" type="text" id="key" placeholder="Enter Registration no" size="40" maxlength="40">
    </div>
         <button class="btn btn-outline-dark" type="submit" name="search" value="">Search</td>

     </button>
     </form>
  
  
</form>
<?php
}
include('../footer/footer.php');
?>
