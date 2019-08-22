<?php
require_once('../Connections/sessioncontrol.php');
# include the header
include('studentMenu.php');
global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
$szSection = 'Admission Process';
$szTitle = 'Student Registration';
$szSubSection = '';
include("studentheader.php");

?>
<p><br><br><em>Please Fill the <span style="color: #C11B17; ">Regisration Form</span> provided
        <br> Make sure you provide the <span style="color: #C11B17; ">CORRECT INFORMATION</span></em></p>
<br><br>
<?php

# include the footer
include("../footer/footer.php");
?>
