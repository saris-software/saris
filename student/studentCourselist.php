<?php 
require_once('../Connections/sessioncontrol.php');
# include the header
include('studentMenu.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Academic Records';
	$szTitle = 'Exam Registration: Please Pick a Course';
	$szSubSection = 'Course Roster';
	include("studentheader.php");
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_courselist = 13;
$pageNum_courselist = 0;
if (isset($_GET['pageNum_courselist'])) {
  $pageNum_courselist = $_GET['pageNum_courselist'];
}
$startRow_courselist = $pageNum_courselist * $maxRows_courselist;
mysql_select_db($database_zalongwa, $zalongwa);
if (isset($_GET['course'])) {
  $key=$_GET['course'];
  $query_courselist = "SELECT CourseCode, CourseName, Units FROM course WHERE CourseCode Like '%$key%' ORDER BY CourseCode";
}else{
$query_courselist = "SELECT CourseCode, CourseName, Units FROM course ORDER BY CourseCode";
}

$query_limit_courselist = sprintf("%s LIMIT %d, %d", $query_courselist, $startRow_courselist, $maxRows_courselist);
$courselist = mysql_query($query_limit_courselist, $zalongwa) or die(mysql_error());
$row_courselist = mysql_fetch_assoc($courselist);

if (isset($_GET['totalRows_courselist'])) {
  $totalRows_courselist = $_GET['totalRows_courselist'];
} else {
  $all_courselist = mysql_query($query_courselist);
  $totalRows_courselist = mysql_num_rows($all_courselist);
}
$totalPages_courselist = ceil($totalRows_courselist/$maxRows_courselist)-1;

$queryString_courselist = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_courselist") == false && 
        stristr($param, "totalRows_courselist") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_courselist = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_courselist = sprintf("&totalRows_courselist=%d%s", $totalRows_courselist, $queryString_courselist);
 
?>
<table width="720" border="1" cellpadding="0" cellspacing="0">
            <tr>
			<td width="25">Pick </td>
              <td width="60">Course Code </td>
			  <td width="40">Units</td>
              <td width="444" nowrap>Course Description </td>
            </tr>
            <?php do { ?>
            <tr>
                <td><?php $CourseCode = $row_courselist['CourseCode']; echo "<a href=\"studentcourseregister.php?CourseCode=$CourseCode\"> Pick </a>"; ?></td>
				<td nowrap><?php echo $row_courselist['CourseCode']; ?></td>
                <td><?php echo $row_courselist['Units']; ?></td>
                <td><?php echo $row_courselist['CourseName']; ?></td>
            </tr>
            <?php } while ($row_courselist = mysql_fetch_assoc($courselist)); ?>
</table>
		    <p><a href="<?php printf("%s?pageNum_courselist=%d%s", $currentPage, max(0, $pageNum_courselist - 1), $queryString_courselist); ?>">Previous Page</a> <span class="style66"><span class="style1">....</span><span class="style34">Record: <span class="style67"><span class="style34"><?php echo min($startRow_courselist + $maxRows_courselist, $totalRows_courselist) ?></span></span> of <?php echo $totalRows_courselist ?> </span><span class="style1">......</span></span><a href="<?php printf("%s?pageNum_courselist=%d%s", $currentPage, min($totalPages_courselist, $pageNum_courselist + 1), $queryString_courselist); ?>">Next Page</a></p>
		    <form name="form1" method="get" action="studentCourselist.php">
              Search by Course Code
              <input name="course" type="text" id="course" maxlength="50">
              <input type="submit" name="Submit" value="Search">
            </form>
		   
<?php
mysql_free_result($courselist);
?>
