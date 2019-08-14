<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Search';
	$szTitle = 'Examination Result';
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
if(isset($_POST['coursecode'])){
	$regno=addslashes($_POST['regno']);
	$ayear=addslashes($_POST['ayear']);
	$key=addslashes($_POST['coursecode']);
	$status=addslashes($_POST['status']);
	$hw1score=addslashes($_POST['hw1']);
	$hw2score=addslashes($_POST['hw2']);
	$qz1score=addslashes($_POST['qz1']);
	$qz2score=addslashes($_POST['qz2']);
	$aescore=addslashes($_POST['exam']);
	$gascore=addslashes($_POST['ga']);
	$supscore=addslashes($_POST['sup']);
	$proscore=addslashes($_POST['pro']);
	$ct1score=addslashes($_POST['tt1']);
	$ct2score=addslashes($_POST['tt2']);
	$spscore=addslashes($_POST['special']);

	include 'includes/exam_edit_result.php';
		
	#delete empty examscore records
	$sql_del = "delete from examresult where examscore=''";
	$db_del = mysql_query($sql_del);

	#Refresh exam result page
	echo "Database Updated Successfuly!";
	$_SESSION['search'] = $regno; 
	echo '<meta http-equiv = "refresh" content ="0; 
			 url = admissionExamResult.php?search=search">';
}

if (isset($_GET['Candidate'])) {
  $key=addslashes($_GET['Candidate']);
  $RegNo=$key;
  $course=addslashes($_GET['Course']);
  $ayear=addslashes($_GET['AYear']);
  echo "Editing Examination Results for Candidate: ".$RegNo;
  
  include'includes/getrawresult.php';

				#query status
				$qstatus = "SELECT Status FROM examregister WHERE CourseCode='$course' AND RegNo='$key'";
				$dbstatus=mysql_query($qstatus);
				$row_status=mysql_fetch_array($dbstatus);

				//display results in editable form
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="frmEdit">
				<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                  <tr>
                    <td>CourseCode</td>
                    <td>HW1</td>
					<td>HW2</td>
					<td>QZ1</td>
					<td>QZ2</td>
					<td>GA</td>
					<td>TT1</td>
					<td>TT2</td>
                    <td>Exam</td>
					<td>Sup</td>
					<td>Spec</td>
					<td>Proj/PT</td>
					<td nowrap>DropCourse</td>
                  </tr>
                  <tr>
                    <td><?php echo $course?><input name="coursecode" type="hidden" value="<?php echo $course?>"></td>
					<td><div align="center">
                      <input name="hw1" type="text" value="<?php echo $hw1score?>" size="4" maxlength="4">
                      <input name="regno" type="hidden" value="<?php echo $RegNo?>">
					  <input name="ayear" type="hidden" value="<?php echo $ayear?>">
					</div></td>
					<td><div align="center">
                      <input name="hw2" type="text" value="<?php echo $hw2score?>" size="4" maxlength="4">
					</div></td>
                    <td><div align="center">
                      <input name="qz1" type="text" value="<?php echo $qz1score?>" size="4" maxlength="4">
                    </div></td>
                    <td><div align="center">
                      <input name="qz2" type="text" value="<?php echo $qz2score?>" size="4" maxlength="4">
                    </div></td>
                    <td><div align="center">
                      <input name="ga" type="text" value="<?php echo $gascore?>" size="4" maxlength="4">
                    </div></td>
                    <td><div align="center">
                      <input name="tt1" type="text" value="<?php echo $ct1score?>" size="4" maxlength="4">
                    </div></td>
                    <td><div align="center">
                      <input name="tt2" type="text" value="<?php echo $ct2score?>" size="4" maxlength="4">
                    </div></td>					
								
					<td><div align="center">
                      <input name="exam" type="text" value="<?php echo $aescore100?>" size="4" maxlength="4">
                    </div></td>
					<td><div align="center">
                      <input name="sup" type="text" value="<?php echo $supscore?>" size="4" maxlength="4">
                    </div></td>
					<td><div align="center">
                      <input name="special" type="text" value="<?php echo $spscore?>" size="4" maxlength="4">
                    </div></td>
					<td><div align="center">
                      <input name="pro" type="text" value="<?php echo $proscore?>" size="4" maxlength="4">
                    </div></td>

                <td><?php print "<a href=\"lecturersingleresultdelete.php?RegNo=$key&key=$course\">Drop</a>";?></td>
                  </tr>
                </table>
				<input name="update" type="submit" value="Update Record">
				</form>
				<?php
 }
?>