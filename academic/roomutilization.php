<?php require_once('../Connections/zalongwa.php'); 
require_once('../Connections/sessioncontrol.php');
# include the header
//include('lecturerMenu.php');

include('timetable.php');

	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Timetable';
	$szTitle = 'Venue Utilization';
	$szSubSection = 'Venue Utilization';
	//include("lecturerheader.php");
?>

<head>
  <title>policy setup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div align select="center">
<div class="container" style="width:55%">


<?php
mysqli_select_db($zalongwa_database,$zalongwa);
//select all academic year
$sql_ayear= "SELECT * FROM academicyear ORDER BY AYear DESC";
$result_ayear=mysqli_query($zalongwa, $sql_ayear);

// select all timetable type/category
$sql_timetablecategory= "SELECT * FROM timetableCategory";
$result_timetablecategory=mysqli_query($zalongwa, $sql_timetablecategory);



if(isset($_POST['load'])){
	$ayear=$_POST['ayear'];
	$type =$_POST['tcategory'];
	
 
	//header('Location: createtimetable.php?create=1&ayear='.$ayear.'&programe='.$programme.'&type='.$type);
	echo '<meta http-equiv = "refresh" content ="0; url = roomutilization.php?create=1&ayear='.$ayear.'&type='.$type.'">';
	exit;
}

