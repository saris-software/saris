<?php
#get connected to the database and verfy current session
require_once('../Connections/sessioncontrol.php');
require_once('../Connections/zalongwa.php');


#start pdf
if (isset($_POST['PDF']) && ($_POST['PDF'] == "Print PDF"))
{
	#get post values
	$year = addslashes($_POST['ayear']);
	$cohot = addslashes($_POST['cohot']);
	$deg = addslashes($_POST['degree']);
	$sem = addslashes($_POST['sem']);
		if ($sem =='Semester I'){
			$semval = 1;
		}elseif ($sem=='Semester II'){
			$semval = 2;
		}
	$list = 2;//addslashes($_POST['list']);
	$faculty = addslashes($_POST['faculty']);
	$checkdegree = addslashes($_POST['checkdegree']);
	$checkyear = addslashes($_POST['checkyear']);
	$checkdept = addslashes($_POST['checkdept']);
	$checkcohot = addslashes($_POST['checkcohot']);
	$checkrem = addslashes($_POST['checkrem']);
	$checkbill = addslashes($_POST['checkbill']);
	$ovr = addslashes($_POST['ovrm']);
             
	#calculate year of study
	$entry = intval(substr($cohot,0,4));
	$current = intval(substr($year,0,4));
	$yearofstudy=$current-$entry;

	if($yearofstudy==0){
		$class="FIRST YEAR";
		}elseif($yearofstudy==1){
		$class="SECOND YEAR";
		}elseif($yearofstudy==2){
		$class="THIRD YEAR";
		}elseif($yearofstudy==3){
		$class="FOURTH YEAR";
		}elseif($yearofstudy==4){
		$class="FIFTH YEAR";
		}elseif($yearofstudy==5){
		$class="SIXTH YEAR";
		}elseif($yearofstudy==6){
		$class="SEVENTH YEAR";
		}else{
		$class="";
	}
	
	#calculate year of study
	$yearofstudy = $yearofstudy +1;
	
	#Get Organisation Name
	$qorg = "SELECT * FROM organisation";
	$dborg = mysql_query($qorg);
	$row_org = mysql_fetch_assoc($dborg);
	$org = $row_org['Name'];
	$address = $row_org['Address'];
	$phone = $row_org['tel'];
	$fax = $row_org['fax'];
	$email = $row_org['email'];
	$website = $row_org['website'];
	$city = $row_org['city'];

	$display=2;

	#get programme name
	$qprogram = "SELECT ProgrammeName FROM programme WHERE ProgrammeCODE ='$deg'";
	$dbprogram = mysql_query($qprogram);
	$row_program = mysql_fetch_assoc($dbprogram);
	$pname = $row_program['ProgrammeName'];

	#create grouplist tiltes
	if($list==1){
	$listitle = 'OF ALL STUDENTS';
	}elseif($list==2){
	$listitle = $pname;
	}else{
	$listitle = $faculty;
	}
		# start PDF processing
		include('includes/PDF.php');
		$pdf = &PDF::factory('p', 'a4');      // Set up the pdf object. 
		$pdf->open();                         // Start the document. 
		$pdf->setCompression(true);           // Activate compression. 
		$pdf->addPage();  

		#put page header
		$x=50;
		$y=210;
		$n=1;
		$pg=1;
		#get column width factor
		$cwf = 80;
		//$i=1;
		#count unregistered
		$j=0;
		#count sex
		$$fmcount = 0;
		$$mcount = 0;
		$$fcount = 0;
		
		#print header
		$pdf->image('../images/logo.jpg', 248, 50);   
		$pdf->setFont('Arial', 'I', 8);     
		$pdf->text(530.28, 825.89, 'Page '.$pg);   
		$pdf->text(50, 825.89, 'Printed On '.$today = date("d-m-Y H:i:s"));   

		$pdf->setFont('Arial', 'B', 23);     
		$pdf->setFillColor('rgb', 0, 0, 0);   
		$pdf->text(66, 50, strtoupper($org));   
		$pdf->setFillColor('rgb', 0, 0, 0);  
		
		#University Addresses
		$pdf->setFont('Arial', '', 11.3);     
		$pdf->text(95, 80, 'Phone: '.$phone);   
		$pdf->text(95, 99, 'Fax: '.$fax);  
		$pdf->text(95, 121, 'Email: '.$email);   
		$pdf->text(370, 80, strtoupper($address));   
		$pdf->text(370, 99, strtoupper($city));   
		$pdf->text(370, 121, $website);   
		
		$pdf->setFillColor('rgb', 0, 0, 0);   
		$pdf->setFont('Arial', '', 13);     
		$pdf->text(174, 193, $ovr.' - '.$class.' - '.strtoupper($listitle).' - ACADEMIC REPORT'); 
		$pdf->setFillColor('rgb', 0, 0, 0); 
		
		$pdf->setFillColor('rgb', 0, 0, 0);   
		$pdf->setFont('Arial', 'B', 10);    
		$pdf->setFillColor('rgb', 0, 0, 0);   
	 

		$pdf->text($x, $y, 'S/N'); 
		$pdf->text($x+38, $y, 'Name'); 
		$pdf->text($x+170, $y, 'RegNo'); 
		$pdf->text($x+238, $y, 'Sex'); 
		$pdf->text($x+260, $y, 'Remarks'); 
		if ($checkbill<>'on'){
			$pdf->text($x+310, $y, 'Invoice'); 
			$pdf->text($x+380, $y, 'Paid'); 
			$pdf->text($x+460, $y, 'Balance'); 
		}
		$pdf->setFont('Arial', '', 8.6); 
		
		$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
		$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
		$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
		$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
		$pdf->line($x+168, $y-15, $x+168, $y+3);              // most left side margin. 
		$pdf->line($x+236, $y-15, $x+236, $y+3);              // most left side margin. 
		$pdf->line($x+258, $y-15, $x+258, $y+3); 
		if ($checkbill<>'on'){ 
			$pdf->line($x+306, $y-15, $x+306, $y+3); 
			$pdf->line($x+374, $y-15, $x+374, $y+3); 
			$pdf->line($x+458, $y-15, $x+458, $y+3);             // most left side margin. 
		}
		$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 

		#query student list
		$overalldiscocount=0;
		$overallpasscount=0;
		$overallinccount=0;
		$overallsuppcount=0;
				
		$qstudent = "SELECT Name, RegNo, Sex, DBirth, ProgrammeofStudy, Sponsor, Status FROM student WHERE (ProgrammeofStudy = '$deg') AND (EntryYear = '$cohot') ORDER BY RegNo";
		$dbstudent = mysql_query($qstudent);
		$totalstudent = mysql_num_rows($dbstudent);
		
		while($rowstudent = mysql_fetch_array($dbstudent)) 
		{
			$name = stripslashes($rowstudent['Name']);
			$regno = stripslashes($rowstudent['RegNo']);
			$sex = $rowstudent['Sex'];
			$bdate = stripslashes($rowstudent['DBirth']);
			$degree = stripslashes($rowstudent["ProgrammeofStudy"]);
			$faculty = stripslashes($rowstudent["Faculty"]);
			$sponsor = stripslashes($rowstudent["Sponsor"]);
			$entryyear = stripslashes($result['EntryYear']);
			$ststatus = stripslashes($rowstudent['Status']);
			
				#initialise
				$totalunit=0;
				$unittaken=0;
				$sgp=0;
				$totalsgp=0;
				$gpa=0;
				
				# new values
				$subjecttaken=0;
				$totalfailed=0;
				$totalinccount=0;
				$halfsubjects=0;
				$ovremark='';
				$gmarks=0;
				$avg =0;				
				$key = $regno;  			
				
				# get all courses for this candidate
				$qcoursestd = "SELECT DISTINCT CourseCode, Status FROM courseprogramme 
								WHERE  (ProgrammeID='$deg') AND (YearofStudy='$yearofstudy') AND 
									(Semester='$semval') ORDER BY CourseCode";
				$dbcoursestd = mysql_query($qcoursestd);
				
				while($row_coursestd = mysql_fetch_array($dbcoursestd))
 				{
						$course= $row_coursestd['CourseCode'];
						$coption = $row_coursestd['Status']; 
						
						$sn=$sn+1;
						$remarks = 'remarks';
						$remark ='';
						$fexm = '';
						$fcwk = '';
						$fsup = ''; 
						$igrade = ''; 
						$egrade = ''; 
						$supp = ''; 
						$RegNo = $key;
						$currentyear=$year;
						include '../academic/includes/compute_student_remark.php';
						
					}
					include '../academic/includes/compute_overall_remark.php';

				# check if paid
				$regno=$RegNo;
				#initialise billing values
				$grandtotal=0;
				$feerate=0;
				$invoice=0;
				$paid=0;
				$debtorlimit=0;
				$tz103=0;
				$amount=0;
				$subtotal=0;
				$cfee=0;
				include('../billing/includes/getgrandtotalpaid.php');
				
				$x=50;

				if($checkrem=='on'){
					if($ovr=='ALL'){
						#Block withheld results
						if($due<=$debtorlimit){
							#check it
			   			 }else{
			    				$ovremark = 'WITHHELD';
			   			 }
							include('../academic/includes/print_board_results.php');
					}elseif($ovr=='WITHHELD'){
					#Block withheld results
						if($due<=$debtorlimit){
							#check it
			   			 }else{
			    			$ovremark = 'WITHHELD';
			    			include('../academic/includes/print_board_results.php');
			   			 }
					}else{
						if($ovremark==$ovr){
							if($due<=$debtorlimit){
							include('../academic/includes/print_board_results.php'); 
				   			 }			
		       			}
					}
						if($fsup=='!'){
							$fsup = '';
								//$overallsuppcount = $overallsuppcount+1;
								
							}elseif (($igrade<>'I') || ($fsup<>'!')){
								//$overallpasscount= $overallpasscount+1;
							}

							if($totalinccount>0){
								$igrade = '';
								//$overallinccount = $overallinccount+1;
							} 
					
					if ($y>800){
						#put page header
						$pdf->addPage();  
						$x=50;
						$y=80;
						$pg=$pg+1;
						$pdf->setFont('Arial', 'I', 8); 
						$pdf->text(530.28, 828.89, 'Page '.$pg);   
						$pdf->text(50, 828.89, 'Printed On '.$today = date("d-m-Y H:i:s"));
						
						#print header
						$pdf->setFont('Arial', '', 13);     
						$pdf->text(174, 60, $ovr.' - '.$class.' - '.strtoupper($listitle).' - ACADEMIC REPORT'); 
						$pdf->setFillColor('rgb', 0, 0, 0); 
				
						$pdf->setFillColor('rgb', 0, 0, 0);   
						$pdf->setFont('Arial', 'B', 10);    
						$pdf->setFillColor('rgb', 0, 0, 0);   
					 
						$pdf->text($x, $y, 'S/N'); 
						$pdf->text($x+38, $y, 'Name'); 
						$pdf->text($x+170, $y, 'RegNo'); 
						$pdf->text($x+238, $y, 'Sex'); 
						$pdf->text($x+260, $y, 'Remarks'); 
						if ($checkbill<>'on'){
						$pdf->text($x+310, $y, 'Invoice'); 
						$pdf->text($x+380, $y, 'Paid'); 
						$pdf->text($x+460, $y, 'Balance'); 
						}
						$pdf->setFont('Arial', '', 8.6); 
						
						$pdf->line($x, $y-15, 570.28, $y-15);       // top year summary line.
						$pdf->line($x, $y+3, 570.28, $y+3);       // top year summary line.
						$pdf->line($x, $y-15, $x, $y+3);               // most left side margin. 
						$pdf->line($x+35, $y-15, $x+35, $y+3);               // most left side margin. 
						$pdf->line($x+168, $y-15, $x+168, $y+3);              // most left side margin. 
						$pdf->line($x+236, $y-15, $x+236, $y+3);              // most left side margin. 
						$pdf->line($x+258, $y-15, $x+258, $y+3); 
						if ($checkbill<>'on'){ 
						$pdf->line($x+306, $y-15, $x+306, $y+3);  
						$pdf->line($x+374, $y-15, $x+374, $y+3); 
						$pdf->line($x+458, $y-15, $x+458, $y+3);             // most left side margin. 
						}
						$pdf->line(570.28, $y-15, 570.28, $y+3);       // most right side margin. 
					}
				}
						
			}
    		$pdf->setFillColor('rgb', 0, 0, 0);
			$gt=$n-1;
			$pdf->text(50, $y+20, 'Grand Total: '.$gt);  

			if ($display==1){
			$pdf->setFillColor('rgb', 1, 0, 0);
			$pdf->text(50, $y+40, 'Total Unregistered Students  are: '.$j.'('.round($j/$gt*100,2).'%) - SEE THE RED LINES!');  
			$pdf->setFillColor('rgb', 0, 0, 0);
			}
			$pdf->text(50, $y+60, 'Total Female Students are: '.$fcount.'('.round($fcount/$gt*100,2).'%)');  
			$pdf->text(50, $y+80, 'Total Male Students are: '.$mcount.'('.round($mcount/$gt*100,2).'%)'); 
			if($fmcount<>0){
			$pdf->text(50, $y+100, 'Total Male/Female Unspecified Students are '.$fmcount.'('.round($fmcount/$gt*100,2).'%)'); 
			}

			 #output file
			 $filename = ereg_replace("[[:space:]]+", "",$deg);
			 $pdf->output($filename.'.pdf');
			 
}else{
#get connected to the database and verfy current session
	require_once('../Connections/sessioncontrol.php');
    require_once('../Connections/zalongwa.php');
	
	# initialise globals
	include('lecturerMenu.php');
	
	# include the header
	global $szSection, $szSubSection;
	$szSection = 'Examination';
	$szSubSection = 'Board Reports';
	$szTitle = 'Printing Board Reports';
	include('lecturerheader.php');
$editFormAction = $_SERVER['PHP_SELF'];

mysql_select_db($database_zalongwa, $zalongwa);
$query_studentlist = "SELECT RegNo, Name, ProgrammeofStudy FROM student ORDER BY ProgrammeofStudy  ASC";
$studentlist = mysql_query($query_studentlist, $zalongwa) or die(mysql_error());
$row_studentlist = mysql_fetch_assoc($studentlist);
$totalRows_studentlist = mysql_num_rows($studentlist);

mysql_select_db($database_zalongwa, $zalongwa);
$query_degree = "SELECT ProgrammeCode, ProgrammeName FROM programme ORDER BY ProgrammeName ASC";
$degree = mysql_query($query_degree, $zalongwa) or die(mysql_error());
$row_degree = mysql_fetch_assoc($degree);
$totalRows_degree = mysql_num_rows($degree);

mysql_select_db($database_zalongwa, $zalongwa);
$query_sem = "SELECT Semester FROM terms ORDER BY Semester Limit 2";
$sem = mysql_query($query_sem, $zalongwa) or die(mysql_error());
$row_sem = mysql_fetch_assoc($sem);
$totalRows_sem = mysql_num_rows($sem);

mysql_select_db($database_zalongwa, $zalongwa);
$query_dept = "SELECT Faculty, DeptName FROM department ORDER BY DeptName, Faculty ASC";
$dept = mysql_query($query_dept, $zalongwa) or die(mysql_error());
$row_dept = mysql_fetch_assoc($dept);
$totalRows_dept = mysql_num_rows($dept);
	

$prog=$_POST['degree'];
$cohotyear = $_POST['cohot'];
$ayear = $_POST['ayear'];
$qprog= "SELECT ProgrammeCode, Title FROM programme WHERE ProgrammeCode='$prog'";
$dbprog = mysql_query($qprog);
$row_prog = mysql_fetch_array($dbprog);
$progname = $row_prog['Title'];
$qyear= "SELECT AYear FROM academicyear WHERE AYear='$cohotyear'";
$dbyear = mysql_query($qyear);
$row_year = mysql_fetch_array($dbyear);
$year = $row_year['AYear'];

?>

<form name="form1" method="post" action="<?php echo $editFormAction ?>">
            <div align="center">
			<table width="200" border="0" bgcolor="#CCCCCC">
            <tr>
                  <td colspan="3"><span class="style61">if you want to filter the results by  criteria <span class="style34">Tick the corresponding check box first</span> then select appropriately </span></td>
                </tr>
                <tr>
                  <td nowrap><input name="checkdegree" type="checkbox" id="checkdegree" value="on"></td>
                  <td nowrap><div align="left">Degree Programme:</div></td>
                  <td>
                      <div align="left">
                        <select name="degree" id="degree">
                          <?php
do {  
?>
                          <option value="<?php echo $row_degree['ProgrammeCode']?>"><?php echo $row_degree['ProgrammeName']?></option>
                          <?php
} while ($row_degree = mysql_fetch_assoc($degree));
  $rows = mysql_num_rows($degree);
  if($rows > 0) {
      mysql_data_seek($degree, 0);
	  $row_degree = mysql_fetch_assoc($degree);
  }
?>
                        </select>
                    </div></td></tr>
                <tr>
                  <td><input name="checkcohot" type="checkbox" id="checkcohot" value="on"></td>
                  <td nowrap><div align="left">Cohort of the  Year: </div></td>
                  <td><div align="left">
						<select name="cohot" id="cohot">
                        <?php
								mysql_select_db($database_zalongwa, $zalongwa);
								$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
								$ayear = mysql_query($query_ayear, $zalongwa);
								$row_ayear = mysql_fetch_assoc($ayear);
								$totalRows_ayear = mysql_num_rows($ayear);                       
							do {  
							?>
							<option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
							  <?php
							} while ($row_ayear = mysql_fetch_assoc($ayear));
							  $rows = mysql_num_rows($ayear);
							  if($rows > 0) {
							      mysql_data_seek($ayear, 0);
								  $row_ayear = mysql_fetch_assoc($ayear);
							  }
							?>
                    </select>
                  </div></td>
                </tr>

            	<tr>
                  <td><input name="checkyear" type="checkbox" id="checkyear" value="on"></td>
                  <td nowrap><div align="left">Results of the  Year: </div></td>
                  <td><div align="left">
                    <select name="ayear" id="ayear">
                        <?php
								mysql_select_db($database_zalongwa, $zalongwa);
								$query_ayear = "SELECT AYear FROM academicyear ORDER BY AYear DESC";
								$ayear = mysql_query($query_ayear, $zalongwa);
								$row_ayear = mysql_fetch_assoc($ayear);
								$totalRows_ayear = mysql_num_rows($ayear);                       
							do {  
							?>
							<option value="<?php echo $row_ayear['AYear']?>"><?php echo $row_ayear['AYear']?></option>
							  <?php
							} while ($row_ayear = mysql_fetch_assoc($ayear));
							  $rows = mysql_num_rows($ayear);
							  if($rows > 0) {
							      mysql_data_seek($ayear, 0);
								  $row_ayear = mysql_fetch_assoc($ayear);
							  }
							?>
                    </select>
                  </div></td>
                </tr>     	

         <tr>
                  <td><input name="checksem" type="checkbox" id="checksem" value="on"></td>
                  <td nowrap><div align="left">Semester: </div></td>
                  <td><div align="left">
                    <select name="sem" id="sem">
                        <?php
mysql_select_db($database_zalongwa, $zalongwa);
$query_sem = "SELECT Semester FROM terms ORDER BY Semester Limit 2";
$sem = mysql_query($query_sem, $zalongwa) or die(mysql_error());
$row_sem = mysql_fetch_assoc($sem);
$totalRows_sem = mysql_num_rows($sem);
do {  
?>
                        <option value="<?php echo $row_sem['Semester']?>"><?php echo $row_sem['Semester']?></option>
                        <?php
} while ($row_sem = mysql_fetch_assoc($sem));
  $rows = mysql_num_rows($sem);
  if($rows > 0) {
      mysql_data_seek($sem, 0);
	  $row_sem = mysql_fetch_assoc($sem);
  }
?>
                    </select>
                  </div></td>
                </tr>
            	<tr>
                  <td><input name="checkrem" type="checkbox" id="checkrem" value="on"></td>
                  <td nowrap><div align="left">Overall Remarks </div></td>
                 
                 <td><div align="left">
                    <select name="ovrm" id="ovrm">
                       <option value="ALL">Print All</option>
                       <option value="PASS">PASS</option>
                       <option value="SUPP:">SUPP</option>
                       <option value="REPEAT">REPEAT</option>
                       <option value="INCO">INCOMPLETE</option>
                       <option value="ABSC">ABSCONDED</option>
                       <option value="DISCO">DISCONTINUED</option>
                       <option value="WITHHELD">WITH HELD</option>
                     </select>
                  </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="3"><div align="center">
                   <input name="checkbill" type="checkbox" id="checkbill" value="on" >Hide Billing Values
                   <br><input type="submit" name="PDF"  id="PDF" value="Print PDF">
                  </div></td>
              </tr>
              </table>
              <input name="MM_update" type="hidden" id="MM_update" value="form1">       
  </div>
</form>
<?php
}
include('../footer/footer.php');
?>
