<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.6, 2011-02-27
 */

/** Error reporting */

error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once '../../Classes/PHPExcel.php';

$papersize = 'PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4';
$fontstyle = 'Arial';
$font = 10.5;

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Zalongwa")
    ->setLastModifiedBy("Charles Bundu")
    ->setTitle($programme)
    ->setSubject("Semester Exam Results")
    ->setDescription("Semester Exam Results.")
    ->setKeywords("zalongwa saris software")
    ->setCategory("Exam result file");

$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

# Set protected sheets to 'true' kama hutaki waandike waziedit sheets zako. Kama unataka wazi-edit weka 'false'
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(false);

#set worksheet orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize($papersize);

#Set page fit width to true
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

#Set footer page numbers
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

#Show or hide grid lines
$objPHPExcel->getActiveSheet()->setShowGridlines(false);

#Set sheet style (fonts and font size)
$objPHPExcel->getDefaultStyle()->getFont()->setName($fontstyle);
$objPHPExcel->getDefaultStyle()->getFont()->setSize($font);

#Set page margins
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);

# Set Rows to repeate in each page
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);

# Set Report Logo
/*
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../images/logo.jpg');
$objDrawing->setHeight(100);

$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../images/logo.jpg');
$objDrawing->setCoordinates('B1');
$objDrawing->setOffsetX(110);
$objDrawing->setRotation(25);
$objDrawing->getShadow()->setVisible(true);
$objDrawing->getShadow()->setDirection(45);
*/

$styleArray = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);


for ($col = A; $col < ZZ; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}


# Print Report header
$rpttitle = 'SEMESTER EXAMINATIONS RESULTS';
$objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
$objPHPExcel->getActiveSheet()->mergeCells('E1:AA1');
$objPHPExcel->getActiveSheet()->mergeCells('C2:AN2');
$objPHPExcel->getActiveSheet()->mergeCells('C3:AN3');
$objPHPExcel->getActiveSheet()->mergeCells('C4:AN4');

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C1', 'NACTE EXAM FORM 03')
    ->setCellValue('E1', strtoupper($org))
    ->setCellValue('C2', $faculty)
    ->setCellValue('C3', 'PROVISIONAL OF OVERALL SUMMARY RESULTS')
    ->setCellValue('C4', 'YEAR OF STUDY: ' . $year . ' - ' . $sem . '   [' . $class . '] ' . $progname . '  CA Weight 40%, FE Weight 60%');

$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(13);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle('C3:C4')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(26);
$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(26);
$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(26);
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(26);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$colm = "C";
$rows = 5;

