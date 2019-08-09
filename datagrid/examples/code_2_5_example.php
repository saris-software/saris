<?php

    $year = isset($_POST['selected_year']) ? $_POST['selected_year'] : @date("Y");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>PHP DataGrid :: Sample #2-5 (code) - using PHP DataGrid Pro for displaying some statistical data</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name='keywords' content='php grid, php datagrid, php data grid, datagrid sample, datagrid php, datagrid, grid php, datagrid in php, data grid in php, free php grid, free php datagrid, pear datagrid, datagrid paging' />
    <meta name='description' content='Advanced Power of PHP :: PHP DataGrid - using PHP DataGrid Pro for displaying some statistical data' />
    <meta content='Advanced Power of PHP' name='author'></meta>
  </head>

<body>

<table width="550px" border=0 align="center">
<tr valign='top'>
    <td align='left'>
        <font style="font-size:16px;font-weight:bold;">Using DataGrid for displaying statistics</font><br>
        <a href=index.php>Back to Index</a>
    </td>
    <td align='right'>
        <form name="frmDownloadStats" action="code_2_5_example.php" method="post">
        <div class='default_dg_caption'>
            &nbsp;&nbsp;&nbsp;
            <select name="selected_year">
                <option <? echo (($year=="2008") ? "selected" : "");?> value="2008">2008</option>
                <option <? echo (($year=="2009") ? "selected" : "");?> value="2009">2009</option>
                <option <? echo (($year=="2010") ? "selected" : "");?> value="2010">2010</option>
                <option <? echo (($year=="2011") ? "selected" : "");?> value="2011">2011</option>
                <option <? echo (($year=="2012") ? "selected" : "");?> value="2012">2012</option>
            </select>
            &nbsp;&nbsp;&nbsp;
            <input type="submit" name="btnSubmit" value="Show" />            
        </div>
        </form>
    </td>
</tr>
</table>
<br>

<center>
<?php    

    ################################################################################
    ## +---------------------------------------------------------------------------+
    ## | 1. Creating & Calling:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** define a relative (virtual) path to datagrid.class.php file
    ##  *** (relatively to the current file)
    ##  *** RELATIVE PATH ONLY ***     
        define ("DATAGRID_DIR", "../");                     /* Ex.: "datagrid/" */ 
        define ("PEAR_DIR", "../pear/");                    /* Ex.: "datagrid/pear/" */
  
        require_once(DATAGRID_DIR.'datagrid.class.php');
        require_once(PEAR_DIR.'PEAR.php');
        require_once(PEAR_DIR.'DB.php');

    ##
    ##  *** creating variables that we need for database connection
     
      //ob_start();
      $db_conn = DB::factory('mysql');  /* don't forget to change on appropriate db type */
      
        // includes database connection parameters
        include_once('install/config.inc.php');
        
        //$DB_USER='username';            
        //$DB_PASS='password';           
        //$DB_HOST='localhost';       
        //$DB_NAME='database_name';    
      
      $result_conn = $db_conn->connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
      if(DB::isError($result_conn)){ die($result_conn->getDebugInfo()); }  
    
    //////////////////////////////////////////////////////////////////////////////// 
    //
    // TOTAL
    //
    ////////////////////////////////////////////////////////////////////////////////
    
    ################################################################################   
    ##  *** put a primary key on the first place 
      $sql = "SELECT
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-01-01' AND demo_downloads.download_date < '".$year."-02-01') as month1,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-02-01' AND demo_downloads.download_date < '".$year."-03-01') as month2,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-03-01' AND demo_downloads.download_date < '".$year."-04-01') as month3,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-04-01' AND demo_downloads.download_date < '".$year."-05-01') as month4,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-05-01' AND demo_downloads.download_date < '".$year."-06-01') as month5,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-06-01' AND demo_downloads.download_date < '".$year."-07-01') as month6,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-07-01' AND demo_downloads.download_date < '".$year."-08-01') as month7,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-08-01' AND demo_downloads.download_date < '".$year."-09-01') as month8,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-09-01' AND demo_downloads.download_date < '".$year."-10-01') as month9,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-10-01' AND demo_downloads.download_date < '".$year."-11-01') as month10,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-11-01' AND demo_downloads.download_date < '".$year."-12-01') as month11,
            (SELECT COUNT(*) FROM demo_downloads WHERE demo_downloads.download_date >= '".$year."-12-01' AND demo_downloads.download_date < '".($year+1)."-01-01') as month12
        FROM demo_downloads 
        GROUP BY month1, month2, month3, month4 ";         
            
    ##  *** set needed options and create a new class instance 
      $debug_mode = false;        /* display SQL statements while processing */    
      $messaging = true;          /* display system messages on a screen */ 
      $unique_prefix = "prd_";    /* prevent overlays - must be started with a letter */
      $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
      $dgrid->SetCssClass("pink");
      $dgrid->DisplayLoadingImage("true");
      $dgrid->AllowPaging(false, "", "");
            
    ##  *** set data source with needed options
      $default_order_field = "download_date";
      $default_order_type = "DESC";
      $dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);
    
    ##  *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
     $modes = array(
         "add"     =>array("view"=>false, "edit"=>false, "type"=>"link"),
         "edit"    =>array("view"=>false, "edit"=>false,  "type"=>"link", "byFieldValue"=>""),
         "cancel"  =>array("view"=>false, "edit"=>false,  "type"=>"link"),
         "details" =>array("view"=>false, "edit"=>false, "type"=>"link"),
         "delete"  =>array("view"=>false, "edit"=>false,  "type"=>"image")
     );
     $dgrid->SetModes($modes);
    ##  *** set DataGrid caption
     $dg_caption = "Statistical data for ".$year." Year";
     $dgrid->SetCaption($dg_caption);
     $dgrid->AllowPrinting(false);
     $dgrid->AllowSorting(false);
     $dgrid->AllowHighlighting(false);
     
    ## +---------------------------------------------------------------------------+
    ## | 6. View Mode Settings:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** set view mode table properties
     $vm_table_properties = array("width"=>"444px");
     $dgrid->SetViewModeTableProperties($vm_table_properties);  
     $max_value = "15";
     $vm_colimns = array(  
        "month1"  =>array("header"=>"Jan", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month2"  =>array("header"=>"Feb", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month3"  =>array("header"=>"Mar", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month4"  =>array("header"=>"Apr", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month5"  =>array("header"=>"May", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month6"  =>array("header"=>"Jun", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month7"  =>array("header"=>"Jul", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month8"  =>array("header"=>"Aug", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month9"  =>array("header"=>"Sep", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month10"  =>array("header"=>"Oct", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
        "month11"  =>array("header"=>"Nov", "type"=>"barchart",  "align"=>"center", "width"=>"", "wrap"=>"nowrap", "visible"=>"true", "on_js_event"=>"", "field"=>"", "maximum_value"=>$max_value, "display_type"=>"vertical"),
     );
     $dgrid->SetColumnsInViewMode($vm_colimns);
    
    ## +---------------------------------------------------------------------------+
    ## | 8. Bind the DataGrid:                                                     | 
    ## +---------------------------------------------------------------------------+
    ##  *** bind the DataGrid and draw it on the screen
      $dgrid->Bind();        
      //ob_end_flush();
    ##
    ################################################################################   

?>
</center>

</body>
</html>