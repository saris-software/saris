<?php 
#get connected to the database and verfy current session
	
	$szSection = 'Communication';
	include('admissionheader.php');

if (isset($_GET['pageNum_studentsuggestion'])) {
$startRow_studentsuggestion = $pageNum_studentsuggestion * $maxRows_studentsuggestion;

$colname_studentsuggestion = "1";
if (isset($_COOKIE['RegNo'])) {
mysql_select_db($database_zalongwa, $zalongwa);
							WHERE toid = '$RegNo' or toid = '$username' or toid=2 ORDER BY received DESC";
$query_limit_studentsuggestion = sprintf("%s LIMIT %d, %d", $query_studentsuggestion, $startRow_studentsuggestion, $maxRows_studentsuggestion);

if (isset($_GET['totalRows_studentsuggestion'])) {
$totalPages_studentsuggestion = ceil($totalRows_studentsuggestion/$maxRows_studentsuggestion)-1;

if (!empty($_SERVER['QUERY_STRING'])) {
  foreach ($params as $param) {
  if (count($newParams) != 0) {
$queryString_studentsuggestion = sprintf("&totalRows_studentsuggestion=%d%s", $totalRows_studentsuggestion, $queryString_studentsuggestion);
?>

            <?php do { ?>
						  $id=$row_studentsuggestion['id']; 
								//select student
								$qstudent = "SELECT Name, RegNo, ProgrammeofStudy from student WHERE RegNo = '$from'";
								$dbstudent = mysql_query($qstudent) or die("This student has no results".  mysql_error()); 
								if($rows = mysql_num_rows($dbstudent) != 0){
									$row_result = mysql_fetch_array($dbstudent);
									$name = $row_result['Name'];
									$regno = $row_result['RegNo'];
									$degree = $row_result['ProgrammeofStudy'];
									
									//get degree name
									$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
									$dbdegree = mysql_query($qdegree);
									$row_degree = mysql_fetch_array($dbdegree);
									$programme = $row_degree['Title'];
									
									echo  "$name - $regno - $programme";	
									}
									
								else{
									$user = mysql_query("SELECT * FROM security WHERE RegNo='$from'");
									$user = mysql_fetch_array($user);
									
									echo "$user[FullName]($user[UserName]) - $user[RegNo]";
									}	
							//echo $row_studentsuggestion['fromid'];
				 ?></td>
            </tr>
            <tr>
                <td valign="top"><div align="right">Message:</div></td>
                <td><?php echo $row_studentsuggestion['message']; ?></td>
            </tr>
			<tr>
                <td valign="top"><div align="right" style="color:maroon">Comments:</div></td>
                <td><span style="color:maroon"><?php echo $row_studentsuggestion['replied']; ?></span></td>
            </tr>
            <?php } while ($row_studentsuggestion = mysql_fetch_assoc($studentsuggestion)); ?>
</table>
<p><a href="<?php printf("%s?pageNum_studentsuggestion=%d%s", $currentPage, max(0, $pageNum_studentsuggestion - 1), $queryString_studentsuggestion); ?>">Previous</a>
       
<?php
?>