<?php require_once('Connections/zalongwa.php'); ?>
<?php

        if () {
            echo '<meta http-equiv = "refresh" content ="0; 
				url = academic/lecturerindex.php">';
            exit;
        } elseif ($module == '2') {
            echo '<meta http-equiv = "refresh" content ="0; 
				 url = accommodation/housingindex.php">';
            exit;
        } elseif ($module == '3') {
            echo '<meta http-equiv = "refresh" content ="0; 
				 url = student/studentindex.php">';
            exit;
        } elseif ($module == '4') {
            echo '<meta http-equiv = "refresh" content ="0; 
				 url = admission/admissionindex.php">';
            exit;
        } elseif ($module == '5') {
            echo '<meta http-equiv = "refresh" content ="0; 
						url = administrator/administratorindex.php">';
            exit;
        } elseif ($module == '6') {
            echo "Your Are Currently Blocked from Using ZALONGWA database!<br> To Restore Services, Please Contact the System Administrator";
            exit;
        } elseif ($module == '7') {
            echo '<meta http-equiv = "refresh" content ="0; 
						url = billing/billingindex.php">';
            exit;
        } elseif ($module == '8') {
            echo '<meta http-equiv = "refresh" content ="0; 
						url = timetable/lecturerindex.php">';
            exit;
        }
    } else {
        //$_SESSION['loginerror'] = 'Sign in Failed, Try Again!';
        echo '<meta http-equiv = "refresh" content ="0; 
		url = index.php">';
        exit;
    }
}
?>
<?php
mysqli_close($zalongwa);

?>