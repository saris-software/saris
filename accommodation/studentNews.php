<?php 
#get connected to the database and verfy current session
	# initialise globals
	# include the header
	$szSection = 'Communication';
	include('admissionheader.php');

if (isset($_GET['pageNum_studentsuggestion'])) {
$startRow_studentsuggestion = $pageNum_studentsuggestion * $maxRows_studentsuggestion;

$colname_studentsuggestion = "1";
if (isset($_COOKIE['RegNo'])) {
mysql_select_db($database_zalongwa, $zalongwa);

$totalPages_studentsuggestion = ceil($totalRows_studentsuggestion/$maxRows_studentsuggestion)-1;
$queryString_studentsuggestion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  foreach ($params as $param) {
    if (stristr($param, "pageNum_studentsuggestion") == false && stristr($param, "totalRows_studentsuggestion") == false) {
  if (count($newParams) != 0) {
$queryString_studentsuggestion = sprintf("&totalRows_studentsuggestion=%d%s", $totalRows_studentsuggestion, $queryString_studentsuggestion);

?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>To Add News, Click:
<a href="admissionPostNews.php">Publish News and or Events</a><hr><table width="721" border="1" cellpadding="0" cellspacing="0">
            <?php do { ?>
            <tr>
		    <p><a href="<?php printf("%s?pageNum_studentsuggestion=%d%s", $currentPage, max(0, $pageNum_studentsuggestion - 1), $queryString_studentsuggestion); ?>">Previous</a> 
<?php
include('../footer/footer.php');
?>