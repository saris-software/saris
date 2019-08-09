<?php
class Cpdf {
//======================================================================
// pdf class
//
// wayne munro - R&OS ltd
// pdf@ros.co.nz
// http://www.ros.co.nz/pdf
//
// this code is a little rough in places, but at present functions well enough
// for the uses that we have put it to. There are a number of possible enhancements
// and if there is sufficient interest then we will extend the functionality.
//
// note that the adobe font AFM files are included, along with some serialized versions
// of their crucial data, though if the serialized versions are not there, then this 
// class will re-create them from the base AFM file for the selected font (if it is there).
// At present only the basic fonts are supported (one of the many restrictions)
//
// this does not yet create a linearised pdf file, this is desirable and will be investigated
// also there is no compression or encryption of the content streams, this will also be added
// as soon as possible.
//
// The site above will have the latest news regarding this code, as well as somewhere to
// register interest in being notified as to future enhancements, and to leave feedback.
//
// IMPORTANT NOTE
// there is no warranty, implied or otherwise with this software.
// 
//
// version 0.04
// 7 december 2001
//======================================================================

var $numObj=0;
var $objects = array();
var $catalogId;
var $fonts=array();
var $currentFont;
var $currentFontNum;
var $currentNode;
var $currentPage;
var $currentContents;
var $numFonts=0;
var $currentColour=array('r'=>-1,'g'=>-1,'b'=>-1);
//var $currentFillColour=array('r'=>-1,'g'=>-1,'b'=>-1);
var $currentStrokeColour=array('r'=>-1,'g'=>-1,'b'=>-1);
var $currentLineStyle='';
var $numPages=0;
var $stack=array(); // the stack will be used to place object Id's onto while others are worked on
var $nStack=0;
var $looseObjects=array();
var $addLooseObjects=array();
var $infoObject=0;
var $numImages=0;
var $options=array('compression'=>1);
var $firstPageId;
var $wordSpaceAdjust=0;

function Cpdf ($pageSize=array(0,0,612,792)){
  $this->newDocument($pageSize);
}

function openFont($font){
  // open the font file and return a php structure containing it.
  // first check if this one has been done before and saved in a form more suited to php
  // note that if a php serialized version does not exist it will try and make one, but will
  // require write access to the directory to do it... it is MUCH faster to have these serialized
  // files.
  
  // assume that $font contains both the path and perhaps the extension to the file, split them
  $pos=strrpos($font,'/');
  $dir=substr($font,0,$pos+1);
  $name=substr($font,$pos+1);
  if (substr($name,-4)=='.afm'){
    $name=substr($name,0,strlen($name)-4);
  }
  if (file_exists($dir.'php_'.$name.'.afm')){
    $tmp = file($dir.'php_'.$name.'.afm');
    $this->fonts[$font]=unserialize($tmp[0]);
  } else if (file_exists($dir.$name.'.afm')){
    $data = array();
    $file = file($dir.$name.'.afm');
    foreach ($file as $rowA){
      $row=trim($rowA);
      $pos=strpos($row,' ');
      if ($pos){
        // then there must be some keyword
        $key = substr($row,0,$pos);
        switch ($key){
          case 'FontName':
          case 'FullName':
          case 'FamilyName':
          case 'Weight':
          case 'ItalicAngle':
          case 'IsFixedPitch':
          case 'CharacterSet':
          case 'UnderlinePosition':
          case 'UnderlineThickness':
          case 'Version':
          case 'EncodingScheme':
          case 'CapHeight':
          case 'XHeight':
          case 'Ascender':
          case 'Descender':
          case 'StdHW':
          case 'StdVW':
          case 'StartCharMetrics':
            $data[$key]=trim(substr($row,$pos));
            break;
          case 'FontBBox':
            $data[$key]=explode(' ',trim(substr($row,$pos)));
            break;
          case 'C':
            //C 39 ; WX 222 ; N quoteright ; B 53 463 157 718 ;
            $bits=explode(';',trim($row));
            $dtmp=array();
            foreach($bits as $bit){
              $bits2 = explode(' ',trim($bit));
              if (strlen($bits2[0])){
                if (count($bits2)>2){
                  $dtmp[$bits2[0]]=array();
                  for ($i=1;$i<count($bits2);$i++){
                    $dtmp[$bits2[0]][]=$bits2[$i];
                  }
                } else if (count($bits2)==2){
                  $dtmp[$bits2[0]]=$bits2[1];
                }
              }
            }
            if ($dtmp['C']>0){
              $data['C'][$dtmp['C']]=$dtmp;
            } else {
              $data['C'][$dtmp['N']]=$dtmp;
            }
            break;
          case 'KPX':
            //KPX Adieresis yacute -40
            $bits=explode(' ',trim($row));
            $data['KPX'][$bits[1]][$bits[2]]=$bits[3];
            break;
        }
      }
    }
    $this->fonts[$font]=$data;
    $fp = fopen($dir.'php_'.$name.'.afm','w');
    fwrite($fp,serialize($data));
    fclose($fp);
  }
}

function o_catalog($id,$action,$options=''){
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'catalog','info'=>array());
      $this->catalogId=$id;
      break;
    case 'outlines':
      $this->objects[$id]['info']['outlines']=$options;
      break;
    case 'pages':
      $this->objects[$id]['info']['pages']=$options;
      break;
    case 'viewerPreferences':
      if (!isset($this->objects[$id]['info']['viewerPreferences'])){
        $this->objects[$id]['info']['viewerPreferences']=array();
      }
      foreach($options as $k=>$v){
        switch ($k){
          case 'HideToolbar':
          case 'HideMenuBar':
          case 'HideWindoUI':
          case 'FitWindow':
          case 'CenterWindow':
          case 'NonFullScreenPageMode':
          case 'Direction':
            $this->objects[$id]['info']['viewerPreferences'][$k]=$v;
          break;
        }
      }
      break;
    case 'out':
      $res="\n".$id." 0 obj\n".'<< /Type /Catalog';
      foreach($this->objects[$id]['info'] as $k=>$v){
        switch($k){
          case 'outlines':
            $res.="\n".'/Outlines '.$v.' 0 R';
            break;
          case 'pages':
            $res.="\n".'/Pages '.$v.' 0 R';
            break;
          case 'viewerPreferences':
            $res.="\n".'/ViewerPreferences <<';
            foreach($this->objects[$id]['info']['viewerPreferences'] as $k=>$v){
              $res.="\n/".$k.' '.$v;
            }
            $res.="\n>>\n";
            break;
        }
      }
      $res.=" >>\nendobj";
      return $res;
      break;
  }
}
function o_pages($id,$action,$options=''){
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'pages','info'=>array());
      $this->o_catalog($this->catalogId,'pages',$id);
      break;
    case 'page':
      $this->objects[$id]['info']['pages'][]=$options;
      break;
    case 'procset':
      $this->objects[$id]['info']['procset']=$options;
      break;
    case 'mediaBox':
      $this->objects[$id]['info']['mediaBox']=$options; // which should be an array of 4 numbers
      break;
    case 'font':
      $this->objects[$id]['info']['fonts'][]=array('objNum'=>$options['objNum'],'fontNum'=>$options['fontNum']);
      break;
    case 'xObject':
      $this->objects[$id]['info']['xObjects'][]=array('objNum'=>$options['objNum'],'label'=>$options['label']);
      break;
    case 'out':
      if (count($this->objects[$id]['info']['pages'])){
        $res="\n".$id." 0 obj\n<< /Type /Pages\n/Kids [";
        foreach($this->objects[$id]['info']['pages'] as $k=>$v){
          $res.=$v." 0 R\n";
        }
        $res.="]\n/Count ".count($this->objects[$id]['info']['pages']);
        if ((isset($this->objects[$id]['info']['fonts']) && count($this->objects[$id]['info']['fonts'])) || isset($this->objects[$id]['info']['procset'])){
          $res.="\n/Resources <<";
          if (isset($this->objects[$id]['info']['procset'])){
            $res.="\n/ProcSet ".$this->objects[$id]['info']['procset']." 0 R";
          }
          if (isset($this->objects[$id]['info']['fonts']) && count($this->objects[$id]['info']['fonts'])){
            $res.="\n/Font << ";
            foreach($this->objects[$id]['info']['fonts'] as $finfo){
              $res.="\n/F".$finfo['fontNum']." ".$finfo['objNum']." 0 R";
            }
            $res.=" >>";
          }
          if (isset($this->objects[$id]['info']['xObjects']) && count($this->objects[$id]['info']['xObjects'])){
            $res.="\n/XObject << ";
            foreach($this->objects[$id]['info']['xObjects'] as $finfo){
              $res.="\n/".$finfo['label']." ".$finfo['objNum']." 0 R";
            }
            $res.=" >>";
          }
          $res.="\n>>";
          if (isset($this->objects[$id]['info']['mediaBox'])){
            $tmp=$this->objects[$id]['info']['mediaBox'];
            $res.="\n/MediaBox [".$tmp[0].' '.$tmp[1].' '.$tmp[2].' '.$tmp[3].']';
          }
        }
        $res.="\n >>\nendobj";
      } else {
        $res="\n".$id." 0 obj\n<< /Type /Pages\n/Count 0\n>>\nendobj";
      }
      return $res;
    break;
  }
}
function o_outlines($id,$action,$options=''){
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'outlines','info'=>array('outlines'=>array()));
      $this->o_catalog($this->catalogId,'outlines',$id);
      break;
    case 'outline':
      $this->objects[$id]['info']['outlines'][]=$options;
      break;
    case 'out':
      if (count($this->objects[$id]['info']['outlines'])){
        $res="\n".$id." 0 obj\n<< /Type /Outlines /Kids [";
        foreach($this->objects[$id]['info']['outlines'] as $k=>$v){
          $res.=$v." 0 R ";
        }
        $res.="] /Count ".count($this->objects[$id]['info']['outlines'])." >>\nendobj";
      } else {
        $res="\n".$id." 0 obj\n<< /Type /Outlines /Count 0 >>\nendobj";
      }
      return $res;
      break;
  }
}