if(!isset($_GET['create'])){
?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <div class="form-group">
      <label for="institution">Academic Year:</label>
      <select class="form-control"  name="ayear">
<?php 
while($row = mysqli_fetch_array($result_ayear)){
	echo '<option value="'.$row['AYear'].'">'.$row['AYear'].'</option>';
}
?>
</select>
 </div>
 
 
     <div class="form-group">
      <label for="institution">
      Time table category:</label>
      <select class="form-control" name="tcategory">
<?php 
while($row = mysqli_fetch_array($result_timetablecategory)){
	echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}
?>
</select>
</div>


<td class="resViewhd" colspan="2" align="center"><input type="submit" name="load" value="Load Timetable"/></td>

</form>
<br/>
<br/>
<?php 
if(isset($_GET['error'])){
echo '<div style="color:red; margin:0px 0px 0px 50px;">'.$_GET['error'].'</div>';	
}
// Start generating report
}else{
$ayear = $_GET['ayear'];
$type = $_GET['type'];

if($type == 1){
	$subtitle_timetable = " ACADEMIC YEAR  ".$ayear .' -  SEMESTER I';
}else if($type == 2){
	$subtitle_timetable = " ACADEMIC YEAR  ".$ayear .' - SEMESTER II';
}else if($type == 3){
	$subtitle_timetable = " SEMESTER I EXAMINATION, ACADEMIC YEAR  ".$ayear ;
}else if($type == 4){
	$subtitle_timetable =  "SEMESTER II EXAMINATION, ACADEMIC YEAR  ".$ayear ;
}else if($type == 5){
	$subtitle_timetable =  " SUPPL/SPECIAL EXAMINATION, ACADEMIC YEAR  ".$ayear;
}


// selet all venue
$get_all ="SELECT * FROM venue";
$venue_result = mysqli_query($zalongwa, $get_all);
$venue_rows = mysqli_num_rows($venue_result);

//get all days
$get_all_days ="SELECT * FROM days";
$days_result = mysqli_query($zalongwa, $get_all_days);


if($venue_rows == 0){
	$err = urlencode('No Venue available in System');
	echo '<meta http-equiv = "refresh" content ="0; url = roomutilization.php?error='.$err.'">';
	exit;
	
}else{

$main_data=array();
$total = array();
$time=array();
$time_total =array();
// loop in all venue
while ($rw = mysqli_fetch_array($venue_result)) {
 	$ven = $rw['VenueCode'];
	$f=array();
         $get_all_days ="SELECT * FROM days";
         $days_result = mysqli_query($zalongwa, $get_all_days);
	
 while ($row = mysqli_fetch_array($days_result)) {
      $d=$row['id'];
 	$sql_count = "SELECT venue FROM timetable WHERE AYear ='$ayear' AND timetable_category='$type' AND venue='$ven' AND day='$d'";
 	$count_result = mysqli_query($zalongwa, $sql_count);
 	$ftc=mysqli_num_rows($count_result);
 	
 	//get all period data 
 	$get_all_period = "SELECT * FROM timetable WHERE AYear ='$ayear' AND timetable_category='$type' AND venue='$ven' AND day='$d'";
 	$all_time = mysqli_query($zalongwa, $get_all_period);
 	$totat_time_in_day = 0;
 	while ($rr = mysqli_fetch_array($all_time)) {
 		$totat_time_in_day += $rr['end']-$rr['start'];
 	}
 	
 	$time[$ven][$d] = $totat_time_in_day;
 	
 	$main_data[$ven][$d]=$ftc;
 		if(array_key_exists($ven, $total)){
 			$last = $total[$ven];
 			$total[$ven] = ($last+$ftc);
 		}else{
 			$total[$ven] = $ftc;
 		}
 		
 		
 if(array_key_exists($ven, $time_total)){
 			$last = $time_total[$ven];
 			$time_total[$ven] = ($last+$totat_time_in_day);
 		}else{
 			$time_total[$ven] = $totat_time_in_day;
 		}
 		
 		
 	}
 	
 }
 
arsort($total,SORT_NUMERIC);
	
	
	?>
	<style type="text/css">
	.view_timetable{
		table-layout:fixed;
		width:900px;
		padding:0px;
		margin:0px;
		position:relative;
		border:1px solid #CCCCCC;
		color:#000000;
		}
		
		.view_timetable tr td{
		border-bottom:1px solid #CCCCCC;
		border-right:1px solid #CCCCCC;
		position:relative;
		}
</style>
<div style="text-indent:20px; padding:10px 0px 0px 0px; width:900px;">
<?php 
echo '<h2 style="padding:0px; margin:0px; width:900px; color:black; font-size:18px; display:block; text-indent:100px;">VENUE UTILIZATION</h2>';
echo '<h3 style="padding:0px; margin:0px; width:900px; color:black; font-size:15px; display:block; text-indent:100px;">'.$subtitle_timetable.'</h3>';
?>
</div>
<div style="color:blue; text-align:right; font-size:15px;font-weight:bold;  padding:5px 100px 10px 0px;">
    <form action="printroomutilization.php" method="post">
   <input value="<?php echo $ayear;?>" name="ayear" type="hidden"/>
   <input value="<?php echo $type?>" name="type" type="hidden"/>
   <input id="m" style="color:blue; font-size:15px;font-weight:bold; cursor: pointer; text-decoration:underline; border:0px; background-color:transparent;" type="submit" value="Export Timetable" name="PRINT"/>
   </form> 
   </div>
	<table class="view_timetable" cellpadding="0" cellspacing="0">
	<tr>
	<td style="width:100px;" align="center">S/No</td>
	<td align="center">Venue Code</td>
	<td>Venue Name</td>
	<?php 
	$sql = "SELECT * FROM days";
	$re=mysqli_query($zalongwa, $sql);
	
	while ($row = mysqli_fetch_array($re)) {
		?>
		<td align="center" colspan="2"><?php echo $row['name'];?></td>
<?php	} ?>

<td align="center" colspan="2">Total Per Week</td>
</tr>

<tr>
<td></td>
<td></td>
<td></td>
<?php 
	$sql = "SELECT * FROM days";
	$re=mysqli_query($zalongwa, $sql);
	
	while ($row = mysqli_fetch_array($re)) {
		?>
		<td align="center"># Period</td>
		<td align="center"># Hours</td>
<?php	} ?>
       <td align="center"> # Period</td>
		<td align="center"># Hours</td>

</tr>
<?php
$i=1;
foreach ($total as $key => $value) {
	?>
	<tr>
	<td align="center"><?php echo $i++;?></td>
	<td align="center"><?php echo $key;?></td>
	<td><?php
   $sql = "SELECT * FROM venue WHERE VenueCode='$key'";
	$re=mysqli_query($zalongwa, $sql);
	$v_name = mysqli_fetch_array($re);
	echo $v_name['VenueName'];?></td>
	<?php 
	$sql = "SELECT * FROM days";
	$re=mysqli_query($zalongwa, $sql);
	while ($row = mysqli_fetch_array($re)) {
		$day = $row['id'];
		?>
		<td align="center"><?php echo $main_data[$key][$day];?></td>
		<td align="center"><?php echo $time[$key][$day];?></td>
<?php	} ?>
<td align="center"><?php echo $value;?></td>
<td align="center"><?php echo $time_total[$key];?></td>

	</tr>
	<?php } ?>
	</table>
	<br/>
	<br/>
	<br/>
	<?php 
}
	
	
}

?>
