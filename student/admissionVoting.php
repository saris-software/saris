<?php
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# include the header
	include('studentMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'E-Voting';
	$szTitle = 'Election Voting';
	$szSubSection = 'Election Voting';
	include("studentheader.php");

	#populate academic year combo box
	mysqli_select_db($zalongwa, $database_zalongwa);
	$query_AYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
	$AYear = mysqli_query($zalongwa, $query_AYear) or die(mysqli_error($zalongwa));
	$row_AYear = mysqli_fetch_assoc($AYear);

	mysqli_select_db($zalongwa, $database_zalongwa);
	$query_post = "SELECT * FROM electionpost ORDER BY Post ASC";
	$post = mysqli_query($zalongwa, $query_post) or die(mysqli_error($zalongwa));
	$row_post = mysqli_fetch_assoc($post);
	$totalRows_post = mysqli_num_rows($post);

	if (isset($_POST["save"])) {
		$values = addslashes($_POST["Candidate"]);
		$value_arr = explode('[',$values);
		
		#print_r($value_arr);exit;
		$name = $value_arr[0];
		$key = $value_arr[1];
		$postid = $value_arr[2];
		
		$get_postName = mysqli_query("SELECT Post FROM electionpost WHERE Id='$postid'");
		list($post) = mysqli_fetch_array($get_postName);
		
		#get student faculty
		$qfac = "SELECT Faculty from student where RegNo='$RegNo'";
		$dbfac = mysqli_query($zalongwa,$qfac);
		$row_fac = mysqli_fetch_assoc($dbfac);
		$stdfac = $row_fac['Faculty'];
		
		if(@mysqli_num_rows($dbfac)<1){
			$error = urlencode("You are not a student, you are not allowed to vote");
			$url = "admissionVoting.php?error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
			exit;
			}

		$qcandfac = "SELECT Faculty FROM electioncandidate WHERE regno = '$name'";
		$dbcandfac = mysqli_query($zalongwa,$qcandfac);
		@$row_candfac = mysqli_fetch_assoc($dbcandfac);
		$candfac = $row_candfac['Faculty'];
		
		#insert vote
		if ($name==''){
			$error = urlencode("Invalid Vote Entries, Please select appropriate values");
			$url = "admissionVoting.php?error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
			exit;
			}
		elseif($candfac == $stdfac) {
			$qins = "INSERT INTO electionvotes VALUES('$RegNo','$name','$key','$post')";
			$dbins = mysqli_query($zalongwa,$qins) or die('Rejected, ZALONGWA Knows that you are attempting to vote once more!');
			
			echo '<script language="javascript">alert("Vote Recieved");</script>';
			}
		elseif($candfac == '[All Faculties]') {
			$qins = "INSERT INTO electionvotes VALUES('$RegNo','$name','$key','$post')";
			$dbins = mysqli_query($zalongwa,$qins) or die('Rejected, ZALONGWA Knows that you are attempting to vote once more!');
			
			echo '<script language="javascript">alert("Vote Recieved");</script>';
			}
		else{
			$error = urlencode("Rejected, The Candidate You are Voting for Does not Belong to your Faculty");
			$url = "admissionVoting.php?error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
			exit;
			}
		}

	#step two for voting
	if (isset($_POST["add"])) {
		$key = addslashes($_POST["Year"]);
		$post = addslashes($_POST["cmbPost"]);
		
		#chek if has already voted for this post
		$qpost = "SELECT RegNo FROM electionvotes WHERE RegNo='$RegNo' AND Period='$key' 
				  AND Post IN (SELECT Post FROM electionpost WHERE Id='$post')";
		$dbpost = mysqli_query($zalongwa,$qpost);
		$total_rows = mysqli_num_rows($dbpost);
		
		#check expired election
		$qedate = "SELECT * FROM electiondate where PostId='$post' AND Period='$key'";
		$dbedate = mysqli_query($zalongwa, $qedate);
		$row_edate = mysqli_fetch_assoc($dbedate);
		$enddate = $row_edate['EndDate'];
		$today = date("Y-m-d H:i:s");
		
		#get student faculty
		$qfac = "SELECT Faculty from student where RegNo='$RegNo'";
		$dbfac = mysqli_query($zalongwa, $qfac);
		$row_fac = mysqli_fetch_assoc($dbfac);
		$stdfac = $row_fac['Faculty'];

		if($today>$enddate && mysqli_num_rows($dbedate)>'0'){
			echo 'Election Days Expired! <br>';
			echo 'Here are the Election Results';
			#get all candidates
			$qexamno = "SELECT el.id, el.RegNo,el.Post,el.Faculty,el.Institution,el.Period,el.Photo,el.Size,st.Name 
						FROM electioncandidate el, student st 
						WHERE (st.RegNo=el.RegNo) AND (el.Period='$key') AND 
						el.Post IN (SELECT Post FROM electionpost WHERE Id='$post')
						ORDER BY el.Period,el.Post, st.Name DESC";
						
			$dbexamno = mysqli_query($zalongwa, $qexamno);
			$totalrec = mysqli_num_rows($dbexamno);
			
			if ($totalrec>0){
				echo "<table border=1 cellpadding='3' cellspacing='0'>
					  <tr>
						<td><strong>SNo</strong></td>
						<td><strong>Period</strong></td>
						<td><strong>Candidate</strong></td>
						<td><strong>Post</strong></td>
						<td><strong>Faculty</strong></td>
						<td><strong>Campus</strong></td>
						<td><strong>Votes</strong></td>
					  </tr>";
				
				$int = 1;
				while ($row_examno = mysqli_fetch_assoc($dbexamno)){
					if(($row_examno['Faculty']=="[All Faculties]") || ($row_examno['Faculty']==$stdfac)){
						$candidateid = trim($row_examno['id']);
						
						#count votes
						$qvote = "select * from electionvotes where CandidateID='$candidateid'";
						$dbvote =mysqli_query($zalongwa, $qvote);
						$vote = mysqli_num_rows($dbvote);
						
						echo "<tr>
								<td nowrap>$int</td>
								<td nowrap>$row_examno[Period]</td>
								<td nowrap>$row_examno[Name]</td>
								<td nowrap>$row_examno[Post]</td>
								<td nowrap>$row_examno[Faculty]</td>
								<td nowrap>$row_examno[Institution]</td>
								<td nowrap>$vote</td>
							  </tr>";
						 $int++;
						 }
					 }
				echo "</table>";
				}
			else{
				echo '<br/>No election results for this year - '.$key;
				}
			exit;
			}
		
		elseif($today>$enddate && mysqli_num_rows($dbedate)<'1'){
			echo "<p style='color:maroon'>Sorry, There was no election monitored by the system in $key</p>";
			exit;
			}
			
		elseif($total_rows>0){
			$qpostname = mysqli_query("SELECT Post FROM electionpost WHERE Id='$post'");
			list($postname) = mysqli_fetch_array($qpostname);
			
			$error = urlencode("You have already Voted for the <b>$postname</b> post");
			$url = "admissionVoting.php?error=$error";
			echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
			exit;
			}

		#get all candidates
		$qcandidate = "SELECT el.id, el.RegNo,el.Post,el.Faculty,el.Institution,el.Period,el.Photo,el.Size,st.Name 
						FROM electioncandidate el, student st 
						WHERE (st.RegNo=el.RegNo) AND (el.Period='$key') AND 
						el.Post IN (SELECT Post FROM electionpost WHERE Id='$post')
						ORDER BY el.Period,el.Post, st.Name DESC";
		$dbcandidate = mysqli_query($zalongwa,$qcandidate);
		$totalrec = mysqli_num_rows($dbcandidate);

		if ($totalrec>0){
			
			echo "<table border='1' cellpadding='3' cellspacing='0'>				  
				  <tr><th colspan='8' align='center' bgcolor='#cccccc'>Step 2: Cast your vote</th></tr>
				  <tr>
					<td><strong>SNo</strong></td>
					<td><strong>RegNo</strong></td>
					<td><strong>Name</strong></td>
					<td><strong>Post</strong></td>
					<td><strong>Faculty</strong></td>					
					<td><strong>Period</strong></td>
					<td><strong>Photo</strong></td>
					<td><strong>Vote</strong></td>
				  </tr>";
			
			$index=1;
			while($results = mysqli_fetch_array($dbcandidate)){
				
				if(($results['Faculty']=="[All Faculties]") || ($results['Faculty']==$stdfac)){
					$id = $results['RegNo'].'['.$results['Period'];
					$vier = $results['RegNo'].'['.$key.'['.$post;
					
					echo "<form action='admissionVoting.php' method='post'>
						  <tr>
							<td nowrap>$index</td>
							<td nowrap>$results[RegNo]</td>
							<td nowrap>$results[Name]</td>
							<td nowrap>$results[Post]</td>
							<td nowrap>$results[Faculty]</td>						
							<td nowrap>$results[Period]</td>
							<td><img src='../admission/img.php?id=".$id."' height='120' width='100'></td>
							<td>
								<input name='Candidate' type='hidden' value='".$vier."'>
								<input name='save' type='submit' value='Vote'>							
							</td>
						 </tr>
						 </form>";
						 #
					$index++;
					}
				}
			 }
			 
		 else{
			 echo 'No election for this year - '.$key;
			 }
		
		echo "</table>";
		}
	
	else{
	?>
		<fieldset>
			<legend>Step 1: Select Period and Post</legend>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="frmAyear" target="_self">
				<table width="200" border="1" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
				  <tr>
					<th scope="row" nowrap><div align="right"> Year:</div>
					</th>
					<td><select name="Year" size="1"  required>
					<option value="">[Select Year]</option>
					<?php
						do {  
								?>
								<option value="<?php echo $row_AYear['AYear']?>"><?php echo $row_AYear['AYear']?></option>
								<?php
									} while ($row_AYear = mysqli_fetch_assoc($AYear));
											$rows = mysqli_num_rows($AYear);
											if($rows > 0) {
								mysqli_data_seek($AYear, 0);
								$row_AYear = mysqli_fetch_assoc($AYear);
							}
					   ?>
					
					</select></td>
				  </tr>
				  <tr bgcolor="#CCCCCC">
			  <th nowrap scope="row"><div align="right">Post:</div></th>
			  <td><select name="cmbPost" id="cmbPost" title="<?php echo $row_post['Post']; ?>" required>
				<?php
		do {  
		?>
				<option value="<?php echo $row_post['Id']?>"><?php echo $row_post['Post']?></option>
				<?php
		} while ($row_post = mysqli_fetch_assoc($post));
		  $rows = mysqli_num_rows($post);
		  if($rows > 0) {
			  mysqli_data_seek($post, 0);
			  $row_post = mysqli_fetch_assoc($post);
		  }
		?>
			  </select></td>
			</tr>

				  <tr>
					<td colspan='2' align='center'><input name="add" type="submit" value="Next"></td>
				  </tr>
				</table>
							
				</form>			
		 </fieldset>
		 <?php 
		
		 if(isset($_GET['error'])){
			 $error = urldecode($_GET['error']);
			 echo "<p style='color:maroon'>$error</p>";
			 }
		 }
	 ?>
