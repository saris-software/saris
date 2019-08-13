<?php 
if ($reportgroup<>'annualhtml'){
	$pdf->setFont('Arial', '', 8); 
}
	if ($semval==1)
   	  {
		$sem1ovremark = $ovremark;	
		if ($reportgroup<>'annualhtml'){
			$pdf->text($x+$cw+202, $y+12, $sem1ovremark);
		}
 	   }elseif ($semval==2){
    	$sem2ovremark = $ovremark;
    	
 	   }else{
 	    
    	switch ($sem1ovremark) 
	    {
			case "PASS":
      			 if ($ovgpa<'1.0')
      			  {
    				$annualovremark='DISCO';
 				  }else{
						
						if ($sem2ovremark=='PASS'){
							$annualovremark='PASS';
						}elseif($sem2ovremark=='SUPP:'){
							$annualovremark='SUPP';
						}elseif($sem2ovremark=='REPEAT'){
							$annualovremark='REPEAT';
						}elseif($sem2ovremark=='DISCO'){
							$annualovremark='DISCO';
						}elseif($sem2ovremark=='ABSC'){
							$annualovremark='ABSC';
						}elseif($sem2ovremark=='INCO'){
							$annualovremark='INCO';
						}
 				  }
						break;
			case "SUPP:":
				if ($ovgpa<'1.0')
      			  {
    				$annualovremark='DISCO';
 				  }else{					
				
						if ($sem2ovremark=='PASS'){
							$annualovremark='SUPP';
						}elseif($sem2ovremark=='SUPP:'){
							$annualovremark='SUPP';
						}elseif($sem2ovremark=='REPEAT'){
							$annualovremark='REPEAT';
						}elseif($sem2ovremark=='DISCO'){
							$annualovremark='DISCO';
						}elseif($sem2ovremark=='ABSC'){
							$annualovremark='ABSC';
						}elseif($sem2ovremark=='INCO'){
							$annualovremark='INCO';
						}
 				  }
						break;
			case "REPEAT":
    					$sem2ovremark = '***';		
						$annualovremark='REPEAT';
						break;
			case "DISCO":
					    $sem2ovremark = '***';			
						$annualovremark='DISCO';
						break;
			case "ABSC":
					    $sem2ovremark = '***';			
						$annualovremark='ABSC';
						break;
			case "INCO":
					    //$sem2ovremark = '***';			
						$annualovremark='INCO';
						break;
			default:
						$sem2ovremark = $sem1ovremark;			
						$annualovremark=$sem1ovremark;
	    }

	    if ($reportgroup<>'annualhtml'){
	    	$pdf->text($x+$cw+35, $y+12, $sem2ovremark);  
		   	$pdf->text($x+$cw+357-$ovrw, $y+12, $annualovremark);
	    }
	   	
	   	#computer summaries
	   	switch ($annualovremark)
	   	{
	   		case "PASS":
  						$goverallpasscount = $goverallpasscount+1;
						break;
			case "SUPP":
						$goverallsuppcount = $goverallsuppcount+1;
						break;
			case "DISCO":
						$goveralldiscocount = $goveralldiscocount+1;
						break;
			case "INCO":
						$goverallincocount = $goverallincocount+1;
						break;
			case "REPEAT":
						$goverallrepeatcount = $goverallrepeatcount+1;
						break;
			case "ABSC":
						$goverallabsccount = $goverallabsccount+1;
						break;
			default:
						$goverallothercount = $goverallotherccount+1;
	   	}
    	if ($gsuppcount>0){
    		//$pdf->text($x+$cw+316, $y+12, '('.$gsuppcount.')');
    }
  }
