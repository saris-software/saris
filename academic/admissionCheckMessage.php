<?php 

#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');

	
	# initialise globals
//	include('lecturerMenu.php');
	include("communication.php");


	# include the header
	global $szSection, $szSubSection;

	$szSection = 'Communication';
	$szSubSection = 'Check Message';
	$szTitle = 'Check Message';

//	include('lecturerheader.php');


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

mysqli_select_db($zalongwa, $database_zalongwa);

$query_studentsuggestion = "SELECT id, received, fromid, toid, message,replied FROM suggestion 
							WHERE toid = '$RegNo' or toid = '$username' or toid=1 ORDER BY received DESC";

$query_limit_studentsuggestion = sprintf("%s LIMIT %d, %d", $query_studentsuggestion, $startRow_studentsuggestion, $maxRows_studentsuggestion);
$studentsuggestion = mysqli_query($zalongwa, $query_limit_studentsuggestion) or die(mysqli_error($zalongwa));
$row_studentsuggestion = mysqli_fetch_assoc($studentsuggestion);


if (isset($_GET['totalRows_studentsuggestion'])) {
  $totalRows_studentsuggestion = $_GET['totalRows_studentsuggestion'];
} 
else {
  $all_studentsuggestion = mysqli_query($zalongwa, $query_studentsuggestion);
  $totalRows_studentsuggestion = mysqli_num_rows($all_studentsuggestion);
}

$totalPages_studentsuggestion = ceil($totalRows_studentsuggestion/$maxRows_studentsuggestion)-1;


$queryString_studentsuggestion = "";

if (!empty($_SERVER['QUERY_STRING'])) {

  $params = explode("&", $_SERVER['QUERY_STRING']);

  $newParams = array();

  foreach ($params as $param) {
    if (stristr($param, "pageNum_studentsuggestion") == false && stristr($param, "totalRows_studentsuggestion") == false) {
      array_push($newParams, $param);
    }
  }

  if (count($newParams) != 0) {
    $queryString_studentsuggestion = "&" . htmlentities(implode("&", $newParams));
  }

}

$queryString_studentsuggestion = sprintf("&totalRows_studentsuggestion=%d%s", $totalRows_studentsuggestion, $queryString_studentsuggestion);


?>


<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div align select="center">
<div class="container" style="width:60%">



 <table class="table table-striped">
    <thead>
      <tr>
        <th style="width:10%">Date</th>
        <th style="width:15%">From</th>
        <th style="width:50%">Message</th>
        <th style="width:20%">Comments</th>
       <th>Reply Message</th>
      </tr>
    </thead>

            <?php do { ?>


            <tr>
                <td width="593"><?php echo $row_studentsuggestion['received']; ?></td>
            
                <td><?php $from=$row_studentsuggestion['fromid']; 

						  $id=$row_studentsuggestion['id']; 

								//select student
								$qstudent = "SELECT Name, RegNo, ProgrammeofStudy from student WHERE RegNo = '$from'";
								$dbstudent = mysqli_query($zalongwa, $qstudent) or die("Mwanafunzi huyu hana matokeo".  mysqli_error($zalongwa));

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

                <td><?php echo $row_studentsuggestion['message']; ?></td>
                <td><span class="style2"  style="color:maroon"><?php echo $row_studentsuggestion['replied']; ?></span></td>
            <td><button class="btn btn-outline-dark"><span class="style64 style1"></span><?php echo "<a href=\"admissionSuggestionBox.php?from=$from&id=$id\">Reply Message</a>" ?></button></td>
            </tr>

            <?php } while ($row_studentsuggestion = mysqli_fetch_assoc($studentsuggestion)); ?>

</table>

<button class="btn btn-outline-dark"><a href="<?php printf("%s?pageNum_studentsuggestion=%d%s", $currentPage, max(0, $pageNum_studentsuggestion - 1), $queryString_studentsuggestion); ?>">Previous</a></button>
 Message: <?php echo min($startRow_studentsuggestion + $maxRows_studentsuggestion, $totalRows_studentsuggestion) ?> of <?php echo $totalRows_studentsuggestion ?> <span class="style64 style1">...</span>
 <button class="btn btn-outline-dark"><a href="<?php printf("%s?pageNum_studentsuggestion=%d%s", $currentPage, min($totalPages_studentsuggestion, $pageNum_studentsuggestion + 1), $queryString_studentsuggestion); ?>">Next</a></button> 

       

<?php



include('../footer/footer.php');

mysqli_free_result($studentsuggestion);

?>



