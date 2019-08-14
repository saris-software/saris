<?php 
require_once('../Connections/zalongwa.php'); 
require_once('../Connections/sessioncontrol.php');
/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once '../Classes/PHPExcel.php';

$papersize='PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4';
$fontstyle='Arial';
$font=10.5;
$prog=$_POST['degree'];
$qprog= "SELECT ProgrammeCode, Title, Faculty FROM programme WHERE ProgrammeCode='$prog'";
$dbprog = mysql_query($qprog);
$row_prog = mysql_fetch_array($dbprog);
$programme = $row_prog['Title'];
  $keys=array();

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Zalongwa")
							 ->setLastModifiedBy("Juma Lungo")
							 ->setTitle($programme)
							 ->setSubject("Semester Exam Results")
							 ->setDescription("Semester Exam Results.")
							 ->setKeywords("zalongwa saris software")
							 ->setCategory("Exam result file");
	
	$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
	
	# Set protected sheets to 'true' kama hutaki waandike waziedit sheets zako. Kama unataka wazi-edit weka 'false'
	$objPHPExcel->getActiveSheet()->getProtection()->setSheet(false);
	
	#set worksheet orientation and size
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize($papersize);
	
	#Set page fit width to true
	$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
	
	
	//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&BPlease treat this document as confidential!');
	#Set footer page numbers
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B Prepared by Zalongwa SARIS' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
	
	#Show or hide grid lines
	$objPHPExcel->getActiveSheet()->setShowGridlines(false);
	
	#Set sheet style (fonts and font size)
	$objPHPExcel->getDefaultStyle()->getFont()->setName($fontstyle);
	$objPHPExcel->getDefaultStyle()->getFont()->setSize($font); 
	
	#Set page margins
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);
	
	# Set Rows to repeate in each page
	$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);

	// Set properties
