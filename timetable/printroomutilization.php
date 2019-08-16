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
$prog='miltone';//$_POST['programme'];
$qprog= "SELECT ProgrammeCode, Title, Faculty FROM programme WHERE ProgrammeCode='$prog'";
$dbprog = mysql_query($qprog);
$row_prog = mysql_fetch_array($dbprog);
$programme = $row_prog['Title'];

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
	
	  $objPHPExcel->getActiveSheet()->setTitle('Room Utilization');
	 
	
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
	                    'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
	                                
	                   

	
$ayear = $_POST['ayear'];
$type = $_POST['type'];

if($type == 1){
	$subtitle_timetable = " ACADEMIC YEAR  ".$ayear .' -  SEMESTER I';
}else if($type == 2){
	$subtitle_timetable = " ACADEMIC YEAR  ".$ayear .' - SEMESTER II';
}else if($type == 3){
	$subtitle_timetable = " SEMESTER I EXAMINATION, ACADEMIC YEAR  ".$ayear ;
}else if($type == 4){
	$subtitle_timetable =  "SEMESTER II EXAMINATION, ACADEMIC YEAR  ".$ayear ;
}else if($type == 5){
	$subtitle_timetable =  " SUPPL/SPECIAL EXAMINATION, ACADEMIC YEAR  ".$ayear;
}
// selet all venue
$get_all ="SELECT * FROM venue";
$venue_result = mysql_query($get_all);
$venue_rows = mysql_num_rows($venue_result);

//get all days
$get_all_days ="SELECT * FROM days";
$days_result = mysql_query($get_all_days);
	          
	          
$main_data=array();
$total = array();
$time=array();
$time_total =array();
// loop in all venue
while ($rw = mysql_fetch_array($venue_result)) {
 	$ven = $rw['VenueCode'];
	$f=array();
         $get_all_days ="SELECT * FROM days";
         $days_result = mysql_query($get_all_days);
	
 while ($row = mysql_fetch_array($days_result)) {
      $d=$row['id'];
 	$sql_count = "SELECT venue FROM timetable WHERE AYear ='$ayear' AND timetable_category='$type' AND venue='$ven' AND day='$d'";
 	$count_result = mysql_query($sql_count);
 	$ftc=mysql_num_rows($count_result);
 	
 	//get all period data 
 	$get_all_period = "SELECT * FROM timetable WHERE AYear ='$ayear' AND timetable_category='$type' AND venue='$ven' AND day='$d'";
 	$all_time = mysql_query($get_all_period);
 	$totat_time_in_day = 0;
 	while ($rr = mysql_fetch_array($all_time)) {
 		$totat_time_in_day += $rr['end']-$rr['start'];
 	}
 	
 	$time[$ven][$d] = $totat_time_in_day;
 	
 	$main_data[$ven][$d]=$ftc;
 		if(array_key_exists($ven, $total)){
 			$last = $total[$ven];
 			$total[$ven] = ($last+$ftc);
 		}else{
 			$total[$ven] = $ftc;
 		}
 		
 		
 if(array_key_exists($ven, $time_total)){
 			$last = $time_total[$ven];
 			$time_total[$ven] = ($last+$totat_time_in_day);
 		}else{
 			$time_total[$ven] = $totat_time_in_day;
 		}
 		
 		
 	}
 	
 }
 
arsort($total,SORT_NUMERIC);
	         
	          
	          
	         
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
		    ->setCellValue('C3', 'VENUE UTILIZATION REPORT')
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
      // serial number
    $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"S/N");
	$objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($style_header);
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(7);
	$objPHPExcel->getActiveSheet()->getRowDimension($rows)->setRowHeight(20);
	$col++;
	 
	//Venue Code
    $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"Venue Code");
	$objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($style_header);
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(14);
	$objPHPExcel->getActiveSheet()->getRowDimension($rows)->setRowHeight(20);
	$col++;
	
	//Venue Name
    $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"Venue Name");
	$objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($style_header);
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(30);
	$objPHPExcel->getActiveSheet()->getRowDimension($rows)->setRowHeight(20);
	$col++;
	
	//Days
	$sql = "SELECT * FROM days";
	$re=mysql_query($sql);
	while ($row = mysql_fetch_array($re)) {
		
	        $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$row['name']);
            $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($style_header);
            $col2=$col;
            
            $objPHPExcel->getActiveSheet()->mergeCells($col.$rows.':'.(++$col2).$rows);
            $objPHPExcel->getActiveSheet()->getRowDimension($rows)->setRowHeight(20);
        $col++;
        $col++;
		
	}
	
	        $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,'Total Per Week');
            $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($style_header);
            $col2=$col;
            
            $objPHPExcel->getActiveSheet()->mergeCells($col.$rows.':'.(++$col2).$rows);
            $objPHPExcel->getActiveSheet()->getRowDimension($rows)->setRowHeight(20);
        $col++;
        $col++;
	$rows++;
	$col="C";
	 $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"");
	$objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	$col++;
	
     $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"");
	$objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	$col++;
	
	 $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"");
	$objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	$col++;

	//Days
	$sql = "SELECT * FROM days";
	$re=mysql_query($sql);
	while ($row = mysql_fetch_array($re)) {
		 
		$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"#Period");
	    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	      $col++;
	 
	     $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"#Hours");
	     $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	     $col++;
  	
	}
	
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"#Period");
	    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	      $col++;
	 
	     $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,"#Hours");
	     $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	     $col++;
	  $rows++;
	  $i=1;
foreach ($total as $key => $value) {
$col = "C";
        $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$i++);
	    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	      $col++;
	       $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$key);
	    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	      $col++;
	      
	      $sql = "SELECT * FROM venue WHERE VenueCode='$key'";
	      $ree=mysql_query($sql);
	      $v_name = mysql_fetch_array($ree);
	      
	      $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$v_name['VenueName']);
	    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	      $col++;
	      
	      
	      $sql = "SELECT * FROM days";
	     $re=mysql_query($sql);
	while ($row = mysql_fetch_array($re)) {
		$day = $row['id'];
	
		$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$main_data[$key][$day]);
	    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	      $col++;
	      
	      $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$time[$key][$day]);
	    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	      $col++;
	}
	
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$value);
	    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	      $col++;
	      
	      $objPHPExcel->getActiveSheet()->setCellValue($col.$rows,$time_total[$key]);
	    $objPHPExcel->getActiveSheet()->getStyle($col.$rows)->applyFromArray($set_borders);
	      $col++;
	      
	      
	      
	      
	      
	      $rows++;
		  

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
