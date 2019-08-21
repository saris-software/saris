<?php
#get connected to the database and verfy current session
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');

# initialise globals
include('../admissionMenu.php');

# include the header
global $szSection, $szSubSection;
$szSection = 'Admission Process';
$szSubSection = 'Admission Status';
$szTitle = 'Admission Statistics';
include('../admissionheader.php');

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

mysqli_select_db($zalongwa, $database_zalongwa);
$query_AcademicYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
$AcademicYear = mysqli_query($zalongwa, $query_AcademicYear) or die(mysqli_error($zalongwa));
$row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
$totalRows_AcademicYear = mysqli_num_rows($AcademicYear);

mysqli_select_db($zalongwa, $database_zalongwa);
$query_Hostel = "SELECT ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$Hostel = mysqli_query($zalongwa, $query_Hostel) or die(mysqli_error($zalongwa));
$row_Hostel = mysqli_fetch_assoc($Hostel);
$totalRows_Hostel = mysqli_num_rows($Hostel);

//Print Room Allocation Report
if (isset($_POST['nominalroll']) && ($_POST['nominalroll'] == "Print Report")) {
#get post variables
    $year = $_POST['ayear'];
    $hall = $_POST['degree'];
    $all = $_POST['check'];

    if ($all == 'on') {
        # Genda Statistics
        //get total female students
        $query_sexf = "SELECT Id FROM student WHERE (student.EntryYear='$year') AND Sex = 'F'";
        $sexf = mysqli_query($zalongwa, $query_sexf) or die(mysqli_error($zalongwa));
        $row_sexf = mysqli_fetch_assoc($sexf);
        $totalRows_sexf = mysqli_num_rows($sexf);
        //get total male student
        $query_sexm = "SELECT Id FROM student WHERE (student.EntryYear='$year') AND Sex = 'M'";
        $sexm = mysqli_query($zalongwa, $query_sexm) or die(mysqli_error($zalongwa));
        $row_sexm = mysqli_fetch_assoc($sexm);
        $totalRows_sexm = mysqli_num_rows($sexm);
        //get unknown sex
        $query_sexu = "SELECT Id FROM student WHERE (student.EntryYear='$year') AND Sex = ''";
        $sexu = mysqli_query($zalongwa, $query_sexu) or die(mysqli_error($zalongwa));
        $row_sexu = mysqli_fetch_assoc($sexu);
        $totalRows_sexu = mysqli_num_rows($sexu);
        //calculate
        $total = $totalRows_sexf + $totalRows_sexm + $totalRows_sexu;
        $percentf = $totalRows_sexf / $total * 100;
        $percentm = $totalRows_sexm / $total * 100;
        $percentu = $totalRows_sexu / $total * 100;
        //print genda statistics
        echo "Grand Total Student    = " . number_format($total, 0, '.', ',') . "<br>";
        echo "Total Female Students: = " . number_format($totalRows_sexf, 0, '.', ',') . " (" . number_format($percentf, 1, '.', ',') . "%)<br>";
        echo "Total Male Students:   = " . number_format($totalRows_sexm, 0, '.', ',') . " (" . number_format($percentm, 1, '.', ',') . "%)<br>";
        echo "Total Unknown Students:= " . number_format($totalRows_sexu, 0, '.', ',') . " (" . number_format($percentu, 1, '.', ',') . "%)<br>";
    } else {
        # Genda Statistics
        //get total female students
        $query_sexf = "SELECT Id FROM student WHERE (student.EntryYear='$year') 
						AND (student.ProgrammeofStudy = '$hall') AND Sex = 'F'";
        $sexf = mysqli_query($zalongwa, $query_sexf) or die(mysqli_error($zalongwa));
        $row_sexf = mysqli_fetch_assoc($sexf);
        $totalRows_sexf = mysqli_num_rows($sexf);
        //get total male student
        $query_sexm = "SELECT Id FROM student WHERE (student.EntryYear='$year') 
						AND (student.ProgrammeofStudy = '$hall') AND Sex = 'M'";
        $sexm = mysqli_query($zalongwa, $query_sexm) or die(mysqli_error($zalongwa));
        $row_sexm = mysqli_fetch_assoc($sexm);
        $totalRows_sexm = mysqli_num_rows($sexm);
        //get unknown sex
        $query_sexu = "SELECT Id FROM student WHERE (student.EntryYear='$year') 
						AND (student.ProgrammeofStudy = '$hall') AND Sex = ''";
        $sexu = mysqli_query($zalongwa, $query_sexu) or die(mysqli_error($zalongwa));
        $row_sexu = mysqli_fetch_assoc($sexu);
        $totalRows_sexu = mysqli_num_rows($sexu);
        //calculate
        $total = $totalRows_sexf + $totalRows_sexm + $totalRows_sexu;
        $percentf = $totalRows_sexf / $total * 100;
        $percentm = $totalRows_sexm / $total * 100;
        $percentu = $totalRows_sexu / $total * 100;
        //print genda statistics
        echo "Grand Total Student    = " . number_format($total, 0, '.', ',') . "<br>";
        echo "Total Female Students: = " . number_format($totalRows_sexf, 0, '.', ',') . " (" . number_format($percentf, 1, '.', ',') . "%)<br>";
        echo "Total Male Students:   = " . number_format($totalRows_sexm, 0, '.', ',') . " (" . number_format($percentm, 1, '.', ',') . "%)<br>";
        echo "Total Unknown Students:= " . number_format($totalRows_sexu, 0, '.', ',') . " (" . number_format($percentu, 1, '.', ',') . "%)<br>";
    }

} else {

    ?>

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="studentRoomApplication"
          id="studentRoomApplication">
        <table width="284" border="0">

            <tr>
                <td width="111" nowrap>
                    <div align="right"><span class="style67">Print All Records:</span></div>
                </td>
                <td width="157" bordercolor="#ECE9D8" bgcolor="#CCCCCC"><span class="style67">
            <input name="check" type="checkbox" id="check">
</span></td>
            </tr>
            <tr>
                <td nowrap>
                    <div align="right">Academic Year:</div>
                </td>
                <td bgcolor="#CCCCCC"><select name="ayear" id="select2">
                        <?php
                        do {
                            ?>
                            <option value="<?php echo $row_AcademicYear['AYear'] ?>"><?php echo $row_AcademicYear['AYear'] ?></option>
                            <?php
                        } while ($row_AcademicYear = mysqli_fetch_assoc($AcademicYear));
                        $rows = mysqli_num_rows($AcademicYear);
                        if ($rows > 0) {
                            mysqli_data_seek($AcademicYear, 0);
                            $row_AcademicYear = mysqli_fetch_assoc($AcademicYear);
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td nowrap>
                    <div align="right">Programme:</div>
                </td>
                <td bgcolor="#CCCCCC"><select name="degree" id="select">
                        <?php
                        do {
                            ?>
                            <option value="<?php echo $row_Hostel['ProgrammeName'] ?>"><?php echo $row_Hostel['ProgrammeName'] ?></option>
                            <?php
                        } while ($row_Hostel = mysqli_fetch_assoc($Hostel));
                        $rows = mysqli_num_rows($Hostel);
                        if ($rows > 0) {
                            mysqli_data_seek($Hostel, 0);
                            $row_Hostel = mysqli_fetch_assoc($Hostel);
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td nowrap>
                    <div align="right">Click Submit to Save:</div>
                </td>
                <td bgcolor="#CCCCCC">
                    <input type="submit" name="nominalroll" value="Print Report"></td>
            </tr>
        </table>
        <input type="hidden" name="MM_insert" value="housingRoomApplication">
    </form>
    <?php
}
mysqli_free_result($AcademicYear);

mysqli_free_result($Hostel);
include('../../footer/footer.php');
?>