function selectFont($fontName){
  // if the font is not loaded then load it and make the required object
  // else just make it the current font
  if (!isset($this->fonts[$fontName])){
    // load the file
    $this->openFont($fontName);
    if (isset($this->fonts[$fontName])){
      $this->numObj++;
      $this->numFonts++;
      $pos=strrpos($fontName,'/');
//      $dir=substr($fontName,0,$pos+1);
      $name=substr($fontName,$pos+1);
      if (substr($name,-4)=='.afm'){
        $name=substr($name,0,strlen($name)-4);
      }
      $this->o_font($this->numObj,'new',$name);
      $this->fonts[$fontName]['fontNum']=$this->numFonts;
    }
  }
  if (isset($this->fonts[$fontName])){
    // so if for some reason the font was not set in the last one then it will not be selected
    $this->currentFont=$fontName;
    $this->currentFontNum=$this->fonts[$fontName]['fontNum'];
  }
  return $this->currentFontNum;
}

function o_font($id,$action,$options=''){
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'font','info'=>array('name'=>$options));
      $fontNum=$this->numFonts;
      $this->objects[$id]['info']['fontNum']=$fontNum;
      // also tell the pages node about the new font
      $this->o_pages($this->currentNode,'font',array('fontNum'=>$fontNum,'objNum'=>$id));
      break;
    case 'out':
      $res="\n".$id." 0 obj\n<< /Type /Font\n/Subtype /Type1\n";
      $res.="/Name /F".$this->objects[$id]['info']['fontNum']."\n";
      $res.="/BaseFont /".$this->objects[$id]['info']['name']."\n";
      $res.="/Encoding /WinAnsiEncoding\n";
