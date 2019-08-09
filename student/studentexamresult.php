<?php 
	if($examofficer<>1){
		require_once('../Connections/sessioncontrol.php');
		
		# include the header
		include('studentMenu.php');
		global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
		$szSection = 'Academic Records';
		$szTitle = 'Examination Results';
		$szSubSection = 'Exam Result';
		include("studentheader.php");
		}
	?>
		
		<style type="text/css">
		#table{
			border-radius:5px;
			background:#ceceff;
			font-family:Courier New, Monospace;
			}
		#table tr th{
			background:#bdbdd5;
			}
		#table tr td{							
			font-size:14px;
			font-family:Courier New, Monospace;
			}
		#table tr:hover{
			opacity:0.7;
			}
		.total{
			background:#bdbdd5;
			font-weight:bold;
			}
		</style>
		
	<?php
		
	$editFormAction = $_SERVER['PHP_SELF'];

	#check if has blocked
	$qstatus = "SELECT Status FROM student  WHERE (RegNo = '$RegNo')";
	$dbstatus = mysql_query($qstatus);
	$row_status = mysql_fetch_array($dbstatus);
	$status = $row_status['Status'];

	if ($status=='Blocked'){
		echo "Your Examination Results are Currently Blocked<br>";
		echo "Please Contact the Registrar Office to Resolve this Issue<br>";
		exit;
		}

	$key = $RegNo;
	//include("../includes/pastel.class.php");
	//$odbcfile = 'http://172.31.0.94:8090/saris/odbc.php';
	//$pastelurl = $odbcfile;
	//$pastelobj = new pastel();
	//$regno = trim(strtoupper($RegNo));
	//$view_type = 3;
	//$inst = $pastelobj->resultCode($pastelurl, $regno, $view_type);
	include '../academic/includes/showexamresults.php';

	if($examofficer<>1){
		include('../footer/footer.php');
		}
?>
