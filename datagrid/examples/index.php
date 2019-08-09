<?php

    require_once("install/settings.inc");    

	$config_file_exists = false;
    if(file_exists("install/".$config_file_path)) {
		$config_file_exists = true;
	}
	
        
    ob_start();
    phpinfo(-1);
    $phpinfo = array('phpinfo' => array());
    if(preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER))
    foreach($matches as $match){
        if(strlen($match[1]))
            $phpinfo[$match[1]] = array();
        elseif(isset($match[3]))
            $phpinfo[end(array_keys($phpinfo))][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
        else
            $phpinfo[end(array_keys($phpinfo))][] = $match[2];
    }

    
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Installation Guide</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" type="text/css" href="install/img/styles.css">
</head>
<BODY text=#000000 vLink=#2971c1 aLink=#2971c1 link=#2971c1 bgColor=#ffffff>
    
<?php if(!$config_file_exists){ ?>
<TABLE align="center" width="70%" cellSpacing=0 cellPadding=2 border=0>
<TBODY>
<TR>
    <TD class=text vAlign=top>
		<H2>Welcome to ApPHP!</H2>
        <H2>This is the installation wizard of <?php echo $application_name;?> examples</H2>
		You have 2 possibilities to install examples: with wizard or manually.
		Please select a type suitable for your.
		<BR><BR>
        
        <fieldset>
		<legend>Using this installation wizard</legend>
			<h3 id="post-1">Follow the wizard to setup your database.</h3>  
			<TABLE width="100%" cellSpacing=0 cellPadding=0 border=0>
			<TBODY>
			<TR>
				<TD class=text align=left>
					<b>Getting System Info</b>
				</TD>
			</TR>
			<tr>
				<TD class=text align=left>
					<UL>
						<LI>System: <?php $phpinfo['phpinfo']['System'];?></li>                                    
						<LI>PHP version: <?php echo (isset($phpinfo['phpinfo']['PHP Version']) ? $phpinfo['phpinfo']['PHP Version'] : "");?></li>
						<LI>Server API: <?php $phpinfo['phpinfo']['Server API'];?></li>
						<LI>Safe Mode: <?php echo (isset($phpinfo['PHP Core']['safe_mode'][0]) ? $phpinfo['PHP Core']['safe_mode'][0] : "");?></li>
					</UL>
				</TD>
			</TR>
			<TR>
				<TD class=text align=left>
					Click on Start button to continue &nbsp;
					<input type="button" class="form_button" value="Start" name="submit" title="Click to start installation" onclick="document.location.href='install/install.php'">					
				</TD>
			</TR>
			</TBODY>
			</TABLE>
			
		</fieldset>
		
		<fieldset>
		<legend>Manually</legend>
		<div>
			<h3 id="post-1">Installation of PHP DataGrid</h3>  
			<div class="storycontent">
			
			To run these examples:<br><br>
			
			1. Create database and user, and assign this user to the database. Give him permissions
			   all needed permissions: INSERT< SELECT etc.. Write down the name of the database, username,
			   and password for the database installation procedure.<br><br>
			
			2. After database and user were created, import SQL Dump.sql
				(<font color='#a60000'><b>it found here: sql/db_dump.sql</b></font>) to create 
				example tables in your database.<br><br>
			
			3. Before running any example - change these default parameters on yours 
			   (saved on step 1):<br><br>
				
				$DB_USER='username'; <br>           
				$DB_PASS='password';     <br>      
				$DB_HOST='localhost';      <br> 
				$DB_NAME='database_name';<br><br>
				
			4. Enjoy!!!	<br>
		
			</div>
		
		</div>
		</div>
		</fieldset>
		

        <?php include_once("install/footer.php"); ?>        
    </TD>
</TR>
</TBODY>
</TABLE>
<?php }else{ ?>

<pre>
<h3 align="center">EXAMPLES INDEX</h3>

<table width="80%" border="0" align="center" cellspacing="5">
<tr valign='top'>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 1-1</b></legend>
			<b>Simplest PHP DG code</b> (<a href="code_1_1_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			--------------------------------<br />
			1. All modes (Add/Edit/Details/Delete/View).<br />
			2. Auto-Genereted colimns.<br />
		</fieldset>
	</td>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 1-2</b></legend>
			<b>Simple PHP DG code</b> (<a href="code_1_2_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			--------------------------------<br />
			1. All modes (Add/Edit/Details/Delete/View).<br />
			2. All features.<br />
			3. Two DataGrids on one page.<br />
		</fieldset>		
	</td>
</tr>

<tr valign='top'>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 2-1</b></legend>
			<b>Advanced PHP DG code</b> (<a href="code_2_1_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			--------------------------------    <br />
			1. All modes (Add/Edit/Details/Delete/View).<br />
			2. All features.<br />
			3. Many types of fields.<br />
			4. Image magnifying feature.<br />
			5. WYSIWYG editor.<br />
		</fieldset>				
	</td>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 2-2</b></legend>
			<b>Advanced PHP DG code</b> (<a href="code_2_2_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			--------------------------------    <br />
			1. All modes (Add/Edit/Details/Delete/View).<br />
			2. All features.<br />
			3. Inline editing.		<br />
			4. Filter automplete feature.		<br />	
		</fieldset>				
	</td>
</tr>

<tr valign='top'>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 2-3</b></legend>
			<b>Advanced PHP DG code</b> (<a href="code_2_3_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			--------------------------------    <br />
			1. All modes (Add/Edit/Details/Delete/View).<br />
			2. All features.<br />
			3. One DataGrid divided into 2 parts with different styles.<br />
		</fieldset>				
	</td>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 2-4</b></legend>
			<b>Advanced PHP DG code</b><br />
			--------------------------------    <br />
			1. All modes (Add/Edit/Details/Delete/View). (<a href="code_2_4_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			2. All features.<br />
			3. Two DataGrids on one page.<br />
			4. Customized layout in details mode.<br />
		</fieldset>				
	</td>
</tr>

<tr valign='top'>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 2-5</b></legend>
			<b>Advanced PHP DG code</b> (<a href="code_2_5_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			--------------------------------    <br />
			1. View Mode.<br />
			2. Using DataGrids for displaying some statistical data.    <br />
		</fieldset>				
	</td>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 2-6</b></legend>
			<b>Advanced PHP DG code - <br />Master/Detail DataGrid Structure</b> (<a href="code_2_6_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			--------------------------------    <br />
			1. Master DataGrid in View Mode.<br />
			2. Second Datagrid in all Modes<br /><br />
		</fieldset>				
	</td>
</tr>

<tr valign='top'>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 2-7</b></legend>
			<b>Advanced PHP DG code</b> (<a href="code_2_7_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			--------------------------------    <br />
			1. All modes (Add/Edit/Details/Delete/View).<br />
			2. All features.<br />
			3. Tabular(inline) layout for filtering.<br />
			4. AJAX sorting and paging.    <br />
		</fieldset>				
	</td>
	<td>
		<fieldset class='big'>
			<legend class='big'><b>Sample 2-8</b></legend>
			<b>Advanced PHP DG code</b> (<a href="code_2_8_example.php" class="blue"><b>See this Example &raquo;</b></a>)<br />
			--------------------------------    <br />
			1. Modes: Add/Edit/Details/View. <br />
			2. Customized layout in View Mode.     <br />
		</fieldset>				
	</td>
</tr>
</table>
</pre>

<?php } ?>
</body>
</html>

