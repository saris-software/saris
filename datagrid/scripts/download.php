<?php

    session_start();    

    $dir  = (isset($_SESSION['datagrid_export_dir']) && $_SESSION['datagrid_export_dir'] != null) ? $_SESSION['datagrid_export_dir'] : "";
    $file = (isset($_SESSION['datagrid_export_file']) && $_SESSION['datagrid_export_file'] != null) ? $_SESSION['datagrid_export_file'] : "";
    $debug = (isset($_SESSION['datagrid_debug']) && $_SESSION['datagrid_debug'] != null) ? $_SESSION['datagrid_debug'] : "";
   
    // define the appropriate path, relatively to download.php
    // 1. For example: $file_path = "../../".$dir.$file; for next structure
    //          export/
    //          datagrid/
    //              - datagrid.class.php
    //              - scripts/
    //                -- download.php
    //
    // 2. For example: $file_path = "../../admin/".$dir.$file; for next structure
    //          admin/
    //              - export/
    //          datagrid/
    //              - datagrid.class.php
    //              - scripts/
    //                -- download.php
    //
    // 3. For example: $file_path = "../".$dir.$file; for next structure
    //          datagrid/
    //              - export/
    //              - datagrid.class.php
    //              - scripts/
    //                -- download.php
    $file_path = '../'.$dir.$file;

    unset($_SESSION['datagrid_export_dir']);
    unset($_SESSION['datagrid_export_file']);
    unset($_SESSION['datagrid_debug']);
    
    // check for hacking attacks
    if(preg_match("/0/", $file) || preg_match("/0/", $dir)){
        echo "Can not find export file! Turn on debug mode to see more info.";
    }
    
    if ((($file == "export.xml") || ($file == "export.csv") || ($file == "export.pdf")) && @file_exists($file_path))
    {
        // strlen() added for security reasons
        header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
        header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header ("Pragma: no-cache"); // HTTP/1.0
        
        header("Content-type: application/force-download"); 
        header('Content-Disposition: inline; filename="'.$file.'"'); 
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-length: ".filesize($file_path)); 
        header('Content-Type: application/octet-stream'); 
        header('Content-Disposition: attachment; filename="'.$file.'"'); 
        readfile($file_path);
    }
    else
    {
        if($debug){
            echo "Can not find such path: $file_path ! Also, check please you added session_start(); in your code";                 
        }else{
            echo "Can not find export file! Turn on debug mode to get more info.";                                         
        }        
    }
    exit(0);

?>