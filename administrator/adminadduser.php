<?php 
#get connected to the database and verify current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('administratorMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Manage Users';
	$szSubSection = 'New User';
	$szTitle = 'List of Database Users';
	include('administratorheader.php')
?>
<form action="adminmanageuser.php" method="get" class="style24" xmlns:background-color="http://www.w3.org/1999/xhtml"
      xmlns:width="http://www.w3.org/1999/xhtml" xmlns:width="http://www.w3.org/1999/xhtml"
      xmlns:width="http://www.w3.org/1999/xhtml" xmlns:style xmlns:width="http://www.w3.org/1999/xhtml"
      xmlns:width="http://www.w3.org/1999/xhtml" xmlns:width="http://www.w3.org/1999/xhtml"
      xmlns:width="http://www.w3.org/1999/xhtml" xmlns:color="http://www.w3.org/1999/xhtml"
      xmlns:padding="http://www.w3.org/1999/xhtml">
            <div text-align="right"><span class="style67"><span style="Verdana"><b>Search</b></span></span>
              <span style="Verdana color: 006699 ; "><b>
                content: <input type="text" name="content" size="15"<?php $content ;
                      echo $content;?>
              </b></span>
                <span family="Verdana color: #FFFF00; "><b>
              <input type="submit" value="GO" name="go">
              </b></span>            </div>
        </form>
        <?php
 if(isset($_POST['Submit']) && $_POST['Submit'] !=""){
		$today = date("F j, Y");   
		$LastName = addslashes($_POST['txtLastName']);
		$FirstName = addslashes($_POST['txtFirstName']);
		$byear = addslashes($_POST['txtYear']);
		$bmon = addslashes($_POST['txtMonth']);
		$bday = addslashes($_POST['txtDay']);
		$id = addslashes($_POST['txtRegNo']);
		$selectPosition = $_POST['selectPosition'];
		$username = addslashes($_POST['txtLogin']);
		$PWD = addslashes($_POST['txtPWD']);
		$Login=$username.$PWD;
		$Email = addslashes($_POST['txtEmail']);
		$fullname = $LastName . ", " . $FirstName;
		$bdate = $bday . " - " . $bmon . " - " . $byear;
		
		if(strlen($bdate)<>14){
		$_SESSION['loginerror'] = $bdate. ' - is Invalid Date of Birth! '; 
  		//echo '<meta http-equiv = "refresh" content ="0; url = registration.php">';
		}
	
		#check username
		if (!preg_match("^(([A-Za-z0-9!#$%&*+/=?^_`{|}~-][A-Za-z0-9!#$%&*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $username)){
		$_SESSION['loginerror'] = $username.' - is a Bad Username! ';
  		//echo '<meta http-equiv = "refresh" content ="0; url = registration.php">';
		 }
	   
		#check username
		if (!preg_match("^(([A-Za-z0-9!#$%&*+/=?^_`{|}~-][A-Za-z0-9!#$%&*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $PWD)){
		$_SESSION['loginerror'] = $PWD.' - is a Bad Password! '; 
  		//echo '<meta http-equiv = "refresh" content ="0; url = registration.php">';
		 }
		#check if use has submitted valid email address
     /**
      * @param $Email
      * @return bool
      */
     function check_email_address($Email) {
		  // First, we check that there's one @ symbol, and that the lengths are right
		  if (!preg_match("[^@]{1,64}@[^@]{1,255}", $Email)) {
			// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
			return false;
	  }
	  // Split it into sections to make life easier
	  $email_array = explode("@", $Email);
	  $local_array = explode(".", $email_array[0]);
	  for ($i = 0; $i < sizeof($local_array); $i++) {
		 if (!preg_split("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
		  return false;
		}
	  }  
	  if (!preg_split("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
		  if (!preg_split("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
			return false;
		  }
		}
		  }
		  return true;
		}
		
		if($Email<>''){
				if (check_email_address($Email)) {
				  //echo $Email . ' is a valid email address. <br>';
					} else {
				$_SESSION['loginerror'] = $Email . '==> is not a valid email address! '; 
				//echo '<meta http-equiv = "refresh" content ="0; url = registration.php">';
				}
	}
	# check if user has created valid username and password
	
	if(strlen($id)<1){
	$_SESSION['loginerror'] = 'Invalid Identity Registration Number! '; 
	//echo '<meta http-equiv = "refresh" content ="0; url = registration.php">';
	}
	if(strlen($username)<5){
	$_SESSION['loginerror'] = 'User Name too short, User Name must be at least 5 characters! '; 
	//echo '<meta http-equiv = "refresh" content ="0; url = registration.php">';
	}
	if(strlen($PWD)<5){
	$_SESSION['loginerror'] = 'Password too short, Password must be at least 5 characters! '; 
	//echo '<meta http-equiv = "refresh" content ="0; url = registration.php">';
	}
	// search for existing users
	
	   #check if username exist
	   $sql ="SELECT UserName FROM security WHERE UserName='$username'";
	   $result = mysqli_query($zalongwa,$sql);
	   $usernameFound = mysqli_num_rows($result);
	   if ($usernameFound>0) {
			$login = mysqli_result($result,0,'UserName');
					$_SESSION['loginerror'] = " Registration NOT successful! <br> Some one is already using this USERNAME: '".$username."'
											<br>Please Select Another Username"; 
					//echo '<meta http-equiv = "refresh" content ="0; url = registration.php">';
			}
	   #check if regno exist
	   $sql ="SELECT RegNo FROM security WHERE RegNo = '$id'";
	   $result = mysqli_query($zalongwa,$sql);
	   $noFound = mysqli_num_rows($result);
	   if ($noFound>0) {
			$userregno = mysqli_result($result,0,"userregno");
					$_SESSION['loginerror'] = "Registration NOT Successful! <br>
											  Re-registration is not allowed in ZALONGWA DATABASE<br>
											  There is already a user using this RegNo: ".$id."<br>
											  Please Sign in with your username and password!"; 
					echo '<meta http-equiv = "refresh" content ="0; url = index.php">';
					exit;
			}

				
		#if no error captured register the candidate
		if ($_SESSION['loginerror']==""){
			// Generate SSHA jlungo hash
			$hash = "{jlungo-hash}" . base64_encode(pack("H*", sha1($PWD)));
			
			//create account
			$query = "INSERT INTO security (UserName, Password, FullName, RegNo, Position, AuthLevel, Email, LastLogin, Registered)
					 VALUES ('$username', '$hash', '$fullname', '$id', '$selectPosition', 'user', '$Email', now(), now())";
			$result = mysqli_query($zalongwa,$query) or die("Query Failed, Words like Ng'ombe are not accepted <br>" . mysqli_query_error($query));
		}
}
?>
<SCRIPT ID=clientEventHandlersJS LANG=javascript>
<!--
function fmAdd_onsubmit() {
if (fmAdd.txtLastName.value === "" || fmAdd.txtFirstName.value === "" || fmAdd.selectPosition.value==="" || fmAdd.txtLogin.value==="" || fmAdd.txtPWD.value==="" || fmAdd.txtRePWD.value==="")
	{window.alert("ZALONGWA System Asks You to Fill in the Blank Text Fields");
	return false;
	}
    var fmAdd;
    if (fmAdd.txtPWD.value !== fmAdd.txtRePWD.value){
		window.alert("Password Texts donot Match, Enter them again, ZALONGWA");
		return false;
	}
}
//-->
</SCRIPT>
<script src="css/zalongwa.js" type="text/javascript"> </script>
<body onLoad="f_setfocus();">
<style type="text/css">
<!--
.style2 {color:#FFFFCC;}
.style3 {color:#FFFFFF;}
.style4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.style5 {color: #000000;
}
-->
</style>
<table  border-spacing="0px" padding="0" style="width=100%">
<tr>
	<td text-align=center><br>
	  <br>
		<!-- Registration Form Starts -->
		<table padding="0px;" style="width:540px" border-collapse="2px solid rgb(119,119,119)">
		<tr>
			<td text-align=left>
			
			
			<table border=0  border-spacing="0px" border-padding="0px" width="100%" background="themes/images/loginTopHeaderBg.gif">
			<tr>
                &nbsp;
				<td text-align=right><!--img src="themes/images/loginTopVersion.gif"--></td>
			</tr>
			</table>
			<table style="border:0; padding='6' width:100%">

			<tr>
				<td text-align=left vertical-align=top class=small border-padding="10" >
					<!-- Sign in box -->
					<div text-align="center"><br>
				  USER REGISTRATION FORM</div>
					<FORM action="<?php echo $_SERVER['PHP_SELF']?>" method=post enctype="application/x-www-form-urlencoded" name=fmAdd id=fmAdd onsubmit="return fmAdd_onsubmit()" LANG=javascript>
       <TABLE style="width:100%"  text-align="center" BORDER-PADDING=0px BORDER-SPACING=0 border-color="#006600" bachground-color="#FFFFCC">
							<?php
							if ($_SESSION['loginerror']!="")
							{
							?>
							<tr>
								<td colspan="6"><b class="small"><span style="color: Brown; ">
								<div text-align="center"><?php echo $_SESSION['loginerror']?></div>
								</span>
								</b>
								</td>
							</tr>
							<?php
							}
							?>
										 <TR>
                            <TD VERTICAL-ALIGN=MIDDLE TEXT-ALIGN=RIGHT colspan="4" height="28" nowrap <?php echo $missingLastname?'style=color: rgb(990000)':'';?>>
                                <div text-align="right" class="large"><span style="color:#0000CC ">LAST NAME:</span></div></TD>
                            <TD colspan="2" TEXT-ALIGN=LEFT VERTICAL-ALIGN=MIDDLE><div text-align="left"><span
                                            style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000; ">
<INPUT TYPE="text" SIZE="29" name="txtLastName" value="<?php echo((isset($_POST["txtLastName"])))? $_POST["txtLastName"]:"" ?>">


                          <TR>
                            <TD VERTICAL-ALIGN=MIDDLE TEXT-ALIGN=RIGHT colspan="4" height="28" nowrap><div text-align="right" class="large"><span
                                            style="color: #0000CC; ">FIRST NAME: </span></div></TD>
                            <TD colspan="2" TEXT-ALIGN=LEFT VERTICAL-ALIGN=MIDDLE><div text-align="left"><span
                                            style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000; ">

<INPUT TYPE="text" SIZE="29" name="txtFirstName" value="<?php echo((isset($_POST["txtFirstName"]))?$_POST["txtFirstName"]:"") ?>">

</span><span style="color: #000000; "><span class="large style4"><span style="color: #0000CC; ">(Firstname)</span></span> </span></div></TD>
                          </TR>
						    <TR>
                            <TD VERTICAL-ALIGN=MIDDLE TEXT-ALIGN=RIGHT colspan="4" height="28" nowrap><div text-align="right" class="large"><span
                                            style="color: #0000CC; ">DATE OF BIRTH: </span></div></TD>
                            <TD colspan="2" TEXT-ALIGN=LEFT VERTICAL-ALIGN=MIDDLE nowrap><div text-align="left"><span
                                            style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000; ">
                            <label for="select"></label><select name="txtDay" id="select">
							<option value="<?php echo((isset($_POST["txtDay"]))?$_POST["txtDay"]:"") ?>"><?php echo((isset($_POST["txtDay"]))?$_POST["txtDay"]:"") ?></option>  
                              <option value=>---</option>
                              <option value="01">01</option>
                              <option value="02">02</option>
                              <option value="03">03</option>
                              <option value="04">04</option>

                              <option value="05">05</option>
                              <option value="06">06</option>
                              <option value="07">07</option>
                              <option value="08">08</option>
                              <option value="09">09</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                              <option value="14">14</option>
                              <option value="15">15</option>
                              <option value="16">16</option>
                              <option value="17">17</option>
                              <option value="18">18</option>
                              <option value="19">19</option>
                              <option value="20">20</option>
                              <option value="21">21</option>
                              <option value="22">22</option>
                              <option value="23">23</option>
                              <option value="24">24</option>
                              <option value="25">25</option>
                              <option value="26">26</option>
                              <option value="27">27</option>
                              <option value="28">28</option>
                              <option value="29">29</option>
                              <option value="30">30</option>
                              <option value="31">31</option>
                            </select>
                            <label for="txtMonth"></label><select name="txtMonth" id="txtMonth">
							<option value="<?php echo((isset($_POST["txtMonth"]))?$_POST["txtMonth"]:"") ?>"><?php echo((isset($_POST["txtMonth"]))?$_POST["txtMonth"]:"") ?></option>  
                              <option value=>-----------</option>
                              <option value="01">January</option>
                              <option value="02">February</option>
                              <option value="03">March</option>
                              <option value="04">April</option>
                              <option value="05">May</option>
                              <option value="06">June</option>
                              <option value="07">July</option>
                              <option value="08">August</option>
                              <option value="09">September</option>
                              <option value="10">October</option>
                              <option value="11">November</option>
                              <option value="12">December</option>
                            </select>
                                      <label for="txtYear"></label><input name="txtYear" type="text" id="txtYear" size="3" maxlength="4" value="<?php echo((isset($_POST["txtYear"]))?$_POST["txtYear"]:"") ?>">
                            <span style="color: #000000; "><span class="large style4"><span
                                                    style="color: #0000CC; ">(dd-mm-<span
                                                        style="color: #0000CC; ">yyyy</span>)</span></span> </span></div></TD>
                          </TR>
                          <TR>
                            <TD VERTICAL-ALIGN=middle height="28" colspan="4" TEXT-ALIGN=right>
                            <div text-align="right" class="large"><span style="color: #0000CC; ">ID RegNo: </span></div></TD>
                            <TD colspan="2" TEXT-ALIGN=LEFT VERTICAL-ALIGN=TOP><div text-align="left"><span
                                            style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000; ">
                                  <label for="txtRegNo"></label><input name="txtRegNo" type="text" id="txtRegNo" size="29" value="<?php echo((isset($_POST["txtRegNo"]))?$_POST["txtRegNo"]:"") ?>">
                            </span><span style="color: #0000CC; "></span></div></TD>
                          </TR>
                          <TR>
                            <TD colspan="4" VERTICAL-ALIGN=MIDDLE TEXT-ALIGN=RIGHT nowrap><div text-align="right" class="large"><span
                                            style="color: #0000CC; ">POSITION:</span></div></TD>
                            <TD colspan="2" TEXT-ALIGN=LEFT TEXT-ALIGN=MIDDLE><div text-align="left"><span
                                            style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000; ">
                                  <label for="selectPosition"></label><select name="selectPosition" id="selectPosition">
							<option value="<?php echo((isset($_POST["selectPosition"]))?$_POST["selectPosition"]:"") ?>"><?php echo((isset($_POST["selectPosition"]))?$_POST["selectPosition"]:"") ?></option>  
                                    <option value="student">student</option>
                                    <option value="student">Lecturer</option>
                                    <option value="student">Administrator</option>
                                    <option value="student">Technician</option>
                                  </select>
                            </span></div></TD>
                          </TR>
                          <TR>
                            <TD height="19" colspan="4" TEXT-ALIGN=RIGHT VERTICAL-ALIGN=MIDDLE nowrap><div text-align="right" class="large"><span
                                            style="color: #0000CC; ">USERNAME: </span></div></TD>
                            <TD colspan="2" TEXT-ALIGN=LEFT VERTICAL-ALIGN=MIDDLE><div text-align="left"><span
                                            style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: rgb(000000); ">
                                        <label for="txtLogin"></label><input name="txtLogin" type="text" id="txtLogin" size="29" value="<?php echo((isset($_POST["txtLogin"]))?$_POST["txtLogin"]:"") ?>">
</span><span style="color: #000000; "><span class="large style4"><span style="color: #0000CC; ">(flastname)</span></span></span></div></TD>
                          </TR>
                          <TR>
                            <TD height="19" colspan="4" rowspan="2" TEXT-ALIGN=RIGHT VERTICAL-ALIGN=MIDDLE><div text-align="right" class="large"><span
                                            style="color: #0000cc;">PASSWORD:</span></div></TD>
                            <TD colspan="2" rowspan="2" TEXT-ALIGN=LEFT VERTICAL-ALIGN=MIDDLE><div text-align="left"><span
                                            family="Verdana, Arial, Helvetica, sans-serif"
                                            style="font-size: x-small;color: #000000;">
                                        <label for="txtPWD"></label><input name="txtPWD" type="password" id="txtPWD" size="29" >
                            </span></div></TD>
                            
                          </TR>
                          <TR>
                            
                          </TR>
                          <TR>
                            <TD height="19" colspan="4" rowspan="2" TEXT-ALIGN=RIGHT VERTICAL-ALIGN=MIDDLE nowrap><div text-align="right" class="large"><span
                                            style="color: rgb(0,0,204); ">RE-ENTER PASSWORD: </span></div></TD>
                            <TD colspan="2" rowspan="2" TEXT-ALIGN=LEFT VERTICAL-ALIGN=MIDDLE><div text-align="left"><span family="Verdana, Arial, Helvetica, sans-serif"
                                                                                                         style="font-size: x-small; color:rgb(000000); ">
                               <label for="txtRePWD"></label><input name="txtRePWD" type="password" id="txtRePWD" size="29" >
                            </span></div></TD>
                           
                          </TR>
                          <TR>
                           
                          </TR>
                          <tr>
                            <td colspan="4" rowspan="2"><div text-align="right"></div>                              <div text-align="right"></div>                              <div text-align="right"><span
                                            style="color: #0000CC; ">EMAIL:</span></div></td>
                              <TD colspan="2" rowspan="2" TEXT-ALIGN=LEFT VERTICAL-ALIGN=MIDDLE><div text-align="left"><span
                                              family="Verdana, Arial, Helvetica, sans-serif"
                                              style="font-size: x-small; color: #0000CC; ">

                                            <label>
<input type="text" size="29" name="txtEmail" value="<?php echo((isset($_POST["txtEmail"]))?$_POST["txtEmail"]:"") ?>">
</label>

                                    </span></div></TD>
                           
                          </tr>


           <table>
                          <TR>
                            <TD height="19"><div  style="text-align:right;"></div></TD>
                            <TD  style="width:113%" text-align="right" vertical-align="bottom"><div text-align="right"><span class="style2"></span></div></TD>
                            <TD VERTICAL-ALIGN=MIDDLE TEXT-ALIGN=LEFT BACKGROUND-COLOR="#FFFFCC"><div text-align="right"><span class="style2"><span class="style3"><span class="style2"><span class="style2"></span></span></span></span></div></TD>
                            <TD VERTICAL-ALIGN=TOP TEXT-ALIGN=LEFT><div text-align="right"><span class="style2"><span class="style3"><span class="style2"><span class="style2"></span></span></span></span></div></TD>
                            <TD vertical-align="top" nowrap background-color="#FFFFCC">                              <div text-align=left" class="style2">
                                  <div text-align="center">
                                    <input type="submit" value="Submit" name="Submit">
                                    <span class="style45 style16"> ...............</span>
                                    <input type="reset" value=" Reset" name="Reset">
                                  </div></TD>
                            
                            <td vertical-align="top" background-color="#FFFFCC"><div text-align="right"></div></td>
                          </TR>
          </table>
          <input type="hidden" name="MM_insert" value="true">
          </FORM>				
			 </td>
			  </table>
			
			</td>
		</tr>
	  </table>
	
			<!-- Shadow -->
			<table style="border:0 celling=0; celling=0; width=640px;">
			<tr>
				<td style="width:100%" background="themes/images/loginBottomShadowBg.gif">&nbsp;</td>
        &nbsp;
			</tr>
	  </table>

</body>
</table>
