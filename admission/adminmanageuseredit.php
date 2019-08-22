<?php
#get connected to the database and verify current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Manage Users';
	$szSubSection = '';
	$szTitle = 'User Visit Information';
	include('admissionheader.php');
?>
<form action="adminmanageuser.php" method="get" class="style24">
            <div align="right"><span class="style67"><span style="font-family: Verdana; "><b>Search</b></span></span>
              <span style="color: #006699; font-family: Verdana; "><b>
              <input type="text" name="content" size="15">
              </b></span><span style="color: #FFFF00; font-family: Verdana; "><b>
              <input type="submit" value="GO" name="go">
              </b></span>            </div>
        </form>
          	<?php
require_once('../Connections/zalongwa.php');

#populate module combo box
	$query_module = "SELECT moduleid, modulename FROM modules";
	$module = mysqli_query($zalongwa, $query_module) or die(mysqli_error($zalongwa));
	$row_module = mysqli_fetch_assoc($module);
	$totalRows_module = mysqli_num_rows($module);

#populate privileges combo box
	$query_privilege = "SELECT privilegeID, privilegename FROM privilege";
	$privilege = mysqli_query($zalongwa, $query_privilege) or die(mysqli_error($zalongwa));
	$row_privilege = mysqli_fetch_assoc($privilege);
	$totalRows_privilege = mysqli_num_rows($privilege);

#populate department combo box
	$query_dept = "SELECT DeptID, DeptName FROM department ORDER BY DeptName";
	$dept = mysqli_query($zalongwa, $query_dept) or die(mysqli_error($zalongwa));
	$row_dept = mysqli_fetch_assoc($dept);
	$totalRows_dept = mysqli_num_rows($dept);
#populate faculty combo box
	$query_faculty = "SELECT FacultyID, FacultyName FROM faculty ORDER BY FacultyName";
	$faculty = mysqli_query($zalongwa, $query_faculty) or die(mysqli_error($zalongwa));
	$row_faculty = mysqli_fetch_assoc($faculty);
	$totalRows_faculty = mysqli_num_rows($faculty);
	 
$login=$_GET['login'];
$sql = "SELECT FullName, RegNo, UserName, Module, Faculty, Dept, Position, PrivilegeID, LastLogin
FROM security WHERE UserName='$login' ORDER BY FullName";

$result = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
$query = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));

$all_query = mysqli_query($zalongwa, $query);
$totalRows_query = mysqli_num_rows($query);
/* Printing Results in html */
if (mysqli_num_rows($query) > 0){
while($result = mysqli_fetch_array($query)) {
		$login = stripslashes($result["UserName"]);
		$Name = stripslashes($result["FullName"]);
		$RegNo = stripslashes($result["RegNo"]);
		$currentprivilege = stripslashes($result["PrivilegeID"]);
		$currentmodule = stripslashes($result["Module"]);
		$currentfaculty = stripslashes($result["Faculty"]);
		$currentdept = stripslashes($result["Dept"]);
		$position = stripslashes($result["Position"]);
		$last = stripslashes($result["LastLogin"]);
	}
}else{
$key= stripslashes($key);
echo "Sorry, No Records Found <br>";
echo "That Match With Your Searck Key \"$key \" ";
}

#Update database values
if (isset($_POST['action']) && ($_POST['action'] == "Update"))
	{
		$position=addslashes($_POST['position']);
		$module=addslashes($_POST['module']);
		$priv=addslashes($_POST['priv']);
		$login=addslashes($_GET['login']);
		$dept=addslashes($_POST['dept']);
		$faculty=addslashes($_POST['faculty']);
		
		$sql="UPDATE security Set Position='$position', Module = '$module', Dept = '$dept', Faculty = '$faculty',
			PrivilegeID='$priv' WHERE UserName='$login'";
		$result = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));
		echo '<meta http-equiv = "refresh" content ="0; 
		url = adminmanageuser.php?content='.$login.'">';
		exit;
mysqli_free_result($result);
mysqli_close($zalongwa);
	}
	?>
