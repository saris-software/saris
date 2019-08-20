<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD id=Head1><TITLE>Zalongwa SARIS Software</TITLE>
    <META http-equiv=Content-Type content="text/html; charset=utf-8"><LINK
            href="login_files/Generic.css" type=text/css rel=stylesheet>
    <META content="MSHTML 6.00.6000.16809" name=GENERATOR><style type="text/css">
        <!--
        body {
            background-color: #CCCCCC;
        }
        .style1 {
            color: #000033;
            font-weight: bold;
        }
        -->
    </style></HEAD>
<BODY>
<FORM action="userlogin.php" method="post" onkeypress="return WebForm_FireDefaultButton(event, 'btnLogin')" id="idpform"
      name="idpform">

    <SCRIPT type=text/javascript>
        //<![CDATA[
        var theForm = document.forms['idpform'];
        if (!theForm) {
            theForm = document.idpform;
        }
        function __doPostBack(eventTarget, eventArgument) {
            if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
                theForm.__EVENTTARGET.value = eventTarget;
                theForm.__EVENTARGUMENT.value = eventArgument;
                theForm.submit();

            }
        }
        //]]>
    </SCRIPT>

    <SCRIPT src="login_files/WebResource.axd" type=text/javascript></SCRIPT>

    <INPUT type=hidden value=1 name=validate>
    <DIV class=loginForm><DIV><IMG style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="login_files/top_banner.png"> </DIV>
        <DIV class=loginOuterFormContents><DIV class=loginLeftBorder></DIV>
            <DIV class=loginInnerFormContents><DIV class=loginErrorRow style="PADDING-TOP: 20px"></DIV>
                <div align="center" class="style1">SARIS LOGIN FORM</div>
                <DIV class=loginFormRow style="PADDING-TOP: 20px"><SPAN class=loginFormHeader>Username:</SPAN>
                    <INPUT id=textusername style="BORDER-RIGHT: silver 1px solid;border-radius: 4px; BORDER-TOP: silver 1px solid; BORDER-LEFT: silver 1px solid; WIDTH: 170px; BORDER-BOTTOM: silver 1px solid"
                           name=textusername value="<?php  echo $_SESSION['username']?>"> </DIV><br>
                    <DIV class=loginFormRow><SPAN class=loginFormHeader>Password:</SPAN>
                         <INPUT id=textpassword style="BORDER-RIGHT: silver 1px solid; border-radius: 4px; BORDER-TOP: silver 1px solid; BORDER-LEFT: silver 1px solid; WIDTH: 170px; BORDER-BOTTOM: silver 1px solid"
                            type=password name=textpassword> </DIV><DIV class=loginButtonRow><div align="left">
                             <INPUT id=btnLogin style="BORDER-TOP-WIDTH: 0px;border-radius: 4px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px"
                               type=image src="login_files/btn_login.gif" name=btnLogin></div></DIV>
                <p><?php
                    if (isset($loginerror ) && $loginerror !="")
                    {
                    ?>
                    <b class="small">
                        <style=font-color:"Brown"><?php  echo $loginerror?></font></b>
                          <?php
                          session_cache_limiter('nocache');
                          $_SESSION = array();
                          session_unset();
                          session_destroy();
                          }
                          ?>
                          </p>
                            <div align="center">
                        - Forgot your password ?<a href="passwordrecover.php" class="style16"> Get Help </a><br>
                        - New User ? <a href="registration.php">Create Account </a><br>
                                                                                 </div>
                                                                                   </DIV>

                                                                                     <DIV class=loginRightBorder></DIV></DIV>
                                                                                                                         <DIV><IMG
                                                                                                                         style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px"
                        src="login_files/fade_bottom.gif"> </DIV></DIV>
                                                                   <SCRIPT type=text/javascript>
                        //<![CDATA[
                        WebForm_AutoFocus('txtUsername');//]]></SCRIPT></FORM></BODY></HTML>