$objPHPExcel->getActiveSheet()->getStyle('C5:BE6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

#header arrays
$preheader = array('MODULE CODE:', 'MODULE CREDITS:', 'EXAM COMPONENTS:');
$sufheader = array('SNo', 'REGISTRATION #', 'NAME', 'SEX', 'EXAMINATION RESULTS', 'CRDT', 'PTS', 'GPA', 'REMARK');
$examdetail = array('CA', 'SE', 'TOT', 'GRD');


#Print headers

#PRINTING COURSE HEADER
$KEY = 1;
foreach ($preheader as $header1) {
    $colm = "C";

    $y = $colm;
    for ($x = 1; $x < 4; $x++) {
        $y++;
    }
    $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->getStartColor()->setARGB('000FFFFF');
    $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $y . $rows)->getStyle($colm . $rows . ':' . $y . $rows)->applyFromArray($styleArray);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $header1);
    $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $colm = $y;
    $colm++;

    //PRINT COURSE DETAILS
    foreach ($coursearray as $studycourse) {

        if ($KEY == 1) {
            //PRINT COURSE CODE
            $y = $colm;
            for ($x = 1; $x < 4; $x++) {
                $y++;
            }

            $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->getStartColor()->setARGB('000FFFFF');
            $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $y . $rows)->getStyle($colm . $rows . ':' . $y . $rows)->applyFromArray($styleArray);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $studycourse);
            $colm = $y;
            $colm++;
        } elseif ($KEY == 2) {
            //GET COURSE UNITS
            $XUnit = mysqli_query($zalongwa, "SELECT Units FROM course WHERE CourseCode='$studycourse'");
            list($UNIT) = mysqli_fetch_array($XUnit);

            $y = $colm;
            for ($x = 1; $x < 4; $x++) {
                $y++;
            }

            //PRINT COURSE UNITS
            $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->getStartColor()->setARGB('000FFFFF');
            $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $y . $rows)->getStyle($colm . $rows . ':' . $y . $rows)->applyFromArray($styleArray);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $UNIT);
            $colm = $y;
            $colm++;
        } else {
            //PRINT EXAM SCORE CATEGORIES
            foreach ($examdetail as $details) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($colm)->setWidth(4);
                $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getFill()->getStartColor()->setARGB('000FFFFF');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $details);
                $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $colm . $rows)->getStyle($colm . $rows . ':' . $colm . $rows)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $colm++;
            }
        }
    }

    //PRINT PERFORMANCE COLUMN
    if ($KEY == 1) {
        $R = $rows;
        $V = $colm;

        for ($x = 1; $x < 3; $x++) {
            $R++;
        }

        for ($x = 1; $x < 4; $x++) {
            $V++;
        }

        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $V . $R)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $V . $R)->getFill()->getStartColor()->setARGB('000FFFFF');
        $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $V . $R)->getStyle($colm . $rows . ':' . $V . $R)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, 'OVERALL PERFORMANCE');
        $colm = $V;
        $colm++;
    }

    $KEY++;
    $rows++;
}


#PRINTING RESULTS HEADER
$colm = 'C';
$KEY = 1;
foreach ($sufheader as $header2) {
    if ($KEY == 5) {
        $y = $colm;
        for ($x = 1; $x < (4 * count($coursearray)); $x++) {
            $y++;
        }

        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->getStartColor()->setARGB('000FFFFF');
        $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $y . $rows)->getStyle($colm . $rows . ':' . $y . $rows)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $header2);
        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $colm = $y;
        $colm++;
    } else {
        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getFill()->getStartColor()->setARGB('000FFFFF');
        $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $colm . $rows)->getStyle($colm . $rows . ':' . $colm . $rows)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $header2);
        $colm++;
    }

    $KEY++;
}
$colm++;
$rows++;

//GPA Classes
$meA = 0;
$feA = 0;
$meBp = 0;
$feBp = 0;
$meB = 0;
$feB = 0;
$meC = 0;
$feC;
$meF = 0;
$feF = 0;

//REMARKS Categories
$mepass = 0;
$fepass = 0;
$mesupp = 0;
$fesupp = 0;
$mefail = 0;
$fefail = 0;
$meinc = 0;
$feinc = 0;
$meother = 0;
$feother = 0;

//get student results
$qstudent = "SELECT * FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot')";
if ($_POST['orderby'] == 'regno') {
    $qstudent .= " ORDER BY RegNo";
} elseif ($_POST['orderby'] == 'gender') {
    $qstudent .= " ORDER BY Sex";
} elseif ($_POST['orderby'] == 'name') {
    $qstudent .= " ORDER BY Name";
}
$dbstudent = mysqli_query($zalongwa, $qstudent);
$totalstudent = mysqli_num_rows($dbstudent);
$i = 1;

$studenresults = '';

