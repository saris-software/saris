<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	//include('lecturerMenu.php');
	
	include('timetable.php');

	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Timetable';
	$szSubSection = 'Find Allocated';
	$szTitle = 'Lecturer Course Allocation';
//	include('lecturerheader.php');
?>

<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

//get all days
$sql_day ="SELECT * FROM days";
$result_day =mysqli_query($zalongwa, $sql_day);

//timetable Category
$sql_cat ="SELECT * FROM timetableCategory";
$result_cat =mysqli_query($zalongwa, $sql_cat);

// academic year
$sql_acc = "SELECT * FROM academicyear ORDER BY AYear DESC";
$result_acc =mysqli_query($zalongwa, $sql_acc);
$get_data="SELECT * FROM timetable ORDER BY AYear DESC";
if(isset($_POST['search'])){
	$get_data="SELECT * FROM timetable";
	$where='';
	if(!empty($_POST['name'])){
		$user_name = $_POST['name'];
		$where.= "lecturer LIKE '%$user_name%' AND ";
	}
if(!empty($_POST['course'])){
		$course_1 = $_POST['course'];
		$where.= "CourseCode LIKE '%$course_1%' AND ";
	}

if(!empty($_POST['room'])){
		$room_1 = $_POST['room'];
		$where.= "venue LIKE '%$room_1%' AND ";
	}
	
if(!empty($_POST['day'])){
		$day_1 = $_POST['day'];
		$where.= "day='$day_1' AND ";
	}
if(!empty($_POST['time'])){
		$start_1= $_POST['time'];
		$where.= "start='$start_1' AND ";
	}
	
if(!empty($_POST['ayear'])){
		$ayear_1= $_POST['ayear'];
		$where.= "AYear='$ayear_1' AND ";
	}

	if(!empty($_POST['semester'])){
		$semester= $_POST['semester'];
		$where.= "timetable_category='$semester' AND ";
	}
	
	if($where != ''){
		$where = rtrim($where," AND ");
		$get_data.=' WHERE '.$where;
	}
	 $get_data=$get_data.' ORDER BY AYear DESC';
	

}

$result_all_data = mysqli_query($zalongwa, $get_data);


?>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<fieldset style="width:600px;"><legend>Filter your Timetable Search  </legend>
             <table class="resView"> 
            
<tr>
<td class="resViewhd"><div align='right'> Username</div></td>
<td class="resViewtd"><input name="name" type="text" id="course" ></td>
<td class="resViewhd"><div align='right'> Course</div></td>
<td class="resViewtd"><input name="course" type="text" id="course" maxlength="15"></td>
</tr>
<tr>
<td class="resViewhd"><div align='right'> Day</div></td>
<td class="resViewtd">
<select name="day" id="day">
     <option value="">Select Day</option>
     <?php 
     while ($rows = mysqli_fetch_array($result_day)) {
     	?>
     	<option value="<?php echo $rows['id'];?>"><?php echo $rows['name'];?></option>
     	<?php      }      ?>       		
     </select>
            		</td>
        
        <td class="resViewhd"><div align='right'> Time</div></td>
        <td class="resViewtd"><select name="time" id="time">
                    <option value="">Select Period Start Time</option>
			<option value="7">7:00</option>
			<option value="8">8:00</option>
			<option value="9">9:00</option>
			<option value="10">10:00</option>
			<option value="11">11:00</option>
			<option value="12">12:00</option>
			<option value="13">13:00</option>
			<option value="14">14:00</option>
			<option value="15">15:00</option>
			<option value="16">16:00</option>
			<option value="17">17:00</option>
			<option value="18">18:00</option>
			<option value="19">19:00</option>
			
           </select></td>
                  </tr>
<tr>

<td class="resViewhd"><div align='right'> Room</div></td>
<td class="resViewtd"><input name="room" type="text" id="room"></td>
<td class="resViewhd"><div align='right'> Category</div></td>
<td class="resViewtd"><select name="semester" id="semester">
<option value="">Select Category</option>
                        <?php
do {
?>
                        <option value="<?php echo $row_sem['id']?>"><?php echo $row_sem['name']?></option>
                        <?php
} while ($row_sem = mysqli_fetch_assoc($result_cat));
  $rows = mysqli_num_rows($result_cat);
  if($rows > 0) {
      mysqli_data_seek($result_cat, 0);
	  $row_sem = mysqli_fetch_assoc($result_cat);
  }
