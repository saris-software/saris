<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Communication';
	$szSubSection = 'Check Message';
	$szTitle = 'Check Message';
	include('lecturerheader.php');

$maxRows_studentsuggestion = 1;
$pageNum_studentsuggestion = 0;
if (isset($_GET['pageNum_studentsuggestion'])) {
  $pageNum_studentsuggestion = $_GET['pageNum_studentsuggestion'];
}
$startRow_studentsuggestion = $pageNum_studentsuggestion * $maxRows_studentsuggestion;

$colname_studentsuggestion = "1";
if (isset($_COOKIE['RegNo'])) {
  $colname_studentsuggestion = (get_magic_quotes_gpc()) ? $_COOKIE['RegNo'] : addslashes($_COOKIE['RegNo']);
}
mysqli_select_db($database_zalongwa, $zalongwa);
//$query_studentsuggestion = "SELECT id, received, fromid, toid, message,replied FROM suggestion WHERE toid = 'admin' ORDER BY received DESC";
$query_studentsuggestion = "SELECT id, received, fromid, toid, message,replied FROM suggestion 
							WHERE (toid = '$RegNo' or toid = '$username' or toid=7) ORDER BY received DESC";
$query_limit_studentsuggestion = sprintf("%s LIMIT %d, %d", $query_studentsuggestion, $startRow_studentsuggestion, $maxRows_studentsuggestion);
$studentsuggestion = mysqli_query($zalongwa, $query_limit_studentsuggestion) or die(mysqli_error());
$row_studentsuggestion = mysqli_fetch_assoc($studentsuggestion);

if (isset($_GET['totalRows_studentsuggestion'])) {
  $totalRows_studentsuggestion = $_GET['totalRows_studentsuggestion'];
} else {
  $all_studentsuggestion = mysqli_query($query_studentsuggestion);
  $totalRows_studentsuggestion = mysqli_num_rows($all_studentsuggestion);
}
$totalPages_studentsuggestion = ceil($totalRows_studentsuggestion/$maxRows_studentsuggestion)-1;

$queryString_studentsuggestion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_studentsuggestion") == false && 
        stristr($param, "totalRows_studentsuggestion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_studentsuggestion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_studentsuggestion = sprintf("&totalRows_studentsuggestion=%d%s", $totalRows_studentsuggestion, $queryString_studentsuggestion);

?>
<table class="resView">
            <?php do { ?>
            
            <tr>
                <td class="resViewhd" width="66"><div align="right">Date:</div></td>
                <td class="resViewtd" width="593"><?php echo $row_studentsuggestion['received']; ?></td>
            </tr>
            <tr>
                <td class="resViewhd"><div align="right">From:</div></td>
                <td class="resViewtd"><?php $from=$row_studentsuggestion['fromid']; 

						  $id=$row_studentsuggestion['id']; 

								//select student
								$qstudent = "SELECT Name, RegNo, ProgrammeofStudy from student WHERE RegNo = '$from'";
								$dbstudent = mysqli_query($zalongwa, $qstudent) or die("Mwanafunzi huyu hana matokeo".  mysqli_error());

								if($rows = mysqli_num_rows($dbstudent) != 0){
									$row_result = mysqli_fetch_array($dbstudent);
									$name = $row_result['Name'];
									$regno = $row_result['RegNo'];
									$degree = $row_result['ProgrammeofStudy'];
									
									//get degree name
									$qdegree = "Select Title from programme where ProgrammeCode = '$degree'";
									$dbdegree = mysqli_query($zalongwa, $qdegree);
									$row_degree = mysqli_fetch_array($dbdegree);
									$programme = $row_degree['Title'];
									
									echo  "$name - $regno - $programme";	
									}
									
								else{
									$user = mysqli_query($zalongwa, "SELECT * FROM security WHERE RegNo='$from'");
									$user = mysqli_fetch_array($user);
									
									echo "$user[FullName]($user[UserName]) - $user[RegNo]";
									}	
							//echo $row_studentsuggestion['fromid'];

				 ?></td>
            </tr>
            <tr>
                <td class="resViewhd" valign="top"><div align="right">Message:</div></td>
                <td class="resViewtd"><?php echo $row_studentsuggestion['message']; ?></td>
            </tr>
			<tr>
                <td class="resViewhd" valign="top"><div align="right" class="style2" style="color:maroon">Comments:</div></td>
                <td class="resViewtd"><span class="style2"  style="color:maroon"><?php echo $row_studentsuggestion['replied']; ?></span></td>
            </tr>

            <?php } while ($row_studentsuggestion = mysqli_fetch_assoc($studentsuggestion)); ?>

</table>
<p><a href="<?php printf("%s?pageNum_studentsuggestion=%d%s", $currentPage, max(0, $pageNum_studentsuggestion - 1), $queryString_studentsuggestion); ?>">Previous</a> Message: <?php echo min($startRow_studentsuggestion + $maxRows_studentsuggestion, $totalRows_studentsuggestion) ?> of <?php echo $totalRows_studentsuggestion ?> <span class="style64 style1">...</span><a href="<?php printf("%s?pageNum_studentsuggestion=%d%s", $currentPage, min($totalPages_studentsuggestion, $pageNum_studentsuggestion + 1), $queryString_studentsuggestion); ?>">Next</a> <span class="style64 style1">.......</span><?php echo "<a href=\"admissionSuggestionBox.php?from=$from&id=$id\">Reply Message</a>" ?></p>
       
<?php

include('../footer/footer.php');
mysqli_free_result($studentsuggestion);
?>