while ($rowstudent = mysqli_fetch_array($dbstudent)) {

    $name = $rowstudent['Name'];
    $regno = $rowstudent['RegNo'];
    $sex = $rowstudent['Sex'];
    $key = $regno;
    $RegNo = $regno;

    $bdate = $rowstudent['DBirth'];
    $degree = stripslashes($rowstudent["ProgrammeofStudy"]);
    $faculty = stripslashes($rowstudent["Faculty"]);
    $sponsor = stripslashes($rowstudent["Sponsor"]);
    $entryyear = stripslashes($rowstudent['EntryYear']);
    $ststatus = stripslashes($rowstudent['Status']);

    $entryyr = "OCTOBER, " . substr($rowstudent['EntryYear'], 0, 4);

    $chckremark = "select * from studentremark where RegNo='$regno' ";
    $resultremark = mysqli_query($zalongwa, $chckremark);
    $rowremark = mysqli_fetch_array($resultremark);
    $studremark = $rowremark['Remark'];
    $semremark = $rowremark['Semester'];
    $acyrremark = $rowremark['AYear'];
    $shiftyearclause = ($studremark == 'PSSG') ? " OR examresult.AYear='$acyrremark'" : "";

    $STD_DETAILS = array($i, $regno, $name, $sex);
    //initialize
    $totalunit = 0;
    $unittaken = 0;
    $sgp = 0;
    $totalsgp = 0;
    $gpa = 0;
    $key = $regno;
    $offset = 1;
    $suppcount = 0;
    $gunits = 0;
    $gpoints = 0;
    $sem1units = 0;
    $sem2units = 0;
    $sem1sgp = 0;
    $sem2sgp = 0;
    $coursesfailed = 0;
    $skipped = 0;
    $incOption = '';

    $courseperfom = array();
    $save = array();

    //DISPLAY STUDENT DETAILS
    $colm = 'C';
    foreach ($STD_DETAILS as $val) {
        $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $colm . $rows)->getStyle($colm . $rows . ':' . $colm . $rows)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $val);
        $colm++;
    }

    //get student marks and grades
    $qstdcourse = "SELECT DISTINCT coursecode FROM examresult WHERE RegNo='$regno' and AYear='$year' AND Semester='$sem'";
    $dbstdcourse = mysqli_query($zalongwa, $qstdcourse);
    $totalstdcourse = mysqli_num_rows($dbstdcourse);

    //foreach($coursearray as $studycourse){
    foreach ($coursearray as $studycourse) {
        $getrows = mysqli_query($zalongwa, "SELECT * FROM examresult WHERE CourseCode='$studycourse' AND RegNo='$regno' AND AYear='$year'");
        $uploaded = mysqli_num_rows($getrows);

        $dbcourseUnit = mysqli_query($zalongwa, "SELECT * FROM course WHERE CourseCode='$studycourse'");

        //get student performance
        while ($row_course = mysqli_fetch_array($dbcourseUnit)) {
            $course = $row_course['CourseCode'];
            $unit = $row_course['Units'];
            $name = $row_course['CourseName'];
            $coursefaculty = $row_course['Department'];
            $remarks = 'remarks';
            $grade = '';
            $supp = '';
            $RegNo = $regno;

            $stdcourse = $course;
            $coursefull = explode(" ", $stdcourse);
            $courseleft = $coursefull[0];
            $courseright = $coursefull[1];
            $exam_ayear = $year;
            include 'choose_studylevel.php';

            //get course status
            $academic = array('FIRST YEAR' => 1, 'SECOND YEAR' => 2, 'THIRD YEAR' => 3, 'FOURTH YEAR' => 4, 'FIFTH YEAR' => 5);
            $semval = ($sem == 'Semester I') ? 1 : 2;
            $yearofstudy = $academic[$class];

            $qcourse = "SELECT Status FROM courseprogramme WHERE (ProgrammeID='$deg') 
							AND (YearofStudy='$yearofstudy') AND (Semester = '$semval')
							AND (AYear='$year') AND (CourseCode='$stdcourse')";
            $dbstdcourse = mysqli_query($zalongwa,$qcourse);
            list($option) = mysqli_fetch_array($dbstdcourse);

            //control remark for unfinished core modules
            if ($option == '1') {
                if ($test2score == '' && $aescore == '') {
                    $grade = '';
                    $supp = '';
                    $marks = '';
                    $incOption = 'I';
                }
            } else {
                if ($test2score == '' && $aescore == '') {
                    $grade = '';
                    $supp = '';
                    $marks = '';
                }
            }

            if ($grade == 'D' || $grade == 'E' || $grade == 'E*' || $grade == 'I' || $grade == 'F') {
                $suppcount = $suppcount + 1;
                $coursesfailed = $coursesfailed + 1;
                $save[] = strtoupper($course);
            } else {
                $style = '';
                $style2 = '';
            }

            if (@$supp == '!') {
                $grade2 = $grade . '' . $supp;
            } else {
                $grade2 = $grade;
            }

            //student scores
            $aescore = (($row_sup_total > 0) && ($supscore <> '')) ? $supscore : $aescore;

            //PRINT COURSE PERFORMANCE
            $COURSE_DETAILS = array($test2score, $aescore, $marks, $grade2);
            $id = 1;
            foreach ($COURSE_DETAILS as $val) {

                //FAIL GRADE
                $fail_grade = array('D', 'E', 'E*', 'I', 'F');
                if ($id == 4 && in_array($grade, $fail_grade, true)) {
                    $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getFill()->getStartColor()->setARGB('CCCCCC');
                }

                $objPHPExcel->getActiveSheet()->getColumnDimension($colm)->setWidth(4);
                $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $colm . $rows)->getStyle($colm . $rows . ':' . $colm . $rows)->applyFromArray($styleArray);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $val);
                $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $colm++;
                $id++;
            }
            $supp = '';
        }
    }

    //calcultate G.P.As
    if ($totalstdcourse = 0) {
        //Semester G.P.As
        $gunits = 0;
        $gpoints = 0;
        $gpa = '-';
    } else {
        //Semester G.P.As
        $gunits = $unittaken + $gunits;
        $gpoints = $totalsgp + $gpoints;
        $gpa = @substr($totalsgp / $unittaken, 0, 3);
    }

    //ASSIGN G.P.A CLASS
    if ($gpa >= 4.4 && empty($save)) {
        $remark = 'PASS';
        $gpagrade = 'A';

        if ($sex == 'M') {
            $meA = $meA + 1;
        } else {
            $feA = $feA + 1;
        }
    } elseif ($gpa >= 4.4 && !empty($save)) {
        $remark = 'SUPP';
        $gpagrade = 'A';

        if ($sex == 'M') {
            $meA = $meA + 1;
        } else {
            $feA = $feA + 1;
        }
    } elseif ($gpa >= 3.5 && empty($save)) {
        $remark = 'PASS';
        $gpagrade = 'B+';

        if ($sex == 'M') {
            $meBp = $meBp + 1;
        } else {
            $feBp = $feBp + 1;
        }
    } elseif ($gpa >= 3.5 && !empty($save)) {
        $remark = 'SUPP';
        $gpagrade = 'B+';

        if ($sex == 'M') {
            $meBp = $meBp + 1;
        } else {
            $feBp = $feBp + 1;
        }
    } elseif ($gpa >= 2.7 && empty($save)) {
        $remark = 'PASS';
        $gpagrade = 'B';

        if ($sex == 'M') {
            $meB = $meB + 1;
        } else {
            $feB = $feB + 1;
        }
    } elseif ($gpa >= 2.7 && !empty($save)) {
        $remark = 'SUPP';
        $gpagrade = 'B';

        if ($sex == 'M') {
            $meB = $meB + 1;
        } else {
            $feB = $feB + 1;
        }
    } elseif ($gpa >= 2.0 && empty($save)) {
        $remark = 'PASS';
        $gpagrade = 'C';

        if ($sex == 'M') {
            $meC = $meC + 1;
        } else {
            $feC = $feC + 1;
        }
    } elseif ($gpa >= 2.0 && !empty($save)) {
        $remark = 'SUPP';
        $gpagrade = 'C';

        if ($sex == 'M') {
            $meC = $meC + 1;
        } else {
            $feC = $feC + 1;
        }
    } elseif ($gpa < 2.0) {
        $remark = 'DISCO';
        $gpagrade = 'D';

        if ($sex == 'M') {
            $meF = $meF + 1;
        } else {
            $feF = $feF + 1;
        }
    } else {
        $remark = 'DISCO';
        $gpagrade = 'E';

        if ($sex == 'M') {
            $meF = $meF + 1;
        } else {
            $feF = $feF + 1;
        }
    }

    //check if student has unfinished compulsary modules
    if ($incOption == 'I' && $gpa >= 2.0) {
        $remark = 'ABSC';
    }

    $gpa = ($unittaken < 1) ? '-' : $gpa;

    //track supplementary courses
    $save_str = '';
    $br = 0;
    foreach ($save as $val) {
        $br++;
        if ($br > 1) {
            $save_str .= $val . '<br/>';
            $br = 0;
        } else {
            $save_str .= $val . ', ';
        }
    }

    $save = '';
    $save_str = rtrim($save_str, '<br/>');
    $save_str = rtrim($save_str, ', ');
    $coursesfailed = 0;

    $qremarks = "SELECT Remark FROM studentremark WHERE RegNo='$regno' AND AYear='$year'";
    $dbremarks = mysqli_query($zalongwa, $qremarks);
    $row_remarks = mysqli_fetch_assoc($dbremarks);
    $totalremarks = mysqli_num_rows($dbremarks);
    $studentremarks = $row_remarks['Remark'];
    if (($totalremarks > 0) && ($studentremarks <> '')) {
        $remark = $studentremarks;
    }

    //gather performance statistics
    if ($remark <> 'PASS') {
        if ($remark == 'FAIL' || $remark == 'DISCO') {
            if ($sex == 'M') {
                $mefail = $mefail + 1;
            } else {
                $fefail = $fefail + 1;
            }
        } elseif ($remark == 'ABSC') {
            if ($sex == 'M') {
                $meinc = $meinc + 1;
            } else {
                $feinc = $feinc + 1;
            }
        } else {
            if ($remark == 'SUPP') {
                if ($sex == 'M') {
                    $mesupp = $mesupp + 1;
                } else {
                    $fesupp = $fesupp + 1;
                }
            } else {
                if ($sex == 'M') {
                    $meother = $meother + 1;
                } else {
                    $feother = $feother + 1;
                }

            }
        }
    } else {
        if ($sex == 'M') {
            $mepass = $mepass + 1;
        } else {
            $fepass = $fepass + 1;
        }
    }

    //PRINT STUDENT PERFORMANCE
    $PERFOM_ARRAY = array($unittaken, $totalsgp, $gpa, $remark);
    $id = 1;
    foreach ($PERFOM_ARRAY as $val) {

        if ($id == 4 && $val <> 'PASS') {
            $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getFill()->getStartColor()->setARGB('CCCCCC');
        }

        $objPHPExcel->getActiveSheet()->getColumnDimension($colm)->setWidth(4);
        $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $colm . $rows)->getStyle($colm . $rows . ':' . $colm . $rows)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $val);
        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $colm . $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $colm++;
        $id++;
    }
    $rows++;
    $i++;
}

