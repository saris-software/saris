<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    # initialise globals
	include('../administrator/administratorMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Database Maintenance';
	$szSubSection = 'Import Data';
	$szTitle = 'Restore/Import MySQL Database Data Dumps';
	include('../administrator/administratorheader.php');
	
	# migrate data
	//include 'datamigration.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<style type="text/css">
<!--
.style1 {color: #990000}
-->
</style>
<head> 
<title>zalongwa database maintenance</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
</head> 

<body> 
     <form enctype="multipart/form-data" action="upload.php" method="post">
                   <table width="512" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="156" nowrap scope="row">
      <input type="hidden" name="MAX_FILE_SIZE" value="55646039">
      Choose File:</th>
                      <td colspan="2" nowrap><input name="userfile" type="file" size="40">
                    </tr>
                    <tr>
                      <th scope="row">&nbsp;</th>
                      <td width="153"><input type="submit" value="Send File"></td>
                      <td width="232">
                        <input type="reset" name="Reset" value="Reset"></td>
                    </tr>
                  </table>
                  <p>&nbsp;              </p>
                  <p>&nbsp;              </p>
</form>
			<?php
				# include the footer
	include('../footer/footer.php');
	?></body> 
</html>