$objPHPExcel->getProperties()->setCreator("Zalongwa")
							 ->setLastModifiedBy("Juma Lungo")
							 ->setTitle('Timetable')
							 ->setSubject("Timetable")
							 ->setDescription("Timetable")
							 ->setKeywords("zalongwa saris software")
							 ->setCategory("Timetable Report");
	
	  $objPHPExcel->getActiveSheet()->setTitle('Timetable');
	 
	
	// style used in formating border of the cell
	$default_border = array(
	         'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array('rgb'=>'1006A3') );
	
	$set_borders = array(
	 'borders' => array( 
	               'bottom' => $default_border, 
	               'left' => $default_border,
	               'top' => $default_border,
	               'right' => $default_border, ),
	         
	);
	
	$style_header = array(
	       'borders' => array( 
	               'bottom' => $default_border, 
	               'left' => $default_border,
	               'top' => $default_border,
	               'right' => $default_border, ), 
	         
	       'fill' => array( 
	             'type' => PHPExcel_Style_Fill::FILL_SOLID, 
	             'color' => array(
	                    'rgb'=>'E1E0F7'),
	                   ),
	         'font' => array( 
	               'bold' => true, ) );
	                   
	                   
	  $style_shade = array(
	       'borders' => array( 
	               'bottom' => $default_border, 
	               'left' => $default_border,
	               'top' => $default_border,
	               'right' => $default_border, ), 
	         
	       'fill' => array( 
	             'type' => PHPExcel_Style_Fill::FILL_SOLID, 
	             'color' => array(
	                    'rgb'=>'DFD7CF'),
	                   ),
	                   
	    'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),    
	          );

	          
	    $default = array(
	         'style' => PHPExcel_Style_Border::BORDER_THIN,
	          'color' => array('rgb'=>'D7BE93') );
	      
	  $shade_days = array(
	       'borders' => array( 
	               'bottom' =>$default, 
	               'left' => $default,
	                'top' => $default,
	               'right' =>$default,      
	              ), 
	         
	       'fill' => array( 
	             'type' => PHPExcel_Style_Fill::FILL_SOLID, 
	             'color' => array(
	                    'rgb'=>'D7BE93'),
	                   ),
	      
	          );        
	                                
	                   
	
	
	///////////////////////////////////////////
	
	  $ayear =$_POST['ayear'];
	  $programme=$_POST['programme'];
	  $type =$_POST['type']; 
	  $fby = $_POST['fby'];                
	                   
	                   if($fby == 1){
	 $sql = "SELECT * FROM timetable WHERE AYear='$ayear' AND Programme='$programme' AND timetable_category='$type' ORDER BY day,start ASC";
	                   // generate timetable title
              $sql_title = "SELECT * FROM programme WHERE ProgrammeCode='$programme'";
	  $title_result = mysql_query($sql_title);
	  $fetch_title = mysql_fetch_array($title_result);
	    $title_timetable = $fetch_title['Title'].' - [ '.$fetch_title['ProgrammeName'].' ] ';
	 
             if($type == 1){
	       $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER I - '.$ayear;
             }else if($type == 2){
            $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER II - '.$ayear;
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER I - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER II - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'SUPPL/SPECIAL EXAMINATION TIMETABLE   - '.$ayear;	
             }
	                   
	                   
	                   }else if($fby == 2){
		
		$sql_faculty = "SELECT * FROM faculty WHERE FacultyID='$programme'";
		$result_faculty = mysql_query($sql_faculty);
		$data=mysql_fetch_array($result_faculty);
		$fc_ID = $programme;
		$fc_name = $data['FacultyName'];
		  $sql_progr = "SELECT DISTINCT ProgrammeCode FROM programme WHERE Faculty='$fc_ID' OR Faculty='$fc_name'";
		
		$facult_prog = mysql_query($sql_progr);
		//$loop_prog_value='';
		while ($row = mysql_fetch_array($facult_prog)) {
			$pg = $row['ProgrammeCode'];
			$loop_prog_value.="  Programme='$pg' OR ";
		}
		
		$loop_prog_value =rtrim($loop_prog_value," OR ");
		
		  $loop_prog_value = " AND (". $loop_prog_value.' ) ';
		  
	   $sql = "SELECT * FROM timetable WHERE AYear='$ayear' $loop_prog_value AND timetable_category='$type' ORDER BY day,start ASC";
		
	   
	   // get title
	   $title_timetable = $fc_name;
	 
             if($type == 1){
	       $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER I - '.$ayear;
             }else if($type == 2){
            $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER II - '.$ayear;
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER I - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER II - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'SUPPL/SPECIAL EXAMINATION TIMETABLE   - '.$ayear;	
             }
	   
	   
	   
	   
	}else if($fby == 3){
	 $sql = "SELECT * FROM timetable WHERE AYear='$ayear' AND lecturer='$programme' AND timetable_category='$type' ORDER BY day,start ASC";
	
	// generate timetable title
      $sql_title = "SELECT * FROM security WHERE UserName='$programme'";
	  $title_result = mysql_query($sql_title);
	  $fetch_title = mysql_fetch_array($title_result);
	    $title_timetable = $fetch_title['FullName'];
	 
             if($type == 1){
	       $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER I - '.$ayear;
             }else if($type == 2){
            $subtitle_timetable = 'ACADEMIC TIMETABLE  SEMESTER II - '.$ayear;
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER I - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'EXAMINATION TIMETABLE  SEMESTER II - '.$ayear;	
             }elseif($type == 3){
             $subtitle_timetable = 'SUPPL/SPECIAL EXAMINATION TIMETABLE   - '.$ayear;	
             }
	 
	 
	 
	 
	}
	 $result = mysql_query($sql);
	 $num = mysql_num_rows($result);
	$timetable=array();
	
	while ($row = mysql_fetch_array($result)) {
			$usern = $row['lecturer'];
			$sql_lect = "SELECT * FROM security WHERE UserName='$usern'";
			$result_lect = mysql_query($sql_lect);
			$lecturer_name = mysql_fetch_array($result_lect);
			$keys[$row['CourseCode']]=$row['CourseCode'];
			$teaching = $row['teachingtype'];
			$sql_teach = "SELECT * FROM teachingtype WHERE id='$teaching'";
			$result_teach = mysql_query($sql_teach);
			$teach_type = mysql_fetch_array($result_teach);
			
			
			$timetable[$row['day']][$row['start']][]=array(
			                           'interval'=>$row['start_end'],
			                            'start'=>$row['start'],
			                            'end'=>$row['end'],
			                            'course'=>$row['CourseCode'],
			                            'venue'=>$row['venue'],
			                             'lecturer'=>$lecturer_name['FullName'],
			                               'teaching'=>$teach_type['name']
			                               );
		}                 
	      // echo '<pre>';
	       //print_r($timetable);
	       //echo '</pre>';            
	         //          exit;
	 #Get Organisation Name
	$qorg = "SELECT * FROM organisation";
	$dborg = mysql_query($qorg);
	$row_org = mysql_fetch_assoc($dborg);
	$org = $row_org['Name'];        
		
		$objPHPExcel->getActiveSheet()->mergeCells('C2:P2');
	$objPHPExcel->getActiveSheet()->mergeCells('C3:P3');
	$objPHPExcel->getActiveSheet()->mergeCells('C4:P4');
	$objPHPExcel->getActiveSheet()
		    ->setCellValue('C2', strtoupper($org))
		    ->setCellValue('C3', strtoupper($title_timetable))
		    ->setCellValue('C4', strtoupper($subtitle_timetable));
	$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(25); 
	$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(20);
	$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setSize(17);
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(26);
	$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(26);
	$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(26);
	$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(26);
	$objPHPExcel->getActiveSheet()->getStyle('C1:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
		
		
		
		
#Set sheet style (fonts and font size)
	$objPHPExcel->getDefaultStyle()->getFont()->setName($fontstyle);
	$objPHPExcel->getDefaultStyle()->getFont()->setSize($font); 
	
	
	$col = "C";
	$rows = 7;
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"Days/Time");
	$objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($style_header);
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(12);
	for ($i=7; $i< 20; $i++){
		$col++;
		$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(12);
		$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$i.':00 - '.($i+1).':00');
		$objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($style_header);
	}	
