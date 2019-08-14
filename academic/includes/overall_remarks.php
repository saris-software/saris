<?php

	$query = mysql_query("SELECT ProgrammeCode, Title, Faculty, Ntalevel FROM programme WHERE ProgrammeCode='$deg'");
	$chas = mysql_fetch_array($query);
	$class = $chas['Ntalevel'];
	
	if($class == 'NTA Level 7' || $class == 'NTA Level 8'){
		if(($totalfailed == '0')&&($gpa>='2')){
			$ovremark = 'PASS';
			$overallpasscount = $overallpasscount+1;
			}
		elseif(($totalfailed > '0')&&($gpa>='2')){
			$ovremark = 'SUPP:';
			$overallsuppcount = $overallsuppcount+1;
			}
		elseif(($totalfailed > '0')&&($gpa>='1.7')){
			$ovremark = 'REPEAT';
			$overallrepeatcount = $overallrepeatcount+1;
			}
		else{
			$ovremark = 'DISCO';
			if ($semval==3){
				$ovremark = 'SUPP:';
				}
			$overalldiscocount = $overalldiscocount+1;
			}		
		}
	
	elseif((($class == 'NTA Level 4' || $class == 'NTA Level 5') && ($currentyear<'2012/2013')) || (($currentyear<'2013/2014') && ($class == 'NTA Level 6'))){
		if(($totalfailed == '0')&&($gpa>='2')){
			$ovremark = 'PASS';
			$overallpasscount = $overallpasscount+1;
			}
		elseif(($totalfailed > '0')&&($gpa>='2')){
			$ovremark = 'SUPP:';
			$overallsuppcount = $overallsuppcount+1;
			}
		elseif(($totalfailed > '0')&&($gpa>='1.0')){
			$ovremark = 'REPEAT';
			$overallrepeatcount = $overallrepeatcount+1;
			}
		else{
			$ovremark = 'DISCO';
			if ($semval==3){
				$ovremark = 'SUPP:';
				}
			$overalldiscocount = $overalldiscocount+1;
			}
		}
		
	elseif((($class == 'NTA Level 4' || $class == 'NTA Level 5' || $class == 'NTA Level 6') && ($currentyear>'2012/2013'))){
		if(($totalfailed == '0')){
			$ovremark = 'PASS';
			$overallpasscount = $overallpasscount+1;
			}
		elseif($totalfailed<=($totalcolms/2)){
			$ovremark = 'SUPP:';
			$overallsuppcount = $overallsuppcount+1;
			}
		else{
			$ovremark = 'DISCO';
			$overalldiscocount = $overalldiscocount+1;
			}
		}
		
	elseif($class == 'NTA Level 4' || $class == 'NTA Level 5'){
		if($totalfailed == '0'){
			$ovremark = 'PASS';
			$overallpasscount = $overallpasscount+1;
			}
		elseif(($totalfailed > '0')&&($totalfailed<=($totalcolms/2))){
			$ovremark = 'SUPP:';
			$overallsuppcount = $overallsuppcount+1;
			}
		else{
			$ovremark = 'DISCO';
			if ($semval==3){
				$ovremark = 'SUPP:';
				}
			$overalldiscocount = $overalldiscocount+1;
			}
		}
		
	else{
		if(($totalfailed == 0)&&($gpa>=2)){
			$ovremark = 'PASS';
			$overallpasscount = $overallpasscount+1;
			}
		elseif(($totalfailed > 0)&&($gpa>=2)){
			$ovremark = 'SUPP:';
			$overallsuppcount = $overallsuppcount+1;
			}
		else{
			$ovremark = 'DISCO';
		
			if ($semval==3){
				$ovremark = 'SUPP:';
				}
			$overalldiscocount = $overalldiscocount+1;
			}		
		}
?>