//      $res.="/Encoding /MacRomanEncoding\n";
      $res.=">>\nendobj";
      return $res;
      break;
  }
}

function o_procset($id,$action,$options=''){
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'procset','info'=>array());
      $this->o_pages($this->currentNode,'procset',$id);
      break;
    case 'out':
      $res="\n".$id." 0 obj\n[/PDF /Text]";
      $res.="\nendobj";
      return $res;
      break;
  }
}

function o_info($id,$action,$options=''){
  switch ($action){
    case 'new':
      $this->infoObject=$id;
      $date='D:'.date('Ymd');
      $this->objects[$id]=array('t'=>'info','info'=>array('Creator'=>'R and OS php pdf writer, http://www.ros.co.nz','CreationDate'=>$date));
      break;
    case 'Title':
    case 'Author':
    case 'Subject':
    case 'Keywords':
    case 'Creator':
    case 'Producer':
    case 'CreationDate':
    case 'ModDate':
    case 'Trapped':
      $this->objects[$id]['info'][$action]=$options;
      break;
    case 'out':
      $res="\n".$id." 0 obj\n<<\n";
      foreach ($this->objects[$id]['info']  as $k=>$v){
        $res.='/'.$k.' ('.$this->filterText($v).")\n";
      }
      $res.=">>\nendobj";
      return $res;
      break;
  }
}

function o_page($id,$action,$options=''){
  switch ($action){
    case 'new':
      $this->numPages++;
      $this->objects[$id]=array('t'=>'page','info'=>array('parent'=>$this->currentNode,'pageNum'=>$this->numPages));
      $this->o_pages($this->currentNode,'page',$id);
      $this->currentPage=$id;
      //make a contents object to go with this page
      $this->numObj++;
      $this->o_contents($this->numObj,'new',$id);
      $this->currentContents=$this->numObj;
      $this->objects[$id]['info']['contents']=array();
      $this->objects[$id]['info']['contents'][]=$this->numObj;
      $match = ($this->numPages%2 ? 'odd' : 'even');
      foreach($this->addLooseObjects as $oId=>$target){
        if ($target=='all' || $match==$target){
          $this->objects[$id]['info']['contents'][]=$oId;
        }
      }
      break;
    case 'content':
      $this->objects[$id]['info']['contents'][]=$options;
      break;
    case 'out':
      $res="\n".$id." 0 obj\n<< /Type /Page";
      $res.="\n/Parent ".$this->objects[$id]['info']['parent']." 0 R";
      $count = count($this->objects[$id]['info']['contents']);
      if ($count==1){
        $res.="\n/Contents ".$this->objects[$id]['info']['contents'][0]." 0 R";
      } else if ($count>1){
        $res.="\n/Contents [\n";
        foreach ($this->objects[$id]['info']['contents'] as $cId){
          $res.=$cId." 0 R\n";
        }
        $res.="]";
      }
      $res.="\n>>\nendobj";
      return $res;
      break;
  }
}

