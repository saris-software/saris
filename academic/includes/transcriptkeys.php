<?php
$pdf->text(190.28, $yind, '          ######## END OF TRANSCRIPT ########');
$pdf->text(50, $yind + 12, '1. The Transcript will be valid only if it bears the Institution Seal');
$pdf->text(50, $yind + 24, '2. Key for Course Units: ONE CREDIT IS EQUIVALENT TO 10 NOTIONAL HOURS.  ');
$pdf->text(110, $yind + 36, 'POINTS = GRADE POINTS MULTIPLIED BY NUMBER OF CREDITS.');
$pdf->text(50, $yind + 48, '3.	Key to the Grades and other Symbols for Institute Examinations: SEE THE TABLE BELOW ');
$x = 50;
$y = $yind + 54;
#table 1
include 'gradescale.php';

#table 2
$pdf->text(50, $y + 68, '4. Key to Classification of Awards: SEE THE TABLE BELOW ');
$y = $y + 74;
include 'gpascale.php';

#save print history
if ($realcopy == 2) {
    $printhistory = "INSERT INTO transcriptcount(RegNo, received, user) VALUES('$key',now(),'$username')";
    $result = mysqli_query($zalongwa, $printhistory);
}
?>
