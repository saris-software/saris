<?php
	#test Final Exam
	if($aescore < 20){
		$grade='E';
		$remark = 'F-EXM';
		$egrade='*';
		$fsup='!';
		$supp='!';
	}	

	#test if CA>=10
	if(($test2score<10)&&($test2score<>'n/a')){
		$grade='E';
		$remark = 'F-CWK';
		$egrade='*';
		$fsup='!';
		$supp='!';
	}elseif($remarks =='Inc'){
		$grade='I';
		$remark = 'ABSC';
		$igrade='I';
	}elseif($marks ==-2){
		$grade='PASS';
		$remark = 'PASS';
	}else{
   }
   
	#prohibit the printing of zeros in coursework and exam
	if ($nullca==1 and $test2score==0){
		$test2score = '';
		$remark = 'ABSC';
	}
	if ($grade=='I' and $marks==0){
		$marks = '';
		$remark = 'ABSC';
	}
?>