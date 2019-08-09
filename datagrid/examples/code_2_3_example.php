<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>PHP DataGrid :: Sample #2-3 (code) - DataGrid divided into 2 parts</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name='keywords' content='php grid, php datagrid, php data grid, datagrid sample, datagrid php, datagrid, grid php, datagrid in php, data grid in php, free php grid, free php datagrid, pear datagrid, datagrid paging' />
    <meta name='description' content='Advanced Power of PHP :: PHP DataGrid - DataGrid divided into 2 parts' />
    <meta content='Advanced Power of PHP' name='author'></meta>
  </head>

<body>


<table width="100%" border="0">
<tr>
<td align="left" valign="top">
<?php
  $pr_rid = isset($_GET['pr_rid']) ? $_GET['pr_rid'] : "";
  $pr_mode = isset($_GET['pr_mode']) ? $_GET['pr_mode'] : "";
  $pr_page_size = isset($_GET['pr_page_size']) ? $_GET['pr_page_size'] : "";
  $pr_p = isset($_GET['pr_p']) ? $_GET['pr_p'] : "";
  $pr_sort_field = isset($_GET['pr_sort_field']) ? $_GET['pr_sort_field'] : "";
  $pr_sort_field_by = isset($_GET['pr_sort_field_by']) ? $_GET['pr_sort_field_by'] : "";
  $pr_sort_type = isset($_GET['pr_sort_type']) ? $_GET['pr_sort_type'] : "";

  $sql_extention = "&pr_page_size=".$pr_page_size."&pr_p=".$pr_p."&pr_sort_field=".$pr_sort_field."&pr_sort_field_by=".$pr_sort_field_by."&pr_sort_type=".$pr_sort_type;

  if(($pr_mode == "edit") || ($pr_mode == "details") || ($pr_mode == "add") || ($pr_mode == "cancel")){
    $_GET['pr_mode'] = "view";
    $_GET['pr_rid'] = "";
    $_REQUEST['pr_mode'] = "view";
    $_REQUEST['pr_rid'] = "";
    if(($pr_mode == "cancel") && ($pr_rid == "-1")){
      $_GET['pr_page_size'] = "";
      $_REQUEST['pr_page_size'] = "";      
    }
  }

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

    // includes database connection parameters
    include_once('install/config.inc.php');
    
    //$DB_USER='username';            
    //$DB_PASS='password';           
    //$DB_HOST='localhost';       
    //$DB_NAME='database_name';    
  
    ob_start();
    $db_conn = DB::factory('mysql');  /* don't forget to change on appropriate db type */
    $result_conn = $db_conn->connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
    if(DB::isError($result_conn)){ die($result_conn->getDebugInfo()); }  
  ##  *** put a primary key on the first place 
    $sql = "
      SELECT 
         demo_presidents.id, 
         demo_presidents.country_id, 
         demo_presidents.name, 
         demo_presidents.birth_date, 
         demo_presidents.status,
         demo_countries.name as country_name, 
         'Edit' as lnk_edit,
         'Details' as lnk_details      
      FROM demo_presidents
      INNER JOIN demo_countries ON demo_presidents.country_id=demo_countries.id 
    ";
  
  ##  *** set needed options and create a new class instance 
    $debug_mode = false;        /* display SQL statements while processing */    
    $messaging = true;          /* display system messages on a screen */ 
    $unique_prefix = "pr_";    /* prevent overlays - must be started with a letter */
    $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
  ##  *** set data source with needed options
    $default_order_field = "id";
    $default_order_type = "ASC";
    $dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);	    
  
  ## +---------------------------------------------------------------------------+
  ## | 2. General Settings:                                                      | 
  ## +---------------------------------------------------------------------------+
   $modes = array(
      "add"	 =>array("view"=>false, "edit"=>false, "type"=>"link"),
      "edit"	 =>array("view"=>false, "edit"=>true,  "type"=>"link", "byFieldValue"=>""),
      "cancel"  =>array("view"=>true, "edit"=>true,  "type"=>"link"),
      "details" =>array("view"=>false, "edit"=>false, "type"=>"link"),
      "delete"  =>array("view"=>true, "edit"=>true,  "type"=>"image")
   );
   $dgrid->SetModes($modes);
  ##  *** allow mulirow operations
    $multirow_option = false;
    $dgrid->AllowMultirowOperations($multirow_option);
  ##  *** set DataGrid caption
   $dg_caption = "Presidents - <a href=index.php>Back to Index</a>";
   $dgrid->SetCaption($dg_caption);
  
  ## +---------------------------------------------------------------------------+
  ## | 3. Printing & Exporting Settings:                                         | 
  ## +---------------------------------------------------------------------------+
  ##  *** set printing option: true(default) or false 
   $printing_option = false;
   $dgrid->AllowPrinting($printing_option);
  
  ## +---------------------------------------------------------------------------+
  ## | 4. Sorting & Paging Settings:                                             | 
  ## +---------------------------------------------------------------------------+
  ##  *** set paging option: true(default) or false 
   $paging_option = true;
   $rows_numeration = false;
   $numeration_sign = "N #";       
   $dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign);
  ##  *** set paging settings
   $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
   $top_paging = array();
   $pages_array = array("10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000");
   $default_page_size = 10;
   $dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size);
  
  ## +---------------------------------------------------------------------------+
  ## | 5. Filter Settings:                                                       | 
  ## +---------------------------------------------------------------------------+
  ##  *** set filtering option: true or false(default)
   $filtering_option = true;
   $show_search_type = false;
   $dgrid->AllowFiltering($filtering_option, $show_search_type);
  ##  *** set aditional filtering settings
   $filtering_fields = array(
      "Name"=>array("table"=>"demo_presidents", "field"=>"name", "source"=>"self", "show_operator"=>false, "default_operator"=>"like%", "order"=>"ASC", "type"=>"textbox", "case_sensitive"=>false, "comparison_type"=>"string"),
   );
   $dgrid->SetFieldsFiltering($filtering_fields);
  
  ## +---------------------------------------------------------------------------+
  ## | 6. View Mode Settings:                                                    | 
  ## +---------------------------------------------------------------------------+
  ##  *** set view mode table properties
   $vm_table_properties = array("width"=>"95%");
   $dgrid->SetViewModeTableProperties($vm_table_properties);  
  ##  *** set columns in view mode
  ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
  ##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
   $vm_colimns = array(
       "name"=>array("header"=>"Name", "type"=>"label",      "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
       "m_birth_date"=>array("header"=>"Date of Birth", "type"=>"label",      "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
       "status"=>array("header"=>"Status", "type"=>"label",      "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
       "country_name"=>array("header"=>"Country", "type"=>"label",      "align"=>"left", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
       "lnk_edit"=>array("header"=>" ", "type"=>"link",       "align"=>"center", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"id", "field_data"=>"lnk_edit", "rel"=>"", "title"=>"", "target"=>"", "href"=>"code_2_3_example.php?pr_mode=edit&pr_rid={0}".$sql_extention.""),
       "lnk_details"=>array("header"=>" ", "type"=>"link",       "align"=>"center", "width"=>"", "wrap"=>"nowrap", "text_length"=>"-1", "tooltip"=>false, "tooltip_type"=>"simple", "case"=>"normal", "summarize"=>"false", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"id", "field_data"=>"lnk_details", "rel"=>"", "title"=>"", "target"=>"", "href"=>"code_2_3_example.php?pr_mode=details&pr_rid={0}".$sql_extention.""),
   );
   $dgrid->SetColumnsInViewMode($vm_colimns);
  
  
  ## +---------------------------------------------------------------------------+
  ## | 7. Add/Edit/Details Mode Settings:                                        | 
  ## +---------------------------------------------------------------------------+
  ##  *** set add/edit mode table properties
   $em_table_properties = array("width"=>"95%");
   $dgrid->SetEditModeTableProperties($em_table_properties);
  ##  *** set details mode table properties
   $dm_table_properties = array("width"=>"95%");
   $dgrid->SetDetailsModeTableProperties($dm_table_properties);
  ##  ***  set settings for add/edit/details modes
    $table_name  = "demo_presidents";
    $primary_key = "id";
    $condition   = "";//table_name.field = ".$_REQUEST['abc_rid'];
    $dgrid->SetTableEdit($table_name, $primary_key, $condition);
  ##  *** set columns in edit mode
   $em_columns = array(
      "name"        =>array("header"=>"Name", "type"=>"textbox",  "align"=>"left", "req_type"=>"rt", "width"=>"120px", "title"=>"Name", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
      "country_id"  =>array("header"=>"Country", "type"=>"textbox", "align"=>"left",  "req_type"=>"rt", "width"=>"120px", "title"=>"Country", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
      "birth_date"  =>array("header"=>"Birth Date", "type"=>"date",  "align"=>"left",    "req_type"=>"rt", "width"=>"120px", "title"=>"Date of Birth", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "calendar_type"=>"floating"),
      "status"      =>array("header"=>"Status", "type"=>"enum",  "align"=>"left",    "req_type"=>"st", "width"=>"120px", "title"=>"Status", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "source"=>"self", "view_type"=>"dropdownlist", "multiple"=>false, "multiple_size"=>"1"),
   );
   $dgrid->SetColumnsInEditMode($em_columns);
  
   $foreign_keys = array(
       "country_id"=>array("table"=>"demo_countries", "field_key"=>"id", "field_name"=>"name", "view_type"=>"dropdownlist", "condition"=>"", "order_by_field"=>"name", "order_type"=>"ASC", "on_js_event"=>""),
   ); 
   $dgrid->SetForeignKeysEdit($foreign_keys);
  
  ## +---------------------------------------------------------------------------+
  ## | 8. Bind the DataGrid:                                                     | 
  ## +---------------------------------------------------------------------------+
  ##  *** bind the DataGrid and draw it on the screen
    $dgrid->Bind();        
    ob_end_flush();
  ##
  ################################################################################   
  ?>
    </td>
  
    <td width="360px" valign="top" align="left">  
  <?php
  if(($pr_mode == "edit") || ($pr_mode == "details") || ($pr_mode == "add")){
    
    $_GET['pr_mode'] = $pr_mode;
    $_GET['pr_rid'] = $pr_rid;
    $_REQUEST['pr_mode'] = $pr_mode;
    $_REQUEST['pr_rid'] = $pr_rid;
    
  ################################################################################
  ##
    ob_start();
    $sql = "
      SELECT 
         demo_presidents.id, 
         demo_presidents.country_id, 
         demo_presidents.name, 
         demo_presidents.birth_date, 
         demo_presidents.status,
         demo_countries.name as country_name, 
         'Edit' as lnk_edit,
         'Details' as lnk_details      
      FROM demo_presidents
      INNER JOIN demo_countries ON demo_presidents.country_id=demo_countries.id 
    ";
    
  ##  *** set needed options and create a new class instance 
    $debug_mode = false;        /* display SQL statements while processing */    
    $messaging = true;          /* display system messages on a screen */ 
    $unique_prefix = "pr_";    /* prevent overlays - must be started with a letter */
    $dgrid1 = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
  ##  *** set data source with needed options
    $default_order_field = "id";
    $default_order_type = "ASC";
    $dgrid1->dataSource($db_conn, $sql, $default_order_field, $default_order_type);	    
  
  ## +---------------------------------------------------------------------------+
  ## | 2. General Settings:                                                      | 
  ## +---------------------------------------------------------------------------+
   $modes = array(
      "add"     =>array("view"=>false, "edit"=>false, "type"=>"link"),
      "edit"    =>array("view"=>false, "edit"=>true,  "type"=>"link", "byFieldValue"=>""),
      "cancel"  =>array("view"=>false, "edit"=>false,  "type"=>"link"),
      "details" =>array("view"=>false, "edit"=>false, "type"=>"link"),
      "delete"  =>array("view"=>false, "edit"=>false,  "type"=>"image")
   );
   $dgrid1->setModes($modes);
  ##  *** set CSS class for datagrid
  ##  *** "default" or "blue" or "gray" or "green" or your own css file 
   $css_class = "default";
   $dgrid1->setCssClass($css_class);
  ##  *** set DataGrid caption
   $dg_caption = "President Info";
   $dgrid1->setCaption($dg_caption);
  
  ## +---------------------------------------------------------------------------+
  ## | 3. Printing & Exporting Settings:                                         | 
  ## +---------------------------------------------------------------------------+
  ##  *** set printing option: true(default) or false 
   $printing_option = false;
   $dgrid1->allowPrinting($printing_option);
  
  ## +---------------------------------------------------------------------------+
  ## | 7. Add/Edit/Details Mode Settings:                                        | 
  ## +---------------------------------------------------------------------------+
  ##  *** set add/edit mode table properties
   $em_table_properties = array("width"=>"370px");
   $dgrid1->setEditModeTableProperties($em_table_properties);
  ##  *** set details mode table properties
   $dm_table_properties = array("width"=>"370px");
   $dgrid1->setDetailsModeTableProperties($dm_table_properties);
  ##  ***  set settings for add/edit/details modes
    $table_name  = "demo_presidents";
    $primary_key = "id";
    $condition   = "";
    $dgrid1->setTableEdit($table_name, $primary_key, $condition);
  ##  *** set columns in edit mode
   $em_columns = array(
      "name"        =>array("header"=>"Name",    "type"=>"textbox",  "align"=>"left",  "req_type"=>"rt", "width"=>"120px", "title"=>"Name", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
      "country_id"  =>array("header"=>"Country", "type"=>"textbox",  "align"=>"left",  "req_type"=>"rt", "width"=>"120px", "title"=>"Country", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
      "birth_date"  =>array("header"=>"Birth Date", "type"=>"date",  "align"=>"left",  "req_type"=>"rt", "width"=>"120px", "title"=>"Date of Birth", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "calendar_type"=>"dropdownlist"),
      "status"      =>array("header"=>"Status",  "type"=>"enum",     "align"=>"left",  "req_type"=>"st", "width"=>"120px", "title"=>"Status", "readonly"=>false, "maxlength"=>"-1", "default"=>"", "unique"=>false, "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "source"=>"self", "view_type"=>"dropdownlist", "multiple"=>false, "multiple_size"=>"1"),
   );
   $dgrid1->setColumnsInEditMode($em_columns);
  
   $foreign_keys = array(
       "country_id"=>array("table"=>"demo_countries", "field_key"=>"id", "field_name"=>"name", "view_type"=>"dropdownlist", "condition"=>"", "order_by_field"=>"name", "order_type"=>"ASC", "on_js_event"=>""),
   ); 
   $dgrid1->setForeignKeysEdit($foreign_keys);
  
  ## +---------------------------------------------------------------------------+
  ## | 8. Bind the DataGrid:                                                     | 
  ## +---------------------------------------------------------------------------+
  ##  *** bind the DataGrid and draw it on the screen
    $dgrid1->bind();        
    ob_end_flush();
  ##
  ################################################################################   
}

?>
</td>
</tr>
</table>


</body>
</html>