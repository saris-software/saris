<?php
require_once('../Connections/sessioncontrol.php');
# include the header
include('studentMenu.php');
global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
$szSection = 'Academic Records';
$szTitle = 'Exam Registration: Please Pick a Course';
$szSubSection = 'Exam Register';
include("studentheader.php");
?>
<?php
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

    //get submitted vaules
    $course = addslashes($_POST['course']);
    $ayear = addslashes($_POST['Ayear']);

    //query current Year
    $qyear = "SELECT AYear from academicyear WHERE Status = 1";
    $dbyear = mysqli_query($zalongwa, $qyear);
    $row_year = mysqli_fetch_assoc($dbyear);
    $currentYear = $row_year['AYear'];
    if ($currentYear <> $ayear) {
        echo "You Cannot Register For This Year:" . $ayear . "<br> Registration Rejected !!";
        exit;
    }
    //get total registered student
    $qregistered = "
            SELECT DISTINCT COUNT(course.CourseCode) as Total, 
                                    course.CourseCode,
                                        examregister.AYear 						 
            FROM examregister 
                INNER JOIN course ON (examregister.CourseCode = course.CourseCode)
            WHERE (examregister.AYear ='$ayear') AND examregister.CourseCode = '$course'
            GROUP BY course.CourseCode";
    $dbregistered = mysqli_query($zalongwa, $qregistered);
    $row_registered = mysqli_fetch_assoc($dbregistered);
    $totalRegistered = $row_registered['Total'];

    //get course capacity
    $qregister = "SELECT Status from student where RegNo='" . $_POST['regno'] . "'";

    $dbregister = mysqli_query($zalongwa, $qregister);

    $row_register = mysqli_fetch_assoc($dbregister);

    $register = $row_register['Status'];
    if ($register == 3) {
        $insertSQL = sprintf("INSERT INTO examregister (AYear, Semester, RegNo, CourseCode, Recorder, Checked) 
                                                            VALUES (%s, %s, %s, %s, %s, %s)",
            GetSQLValueString($_POST['Ayear'], "text"),
            GetSQLValueString($_POST['semester'], "text"),
            GetSQLValueString($_POST['regno'], "text"),
            GetSQLValueString($_POST['course'], "text"),
            GetSQLValueString($_POST['user'], "text"),
            GetSQLValueString($_POST['checked'], "text"));

        mysqli_select_db($zalongwa, $database_zalongwa);
        $Result1 = mysqli_query($zalongwa, $insertSQL) or die(mysqli_error($zalongwa));
        echo '<meta http-equiv = "refresh" content ="0; 
                                url = studentAcademic.php">';
    } else {
        echo '<p style="color:red;">Registration Not Possible, See the Admission Officer for Registration!!. </p><br>';

    }
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_ExamOfficerGradeBook = 20;
$pageNum_ExamOfficerGradeBook = 0;
if (isset($_GET['pageNum_ExamOfficerGradeBook'])) {
    $pageNum_ExamOfficerGradeBook = $_GET['pageNum_ExamOfficerGradeBook'];
}
$startRow_ExamOfficerGradeBook = $pageNum_ExamOfficerGradeBook * $maxRows_ExamOfficerGradeBook;
//this block of code was formely commented
mysqli_select_db($zalongwa, $database_zalongwa);
$query_ExamOfficerGradeBook = "SELECT CourseCode, AYear, SemesterID FROM examresult";
$query_limit_ExamOfficerGradeBook = sprintf("%s LIMIT %d, %d", $query_ExamOfficerGradeBook, $startRow_ExamOfficerGradeBook, $maxRows_ExamOfficerGradeBook);
$ExamOfficerGradeBook = mysqli_query($zalongwa, $query_limit_ExamOfficerGradeBook) or die(mysqli_error($zalongwa));
$row_ExamOfficerGradeBook = mysqli_fetch_assoc($ExamOfficerGradeBook);


if (isset($_GET['totalRows_ExamOfficerGradeBook'])) {
    $totalRows_ExamOfficerGradeBook = $_GET['totalRows_ExamOfficerGradeBook'];
} else {
    $all_ExamOfficerGradeBook = mysqli_query($zalongwa, $query_ExamOfficerGradeBook);
    @$totalRows_ExamOfficerGradeBook = mysqli_num_rows(@$all_ExamOfficerGradeBook);
}
$totalPages_ExamOfficerGradeBook = ceil($totalRows_ExamOfficerGradeBook / $maxRows_ExamOfficerGradeBook) - 1;

