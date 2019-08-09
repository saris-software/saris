<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>PHP DataGrid :: Sample #2-6 (code) - Using Master/Detaill DataGrid Structure</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name='keywords' content='php grid, php datagrid, php data grid, datagrid sample, datagrid php, datagrid, grid php, datagrid in php, data grid in php, free php grid, free php datagrid, pear datagrid, datagrid paging' />
    <meta name='description' content='Advanced Power of PHP :: PHP DataGrid - Using Master/Detaill DataGrid Structure' />
    <meta content='Advanced Power of PHP' name='author'></meta>
    <meta name="ROBOTS" content="All" />
    <meta name="revisit-after" content="7 days" />
    <link rel="SHORTCUT ICON" href="http://www.apphp.com/php-datagrid/images/icons/phpdatagrid.ico"/>    
    <link href="../css/style.css" type="text/css" rel="stylesheet" />
  </head>

<body>

<center>
<?php

    $act = isset($_GET['act']) ? $_GET['act'] : "";
    $region_id = isset($_GET['region_id']) ? $_GET['region_id'] : "";
    $regn_p = isset($_GET['regn_p']) ? $_GET['regn_p'] : "";
    $regn_page_size = isset($_GET['regn_page_size']) ? $_GET['regn_page_size'] : "";

    ################################################################################
    ## +---------------------------------------------------------------------------+
    ## | 1. Creating & Calling:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** define a relative (virtual) path to datagrid.class.php file (relatively to the current file)
    ##  *** RELATIVE PATH ONLY ***
    ##  Ex.: "datagrid/datagrid.class.php" or "datagrid.class.php" etc.
      define ("DATAGRID_DIR", "../");                     /* Ex.: "datagrid/" */ 
      define ("PEAR_DIR", "../pear/");                    /* Ex.: "datagrid/pear/" */
  
      require_once(DATAGRID_DIR.'datagrid.class.php');
      require_once(PEAR_DIR.'PEAR.php');
      require_once(PEAR_DIR.'DB.php');

    ##
    ##  *** creating variables that we need for database connection 
        
      // includes database connection parameters
      include_once('install/config.inc.php');
    
      //$DB_USER='username';            
      //$DB_PASS='password';           
      //$DB_HOST='localhost';       
      //$DB_NAME='database_name';    
        
      $db_conn = DB::factory('mysql');  /* don't forget to change on appropriate db type */
      $result_conn = $db_conn->connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
      if(DB::isError($result_conn)){ die($result_conn->getDebugInfo()); }  
    ##  *** put a primary key on the first place 
        $sql = "SELECT
            demo_regions.id,
            IF(demo_regions.id = ".(int)$region_id.", CONCAT('<font color=\"#ff0000\"><b>',demo_regions.name,'</b></font>'), demo_regions.name) as name,
            'View Countries' as link_to_countries
        FROM demo_regions";
            
    ##  *** set needed options and create a new class instance 
      $debug_mode = false;        /* display SQL statements while processing */    
      $messaging = true;          /* display system messages on a screen */ 
      $unique_prefix = "regn_";    /* prevent overlays - must be started with a letter */
      $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
      
    ##  *** set data source with needed options
      $default_order_field = "id";
      $default_order_type = "ASC";
      $dgrid->dataSource($db_conn, $sql, $default_order_field, $default_order_type);

   
    ## +---------------------------------------------------------------------------+
    ## | 2. General Settings:                                                      | 
    ## +---------------------------------------------------------------------------+
     $dg_language = "en";  
     $dgrid->SetInterfaceLang($dg_language);

    ##  *** set layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized 
     $layouts = array("view"=>"0", "edit"=>"0", "details"=>"1", "filter"=>"1"); 
     $dgrid->setLayouts($layouts);

    ##  *** set modes for operations ("type" => "link|button|image") 
    ##  *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
     $modes = array(
         "add"	  =>array("view"=>false, "edit"=>false, "type"=>"link"),
         "edit"	  =>array("view"=>false, "edit"=>false,  "type"=>"link", "byFieldValue"=>""),
         "cancel"  =>array("view"=>false, "edit"=>false,  "type"=>"link"),
         "details" =>array("view"=>false, "edit"=>false, "type"=>"link"),
         "delete"  =>array("view"=>false, "edit"=>false,  "type"=>"image")
     );
     $dgrid->setModes($modes);
    ##  *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
    ##  *** format (in which mode to allow processing of another datagrids)
    ##  *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
    // $anotherDatagrids = array("armo_"=>array("view"=>false, "edit"=>false, "details"=>false));
    // $dgrid->setAnotherDatagrids($anotherDatagrids);  
     $css_class = "x-blue";
     $dgrid->SetCssClass($css_class);
    ##  *** set DataGrid caption
     $dg_caption = "Regions (Master DataGrid) - <a href=index.php>Back to Index</a>";
     $dgrid->setCaption($dg_caption);
    
    ## +---------------------------------------------------------------------------+
    ## | 3. Printing & Exporting Settings:                                         | 
    ## +---------------------------------------------------------------------------+
    ##  *** set printing option: true(default) or false 
     $printing_option = false;
     $dgrid->AllowPrinting($printing_option);

    ## +---------------------------------------------------------------------------+
    ## | 4. Sorting & Paging Settings:                                             | 
    ## +---------------------------------------------------------------------------+
    ##  *** set sorting option: true(default) or false 
     $sorting_option = true;
     $dgrid->AllowSorting($sorting_option);               
    ##  *** set paging option: true(default) or false 
     $paging_option = true;
     $rows_numeration = false;
     $numeration_sign = "N #";
     $dropdown_paging = true;
     $dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign, $dropdown_paging);
    ##  *** set paging settings
     $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
     $top_paging = array();
     $pages_array = array("5"=>"5", "10"=>"10", "15"=>"15", "25"=>"25", "50"=>"50", "100"=>"100");
     $default_page_size = 5;
     $paging_arrows = array("first"=>"|&lt;&lt;", "previous"=>"&lt;&lt;", "next"=>"&gt;&gt;", "last"=>"&gt;&gt;|");
     $dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);

    ## +---------------------------------------------------------------------------+
    ## | 6. View Mode Settings:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** set view mode table properties
     $vm_table_properties = array("width"=>"60%");
     $dgrid->setViewModeTableProperties($vm_table_properties);  
    ##  *** set columns in view mode
    ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
    ##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
     $vm_colimns = array(  
        "id"                =>array("header"=>"ID",     "type"=>"label",   "align"=>"center", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
        "name"              =>array("header"=>"Name",   "type"=>"label", "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
        "link_to_countries" =>array("header"=>"Action", "type"=>"link", "align"=>"center", "width"=>"150px", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"id", "field_data"=>"link_to_countries", "rel"=>"", "title"=>"", "target"=>"_self", "href"=>"code_2_6_example.php?act=details&region_id={0}&regn_p=".$regn_p."&regn_page_size=".$regn_page_size),        
     );
     $dgrid->setColumnsInViewMode($vm_colimns);


    if($act == "details"){
        
        ##  *** put a primary key on the first place 
        $sql=" SELECT   
            demo_countries.id, 
            demo_countries.name, 
            demo_countries.description, 
            demo_countries.picture_url, 
            FORMAT(demo_countries.population, 0) as population, 
            CASE WHEN demo_countries.is_democracy = 1 THEN 'Yes' ELSE 'No' END as is_democracy
        FROM demo_countries 
        WHERE region_id = ".(int)$region_id;         
            
        ##  *** set needed options and create a new class instance 
         $debug_mode = false;        /* display SQL statements while processing */    
         $messaging = true;          /* display system messages on a screen */ 
         $unique_prefix = "cnt_";    /* prevent overlays - must be started with a letter */
         $dgrid1 = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
        
        ##  *** set data source with needed options
         $default_order_field = "name";
         $default_order_type = "ASC";
         $dgrid1->dataSource($db_conn, $sql, $default_order_field, $default_order_type);
         
         $css_class = "x-blue";
         $dgrid1->SetCssClass($css_class);
         
        ##  *** set DataGrid caption
         $dg_caption = "Countries (Detail DataGrid)";
         $dgrid1->setCaption($dg_caption);
        
        ##  *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.) 
         $http_get_vars = array("act", "region_id");
         $dgrid1->SetHttpGetVars($http_get_vars);

        ## +---------------------------------------------------------------------------+
        ## | 3. Printing & Exporting Settings:                                         | 
        ## +---------------------------------------------------------------------------+
        ##  *** set printing option: true(default) or false 
         $printing_option = false;
         $dgrid1->AllowPrinting($printing_option);
        
        ## +---------------------------------------------------------------------------+
        ## | 6. View Mode Settings:                                                    | 
        ## +---------------------------------------------------------------------------+
        ##  *** set view mode table properties
         $vm_table_properties = array("width"=>"60%");
         $dgrid1->setViewModeTableProperties($vm_table_properties);  
        ##  *** set columns in view mode
        ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
        ##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
         $vm_colimns = array(  
            "name"       =>array("header"=>"Name",   "type"=>"label", "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
            "population" =>array("header"=>"Population", "type"=>"label", "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>true|false, "tooltip_type"=>"floating|simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
         );
         $dgrid1->setColumnsInViewMode($vm_colimns);
        
        ## +---------------------------------------------------------------------------+
        ## | 7. Add/Edit/Details Mode settings:                                        | 
        ## +---------------------------------------------------------------------------+
        ##  ***  set settings for edit/details mode
         $em_table_properties = array("width"=>"60%");
         $dgrid1->SetEditModeTableProperties($em_table_properties);
         $dm_table_properties = array("width"=>"60%");
         $dgrid1->SetDetailsModeTableProperties($dm_table_properties);
        ##  ***  set settings for edit/details mode
         $table_name = "demo_countries";
         $primary_key = "id";
         $condition = "";
         $dgrid1->setTableEdit($table_name, $primary_key, $condition);

         $fill_from_array = array("10000"=>"10000", "250000"=>"250000", "5000000"=>"5000000", "25000000"=>"25000000", "100000000"=>"100000000");
         $em_columns = array(
           "region_id"        =>array("header"=>"Region",           "type"=>"textbox",  "width"=>"210px", "req_type"=>"rt", "title"=>"Region Name"),
           "name"             =>array("header"=>"Country",          "type"=>"textbox",  "width"=>"210px", "req_type"=>"ry", "title"=>"Country Name", "unique"=>true),
           "description"      =>array("header"=>"Short Descr.",     "type"=>"textarea", "width"=>"210px", "req_type"=>"rt", "title"=>"Short Description", "edit_type"=>"wysiwyg", "rows"=>"3", "cols"=>"50"),
           "population"       =>array("header"=>"Peoples",          "type"=>"enum",     "source"=>$fill_from_array, "view_type"=>"dropdownlist",  "width"=>"139px", "req_type"=>"ri", "title"=>"Population (Peoples)"),
           "picture_url"      =>array("header"=>"Image URL",        "type"=>"image",    "req_type"=>"st", "width"=>"210px", "title"=>"Picture", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100K", "image_width"=>"100px", "image_height"=>"100px", "file_name"=>"", "host"=>"local"),
           "is_democracy"     =>array("header"=>"Is Democracy",     "type"=>"checkbox", "true_value"=>1, "false_value"=>0,  "width"=>"210px", "req_type"=>"sy", "title"=>"Is Democraty"),
           "independent_date" =>array("header"=>"Independence Day", "type"=>"date",     "req_type"=>"rt", "width"=>"187px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "calendar_type"=>"floating"),
         );
         $dgrid1->SetColumnsInEditMode($em_columns);
        ##  *** set foreign keys for add/edit/details modes (if there are linked tables)
        ##  *** Ex.: "condition"=>"TableName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
        ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
         $foreign_keys = array(
           "region_id"=>array("table"=>"demo_regions", "field_key"=>"id", "field_name"=>"name", "view_type"=>"dropdownlist", "order_by_field"=>"name", "order_type"=>"ASC"),
         ); 
         $dgrid1->SetForeignKeysEdit($foreign_keys);
        
    }

    ################################################################################   
    ## +---------------------------------------------------------------------------+
    ## | 8. Bind the DataGrid:                                                     | 
    ## +---------------------------------------------------------------------------+
    ##  *** bind the DataGrid and draw it on the screen
    
    ob_start();    
      $dgrid->Bind();            
        
      if($act == "details"){
          echo "<br>";
          $dgrid1->Bind();                
      }
    ob_end_flush();    
    
    ################################################################################

?>
</center>

</body>
</html>