$rows++;
	#freez
	//$objPHPExcel->getActiveSheet()->freezePane($col.$rows);
			
$sql_day = "SELECT * FROM days ORDER BY id ASC";
$get = mysql_query($sql_day); 
$row1=$rows;
$row2=$rows;
$row3 =$rows;
$start = $rows;
$tracker=array();
$cell_data=array();
while ($row = mysql_fetch_array($get)) {
$col="C";
$kk = "B";
$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$row['name']);
$objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
$col++;
$kk++;
 $yy = array();
 $xx = array();
 if(array_key_exists($row['id'], $timetable)){
 	       $ll = $rows;
 	      
			for ( $p=7; $p < 20;$p++) {
			$loop = $ll;	
				
				if(array_key_exists($p, $timetable[$row['id']])){
                               
					foreach ($timetable[$row['id']][$p] as $key => $value) { 

						if($value['interval'] == 1){
							
							if(array_key_exists($loop, $yy) && array_key_exists($loop, $xx)){
						  
						if(array_key_exists($kk, $yy[$loop]) && array_key_exists($kk, $xx[$loop])){
						
							if($yy[$loop][$kk] != $xx[$loop][$kk]){
								$loop++;
							}
						}
					}
					
			$kipind = $value['teaching']."\n". $value['course']."\n".$value['venue']."\n". $value['start'].':00 - '.$value['end'].':00';
            $objPHPExcel->getActiveSheet()->setCellValue($col.$loop,$kipind);
            $objPHPExcel->getActiveSheet()->getStyle($col.$loop)->applyFromArray($style_shade);
            $objPHPExcel->getActiveSheet()->getRowDimension($loop)->setRowHeight(50);
              $cell_data[$loop][$col.'-'.$col]=1;
            $loop++;
            
             
		
		
		 }else if($value['interval'] == 2){
		 	
		                   	if(array_key_exists($loop, $yy) && array_key_exists($loop, $xx)){
						
		                 if(array_key_exists($kk, $yy[$loop]) && array_key_exists($kk, $xx[$loop])){
							
							if($yy[$loop][$kk] != $xx[$loop][$kk]){
								$loop++;
							}
						}
					}
		    $kipind =$value['teaching']."\n".$value['course']."\n".$value['venue']."\n". $value['start'].':00 - '.$value['end'].':00';
            $objPHPExcel->getActiveSheet()->setCellValue($col.$loop,$kipind);
            $objPHPExcel->getActiveSheet()->getStyle($col.$loop)->applyFromArray($style_shade);
            $col2=$col;
            $objPHPExcel->getActiveSheet()->mergeCells($col.$loop.':'.(++$col2).$loop);
            $objPHPExcel->getActiveSheet()->getRowDimension($loop)->setRowHeight(50);
            $yy[$loop][$col]=1;
            $xx[$loop][$col]=2;
           $cell_data[$loop][$col.'-'.$col2]=1;
            $loop++;
            
		 }else if($value['interval'] == 3){
		                   if(array_key_exists($loop, $yy) && array_key_exists($loop, $xx)){
		                  if(array_key_exists($kk, $yy[$loop]) && array_key_exists($kk, $xx[$loop])){
							if($yy[$loop][$kk] != $xx[$loop][$kk]){
								$loop++;
							}
						}
					}
		 $kipind = $value['teaching']."\n".$value['course']."\n".$value['venue']."\n". $value['start'].':00 - '.$value['end'].':00';
            $objPHPExcel->getActiveSheet()->setCellValue($col.$loop,$kipind);
            $objPHPExcel->getActiveSheet()->getStyle($col.$loop)->applyFromArray($style_shade);
            $col2=$col;
            $col2++;
            $objPHPExcel->getActiveSheet()->mergeCells($col.$loop.':'.(++$col2).$loop);
            $objPHPExcel->getActiveSheet()->getRowDimension($loop)->setRowHeight(50);
            $yy[$loop][$col]=1;
            $xx[$loop][$col]=2;
           $cell_data[$loop][$col.'-'.$col2]=1;
            $loop++;
       
        
		  }		
		}
	if($loop > $rows){
		$rows = $loop;
	}
        $col++;
        $kk++;
			}else{ 

 	$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,'');
    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
		$col++;
		$kk++;		
					}
					
			}
		}
		