mysqli_select_db($zalongwa, $database_zalongwa);
$query_Ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$Ayear = mysqli_query($zalongwa, $query_Ayear) or die(mysqli_error($zalongwa));
$row_Ayear = mysqli_fetch_assoc($Ayear);
$totalRows_Ayear = mysqli_num_rows($Ayear);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_semester = "SELECT Description FROM terms ORDER BY Semester ASC";
$semester = mysqli_query($zalongwa, $query_semester) or die(mysqli_error($zalongwa));
$row_semester = mysqli_fetch_assoc($semester);
$totalRows_semester = mysqli_num_rows($semester);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_course = "SELECT CourseCode, CourseName FROM course ORDER BY CourseCode ASC";
$course = mysqli_query($zalongwa, $query_course) or die(mysqli_error($zalongwa));
$row_course = mysqli_fetch_assoc($course);
$totalRows_course = mysqli_num_rows($course);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_lecturer = "SELECT RegNo FROM student ORDER BY RegNo ASC";
$lecturer = mysqli_query($zalongwa, $query_lecturer) or die(mysqli_error($zalongwa));
$row_lecturer = mysqli_fetch_assoc($lecturer);
$totalRows_lecturer = mysqli_num_rows($lecturer);

$queryString_ExamOfficerGradeBook = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (stristr($param, "pageNum_ExamOfficerGradeBook") == false &&
            stristr($param, "totalRows_ExamOfficerGradeBook") == false) {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0) {
        $queryString_ExamOfficerGradeBook = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_ExamOfficerGradeBook = sprintf("&totalRows_ExamOfficerGradeBook=%d%s", $totalRows_ExamOfficerGradeBook, $queryString_ExamOfficerGradeBook);

$browser = $_SERVER["HTTP_USER_AGENT"];
$ip = $_SERVER["REMOTE_ADDR"];

$sql = "INSERT INTO stats(ip,browser,received,page) VALUES('$ip','$browser',now(),'$username')";
$result = mysqli_query($zalongwa, $sql) or die("Siwezi kuingiza data.<br>" . mysqli_error($zalongwa));
?>
<?php
#get values
@$CourseCode = $_GET['CourseCode'];
?>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    <table width="59%" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
            <td width="17%" nowrap>
                <div align="right">Academic Year:</div>
            </td>
            <td width="16%"><select name="Ayear" id="Ayear">
                    <option value="0">[Select Academic Year]</option>
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_Ayear['AYear'] ?>"><?php echo $row_Ayear['AYear'] ?></option>
                        <?php
                    } while ($row_Ayear = mysqli_fetch_assoc($Ayear));
                    $rows = mysqli_num_rows($Ayear);
                    if ($rows > 0) {
                        mysqli_data_seek($Ayear, 0);
                        $row_Ayear = mysqli_fetch_assoc($Ayear);
                    }
                    ?>
                </select></td>
            <td width="15%" nowrap>
                <div align="right">Course Code:</div>
            </td>
            <td width="52%"><input name="course" type="hidden" id="course"
                                   value="<?php echo $CourseCode; ?>"><?php echo $CourseCode; ?></td>
        </tr>
        <tr>
            <td nowrap>
                <div align="right">Semester:</div>
            </td>
            <td><select name="semester" id="semester">
                    <option value="0">[Select Semester]</option>
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_semester['Description'] ?>"><?php echo $row_semester['Description'] ?></option>
                        <?php
                    } while ($row_semester = mysqli_fetch_assoc($semester));
                    $rows = mysqli_num_rows($semester);
                    if ($rows > 0) {
                        mysqli_data_seek($semester, 0);
                        $row_semester = mysqli_fetch_assoc($semester);
                    }
                    ?>
                </select></td>
            <td nowrap>
                <div align="right">
                    <input name="user" type="hidden" id="user" value="<?php echo $username; ?>">
                    <input name="checked" type="hidden" id="checked" value="0">
                    Your RegNo:
                </div>
            </td>
            <td><input name="regno" type="hidden" id="regno" value="<?php echo $RegNo; ?>">
                <?php echo $RegNo; ?></td>
        </tr>
        <tr>
            <td colspan="4">
                <div align="center">
                    <input type="submit" name="Submit" value="Save Records">
                </div>
            </td>
        </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1">
</form>

<?php
@mysqli_free_result($ExamOfficerGradeBook);

@mysqli_free_result($Ayear);

@mysqli_free_result($semester);

@mysqli_free_result($course);

@mysqli_free_result($lecturer);
mysqli_close($zalongwa);
?>