function o_contents($id,$action,$options=''){
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'contents','c'=>'');
      if (strlen($options) && intval($options)){
        // then this contents is the primary for a page
        $this->objects[$id]['onPage']=$options;
      }
      break;
    case 'out':
      $tmp=$this->objects[$id]['c'];
      $res= "\n".$id." 0 obj\n<<";
      if (function_exists('gzcompress') && $this->options['compression']){
        // then implement ZLIB based compression on this content stream
        $res.=" /Filter /FlateDecode";
        $tmp = gzcompress($tmp);
      }
      $res.=" /Length ".strlen($tmp)." >>\nstream\n".$tmp."\nendstream\nendobj\n";
      return $res;
      break;
  }
}

function o_image($id,$action,$options=''){
  switch($action){
    case 'new':
      // make the new object
      $this->objects[$id]=array('t'=>'image','data'=>$options['data'],'info'=>array());
      $this->objects[$id]['info']['Type']='/XObject';
      $this->objects[$id]['info']['Subtype']='/Image';
      $this->objects[$id]['info']['Width']=$options['iw'];
      $this->objects[$id]['info']['Height']=$options['ih'];
      $this->objects[$id]['info']['ColorSpace']='/DeviceRGB';
      $this->objects[$id]['info']['BitsPerComponent']=8;
      $this->objects[$id]['info']['Filter']='/DCTDecode';
      // assign it a place in the named resource dictionary as an external object, according to
      // the label passed in with it.
      $this->o_pages($this->currentNode,'xObject',array('label'=>$options['label'],'objNum'=>$id));
      break;
    case 'out':
      $tmp=$this->objects[$id]['data'];
      $res= "\n".$id." 0 obj\n<<";
      foreach($this->objects[$id]['info'] as $k=>$v){
        $res.="\n/".$k.' '.$v;
      }
      $res.="\n/Length ".strlen($tmp)." >>\nstream\n".$tmp."\nendstream\nendobj\n";
      return $res;
      break;
  }
}

function newDocument($pageSize=array(0,0,612,792)){
  $this->numObj=0;
  $this->objects = array();
  $this->o_catalog(1,'new');

//  $this->o_catalog(1,'outlines',2);
  $this->o_outlines(2,'new');
  $this->o_pages(3,'new');

  // hard code the page size for now
  $this->o_pages(3,'mediaBox',$pageSize);
  $this->currentNode = 3;

  $this->o_procset(4,'new');

  $this->numObj=4;

  $this->numObj++;
  $this->o_info($this->numObj,'new');

  $this->numObj++;
  $this->o_page($this->numObj,'new');

  // need to store the first page id as there is no way to get it to the user during 
  // startup
  $this->firstPageId = $this->currentContents;
}

function getFirstPageId(){
  return $this->firstPageId;
}

function checkAllHere(){
  // make sure that anything that needs to be in the file has been included
}

function output($debug=0){

  if ($debug){
    // turn compression off
    $this->options['compression']=0;
  }

  $this->checkAllHere();

  $xref=array();
  $content="%PDF-1.3\n";
  $pos=strlen($content);
//  $xref[]=$pos;
  foreach($this->objects as $k=>$v){
    $tmp='o_'.$v['t'];
    $cont=$this->$tmp($k,'out');
    $content.=$cont;
    $xref[]=$pos;
    $pos+=strlen($cont);
  }
  $content.="\nxref\n0 ".(count($xref)+1)."\n0000000000 65535 f \n";
  foreach($xref as $p){
    $content.=substr('0000000000',0,10-strlen($p)).$p." 00000 n \n";
  }
  $content.=
'
trailer
  << /Size '.(count($xref)+1).'
     /Root 1 0 R
     /Info '.$this->infoObject.' 0 R
  >>
startxref
'.$pos.'
%%EOF
';
  return $content;
}

function addContent($content){
  $this->objects[$this->currentContents]['c'].=$content;
}

function filterText($text){
  $text = str_replace('\\','\\\\',$text);
  $text = str_replace('(','\(',$text);
  $text = str_replace(')','\)',$text);
  return $text;
}
function addText($x,$y,$size,$text,$angle=0,$wordSpaceAdjust=0){
  if (!$this->numFonts){$this->selectFont('./fonts/Helvetica');}
  $text=$this->filterText($text);
//  $text = str_replace('\\','\\\\',$text);
//  $text = str_replace('(','\(',$text);
//  $text = str_replace(')','\)',$text);
  if ($angle==0){
    $this->objects[$this->currentContents]['c'].="\n".'BT /F'.$this->currentFontNum.' '.sprintf('%.1f',$size).' Tf '.sprintf('%.3f',$x).' '.sprintf('%.3f',$y);
    if ($wordSpaceAdjust!=0 || $wordSpaceAdjust != $this->wordSpaceAdjust){
      $this->wordSpaceAdjust=$wordSpaceAdjust;
      $this->objects[$this->currentContents]['c'].=' '.sprintf('%.3f',$wordSpaceAdjust).' Tw';
    }
    $this->objects[$this->currentContents]['c'].=' Td ('.$text.') Tj ET';
  } else {
    // then we are going to need a modification matrix
    // assume the angle is in degrees
    $a = deg2rad((float)$angle);
    $tmp = "\n".'BT /F'.$this->currentFontNum.' '.sprintf('%.1f',$size).' Tf ';
    $tmp .= sprintf('%.3f',cos($a)).' '.sprintf('%.3f',(-1.0*sin($a))).' '.sprintf('%.3f',sin($a)).' '.sprintf('%.3f',cos($a)).' ';
    $tmp .= sprintf('%.3f',$x).' '.sprintf('%.3f',$y).' Tm';
    $tmp.= ' ('.$text.') Tj ET';
    $this->objects[$this->currentContents]['c'].=$tmp;
  }
}

