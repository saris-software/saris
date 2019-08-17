<?php require_once('../Connections/zalongwa.php'); 
require_once('../Connections/sessioncontrol.php');
# include the header
include('lecturerMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Timetable';
	$szTitle = 'View Timetable';
	$szSubSection = 'Get TimeTable';
	include("lecturerheader.php");
?>

<?php
mysqli_select_db($zalongwa_database,$zalongwa);
//select all academic year
$sql_ayear= "SELECT * FROM academicyear ORDER BY AYear DESC";
$result_ayear=mysqli_query($sql_ayear);

// select all timetable type/category
$sql_timetablecategory= "SELECT * FROM timetableCategory";
$result_timetablecategory=mysqli_query($sql_timetablecategory);

//select all programme
$sql_programme= "SELECT * FROM programme";
$result_programme=mysql_query($sql_programme);

// select all lecturer
$query_lecturer = "SELECT UserName, FullName, Position FROM security WHERE Position = 'Lecturer' ORDER BY FullName";
$lecturer_result=mysql_query($query_lecturer);

// select all fuculty
$query_fuculty = "SELECT * FROM faculty ";
$fuculty_result=mysql_query($query_fuculty);


if(isset($_POST['load'])){
	$ayear=$_POST['ayear'];
	$programme = '';// $_POST['programme'];
	$type =$_POST['tcategory'];
	$filter =$_POST['fby'];
 if($filter == 1){
 	$programme = $_POST['programme'];
 }else if($filter == 2){
 	$programme=$_POST['faculty'];
 }else if($filter == 3){
 	$programme = $_POST['lecturer'];
 }
 
	//header('Location: createtimetable.php?create=1&ayear='.$ayear.'&programe='.$programme.'&type='.$type);
	echo '<meta http-equiv = "refresh" content ="0; url = gettimetable.php?create=1&ayear='.$ayear.'&fby='.$filter.'&programme='.$programme.'&type='.$type.'">';
	exit;
}

if(!isset($_GET['create'])){
?>
<style type="text/css">
.hide{
display:none;
}
</style>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="resView">
<tr>
<td class="resViewhd">Academic Year:</td>
<td class="resViewtd">
<select name="ayear">
<?php 
while($row = mysql_fetch_array($result_ayear)){
	echo '<option value="'.$row['AYear'].'">'.$row['AYear'].'</option>';
}
?>
</select>
</td>

</tr>
<tr><td class="resViewhd">Filter By</td>
<td class="resViewtd">
<select name="fby" id="filter">
<option value="1">Programme</option>
<option value="2">Faculty</option>
<option value="3">Lecturer</option>
</select>
</td>
</tr>
<tr id="pr"><td class="resViewhd">Programme:</td>
<td class="resViewtd">
<select name="programme">
<?php 
while($row = mysql_fetch_array($result_programme)){
	echo '<option value="'.$row['ProgrammeCode'].'">'.$row['ProgrammeName'].'</option>';
}
?>
</select>
</td>
</tr>

<tr class="hide" id="fc"><td class="resViewhd">Fuculty:</td>
<td class="resViewtd">
<select name="faculty">
<?php 
while($row = mysql_fetch_array($fuculty_result)){
	echo '<option value="'.$row['FacultyID'].'">'.$row['FacultyName'].'</option>';
}
?>
</select>
</td>
</tr>

<tr class="hide" id="lect"><td class="resViewhd">Lecturer:</td>
<td class="resViewtd">
<select name="lecturer">
<?php 
while($row = mysql_fetch_array($lecturer_result)){
	echo '<option value="'.$row['UserName'].'">'.$row['FullName'].'</option>';
}
?>
</select>
</td>
</tr>

<tr><td class="resViewhd">Time table Category:</td>
<td class="resViewtd">
<select name="tcategory">
<?php 
while($row = mysql_fetch_array($result_timetablecategory)){
	echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}
?>
</select>
</td>
</tr>
<tr>
<td class="resViewhd" colspan="2" align="center"><input type="submit" name="load" value="Load Timetable"/></td>
</tr>
</table>
</form>
<br/>
<br/>
<?php 
if(isset($_GET['error'])){
echo '<div style="color:red; margin:0px 0px 0px 50px;">'.$_GET['error'].'</div>';	
}
}else{ 
    $ayear = $_GET['ayear'];
	$programme= $_GET['programme'];
	$type = $_GET['type'];	
	$fby = $_GET['fby'];
	 
	if($fby == 1){
	 $sql = "SELECT * FROM timetable WHERE AYear='$ayear' AND Programme='$programme' AND timetable_category='$type' ORDER BY day,start ASC";
             // generate timetable title
              $sql_title = "SELECT * FROM programme WHERE ProgrammeCode='$programme'";
	  $title_result = mysql_query($sql_title);
	  $fetch_title = mysql_fetch_array($title_result);
	    $title_timetable = $fetch_title['Title'].' - [ '.$fetch_title['ProgrammeName'].' ] ';
	 
             if($type == 1){
	       $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER I - '.$ayear;
             }else if($type == 2){
            $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER II - '.$ayear;
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER I - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER II - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'SUPPL/SPECIAL EXAMINATION TIMETABLE   - '.$ayear;	
             }
	}else if($fby == 2){
		
		$sql_faculty = "SELECT * FROM faculty WHERE FacultyID='$programme'";
		$result_faculty = mysql_query($sql_faculty);
		$data=mysql_fetch_array($result_faculty);
		$fc_ID = $programme;
		$fc_name = $data['FacultyName'];
		  $sql_progr = "SELECT DISTINCT ProgrammeCode FROM programme WHERE Faculty='$fc_ID' OR Faculty='$fc_name'";
		
		$facult_prog = mysql_query($sql_progr);
		//$loop_prog_value='';
		while ($row = mysql_fetch_array($facult_prog)) {
			$pg = $row['ProgrammeCode'];
			$loop_prog_value.="  Programme='$pg' OR ";
		}
		
		$loop_prog_value =rtrim($loop_prog_value," OR ");
		
		  $loop_prog_value = " AND (". $loop_prog_value.' ) ';
		  
	   $sql = "SELECT * FROM timetable WHERE AYear='$ayear' $loop_prog_value AND timetable_category='$type' ORDER BY day,start ASC";
		
	   
	   // get title
	   $title_timetable = $fc_name;
	 
             if($type == 1){
	       $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER I - '.$ayear;
             }else if($type == 2){
            $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER II - '.$ayear;
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER I - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER II - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'SUPPL/SPECIAL EXAMINATION TIMETABLE   - '.$ayear;	
             }
	   
	   
	}else if($fby == 3){
	 $sql = "SELECT * FROM timetable WHERE AYear='$ayear' AND lecturer='$programme' AND timetable_category='$type' ORDER BY day,start ASC";
	
	 
	 // generate timetable title
      $sql_title = "SELECT * FROM security WHERE UserName='$programme'";
	  $title_result = mysql_query($sql_title);
	  $fetch_title = mysql_fetch_array($title_result);
	    $title_timetable = $fetch_title['FullName'];
	 
             if($type == 1){
	       $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER I - '.$ayear;
             }else if($type == 2){
            $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER II - '.$ayear;
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER I - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER II - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'SUPPL/SPECIAL EXAMINATION TIMETABLE   - '.$ayear;	
             }
	 
	}
	 $result = mysql_query($sql);
	 $num = mysql_num_rows($result);
	

	$timetable=array();
	if($num < 1){
	echo '<meta http-equiv = "refresh" content ="0; url = gettimetable.php?error=No data found!!!">';
	exit;	
	}else{
		//array key define here
		$keys = array();
		while ($row = mysql_fetch_array($result)) {
			$usern = $row['lecturer'];
			$sql_lect = "SELECT * FROM security WHERE UserName='$usern'";
			$result_lect = mysql_query($sql_lect);
			$lecturer_name = mysql_fetch_array($result_lect);
			
			$teaching = $row['teachingtype'];
			$sql_teach = "SELECT * FROM teachingtype WHERE id='$teaching'";
			$result_teach = mysql_query($sql_teach);
			$teach_type = mysql_fetch_array($result_teach);
			
			$keys[$row['CourseCode']] = $row['CourseCode'];
			$timetable[$row['day']][$row['start']][]=array(
			                           'interval'=>$row['start_end'],
			                            'start'=>$row['start'],
			                            'end'=>$row['end'],
			                            'course'=>$row['CourseCode'],
			                            'venue'=>$row['venue'],
			                            'lecturer'=>$lecturer_name['FullName'],
			                            'teaching'=>$teach_type['name']
			                               );
		}
		
		//echo '<pre>';
		//print_r($timetable);
		//echo '</pre>';
		?>
		<style type="text/css">
		#content span{
		color:black;
		font-weight:normal;
		font-size:12px;
		}
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
		.one{
		display:block;
		background-color:#DFD7CF;
		border:1px solid blue;
		text-align:center;
		padding:0px 0px 0px 0px;
		height:80px;
		overflow:hidden;
		margin:5px 0px 5px 0px;
		}
		.wiz{
		display:block;
		margin:7px 0px 0px 0px;
		padding:5px 0px 0px 0px;
		}
		
		.one span{
		display:block;
		color:black;
		}
		
		.two{
		display:block;
		background-color: #DFD7CF;
		border:1px solid blue;
		z-index:100;
		position:relative;
		text-align:center;
		padding:0px 0px 0px 0px;
		height:80px;
		overflow:hidden;
		margin:5px 0px 5px 0px;
		}
		
		.two span{
		display:block;
		color:#000000;
		}
		
		.two-clas{
		  width:130px;
		}
		
		.three{
		display:block;
		background-color:#DFD7CF;
		border:1px solid blue;
		text-align:center;
		height:80px;
		overflow:hidden;
		padding:0px 0px 0px 0px;
		margin:5px 0px 5px 0px;
		}
		
		.three span{
		display:block;
		color:#000000;
		}
		
</style>
<div id="hello">
<div style="text-indent:20px; padding:10px 0px 0px 0px; width:900px;">
<?php 
echo '<h2 style="padding:0px; margin:0px; width:900px; color:black; font-size:20px; display:block; text-indent:100px;">'.strtoupper($title_timetable).'</h2>';
echo '<h3 style="padding:0px; margin:0px; width:900px; color:black; font-size:20px; display:block; text-indent:100px;">'.$subtitle_timetable.'</h3>';
?>
</div>
 <div style="color:blue; text-align:right; font-size:15px;font-weight:bold;  padding:10px 100px 10px 0px;">
    <form action="printtimetable.php" method="post">
   <input value="<?php echo $ayear;?>" name="ayear" type="hidden"/>
   <input value="<?php echo $programme?>" name="programme" type="hidden" />
   <input value="<?php echo $type?>" name="type" type="hidden"/>
   <input value="<?php echo $fby?>" name="fby" type="hidden"/>
   <input id="m" style="color:blue; font-size:15px;font-weight:bold; cursor: pointer; text-decoration:underline; border:0px; background-color:transparent;" type="submit" value="Export Timetable" name="PRINT"/>
   </form> 
   </div>
		 <table border="0" cellpadding="0" cellspacing="0" class="view_timetable">
  <tr>
  <td style="width:100px;">Day/Time</td>
  <td class="time">07:00 - 08:00</td>
  <td class="time">08:00 - 09:00</td>
  <td class="time">09:00 - 10:00</td>
  <td class="time">10:00 - 11:00</td>
  <td class="time">11:00 - 12:00</td>
  <td class="time">12:00 - 13:00</td>
  <td class="time">13:00 - 14:00</td>
  <td class="time">14:00 - 15:00</td>
  <td class="time">15:00 - 16:00</td>
  <td class="time">16:00 - 17:00</td>
  <td class="time">17:00 - 18:00</td>
  <td class="time">18:00 - 19:00</td>
  <td class="time">19:00 - 20:00</td>
  </tr>
  
  
  
  
  
  
<?php
$sql_day = "SELECT * FROM days ORDER BY id ASC";
$get = mysql_query($sql_day); 
while ($row = mysql_fetch_array($get)) {
	?>
	<tr>
	<td style="width:100px;"><?php echo $row['name'];?></td>
 <?php 
		if(array_key_exists($row['id'], $timetable)){
			for ( $p=7; $p < 20;$p++) {
				if(array_key_exists($p, $timetable[$row['id']])){
					?>
					<td valign="top">
					<?php 
					foreach ($timetable[$row['id']][$p] as $key => $value) { 
						if($value['interval'] == 1){ ?>
		<div class="one">
		<span style="background-color:gray; padding:5px 0px 5px 0px;"><?php echo $value['teaching']?></span>
		<span style="padding-top:5px;"><?php echo $value['course']?></span>
		<span><?php echo $value['venue'];?></span>
		<span><?php echo $value['start'].'00 - '.$value['end'].'00';?></span>
		</div>
		<?php }else if($value['interval'] == 2){?>
		<div class="two">
		<span style="background-color:gray; padding:5px 0px 5px 0px;"><?php echo $value['teaching']?></span>
		<span style="padding-top:5px;"><?php echo $value['course']?></span>
		<span><?php echo $value['venue'];?></span>
		<span><?php echo $value['start'].'00 - '.$value['end'].':00';?></span>
		</div>
		<?php }else if($value['interval'] == 3){?>
		<div class="three">
		<span style="background-color:gray; padding:5px 0px 5px 0px;"><?php echo $value['teaching']?></span>
		<span style="padding-top:5px;"><?php echo $value['course']?></span>
		<span><?php echo $value['venue'];?></span>
		<span><?php echo $value['start'].'00 - '.$value['end'].':00';?></span>
		</div>			
<?php 	}			}
					?>
					</td>
<?php 				}else{ ?>
				<td valign="top">&nbsp;</td>	
<?php 		
					}
			}
		}
		?>
	 </tr>
	 <?php } ?> 
  </table>
  </div>
 
  <br/>
  <br/>
    <br/>
  <br/>
  
  <!--Keys for course display here-->
  <p>
            <?php
            if (count($keys) > 0) {
                echo '<u><b>KEY</b></u><br/>';
                foreach ($keys as $k => $v) {
                    $sele = "SELECT * FROM course WHERE CourseCode='$k'";
                    $my = mysql_query($sele);
                    $fetc = mysql_fetch_array($my);
                    echo $k . ' &nbsp; : &nbsp; &nbsp;' . $fetc['CourseName'] . '<br/>';
                }
            }
            ?> 
        </p>
        <br/>
        <br/>
        <br/>
		<?php  }  }  ?>
