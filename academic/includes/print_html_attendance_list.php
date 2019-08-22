<?php
#Get Organisation Name
$qorg = "SELECT * FROM organisation";
$dborg = mysqli_query($zalongwa, $qorg);
$row_org = mysqli_fetch_assoc($dborg);
$org = $row_org['Name'];

@$checkdegree = addslashes($_POST['checkdegree']);
@$checkyear = addslashes($_POST['checkyear']);
@$checkdept = addslashes($_POST['checkdept']);
@$checkcohot = addslashes($_POST['checkcohot']);
@$checkrem = addslashes($_POST['checkrem']);
$ovr = addslashes($_POST['ovrm']);

@$paper = 'a3'; //addslashes($_POST['paper']);
@$layout = 'L'; //addslashes($_POST['layout']);
if ($paper == 'a3') {
    $xpoint = 1050.00;
    $ypoint = 800.89;
} else {
    $xpoint = 800.89;
    $ypoint = 580.28;
}

$prog = $_POST['degree'];
$cohotyear = $_POST['cohot'];
$ayear = $_POST['ayear'];
$qprog = "SELECT ProgrammeCode, Title, Faculty, Ntalevel FROM programme WHERE ProgrammeCode='$prog'";
$dbprog = mysqli_query($zalongwa, $qprog);
$row_prog = mysqli_fetch_array($dbprog);
$progname = $row_prog['Title'];
$faculty = $row_prog['Faculty'];
$class = $row_prog['Ntalevel'];

//calculate year of study
$entry = intval(substr($cohotyear, 0, 4));
$current = intval(substr($ayear, 0, 4));
$yearofstudy = $current - $entry;

$deg = addslashes($_POST['degree']);
$year = addslashes($_POST['ayear']);
$cohot = addslashes($_POST['cohot']);
$dept = addslashes($_POST['dept']);
$sem = addslashes($_POST['sem']);
if ($sem == 'Semester I') {
    $semval = 1;
} elseif ($sem == 'Semester II') {
    $semval = 2;
}

echo $progname;
echo " - " . $cohot;
echo " - " . $sem;

#calculate year of study
$entry = intval(substr($cohot, 0, 4));
$current = intval(substr($ayear, 0, 4));
$yearofstudy = $current - $entry;

if ($yearofstudy == 0) {
    $class = "FIRST YEAR";
} elseif ($yearofstudy == 1) {
    $class = "SECOND YEAR";
} elseif ($yearofstudy == 2) {
    $class = "THIRD YEAR";
} elseif ($yearofstudy == 3) {
    $class = "FOURTH YEAR";
} elseif ($yearofstudy == 4) {
    $class = "FIFTH YEAR";
} elseif ($yearofstudy == 5) {
    $class = "SIXTH YEAR";
} elseif ($yearofstudy == 6) {
    $class = "SEVENTH YEAR";
} else {
    $class = "";
}
#cohort number
$yearofstudy = $yearofstudy + 1;
$sqlstd = "SELECT student.Id,
			   student.Name,
			   student.RegNo,
			   student.Sex,
			   student.Faculty,
			   student.EntryYear,
			   student.Sponsor,
			   student.Status,
			   student.ProgrammeofStudy
			FROM student
			WHERE 
				 (
					(student.EntryYear='$cohot') AND 
					(student.ProgrammeofStudy = '$deg') AND
					(student.ProgrammeofStudy <> '10103')
				 )
					ORDER BY  student.Name";

$querystd = mysqli_query($zalongwa, $sqlstd);


?>
<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="10" colspan="1" nowrap scope="col">
            <div align="left"></div>
            S/No
        </td>
        <td width="60" colspan="1" nowrap scope="col">
            <div align="left"></div>
            Name
        </td>
        <td width="40" colspan="1" nowrap scope="col">
            <div align="left"></div>
            RegNo
        </td>
        <td width="20" colspan="1" nowrap scope="col">
            <div align="left"></div>
            Sex
        </td>
    </tr>
    <?php
    $n = 1;
    while ($result = mysqli_fetch_array($querystd)) {

        $Name = stripslashes($result["Name"]);
        $RegNo = stripslashes($result["RegNo"]);
        $sex = stripslashes($result["Sex"]);
        $degree = stripslashes($result["ProgrammeofStudy"]);
        $faculty = stripslashes($result["Faculty"]);
        $sponsor = stripslashes($result["Sponsor"]);
        $entryyear = stripslashes($result['EntryYear']);
        $ststatus = stripslashes($result['Status']);

        #initialise billing values
        $grandtotal = 0;
        $feerate = 0;
        $invoice = 0;
        $paid = 0;
        $debtorlimit = 0;
        $tz103 = 0;
        $amount = 0;
        $subtotal = 0;
        $cfee = 0;


        $regno = $RegNo;
        include('../billing/includes/getgrandtotalpaid.php');

        if ($due <= $debtorlimit) {

            #check overall remarks
            # get all courses for this candidate
            $qcourse_total = "SELECT CourseCode FROM courseprogramme WHERE  (ProgrammeID='$deg') AND (YearofStudy='$yearofstudy') 
							ORDER BY CourseCode";
            $dbcourse_total = mysqli_query($zalongwa, $qcourse_total);
            #initialise all values
            $subjecttaken = 0;
            $totalfailed = 0;
            $totalinccount = 0;
            $halfsubjects = 0;
            $overalldiscocount = 0;
            $overallpasscount = 0;
            $overallinccount = 0;
            $overallsuppcount = 0;
            $ovremark = '';
            $gmarks = 0;
            $avg = 0;
            $gmarks = 0;

            while ($row_course_total = mysqli_fetch_array($dbcourse_total)) {
                $RegNo = $regno;
                $currentyear = $cyear;
                $course = $row_course_total['CourseCode'];

                include 'compute_student_remark.php';

            }
            #computer overall remarks
            $degree = $deg;
            include 'compute_overall_remark.php';

            if ($checkrem == 'on') {
                if ($ovr == 'ALL') {
                    if (($ovremark == 'PASS') || ($ovremark == 'SUPP:') || ($ovremark == 'INCO')) {
                        $stname = explode(',', $Name);
                        ?>
                        <tr>
                            <td width="10" colspan="1" nowrap scope="col"><?php echo $n;
                                $n = $n + 1; ?></td>
                            <td width="60" colspan="1" nowrap
                                scope="col"><?php echo strtoupper(stripslashes($stname[0])) . ', ' . ucwords(strtolower(stripslashes($stname[1]))); ?></td>
                            <td width="40" colspan="1" nowrap scope="col"><?php echo $RegNo ?></td>
                            <td width="20" colspan="1" nowrap scope="col"><?php echo $sex ?></td>
                        </tr>

                        <?php

                    }
                }
            }
        }
    }
    ?>
</table>