function setColor($r,$g,$b,$force=0){
  if ($force || $r!=$this->currentColour['r'] || $g!=$this->currentColour['g'] || $b!=$this->currentColour['b']){
    $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$r).' '.sprintf('%.3f',$g).' '.sprintf('%.3f',$b).' rg';
    $this->currentColour=array('r'=>$r,'g'=>$g,'b'=>$b);
  }
}

function setStrokeColor($r,$g,$b,$force=0){
  if ($force || $r!=$this->currentStrokeColour['r'] || $g!=$this->currentStrokeColour['g'] || $b!=$this->currentStrokeColour['b']){
    $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$r).' '.sprintf('%.3f',$g).' '.sprintf('%.3f',$b).' RG';
    $this->currentStrokeColour=array('r'=>$r,'g'=>$g,'b'=>$b);
  }
}

function line($x1,$y1,$x2,$y2){
  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$x1).' '.sprintf('%.3f',$y1).' m '.sprintf('%.3f',$x2).' '.sprintf('%.3f',$y2).' l S';
}

function curve($x0,$y0,$x1,$y1,$x2,$y2,$x3,$y3){
  // in the current line style, draw a bezier curve from (x0,y0) to (x3,y3) using the other two points
  // as the control points for the curve.
  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$x0).' '.sprintf('%.3f',$y0).' m '.sprintf('%.3f',$x1).' '.sprintf('%.3f',$y1);
  $this->objects[$this->currentContents]['c'].= ' '.sprintf('%.3f',$x2).' '.sprintf('%.3f',$y2).' '.sprintf('%.3f',$x3).' '.sprintf('%.3f',$y3).' c S';
}

function ellipse($x0,$y0,$r1,$r2=0,$angle=0,$nSeg=8){
  // draws an ellipse in the current line style
  // centered at $x0,$y0, radii $r1,$r2
  // if $r2 is not set, then a circle is drawn
  // nSeg is not allowed to be less than 2, as this will simply draw a line (and will even draw a 
  // pretty crappy shape at 2, as we are approximating with bezier curves.
  if ($r1==0){
    return;
  }
  if ($r2==0){
    $r2=$r1;
  }
  if ($nSeg<2){
    $nSeg=2;
  }
  $dt = 2*pi()/$nSeg;
  $dtm = $dt/3;

  if ($angle != 0){
    $a = -1*deg2rad((float)$angle);
    $tmp = "\n q ";
    $tmp .= sprintf('%.3f',cos($a)).' '.sprintf('%.3f',(-1.0*sin($a))).' '.sprintf('%.3f',sin($a)).' '.sprintf('%.3f',cos($a)).' ';
    $tmp .= sprintf('%.3f',$x0).' '.sprintf('%.3f',$y0).' cm';
    $this->objects[$this->currentContents]['c'].= $tmp;
    $x0=0;
    $y0=0;
  }

  $a0=$x0+$r1;
  $b0=$y0;
  $c0=0;
  $d0=$r1;

  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$a0).' '.sprintf('%.3f',$b0).' m ';
  for ($i=1;$i<=$nSeg;$i++){
    // draw this bit of the total curve
    $t1 = $i*$dt;
    $a1 = $x0+$r1*cos($t1);
    $b1 = $y0+$r2*sin($t1);
    $c1 = -$r1*sin($t1);
    $d1 = $r2*cos($t1);
    $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',($a0+$c0*$dtm)).' '.sprintf('%.3f',($b0+$d0*$dtm));
    $this->objects[$this->currentContents]['c'].= ' '.sprintf('%.3f',($a1-$c1*$dtm)).' '.sprintf('%.3f',($b1-$d1*$dtm)).' '.sprintf('%.3f',$a1).' '.sprintf('%.3f',$b1).' c';
    $a0=$a1;
    $b0=$b1;
    $c0=$c1;
    $d0=$d1;    
  }
  $this->objects[$this->currentContents]['c'].=' s'; // small 's' signifies closing the path as well
  if ($angle !=0){
    $this->objects[$this->currentContents]['c'].=' Q';
  }
}

