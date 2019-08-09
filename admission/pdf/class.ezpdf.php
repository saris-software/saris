<?php

include_once('class.pdf.php');

class Cezpdf extends Cpdf {
//==============================================================================
// this class will take the basic interaction facilities of the Cpdf class
// and make more useful functions so that the user does not have to 
// know all the ins and outs of pdf presentation to produce something pretty.
//
// IMPORTANT NOTE
// there is no warranty, implied or otherwise with this software.
// 
// version 004 (versioning is linked to class.pdf.php)
//
// Wayne Munro, R&OS Ltd, 7 December 2001
//==============================================================================

var $ez=array('fontSize'=>10); // used for storing most of the page configuration parameters
var $y; // this is the current vertical positon on the page of the writing point, very important
var $ezPages=array(); // keep an array of the ids of the pages, making it easy to go back and add page numbers etc.
var $ezPageCount=0;

function Cezpdf($paper='a4',$orientation='portrait'){
  // Assuming that people don't want to specify the paper size using the absolute coordinates
  // allow a couple of options:
  // paper can be 'a4' or 'letter'
  // orientation can be 'portrait' or 'landscape'
  // or, to actually set the coordinates, then pass an array in as the first parameter.
  // the defaults are as shown.

  if (!is_array($paper)){
    switch (strtolower($paper)){
      case 'letter':
        $size = array(0,0,612,792);
        break;
      case 'a4':
      default:
        $size = array(0,0,598,842);
        break;
    }
    switch (strtolower($orientation)){
      case 'landscape':
        $a=$size[3];
        $size[3]=$size[2];
        $size[2]=$a;
        break;
    }
  } else {
    // then an array was sent it to set the size
    $size = $paper;
  }
  $this->Cpdf($size);
  $this->ez['pageWidth']=$size[2];
  $this->ez['pageHeight']=$size[3];
  
  // also set the margins to some reasonable defaults
  $this->ez['topMargin']=30;
  $this->ez['bottomMargin']=30;
  $this->ez['leftMargin']=30;
  $this->ez['rightMargin']=30;
  
  // set the current writing position to the top of the first page
  $this->y = $this->ez['pageHeight']-$this->ez['topMargin'];
  $this->ezPages[1]=$this->getFirstPageId();
  $this->ezPageCount=1;
}

function ezNewPage(){
  // make a new page, setting the writing point back to the top
  $this->y = $this->ez['pageHeight']-$this->ez['topMargin'];
  // make the new page with a call to the basic class.
  $this->ezPageCount++;
  $this->ezPages[$this->ezPageCount] = $this->newPage();
}

function ezSetMargins($top,$bottom,$left,$right){
  // sets the margins to new values
  $this->ez['topMargin']=$top;
  $this->ez['bottomMargin']=$bottom;
  $this->ez['leftMargin']=$left;
  $this->ez['rightMargin']=$right;
  // check to see if this means that the current writing position is outside the 
  // writable area
  if ($this->y > $this->ez['pageHeight']-$top){
    // then move y down
    $this->y = $this->ez['pageHeight']-$top;
  }
  if ( $this->y < $bottom){
    // then make a new page
    $this->ezNewPage();
  }
}  

function ezStartPageNumbers($x,$y,$size,$pos='left',$pattern='{PAGENUM} of {TOTALPAGENUM}',$num=''){
  // put page numbers on the pages from here.
  // place then on the 'pos' side of the coordinates (x,y).
  // pos can be 'left' or 'right'
  // use the given 'pattern' for display, where (PAGENUM} and {TOTALPAGENUM} are replaced
  // as required.
  // if $num is set, then make the first page this number, the number of total pages will
  // be adjusted to account for this.
  if (!$pos || !strlen($pos)){
    $pos='left';
  }
  if (!$pattern || !strlen($pattern)){
    $pattern='{PAGENUM} of {TOTALPAGENUM}';
  }
  if (!isset($this->ez['pageNumbering'])){
    $this->ez['pageNumbering']=array();
  }
  $this->ez['pageNumbering'][$this->ezPageCount]=array('x'=>$x,'y'=>$y,'pos'=>$pos,'pattern'=>$pattern,'num'=>$num,'size'=>$size);
}

function ezStopPageNumbers(){
  if (!isset($this->ez['pageNumbering'])){
    $this->ez['pageNumbering']=array();
  }
  $this->ez['pageNumbering'][$this->ezPageCount]='stop';
}

function ezPRVTaddPageNumbers(){
  // this will go through the pageNumbering array and add the page numbers are required
  if (isset($this->ez['pageNumbering'])){
    $totalPages = $this->ezPageCount;
    $tmp=$this->ez['pageNumbering'];
    $status=0;
    foreach ($this->ezPages as $pageNum=>$id){
      if (isset($tmp[$pageNum])){
        if (is_array($tmp[$pageNum])){
          // then this must be starting page numbers
          $status=1;
          $info = $tmp[$pageNum];
        } else if ($tmp[$pageNum]=='stop'){
          // then we are stopping page numbers
          $status=0;
        }
      }
      if ($status){
        // then add the page numbering to this page
        if (strlen($info['num'])){
          $num=$pageNum-$info['num'];
        } else {
          $num=$pageNum;
        }
        $total = $totalPages+$num-$pageNum;
        $pat = str_replace('{PAGENUM}',$num,$info['pattern']);
        $pat = str_replace('{TOTALPAGENUM}',$total,$pat);
        $this->reopenObject($id);
        switch($info['pos']){
          case 'right':
            $this->addText($info['x'],$info['y'],$info['size'],$pat);
            break;
          default:
            $w=$this->getTextWidth($info['size'],$pat);
            $this->addText($info['x']-$w,$info['y'],$info['size'],$pat);
            break;
        }
        $this->closeObject();
      }
    }
  }
}

function ezPRVTcleanUp(){
  $this->ezPRVTaddPageNumbers();
}

function ezStream($options=''){
  $this->ezPRVTcleanUp();
  $this->stream($options);
}

function ezOutput($options=0){
  $this->ezPRVTcleanUp();
  return $this->output($options);
}

function ezSetY($y){
  // used to change the vertical position of the writing point.
  $this->y = $y;
  if ( $this->y < $this->ez['marginBottom']){
    // then make a new page
    $this->ezNewPage();
  }
}

function ezSetDy($dy){
  // used to change the vertical position of the writing point.
  // changes up by a positive increment, so enter a negative number to go
  // down the page
  $this->y += $dy;
  if ( $this->y < $this->ez['marginBottom']){
    // then make a new page
    $this->ezNewPage();
  }
}

function ezPrvtTableDrawLines($pos,$gap,$x0,$x1,$y0,$y1,$y2,$col){
  $x0=1000;
  $x1=0;
  $this->setStrokeColor($col[0],$col[1],$col[2]);
//  $pdf->setStrokeColor(0.8,0.8,0.8);
  foreach($pos as $x){
    $this->line($x-$gap/2,$y0,$x-$gap/2,$y2);
    if ($x>$x1){ $x1=$x; };
    if ($x<$x0){ $x0=$x; };
  }
  $this->line($x0-$gap/2,$y0,$x1-$gap/2,$y0);
  if ($y0!=$y1){
    $this->line($x0-$gap/2,$y1,$x1-$gap/2,$y1);
  }
  $this->line($x0-$gap/2,$y2,$x1-$gap/2,$y2);
}

function ezPrvtTableColumnHeadings($cols,$pos,$height,$gap,$size,&$y){
  $y=$y-$height;
  foreach($cols as $colName=>$colHeading){
    $this->addText($pos[$colName],$y,$size,$colHeading);
  }
  $y -= $gap;
}

function ezTable(&$data,$cols='',$title='',$options=''){
  // add a table of information to the pdf document
  // $data is a two dimensional array
  // $cols (optional) is an associative array, the keys are the names of the columns from $data
  // to be presented (and in that order), the values are the titles to be given to the columns
  // $title (optional) is the title to be put on the top of the table
  //
  // $options is an associative array which can contain:
  // 'showLines'=> 0 or 1, default is 1 (1->alternate lines are shaded, 0->no shading)
  // 'showHeadings' => 0 or 1
  // 'shaded'=> 0 or 1, default is 1 (1->alternate lines are shaded, 0->no shading)
  // 'shadeCol' => (r,g,b) array, defining the colour of the shading, default is (0.8,0.8,0.8)
  // 'fontSize' => 10
  // 'textCol' => (r,g,b) array, text colour
  // 'titleFontSize' => 12
  // 'titleGap' => 5 , the space between the title and the top of the table
  // 'lineCol' => (r,g,b) array, defining the colour of the lines, default, black.
  // 'xPos' => 'left','right','center','centre',or coordinate, reference coordinate in the x-direction
  // 'xOrientation' => 'left','right','center','centre', position of the table w.r.t 'xPos' 
  //
  // note that the user will have had to make a font selection already or this will not 
  // produce a valid pdf file.
  
  if (!is_array($data)){
    return;
  }
  
  if (!is_array($cols)){
    // take the columns from the first row of the data set
    reset($data);
    list($k,$v)=each($data);
    if (!is_array($v)){
      return;
    }
    $cols=array();
    foreach($v as $k1=>$v1){
      $cols[$k1]=$k1;
    }
  }
  
  if (!is_array($options)){
    $options=array();
  }

  $defaults = array(
    'shaded'=>1,'showLines'=>1,'shadeCol'=>array(0.8,0.8,0.8),'fontSize'=>10,'titleFontSize'=>12
    ,'titleGap'=>5,'lineCol'=>array(0,0,0),'gap'=>5,'xPos'=>'centre','xOrientation'=>'centre'
    ,'showHeadings'=>1,'textCol'=>array(0,0,0));

  foreach($defaults as $key=>$value){
    if (is_array($value)){
      if (!isset($options[$key]) || !is_array($options[$key])){
        $options[$key]=$value;
      }
    } else {
      if (!isset($options[$key])){
        $options[$key]=$value;
      }
    }
  }

  $middle = ($this->ez['pageWidth']-$this->ez['rightMargin'])/2+($this->ez['leftMargin'])/2;
  // figure out the maximum widths of each column
  $maxWidth=array();
  foreach($cols as $colName=>$colHeading){
    $maxWidth[$colName]=0;
  }
  foreach($data as $row){
    foreach($cols as $colName=>$colHeading){
      $w = $this->getTextWidth($options['fontSize'],(string)$row[$colName]);
      if ($w > $maxWidth[$colName]){
        $maxWidth[$colName]=$w;
      }
    }
  }
  foreach($cols as $colName=>$colTitle){
    $w = $this->getTextWidth($options['fontSize'],(string)$colTitle);
    if ($w > $maxWidth[$colName]){
      $maxWidth[$colName]=$w;
    }
  }
  
  // calculate the start positions of each of the columns
  $pos=array();
  $x=0;
  $t=$x;
  foreach($maxWidth as $colName => $w){
    $pos[$colName]=$t;
    $t=$t+$w+$options['gap'];
  }
  $pos['_end_']=$t;
  // now adjust the table to the correct location accross the page
  switch ($options['xPos']){
    case 'left':
      $xref = $this->ez['leftMargin'];
      break;
    case 'right':
      $xref = $this->ez['rightMargin'];
      break;
    case 'centre':
    case 'center':
      $xref = $middle;
      break;
  }
  switch ($options['xOrientation']){
    case 'left':
      $dx = $xref;
      break;
    case 'right':
      $dx = $xref-$t;
      break;
    case 'centre':
    case 'center':
      $dx = $xref-$t/2;
      break;
  }
  foreach($pos as $k=>$v){
    $pos[$k]=$v+$dx;
  }
  $x0=$x+$dx;
  $x1=$t+$dx;
  
  // ok, just about ready to make me a table
//  $this->setColor($options['lineCol'][0],$options['lineCol'][1],$options['lineCol'][2]);
  $this->setColor($options['textCol'][0],$options['textCol'][1],$options['textCol'][2]);
  $this->setStrokeColor($options['shadeCol'][0],$options['shadeCol'][1],$options['shadeCol'][2]);

  // if the title is set, then do that
  if (strlen($title)){
    $w = $this->getTextWidth($options['titleFontSize'],$title);
    $this->y -= $this->getFontHeight($options['titleFontSize']);
    if ($this->y < $this->ez['bottomMargin']){
      $this->ezNewPage();
      $this->y -= $this->getFontHeight($options['titleFontSize']);
    }
    $this->addText($middle-$w/2,$this->y,$options['titleFontSize'],$title);
    $this->y -= $options['titleGap'];
  }

  $y=$this->y; // to simplify the code a bit
  
  // make the table
  $height = $this->getFontHeight($options['fontSize']);
  $decender = $this->getFontDecender($options['fontSize']);

//  $y0=$y+$height+$decender;
  $y0=$y+$decender;
  $dy=0;
  if ($options['showHeadings']){
    $this->ezPrvtTableColumnHeadings($cols,$pos,$height,$options['gap'],$options['fontSize'],&$y);
    $dy=$options['gap']/2;
  }
  $y1 = $y+$decender+$dy;
//  columnHeadings($pdf,$col,$pos,$height,$gap,$size,$y);
//  $y1=$y+$height+$decender+$options['gap']/2;
//  $y1=$y+$decender+$options['gap']/2;
  
  $cnt=0;
  foreach($data as $row){
    $cnt++;
    $y-=$height;
    if ($y<$this->ez['bottomMargin']){
//      $y2=$y+$height+$decender;
      $y2=$y+$height+$decender;
      if ($options['showLines']){
        $this->ezPrvtTableDrawLines($pos,$options['gap'],$x0,$x1,$y0,$y1,$y2,$options['lineCol']);
      }
      $this->newPage();
//      $this->setColor($options['lineCol'][0],$options['lineCol'][1],$options['lineCol'][2]);
      $this->setColor($options['textCol'][0],$options['textCol'][1],$options['textCol'][2]);
      $y = $this->ez['pageHeight']-$this->ez['topMargin'];
      $y0=$y+$decender;
      if ($options['showHeadings']){
        $this->ezPrvtTableColumnHeadings($cols,$pos,$height,$options['gap'],$options['fontSize'],&$y);
      }
      $y1=$y+$decender+$options['gap']/2;
  //      drawShading($pdf,$y+$decender,$height);
  //      $pdf->setColor(0,0,0);
      $y -= $height;
    }
    if ($options['shaded'] && $cnt%2==0){
      $this->saveState();
      $this->setColor($options['shadeCol'][0],$options['shadeCol'][1],$options['shadeCol'][2],1);
      $this->filledRectangle($x0-$options['gap']/2,$y+$decender,$x1-$x0,$height);
      $this->restoreState();
    }
    // write the actual data
    foreach($cols as $colName=>$colTitle){
      $this->addText($pos[$colName],$y,$options['fontSize'],$row[$colName]);
    }
  }
  $y2=$y+$decender;
  if ($options['showLines']){
    $this->ezPrvtTableDrawLines($pos,$options['gap'],$x0,$x1,$y0,$y1,$y2,$options['lineCol']);
  }
  
  $this->y=$y;
}

function ezText($text,$size=0,$options=''){
  // this will add a string of text to the document, starting at the current drawing
  // position.
  // it will wrap to keep within the margins, including optional offsets from the left
  // and the right, if $size is not specified, then it will be the last one used, or
  // the default value (12 I think).
  // the text will go to the start of the next line when a return code "\n" is found.
  // possible options are:
  // 'left'=> number, gap to leave from the left margin
  // 'right'=> number, gap to leave from the right margin
  // 'justification' => 'left','right','center','centre','full'

  $left = $this->ez['leftMargin'] + (isset($options['left'])?$options['left']:0);
  $right = $this->ez['pageWidth'] - $this->ez['rightMargin'] - (isset($options['right'])?$options['right']:0);
  if ($size<=0){
    $size = $this->ez['fontSize'];
  } else {
    $this->ez['fontSize']=$size;
  }
  
  if (isset($options['justification'])){
    $just = $options['justification'];
  } else {
    $just = 'left';
  }
  
  $height = $this->getFontHeight($size);
  $lines = explode("\n",$text);
  foreach ($lines as $line){
    $start=1;
    while (strlen($line) || $start){
      $start=0;
      $this->y=$this->y-$height;
      if ($this->y < $this->ez['bottomMargin']){
        $this->ezNewPage();
      }
      $line=$this->addTextWrap($left,$this->y,$right-$left,$size,$line,$just);
    }
  }

}

}
?>