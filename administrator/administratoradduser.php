<?php 
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('administratorMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Manage Users';
	$szSubSection = '';
	$szTitle = 'List of Database Users';
	include('administratorheader.php');


#populate module combo box
	$query_module = "SELECT moduleid, modulename FROM modules";
	$module = mysqli_query($zalongwa,$query_module) or die(mysqli_error($zalongwa));
	$row_module = mysqli_fetch_assoc($module);
	$totalRows_module = mysqli_num_rows($module);

#populate privileges combo box
	$query_privilege = "SELECT privilegeID, privilegename FROM privilege";
	$privilege = mysqli_query($zalongwa,$query_privilege) or die(mysqli_error($zalongwa));
	$row_privilege = mysqli_fetch_assoc($privilege);
	$totalRows_privilege = mysqli_num_rows($privilege);
	
@$check = $_POST['checksubmit'];
if ($check=='on'){
					$username = $_POST['txtUsername'];
					$pwd = $_POST['txtPassword'];
					$name = $_POST['txtName'];
					$reg = $_POST['txtRegno'];
					$desig = $_POST['position'];
					$email= $_POST['txtEmail'];
					$authlevel = $_POST['priv'];
					$module = $_POST['module'];
			$sql="INSERT INTO security (UserName,password,FullName,RegNo, Position, Email, LastLogin, 
			Registered, AuthLevel, Module, PrivilegeID) VALUES('$username','$pwd','$name','$reg','$desig','$email','now()','now()','','$authlevel','$module')";   
			$result = mysqli_query($zalongwa,$sql) or die("Siwezi kuingiza data.<br>" . mysqli_connect_error($zalongwa));
	}
?> 

          <form action="adminmanageuser.php" method="get" class="style24">
            <div text-align="right"><span class="style42"><span style="font-family: V
            erdana,serif; "><b>Search</b></span></span>
              <span style="color: #006699; font-family: Verdana,serif; "><b
                  <label>
<input type="text" name="content" size="15">
</label>
                  </b></span><span style="color: #FFFF00; font-family: Verdana,serif; "><b>
              <input type="submit" value="GO" name="go">
            </b></span>            </div>
        </form>       
        		 <?php

	# include the footer
	include('../footer/footer.php');
?>