$cc="C"	;

	
for ($f=0;$f<14;$f++){
	    $objPHPExcel->getActiveSheet()->setCellValue($cc.$rows,'');
		$objPHPExcel->getActiveSheet()->getStyle($cc.$rows)->applyFromArray($set_borders);
		$objPHPExcel->getActiveSheet()->getStyle($cc.$rows)->applyFromArray($shade_days);
		$cc++;	
		
		 
		 	
		 }
	$objPHPExcel->getActiveSheet()->getRowDimension($rows)->setRowHeight(8);
		 $rows++;

	
}
	                   
	/////////////////////////////////////////////////
	//echo '<pre>';
	//print_r($cell_data);
	//echo '</pre>';exit;
	for($s=$start; $s < $rows;$s++){
		$c="C";
		
		for ($f=0;$f<14;$f++){
		$objPHPExcel->getActiveSheet()->getStyle($c.$s)->applyFromArray($set_borders);
		$c++;	
		
			 }
	}

$col="C";
$rows++;

if(count($keys) > 0){
$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,'KEY');
    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
$rows++;	
foreach($keys as $k=>$v){
$col="C";

$sele = "SELECT * FROM course WHERE CourseCode='$k'";
$my=mysql_query($sele);
$fetc = mysql_fetch_array($my);
$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$k);
    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
$col++;
$pcol=$col;
$pcol++;$pcol++;$pcol++;$pcol++;
$objPHPExcel->getActiveSheet()->mergeCells($col.$rows.':'.$pcol.$rows);
$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$fetc['CourseName']);
    $objPHPExcel->getActiveSheet()->getStyle($col.$rows.':'.$pcol.$rows)->applyFromArray($set_borders);
$rows++;
//echo $k .':'. $fetc['CourseName'].'<br/>'; 
}

}





header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="SARIS_Timetable.xls"');
	header('Cache-Control: max-age=0');
	#make pdf
	/*
	header('Content-Type: application/pdf');
	header('Content-Disposition: attachment;filename="SARIS_Exam_Results.pdf"');
	header('Cache-Control: max-age=0');
	*/
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	#make pdf
	// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
$objWriter->save('php://output');
?>
