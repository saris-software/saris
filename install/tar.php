<?php
// M-ZIP Library: unzipping files using command line tools
//
// Feel free to use and distribute this but please keep this note intact
// (you may add at the bottom) 
// Please if you make modifications, fix bugs, etc... let me know!
//
//
// (C) Francesco M. Munafo'
//
// EMail: PHPDev (AT) eSurfers (DOT) com
//

if(!defined('M_ZIP')) include('m-ziptar.php'); // INCLUDE ONLY ONCE


if(!defined('UNZIP_CMD')) define('UNZIP_CMD','unzip -o @_SRC_@ -x -d
@_DST_@');

function UnzipAllFiles($zipFile,$zipDir) {
$unzipCmd=UNZIP_CMD;
$unzipCmd=str_replace('@_SRC_@',$zipFile,$unzipCmd);
$unzipCmd=str_replace('@_DST_@',$zipDir,$unzipCmd);
$res=-1; // any nonzero value
$UnusedArrayResult=array();
$UnusedStringResult=exec($unzipCmd,$UnusedArrayResult,$res);
return ($res==0);
} 


// Use it this way:

$zipFile='zalongwa.zip';
$whereToUnzip='../install';

$result=UnzipAllFiles($zipFile,$whereToUnzip);

if($result===FALSE) echo('FAILED TO UNZIP A FILE <br>');
else echo('FILE UNZIPED SUCCESSFULY <br>'); 
unlink($zipFile);