/*
*************************************
* END OF PRINTING OF STUDENT RESULTS
*************************************
*/


/*
***************************************
* PRINTING OF MODULE/COURSE DEFINITION
***************************************
*/
$colm = "C";
$y = $colm;
$rows++;
$rows++;
$rows++;

$START_POINT = $rows;
$track = 1;
while ($track < 6) {
    $y++;
    $track++;
}

$objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $y . $rows)->getStyle($colm . $rows . ':' . $y . $rows)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle($colm . $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->getStartColor()->setARGB('000FFFFF');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, ' KEY FOR COURSE CODES ');
$objPHPExcel->getActiveSheet()->getStyle($colm . $rows)->applyFromArray($styleArray);
$rows++;

//definition headers
$HEADER = array('SNo.', 'COURSE CODE', 'COURSE TITLE');
$colm = "C";
foreach ($HEADER as $header) {
    $y = $colm;
    if (strstr($header, "TITLE")) {

        $track = 1;
        while ($track < 4) {
            $y++;
            $track++;
        }
    }
    $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $y . $rows)->getStyle($colm . $rows . ':' . $y . $rows)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle($colm . $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->getStartColor()->setARGB('000FFFFF');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $header);
    $objPHPExcel->getActiveSheet()->getStyle($colm . $rows)->applyFromArray($styleArray);
    $colm = $y;
    $colm++;
}
$rows++;