function setLineStyle($width=1,$cap='',$join='',$dash='',$phase=0){
  // this sets the line drawing style.
  // width, is the thickness of the line in user units
  // cap is the type of cap to put on the line, values can be 'butt','round','square'
  //    where the diffference between 'square' and 'butt' is that 'square' projects a flat end past the
  //    end of the line.
  // join can be 'miter', 'round', 'bevel'
  // dash is an array which sets the dash pattern, is a series of length values, which are the lengths of the
  //   on and off dashes.
  //   (2) represents 2 on, 2 off, 2 on , 2 off ...
  //   (2,1) is 2 on, 1 off, 2 on, 1 off.. etc
  // phase is a modifier on the dash pattern which is used to shift the point at which the pattern starts. 

  // this is quite inefficient in that it sets all the parameters whenever 1 is changed, but will fix another day

  $string = '';
  if ($width>0){
    $string.= $width.' w';
  }
  $ca = array('butt'=>0,'round'=>1,'square'=>2);
  if (isset($ca[$cap])){
    $string.= ' '.$ca[$cap].' J';
  }
  $ja = array('miter'=>0,'round'=>1,'bevel'=>2);
  if (isset($ja[$join])){
    $string.= ' '.$ja[$join].' j';
  }
  if (is_array($dash)){
    $string.= ' [';
    foreach ($dash as $len){
      $string.=' '.$len;
    }
    $string.= ' ] '.$phase.' d';
  }
  $this->currentLineStyle = $string;
  $this->objects[$this->currentContents]['c'].="\n".$string;
}

function polygon($p,$np,$f=0){
  $this->objects[$this->currentContents]['c'].="\n";
  $this->objects[$this->currentContents]['c'].=sprintf('%.3f',$p[0]).' '.sprintf('%.3f',$p[1]).' m ';
  for ($i=2;$i<$np*2;$i=$i+2){
    $this->objects[$this->currentContents]['c'].= sprintf('%.3f',$p[$i]).' '.sprintf('%.3f',$p[$i+1]).' l ';
  }
  if ($f==1){
    $this->objects[$this->currentContents]['c'].=' f';
  } else {
    $this->objects[$this->currentContents]['c'].=' S';
  }
}

function filledRectangle($x1,$y1,$width,$height){
  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$x1).' '.sprintf('%.3f',$y1).' '.$width.' '.$height.' re f';
}

function rectangle($x1,$y1,$width,$height){
  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$x1).' '.sprintf('%.3f',$y1).' '.$width.' '.$height.' re S';
}

function newPage(){
  $this->numObj++;
  $this->o_page($this->numObj,'new');
  // and if there has been a stroke or fill colour set, then transfer them
  if ($this->currentColour['r']>=0){
    $this->setColor($this->currentColour['r'],$this->currentColour['g'],$this->currentColour['b'],1);
  }
  if ($this->currentStrokeColour['r']>=0){
    $this->setStrokeColor($this->currentStrokeColour['r'],$this->currentStrokeColour['g'],$this->currentStrokeColour['b'],1);
  }

  // if there is a line style set, then put this in too
  if (strlen($this->currentLineStyle)){
    $this->objects[$this->currentContents]['c'].="\n".$string;
  }

  // the call to the o_page object set currentContents to the present page, so this can be returned as the page id
  return $this->currentContents;
}

function stream($options=''){
  // setting the options allows the adjustment of the headers
  // values at the moment are:
  // 'Content-Disposition'=>'filename'  - sets the filename, though not too sure how well this will 
  //        work as in my trial the browser seems to use the filename of the php file with .pdf on the end
  // 'Accept-Ranges'=>1 or 0 - if this is not set to 1, then this header is not included, off by default
  //    this header seems to have caused some problems despite tha fact that it is supposed to solve
  //    them, so I am leaving it off by default.
  // 'compress'=> 1 or 0 - apply content stream compression, this is on (1) by default
  if (isset($options['compress']) && $options['compress']==0){
    $tmp = $this->output(1);
  } else {
    $tmp = $this->output();
  }
  header("Content-type: application/pdf");
  header("Content-Length: ".strlen(trim($tmp)));
  $fileName = (isset($options['Content-Disposition'])?$options['Content-Disposition']:'file.pdf');
  header("Content-Disposition: inline; filename=".$fileName);
  if (isset($options['Accept-Ranges']) && $options['Accept-Ranges']==1){
    header("Accept-Ranges: ".strlen(trim($tmp))); 
  }
  echo trim($tmp);
}

function getFontHeight($size){
  if (!$this->numFonts){
    $this->selectFont('./fonts/Helvetica');
  }
  // for the current font, and the given size, what is the height of the font in user units
  $h = $this->fonts[$this->currentFont]['FontBBox'][3]-$this->fonts[$this->currentFont]['FontBBox'][1];
  return $size*$h/1000;
}
function getFontDecender($size){
  // note that this will most likely return a negative value
  if (!$this->numFonts){
    $this->selectFont('./fonts/Helvetica');
  }
  $h = $this->fonts[$this->currentFont]['FontBBox'][1];
  return $size*$h/1000;
}

