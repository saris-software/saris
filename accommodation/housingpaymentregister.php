<?php
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('admissionMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Financial Reports';
	$szSubSection = 'Add Payments';
	$szTitle = 'Register New Payments';
	include('admissionheader.php');

	#populate Payment Category Combo Box
	$query_paytype = "SELECT Id, Description FROM paytype ORDER BY Id ASC";
	$paytype = mysql_query($query_paytype, $zalongwa) or die(mysql_error());
	$row_paytype = mysql_fetch_assoc($paytype);
	$totalRows_paytype = mysql_num_rows($paytype);
	
	#populate Candidate Combo Box
	$query_std = "SELECT  Name, RegNo FROM student ORDER BY RegNo ASC";
	$std = mysql_query($query_std, $zalongwa) or die(mysql_error());
	$row_std = mysql_fetch_assoc($std);
	$totalRows_std = mysql_num_rows($std);

function add($f){
  global $errorindicator,$errorclass,$Javascript;
  $tocheck=explode(',',','.$_POST['required']);
  preg_match('/id="(.*?)"/i',$f,$i);
  preg_match('/name="(.*?)"/i',$f,$n);
  preg_match('/type="(.*?)"/i',$f,$t);
  preg_match('/value="(.*?)"/i',$f,$iv);
  $n=$n[1];$iv=$iv[1];$i=str_replace('_',' ',$i[1]);
  if(preg_match('/<textarea/',$f)){
    $v=$_POST[$n]==''?$i:$_POST[$n];
    $f=preg_replace('/<textarea(.*?)>(.*?)<\/textarea>/',
    '<textarea\\1>'.stripslashes(htmlentities($v)).'</textarea>',$f);
        if($Javascript){$f=preg_replace('/<textarea/',
        '<textarea onfocus="this.value=this.value==\''.
        $i.'\'?\'\':this.value"',$f);}
  }  
  if(@preg_match('/<select/',$f)){
    @preg_match('/<select.*?>
<style type="text/css">
<!--
.style4 {color: #CCCCCC}
-->
</style>
/',$f,$st);
    @preg_match_all('/<option value="(.*?)">(.*?)<\/option>/',$f,$allopt);
    foreach ($allopt[0] as $k=>$a){
      if($_POST[$n]==$allopt[1][$k] || 
      ($_POST[$n]=='' && $k==0)){
        $preg='/<option value="';
        $preg.=$allopt[1][$k].'">'.$allopt[2][$k].
        '<\/option>/si';
        $rep='<option selected="selected" value="';
        $rep.=$allopt[1][$k].'">'.$allopt[2][$k].
        '</option>';
        $f=preg_replace($preg,$rep,$f);
      }
    }
  }else{
    switch ($t[1]){
      case 'text':
        $v=$_POST[$n]==''?'value="'.$i.'"':'value="'.
        stripslashes(htmlentities($_POST[$n])).'"';
        $f=preg_replace('/<input/','<input '.$v,$f);
        if($Javascript){$f=preg_replace('/<input/',
        '<input onfocus="this.value=this.value==\''
        .$i.'\'?\'\':this.value"',$f);}
      break;
    }
  }
  $f.='<input type="hidden" name="'.$n.'initvalue" value="'.$i.'" />';
  if (array_search($n,$tocheck) and ($_POST[$n]=='' or $_POST[$n]==$i)){
      if($errorindicator!=''){$f=$errorindicator.$f;}
      if($errorclass!=''){$f=preg_replace('/name=/i','class="'.
      $errorclass.'" name=',$f);}
  }
  return $f;
}

// check the form
function check(){
  if ($_POST!=''){
    $sentarray=array();
    $tocheck=explode(',',$_POST['required']);
    $error[0]="Errors:";
    foreach ($tocheck as $t){if(!array_key_exists($t,$_POST)){
    $error[]=$t;}}
    foreach (array_keys($_POST) as $p){
      if(!preg_match('/initvalue/',$p) and 
      !preg_match('/required/',$p)){
        $sentarray[$p]=$_POST[$p]==
        $_POST[$p.'initvalue']?'':$_POST[$p];
      }
      foreach ($tocheck as $c){
        if ($p==$c and $sentarray[$p]==''){
          $error[]=$_POST[$p.'initvalue'];
        }
      }
    }
    return $error[1]==''?$sentarray:$error;  
    }
}
?>

<?PHP
//use the function
  $errorindicator='<img src="images/delete.gif" width="14" height="14" 
  alt="Alert" title="Indicator for missing form element" border="0" />';
  $errorclass="error";
  $Javascript=true;
  $results=check();
  if($results[0]=='Errors:'){
    
?>
  <h3>There has been an error:</h3>
  <p>You forgot to enter the following field(s)</p>
  <ul>
  <?PHP foreach ($results as $i=>$e){if ($i>0){
    echo "<li>$e</li>";
  }}
  @$errored=1;
  $regno = $_POST['regno'];
  ?>
  </ul>
<?PHP 
  }else{
  // Add send functionality here
		$regno = $_POST['regno'];
		$category = $_POST['category'];
		$amount = $_POST['amount'];
		$receiptno = $_POST['receiptno'];
		$rpDate = $_POST['rpDate'];
		$comments = $_POST['comments'];
		
		#check if receiptno exist
		if(!empty($receiptno)){
			$sql = "SELECT ReceiptNo FROM tblcautionfee WHERE ReceiptNo = '$receiptno'";
			$result = mysql_query($sql);
			$num_row = mysql_num_rows($result);
			if ($num_row > 0) {
					echo "Can't Save Records, ZALONGWA Imegundua Kuwa,<br> Receipt Number Hii, $receiptno, Ishatumika Tayari";
					echo "<br> Tafadhari Chagua Nyingine!<hr><br>";
					?>
					<form name="addpayment" method="post" action="<?=$_SERVER['PHP_SELF']?>">
			  <input type="hidden" name="required" value="category,regno,amount,receiptno,rpDate" />
			  <fieldset>
				<legend>Payment Registration Form</legend>
				<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
				  <tr>
					<th scope="row"><div align="right">Candidate:</div></th>
					<td>
					<?=add('<input type="text" name="regno" id="regno" value="echo $row_candidate[\'RegNo\']/>')?>
					<? echo $row_candidate['Name']." " ?><? echo $row_candidate['RegNo']?>
					</td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Pay Category: </div></th>
					<td>
					<?=add('
							  <select name="category" id="category">
							  <option value="0">[Select Category]</option>
								<optgroup label="Accommodation Office">
								  <option value="1">Accom. Rental Charges</option>
								  <option value="2">Accom. Caution Fees</option>
								  <option value="3">Accom. Penalty Charges</option>
								</optgroup>
								<optgroup label="Admission Office">
								  <option value="4">Univ. Tuition Fees</option>
								  <option value="5">Univ. Caution Fees</option>
								  <option value="6">Univ. Penalty Charges</option>
								</optgroup>
								<optgroup label="Examination Office">
								  <option value="7">Exam. Transcript Fees</option>
								  <option value="8">Exam. Certificate Fees</option>
								  <option value="9">Exam. Appeal Fees</option>
								</optgroup>
							   </select>
						   ')?>
					</td>
				  </tr>
				  
				  <tr>
					<th scope="row"><div align="right">Amount:</div></th>
					<td><?=add('<input type="text" name="amount"
					 id="amount" />')?></td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Receipt No.: </div></th>
					<td><?=add('<input type="text" name="receiptno" id="receiptno" />')?></td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Receipt Date: </div></th>
					<td>
					<!-- A Separate Layer for the Calendar -->
					<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>
					 <table border="0">
									<tr>
										<td><?=add('<input type="text" class="vform" size="20" name="rpDate" id="rpDate" value="" />')?></td>
										<td><input type="button" class="button" name="rpDate_button" value="Pick Date" onClick="show_calendar('addpayment.rpDate', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=325;PopupY=325;')"></td>
									</tr>
					  </table>
					 
					</td>
				  </tr>
				  <tr>
					<th scope="row"><div align="right">Comments:</div></th>
					<td><?=add('<input type="text" size="57" name="comments"
					 id="comments" />')?></td>
				  </tr>
				  <tr>
					<th scope="row">&nbsp;</th>
					<td nowrap><input name="submit" type="submit" value="Save" />
					<span class="style4">............</span>          <input name="cancel" type="reset" id="cancel" value="Cancel"></td>
				  </tr>
				</table>
				<p>&nbsp;    </p>
			  </fieldset>
			</form>
					<?
				}elseif(intval($category)==0){
				echo "Can't Save Records, <br> Please Select Category! <hr>";
				?>
				<form name="addpayment" method="post" action="<?=$_SERVER['PHP_SELF']?>">
			  <input type="hidden" name="required" value="category,regno,amount,receiptno,rpDate" />
			  <fieldset>
				<legend>Payment Registration Form</legend>
				<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
				  <tr>
					<th scope="row"><div align="right">Candidate:</div></th>
					<td>
					<?=add('<input type="text" name="regno" id="regno" value="echo $row_candidate[\'RegNo\']/>')?>
					<? echo $row_candidate['Name']." " ?><? echo $row_candidate['RegNo']?>
					</td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Pay Category: </div></th>
					<td>
					<?=add('
							  <select name="category" id="category">
							  <option value="0">[Select Category]</option>
								<optgroup label="Accommodation Office">
								  <option value="1">Accom. Rental Charges</option>
								  <option value="2">Accom. Caution Fees</option>
								  <option value="3">Accom. Penalty Charges</option>
								</optgroup>
								<optgroup label="Admission Office">
								  <option value="4">Univ. Tuition Fees</option>
								  <option value="5">Univ. Caution Fees</option>
								  <option value="6">Univ. Penalty Charges</option>
								</optgroup>
								<optgroup label="Examination Office">
								  <option value="7">Exam. Transcript Fees</option>
								  <option value="8">Exam. Certificate Fees</option>
								  <option value="9">Exam. Appeal Fees</option>
								</optgroup>
							   </select>
						   ')?>
					</td>
				  </tr>
				  
				  <tr>
					<th scope="row"><div align="right">Amount:</div></th>
					<td><?=add('<input type="text" name="amount"
					 id="amount" />')?></td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Receipt No.: </div></th>
					<td><?=add('<input type="text" name="receiptno" id="receiptno" />')?></td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Receipt Date: </div></th>
					<td>
					<!-- A Separate Layer for the Calendar -->
					<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>
					 <table border="0">
									<tr>
										<td><?=add('<input type="text" class="vform" size="20" name="rpDate" id="rpDate" value="" />')?></td>
										<td><input type="button" class="button" name="rpDate_button" value="Pick Date" onClick="show_calendar('addpayment.rpDate', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=325;PopupY=325;')"></td>
									</tr>
					  </table>
					 
					</td>
				  </tr>
				  <tr>
					<th scope="row"><div align="right">Comments:</div></th>
					<td><?=add('<input type="text" size="57" name="comments"
					 id="comments" />')?></td>
				  </tr>
				  <tr>
					<th scope="row">&nbsp;</th>
					<td nowrap><input name="submit" type="submit" value="Save" />
					<span class="style4">............</span>          <input name="cancel" type="reset" id="cancel" value="Cancel"></td>
				  </tr>
				</table>
				<p>&nbsp;    </p>
			  </fieldset>
			</form>
				<?php
				}elseif(intval($regno)==0){
				echo "Can't Save Records, <br> Please Select Candidate! <hr>";
				?>
				<form name="addpayment" method="post" action="<?=$_SERVER['PHP_SELF']?>">
			  <input type="hidden" name="required" value="category,regno,amount,receiptno,rpDate" />
			  <fieldset>
				<legend>Payment Registration Form</legend>
				<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
				  <tr>
					<th scope="row"><div align="right">Candidate:</div></th>
					<td>
					<?=add('<input type="text" name="regno" id="regno" value="echo $row_candidate[\'RegNo\']/>')?>
					<? echo $row_candidate['Name']." " ?><? echo $row_candidate['RegNo']?>
					</td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Pay Category: </div></th>
					<td>
					<?=add('
							  <select name="category" id="category">
							  <option value="0">[Select Category]</option>
								<optgroup label="Accommodation Office">
								  <option value="1">Accom. Rental Charges</option>
								  <option value="2">Accom. Caution Fees</option>
								  <option value="3">Accom. Penalty Charges</option>
								</optgroup>
								<optgroup label="Admission Office">
								  <option value="4">Univ. Tuition Fees</option>
								  <option value="5">Univ. Caution Fees</option>
								  <option value="6">Univ. Penalty Charges</option>
								</optgroup>
								<optgroup label="Examination Office">
								  <option value="7">Exam. Transcript Fees</option>
								  <option value="8">Exam. Certificate Fees</option>
								  <option value="9">Exam. Appeal Fees</option>
								</optgroup>
							   </select>
						   ')?>
					</td>
				  </tr>
				  
				  <tr>
					<th scope="row"><div align="right">Amount:</div></th>
					<td><?=add('<input type="text" name="amount"
					 id="amount" />')?></td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Receipt No.: </div></th>
					<td><?=add('<input type="text" name="receiptno" id="receiptno" />')?></td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Receipt Date: </div></th>
					<td>
					<!-- A Separate Layer for the Calendar -->
					<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>
					 <table border="0">
									<tr>
										<td><?=add('<input type="text" class="vform" size="20" name="rpDate" id="rpDate" value="" />')?></td>
										<td><input type="button" class="button" name="rpDate_button" value="Pick Date" onClick="show_calendar('addpayment.rpDate', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=325;PopupY=325;')"></td>
									</tr>
					  </table>
					 
					</td>
				  </tr>
				  <tr>
					<th scope="row"><div align="right">Comments:</div></th>
					<td><?=add('<input type="text" size="57" name="comments"
					 id="comments" />')?></td>
				  </tr>
				  <tr>
					<th scope="row">&nbsp;</th>
					<td nowrap><input name="submit" type="submit" value="Save" />
					<span class="style4">............</span>          <input name="cancel" type="reset" id="cancel" value="Cancel"></td>
				  </tr>
				</table>
				<p>&nbsp;    </p>
			  </fieldset>
			</form>
				<?php
				}else{
				$sql="INSERT INTO tblcautionfee(RegNo, PayType, Amount, ReceiptNo, ReceiptDate, User, Description, Received) 
										VALUES('$regno','$category','$amount','$receiptno','$rpDate','$username','$comments',now())";   
				$result = mysql_query($sql) or die("Kuna matatizo fulani, Jaribu baadaye" . mysql_error());
			}
		}
  }  
?>
<?php

//Search Candidate
if (isset($_POST["candidate"])){
$key=trim($_POST["candidate"]);
$query_candidate = "SELECT student.Name, student.RegNo, student.ProgrammeofStudy
						  FROM student 
						  WHERE (student.RegNo ='$key')";
$candidate = mysql_query($query_candidate, $zalongwa) or die(mysql_error());
$row_candidate = mysql_fetch_assoc($candidate);
$totalRows_candidate = mysql_num_rows($candidate);
}
//display the form is candidate is found
if((@$totalRows_candidate>0)||($errored==1)){ 
?>
			<form name="addpayment" method="post" action="<?=$_SERVER['PHP_SELF']?>">
			  <input type="hidden" name="required" value="category,regno,amount,receiptno,rpDate" />
			  <fieldset>
				<legend>Payment Registration Form</legend>
				<table width="200" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
				  <tr>
					<th scope="row"><div align="right">Candidate:</div></th>
					<td><input type="hidden" name="regno" id="regno" value="<?=$row_candidate['RegNo'] ?>" />	
					<? echo $row_candidate['Name'].": " ?><? echo $row_candidate['RegNo']; echo $regno ?> 
					</td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Pay Category: </div></th>
					<td>
					<?=add('
							  <select name="category" id="category">
							  <option value="0">[Select Category]</option>
								<optgroup label="Accommodation Office">
								  <option value="1">Accom. Rental Charges</option>
								  <option value="2">Accom. Caution Fees</option>
								  <option value="3">Accom. Penalty Charges</option>
								</optgroup>
								<optgroup label="Admission Office">
								  <option value="4">Univ. Tuition Fees</option>
								  <option value="5">Univ. Caution Fees</option>
								  <option value="6">Univ. Penalty Charges</option>
								</optgroup>
								<optgroup label="Examination Office">
								  <option value="7">Exam. Transcript Fees</option>
								  <option value="8">Exam. Certificate Fees</option>
								  <option value="9">Exam. Appeal Fees</option>
								</optgroup>
							   </select>
						   ')?>
					</td>
				  </tr>
				  
				  <tr>
					<th scope="row"><div align="right">Amount:</div></th>
					<td><?=add('<input type="text" name="amount"
					 id="amount" />')?></td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Receipt No.: </div></th>
					<td><?=add('<input type="text" name="receiptno" id="receiptno" />')?></td>
				  </tr>
				  <tr>
					<th nowrap scope="row"><div align="right">Receipt Date: </div></th>
					<td>
					<!-- A Separate Layer for the Calendar -->
					<script language="JavaScript" src="datepicker/Calendar1-901.js" type="text/javascript"></script>
					 <table border="0">
									<tr>
										<td><?=add('<input type="text" class="vform" size="20" name="rpDate" id="rpDate" value="" />')?></td>
										<td><input type="button" class="button" name="rpDate_button" value="Pick Date" onClick="show_calendar('addpayment.rpDate', '','','YYYY-MM-DD', 'POPUP','AllowWeekends=Yes;Nav=No;SmartNav=Yes;PopupX=325;PopupY=325;')"></td>
									</tr>
					  </table>
					 
					</td>
				  </tr>
				  <tr>
					<th scope="row"><div align="right">Comments:</div></th>
					<td><?=add('<input type="text" size="57" name="comments"
					 id="comments" />')?></td>
				  </tr>
				  <tr>
					<th scope="row">&nbsp;</th>
					<td nowrap><input name="submit" type="submit" value="Save" />
					<span class="style4">............</span>          <input name="cancel" type="reset" id="cancel" value="Cancel"></td>
				  </tr>
				</table>
				<p>&nbsp;    </p>
			  </fieldset>
			</form>
  <?php
  }else{
  ?>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="search" id="search">
						<fieldset>
						 <legend>Search Candidate </legend>
						 <table width="200" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
			  <tr>
				<td nowrap><div align="right"><strong>Enter RegNo:</strong></div></td>
				<td><input name="candidate" type="text" id = "candidate" value="" size = "25" maxlength="20"></td>
				<td><input type="submit" name="Submit" value="GO"></td>
			  </tr>
			</table>
			</fieldset>
			</form>
	<?php
  }
	# include the footer
	include('../footer/footer.php');
?>