?>
                    </select>
                  </td></tr>
                  
                  
                  
                  
                  
                  <tr>
 
             <td class="resViewhd"><div align='right'> Year</div></td>
<td class="resViewtd">
<select name="ayear" id="ayear">
     <?php 
     while ($rows = mysqli_fetch_array($result_acc)) {
     	?>
     	<option value="<?php echo $rows['AYear'];?>"><?php echo $rows['AYear'];?></option>
     	<?php      }      ?>       		
     </select>
            		</td>
   
             
<td class="resViewhd" colspan='2'>
              <input type="submit" name="search" value="Search" onmouseover="this.style.background='#DEFEDE'"
onmouseout="this.style.background='lightblue'" style='background-color:lightblue; width:100px; padding:5px 0px 5px 0px;    color:black;font-size:9pt;font-weight:bold'  title="Click to Search the List"></td>
</tr></table> 

</fieldset>
</form>
<br/>

<br/>
<?php 
if(isset($_GET['succ'])){
	echo  '<div style="color:red;">'.$_GET['succ'].'</div>';
}

?>
<table  class="resView" style="width:900px;">
<tr>
<td class="resViewhd">Full Name</td>
<td class="resViewhd">UserName</td>
<td class="resViewhd">Day</td>
<td class="resViewhd">Year</td>
<td class="resViewhd">Category</td>
<td class="resViewhd">Course</td>
<td class="resViewhd">Venue</td>
<td class="resViewhd">Time</td>
<td class="resViewhd">Edit</td>
<td class="resViewhd">Delete</td>
</tr>

<?php 
while ($data = mysqli_fetch_array($result_all_data)) {
	//fullname
	$lname = $data['lecturer'];
	$user="SELECT * FROM security WHERE UserName='$lname'";
	$result_user=mysqli_query($zalongwa, $user);
	$lect_name = mysqli_fetch_array($result_user);
	
	//get dat
	$day = $data['day'];
$sql_day ="SELECT * FROM days WHERE id='$day'";
$result_day =mysqli_query($zalongwa, $sql_day);
$day_name = mysqli_fetch_array($result_day);

//timetable Category
$cat_id = $data['timetable_category'];
$sql_cat ="SELECT * FROM timetableCategory WHERE id='$cat_id'";
$cat_name = mysqli_fetch_array($result_cat_name);
	
	?>
	<tr>
<td class="resViewtd"><?php echo $lect_name['FullName'] ?></td>
<td class="resViewtd"><?php echo $lname ;?></td>
<td class="resViewtd"><?php echo $day_name['name'];?></td>
<td class="resViewtd"><?php echo $data['AYear'];?></td>
<td class="resViewtd"><?php echo $cat_name ['name'];?></td>
<td class="resViewtd"><?php echo $data['CourseCode'];?></td>
<td class="resViewtd"><?php echo $data['venue'];?></td>
<td class="resViewtd"><?php echo $data['start'].':00 - '.$data['end'].':00';?></td>
<td class="resViewtd"><a  href="createtimetable.php?create=1&ayear=<?php echo $data['AYear']; ?>&programme=<?php echo $data['Programme']?>&type=<?php echo $data['timetable_category'] ?>&edit=<?php echo $data['id']?>">Edit</a> </td>
<td class="resViewtd"><a onclick="return delete_data()" href="lecturerSearchtimetable.php?delete=<?php echo $data['id']?>">Delete</a> </td>
</tr>
	
<?php } ?>
</table>
<?php 
if(isset($_GET['delete'])){
	$id = $_GET['delete'];
	$delete = "DELETE FROM timetable WHERE id='$id'";
	$Result = mysqli_query($zalongwa, $delete);
	if($Result){
		$succ = urlencode('Data deleted!!');
	echo '<meta http-equiv = "refresh" content ="0; url = lecturerSearchtimetable.php?succ='.$succ.'">';
	exit;	
	}
}
?>
<br/>
<br/>
<br/>

<script type="text/javascript">
function delete_data(){
	$con = confirm('Are you sure you want delete ??');
     if($con){
  return true;
     }else{
  return false;
     }
}
</script>