function getTextWidth($size,$text){
  if (!$this->numFonts){
    $this->selectFont('./fonts/Helvetica');
  }
  // hmm, this is where it all starts to get tricky - use the font information to
  // calculate the width of each character, add them up and convert to user units
  $w=0;
  $len=strlen($text);
  $cf = $this->currentFont;
  for ($i=0;$i<$len;$i++){
    $w+=$this->fonts[$cf]['C'][ord($text[$i])]['WX'];
  }
  return $w*$size/1000;
}

function PRVTadjustWrapText($text,$actual,$width,&$x,&$adjust,$justification){
  switch ($justification){
    case 'left':
      return;
      break;
    case 'right':
      $x+=$width-$actual;
      break;
    case 'center':
    case 'centre':
      $x+=($width-$actual)/2;
      break;
    case 'full':
      // count the number of words
      $words = explode(' ',$text);
      $nspaces=count($words)-1;
      if ($nspaces>0){
        $adjust = ($width-$actual)/$nspaces;
      } else {
        $adjust=0;
      }
      break;
  }
}

function addTextWrap($x,$y,$width,$size,$text,$justification='left'){
  // this will display the text, and if it goes beyond the width $width, will backtrack to the 
  // previous space or hyphen, and return the remainder of the text.

  // $justification can be set to 'left','right','center','centre','full'
    
  if (!$this->numFonts){$this->selectFont('./fonts/Helvetica');}
  if ($width<=0){
    // error, pretend it printed ok, otherwise risking a loop
    return '';
  }
  $w=0;
  $break=0;
  $breakWidth=0;
  $len=strlen($text);
  $cf = $this->currentFont;
  $tw = $width/$size*1000;
  for ($i=0;$i<$len;$i++){
    $cOrd = ord($text[$i]);
    if (isset($this->fonts[$cf]['C'][$cOrd]['WX'])){
      $w+=$this->fonts[$cf]['C'][$cOrd]['WX'];
    }
    if ($w>$tw){
      // then we need to truncate this line
      if ($break>0){
        // then we have somewhere that we can split :)
        $tmp = substr($text,0,$break+1);
        $adjust=0;
        $this->PRVTadjustWrapText($tmp,$breakWidth,$width,&$x,&$adjust,$justification);
        $this->addText($x,$y,$size,$tmp,0,$adjust);
        return substr($text,$break+1);
      } else {
        // just split before the current character
        $tmp = substr($text,0,$i);
        $adjust=0;
        $tmpw=($w-$this->fonts[$cf]['C'][ord($text[$i])]['WX'])*$size/1000;
        $this->PRVTadjustWrapText($tmp,$tmpw,$width,&$x,&$adjust,$justification);
        $this->addText($x,$y,$size,$tmp,0,$adjust);
        return substr($text,$i);
      }
    }
    if ($text[$i]=='-'){
      $break=$i;
      $breakWidth = $w*$size/1000;
    }
    if ($text[$i]==' '){
      $break=$i;
      $breakWidth = ($w-$this->fonts[$cf]['C'][ord($text[$i])]['WX'])*$size/1000;
    }
  }
  // then there was no need to break this line
  if ($justification=='full'){
    $justification='left';
  }
  $adjust=0;
  $tmpw=$w*$size/1000;
  $this->PRVTadjustWrapText($text,$tmpw,$width,&$x,&$adjust,$justification);
  $this->addText($x,$y,$size,$text,0,$adjust);
  return '';
}

function saveState(){
  $this->objects[$this->currentContents]['c'].="\nq";
}

function restoreState(){
  $this->objects[$this->currentContents]['c'].="\nQ";
}

function openObject(){
  // make a loose object, the output will go into this object, until it is closed, then will revert to
  // the current one.
  // this object will not appear until it is included within a page.
  // the function will return the object number
  $this->nStack++;
  $this->stack[$this->nStack]=$this->currentContents;
  // add a new object of the content type, to hold the data flow
  $this->numObj++;
  $this->o_contents($this->numObj,'new');
  $this->currentContents=$this->numObj;
  $this->looseObjects[$this->numObj]=1;
  
  return $this->numObj;
}

function reopenObject($id){
   $this->nStack++;
   $this->stack[$this->nStack]=$this->currentContents;
   $this->currentContents=$id;
}

function closeObject(){
  // close the object, as long as there was one open in the first place, which will be indicated by
  // an objectId on the stack.
  if ($this->nStack>0){
    $this->currentContents=$this->stack[$this->nStack];
    $this->nStack--;
    // easier to probably not worry about removing the old entries, they will be overwritten
    // if there are new ones.
  }
}

function stopObject($id){
  // if an object has been appearing on pages up to now, then stop it, this page will
  // be the last one that could contian it.
  if (isset($this->addLooseObjects[$id])){
    $this->addLooseObjects[$id]='';
  }
}

