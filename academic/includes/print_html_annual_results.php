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
@$checkwh = addslashes($_POST['checkwh']);
$sem1sup = addslashes($_POST['checksupp']);
$checkregno = addslashes($_POST['checkregno']);
$checksem2 = addslashes($_POST['checksem2']);

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

if (($checkdegree == 'on') && ($checkyear == 'on') && ($checkcohot == 'on')){
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
$semval = 2;
echo $progname;
echo " - " . $year;
echo " - Semester I & II Results";

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
$totalcolms = 0;
#determine total number of columns
$qcolmns = "SELECT DISTINCT CourseCode, Status FROM courseprogramme 
								WHERE  (ProgrammeID='$deg') AND (YearofStudy='$yearofstudy') AND 
									(Semester='$semval') ORDER BY CourseCode";
$dbcolmns = mysqli_query($zalongwa, $qcolmns);
$dbcolmnscredits = mysqli_query($zalongwa, $qcolmns);
$dbexamcat = mysqli_query($zalongwa, $qcolmns);
$totalcolms = mysqli_num_rows($dbcolmns);
$degree = $deg;
?>
<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="20" colspan="3" rowspan="2" nowrap scope="col">
            <div align="left"></div>
            CourseCode
        </td>
        <?php
        # print course header
        while ($rowcourseheader = mysqli_fetch_array($dbcolmns)) {
            if ($checksem2 == 0) {
                ?>
                <td width="70" colspan="4" nowrap scope="col"><?php echo $rowcourseheader['CourseCode'] ?> </td>
                <?php
            }
        }
        ?>
        <td width="52" rowspan="2" colspan="4" nowrap>
            <div align="center">Semester II Remarks</div>
        </td>
        <td width="52" rowspan="2" colspan="4" nowrap>
            <div align="center">Semester I Remarks</div>
        </td>
        <td width="52" rowspan="2" colspan="4" nowrap>
            <div align="center">Overall Remarks</div>
        </td>
    </tr>
    <tr>
        <?php
        # print course header
        while ($rowcourseheader = mysqli_fetch_array($dbcolmnscredits)) {
            if ($checksem2 == 0) {
                ?>
                <td width="70" colspan="4" nowrap scope="col"><?php
                $course = $rowcourseheader['CourseCode'];
                #get course unit
                $qunits = "SELECT Units FROM course WHERE CourseCode='$course'";
                $dbunits = mysqli_query($zalongwa, $qunits);
                $row_units = mysqli_fetch_array($dbunits);
                $unit = $row_units['Units'];
                echo $unit;
            }
            ?> </td>
        <?php } ?>
    </tr>
    <tr>
        <td width="10" colspan="1" nowrap scope="col">
            <div align="left"></div>
            S/No
        </td>
        <td width="40" colspan="1" nowrap scope="col">
            <div align="left"></div>
            RegNo
        </td>
        <td width="20" colspan="1" nowrap scope="col">
            <div align="left"></div>
            Sex
        </td>
        <?php
        # print course header
        while ($rowexamcat = mysqli_fetch_array($dbexamcat)) {
            if ($checksem2 == 0) {
                ?>
                <td width="20" colspan="1" nowrap scope="col">X/40</td>
                <td width="20" colspan="1" nowrap scope="col">X/60</td>
                <td width="20" colspan="1" nowrap scope="col">X/100</td>
                <td width="20" colspan="1" nowrap scope="col">GRD</td>
                <?php
            }
        }
        ?>

        <td width="13" colspan="1" nowrap>
            <div align="center">CREDITS</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">POINTS</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">GPA</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">Remarks</div>
        </td>

        <td width="13" colspan="1" nowrap>
            <div align="center">CREDITS</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">POINTS</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">GPA</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">Remarks</div>
        </td>

        <td width="13" colspan="1" nowrap>
            <div align="center">CREDITS</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">POINTS</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">GPA</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">CLASSIFICATION</div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">Remarks</div>
        </td>
    </tr>
    <?php
    # print candidate results
    $overallpasscount = 0;
    $overallsuppcount = 0;
    $overallinccount = 0;
    $overalldiscocount = 0;
    $qstudent = "SELECT Name, RegNo, Sex, DBirth, ProgrammeofStudy, Faculty, Sponsor, EntryYear, Status FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY RegNo";
    $dbstudent = mysqli_query($zalongwa, $qstudent);
    $totalstudent = mysqli_num_rows($dbstudent);
    $z = 1;
    #mark this report as html report
    $reportgroup = 'annualhtml';

    while ($rowstudent = mysqli_fetch_array($dbstudent)) {
        $name = stripslashes($rowstudent['Name']);
        $regno = $rowstudent['RegNo'];
        $sex = $rowstudent['Sex'];
        $bdate = $rowstudent['DBirth'];
        if ($checkhide == 'on') {
            $degree = stripslashes($rowstudent["ProgrammeofStudy"]);
            $faculty = stripslashes($rowstudent["Faculty"]);
            $sponsor = stripslashes($rowstudent["Sponsor"]);
            $entryyear = stripslashes($result['EntryYear']);
            $ststatus = stripslashes($rowstudent['Status']);
        }
        # reset values
        $sem1ovremark = '';
        $ptc = '';
        $gpa = '';
        $sem2ovremark = '';
        $annualovremark = '';
        $gsuppcount = '';

        #check billing rates
        if ($checkwh == 'on') {
            # check if paid
            //$regno=$RegNo;
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
            include('../billing/includes/getgrandtotalpaid.php');
        }
        # get all courses of semester II for this candidate
        # loop the results of two semester starting with semester I
        for ($semval = 1; $semval <= 2; $semval += 1) {
            $qcourse = "SELECT DISTINCT CourseCode, Status FROM courseprogramme 
							WHERE  (ProgrammeID='$deg') AND (YearofStudy='$yearofstudy') AND 
								(Semester='$semval') ORDER BY CourseCode";
            $dbcourse = mysqli_query($zalongwa, $qcourse);
            $dbcourseUnit = mysqli_query($zalongwa, $qcourse);
            $dbcourseovremark = mysqli_query($zalongwa, $qcourse);
            $dbcourseheader = mysqli_query($zalongwa, $qcourse);
            $total_rows = mysqli_num_rows($dbcourse);

            #initialise
            $totalunit = 0;
            $gmarks = 0;
            $totalfailed = 0;
            $totalinccount = 0;
            $unittaken = 0;
            $sgp = 0;
            $totalsgp = 0;
            $gpa = 0;

            # new values
            $subjecttaken = 0;
            $unittaken = 0;
            $totalfailed = 0;
            $totalinccount = 0;
            $halfsubjects = 0;
            $ptc = 0;
            $ovremark = '';
            $avg = 0;
            $key = $regno;
            #get all courses
            $qcourselist = "SELECT DISTINCT CourseCode, Status FROM courseprogramme 
								WHERE  (ProgrammeID='$deg') AND (YearofStudy='$yearofstudy') AND 
									(Semester='$semval') ORDER BY CourseCode";
            $dbcourselist = mysqli_query($zalongwa, $qcourselist);

            # manage overal remark for semester I
            if ($semval == 1) {
                #initialise values for semester I
                $sem1subj = 0;
                $sem1marks = 0;
                $sem1avg = 0;
                $sem1ovremark = '';
                $sem1suppcount = 0;
                $sem1unittaken = 0;
                $sem1totalcredits = 0;
                $sem1totalcredits = 0;
                $sem1totalsgp = 0;
                $sem1gpa = '';

                while ($row_courselist = mysqli_fetch_array($dbcourselist)) {
                    $course = $row_courselist['CourseCode'];
                    $coption = $row_courselist['Status'];
                    #get course unit
                    $qunits = "SELECT Units FROM course WHERE CourseCode='$course'";
                    $dbunits = mysqli_query($zalongwa, $qunits);
                    $row_units = mysqli_fetch_array($dbunits);
                    $unit = $row_units['Units'];
                    $remarks = 'remarks';
                    $RegNo = $key;
                    $currentyear = $year;
                    include 'compute_student_remark.php';
                }

                $sem1unittaken = $unittaken;
                $sem1totalsgp = $totalsgp;

                $curr_semester = $semval;
                include 'compute_overall_remark.php';
                $sem1ptc = $ptc;
                $sem1gpa = $gpa;
                $sem1subj = $subjecttaken;
                $sem1marks = $gmarks;
                $sem1avg = $avg;

                include 'sem1and2ovremark.php';

                #check failed exam
                if ($fexm == '#') {
                    $fexm = '';
                    $remark = '';
                }
                #check failed exam
                if (($totalremarks > 0) && ($studentremarks <> '')) {
                    include 'sem1and2ovremark.php';
                    $remark = '';
                    $fexm = '';
                    $fcwk = '';
                    $fsup = '';
                    $igrade = '';
                    $egrade = '';
                } else {
                    #check for supp and inco
                    $k = 0;
                    if (($ovremark == 'SUPP:') || ($ovremark == 'SUPP')) {
                        include 'sem1and2ovremark.php';
                        #print supplementaries
                        $k = 25;
                        #determine total number of columns
                        $qsupp = "SELECT DISTINCT CourseCode, Status FROM courseprogramme WHERE  (ProgrammeID='$deg') 
														AND (YearofStudy='$yearofstudy') 
															AND (Semester = '$semval') ORDER BY CourseCode";
                        $dbsupp = mysqli_query($zalongwa, $qsupp);
                        $sem2suppcount = '';
                        $sem1suppcount = '';
                        while ($row_supp = mysqli_fetch_array($dbsupp)) {
                            $course = $row_supp['CourseCode'];
                            $coption = $row_supp['Status'];
                            #get course unit
                            $qunits = "SELECT Units FROM course WHERE CourseCode='$course'";
                            $dbunits = mysqli_query($zalongwa, $qunits);
                            $row_units = mysqli_fetch_array($dbunits);
                            $unit = $row_units['Units'];
                            #print courses as headers
                            $unitheader = $unit;
                            $grade = '';
                            $supp = '';
                            $RegNo = $regno;
                            #include grading scale
                            include 'choose_studylevel.php';
                            if ($supp == '!') {
                                if ($semval == 2) {
                                    $sem2suppcount = $sem2suppcount . 1;

                                } else {
                                    $sem1suppcount = $sem1suppcount . 1;
                                }
                                $k = $k + 29;
                            }

                            #empty option value
                            $coption = '';
                        }

                    } else {
                        include 'sem1and2ovremark.php';
                    }

                    if ($igrade <> 'I') {
                    }
                    if ($fsup == '!') {
                        $fsup = '';
                        //$overallsuppcount = $overallsuppcount+1;

                    } elseif (($igrade <> 'I') || ($fsup <> '!')) {
                        //$overallpasscount= $overallpasscount+1;
                    }

                    if ($totalinccount > 0) {
                        $igrade = '';
                        //$overallinccount = $overallinccount+1;
                    }
                }
                if ($due <= $debtorlimit) {
                    #check it
                } else {
                    $sem1ovremark = 'WITHHELD';
                }
            }

            # manage overal remark for semester II
            if ($semval == 2) {
                $sem2subj = 0;
                $sem2marks = 0;
                $sem2avg = 0;
                $sem2gpa = '';
                $sem2ovremark = '';
                $sem2suppcount = 0;
                $sem2totalcredits = 0;
                $sem2totalsgp = 0;
                $gpa = '';
                $ptc = '';
                $totalsgp = 0;
                $unittaken = 0;
                $totalfailed = 0;
                ?>
                <tr>
                <td width="20" colspan="1" nowrap>
                    <div align="left"></div><?php echo $z; ?></td>
                <td width="20" colspan="1" nowrap>
                    <div align="left"></div>
                    <?php
                    if ($checkregno == 0) {
                        echo $regno;
                    }
                    ?>
                </td>
                <td width="20" colspan="1" nowrap>
                    <div align="left"></div><?php echo $sex; ?></td>
                <?php
                $z = $z + 1;

                while ($row_courselist = mysqli_fetch_array($dbcourselist)) {
                    $course = $row_courselist['CourseCode'];
                    $coption = $row_courselist['Status'];
                    #get course unit
                    $qunits = "SELECT Units FROM course WHERE CourseCode='$course'";
                    $dbunits = mysqli_query($zalongwa, $qunits);
                    $row_units = mysqli_fetch_array($dbunits);
                    $unit = $row_units['Units'];
                    $remarks = 'remarks';
                    $RegNo = $key;
                    $currentyear = $year;
                    include 'compute_student_remark.php';
                    $sem2unittaken = $unittaken;
                    $sem2totalsgp = $totalsgp;
                    if ($checksem2 == 0) {
                        ?>
                        <td width="20" colspan="1" nowrap scope="col"><?php if ($sem1ovremark != 'ABSC') {
                                if ($checkwh == 'on') {
                                    if ($due <= $debtorlimit) {
                                        echo $test2score;
                                    }
                                } else {
                                    echo $test2score;
                                }
                            } ?></td>
                        <td width="20" colspan="1" nowrap scope="col"><?php if ($sem1ovremark != 'ABSC') {
                                if ($checkwh == 'on') {
                                    if ($due <= $debtorlimit) {
                                        echo $aescore;
                                    }
                                } else {
                                    echo $aescore;
                                }
                            } ?></td>
                        <td width="20" colspan="1" nowrap scope="col"><?php if ($sem1ovremark != 'ABSC') {
                                if ($checkwh == 'on') {
                                    if ($due <= $debtorlimit) {
                                        echo $marks;
                                    }
                                } else {
                                    echo $marks;
                                }
                            } ?></td>
                        <td width="20" colspan="1" nowrap scope="col"><?php if ($sem1ovremark != 'ABSC') {
                                if ($checkwh == 'on') {
                                    if ($due <= $debtorlimit) {
                                        echo $grade;
                                    }
                                } else {
                                    echo $grade;
                                }
                            } ?></td>
                        <?php
                    }
                }
                $curr_semester = $semval;
                include 'compute_overall_remark.php';
                $sem2ptc = $ptc;
                $sem2gpa = $gpa;
                $sem2subj = $subjecttaken;
                $sem2unittaken = $unittaken;
                $sem2totalsgp = $totalsgp;
                $sem2marks = $gmarks;
                $sem2avg = $avg;
                ?>
                <td width="13" colspan="1" nowrap>
                    <div align="center"><?php if ($sem1ovremark != 'ABSC') {
                            if ($due <= $debtorlimit) {
                                echo $sem2unittaken;
                            }
                        } ?></div>
                </td>
                <td width="13" colspan="1" nowrap>
                    <div align="center"><?php if ($sem1ovremark != 'ABSC') {
                            if ($due <= $debtorlimit) {
                                echo $sem2totalsgp;
                            }
                        } ?></div>
                </td>
                <td width="13" colspan="1" nowrap>
                    <div align="center"><?php if ($sem1ovremark != 'ABSC') {
                            if ($due <= $debtorlimit) {
                                echo $sem2gpa;
                            }
                        } ?></div>
                </td>
                <td width="13" colspan="1" nowrap>
                    <div align="center">
                        <?php
                        if ($due <= $debtorlimit) {
                            #check it
                        } else {
                            $ovremark = 'WITHHELD';
                        }

                        #check failed exam
                        if ($fexm == '#') {
                            $fexm = '';
                            $remark = '';
                        }
                        #check failed exam
                        #check failed exam
                        if (($totalremarks > 0) && ($studentremarks <> '')) {

                            include 'sem1and2ovremark.php';
                            echo $sem2ovremark;
                            $remark = '';
                            $fexm = '';
                            $fcwk = '';
                            $fsup = '';
                            $igrade = '';
                            $egrade = '';
                        } else {
                            #check for supp and inco
                            $k = 0;
                            if ($ovremark == 'SUPP:') {
                                include 'sem1and2ovremark.php';
                                echo $sem2ovremark;
                                #print supplementaries
                                $k = 25;
                                #determine total number of columns
                                $qsupp = "SELECT DISTINCT CourseCode, Status FROM courseprogramme WHERE  (ProgrammeID='$deg') 
														AND (YearofStudy='$yearofstudy') 
															AND (Semester = '$semval') ORDER BY CourseCode";
                                $dbsupp = mysqli_query($zalongwa, $qsupp);
                                while ($row_supp = mysqli_fetch_array($dbsupp)) {
                                    $course = $row_supp['CourseCode'];
                                    $coption = $row_supp['Status'];
                                    #get course unit
                                    $qunits = "SELECT Units FROM course WHERE CourseCode='$courseheader'";
                                    $dbunits = mysqli_query($zalongwa, $qunits);
                                    $row_units = mysqli_fetch_array($dbunits);
                                    $unit = $row_units['Units'];
                                    #print courses as headers

                                    $unitheader = $unit;

                                    $grade = '';
                                    $supp = '';
                                    $RegNo = $regno;
                                    #include grading scale
                                    include 'choose_studylevel.php';
                                    if (($supp == '!') && ($marks > 0)) {
                                        echo ',' . $course;
                                        $k = $k + 35;
                                    }
                                    #empty option value
                                    $coption = '';
                                }

                            } else {
                                include 'sem1and2ovremark.php';
                                echo $sem2ovremark;
                            }

                            if ($igrade <> 'I') {
                            }
                            if ($fsup == '!') {
                                $fsup = '';
                                //$overallsuppcount = $overallsuppcount+1;

                            } elseif (($igrade <> 'I') || ($fsup <> '!')) {
                                //$overallpasscount= $overallpasscount+1;
                            }

                            if ($totalinccount > 0) {
                                $igrade = '';
                                //$overallinccount = $overallinccount+1;
                            }
                        }
                        ?>
                    </div>
                </td>

                <td width="13" colspan="1" nowrap>
                    <div align="center">

                        <?php
                        if ($due <= $debtorlimit) {
                            echo $sem1unittaken;
                        }

                        ?></div>
                </td>
                <td width="13" colspan="1" nowrap>
                    <div align="center">

                        <?php
                        if ($due <= $debtorlimit) {
                            echo $sem1totalsgp;
                        }
                        ?></div>
                </td>
                <td width="13" colspan="1" nowrap>
                    <div align="center">

                        <?php
                        if ($due <= $debtorlimit) {
                            echo $sem1gpa;
                        }
                        ?></div>
                </td>
                <td width="13" colspan="1" nowrap><div align="center">
                <?php
                if ($due <= $debtorlimit) {
                    echo $sem1ovremark;
                    if ($sem1ovremark == 'SUPP:') {
                        if ($sem1suppcount > 0) {
                            if ($sem1sup <> 1) {
                                echo '(' . $sem1suppcount . ')';
                            } else {
                                $k = 0;
                                #print supplementaries for semester I
                                $k = 25;
                                #determine total number of columns
                                $qsupp = "SELECT DISTINCT CourseCode, Status FROM courseprogramme WHERE  (ProgrammeID='$deg') 
														AND (YearofStudy='$yearofstudy') 
															AND (Semester = '1') ORDER BY CourseCode";
                                $dbsupp = mysqli_query($zalongwa, $qsupp);
                                $sem2suppcount = '';
                                $sem1suppcount = '';
                                while ($row_supp = mysqli_fetch_array($dbsupp)) {
                                    $course = $row_supp['CourseCode'];
                                    $coption = $row_supp['Status'];
                                    $grade = '';
                                    $supp = '';
                                    $RegNo = $regno;
                                    #include grading scale
                                    include 'choose_studylevel.php';
                                    if (($supp == '!') && ($marks > 0)) {
                                        echo ',' . $course;
                                        $k = $k + 35;
                                    }

                                    #empty option value
                                    $coption = '';
                                }
                            }
                        }
                    }
                }
            }
            ?>
            </div></td>

            <?php
            # manage annual overal remarks
            //  	include 'includes/sem1and2ovremark.php';
        }

        ?>
        <td width="13" colspan="1" nowrap>
            <div align="center">

                <?php
                if ($due <= $debtorlimit) {
                    $ttunits = ($sem2unittaken + $sem1unittaken);
                    echo $ttunits;
                }
                ?></div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">

                <?php
                if ($due <= $debtorlimit) {
                    $ttsgp = ($sem2totalsgp + $sem1totalsgp);
                    echo $ttsgp;
                }
                ?></div>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">

                <?php
                if ($due <= $debtorlimit) {
                    if ($ttunits > 0) {
                        $ovgpa = substr($ttsgp / $ttunits, 0, 3);
                        echo $ovgpa;
                    }
                }

                ?></div>
        </td>
        <td colspan='1' align='center' nowrap>
            <?php
            //get annual remark
            $annualptc = ($sem1ptc + $sem2ptc) / 2;
            include 'sem1and2ovremark.php';

            //get gpa classification
            include 'classification.php';
            echo $classification;
            ?>
        </td>
        <td width="13" colspan="1" nowrap>
            <div align="center">
                <?php
                echo $annualovremark;
                /*
        //$ovgpa=$sem1gpa+$sem2gpa;
        if (($ovgpa>=2)&&($ptc>=60))
        {
            $annualovremark='PASS'	;
        }elseif(($ovgpa>=2)&&($ptc>=60)&&($totalfailed>0)){
            $annualovremark='PROBATE'	;
        }
            //include '../academic/includes/sem1and2ovremark.php';

            */
                ?>
            </div>
        </td>
        </tr>
        <?php
    }
    }
    ?>
</table>
