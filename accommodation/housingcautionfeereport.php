<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Financial Reports';
	$szSubSection = 'Caution Fees';
	$szTitle = 'Financial Reports';
	include('admissionheader.php');

if (isset($_POST["candidate"])){
$key=$_POST['candidate'];
mysqli_select_db($zalongwa,$database_zalongwa);
$query_candidate = "SELECT Name, RegNo FROM student WHERE Name LIKE '%$key%' OR RegNo LIKE '%$key%' ORDER BY Name";
$candidate = mysqli_query($zalongwa,$query_candidate) or die(mysqli_error());
$row_candidate = mysqli_fetch_assoc($candidate);
$totalRows_candidate = mysqli_num_rows($candidate);
 }

?>


            <form name="form1" method="post" action="/accommodation/housingcautionfeereport.php">
              <table width="365" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="150" nowrap><div align="left">Search Candidate:</div></td>
                  <td width="215" nowrap><div align="right">
                    <input name="candidate" type="text" id="candidate">
                    <input name="search" type="submit" id="search" value="Search">
                  </div></td>
                </tr>
                <tr>
                  <td colspan="2">                        <div align="left"></div></td>
                </tr>
              </table>
            </form>
            
            <?php if (@$totalRows_candidate > 0) { // Show if recordset not empty ?>
            <table width="200" border="1" cellpadding="0" cellspacing="0">
              <tr>
                <td><strong>Candidate</strong></td>
                <td><strong>RegNo</strong></td>
                <td nowrap><strong>Caution Fee </strong></td>
                <td nowrap><strong>Charge Penalty </strong></td>
              </tr>
              <?php do { ?>
              <tr>
                <td nowrap><?php echo @$row_candidate['Name']; ?></td>
                <td nowrap><?php $RegNo=@$row_candidate['RegNo']; echo $RegNo; ?></td>
                <td nowrap><?php print "<a href=\"housingcautionfee.php?RegNo=$RegNo\">Add Caution Fees</a>";?></td>
                <td nowrap><?php print "<a href=\"housingcautionfeepenalty.php?RegNo=$RegNo\">Add Penalty Charge </a>";?></td>
              </tr>
              <?php } while ($row_candidate = @mysqli_fetch_assoc($candidate)); ?>
</table>
            <?php } // Show if recordset not empty ?>
            
<?php
@mysqli_free_result($candidate);
?>