function addObject($id,$options='add'){
  // add the specified object to the page
  if (isset($this->looseObjects[$id]) && $this->currentContents!=$id){
    // then it is a valid object, and it is not being added to itself
    switch($options){
      case 'all':
        // then this object is to be added to this page (done in the next block) and 
        // all future new pages. 
        $this->addLooseObjects[$id]='all';
      case 'add':
        if (isset($this->objects[$this->currentContents]['onPage'])){
          // then the destination contents is the primary for the page
          // (though this object is actually added to that page)
          $this->o_page($this->objects[$this->currentContents]['onPage'],'content',$id);
        }
        break;
      case 'even':
        $this->addLooseObjects[$id]='even';
        $pageObjectId=$this->objects[$this->currentContents]['onPage'];
        if ($this->objects[$pageObjectId]['info']['pageNum']%2==0){
          $this->addObject($id); // hacky huh :)
        }
        break;
      case 'odd':
        $this->addLooseObjects[$id]='odd';
        $pageObjectId=$this->objects[$this->currentContents]['onPage'];
        if ($this->objects[$pageObjectId]['info']['pageNum']%2==1){
          $this->addObject($id); // hacky huh :)
        }
        break;
    }
  }
}

function addInfo($label,$value=0){
  // this will only work if the label is one of the valid ones.
  // modify this so that arrays can be passed as well.
  // if $label is an array then assume that it is key=>value pairs
  // else assume that they are both scalar, anything else will probably error
  if (is_array($label)){
    foreach ($label as $l=>$v){
      $this->o_info($this->infoObject,$l,$v);
    }
  } else {
    $this->o_info($this->infoObject,$label,$value);
  }
}

function setPreferences($label,$value=0){
  // this will only work if the label is one of the valid ones.
  if (is_array($label)){
    foreach ($label as $l=>$v){
      $this->o_catalog($this->catalogId,'viewerPreferences',array($l=>$v));
    }
  } else {
    $this->o_catalog($this->catalogId,'viewerPreferences',array($label=>$value));
  }
}

function addJpegFromFile($img,$x,$y,$w=0,$h=0){
  // attempt to add a jpeg image straight from a file, using no GD commands
  // note that this function is unable to operate on a remote file.

  if (!file_exists($img)){
    return;
  }

  $tmp=getimagesize($img);
  $imageWidth=$tmp[0];
  $imageHeight=$tmp[1];
    
  if ($w<=0 && $h<=0){
    return;
  }
  if ($w==0){
    $w=$h/$imageHeight*$imageWidth;
  }
  if ($h==0){
    $h=$w*$imageHeight/$imageWidth;
  }

  $fp=fopen($img,'r');
  $data = fread($fp,filesize($img));
  fclose($fp);

  $this->addJpegImage_common($data,$x,$y,$w,$h,$imageWidth,$imageHeight);
}

function addImage(&$img,$x,$y,$w=0,$h=0,$quality=75){
  // add a new image into the current location, as an external object
  // add the image at $x,$y, and with width and height as defined by $w & $h
  
  // note that this will only work with full colour images and makes them jpg images for display
  // later versions could present lossless image formats if there is interest.
  
  // there seems to be some problem here in that images that have quality set above 75 do not appear
  // not too sure why this is, but in the meantime I have restricted this to 75.  
  if ($quality>75){
    $quality=75;
  }

  // if the width or height are set to zero, then set the other one based on keeping the image
  // height/width ratio the same, if they are both zero, then give up :)
  $imageWidth=imagesx($img);
  $imageHeight=imagesy($img);
  
  if ($w<=0 && $h<=0){
    return;
  }
  if ($w==0){
    $w=$h/$imageHeight*$imageWidth;
  }
  if ($h==0){
    $h=$w*$imageHeight/$imageWidth;
  }
  
  // gotta get the data out of the img..

/*
  // wanted to use this output buffering code, but it doesn't seem to work and I get an 
  // header sent error message which balses everything up. not sure why this is.
  ob_start();
  imagejpeg($img,'',$quality);
  $data=ob_get_contents();
  ob_end_clean();
*/  

  // so I write to a temp file, and then read it back.. soo ugly, my apologies.
  $tmpDir='/tmp';
  $tmpName=tempnam($tmpDir,'img');
  imagejpeg($img,$tmpName,$quality);
  $fp=fopen($tmpName,'r');
  $data = fread($fp,filesize($tmpName));
  fclose($fp);
  unlink($tmpName);
  $this->addJpegImage_common($data,$x,$y,$w,$h,$imageWidth,$imageHeight);
}

function addJpegImage_common(&$data,$x,$y,$w=0,$h=0,$imageWidth,$imageHeight){
  // note that this function is not to be called externally
  // it is just the common code between the GD and the file options
  $this->numImages++;
  $im=$this->numImages;
  $label='I'.$im;
  $this->numObj++;
  $this->o_image($this->numObj,'new',array('label'=>$label,'data'=>$data,'iw'=>$imageWidth,'ih'=>$imageHeight));

  $this->objects[$this->currentContents]['c'].="\nq";
  $this->objects[$this->currentContents]['c'].="\n".$w." 0 0 ".$h." ".$x." ".$y." cm";
  $this->objects[$this->currentContents]['c'].="\n/".$label.' Do';
  $this->objects[$this->currentContents]['c'].="\nQ";
}

}

?>