<?php
	/*
	 * ****
	 * Developed by Charles Bundu
	 * 
	 * Any hardship found in understanding the auto-generation process 
	 * 
	 * Don't hesitate to ask
	 * 
	 * Comments are put to help understand the process..
	 * ***
	 */

	global $error, $errors, $degree, $ayear, $sem;				
	


	if(isset($_POST['HTML']) && ($_POST['HTML'] == "Print HTML")){
			
			global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;	
			
			require_once('../Connections/sessioncontrol.php');
			require_once('../Connections/zalongwa.php');
			# include the header
			// include('lecturerMenu.php');		
		  
			include('administration.php');

			$szSection = 'Administration';
			$szTitle = 'Generate Examination Numbers';
			$szSubSection = 'Exam Numbers';
			// include('lecturerheader.php');
			
			
			$prog = $_POST['prog'];
			$semester = $_POST['semester'];
			$cohort = $_POST['cohort'];
			$checked = $_POST['button'];
			$qcode = mysqli_query($zalongwa, "SELECT ProgrammeName, Title FROM programme WHERE ProgrammeCode='$prog'");
			$code = mysqli_fetch_assoc($qcode);
			$shorts = $code['ProgrammeName'];
			$title = $code['Title'];
			$short = explode(" ",$shorts);
			$initial = $short[1];
			
			$tabl = "examnumber_".$initial;
			if($checked == 'Y'){
				$num = mysqli_query($zalongwa, "SELECT * FROM $tabl WHERE Semester='$semester' AND EntryYear = '$cohort' LIMIT 1");
				}
			else{
				$num = mysqli_query($zalongwa, "SELECT * FROM $tabl WHERE Semester='$semester' LIMIT 1");
				}
				
			if(($row = mysqli_num_rows($num)) == 0){
					$error =  urlencode("There are NO Examination numbers generated<br/> for the choices you made");
					$location = "lecturerexamnumberpublish.php?errors=$error";
					echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
					exit;
				}
			else{
					$lim = mysqli_fetch_assoc($num);
					$year = $lim['AYear'];
					$yearsem = $lim['Semester'];
					?>
					<p style="font-weight:bold; width:700px;"><?php echo $title."<br />".$year." - ".$yearsem;?> Students Examination Numbers</p>
					<table border="1" cellpadding="3" cellspacing="0">						
						<tr style="font-weight:bold">
							<td nowrap>S/NO</td>
							<td nowrap>NAME</td>
							<td nowrap>REG NUMBER</td>
							<td nowrap>EXAM NUMBER</td>
							<td nowrap>SEX</td>
							<td nowrap>ENTRY YEAR</td>
						</tr>
					
					<?php
						
						if($checked == 'Y'){
								$sel = mysqli_query($zalongwa, "SELECT e.RegNo, e.ExamNo, e.EntryYear, s.Name, s.Sex 
												FROM $tabl e, student s	WHERE e.RegNo = s.RegNo 
												AND e.EntryYear = '$cohort' ORDER BY e.EntryYear DESC, s.Name ASC");
							}
							
						else{
								$sel = mysqli_query($zalongwa, "SELECT e.RegNo, e.ExamNo, e.EntryYear, s.Name, s.Sex 
													FROM $tabl e, student s WHERE e.RegNo = s.RegNo 
													ORDER BY e.EntryYear DESC, s.Name ASC");
							}
							
						$sn = 1;
						
						while($fetch = mysqli_fetch_array($sel)){
								echo "<tr>
										<td nowrap>$sn</td>
										<td nowrap>$fetch[Name]</td>
										<td nowrap>$fetch[RegNo]</td>
										<td nowrap>$fetch[ExamNo]</td>
										<td nowrap>$fetch[Sex]</td>
										<td nowrap>$fetch[EntryYear]</td>
									</tr>";
								$sn = $sn +1; 
							}						
					?>
					</table>
					<?php
				}						
			
			include("../footer/footer.php");
			exit;
		}
			
	
	
		global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
		
		require_once('../Connections/sessioncontrol.php');
		require_once('../Connections/zalongwa.php');
		# include the header
		//include('lecturerMenu.php');		
		
				include('administration.php');		

		$szSection = 'Administration';
		$szTitle = 'Generate Examination Numbers';
		$szSubSection = 'Exam Numbers';
		//include('lecturerheader.php');
		
		
		$query_degree = mysqli_query($zalongwa, "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeCode");
		$query_degree1 = mysqli_query($zalongwa, "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeCode");
		$query_ayear = mysqli_query($zalongwa, "SELECT AYear FROM academicyear ORDER BY AYear DESC");
		$query_ayear1 = mysqli_query($zalongwa, "SELECT AYear FROM academicyear ORDER BY AYear DESC");
		$query_sem = mysqli_query($zalongwa, "SELECT Semester FROM terms ORDER BY Semester Limit 2");
		$query_sem2 = mysqli_query($zalongwa, "SELECT Semester FROM terms ORDER BY Semester Limit 2");
		
		?>
		<style type="text/css">
			.align{
				text-align:right;
				}
			.left{
				text-align:left;
				}
		</style>
		<div>
			<form action="<?php $_SERVER['PHP_SELF']?>" method="post" >
				<table border="0" style="background:#ccc">
					<tr>
						<td class="align">Choose Study Programme:</td>
						<td nowrap>
							<select name="prog" id="prog">
							<?php
								while($degree = mysqli_fetch_array($query_degree)){
									?>
									<option value="<?php echo $degree['ProgrammeCode']?>"><?php echo $degree['ProgrammeName']?></option>								
									<?php								
									}								
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="align">Choose Student Cohort:</td>
						<td nowrap>
							<select name="cohort" id="cohort">
							<?php
								while($ayear = mysqli_fetch_assoc($query_ayear)){
									?>
									<option value="<?php echo $ayear['AYear']?>"><?php echo $ayear['AYear']?></option>								
									<?php
									}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="align">Choose Semester:</td>
						<td nowrap>
							<select name="semester" id="semester">
							<?php
								while($sem = mysqli_fetch_assoc($query_sem)){
									?>
									<option value="<?php echo $sem['Semester']?>"><?php echo $sem['Semester']?></option>								
									<?php
									}
							?>
							</select>
						</td>
					</tr>
					
					<tr>
						<td  colspan="2" style="text-align:center"><input type="submit" name="Generate" value="Generate" /></td>					
					</tr>
					<!--
					<tr>
						<td  class="align" style="padding-top:10px"><input type="checkbox" name="Overwrite" value="on" />Overwrite</td>
						<td class="left" style="padding-top:10px"><input type="submit" name="Generate" value="Generate" /></td>					
					</tr>-->
				</table>
			</form>
			<div>
				<?php
					if(isset($_GET['error']) && $_GET['error'] !=""){
						$msg = urldecode($_GET['error']);
						echo "<p style='color:red'>$msg</p>";
						}
				?>
			</div>
			
			<form method="post" action="<?php $_SERVER['PHP_SELF'];?>" style="background:#CCCCCC; margin-top:50px; width:315px;">
				<table border="0">
					<tr><td colspan="2"><b>Print Generated Examination Numbers</b></td></tr>
					<tr>
						<td class="align">Choose Study Programme:</td>
						<td nowrap>
							<select name="prog" id="prog">
							<?php
								while($degree = mysqli_fetch_array($query_degree1)){
									?>
									<option value="<?php echo $degree['ProgrammeCode']?>"><?php echo $degree['ProgrammeName']?></option>								
									<?php								
									}								
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="align" nowrap>
						Specify Cohort: 
						Yes<input type="radio" name="button" value="Y"> 
						<!--No<input type="radio" name="button" value="N">-->
						</td>
						<td nowrap>
							<select name="cohort" id="cohort">
							<?php
								while($ayear = mysqli_fetch_assoc($query_ayear1)){
									?>
									<option value="<?php echo $ayear['AYear']?>"><?php echo $ayear['AYear']?></option>								
									<?php
									}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="align">Choose Semester:</td>
						<td nowrap>
							<select name="semester" id="semester">
							<?php
								while($sem = mysqli_fetch_assoc($query_sem2)){
									?>
									<option value="<?php echo $sem['Semester']?>"><?php echo $sem['Semester']?></option>								
									<?php
									}
							?>
							</select>
						</td>
					</tr>
					<tr style="display:none; text-align:center">
						<td colspan="2" nowrap>Layout:Landscape<input name="layout" type="radio" value="L" checked></td> 
					</tr>
					<tr style="text-align:center;">
						<td colspan="2"><input type="submit" name="HTML" id="HTML" value="Print HTML"></td>
						<!--<td><input type="submit" name="EXCEL" id="EXCEL" value="EXCEL Export"></td>-->
					</tr>
				</table>						
			</form>
			<div>
				<?php
					if(isset($_GET['errors']) && $_GET['errors'] !=""){
						$msg = urldecode($_GET['errors']);
						echo "<p style='color:red'>$msg</p>";
						}
				?>
			</div>
			
			<?php
if(isset($_POST['Generate']) && ($_POST['Generate'] == "Generate")){

		require_once('../Connections/sessioncontrol.php');
		require_once('../Connections/zalongwa.php');
		# include the header
		include('lecturerMenu.php');		
		
		$cohort = stripslashes($_POST['cohort']);
		$sem = stripslashes($_POST['semester']);
		$prog = stripslashes($_POST['prog']);
		
		//check if any of the field are empty
	    if(empty($prog) && empty($cohort) && empty($sem)){
			$error = urlencode("Make selections before submission");
			$updateGoTo = "lecturerexamnumberpublish.php?error=$error";
			echo '<meta http-equiv = "refresh" content ="0; url ='. $updateGoTo.'">';
			}
			
		elseif(empty($prog)){
			$error = urlencode("Select study programme");
			$updateGoTo = "lecturerexamnumberpublish.php?error=$error";
			echo '<meta http-equiv = "refresh" content ="0; url ='. $updateGoTo.'">';
			}
			
		elseif(empty($cohort)){
			$error = urlencode("Select student Cohort");
			$updateGoTo = "lecturerexamnumberpublish.php?error=$error";
			echo '<meta http-equiv = "refresh" content ="0; url ='. $updateGoTo.'">';
			}
			
		elseif(empty($sem)){
			$error = urlencode("Select semester of study");
			$updateGoTo = "lecturerexamnumberpublish.php?error=$error";
			echo '<meta http-equiv = "refresh" content ="0; url ='. $updateGoTo.'">';			
			}
					
		else{
			
			$sql = mysqli_query($zalongwa, "SELECT AYear FROM academicyear where Status = 1");
			$acyr = mysqli_fetch_assoc($sql);
			$ayear = $acyr['AYear'];
			
			$date = explode("/", $ayear);
			$ayr = explode("/", $cohort);				
			$diff = $date[1] - $ayr[0];
				
			//check if the years of study have exceeded the institution limit
			if($diff > 6){
				$error = urlencode("No student in the cohort you selected is allowed to sit for Exam(s)");
				$updateGoTo = "lecturerexamnumberpublish.php?error=$error";
				echo '<meta http-equiv = "refresh" content ="0; url ='. $updateGoTo.'">';				
				}
				
			//select all students within the institution limits(years of study-wise)
			else{
				$group = mysqli_query($zalongwa,"SELECT DISTINCT RegNo, EntryYear, GradYear from student WHERE ProgrammeofStudy='$prog' 
										AND EntryYear>='$cohort' ORDER BY EntryYear ASC, RegNo DESC");
										
				$qcode = mysqli_query($zalongwa,"SELECT ProgrammeName FROM programme WHERE ProgrammeCode='$prog'");
				$code = mysqli_fetch_assoc($qcode);
				$shorts = $code['ProgrammeName'];
				$short = explode(" ",$shorts);
				$initial = $short[1];
				
				//$students = mysql_num_rows($group);
				
				$track = 1;
									
				while($create = mysqli_fetch_array($group)){
					$regnos = $create['RegNo'];
					$entrys = $create['EntryYear'];
					$gradus = $create['GradYear'];
					
					//check if the student has completed studies and lower the institution limit for certificate students
					if(strlen($gradus) == 10){
						$trk[$track] = $regnos; //has finished;
						}
					elseif(strstr($initial,"YW") && ($diff > 3)){
						$trk[$track] = $regnos; //has exceeded limits
						}							
						
					else{												
						
						//auto generate table name and create the table
						$tabl = "examnumber_".$initial;
						$table = mysqli_query($zalongwa, "CREATE TABLE IF NOT EXISTS $tabl 
											(RegNo varchar(50) PRIMARY KEY, ExamNo varchar(50) UNIQUE KEY, 
											EntryYear varchar(9),AYear varchar(9), Semester varchar(11))");
							
						//check if the table has any record(s)		
						$trial = mysqli_query($zalongwa,"SELECT * FROM $tabl WHERE AYear='$ayear' AND Semester='$sem'");
						if($try = mysqli_num_rows($trial) > 0){
							
							$checks = mysqli_query($zalongwa,"SELECT * FROM $tabl WHERE AYear='$ayear' 
													AND EntryYear='$entrys' AND Semester='$sem'");
							
							//check if that cohort exists
							if($num = mysqli_num_rows($checks) > 0){
								$check = mysqli_query($zalongwa,"SELECT * FROM $tabl WHERE AYear=$ayear AND Semester='$sem' 
														AND RegNo = '$regnos'");
														
								if($nums = mysqli_num_rows($check) == 0){
									
									//fetch the last examnumber									
									$enum = mysqli_query($zalongwa,"SELECT * FROM $tabl ORDER BY ExamNo DESC LIMIT 1");
									$endn = mysqli_fetch_array($enum);
									
									$ends = substr($endn['ExamNo'],-4);
									
									#control the ending digits
									//single ending digit
									if(substr($ends,0,1)==0 AND substr($ends,1,1)==0 AND substr($ends,2,1)==0){
										$temp = (integer)substr($ends,-1);							
										$last = $temp + 1;						
							
										if($last>9){
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."00".$last;											
											}
										else{
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."000".$last;											
											}
									}
									//double ending digit
									if(substr($ends,0,1)==0 AND substr($ends,1,1)==0 AND substr($ends,2,1)!=0){
										$temp = (integer)substr($ends,-2);							
										$last = $temp + 1;						
							
										if($last>99){
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."0".$last;											
											}
										else{
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."00".$last;											
											}
									}
									//triple ending digit
									if(substr($ends,0,1)==0 AND substr($ends,1,1)!=0){
										$temp = (integer)substr($ends,-3);							
										$last = $temp + 1;						
							
										if($last>999){
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid.$last;											
											}
										else{
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."0".$last;											
											}
									}
									//non-zero starting digit
									if(substr($ends,0,1)!=0){
										$temp = (integer)substr($ends,-4);							
										$last = $temp + 1;						
							
										$mid = substr($ayear,2,3);																		
										$xamno = $initial."/".$mid.$last;																						
									}

									$qinsrt = "INSERT INTO $tabl VALUES ('$regnos','$xamno','$entrys','$ayear','$sem')";
									$insrt = mysqli_query($zalongwa, $qinsrt);
									
									if($insrt){
										echo "$regnos has Examination number $xamno<br/>";										
										}
									else{
										echo "Duplicate entry for $regnos<br/>";										
										}																			
									}
								else{	
										//if the student has exam number
										echo "$regnos has Examinations number already<br/>";										
									}
								}
								
							else{
								$xzst = mysqli_query($zalongwa, "SELECT * FROM $tabl WHERE AYear='$ayear' AND Semester='$sem' 
													AND RegNo = '$regnos'");
								
								//check if that cohort has exam numbers
								if($new = mysqli_num_rows($xzst) > 0){
									//if the student has exam number
									echo "$regnos has Examinations number already<br/>";
									}
								else{
									//generate exam numbers for the specified cohort
									//fetch the last examnumber									
									$enum = mysqli_query($zalongwa, "SELECT * FROM $tabl ORDER BY ExamNo DESC LIMIT 1");
									$endn = mysqli_fetch_array($enum);
									
									$ends = substr($endn['ExamNo'],-4);
									
									#control the ending digits
									//single ending digit
									if(substr($ends,0,1)==0 AND substr($ends,1,1)==0 AND substr($ends,2,1)==0){
										$temp = (integer)substr($ends,-1);							
										$last = $temp + 1;						
							
										if($last>9){
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."00".$last;											
											}
										else{
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."000".$last;											
											}
									}
									//double ending digit
									if(substr($ends,0,1)==0 AND substr($ends,1,1)==0 AND substr($ends,2,1)!=0){
										$temp = (integer)substr($ends,-2);							
										$last = $temp + 1;						
							
										if($last>99){
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."0".$last;											
											}
										else{
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."00".$last;											
											}
									}
									//triple ending digit
									if(substr($ends,0,1)==0 AND substr($ends,1,1)!=0){
										$temp = (integer)substr($ends,-3);							
										$last = $temp + 1;						
							
										if($last>999){
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid.$last;											
											}
										else{
											$mid = substr($ayear,2,3);																		
											$xamno = $initial."/".$mid."0".$last;											
											}
									}
									//non-zero starting digit
									if(substr($ends,0,1)!=0){
										$temp = (integer)substr($ends,-4);							
										$last = $temp + 1;						
							
										$mid = substr($ayear,2,3);																		
										$xamno = $initial."/".$mid.$last;																						
									}

									$qinsrt = "INSERT INTO $tabl VALUES ('$regnos','$xamno','$entrys','$ayear','$sem')";
									$insrt = mysqli_query($zalongwa, $qinsrt);
									
									if($insrt){
										echo "$regnos has Examination number $xamno<br/>";										
										}
									else{
										echo "Duplicate entry for $regnos<br/>";										
										}
									}								
								}
							}
							
						else{
							
							mysqli_query($zalongwa, "DELETE FROM $tabl");
							/*for random generation of numbers
							 * $nux = mt_rand(1, $students);
							 * if(strlen($nux) == 1){ $nux = "000".$nux;}
							 * elseif(strlen($nux) == 2){ $nux = "00".$nux;}
							 * elseif(strlen($nux) == 3){ $nux = "0".$nux;}
							 * else{}
							*/
							
							$mid = substr($ayear,2,3);
							$xamno = $initial."/".$mid."0001";
							
							/*for randomization
							 * $xamno = $initial."/".$mid.$nux;
							 */
							$qinsrt = "INSERT INTO $tabl VALUES ('$regnos','$xamno','$entrys','$ayear','$sem')";
							$insrt = mysqli_query($zalongwa, $qinsrt);
							
							if($insrt){
								echo "$regnos has Examination number $xamno<br/>";										
								}
							else{
								echo "Duplicate entry for $regnos<br/>";										
								}
							}																										
						}
					}					
					$track += 1;
				}				
			}		
	}
			?>
			
		</div>
		
		<?php
		# include the footer
		include("../footer/footer.php");
	
?>