$i = 1;
foreach ($coursearray as $course) {
    $get_coursedet = mysqli_query($zalongwa, "SELECT CourseName FROM course WHERE CourseCode='$course'");
    list($name) = mysqli_fetch_array($get_coursedet);

    $arrays = array($i, $course, $name);

    $horizotal = 1;
    $colm = "C";
    foreach ($arrays as $header) {
        $y = $colm;
        if ($horizotal == 3) {

            $track = 1;
            while ($track < 4) {
                $y++;
                $track++;
            }
        }
        $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $y . $rows)->getStyle($colm . $rows . ':' . $y . $rows)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, ' ' . $header . ' ');
        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows)->applyFromArray($styleArray);
        $colm = $y;
        $colm++;
        $horizotal++;
    }
    $rows++;
    $i++;
}


/*
***************************************
* PRINTING OF PERFORMANCE STATISTICS
***************************************
*/
$colm++;
$colm++;
$y = $colm;

$rows = $START_POINT;
$START_POINT = $colm;
$track = 1;
while ($track < 18) {
    $y++;
    $track++;
}

$objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $y . $rows)->getStyle($colm . $rows . ':' . $y . $rows)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle($colm . $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle($colm . $rows . ':' . $y . $rows)->getFill()->getStartColor()->setARGB('000FFFFF');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, ' SUMMARY OF PERFORMANCE STATISTICS ');
$objPHPExcel->getActiveSheet()->getStyle($colm . $rows)->applyFromArray($styleArray);
$rows++;