<script type="text/javascript" src="jquery.js"></script>		
<script type="text/javascript">
$(document).ready(function(){

	
$('#fc').hide();
$('#lect').hide();

$('#filter').change(function(){
   onchange_val = $(this).val();

   if(onchange_val == 3){
   $('#lect').show();
   $('#fc').hide();
   $('#pr').hide();
   }else if(onchange_val == 2){
	   $('#lect').hide();
	   $('#fc').show();
	   $('#pr').hide();
   }else if(onchange_val == 1){
	   $('#lect').hide();
	   $('#fc').hide();
	   $('#pr').show();
   
   }
	
});



	
	var single=60;

//period with 1hr interval
    $('.view_timetable').find('div[class=one]').each(function(){
         single = $(this).width();
                
        });

       // period with 3hrs interval
    $('.view_timetable').find('div[class=three]').each(function(){
        $(this).width(3*single); // overwrite the width to fix 3 td
       
        width = $(this).width(); 
        offset = $(this).position();  // get position of the div
        height = $(this).height(); // get height of the div
       var ll = 0;
        $($(this).parent().next()).find('div').each(function(){  // loop all div in the next td
        	 $(this).css('position','relative');
             $(this).css('z-index','2000');
            
             off = $(this).position();  // get position of the div in the next td
             he = $(this).height();
             if(width > single){
            if(off.top == offset.top){  // if the div fall in the same possition append div aon top 
                
               ass = height;
               
           $('<div class="wiz" style="position:relative;z-index:2000;height:'+ass+'px">ll</div>').insertBefore(this); // insert div before the overlaping div
                }
            }
            });

        //loop next td /// the 3rd td, the same procedure as above
        $($(this).parent().next().next()).find('div').each(function(){
          	 $(this).css('position','relative');
               $(this).css('z-index','2000');
             // alert('sdsd');
               off = $(this).position();
               he = $(this).height();
               if(width > single){
              if(off.top == offset.top){
                  
                 ass = height;
                 
             $('<div class="wiz" style="position:relative;z-index:3000;height:'+ass+'px"></div>').insertBefore(this);
                  }
              }
              });
    });



        // deal with period of 2hrs interval
        $('.view_timetable').find('div[class=two]').each(function(){
           
            $(this).width(2*single);
            width = $(this).width();
            
            //$(this).append($(this).width());
            offset = $(this).position();
            height = $(this).height();
           var ll = 0;
            $($(this).parent().next()).find('div').each(function(){
            	 $(this).css('position','relative');
                 $(this).css('z-index','2000');
                
                 off = $(this).position();
                 he = $(this).height();
                 if(width > single){
                if(off.top == offset.top){
                    
                   ass = height;
                   
               $('<div class="wiz" style="position:relative;z-index:2000;height:'+ass+'px"></div>').insertBefore(this);
                    }
                }
                });
            
            
        
       });
	
});




</script>