<form action="#" method="post" name="updateuser" id="updateuser">
<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
              <tr>
                <td width="81"><div align="right"><strong>Name:</strong></div></td>
                <td width="109"><?php echo $Name; ?> </td>
              </tr>
              <tr>
                <td><div align="right"><strong>RegNo:</strong></div></td>
                <td><?php echo $RegNo; ?></td>
              </tr>
              <tr>
                <td nowrap><div align="right"><strong>User Name:</strong></div></td>
                <td><?php echo $login; ?>
                  <input name="login" type="hidden" id="login" value="<?php echo $login; ?>"></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Position:</strong></div></td>
                <td><select name="position" id="position">
				<option value="<?php echo $position; ?>" selected><?php echo $position; ?></option>
                  <option value="Accountant">Accountant</option>
				  <option value="Administrator">Administrator</option>
                  <option value="Lecturer">Lecturer</option>
                  <option value="student">Student</option>
				  <option value="Webmaster">Webmaster</option>
                </select></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Module:</strong></div></td>
                <td><select name="module" id="module">
                 <option value="<?php echo $currentmodule?>" selected><?php echo $currentmodule?></option>
            		<?php
							do {  
									?>
            		<option value="<?php echo $row_module['moduleid']?>"><?php echo $row_module['modulename']?></option>
           				 <?php
								} while ($row_module = mysqli_fetch_assoc($module));
  								$rows = mysqli_num_rows($module);
  								if($rows > 0) {
      								mysqli_data_seek($module, 0);
	  								$row_module = mysqli_fetch_assoc($module);
  								}
						?>
                </select></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Privilege:</strong></div></td>
                <td><select name="priv" id="priv">
				 <option value="<?php $cuerrentprivilege =$currentprivilege;
                 echo $cuerrentprivilege?>" selected><?php echo $currentprivilege?></option>
            		<?php
							do {  
									?>
            		<option value="<?php echo $row_privilege['privilegeID']?>"><?php echo $row_privilege['privilegename']?></option>
           				 <?php
								} while ($row_privilege = mysqli_fetch_assoc($privilege));
  								$rows = mysqli_num_rows($privilege);
  								if($rows > 0) {
      								mysqli_data_seek($privilege, 0);
	  								$row_privilege = mysqli_fetch_assoc($privilege);
  								}
						?>
                </select></td>
              </tr>
			   <tr>
                <td><div align="right"><strong>Department:</strong></div></td>
                <td><select name="dept" id="dept">
				 <option value="<?php echo $currentdept?>" selected><?php echo $currentdept?></option>
            		 <option value="0">[Faculty Exam Officer]</option>
					<?php
							do {  
									?>
            		<option value="<?php echo $row_dept['DeptID']?>"><?php echo $row_dept['DeptName']?></option>
           				 <?php
								} while ($row_dept = mysqli_fetch_assoc($dept));
  								$rows = mysqli_num_rows($dept);
  								if($rows > 0) {
      								mysqli_data_seek($dept, 0);
	  								$row_dept = mysqli_fetch_assoc($dept);
  								}
						?>
                </select></td>
              </tr>
			   <tr>
                <td><div align="right"><strong>Faculty:</strong></div></td>
                <td><select name="faculty" id="faculty">
                        <option value="<?php /** @var cuerrentfaculty $cuerrentfaculty */
                 echo $cuerrentfaculty?>" selected><?php echo $currentfaculty?></option>
            		<?php
							do {  
									?>
            		<option value="<?php echo $row_faculty['FacultyID']?>"><?php echo $row_faculty['FacultyName']?></option>
           				 <?php
								} while ($row_faculty = mysqli_fetch_assoc($faculty));
  								$rows = mysqli_num_rows($faculty);
  								if($rows > 0) {
      								mysqli_data_seek($faculty, 0);
	  								$row_faculty = mysqli_fetch_assoc($faculty);
  								}
						?>
                </select></td>
              </tr>
			  <tr>
                <td><div align="right"><strong>Update:</strong></div></td>
                <td><input type="submit" name="action" value="Update"></td>
              </tr>
  </table>
</form>            
            	
<?php

	# include the footer
	include('../footer/footer.php');
?>
