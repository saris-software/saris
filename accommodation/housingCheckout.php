<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Accommodation';
	$szSubSection = 'Checkout Room';
	$szTitle = 'Checkout Room Tenant';
	include('admissionheader.php');
	$today = date("Y-m-d");
	
	
	if(isset($_POST['save'])){
		//get posted values
		$regno = addslashes($_POST['regno']);
		$checkout = addslashes($_POST['checkout']);

		if ($regno==''){
		echo 'Please Enter RegNo !';
		exit;
		}
	
		//validate this regno
		$qregno =  "select Name, RegNo from student where RegNo='$regno'";
		$dbregno=mysql_query($qregno);
		if(mysql_num_rows($dbregno)>0){
				//check max checkin
				$qmaxindate = "select max(CheckIn) from allocation where RegNo='$regno'";
				$dbmaxindate = mysql_query($qmaxindate);
				$row_maxindate = mysql_fetch_assoc($dbmaxindate);
				$maxindate = $row_maxindate['max(CheckIn)'];
				if($maxindate>$checkout){
					echo 'Database not Updated <br>';
					echo $checkout.' - Checkout Date is Older than Checkin Date - '.$maxindate;
						?>
						<form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="save" target="_self">
						<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
						  <tr>
							<td><strong>RegNo:</strong></td>
							<td><input name="regno" type="text" maxlength="20"></td>
						  </tr>
						
						  <tr>
							<td><strong>CheckOUT:</strong></td>
							<td><input name="checkout" type="text" maxlength="20"></td>
							<!-- A Separate Layer for the Calendar -->
							<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>    
							<td><input type="button" class="button" name="dtDate_button" value="Calendar" onClick="show_calendar('save.checkout', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')"></td>
						  </tr>
						  <tr>
							<td></td>
							<td><input name="save" type="submit" value="Update"></td>
						  </tr>
						</table>
						<?php 
						exit;
				}

				//update max checkout
				$qmaxdate = "select max(CheckOut) from allocation where RegNo='$regno'";
				$dbmaxdate = mysql_query($qmaxdate);
				$row_maxdate = mysql_fetch_assoc($dbmaxdate);
				$maxdate = $row_maxdate['max(CheckOut)'];
				
				$qupdate = "UPDATE allocation SET Checkout = '$checkout' WHERE RegNo='$regno' and CheckOut ='$maxdate' ";
				$dbupdate = mysql_query($qupdate);
				if($dbupdate){
				echo 'Database Updated';
						?>
						<form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="save" target="_self">
						<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
						  <tr>
							<td><strong>RegNo:</strong></td>
							<td><input name="regno" type="text" maxlength="20"></td>
						  </tr>
						
						  <tr>
							<td><strong>CheckOUT:</strong></td>
							<td><input name="checkout" type="text" maxlength="20"></td>
							<!-- A Separate Layer for the Calendar -->
							<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>    
							<td><input type="button" class="button" name="dtDate_button" value="Calendar" onClick="show_calendar('save.checkout', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')"></td>
						  </tr>
						  <tr>
							<td></td>
							<td><input name="save" type="submit" value="Update"></td>
						  </tr>
						</table>
						<?php
						exit;
				}
		}
	}
	else{
	?>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="save" target="_self">
<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td><strong>RegNo:</strong></td>
    <td><input name="regno" type="text" maxlength="20"></td>
  </tr>

  <tr>
    <td><strong>CheckOUT:</strong></td>
    <td><input name="checkout" type="text" maxlength="20"></td>
	<!-- A Separate Layer for the Calendar -->
	<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>    
	<td><input type="button" class="button" name="dtDate_button" value="Calendar" onClick="show_calendar('save.checkout', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=300;PopupY=300;')"></td>
  </tr>
  <tr>
    <td></td>
    <td><input name="save" type="submit" value="Update"></td>
  </tr>
</table>
<?php } ?>
