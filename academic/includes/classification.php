<?php

	if($class == 'NTA Level 8' || $class == 'NTA Level 7'){
		if($ovgpa >= '4.4' && $ovgpa <= '5.0'){
			$classification = '1ST CLASS';
			}
		elseif($ovgpa >= '3.5' && $ovgpa < '4.4'){
			$classification = '2ND CLASS - UPPER';
			}
		elseif($ovgpa >= '2.7' && $ovgpa < '3.5'){
			$classification = '2ND CLASS -LOWER';
			}
		elseif($ovgpa >= '2.0' && $ovgpa < '2.7'){
			$classification = 'PASS';
			}
		elseif($ovgpa >= '1.7' && $ovgpa < '2.0'){
			$classification = 'REPEAT';
			}
		elseif($ovgpa >= '0.0' && $ovgpa < '1.7'){
			$classification = 'DISCO';
			}
		}
		
	elseif($class == 'NTA Level 6'){
		if($ovgpa >= '4.4' && $ovgpa <= '5.0'){
			$classification = '1ST CLASS';
			}
		elseif($ovgpa >= '3.5' && $ovgpa < '4.4'){
			$classification = '2ND CLASS - UPPER';
			}
		elseif($ovgpa >= '2.7' && $ovgpa < '3.5'){
			$classification = '2ND CLASS -LOWER';
			}
		elseif($ovgpa >= '2.0' && $ovgpa < '2.7'){
			$classification = 'PASS';
			}
		elseif($ovgpa >= '1.0' && $ovgpa < '2.0'){
			$classification = 'REPEAT';
			}
		elseif($ovgpa >= '0.0' && $ovgpa < '1.0'){
			$classification = 'DISCO';
			}
		}
		
	elseif($class == 'NTA Level 5' || $class == 'NTA Level 4'){
		if($ovgpa >= '3.4' && $ovgpa <= '4.0'){
			$classification = '1ST CLASS';
			}
		elseif($ovgpa >= '3.0' && $ovgpa < '3.4'){
			$classification = '2ND CLASS';
			}
		elseif($ovgpa >= '2.0' && $ovgpa < '3.0'){
			$classification = 'PASS';
			}
		elseif($ovgpa >= '1.0' && $ovgpa < '2.0'){
			$classification = 'REPEAT';
			}
		elseif($ovgpa >= '0.0' && $ovgpa < '1.0'){
			$classification = 'DISCO';
			}
		}
		
		if($totalsgp == '0' || $ovgpa == ''){
			$classification = 'ABSC';
			}
?>
