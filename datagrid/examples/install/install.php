<?php

    require_once("settings.inc");    
    
    if (file_exists($config_file_path)) {        
		header("location: ".$application_start_file);
        exit;
	}
	
      
?>	


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Installation Guide</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" type="text/css" href="img/styles.css">
</head>


<BODY text=#000000 vLink=#2971c1 aLink=#2971c1 link=#2971c1 bgColor=#ffffff>
    
<TABLE align="center" width="70%" cellSpacing=0 cellPadding=2 border=0>
<TBODY>
<TR>
    <TD class=text vAlign=top>
        <H2>Installation of <?=$application_name;?> examples!</H2>

        <fieldset>
			<legend>Follow the wizard to setup your database.</legend>
			<br>
			<TABLE width="100%" cellSpacing=0 cellPadding=0 border=0>
			<TBODY>
			<TR>
				<TD class=text align=left>
					<b>Step 1. Database Import</b>
				</td>
			</tr>
			</tbody>
			</table>
			<br />
			
			<form method="post" action="install2.php">
			<input type="hidden" name="submit" value="step2" />  
			<table class=text width="100%" border="0" cellspacing="0" cellpadding="2" class="main_text">
			<tr>
				<tr>
					<td>&nbsp;Database Host</td>
					<td>
						<input type="text" class="form_text" name="database_host" value='localhost' size="30">
					</td>
				</tr>
				<tr>
					<td>&nbsp;Database Name</td>
					<td>
						<input type="text" class="form_text" name="database_name" size="30" value="">
					</td>
				</tr>
				<tr>
					<td>&nbsp;Database Username</td>
					<td>
						<input type="text" class="form_text" name="database_username" size="30" value="">
					</td>
				</tr>
				<tr>
					<td>&nbsp;Database Password</td>
					<td>
						<input type="text" class="form_text" name="database_password" size="30" value="">
					</td>
				</tr>
				<tr>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td colspan=2 align='left'>
						<input type="button" class="form_button" name="btn_cancel" value="Cancel" onclick="document.location.href='../index.php'">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" class="form_button" name="btn_submit" value="Continue">
					</td>
				</tr>
			
			</table>
			</form>                        
			<br />						
		</fieldset>
                
        <? include_once("footer.php"); ?>        
    </TD>
</TR>
</TBODY>
</TABLE>
                  
</body>
</html>
