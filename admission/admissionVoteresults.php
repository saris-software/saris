<?php
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	# include the header
	include('admissionMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'E-Voting System';
	$szTitle = 'Election Results';
	$szSubSection = 'Election Results';
	include("admissionheader.php");

	#populate academic year combo box
	mysqlI_select_db($database_zalongwa, $zalongwa);
	$query_AYear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
	$AYear = mysqlI_query($zalongwa, $query_AYear) or die(mysqli_error($zalongwa));
	$row_AYear = mysqli_fetch_assoc($AYear);

	mysqli_select_db($database_zalongwa, $zalongwa);
	$query_post = "SELECT * FROM electionpost ORDER BY Post ASC";
	$post = mysqli_query($zalongwa, $query_post) or die(mysqli_error($zalongwa));
	$row_post = mysqli_fetch_assoc($post);
	$totalRows_post = mysqli_num_rows($post);

	if (isset($_POST["add"])) {
		$key = addslashes($_POST["Year"]);
		$post = addslashes($_POST["cmbPost"]);
		# updating examresult regnos

		#get all candidates
		$qexamno = "SELECT el.id, el.RegNo,el.Post,el.Faculty,el.Institution,el.Period,st.Name 
					FROM electioncandidate el, student st 
					WHERE (st.RegNo=el.RegNo) AND (el.Period='$key') AND (el.Post='$post')
					ORDER BY el.Period,el.Post, st.Name DESC";
		$dbexamno = mysqli_query($zalongwa, $qexamno);
		$totalrec = mysqli_num_rows($dbexamno);

		if ($totalrec>0){
			
			echo "<table border='1' cellpadding='3' cellspacing='0'>
				  <tr>
					<th>SNo</th>
					<th>Period</th>
					<th>RegNo</th>
					<th>Candidate</th>
					<th>Post</th>
					<th>Faculty</th>
					<th>Institution</th>
					<th>Votes</th>
				  </tr>";
			
			$index = 1;
			while ($row_examno = mysqli_fetch_assoc($dbexamno)){
				$candidateid = trim($row_examno['id']);
				$period = trim($row_examno['Period']);
				$regno = trim($row_examno['RegNo']);
				$name = trim($row_examno['Name']);
				$post= trim($row_examno['Post']);
				$faculty = trim($row_examno['Faculty']);
				$inst= trim($row_examno['Institution']);
				#count votes
				$qvote = "select * from electionvotes where CandidateID='$candidateid'";
				$dbvote =mysqli_query($zalongwa, $qvote);
				$vote = mysqli_num_rows($dbvote);
				
				echo "<tr>
						<td nowrap>$index</td>
						<td nowrap>$period</td>
						<td nowrap>$regno</td>
						<td nowrap>$name</td>
						<td nowrap>$post</td>
						<td nowrap>$faculty</td>
						<td nowrap>$inst</td>
						<td nowrap>$vote</td>
					</tr>";
				$index++;
				}
			}
		else{
			echo 'No electionresults for this year - '.$key;
			}
		echo "</table>";
		}

	else{
		?>
		<fieldset>
			<legend>Select Appropriate Entries</legend>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="frmAyear" target="_self">
				<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
				  <tr>
					<th scope="row" nowrap><div align="right"> Year:</div>
					</th>
					<td><select name="Year" size="1" required>
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
					<option value="<?php echo $row_post['Post']?>"><?php echo $row_post['Post']?></option>
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
					<th scope="row"><div align="right"></div></th>
					<td><input name="add" type="submit" value="Search"></td>
				  </tr>
				</table>
							
				</form>			
		 </fieldset>
		 <?php
		 } 
		 ?>
