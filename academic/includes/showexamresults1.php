<?php
//select student
$qstudent = "SELECT * from student WHERE RegNo = '$key'";
$dbstudent = mysqli_query($zalongwa, $qstudent) or die("Mwanafunzi huyu hana matokeo");
$row_result = mysqli_fetch_array($dbstudent);
$name = $row_result['Name'];
$regno = $row_result['RegNo'];
$degree = $row_result['ProgrammeofStudy'];
$RegNo = $regno;

//get degree name
$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
$dbdegree = mysqli_query($zalongwa, $qdegree);
$row_degree = mysqli_fetch_array($dbdegree);
$programme = $row_degree['Title'];

echo "$name - $regno <br> $programme";


//query academeic year
$qayear = "SELECT DISTINCT AYear FROM examresult WHERE RegNo = '$RegNo' ORDER BY AYear ASC";
$dbayear = mysqli_query($zalongwa, $qayear);

//query exam results sorted per years
while ($rowayear = mysqli_fetch_object($dbayear)) {
    $currentyear = $rowayear->AYear;

//query semester
    $qsemester = "SELECT DISTINCT Semester FROM examresult WHERE RegNo = '$RegNo' AND AYear = '$currentyear' ORDER BY Semester ASC";
    $dbsemester = mysqli_query($zalongwa, $qsemester);

//query exam results sorted per semester
    while ($rowsemester = mysqli_fetch_object($dbsemester)) {
        $currentsemester = $rowsemester->Semester;
        # get all courses for this candidate
        $qcourse = "SELECT DISTINCT course.CourseName, 
									  course.Units, 
									  course.StudyLevel, 
									  course.Department, 
									  examresult.CourseCode, 
									  examresult.Semester, 
									  examresult.Status 
					  FROM 
							course INNER JOIN examresult ON (course.CourseCode = examresult.CourseCode)
					  WHERE (examresult.RegNo='$regno') AND 
							(examresult.AYear = '$currentyear') AND
							(examresult.Semester = '$currentsemester') AND  
							(examresult.Checked='1') 
				      ORDER BY examresult.AYear DESC, examresult.Semester ASC";
        $dbcourse = mysqli_query($zalongwa, $qcourse) or die("No Exam Results for the Candidate - $key ");
        $total_rows = mysqli_num_rows($dbcourse);

        if ($total_rows > 0) {
            #initialise s/no
            $sn = 0;
            #print name and degree
            //select student
            $qstudent = "SELECT Name, RegNo, ProgrammeofStudy from student WHERE RegNo = '$RegNo'";
            $dbstudent = mysqli_query($zalongwa, $qstudent) or die("Mwanafunzi huyu hana matokeo" . mysqli_error($zalongwa));
            $row_result = mysqli_fetch_array($dbstudent);
            $name = $row_result['Name'];
            $regno = $row_result['RegNo'];
            $degree = $row_result['ProgrammeofStudy'];

            //get degree name
            $qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
            $dbdegree = mysqli_query($zalongwa, $qdegree);
            $row_degree = mysqli_fetch_array($dbdegree);
            $programme = $row_degree['Title'];

            #initialise
            $totalunit = 0;
            $unittaken = 0;
            $sgp = 0;
            $totalsgp = 0;
            $gpa = 0;
            ?>
            <table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="63" scope="col"><?php echo $rowayear->AYear; ?></td>
                    <td width="30" nowrap scope="col">Code</td>
                    <td width="350" nowrap scope="col">Name</td>
                    <td width="30" nowrap scope="col">Credits</td>
                    <td width="38" nowrap scope="col">Grade</td>
                    <td width="31" nowrap scope="col">Points</td>
                    <td width="31" nowrap scope="col">GPA</td>
                </tr>
                <?php
                while ($row_course = mysqli_fetch_array($dbcourse)) {
                    $course = $row_course['CourseCode'];
                    $unit = $row_course['Units'];
                    $semester = $row_course['Semester'];
                    $coursename = $row_course['CourseName'];
                    $coursefaculty = $row_course['Department'];
                    if ($row_course['Status'] == 1) {
                        $status = 'Core';
                    } else {
                        $status = 'Elective';
                    }
                    $sn = $sn + 1;
                    $remarks = 'remarks';

                    include 'choose_studylevel.php';

                    #display results

                    ?>
                    <tr>
                        <td nowrap scope="col">
                            <div align="left"><?php echo $semester ?></div>
                        </td>
                        <td nowrap scope="col">
                            <div align="left"><?php echo $course ?></div>
                        </td>
                        <td width="350" nowrap scope="col">
                            <div align="left"><?php echo $coursename; ?></div>
                        </td>
                        <td width="30" nowrap scope="col">
                            <div align="center"><?php echo $row_course['Units'] ?></div>
                        </td>
                        <td width="38" nowrap scope="col">
                            <div align="center"><?php echo $grade; ?></div>
                        </td>
                        <td width="31" nowrap scope="col">
                            <div align="center"><?php echo $sgp; ?></div>
                        </td>
                        <td width="31" nowrap scope="col"></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td scope="col"></td>
                    <td scope="col"></td>
                    <td width="350" nowrap scope="col"></td>
                    <td width="30" nowrap scope="col">
                        <div align="center"><?php echo $unittaken; ?></div>
                    </td>
                    <td width="38" nowrap scope="col"></td>
                    <td width="31" nowrap scope="col">
                        <div align="center"><?php echo $totalsgp; ?></div>
                    </td>
                    <td width="31" nowrap scope="col">
                        <div align="center"><?php echo @substr($totalsgp / $unittaken, 0, 3); ?></div>
                    </td>
                </tr>
            </table>
        <?php } else {
            if (!@$reg[$c]) {
            } else {
                echo "$c" . ".Sorry, No Records Found for '$reg[$c]'<br><hr>";
            }
        }
    } //ends while rowsemester
} //ends while rowayear	
mysqli_close($zalongwa);