//PERFORMANCE STATISTICS
$pass = $fepass + $mepass;
$supps = $fesupp + $mesupp;
$fail = $fefail + $mefail;
$inco = $feinc + $meinc;
$other = $feother + $meother;

$pass2 = number_format($pass * 100 / $totalstudent, 1) . '%';
$supps2 = number_format($supps * 100 / $totalstudent, 1) . '%';
$fail2 = number_format($fail * 100 / $totalstudent, 1) . '%';
$inco2 = number_format($inco * 100 / $totalstudent, 1) . '%';
$other2 = number_format($other * 100 / $totalstudent, 1) . '%';

//summary array
$summary = array(
    'one' => array('REMARKS', 'PASS', 'SUPPLEMENTARY', 'FAIL', 'INCOMPLETE', 'OTHER REMARKS'),
    'two' => array('FEMALE', $fepass, $fesupp, $fefail, $feinc, $feother),
    'three' => array('MALE', $mepass, $mesupp, $mefail, $meinc, $meother),
    'four' => array('SUBTOTAL', $pass . '(' . $pass2 . ')', $supps . '(' . $supps2 . ')',
        $fail . '(' . $fail2 . ')', $inco . '(' . $inco2 . ')', $other . '(' . $other2 . ')')
);

foreach ($summary as $perform) {
    $colm = $START_POINT;

    foreach ($perform as $val) {
        $y = $colm;
        $track = 1;
        while ($track < 3) {
            $y++;
            $track++;
        }

        $objPHPExcel->getActiveSheet()->mergeCells($colm . $rows . ':' . $y . $rows)->getStyle($colm . $rows . ':' . $y . $rows)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colm . $rows, $val);
        $objPHPExcel->getActiveSheet()->getStyle($colm . $rows)->applyFromArray($styleArray);
        $colm = $y;
        $colm++;
    }
    $rows++;
}

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle($sem . ' Report');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="SARIS_Semester_Report.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

