<?php
################################################################################
##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                 #
## --------------------------------------------------------------------------- #
##  PHP DataGrid Pro (AJAX enabled) version 6.0.8                              #
##  Developed by:  ApPHP <info@apphp.com>                                      #
##  License:       GNU LGPL v.3                                                #
##  Site:          http://www.apphp.com/php-datagrid/                          #
##  Copyright:     PHP DataGrid (c) 2006-2010. All rights reserved.            #
##  Last changed:  21.04.2010 01:05                                            #
##                                                                             #
##  Additional modules (embedded):                                             #
##  -- openWYSIWYG v1.0.1 (free cross-browser)          http://openWebWare.com #
##  -- PEAR::DB v1.7.14 (PHP Ext.&Application Repository)  http://pear.php.net #
##  -- JS AFV v2.0.1 (JS Auto From Validator)                 http://apphp.com #
##  -- overLIB v4.21 (JS library)           http://www.bosrup.com/web/overlib/ #
##  -- FPDF v1.53 (PDF files generator)                    http://www.fpdf.org #
##  -- JsCalendar v1.0 (DHTML/JavaScript Calendar)      http://www.dynarch.com #
##  -- AutoSuggest v2.1.3 (AJAX autocomplete)  http://www.brandspankingnew.net #
##  -- LyteBox v3.22                              http://www.dolem.com/lytebox #
##  -- jQuery v1.3.2 (JavaScript Library)                    http://jquery.com #
##  -- Scrollable HTML table                        http://www.webtoolkit.info #
##                                                                             # 
################################################################################
## +---------------------------------------------------------------------------+
## | 1. Creating & Calling:                                                    | 
## +---------------------------------------------------------------------------+
##  *** define a relative (virtual) path to datagrid.class.php file
##  *** (relatively to the current file)
##  *** RELATIVE PATH ONLY ***
//  define ("DATAGRID_DIR", "");                     /* Ex.: "datagrid/" */ 
//  define ("PEAR_DIR", "pear/");                    /* Ex.: "datagrid/pear/" */
//
//  require_once(DATAGRID_DIR.'datagrid.class.php');
//  require_once(PEAR_DIR.'PEAR.php');
//  require_once(PEAR_DIR.'DB.php');
##
##  *** creating variables that we need for database connection 
//  $DB_USER='name';            /* usually like this: prefix_name             */
//  $DB_PASS='';                /* must be already encrypted (recommended)    */
//  $DB_HOST='localhost';       /* usually localhost                          */
//  $DB_NAME='dbName';          /* usually like this: prefix_dbName           */
//
//  ob_start();
##  *** (example of ODBC connection string) - odbc
##  *** $result_conn = $db_conn->connect(DB::parseDSN('odbc://root:12345@test_db'));
##  *** (example of Oracle connection string) - oci8
##  *** 1. $DB_NAME = "localhost:1521/mydatabase";
##  ***    $result_conn = $db_conn->connect(DB::parseDSN('oci8://root:12345@localhost/'.$DB_NAME)); 
##  *** 2. $DB_DESCR = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = xx.xx.xx.xx)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = dev.domain.com)))";
##  ***    $result_conn = $db_conn->connect(DB::parseDSN('oci8://root:12345@'.$DB_DESCR)); 
##  *** (example of PostgreSQL connection string) - pgsql
##  *** $result_conn = $db_conn->connect(DB::parseDSN('pgsql://root:12345@localhost/mydatabase')); 
##  *** (example of Firebird connection string)
##  *** $DB_NAME='c:\\program\\firebird21\\data\\db_test.fdb';   
##  *** $db_conn->connect(DB::parseDSN('firebird://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));      
##  === (Examples of connections to other db types see in "docs/pear/" folder)
//  $db_conn = DB::factory('mysql');  /* don't forget to change on appropriate db type */
//  $result_conn = $db_conn->connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
//  if(DB::isError($result_conn)){ die($result_conn->getDebugInfo()); }  
##  *** write down the primary key in the first place (MUST BE AUTO-INCREMENT NUMERIC!)
//  $sql = "SELECT primary_key, field_1, field_2 ... FROM tableName ;";
##  *** set needed options and create a new class instance 
//  $debug_mode = false;        /* display SQL statements while processing */    
//  $messaging = true;          /* display system messages on a screen */ 
//  $unique_prefix = "abc_";    /* prevent overlays - must be started with a letter */
//  $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
##  *** set encoding and collation (default: utf8/utf8_unicode_ci)
/// $dg_encoding = "utf8";
/// $dg_collation = "utf8_unicode_ci";
/// $dgrid->SetEncoding($dg_encoding, $dg_collation);
##  *** set data source with needed options
//  $default_order_field = "field_name_1"; /* Ex.: field_name_1 [, field_name_2...] */
//  $default_order_type = "ASC";           /* Ex.: ASC|DESC [, ASC|DESC...] */
//  $dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);	    
##
##
## +---------------------------------------------------------------------------+
## | 2. General Settings:                                                      | 
## +---------------------------------------------------------------------------+
## +-- AJAX -------------------------------------------------------------------+
##  *** enable or disable using of AJAX (for sorting and paging ONLY)
/// $ajax_option = false;
/// $dgrid->AllowAjax($ajax_option);
##
## +-- Languages --------------------------------------------------------------+
##  *** set interface language (default - English)
##  *** (ar) - Arabic        (bg) - Bulgarian  (ca) - Catala    (ch) - Chinese
##  *** (cz) - Czech         (da) - Danish     (de) - German    (en) - English
##  *** (es) - Espanol       (fr) - Francais   (gk) - Greek     (he) - Hebrew
##  *** (hu) - Hungarian     (hr) - Bosnian/Croatian            (it) - Italiano
##  *** (ja_utf8) - Japanese (nl) - Netherlands/"Vlaams"(Flemish)
##  *** (pl) - Polish        (pb) - Brazilian Portuguese        (ro/ro_utf8) - Romanian
##  *** (ru_utf8) - Russian  (se) - Swedish    (sr) - Serbian   (tr) - Turkish                 
/// $dg_language = "en";  
/// $dgrid->SetInterfaceLang($dg_language);
##  *** set direction: "ltr" or "rtr" (default - "ltr")
/// $direction = "ltr";
/// $dgrid->SetDirection($direction);
##
## +-- Layouts, Templates & CSS -----------------------------------------------+
##  *** datagrid layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized
##  *** use "view"=>"0" and "edit"=>"0" only if you work on the same tables
##  *** filter layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - tabular(inline)
/// $layouts = array("view"=>"0", "edit"=>"1", "details"=>"1", "filter"=>"1"); 
/// $dgrid->SetLayouts($layouts);
/// *** $mode_template = array("header"=>"", "body"=>"", "footer"=>"");
/// @field_name_1@ - field header 
/// {field_name_1} - field value
/// [ADD][CREATE][EDIT][DELETE][BACK][CANCEL][UPDATE] - allowed operations (must be placed in $template['body'] only)
/// $view_template = "";
/// $add_edit_template = "";
/// $details_template = array("header"=>"", "body"=>"", "footer"=>"");
/// $details_template['header'] = "";
/// $details_template['body'] = "<table><tr><td>{field_name_1}</td><td>{field_name_2}</td></tr><tr><td>[BACK]</td></tr></table>";
/// $details_template['footer'] = "";
/// $dgrid->SetTemplates($view_template, $add_edit_template, $details_template);
##  *** set modes for operations ("type" => "link|button|image")
##  *** "view" - view mode | "edit" - add/edit/details modes
##  *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
/// $modes = array(
///     "add"	  =>array("view"=>true, "edit"=>false, "type"=>"link", "show_add_button"=>"inside|outside"),
///     "edit"	  =>array("view"=>true, "edit"=>true,  "type"=>"link", "byFieldValue"=>""),
///     "cancel"  =>array("view"=>true, "edit"=>true,  "type"=>"link"),
///     "details" =>array("view"=>true, "edit"=>false, "type"=>"link"),
///     "delete"  =>array("view"=>true, "edit"=>true,  "type"=>"image")
/// );
/// $dgrid->SetModes($modes);
##  *** set CSS class for datagrid
##  *** "default|blue|gray|green|pink|empty|x-blue|x-gray|x-green" or your own css style
/// $css_class = "default";
/// $dgrid->SetCssClass($css_class);
##  *** set DataGrid caption
/// $dg_caption = "My Favorite Lovely PHP DataGrid";
/// $dgrid->SetCaption($dg_caption);
##
## +-- Scrolling --------------------------------------------------------------+
##  *** allow scrolling on datagrid
/// $scrolling_option = false;
/// $dgrid->AllowScrollingSettings($scrolling_option);  
##  *** set scrolling settings (optional) 
/// $scrolling_height = "100px"; /* ex.: "190px" or "190" */
/// $dgrid->SetScrollingSettings($scrolling_height);
##
## +-- Multirow Operations ----------------------------------------------------+
##  *** allow multirow operations
/// $multirow_option = true;
/// $dgrid->AllowMultirowOperations($multirow_option);
/// $multirow_operations = array(
///     "edit"    => array("view"=>true),
///     "details" => array("view"=>true),
///     "delete"  => array("view"=>true),
///     "my_operation_name" => array("view"=>true, "flag_name"=>"my_flag_name", "flag_value"=>"my_flag_value", "tooltip"=>"Do something with selected", "image"=>"image.gif")
/// );
/// $dgrid->SetMultirowOperations($multirow_operations);  
##  *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.) 
##
## +-- Passing parameters & setting up other DataGrids ------------------------+
/// $http_get_vars = array("act", "id");
/// $dgrid->SetHttpGetVars($http_get_vars);
##  *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
##  *** format (in which mode to allow processing of another datagrids)
##  *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
/// $anotherDatagrids = array("abcd_"=>array("view"=>true, "edit"=>true, "details"=>true));
/// $dgrid->SetAnotherDatagrids($anotherDatagrids);  
##
##
## +---------------------------------------------------------------------------+
## | 3. Printing & Exporting Settings:                                         | 
## +---------------------------------------------------------------------------+
##  *** set printing option: true(default) or false 
/// $printing_option = true;
/// $dgrid->AllowPrinting($printing_option);
##  *** set exporting option: true(default) or false and relative (virtual) path 
##  *** to export directory (relatively to datagrid.class.php file). Ex.: "export/"
##  *** Add 744 access permissions for this folder.
##  *** Initialize the session. with session_start();
##  *** Ex.: "export/" or "" - if you want to write in current folder
##  *** Change $file_path = "../../".$dir.$file; in scripts/download.php on appropriate path relatively to download.php
/// $exporting_option = true;
/// $exporting_directory = "";               
/// $export_all = false;
/// $dgrid->AllowExporting($exporting_option, $exporting_directory, $export_all);
/// $exporting_types = array("excel"=>"true", "pdf"=>"true", "xml"=>"true");
/// $dgrid->AllowExportingTypes($exporting_types);
##
##
## +---------------------------------------------------------------------------+
## | 4. Sorting & Paging Settings:                                             | 
## +---------------------------------------------------------------------------+
##  *** set sorting option: true(default) or false 
/// $sorting_option = true;
/// $dgrid->AllowSorting($sorting_option);               
##  *** set paging option: true(default) or false 
/// $paging_option = true;
/// $rows_numeration = false;
/// $numeration_sign = "N #";
/// $dropdown_paging = false;
/// $dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign, $dropdown_paging);
##  *** set paging settings
/// $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
/// $top_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
/// $pages_array = array("10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000");
/// $default_page_size = 10;
/// $paging_arrows = array("first"=>"|&lt;&lt;", "previous"=>"&lt;&lt;", "next"=>"&gt;&gt;", "last"=>"&gt;&gt;|");
/// $dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
##
##
## +---------------------------------------------------------------------------+
## | 5. Filter Settings:                                                       | 
## +---------------------------------------------------------------------------+
##  *** set filtering option: true or false(default)
/// $filtering_option = true;
/// $show_search_type = true;
/// $dgrid->AllowFiltering($filtering_option, $show_search_type);
##  *** set additional filtering settings
##  *** tips: use "," (comma) if you want to make search by some words, for ex.: hello, bye, hi
##  *** "field_type" (optional, for range search) may be "from" or "to"
##  *** "date_format" may be "date|datedmy|datetime|time"
##  *** "default_operator" may be =|<|>|like|%like|like%|%like%|not like
##  *** "handler"=>"" - write here path relatively to DATAGRID_DIR (where datagrid.class.php is found)
/// $fill_from_array = array("0"=>"No", "1"=>"Yes");  /* as "value"=>"option" */
/// $filtering_fields = array(
///     "Caption_1"=>array("type"=>"textbox", "table"=>"tableName_1", "field"=>"fieldName_1|,fieldName_2", "filter_condition"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "on_js_event"=>""),
///     "Caption_2"=>array("type"=>"textbox", "autocomplete"=>"false", "handler"=>"modules/autosuggest/test.php", "maxresults"=>"12", "shownoresults"=>"false", "table"=>"tableName_2", "field"=>"fieldName_1|,fieldName_2", "filter_condition"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "on_js_event"=>""),
///     "Caption_3"=>array("type"=>"dropdownlist", "table"=>"tableName_3", "field"=>"fieldName_1", "field_view"=>"fieldName_2", "show_count"=>false, "filter_condition"=>"", "order"=>"ASC|DESC", "source"=>"self"|$fill_from_array, "condition"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "multiple"=>"false", "multiple_size"=>"4", "on_js_event"=>""),
///     "Caption_4"=>array("type"=>"calendar", "calendar_type"=>"popup|floating", "date_format"=>"date", "table"=>"tableName_4", "field"=>"fieldName_1", "filter_condition"=>"", "field_type"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "on_js_event"=>""),
/// );
/// $dgrid->SetFieldsFiltering($filtering_fields);
##
## 
## +---------------------------------------------------------------------------+
## | 6. View Mode Settings:                                                    | 
## +---------------------------------------------------------------------------+
##  *** set view mode table properties
/// $vm_table_properties = array("width"=>"90%");
/// $dgrid->SetViewModeTableProperties($vm_table_properties);  
##  *** set columns in view mode
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
/// $fill_from_array = array("0"=>"Banned", "1"=>"Active", "2"=>"Closed", "3"=>"Removed"); /* as "value"=>"option" */
/// $vm_columns = array(
///     "FieldName_1"=>array("header"=>"Name_A", "type"=>"label",      "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_2"=>array("header"=>"Name_B", "type"=>"image",      "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "default"=>"default_image.ext", "image_width"=>"50px", "image_height"=>"30px", "linkto"=>"", "magnify"=>"false", "magnify_type"=>"popup|magnifier|lightbox", "magnify_power"=>"2"),
///     "FieldName_3"=>array("header"=>"Name_C", "type"=>"linktoview", "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_4"=>array("header"=>"Name_D", "type"=>"linktoedit", "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_5"=>array("header"=>"Name_E", "type"=>"linktodelete", "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_6"=>array("header"=>"Name_F", "type"=>"link",       "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"field_name_0", "field_key_1"=>"field_name_1", "field_data"=>"field_name_2", "rel"=>"", "title"=>"", "target"=>"_self", "href"=>"{0}"),
///     "FieldName_7"=>array("header"=>"Name_G", "type"=>"link",       "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"field_name_0", "field_key_1"=>"field_name_1", "field_data"=>"field_name_2", "rel"=>"", "title"=>"", "target"=>"_self", "href"=>"mailto:{0}"),
///     "FieldName_8"=>array("header"=>"Name_H", "type"=>"link",       "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"field_name_0", "field_key_1"=>"field_name_1", "field_data"=>"field_name_2", "rel"=>"", "title"=>"", "target"=>"_self", "href"=>"http://mydomain.com?act={0}&act={1}&code=ABC"),
///     "FieldName_9"=>array("header"=>"Name_I", "type"=>"linkbutton", "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"field_name_0", "field_key_1"=>"field_name_1", "field_data"=>"field_name_2", "href"=>"{0}"),
///     "FieldName_10"=>array("header"=>"Name_G", "type"=>"money",     "align"=>"right", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "sign"=>"$", "sign_place"=>"before|after", "decimal_places"=>"2", "dec_separator"=>".", "thousands_separator"=>","),
///     "FieldName_11"=>array("header"=>"Name_K", "type"=>"password",  "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "hide"=>"false"),
///     "FieldName_12"=>array("header"=>"Name_L", "type"=>"percent",   "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "decimal_places"=>"2", "dec_separator"=>"."),
///     "FieldName_13"=>array("header"=>"Name_M", "type"=>"barchart",  "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field"=>"field_name", "maximum_value"=>"value", "display_type"=>"vertical|horizontal"),
///     "FieldName_14"=>array("header"=>"Name_N", "type"=>"enum",      "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "source"=>$fill_from_array),
///     "FieldName_15"=>array("header"=>"Name_O", "type"=>"color",     "align"=>"center", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "view_type"=>"text|image"),
///     "FieldName_15"=>array("header"=>"Name_P", "type"=>"checkbox",  "align"=>"center", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "true_value"=>1, "false_value"=>0),
///     "FieldName_16"=>array("header"=>"Name_Q", "type"=>"blob"),
/// );
/// $dgrid->SetColumnsInViewMode($vm_columns);
##  *** set auto-generated columns in view mode
//  $auto_column_in_view_mode = false;
//  $dgrid->SetAutoColumnsInViewMode($auto_column_in_view_mode);
##
##
## +---------------------------------------------------------------------------+
## | 7. Add/Edit/Details Mode Settings:                                        | 
## +---------------------------------------------------------------------------+
##  *** set add/edit mode table properties
/// $em_table_properties = array("width"=>"70%");
/// $dgrid->SetEditModeTableProperties($em_table_properties);
##  *** set details mode table properties
/// $dm_table_properties = array("width"=>"70%");
/// $dgrid->SetDetailsModeTableProperties($dm_table_properties);
##  ***  define settings for add/edit/details modes
//  $table_name  = "table_name";
//  $primary_key = "primary_key";
##  for ex.: "table_name.field = ".$_REQUEST['abc_rid'];
//  $condition   = "";
//  $dgrid->SetTableEdit($table_name, $primary_key, $condition);
##  *** set columns in edit mode   
##  *** first letter:  r - required, s - simple (not required)
##  *** second letter: t - text(including datetime), n - numeric, a - alphanumeric, e - email, f - float, 
##                     y - any(generally used for foreign languages), l - login name, z - zipcode,
##                     p - password, i - integer, v - verified, checked (for checkboxes), u - URL
##                     s - SSN number, m - telephone, x - template  (for example - "req_type"="rx", "template"=>"(ddd)-ddd-dd-dd", where d - digit, c - character)
 
##  *** third letter (optional): 
##          for numbers: s - signed, u - unsigned, p - positive, n - negative
##          for strings: u - upper,  l - lower,    n - normal,   y - any
##          for telephone: m - mobile, f - fixed (stationary), i - international, y - any
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
##  *** Ex.: type = textbox|textarea|label|date(yyyy-mm-dd)|datedmy(dd-mm-yyyy)|datemdy(mm-dd-yyyy)|datetime(yyyy-mm-dd hh:mm:ss)|datetimedmy(dd-mm-yyyy hh:mm:ss)|time(hh:mm:ss)|image|password|enum|print|checkbox|blob|hidden|validator
##  *** make sure your WYSIWYG dir has 755 access permissions
##  *** make sure uploading directories for files/images have 755 access permissions
##  *** to set up uploading directoy for textarea, open modules\wysiwyg\addons\imagelibrary\config.inc.php and change $imagebasedir = 'images';
##  *** if you allows user upload files via WYSIWYG - make sure the area this script is already password protected!!!
/// $fill_from_array = array("0"=>"No", "1"=>"Yes", "2"=>"Don't know", "3"=>"My be"); /* as "value"=>"option" */
/// $em_columns = array(
///     "FieldName_1"  =>array("header"=>"Name_A", "type"=>"textbox",    "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_2"  =>array("header"=>"Name_B", "type"=>"textarea",   "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "edit_type"=>"simple|wysiwyg", "resizable"=>"false", "upload_images"=>"false", "rows"=>"7", "cols"=>"50"),
///     "FieldName_3"  =>array("header"=>"Name_C", "type"=>"label",      "title"=>"", "default"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_4"  =>array("header"=>"Name_D", "type"=>"date",       "req_type"=>"rt", "width"=>"187px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "calendar_type"=>"popup|floating|dropdownlist"),
///     "FieldName_5"  =>array("header"=>"Name_E", "type"=>"datetime",   "req_type"=>"st", "width"=>"187px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "calendar_type"=>"popup|floating|dropdownlist", "show_seconds"=>"true"),
///     "FieldName_6"  =>array("header"=>"Name_F", "type"=>"time",       "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_7"  =>array("header"=>"Name_G", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100000|100K|10M|1G", "image_width"=>"120px", "image_height"=>"90px", "resize_image"=>"false", "resize_width"=>"", "resize_height"=>"", "magnify"=>"false", "magnify_type"=>"popup|magnifier|lightbox", "magnify_power"=>"2", "file_name"=>"", "host"=>"local|remote", "allow_downloading"=>"false"),
///     "FieldName_8"  =>array("header"=>"Name_H", "type"=>"password",   "req_type"=>"rp", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "hide"=>"false", "generate"=>"true", "cryptography"=>"false", "cryptography_type"=>"aes|md5", "aes_password"=>"aes_password"),
///     "FieldName_9"  =>array("header"=>"Name_I", "type"=>"money",      "req_type"=>"rf", "width"=>"80px",  "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "sign"=>"$", "sign_place"=>"before|after", "decimal_places"=>"2", "dec_separator"=>".", "thousands_separator"=>","),
///     "FieldName_10" =>array("header"=>"Name_J", "type"=>"enum",       "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "source"=>"self"|$fill_from_array, "view_type"=>"dropdownlist(default)|radiobutton|checkbox", "radiobuttons_alignment"=>"horizontal|vertical", "multiple"=>"false", "multiple_size"=>"4"),
///     "FieldName_11" =>array("header"=>"Name_K", "type"=>"print",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_12" =>array("header"=>"Name_L", "type"=>"checkbox",   "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "true_value"=>1, "false_value"=>0),
///     "FieldName_13" =>array("header"=>"Name_M", "type"=>"file",       "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100000|100K|10M|1G", "file_name"=>"", "host"=>"local|remote", "allow_downloading"=>"false"),
///     "FieldName_14_a" =>array("header"=>"Name_N (for add/edit mode)", "type"=>"link",   "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
///     "FieldName_14_b" =>array("header"=>"Name_N (for details mode)",  "type"=>"link",   "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"", "field_key_1"=>"", "field_data"=>"", "rel"=>"", "title"=>"", "target"=>"_self", "href"=>"{0}"),
///     "FieldName_15" =>array("header"=>"Name_O", "type"=>"foreign_key","req_type"=>"ri", "width"=>"210px", "title"=>"", "readonly"=>"false", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true"),
///     "FieldName_16" =>array("header"=>"Name_P", "type"=>"blob",       "req_type"=>"st", "readonly"=>"false"),
///     "FieldName_17" =>array("header"=>"Name_Q", "type"=>"hidden",     "req_type"=>"st", "default"=>"", "value"=>"", "unique"=>"false", "visible"=>"true"),
///     "FieldName_18" =>array("header"=>"Name_R", "type"=>"percent",    "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "decimal_places"=>"2", "dec_separator"=>"."),
///     "FieldName_19" =>array("header"=>"Name_S", "type"=>"color",      "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "view_type"=>"dropdownlist", "save_format"=>"hexcodes"),
///     "validator"    =>array("header"=>"Name_T", "type"=>"validator",  "req_type"=>"rv", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "visible"=>"true", "on_js_event"=>"", "for_field"=>"", "validation_type"=>"password|email"),
///     "delimiter_1|2|3..."    =>array("inner_html"=>"<br />"),
/// );
/// $dgrid->SetColumnsInEditMode($em_columns);
##  *** set auto-generated columns in edit mode
//  $auto_column_in_edit_mode = false;
//  $dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);
##  *** set foreign keys for add/edit/details modes (if there are linked tables)
##  *** Ex.: "field_name"=>"CONCAT(field1,' ',field2) as field3" 
##  *** Ex.: "condition"=>"TableName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
/// $foreign_keys = array(
///     "ForeignKey_1"=>array("table"=>"TableName_1", "field_key"=>"FieldKey_1", "field_name"=>"FieldName_1", "view_type"=>"dropdownlist(default)|radiobutton|textbox|label", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"", "order_type"=>"ASC|DESC", "on_js_event"=>""),
///     "ForeignKey_2"=>array("table"=>"TableName_2", "field_key"=>"FieldKey_2", "field_name"=>"FieldName_2", "view_type"=>"dropdownlist(default)|radiobutton|textbox|label", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"", "order_type"=>"ASC|DESC", "on_js_event"=>"")
/// ); 
/// $dgrid->SetForeignKeysEdit($foreign_keys);
##
##
## +---------------------------------------------------------------------------+
## | 8. Bind the DataGrid:                                                     | 
## +---------------------------------------------------------------------------+
##  *** bind the DataGrid and draw it on the screen
//  $dgrid->WriteCssClass();    /* call of this method between HTML <HEAD> tags */
//  $dgrid->Bind();        
//  ob_end_flush();
##
################################################################################   

////////////////////////////////////////////////////////////////////////////////
//
// Non-documented:
// -----------------------------------------------------------------------------
// PROPERTY  : firstFieldFocusAllowed      = true|false;
//  --//--   : hideGridBeforeSearch        = true|false;  /* put it before Bind() method */
//  --//--   : modeAfterUpdate             = ""|"edit";
//                                           This function must be defined with 1 parameter, that will get fild's data.
//                                           Ex.: function function_name($field_value){ ... return $new_field_value;}
//  --//--   : noDataFoundText             = ""; displays a text on empty dataset
//  --//--   : isDemo                      = ""; blockd all operations with DataGrid
//  --//--   : navigationBar               = ""; allows to display additional links etc. at the top of DataGrid
//  --//--   : summarizeFunction           = "SUM|AVG"; defines global summarize function: SUM or AVG
//  --//--   : controlsDisplayingType      = ""; defines displaying alignment of controls ("" or "grouped")
//  --//--   : allowRealEscape             = true|false;  defines using of escaping special characters in a string
//  --//--   : weekStartingtDay            = 1|2...7;  defines week first day (0 - sunday, default) for floating calendar
//  --//--   : initFilteringState          = ""; defines initial state of filtering block - "closed" or "opened"
// 
// METHOD    : ExecuteSQL() 
//            use it after DataSource() method only (using this method before bind() requires redefinition of DataSource())
//    		  $dSet = $dgrid->ExecuteSQL("SELECT * FROM tblPresidents WHERE tblPresidents.CountryID = ".$_GET['f_rid']."");
//    		  while($row = $dSet->fetchRow()){
//        	    for($c = 0; ($c < $dSet->numCols()); $c++){ echo $row[$c]." "; }
//        	    echo "<br />";
//    		  }
//  --//--   : SelectSqlItem()
//             use it after DataSource() method only (using this method before bind() requires redefinition of DataSource())
//             $presidents = $dgrid->SelectSqlItem("SELECT COUNT(tblPresidents.presidentID) FROM tblPresidents WHERE tblPresidents.CountryID = ".$_GET['f_rid']."");
//  --//--   : AllowHighlighting(true|false);
//  --//--   : SetJsErrorsDisplayStyle("all"|"each");
//  --//--   : GetNextId();
//  --//--   : GetCurrentId();
//  --//--   : SetHeadersInColumnarLayout("Field Name", "Field Value");
//  --//--   : SetDgMessages("add", "update", "delete");
//  --//--   : IsOperationCompleted();
//  --//--   : IgnoreBaseTag();
//  --//--   : DisplayLoadingImage();
//  --//--   : SetSummarizeNumberFormat("2", ".", ",");
//  --//--   : SetFilteringTabularLayoutColumns("2");
//  --//--   : SetDefaultTimezone("America/Los_Angeles"); // (list of supported Timezones - http://us3.php.net/manual/en/timezones.php)       
//             
// ATTRIBUTE : "header_tooltip"   => "" in view mode
//  --//--   : "header_align"     => "" in view mode
//  --//--   : "sortable"         => "false|true" in view mode
//  --//--   : "type"             => "data" in view mode - displays field data without HTML formatting
//  --//--   : "autocomplete"     => "on|off" attribute for textboxes in add/edit modes (default - "on")
//  --//--   : "align"            => "left|center|right" attribute for fields in add/edit modes
//  --//--   : "pre_addition"     => "" and "post_addition"=>"" attributes in view/add/edit/details modes
//  --//--   : "on_item_created"  => "function_name" attributes in view/add/edit/details modes for customized work with field value.
//  --//--   : "summarize_function" => "SUM|AVG" defines aggregate function for certain field
//  --//--   : ("req_type"="rx", "template"=>"(ddd)-ddd-dd-dd", where d - digit, c - character) - template(mask) check type for fields in Add/Edit Mode
//
// FEATURE   : onSubmitMyCheck
//      	   <script type='text/javascript'>
//                function unique_prefix_onSubmitMyCheck(){
//                  if(document.getElementById('ryyfirst_name').value =='x'){
//                     alert("Please check ...  X is invalid!!!");
//                     return false;
//                  }  
//                  return true;
//      	      }	
//      	   </script>
//  --//--   : "on_js_event"=>"onchange='formAction(\"\", \"\", \"".$dgrid->uniquePrefix."\", \"".$dgrid->HTTP_URL."\", \"".$_SERVER['QUERY_STRING']."\")'" 
//  --//--   : Bind(true|false) - draw DataGrid on the screen on not
//
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
//
// Tricks:
// -----------------------------------------------------------------------------
// 1. Set default value, that disappears on focus:
//      "default"=>"http://www.website.com", "on_js_event"=>"onBlur='if(this.value == \"\") this.value = \"http://www.website.com\"; this.style.color=\"#f68d6f\";' onClick='if(this.value==\"http://www.website.com\") this.value=\"\"; this.style.color=\"#000000\";'",
//
// 2. Set unique value for uploaded image:
//     a) "file_name"=>"img_".((isset($_GET[$unique_prefix.'mode']) && ($_GET[$unique_prefix.'mode'] == "add")) ? $dgrid->GetNextId() : $dgrid->GetCurrentId())
//     b) "file_name"=>"img_".((isset($_GET[$unique_prefix.'mode']) && ($_GET[$unique_prefix.'mode'] == "add")) ? $dgrid->GetRandomString("10") : $dgrid->GetRandomString("10"))
//
// 3. Make auto-refresh for filtering fields:
//      "on_js_event"=>"onchange='document.getElementById(\"...prefix..._ff_onSUBMIT_FILTER\").click();'"
//
// 4. Make a field text colored according to condition (in SQL statement):
//      if (product='flooring', CONCAT('<SPAN style=\"background-color:yellow\">',product,'</SPAN>'),product) as ProductColored,
//
// 5. Change the field's data on fly (for "on_item_created"=>"setColor" field's attribute):
//      function setColor($field_value){
//        if(strlen($field_value) > 5){
//            return "<font color='red'>".$field_value."</font>";
//        }else{
//            return "<font color='blue'>".$field_value."</font>";        
//        }
//      }
//
// 6. Change the field's type on fly (for "on_item_created" field's attribute):
//    To do this, you need to change this line of code $field_value = $fp_on_item_created($field_value);
//    On this one: $field_value = $fp_on_item_created($field_value, &$fp_type);
//      function setColor($field_value, $fp_type){
//        if(strlen($field_value) > 5){
//            return "<font color='red'>".$field_value."</font>";
//        }else{
//            $fp_type = "linktoview";
//            return "<font color='blue'>".$field_value."</font>";        
//        }
//      }
//
// 8. Customized filtering: write filter field with empty table name and field: (..."table"=>"", "field"=>"xxx",...)
//    Then use $my_field = isset($_GET['prefix__ff__xxx']) ? $_GET['prefix__ff__xxx'] : "";
//    Use $my_field in SQL SELECT for your own filtering
//
// 9. Passing parameters to Javascript function on "on_js_event"=>"" for "link" fields 
//    "href"=>"", "on_js_event"=>"my_finction({0},{1})" 
//
////////////////////////////////////////////////////////////////////////////////


require_once(DATAGRID_DIR."classes/helper.class.php");

Class DataGrid
{
    //==========================================================================
    // Data Members
    //==========================================================================
    private $dgVersion;
    
    // unique prefixes ---------------------------------------------------------
    public $uniquePrefix;
    public $uniqueRandomPrefix;
    
    // security ----------------------------------------------------------------
    public $safeMode;
    private $securityLevel;

    // directory ---------------------------------------------------------------
    public $directory;

    // language ----------------------------------------------------------------
    public $langName;
    public $lang;

    // caption -----------------------------------------------------------------
    public $caption;

    // rows and columns data members -------------------------------------------
    public $rows;
    public $rowLower;
    public $rowUpper;
    public $columns;            
    public $colLower;
    public $colUpper;

    // http get vars -----------------------------------------------------------    
    public $http;
    public $port;
    public $serverName;
    public $HTTP_URL;
    public $HTTP_HOST;
    private $QUERY_STRING;
    public $httpGetVars;
    public $anotherDatagrids;
    private $ignoreBaseTag;

    // data source -------------------------------------------------------------
    public $dbHandler;
    public $sql;
    public $sqlView;
    public $sqlGroupBy;
    private $dataSet;
    public $sqlSort;
    
    // signs -------------------------------------------------------------------
    public $amp;
    public $nbsp;
    
    // encoding & direction ----------------------------------------------------
    public $encoding;
    public $collation;
    public $direction;

    // layout style ------------------------------------------------------------
    public $layouts;  
    public $layoutType;

    // templates ---------------------------------------------------------------
    public $templates;
    
    // paging variables --------------------------------------------------------
    public $pagesTotal;
    public $pageCurrent;
    public $defaultPageSize;
    public $dropdownPaging;
    public $reqPageSize;
    public $pagingAllowed;
    public $rowsNumeration;
    public $numerationSign;           
    public $arrLowerPaging;
    public $arrUpperPaging;
    public $arrPages;
    public $firstArrow;
    public $previousArrow;
    public $nextArrow;
    public $lastArrow;    
    public $limitStart;
    public $limitSize;
    public $rowsTotal;

    // sorting variables -------------------------------------------------------
    public $sortField;
    public $sortType;
    public $defaultSortField;    
    public $defaultSortType;    
    public $defaultSortFieldHelp;    
    public $defaultSortTypeHelp;    
    public $sortingAllowed;

    // filtering variables -----------------------------------------------------
    public $filteringAllowed;
    public $showSearchType;
    public $arrFilterFields;
    public $hideDisplay;
    public $initFilteringState;
    private $tabularColumns;

    private $defFilterField;
    private $defFilterFieldValue;
    private $defFilterFieldWhere;

    // columns style parameters ------------------------------------------------            
    public $wrap;

    // css style ---------------------------------------------------------------            
    public $isRowHighlightingAllowed;
    public $cssClass;
    public $rowColor;
    protected $isCssClassWritten;

    // table style parameters --------------------------------------------------                        
    public $tblAlign;
    public $tblWidth;
    public $tblBorder;
    public $tblBorderColor;
    public $tblCellSpacing;
    public $tblCellPadding;
    
    // datagrid modes ----------------------------------------------------------                        
    public $modes;
    public $modeAfterUpdate;
    public $mode;
    public $rid;
    public $rids;
    public $tblName;
    public $primaryKey;
    public $condition;
    public $arrForeignKeys;    
    public $columnsViewMode;
    public $columnsEditMode;
    public $sortedColumns;

    // printing & exporting ----------------------------------------------------                        
    public $printingAllowed;
    public $exportingAllowed;
    public $exportingDirectory;
    public $exportAll;
    protected $arrExportingTypes;
    public $navigationBar;
    protected $isPrinting;

    // debug mode --------------------------------------------------------------                        
    public $debug;
    public $startTime;
    public $endTime;
    public $isDemo;

    // message -----------------------------------------------------------------                        
    public $actMsg;
    public $messaging;
    public $isError;
    public $errors;
    public $isWarning;
    public $warnings;
    public $sqlStatements;
    public $arrDgMessages;
    public $noDataFoundText;
    private $isOperationCompleted;

    // browser & system types --------------------------------------------------
    public $platform;
    public $browserName;
    public $browserVersion;
    
    // scrolling ---------------------------------------------------------------
    public $scrollingOption;
    public $scrollingHeight;

    // header names ------------------------------------------------------------
    public $fieldHeader;
    public $fieldHeaderValue;

    // hide --------------------------------------------------------------------
    public $hideGridBeforeSearch;

    // summarize ---------------------------------------------------------------
    public $arrSummarizeColumns;
    public $summarizeNumberFormat;
    public $summarizeFunction;
    
    // multirow ----------------------------------------------------------------
    public $isMultirowAllowed;
    public $multiRows;
    public $arrMultirowOperations;

    // first field focus -------------------------------------------------------
    public $firstFieldFocusAllowed;

    // javascript errors display style -----------------------------------------
    protected $jsValidationErrors;
    protected $jsCode;

    // existing fields ---------------------------------------------------------
    public $existingFields;
    
    // loading image -----------------------------------------------------------
    private $isLoadingImageEnabled;

    // type of displaying control buttons --------------------------------------
    public $controlsDisplayingType;
    
    // using of escaping special characters in a string ------------------------
    public $allowRealEscape;
    
    // enable using of AJAX ----------------------------------------------------
    private $ajaxEnabled;
    
    // specifies which HTTP method will be used to submit the form data set ---- 
    public $httpSubmitMethod; 
    
    // calendar first week day 0: sunday (default), 1: monday... --------------- 
    public $weekStartingtDay;
    
    // timezone ---------------------------------------------------------------- 
    public $timezone;
    

    //==========================================================================
    // PUBLIC MEMBER FUNCTIONS 
    //==========================================================================
    //--------------------------------------------------------------------------
    // Default class constructor 
    //--------------------------------------------------------------------------
    function __construct($debug_mode = false, $messaging = true, $unique_prefix = "", $datagrid_dir = "datagrid/"){
    
        $this->dgVersion = "6.0.8";               

        $this->ajaxEnabled = false;
        $this->httpSubmitMethod = "GET";

        // set debug/demo state  -----------------------------------------------
        $this->debug = (($debug_mode == true) || ($debug_mode == "true")) ? true : false ;
        $this->isDemo = false;

        // start calculating running time of a script
        $this->startTime = 0;
        $this->endTime = 0;
        if($this->debug){
            $this->startTime = $this->GetFormattedMicrotime();
        }        

        // clean slashes from the input if there was page reloading  -----------
        if(array_key_exists($unique_prefix."file_act", $_GET) && get_magic_quotes_gpc()){
            function StripSlashesDeep($value) {
                $value = is_array($value) ? array_map('StripSlashesDeep', $value) : stripslashes($value);
                return $value;
            }
            $_POST = array_map('StripSlashesDeep', $_POST);
        }

        // unique prefixes -----------------------------------------------------
        $this->SetUniquePrefix($unique_prefix);
        
        // security ------------------------------------------------------------
        $this->safeMode = false;
        $this->securityLevel = "medium"; // low|medium/high
        
        // directory -----------------------------------------------------------
        $this->directory = $datagrid_dir;

        // language ------------------------------------------------------------
        $this->langName = "en";
        $this->lang = array();
        $this->lang['total'] = "Total";
        $this->lang['wrong_parameter_error'] = "Wrong parameter in [<b>_FIELD_</b>]: _VALUE_";        

        // caption -------------------------------------------------------------        
        $this->caption = "";

        // rows and columns data members ---------------------------------------
        $this->http = $this->GetProtocol();
        $this->port = $this->GetPort();
        $this->serverName = $this->GetServerName();
        $this->HTTP_URL = str_replace("///", "//", $this->http.$this->serverName.$this->port.$_SERVER['PHP_SELF']);
        $this->HTTP_HOST = str_replace("///", "//", $this->http.$this->serverName.$this->port.dirname($_SERVER['PHP_SELF']));
        $this->ignoreBaseTag = false;

        // http get vars -------------------------------------------------------        
        $this->httpGetVars = "";
        $this->anotherDatagrids = "";

        // css style  ----------------------------------------------------------        
        $this->isRowHighlightingAllowed = true;
        $this->cssClass = "default";
        $this->rowColor = array();
        $this->isCssClassWritten = false;

        // signs ---------------------------------------------------------------
        $this->amp = ($this->ajaxEnabled) ? "&" : "&amp;";
        $this->nbsp = ""; //&nbsp;       
        
        $this->rows = 0;
        $this->rowLower = 0;
        $this->rowUpper = 0;
        $this->columns = 0;            
        $this->colLower = 0;
        $this->colUpper = 0;

        // encoding & direction ------------------------------------------------
        $this->encoding = "utf8";
        $this->collation = "utf8_unicode_ci";
        $this->direction = "ltr";
        
        $this->layouts['view']   = "0";
        $this->layouts['edit']   = "1";
        $this->layouts['filter'] = "1";
        $this->layouts['show']   = "1";
        $this->layoutType = "view";
        
        // templates -----------------------------------------------------------
        $this->templates['view'] = "";
        $this->templates['edit'] = "";
        $this->templates['show'] = "";
        
        // paging variables ----------------------------------------------------
        $this->pagesTotal = 0;
        $this->pageCurrent = 0;
        $this->arrPages = array("10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000");
        $this->firstArrow    = "|&lt;&lt;";
        $this->previousArrow = "&lt;&lt;";
        $this->nextArrow     = "&gt;&gt;";
        $this->lastArrow     = "&gt;&gt;|";
        $this->defaultPageSize = 10;
        $this->dropdownPaging = false;
        $this->reqPageSize = 10;                
        $this->pagingAllowed = true;
        $this->rowsNumeration = false;
        $this->numerationSign = "N #";       
        $this->arrLowerPaging['results'] = false;
        $this->arrLowerPaging['results_align'] = "left";
        $this->arrLowerPaging['pages'] = false;        
        $this->arrLowerPaging['pages_align'] = "center";
        $this->arrLowerPaging['page_size'] = false;
        $this->arrLowerPaging['page_size_align'] = "right";
        $this->arrUpperPaging['results'] = false;
        $this->arrUpperPaging['results_align'] = "left";
        $this->arrUpperPaging['pages'] = false;        
        $this->arrUpperPaging['pages_align'] = "center";
        $this->arrUpperPaging['page_size'] = false;
        $this->arrUpperPaging['page_size_align'] = "right";
        $this->limitStart = 0;
        $this->limitSize = $this->reqPageSize;
        $this->rowsTotal = 0;
        $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
        $this->SetPagingSettings($bottom_paging);
        
        $this->sortField = "";
        $this->sort_field_by = "";
        $this->sort_field_type = "";
        $this->sortType = "";
        $this->defaultSortField = array();
        $this->defaultSortType = array();
        $this->defaultSortFieldHelp = "";
        $this->defaultSortTypeHelp = "";        
        $this->sortingAllowed = true;
        $this->sqlView = "";
        $this->sqlGroupBy = "";
        $this->dataSet = "";
        $this->sql = "";
        $this->sqlSort = "";
        
        $this->filteringAllowed = false;
        $this->showSearchType = true;        
        $this->arrFilterFields = array();
        $this->hideDisplay = "";
        $this->initFilteringState = "opened";
        $this->tabularColumns = "";        

        $this->defFilterField = "";
        $this->defFilterFieldValue = "";
        $this->defFilterFieldWhere = "";        
        
        $this->tblAlign['view'] = "center";         $this->tblAlign['edit'] = "center";         $this->tblAlign['details'] = "center";
        $this->tblWidth['view'] = "90%";            $this->tblWidth['edit'] = "70%";            $this->tblWidth['details'] = "60%";
        $this->tblBorder['view'] = "1";             $this->tblBorder['edit'] = "1";             $this->tblBorder['details'] = "1";
        $this->tblBorderColor['view'] = "#000000";  $this->tblBorderColor['edit'] = "#000000";  $this->tblBorderColor['details'] = "#000000";
        $this->tblCellSpacing['view'] = "0";        $this->tblCellSpacing['edit'] = "0";        $this->tblCellSpacing['details'] = "0";
        $this->tblCellPadding['view'] = "0";        $this->tblCellPadding['edit'] = "0";        $this->tblCellPadding['details'] = "0";
        
        // datagrid modes ------------------------------------------------------
        $this->modes["add"]     = array("view"=>true, "edit"=>false, "type"=>"link", "show_add_button"=>"inside");
        $this->modes["edit"]    = array("view"=>true, "edit"=>true,  "type"=>"link", "byFieldValue"=>"");
        $this->modes["cancel"]  = array("view"=>true, "edit"=>true,  "type"=>"link");
        $this->modes["details"] = array("view"=>true, "edit"=>false, "type"=>"link");
        $this->modes["delete"]  = array("view"=>true, "edit"=>true,  "type"=>"image");            

        $this->mode = "view";
        $this->modeAfterUpdate = "";
        $this->rid = $this->GetVariable('rid');
        $this->rids = "";
        $this->tblName ="";
        $this->primaryKey = 0;
        $this->condition = "";

        $this->arrForeignKeys = array();
        
        $this->columnsViewMode = array();
        $this->columnsEditMode = array();
        $this->sortedColumns = array();
              
        $this->printingAllowed = true;
        $this->exportingAllowed = false;
        $this->exportingDirectory = "";
        $this->exportAll = false;
        $this->arrExportingTypes = array("excel"=>true, "pdf"=>true, "xml"=>true);
        $this->navigationBar = "";
        $this->isPrinting = $this->GetVariable('print');
        
        // @ - to prevent problems with IIS 5.1 (some of the _SERVER variables doesn't seem to exist)
        $this->QUERY_STRING = @isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "";
        // check if there is Print Mode from another DG
        if(preg_match("/print=true/i", $this->QUERY_STRING)) $this->isPrinting = true;
        $this->wrap = "wrap";

        // scrolling -----------------------------------------------------------
        $this->scrollingOption = false;
        $this->scrollingHeight = "300px";

        // header names --------------------------------------------------------
        $this->fieldHeader = "";
        $this->fieldHeaderValue = "";

        // hide ----------------------------------------------------------------
        $this->hideGridBeforeSearch = false;
        
        // summarize -----------------------------------------------------------
        $this->arrSummarizeColumns = array();
        $this->summarizeNumberFormat = array();
        $this->summarizeNumberFormat['decimal_places'] = "2";
        $this->summarizeNumberFormat['decimal_separator'] = ".";
        $this->summarizeNumberFormat['thousands_separator'] = ",";
        $this->summarizeFunction = "SUM";
        
        $this->isMultirowAllowed = false;
        $this->multiRows = 0;
        $this->arrMultirowOperations = array();
        $this->arrMultirowOperations['edit'] = array("view"=>true);
        $this->arrMultirowOperations['details'] = array("view"=>true);
        $this->arrMultirowOperations['delete'] = array("view"=>true);

        $this->firstFieldFocusAllowed = false;

        // message -------------------------------------------------------------
        $this->actMsg = "";

        if($this->debug) error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        $this->messaging = (($messaging == true) || ($messaging == "true")) ? true : false ;        
        $this->isError = false;
        $this->errors = array();
        $this->isWarning = false;
        $this->warnings = array();
        $this->sqlStatements = array();
        $this->arrDgMessages = array();
        $this->arrDgMessages['add'] = "";
        $this->arrDgMessages['update'] = "";
        $this->arrDgMessages['delete'] = "";
        $this->isOperationCompleted = false;
        
        // javascript errors display style -------------------------------------
        $this->jsValidationErrors = "true";
        $this->jsCode = "";

        // set browser definitions  
        $bd = Helper::SetBrowserDefinitions();
        $this->browserName     = $bd['browser'];
        $this->browserVersion  = $bd['version'];
        $this->platform        = $bd['platform'];        

        // existing fields -----------------------------------------------------
        $this->existingFields = array();
        $this->existingFields['resizable_field'] = false;
        $this->existingFields['wysiwyg_field'] = false;
        $this->existingFields['calendar_type_popup'] = false;
        $this->existingFields['calendar_type_floating'] = false;
        $this->existingFields['autosuggestion_field'] = false;
        $this->existingFields['tooltip_type_floating'] = false; 
        $this->existingFields['magnify_field_view'] = false;
        $this->existingFields['magnify_field_edit'] = false;
        $this->existingFields['magnify_field_view_magnifier'] = false;
        $this->existingFields['magnify_field_view_lightbox'] = false;
        $this->existingFields['magnify_field_edit_magnifier'] = false;
        $this->existingFields['magnify_field_edit_lightbox'] = false;

        // loading image -------------------------------------------------------
        $this->isLoadingImageEnabled = true;
        
        // type of displaying control buttons ----------------------------------
        $this->controlsDisplayingType = "";

        // using of escaping special characters in a string --------------------
        $this->allowRealEscape = true;
        
        // set first wee kday to sunday ----------------------------------------
        $this->weekStartingtDay = 0;
        
    }

    //--------------------------------------------------------------------------
    // Class destructor
    //--------------------------------------------------------------------------    
    function __destruct()
    {
		// echo 'this object has been destroyed';
    }

    //--------------------------------------------------------------------------
    // Set encoding
    //--------------------------------------------------------------------------
    function SetEncoding($dg_encoding = "", $dg_collation = ""){
        $this->encoding = ($dg_encoding != "") ? $dg_encoding : $this->encoding;
        $this->collation = ($dg_collation != "") ? $dg_collation : $this->collation;
    }

    //--------------------------------------------------------------------------
    // Set data source 
    //--------------------------------------------------------------------------
    function DataSource($db_handl, $sql = "", $start_order = "", $start_order_type = ""){        
        $req_mode = $this->GetVariable('mode');
        
        // clear sql statment
        $sql = str_replace(array("\n", "\t", "  ", chr(13), chr(10)), " ", $sql); // new row
        $sql = rtrim(trim($sql), ";");
        
        // get preliminary Primary Key
        $p_key = explode(" ", $sql);
        $p_key = substr($p_key[1], 0, strpos($p_key[1], ","));
        $p_key = explode(".", $p_key);
        $this->primaryKey = $p_key[count($p_key)-1];
        
        $req_onSUBMIT_FILTER = $this->GetVariable('_ff_onSUBMIT_FILTER');
        $req_sort_field = $this->GetVariable('sort_field');
        $req_sort_field_by = $this->GetVariable('sort_field_by');
        $req_sort_field_type = $this->GetVariable('sort_field_type');
        $sort_field = ($req_sort_field_by != "") ? $req_sort_field_by : $req_sort_field ;
        $req_sort_type = $this->GetVariable('sort_type');
        $this->dbHandler = $db_handl;       
        $this->dbHandler->setFetchMode(DB_FETCHMODE_ORDERED);
        $numeric_sort = false;

        // handle SELECT SQL statement
        $this->sqlView = $sql;         
        $group_by_ind = strpos(strtolower($this->sqlView), "group by");
        if($group_by_ind){
            $this->sqlView = substr($sql, 0, $group_by_ind)." ";
            $this->sqlGroupBy = substr($sql, $group_by_ind);                
        }            
        if($this->SubStrOccurence($this->sqlView, " from ", true) < $this->SubStrOccurence($this->sqlView, "where ", true)){
            // handle SELECT statment with sub-SELECTs and SELECT without WHERE
            if(!$group_by_ind) $this->sqlView .= " WHERE 1=1 "; 
        }else if($this->SubStrOccurence($this->sqlView, "where ", true) == ""){
            if(!$group_by_ind) $this->sqlView .= " WHERE 1=1 ";
        }
        $this->sql = $this->sqlView.$this->sqlGroupBy;
        
        // set default order
        if($start_order != ""){
            $default_sort_field = explode(",", $start_order);
            $default_sort_type = explode(",", $start_order_type);
            for($ind=0; $ind < count($default_sort_field); $ind++){
                $this->defaultSortField[$ind] = trim($default_sort_field[$ind]);
                if(isset($default_sort_type[$ind])){
                    if((strtolower(trim($default_sort_type[$ind])) == "asc") || (strtolower(trim($default_sort_type[$ind])) == "desc")){
                        $this->defaultSortType[$ind] = trim($default_sort_type[$ind]);
                    }else{
                        $this->defaultSortType[$ind] = "ASC";
                        $this->AddWarning('$default_order_type', $start_order_type);
                    }
                }else{
                    $this->defaultSortType[$ind] = "ASC";
                }
            }
            $this->defaultSortFieldHelp = $this->defaultSortField[0];
            $this->defaultSortTypeHelp = $this->defaultSortType[0];
        }else{
            $this->defaultSortField[0] = "1";
            $this->defaultSortType[0] = "ASC";
        }

        // create ORDER BY part of sql statment
        if($req_sort_field){            
            if(!substr_count($this->sql, "ORDER BY")){
                if($req_sort_field_type == "numeric"){
                    $this->sqlSort = " ORDER BY ABS(".$sort_field.") ".$req_sort_type;     
                    $numeric_sort = true;
                }else{
                    $sort_field_name = $sort_field;
                    // [#0014-2] fixed bug 08.04.2010
                    if($this->dbHandler->phptype == "mssql"){
                        $sql_parts = explode(" ", $this->sql);
                        if(isset($sql_parts[$sort_field-1])){
                            $sort_field_name = str_replace(",", "", $sql_parts[$sort_field-1]);
                            $this->sqlSort = " ORDER BY ".$sort_field_name." ".$req_sort_type;
                        }else{
                            $this->sqlSort = " ".$this->GetOrderByList();
                        }
                    }else{
                        $this->sqlSort = " ORDER BY ".$sort_field_name." ".$req_sort_type;    
                    }
                }                
            }else{
              $this->sqlSort = " , ".$sort_field." ".$req_sort_type;
            }
            $this->sqlSort;
        }else if($start_order != ""){
            $this->sqlSort = " ORDER BY ".$this->GetOrderByList();
        }else{
            if($req_onSUBMIT_FILTER != "" && $this->defaultSortFieldHelp != "" && $this->defaultSortTypeHelp != ""){
                // if there we are in searching - save default ordering                
                $this->sqlSort = " ORDER BY ".$this->defaultSortFieldHelp." ".$this->defaultSortTypeHelp;
            }else{
                $this->sqlSort = " ORDER BY 1 ASC";
            }
        }
        
        $this->GetDataSet($this->sqlSort, "", "", $sort_field, $numeric_sort, true);
        
        // check if the preliminary key is a Primary Key
        $is_warning = false;
        switch ($this->dbHandler->phptype){ 
            case "ibase":
            case "firebird": 
                if(strtolower($this->GetFieldInfo(0, 'type', 1)) != "integer") $is_warning = true;
                break;    
            default:
                if(strtolower($this->GetFieldInfo(0, 'type', 1)) != "int") $is_warning = true;
                break;
        }
        if($is_warning) $this->AddWarning($this->primaryKey, "Check this field carefully, it may be not a Primary Key!");
    }    

    //--------------------------------------------------------------------------
    // Set language
    //--------------------------------------------------------------------------
    function SetInterfaceLang($lang_name = ""){
        $default_language = false;
        if($lang_name != ""){ $this->langName = $lang_name; }
        if (file_exists($this->directory.'languages/'.$this->langName.'.php')) {
            if(!defined("_DG_LANGUAGE_INCLUDED")){
                include_once($this->directory.'languages/'.$this->langName.'.php');
                if(function_exists('setLanguage')){
                    $this->lang = setLanguage();
                    define("_DG_LANGUAGE_INCLUDED", $this->langName);
                }else{
                    if($this->debug){ echo "<label class='".$this->cssClass."_dg_error_message no_print'>Your language interface option is turned on, but the system was failed to open correctly stream: <b>'".$this->directory."languages/lang.php'</b>. <br />The structure of the file is corrupted or invalid. Please check it or return the language option to default value: <b>'en'</b>!</label><br />"; }
                    $default_language = true;
                }
            }else{
                /// if($this->debug){ echo "<label class='".$this->cssClass."_dg_error_message no_print'>Your cannot use different languages for DataGrids!</label><br />"; }
                $this->langName = _DG_LANGUAGE_INCLUDED;
                $this->lang = setLanguage();
            }
    	}else{
            if((strtolower($lang_name) != "en") && ($this->debug)){
                echo "<label class='".$this->cssClass."_dg_error_message no_print'>Your language interface option is turned on, but the system was failed to open stream: <b>'".$this->directory."languages/".$lang_name.".php'</b>. <br />No such file or directory. Please check it or return the language option to default value: <b>'en'</b>!</label><br />";
            }
            $default_language = true;                    
    	}
               
        if($default_language){
            $this->lang = Helper::GetLangVacabulary();
        }
    }

    //--------------------------------------------------------------------------
    // Set direction
    //--------------------------------------------------------------------------
    function SetDirection($direction = "ltr"){
        $this->direction = $direction;
    }

    //--------------------------------------------------------------------------
    // Set layouts
    //--------------------------------------------------------------------------
    function SetLayouts($layouts = ""){
        $this->layouts['view']   = (isset($layouts['view'])) ? $layouts['view'] : "0";
        $this->layouts['edit']   = (isset($layouts['edit'])) ? $layouts['edit'] : "0";
        $this->layouts['show']   = (isset($layouts['details'])) ? $layouts['details'] : "1";
        $this->layouts['filter'] = (isset($layouts['filter'])) ? $layouts['filter'] : "0";        
    }

    //--------------------------------------------------------------------------
    // Set templates for customized layouts
    //--------------------------------------------------------------------------
    function SetTemplates($view = "", $add_edit = "", $details = ""){
        $this->templates['view'] = $view;
        $this->templates['edit'] = $add_edit;
        $this->templates['show'] = $details;
    }

    //--------------------------------------------------------------------------
    // Set mode add/edit/cancel/delete
    //--------------------------------------------------------------------------
    function SetModes($parameters){
        $this->modes = array();
        if(is_array($parameters)){
            foreach($parameters as $modeName => $modeValue){
                $this->modes[$modeName] = $modeValue;
            }            
        }
        $this->mode = "view";
    }  	    

    //--------------------------------------------------------------------------
    // Allow scrolling settings
    //--------------------------------------------------------------------------
    function AllowScrollingSettings($scrolling_option = false){
        $this->scrollingOption = (($scrolling_option == true) || ($scrolling_option == "true")) ? true : false ;        
    }

    //--------------------------------------------------------------------------
    // Set scrolling settings
    //--------------------------------------------------------------------------
    function setScrollingSettings($height=""){
        if($height != "") $this->scrollingHeight = $height;
    }

    //--------------------------------------------------------------------------
    // Allow multirow operations
    //--------------------------------------------------------------------------
    function AllowMultirowOperations($multirow_option = false){
        $this->isMultirowAllowed = (($multirow_option == true) || ($multirow_option == "true")) ? true : false ;
    }

    //--------------------------------------------------------------------------
    // Set multirow operations
    //--------------------------------------------------------------------------    
    function SetMultirowOperations($multirow_operations = ""){
        if(is_array($multirow_operations)){                
            foreach($multirow_operations as $fldName => $fldValue){
                $this->arrMultirowOperations[$fldName] = $fldValue;
            }
        }        
    }

    //--------------------------------------------------------------------------
    // Set css class
    //--------------------------------------------------------------------------
    function SetCssClass($class = "default"){        
        $this->cssClass = strtolower($class);
    }
    
    //--------------------------------------------------------------------------
    // Set Http Get Vars
    //--------------------------------------------------------------------------
    function SetHttpGetVars($http_get_vars = ""){
        $this->httpGetVars = $http_get_vars;
    }

    //--------------------------------------------------------------------------
    // Set Other DataGrids
    //--------------------------------------------------------------------------
    function SetAnotherDatagrids($another_datagrids = ""){
        $this->anotherDatagrids = $another_datagrids;
    }

    //--------------------------------------------------------------------------
    // Set title for datagrid
    //--------------------------------------------------------------------------
    function SetCaption($dg_caption = ""){
        $this->caption = $dg_caption;
    }

    //--------------------------------------------------------------------------
    // Allow using of AJAX
    //--------------------------------------------------------------------------
    function AllowAjax ($option = true) { $this->ajaxEnabled  = (($option == true) || ($option == "true")) ? true : false ; }    
 
    //--------------------------------------------------------------------------
    // Allow printing and exporting functions
    //--------------------------------------------------------------------------
    function AllowPrinting  ($option = true) { $this->printingAllowed  = (($option == true) || ($option == "true")) ? true : false ; }    
    function AllowExporting ($option = true, $exporting_directory = "", $export_all = false) {
        $this->exportingAllowed = (($option === true) || ($option == "true")) ? true : false ;
        $this->exportingDirectory = $exporting_directory;
        $this->exportAll = ($export_all === true || $export_all == "true") ? true : false;
    }
    function AllowExportingTypes($exporting_types = ""){
        if(is_array($exporting_types)){
            $this->arrExportingTypes["excel"] = (isset($exporting_types["excel"]) && (($exporting_types["excel"] === true) || ($exporting_types["excel"] === "true"))) ?  true : false;
            $this->arrExportingTypes["pdf"]   = (isset($exporting_types["pdf"]) && (($exporting_types["pdf"] === true) || ($exporting_types["pdf"] === "true"))) ?  true : false;
            $this->arrExportingTypes["xml"]   = (isset($exporting_types["xml"]) && (($exporting_types["xml"] === true) || ($exporting_types["xml"] === "true"))) ?  true : false;
        }
    }

    //--------------------------------------------------------------------------
    // Set sorting settings
    //--------------------------------------------------------------------------    
    function AllowSorting($option = true){ $this->sortingAllowed   = (($option === true) || (strtolower($option) == "true")) ? true : false ; }    

    //--------------------------------------------------------------------------
    // Set paging settings
    //--------------------------------------------------------------------------    
    function AllowPaging($option = true, $rows_numeration = false, $numeration_sign = "N #", $dropdown_paging = false){
        $this->pagingAllowed = (($option === true) || ($option == "true")) ? true : false ;
        $this->rowsNumeration = $rows_numeration;
        $this->numerationSign = $numeration_sign;
        $this->dropdownPaging = (($dropdown_paging === true) || ($dropdown_paging == "true")) ? true : false ;
    }

    function SetPagingSettings($lower=false, $upper=false, $pages_array=false, $default_page_size="", $paging_arrows=""){
        if(is_array($lower)){
            if(isset($lower['results'])) $this->arrLowerPaging['results'] = $lower['results'];
            if(isset($lower['results_align'])) $this->arrLowerPaging['results_align'] = $lower['results_align'];
            if(isset($lower['pages'])) $this->arrLowerPaging['pages'] = $lower['pages'];           
            if(isset($lower['pages_align'])) $this->arrLowerPaging['pages_align'] = $lower['pages_align'];
            if(isset($lower['page_size'])) $this->arrLowerPaging['page_size'] = $lower['page_size'];
            if(isset($lower['page_size_align'])) $this->arrLowerPaging['page_size_align'] = $lower['page_size_align'];
        }
        if(is_array($upper) && (count($upper) > 0)){
            if(isset($upper['results'])) $this->arrUpperPaging['results'] = $upper['results'];
            if(isset($upper['results_align'])) $this->arrUpperPaging['results_align'] = $upper['results_align'];
            if(isset($upper['pages'])) $this->arrUpperPaging['pages'] = $upper['pages'];           
            if(isset($upper['pages_align'])) $this->arrUpperPaging['pages_align'] = $upper['pages_align'];
            if(isset($upper['page_size'])) $this->arrUpperPaging['page_size'] = $upper['page_size'];
            if(isset($upper['page_size_align'])) $this->arrUpperPaging['page_size_align'] = $upper['page_size_align'];
        }
        if($pages_array){
            if(is_array($pages_array) && (count($pages_array) > 0)){
                $first_key = "";
                foreach($pages_array as $key => $val){
                    if($first_key == "") {$first_key = $key;};
                    if (intval($pages_array[$key]) == 0) $pages_array[$key] = 1;
                }
                $this->arrPages = $pages_array;
                $this->reqPageSize = ($pages_array[$first_key] > 0) ? $pages_array[$first_key] : $this->reqPageSize;               
            }
        }
        if(($default_page_size != "") && ($default_page_size > 0)) { $this->defaultPageSize = $this->reqPageSize = $default_page_size; }
   
        if($paging_arrows != ""){
            if(is_array($paging_arrows) && (count($paging_arrows) > 0)){
                $this->firstArrow    = (isset($paging_arrows["first"])) ? $paging_arrows["first"] : $this->firstArrow;
                $this->previousArrow = (isset($paging_arrows["previous"])) ? $paging_arrows["previous"] : $this->previousArrow;
                $this->nextArrow     = (isset($paging_arrows["next"])) ? $paging_arrows["next"] : $this->nextArrow;
                $this->lastArrow     = (isset($paging_arrows["last"])) ? $paging_arrows["last"] : $this->lastArrow;
            }
        }       
    }

    //--------------------------------------------------------------------------
    // Set filtering settings
    //--------------------------------------------------------------------------
    function AllowFiltering ($option = false, $show_search_type = "true"){
        $this->filteringAllowed = (($option == true) || ($option == "true")) ? true : false ;
        $this->showSearchType  = (($show_search_type == true) || ($show_search_type == "true")) ? true : false ;
    }
    
    function SetFilteringTabularLayoutColumns($tabular_columns = ""){
        $this->tabularColumns = ($tabular_columns != "" && (int)$tabular_columns > 0) ? (int)$tabular_columns : "";
    }
    
    function SetFieldsFiltering($filter_fields_array = ""){
        $req_selSearchType      = $this->GetVariable('_ff_selSearchType');
        $req_onSUBMIT_FILTER    = $this->GetVariable('_ff_onSUBMIT_FILTER');
        $filter_fields_count    = 0; /* used to count fields in SQL (() and () and ())*/

        if(is_array($filter_fields_array)){
            foreach($filter_fields_array as $fldName => $fldValue){
                $this->arrFilterFields[$fldName] = $fldValue;
            }                   
            if($req_onSUBMIT_FILTER != ""){
                $search_type_start = "AND";
                if($req_selSearchType == "0"){
                    $search_type = "AND";                    
                }else{
                    $search_type = "OR";
                }
                if(!substr_count(strtolower($this->sqlView), "where") && !substr_count(strtolower($this->sqlView), "having")) $this->sqlView .= " WHERE 1=1 ";
                if(count($filter_fields_array) > 0) $this->sqlView .= " ".$search_type_start." (";
                // loop by filter fields
                foreach($filter_fields_array as $fldName => $fldValue){
                    $table_field_name = "";
                    $fldValue_fields = str_replace(" ", "", $fldValue['field']);
                    $fldValue_fields = explode(",", $fldValue_fields);
                    
                    $fp_filter_condition  = $this->GetFieldProperty($fldName, "filter_condition", "filter", "normal");
                    // get extension for from/to fields                    
                    $fp_field_type = $this->GetFieldProperty($fldName, "field_type", "filter", "normal");
                    if($fp_field_type != "") $fp_field_type = "_fo_".$fp_field_type;                    
                    
                    // loop 
                    foreach($fldValue_fields as $fldValue_field){
                        // ignore filter field if there was empty 'table' or 'field' attribute
                        if((trim($fldValue['table']) == "") || (trim($fldValue['field']) == "")) { continue; }
                        // table-filed name with fixed "dot" issue
                        $table_field_name = str_replace(".", "_d_", $fldValue['table'])."_".$fldValue_field;
                        
                        // full name of field in URL    
                        $field_name_in_url = $this->uniquePrefix."_ff_".$table_field_name.$fp_field_type;
                        
                        if(isset($_REQUEST[$field_name_in_url]) && ($_REQUEST[$field_name_in_url] !== "")){                        
                            $filter_field_operator = $table_field_name."_operator";                        
                            if(isset($fldValue['case_sensitive']) && ($fldValue['case_sensitive'] != true)){
                                $fldTableField = $this->GetLcaseFooByDbType()."(".(($fldValue['table'] != "") ? $fldValue['table']."." : "" ).$fldValue_field.")";
                                $fldTableFieldName = Helper::ConvertCase($_REQUEST[$field_name_in_url],"lower",$this->langName); 
                            }else{
                                $fldTableField = (($fldValue['table'] != "") ? $fldValue['table']."." : "" ).$fldValue_field;                            
                                $fldTableFieldName = $_REQUEST[$field_name_in_url];
                            }
                            if(isset($fldValue['comparison_type']) && (strtolower($fldValue['comparison_type']) == "numeric")){
                                $left_comma =""; 
                            }else{
                                $left_comma ="'"; 
                            }                            
                                
                            // split by separated words if user split them by ","
                            if(!is_array($fldTableFieldName)) $split_fldTableFieldName = explode(",", $fldTableFieldName);
                            else $split_fldTableFieldName = $fldTableFieldName;
                            $separated_word_count = 0;
                            if(count($split_fldTableFieldName) > 0) $this->sqlView .= " ".(($filter_fields_count++ > 0) ? $search_type_start : "")." ( ";
                            foreach($split_fldTableFieldName as $separated_word){                                
                                $separated_word = trim($separated_word);                                                                
                                // check if there is a formated date fields
                                $separated_word = $this->IsDatePrepare($fldName, $separated_word, "filter", "date_format");
                                
                                if($separated_word_count > 0 ){ $this->sqlView .= " OR "; }
                                $requested_filter_field_operator = isset($_REQUEST[$this->uniquePrefix."_ff_".$filter_field_operator.$fp_field_type]) ? $_REQUEST[$this->uniquePrefix."_ff_".$filter_field_operator.$fp_field_type] : "";
                                if($requested_filter_field_operator != ""){                                
                                    if(isset($fldValue['comparison_type']) && (strtolower($fldValue['comparison_type']) == "binary")) $comparison_type = "BINARY";
                                    else $comparison_type ="";
                                    
                                    // To be sure SQL understands our quotation
                                    if(substr_count($requested_filter_field_operator, "like") > 0){
                                        $separated_word = str_replace('\"', $this->SetRealEscapeStringByDbType('\\\"'), $separated_word); // double quotation mark 
                                        // [#0001-01 under check - 21.11.09] - start
                                        // old version: $separated_word = str_replace("\'", $this->SetRealEscapeStringByDbType("\\\'"), $separated_word); // single quotation mark
                                        $separated_word = str_replace("\'", $this->SetRealEscapeStringByDbType("\'"), $separated_word); // single quotation mark
                                        // [#0001-01 under check - 21.11.09] - end
                                    }else{
                                        $separated_word = str_replace('\"', $this->SetRealEscapeStringByDbType('\\"'), $separated_word); // double quotation mark 
                                        // [#0001-02 under check - 15.05.09] - start
                                        // old version: $separated_word = str_replace("\'", $this->SetRealEscapeStringByDbType("\\'"), $separated_word); // single quotation mark 
                                        $separated_word = str_replace("\'", $this->SetRealEscapeStringByDbType("\'"), $separated_word); // single quotation mark
                                        // [#0001-02 under check - 15.05.09] - end
                                    }
                                    
                                    $requested_filter_field_operator = urldecode($requested_filter_field_operator);
                                    if($requested_filter_field_operator == "like"){
                                        $this->sqlView .= " $fldTableField ".$requested_filter_field_operator." ".$comparison_type." '%".$separated_word."%'";
                                    }else if($requested_filter_field_operator == "like%"){
                                        $this->sqlView .= " $fldTableField ".substr($requested_filter_field_operator, 0, 4)." ".$comparison_type." '".$separated_word."%'";
                                    }else if($requested_filter_field_operator == "%like"){
                                        $this->sqlView .= " $fldTableField ".substr($requested_filter_field_operator, 1, 4)." ".$comparison_type." '%".$separated_word."'";
                                    }else if($requested_filter_field_operator == "%like%"){
                                        $this->sqlView .= " $fldTableField ".substr($requested_filter_field_operator, 1, 4)." ".$comparison_type." '%".$separated_word."%'";
                                    }else{
                                        $this->sqlView .= " $fldTableField ".$requested_filter_field_operator." $left_comma".$separated_word."$left_comma ";
                                    }
                                }else{
                                    $this->sqlView .= " $fldTableField = $left_comma".$separated_word."$left_comma ";                                    
                                }                                                        
                                $separated_word_count++;                                
                            }
                            // add here field_property_filter_condition from "filter_condition" attribute
                            if($fp_filter_condition != ""){
                                $this->sqlView .= (preg_match("/and/i", $fp_filter_condition)) ? " ".$fp_filter_condition." " : " AND ".$fp_filter_condition." ";
                            }                            
                            if(count($split_fldTableFieldName) > 0) $this->sqlView .= " ) ";
                            if($search_type_start !== $search_type){ $search_type_start = $search_type; }
                        }                        
                    }
                }// fields loop
                if($filter_fields_count == 0) $this->sqlView .= "1=1 ";
                if(count($filter_fields_array) > 0) $this->sqlView .= ") ";                
                $this->DataSource($this->dbHandler, $this->sqlView);
            }else if($this->defFilterField != ""){
                $this->sqlView .= " AND ".$this->defFilterFieldWhere." ";
                $this->DataSource($this->dbHandler, $this->sqlView);
            }
        }        
    }
    
    //--------------------------------------------------------------------------
    // Set view mode table properties
    //--------------------------------------------------------------------------    
    function SetViewModeTableProperties($vmt_properties = ""){        
        if(is_array($vmt_properties) && (count($vmt_properties) > 0)){
            if(isset($vmt_properties['width'])) $this->tblWidth['view'] = $vmt_properties['width'];    
        }
    }

    //--------------------------------------------------------------------------
    // Set columns in view mode
    //--------------------------------------------------------------------------    
    function SetColumnsInViewMode($columns = ""){
        unset($this->columnsViewMode);
        $this->columnsViewMode = array();
        if(is_array($columns)){        
            foreach($columns as $fldName => $fldValue){
                $this->columnsViewMode[$fldName] = $fldValue;
            }
        }
    }

    //--------------------------------------------------------------------------
    // Set auto-generated columns in view mode
    //--------------------------------------------------------------------------    
    function SetAutoColumnsInViewMode($auto_columns = ""){
        if(($auto_columns == true) || ($auto_columns == "true")){            
            if($this->dbHandler->isError($this->dataSet) == 1){
                $this->isError = true;
                $this->AddErrors();
            }else{
                unset($this->columnsViewMode);
                $fields = $this->dataSet->tableInfo();
                for($ind=0; $ind < $this->dataSet->numCols(); $ind++){                
                    $this->columnsViewMode[$fields[$ind]['name']] =
                    array("header"  =>$fields[$ind]['name'],
                        "type"      =>"label",
                        "align"     =>"left",
                        "width"     =>"210px",
                        "wrap"      =>"wrap",
                        "tooltip"   =>false,
                        "text_length"=>"-1",
                        "case"      =>"normal",
                        "summarize" =>false,
                        "visible"   =>"true"
                    );
                }                
            }
        }
    }

    //--------------------------------------------------------------------------
    // Set add/edit/details mode table properties
    //--------------------------------------------------------------------------    
    function SetEditModeTableProperties($emt_properties = ""){        
        if(is_array($emt_properties) && (count($emt_properties) > 0)){
            if(isset($emt_properties['width'])) $this->tblWidth['edit'] = $emt_properties['width'];    
        }
    }

    //--------------------------------------------------------------------------
    // Set details mode table properties
    //--------------------------------------------------------------------------    
    function SetDetailsModeTableProperties($dmt_properties = ""){        
        if(is_array($dmt_properties) && (count($dmt_properties) > 0)){
            if(isset($dmt_properties['width'])) $this->tblWidth['details'] = $dmt_properties['width'];    
        }
    }
    
    //--------------------------------------------------------------------------
    // Set editing table & primary key id
    //--------------------------------------------------------------------------
    function SetTableEdit($tbl_name, $field_name, $condition = ""){
        $this->tblName = $tbl_name;
        $field_name_split = explode("\.", $field_name);
        if(isset($field_name_split[1]) && $this->tblName == $field_name_split[0]) $this->primaryKey = $field_name_split[1];
        else $this->primaryKey = $field_name_split[0];
        $this->condition = $condition;
    }

    //--------------------------------------------------------------------------
    // Set columns in add/edit/details mode
    //--------------------------------------------------------------------------    
    function SetColumnsInEditMode($columns = ""){
        unset($this->columnsEditMode);
        $this->columnsEditMode = array();
        if(is_array($columns)){
            foreach($columns as $fldName => $fldValue){
                $this->columnsEditMode[$fldName] = $fldValue;
            }
        }
    }

    //--------------------------------------------------------------------------
    // Set auto-generated columns in add/edit/details mode
    //--------------------------------------------------------------------------    
    function SetAutoColumnsInEditMode($auto_columns = ""){
        if(($auto_columns == true) || ($auto_columns == "true")){
            $sql  = " SELECT * FROM ".$this->tblName." ";
            $dSet = $this->dbHandler->query($sql);
            if($this->dbHandler->isError($dSet) == 1){
                $this->isError = true;
                $this->AddErrors($dSet);
                $this->AddWarning("", "", "Check settings of auto-generated columns property (must be defined after SetTableEdit() method).");
            }else{
                unset($this->columnsEditMode);
                $fields = $dSet->tableInfo();
                
                // try to get default value from field in database for MySQL
                if($this->dbHandler->phptype == "mysql"){
                    $sql_result = mysql_query(" DESCRIBE ".$this->tblName." ");
                }
                
                for($ind=0; $ind < $dSet->numCols(); $ind++){    
                    
                    // for MySQL    
                    $default_value = "";
                    if($this->dbHandler->phptype == "mysql"){
                        $meta = mysql_fetch_assoc($sql_result);
                        if(isset($meta['Default'])) $default_value = $meta['Default'];
                    }

                    if($fields[$ind]['name'] != $this->primaryKey){
                        // get required simbol
                        $required_simbol = ($this->IsFieldRequired($fields[$ind]['name'])) ? "r" : "s";
                        // get field view type & view type 
                        $type_view = "texbox";
                        switch (strtolower($fields[$ind]['type'])){
                            case 'int':     // int: TINYINT, SMALLINT, MEDIUMINT, INT, INTEGER, BIGINT, TINY, SHORT, LONG, LONGLONG, INT24
                                $type_simbol = "i"; break;            
                            case 'real':    // real: FLOAT, DOUBLE, DECIMAL, NUMERIC
                                $type_simbol = "f"; break;            
                            case 'null':    // empty: NULL            
                                $type_simbol = "t"; break;
                            case 'string':  // string: CHAR, VARCHAR, TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT, ENUM, SET, VAR_STRING
                            case 'blob':    // blob: TINYBLOB, MEDIUMBLOB, LONGBLOB, BLOB, TEXT
                            case 'date':    // date: DATE
                            case 'timestamp':    // date: TIMESTAMP
                            case 'year':    // date: YEAR
                            case 'time':    // date: TIME
                                $type_simbol = "t"; break;                        
                            case 'datetime':    // date: DATETIME
                                $type_view = "datetime";
                                $type_simbol = "t"; break;
                            default:
                                $type_simbol = "t"; break;
                        }
                        // get required-type simbols
                        $req_type_simbols = $required_simbol."".$type_simbol;
                        // get field maxlength
                        $field_maxlength = ($fields[$ind]['len'] <= 0) ? "" : $fields[$ind]['len'];                    
                        $this->columnsEditMode[$fields[$ind]['name']] =
                        array("header"  =>$fields[$ind]['name'],
                            "type"      =>"$type_view",
                            "req_type"  =>"$req_type_simbols",
                            "width"     =>"210px",
                            "maxlength" =>"$field_maxlength",
                            "title"     =>$fields[$ind]['name'],
                            "readonly"  =>false,
                            "visible"   =>"true",
                            "default"   =>$default_value,
                        );                    
                    }
                }                        
            }            
        }
    }

    //--------------------------------------------------------------------------
    // Set set foreign keys editing
    //--------------------------------------------------------------------------    
    function SetForeignKeysEdit($foreign_keys_array = ""){
        if(is_array($foreign_keys_array)){                
            foreach($foreign_keys_array as $fldName => $fldValue){
                $this->arrForeignKeys[$fldName] = $fldValue;
            }
        }
    }

    //--------------------------------------------------------------------------
    // Bind data and draw DG
    //--------------------------------------------------------------------------
    function Bind($show = true){
        $this->SetInterfaceLang();        
        $this->SetCommonJavaScript();
        
        // for the case when safeMode == true
        $this->rids = explode("-", $this->rid);
        if(count($this->rids) > 1){
            $this->multiRows = count($this->rids);            
        }
        if(count($this->rids) <= 1) $this->rid = $this->DecodeParameter($this->GetVariable('rid')); 
        $req_mode       = $this->GetVariable('mode');
        $req_new        = $this->GetVariable('new');
        $req_page_size  = $this->GetVariable('page_size');
        $req_sort_field = $this->GetVariable('sort_field');
        $req_sort_field_by   = $this->GetVariable('sort_field_by');
        $req_sort_field_type = $this->GetVariable('sort_field_type');
        $sort_field     = ($req_sort_field_by != "") ? $req_sort_field_by : $req_sort_field ;
        $req_sort_type  = $this->GetVariable('sort_type');
        
        // protect datagrid from a Hack Attacks
        if($this->SecurityCheck())
        {
            // VIEW mode processing
            // we need this (($req_mode == "view") && $this->exportAll) for "Export All"
            if(($req_mode == "") || (($req_mode == "view") && ($req_sort_field_type == "numeric")) || (($req_mode == "view") && $this->exportAll)){
                if($req_sort_field_type == "numeric") $numeric_sort = true; else $numeric_sort = false;
                $this->GetDataSet($this->sqlSort, "", "", $req_sort_field_type, $numeric_sort);
                $view_limit = $this->SetSqlLimitByDbType("0", $req_page_size);
            }
            
            // DELETE mode processing 
            if(($req_mode == "delete") && ($this->rid != "")){          
                if(!$this->isPrinting){
                    $this->DeleteRow($this->rid);
                }
                $this->sql = $this->sqlView." ".$this->sqlGroupBy;
                $this->GetDataSet($this->sqlSort);
                $this->mode = "view";          
            }
            
            // UPDATE mode processing 
            if($req_mode == "update"){ 
                if(!$this->isPrinting){
                    if($req_new != 1){
                        $this->UpdateRow($this->rid);
                    }else{
                        $this->AddRow();
                        $this->modeAfterUpdate = "";
                    }                
                }
                if(($req_new != 1) && ($this->modeAfterUpdate == "edit")){
                    $req_mode = "edit";
                    $this->mode = "edit";
                }else{
                    $this->sql = $this->sqlView." ".$this->sqlGroupBy;
                    $this->GetDataSet($this->sqlSort);
                    $this->mode = "view";
                }
            }            
    
            // EDIT & DETAILS modes processing 
            if((($req_mode == "edit") || ($req_mode == "details")) && ($this->rid != "")){
                if($req_new == 1){
                    $this->dataSet = $this->dbHandler->query($this->sql);            
                }
                $this->AllowSorting(false);
                $this->AllowPaging(false);            
                $this->sqlSort = " ORDER BY ".$this->primaryKey." DESC";
                if(($this->layouts['view'] == "0" || $this->layouts['view'] == "2") && ($this->layouts['edit'] == "1") && ($req_mode == "details")){
                    // if we have more that 1 row selected
                    if(count($this->rids) > 1){ 
                        $where = "WHERE ".$this->primaryKey." IN ('-1' ";
                        foreach ($this->rids as $key){ if($key != "") $where .= ", '".$this->DecodeParameter($key)."' "; }
                        $where .= ") ";
                        // Issue [#123] - start
                        if($sort_field != "") $this->sqlSort = " ORDER BY ".(($req_sort_field_type == "numeric") ? " ABS (".$sort_field.")" : $sort_field)." ".$req_sort_type;
                        // Issue [#123] - end
                    }else{
                        $where = "WHERE ".$this->primaryKey." = '".$this->rid."' ";    
                    }
                    if($this->condition != ""){ $where .= " AND ". $this->condition; }
                    $view_limit = $this->SetSqlLimitByDbType("0", $req_page_size);
                    $fields_list = $this->PreparePasswordDecryption();
                    $fields_list .= $this->tblName.".*";
                    $this->sql = "SELECT ".$fields_list." FROM $this->tblName ".$where; 
                }else if(($this->layouts['view'] == "0" || $this->layouts['view'] == "2") && ($this->layouts['edit'] == "1") && ($req_mode == "edit")){
                    // sort from higest to lowest
                    rsort($this->rids);
                    // if we have more that 1 row selected
                    // mr_1
                    if(count($this->rids) > 1){ 
                        $where = "WHERE ".$this->primaryKey." IN ('-1' ";
                        foreach ($this->rids as $key){ if($key != "") $where .= ", '".$this->DecodeParameter($key)."' "; }
                        $where .= ") ";
                    }else{
                        $where = "WHERE ".$this->primaryKey." = '".$this->rid."' ";    
                    }
                    if($this->condition != ""){ $where .= " AND ". $this->condition; }                     
                    $view_limit = $this->SetSqlLimitByDbType("0", $req_page_size);                
                    $fields_list = $this->PreparePasswordDecryption();
                    $fields_list .= $this->tblName.".*";
                    $this->sql = "SELECT ".$fields_list." FROM $this->tblName ".$where; 
                }else if(($this->layouts['view'] == "0" || $this->layouts['view'] == "2") && ($this->layouts['edit'] == "0") && ($req_mode == "details")){
                    // if we have more that 1 row selected
                    if(count($this->rids) > 1){ 
                        $where = "WHERE ".$this->primaryKey." IN ('-1' ";
                        foreach ($this->rids as $key){ if($key != "") $where .= ", '".$this->DecodeParameter($key)."' "; }
                        $where .= ") ";
                    }else{
                        $where = "WHERE ".$this->primaryKey." = '".$this->rid."' ";    
                    }
                    $view_limit = $this->SetSqlLimitByDbType("0", $req_page_size);
                    $this->sqlSort = "";
                    $this->sql = "SELECT * FROM $this->tblName ".$where; 
                }else if(($this->layouts['view'] == "0") && ($this->layouts['edit'] == "0") && ($req_mode == "edit")){
                    $view_limit = "";                
                    if($this->condition != ""){ 
                        $where = "WHERE ". $this->condition; 
                    } else { 
                        $view_limit = $this->SetSqlLimitByDbType();
                        $where = "";
                    }
                    // prepare sorting, but prevent unexpected cases
                    if(!is_numeric($sort_field) || (is_numeric($sort_field) && $sort_field <= $this->dataSet->numRows())){
                        if($req_sort_field != "") $this->sqlSort = " ORDER BY ".(($req_sort_field_type == "numeric") ? " ABS (".$sort_field.")" : $sort_field)." ".$req_sort_type;   
                    }
                    $fields_list = $this->PreparePasswordDecryption();
                    $fields_list .= $this->tblName.".*";                    
                    $this->sql = "SELECT ".$fields_list." FROM $this->tblName ".$where;
                }else{
                    $view_limit = $this->SetSqlLimitByDbType("0", $req_page_size);                
                    $where = "WHERE ".$this->primaryKey." = '".$this->rid."' ";
                    $this->sql = "SELECT * FROM $this->tblName ".$where;                 
                }            
    
                $this->GetDataSet($this->sqlSort, $view_limit, $this->modeAfterUpdate);
                if($req_mode == "edit") $this->mode = "edit";
                else $this->mode = "details";           
            }

            // CANCEL mode processing 
            if($req_mode == "cancel"){
                $this->rid = "";
                $this->sql = $this->sqlView." ".$this->sqlGroupBy;
                $this->GetDataSet($this->sqlSort);            
                $this->mode = "view";
            }    

            // ADD mode processing 
            if($req_mode == "add"){
                $this->modeAfterUpdate = "";
                // we don't need multirow option allowed when we add new record
                $this->isMultirowAllowed = false;
                if(($this->layouts['view'] == "0") && ($this->layouts['edit'] == "0")){
                    // we need
                    $view_limit = "";
                    if($this->condition != "") $where = " WHERE ". $this->condition;
                    else $where = "";
                    $this->sql = "SELECT * FROM $this->tblName ".$where;                
                }else{
                    $view_limit = "";
                    $this->sql = "SELECT * FROM $this->tblName ";                
                }
                $this->sqlSort = " ORDER BY ".$this->primaryKey." DESC";
                $this->GetDataSet($this->sqlSort, $view_limit);
                $this->rid = -1;
                $this->AllowSorting(false);
                $this->AllowPaging(false);
                $this->mode = "edit";
            }            
        }else{           
            // VIEW mode processing 
            if($req_mode == ""){
                if($req_sort_field_type == "numeric") $numeric_sort = true; else $numeric_sort = false;
                $this->GetDataSet($this->sqlSort, "", "", $req_sort_field_type, $numeric_sort);
                $view_limit = $this->SetSqlLimitByDbType("0", $req_page_size);    
            }
            // block possibility to add new record on security alert
            $this->modes["add"]["view"] = false; 
            if($this->debug){
                echo "<br /><center><label class='default_dg_error_message'>Wrong parameters were passed! Possible Hack attack!</label></center><br />";
            }else{
                echo "<br /><center><label class='default_dg_error_message'>Wrong parameters were passed!</label></center><br />";                
            }
        }
        
        $this->SetCommonJavaScriptEnd();        
        
        if($this->ajaxEnabled){
            echo "<div id='".$this->uniquePrefix."dg_ajax_container'>\n";
            echo "<div id='".$this->uniquePrefix."dg_ajax_container_opacity' style='width:100%;position:relative;'>\n";
            if($this->ajaxEnabled) echo "<div id='".$this->uniquePrefix."ajax_loading_image' style='position:absolute;display:none;margin:0 auto;left:50%;right:50%;top:20px;width:32px;height:32px;'><img src='".$this->directory."images/ajax_loading.gif' alt='".$this->lang['loading_data']."' border='0' /></div>\n";
        }
                
        if($this->dataSet){            
            if(($this->mode === "edit") || ($this->mode === "add")){
                $this->layoutType = "edit";
                $this->AllowHighlighting(false);
            }else if($this->mode === "details"){
                $this->layoutType = "show";
                $this->AllowHighlighting(false);
            }else {
                $this->layoutType = "view";
            }
            
            // sort columns by mode order
            $this->SortColumns($this->mode);
            
            if($show == true){
                $this->WriteCssClass();                
               
                if($this->layouts[$this->layoutType] == "0"){
                    $this->DrawTabular();
                }else if($this->layouts[$this->layoutType] == "1"){
                    $this->DrawColumnar();
                }else if($this->layouts[$this->layoutType] == "2"){
                    $this->DrawCustomized();                
                }else{
                    $this->DrawTabular();
                }
            }
        }        
        
        $this->DisplaySqlStatements();                
        $this->DisplayDataSent();                
        $this->DisplayErrors();
        $this->DisplayWarnings();
        
        // finish calculating running time of a script
        if($this->debug){
            $this->endTime = $this->GetFormattedMicrotime();
            echo "<br /><center><label class='default_dg_label'>Total running time: ".round((float)$this->endTime - (float)$this->startTime, 6)." sec.</label></center>";
        }        

        if($this->ajaxEnabled) echo "</div></div><div id='".$this->uniquePrefix."dg_ajax_container_end'></div>";

        echo "\n<!-- END This script was generated by datagrid.class.php v.".$this->dgVersion." (http://www.apphp.com/php-datagrid/index.php) END -->\n";
        $this->SetCommonJavaScriptAjax();
        
    }

    ////////////////////////////////////////////////////////////////////////////
    //
    // Non documented
    //
    ////////////////////////////////////////////////////////////////////////////
    //--------------------------------------------------------------------------
    // Set summarize number format
    //--------------------------------------------------------------------------
    function SetSummarizeNumberFormat($decimal_places = "2", $decimal_separator = ".", $thousands_separator = ","){
        $this->summarizeNumberFormat['decimal_places'] = (int)$decimal_places;
        $this->summarizeNumberFormat['decimal_separator'] = $decimal_separator;
        $this->summarizeNumberFormat['thousands_separator'] = $thousands_separator;
    }

    //--------------------------------------------------------------------------
    // Enable/Unable loading image
    //--------------------------------------------------------------------------
    function DisplayLoadingImage($display = true){
        $this->isLoadingImageEnabled = ($display == "true" || $display === true) ? true : false;
    }    

    //--------------------------------------------------------------------------
    // Returns status of current operation
    //--------------------------------------------------------------------------
    function IsOperationCompleted(){
        return $this->isOperationCompleted;    
    }
    
    //--------------------------------------------------------------------------
    // Sets using of <BASE> tag
    //--------------------------------------------------------------------------
    function IgnoreBaseTag($ignore = "false"){
        $this->ignoreBaseTag = (($ignore == "true") || ($ignore == true)) ? true : false;    
    }
    
    //--------------------------------------------------------------------------
    // ExecuteSQL - returns dataSet after executing custom SQL statement
    //--------------------------------------------------------------------------
    function ExecuteSQL($sql = ""){
        $dataSet = "";
        if($this->dbHandler){
            if($sql != ""){
                $this->SetEncodingOnDatabase();
                $dataSet = & $this->dbHandler->query($sql);
            }
            if($this->debug){
                if($this->dbHandler->isError($dataSet) == 1){ $debugInfo = "<tr><td>".$dataSet->getDebugInfo()."</td></tr>"; } else { $debugInfo = ""; };
                echo "<table width='".$this->tblWidth[$this->mode]."'><tr><td align='left'><label class='".$this->cssClass."_dg_label'><b>sql: </b>".$sql."</label></td></tr>".$debugInfo."</table><br />";
            }               
        }else{
            $this->AddWarning('ExecuteSQL() method', 'This method must be called after DataSource() method only!');
        }
        return $dataSet;               
    }

    //--------------------------------------------------------------------------
    // SelectSqlItem - return the first field after executing custom SELECT SQL statement
    //--------------------------------------------------------------------------
    function SelectSqlItem($sql = ""){
        $dataField = "";
        $num_cols = "0";
        if($this->dbHandler){       
            if($sql != ""){
                $this->SetEncodingOnDatabase();
                $this->dbHandler->setFetchMode(DB_FETCHMODE_ORDERED); 
                $dataSet = & $this->dbHandler->query($sql);
                if(method_exists($dataSet, 'numCols') && $dataSet->numCols() > 0){
                   $row = $dataSet->fetchRow();
                   $dataField = $row[0];
                   $num_cols = $dataSet->numCols();
                }
                if($this->debug){
                    if($this->dbHandler->isError($dataSet) == 1){ $debugInfo = "<tr><td>".$dataSet->getDebugInfo()."</td></tr>"; } else { $debugInfo = ""; };
                    $this->sqlStatements[] = "<table width='".$this->tblWidth[$this->mode]."'><tr><td align='left' class='".$this->cssClass."_dg_error_message no_print' style='COLOR: #333333;'><label class='".$this->cssClass."_dg_label'><b>select sql (".Helper::ConvertCase($this->lang['total'],"lower",$this->langName).": ".$num_cols.") </b>".$sql."</label></td></tr>".$debugInfo."</table>";
                }              
            }
        }else{
            $this->AddWarning('SelectSqlItem() method', 'This method must be called after DataSource() method only!');
        }
        return $dataField;               
    }
    
    function AllowHighlighting($option = true){ $this->isRowHighlightingAllowed = (($option == true) || ($option == "true")) ? true : false ; }    

    //--------------------------------------------------------------------------
    // Set javascript errors display style
    //--------------------------------------------------------------------------
    function SetJsErrorsDisplayStyle($display_style = "all"){        
        $this->jsValidationErrors = ($display_style == "all") ? "true" : "false";
    }    

    //--------------------------------------------------------------------------
    // Get current Id
    //--------------------------------------------------------------------------
    function GetCurrentId(){
        return ($this->rid != "") ? $this->rid : "";
    }

    //--------------------------------------------------------------------------
    // Get next Id
    //--------------------------------------------------------------------------
    function GetNextId(){
        if(isset($this->dbHandler)){
            // need to be declined if creating new row was cancelied
            // return $this->dbHandler->nextId("'".$this->tblName."'");            
            $sql  = " SELECT MAX(".$this->primaryKey.") as max_id FROM ".$this->tblName." ";
            $dSet = $this->dbHandler->query($sql);
            if($row = $dSet->fetchRow()){
                return $row[0]+1;
            }
        }else{
            return "-1";        
        }        
    } 

    //--------------------------------------------------------------------------
    // Set messages
    //--------------------------------------------------------------------------
    function SetDgMessages($add_message = "", $update_message = "", $delete_message = ""){
        $this->arrDgMessages['add'] = $add_message;
        $this->arrDgMessages['update'] = $update_message;
        $this->arrDgMessages['delete'] = $delete_message;
    }

    //--------------------------------------------------------------------------
    // Set header names in columnar layout
    //--------------------------------------------------------------------------
    function SetHeadersInColumnarLayout($field_header = "", $field_value_header = ""){
        $this->fieldHeader = $field_header;
        $this->fieldHeaderValue = $field_value_header;
    }
    
    //--------------------------------------------------------------------------
    // Write css class
    //--------------------------------------------------------------------------
    function WriteCssClass(){
        if(!$this->isCssClassWritten){

            echo "\n<!-- DataGrid CSS definitions - START -->";
            $this->SetMediaPrint();
            $this->DefineCssClass();
            // if we in Print Mode
            if($this->isPrinting){
                $this->rowColor[0] = "";
                $this->rowColor[1] = "";            
                $this->rowColor[2] = ""; // dark
                $this->rowColor[3] = ""; // light
                $this->rowColor[4] = ""; // row mouse over lighting
                $this->rowColor[5] = ""; // on mouse click
                $this->rowColor[6] = ""; // header (th main) column
                $this->rowColor[7] = ""; // selected row mouse over lighting
                $this->rowColor[8] = "";
                $this->rowColor[9] = "";
                echo "\n<!--[if IE]><link rel='stylesheet' type='text/css' href='".$this->directory."styles/print/style_IE.css' /><![endif]-->";            
                echo "\n<link rel='stylesheet' type='text/css' href='".$this->directory."styles/print/style.css'>";
                $this->cssClass = "print";
            }else{
                echo "\n<!--[if IE]><link rel='stylesheet' type='text/css' href='".$this->directory."styles/".$this->cssClass."/style_IE.css' /><![endif]-->";            
                echo "\n<link rel='stylesheet' type='text/css' href='".$this->directory."styles/".$this->cssClass."/style.css' />";            
            }
            echo "\n<!-- DataGrid CSS definitions - END -->\n\n";            
            $this->isCssClassWritten = true;            
        }
    }


    //==========================================================================
    // PROTECTED MEMBER FUNCTIONS 
    //==========================================================================
    //--------------------------------------------------------------------------
    // Set unique names
    //--------------------------------------------------------------------------
    protected function SetUniquePrefix($unique_prefix = ""){
        $this->uniquePrefix = $unique_prefix;
        $this->uniqueRandomPrefix = $this->GetRandomString("5");
    }

    //--------------------------------------------------------------------------
    // Set css class
    //--------------------------------------------------------------------------
    protected function DefineCssClass(){
        echo "\n<style type='text/css'>.resizable-textarea .grippie { BACKGROUND: url(".$this->directory."images/grippie.png) #eee no-repeat center 2px; }</style>";
        // read style color definitions
        $file_name = $this->directory."styles/".$this->cssClass."/colors.inc.php";
        if (file_exists($file_name)) { 
            include($file_name);
            if(isset($rowColor)){
                $this->rowColor[0] = $rowColor[0]; // odd row color 
                $this->rowColor[1] = $rowColor[1]; // even row color
                $this->rowColor[2] = $rowColor[2]; // odd row color in main colomn
                $this->rowColor[3] = $rowColor[3]; // even row color in main colomn
                $this->rowColor[4] = $rowColor[4]; // row mouse over lighting 
                $this->rowColor[5] = $rowColor[5]; // on mouse click 
                $this->rowColor[6] = $rowColor[6]; // header (th main) column
                $this->rowColor[7] = $rowColor[7]; // selected row mouse over lighting
                $this->rowColor[8] = $rowColor[8];
                $this->rowColor[9] = $rowColor[9];
                return true;                
            }
        }
        
        $this->rowColor[0] = "#fcfaf6"; // odd row color 
        $this->rowColor[1] = "#ffffff"; // even row color
        $this->rowColor[2] = "#ebeadb"; // odd row color in main colomn
        $this->rowColor[3] = "#ebeadb"; // even row color in main colomn
        $this->rowColor[4] = "#e2f3fc"; // row mouse over lighting 
        $this->rowColor[5] = "#fdfde7"; // on mouse click 
        $this->rowColor[6] = "#e2e0cb";        // header (th main) column 
        $this->rowColor[7] = "#f9f9e3"; // selected row mouse over lighting
        $this->rowColor[8] = "#fcfaf6";
        $this->rowColor[9] = "#fcfaf6";
    }

    //--------------------------------------------------------------------------
    // Get DataSet
    //--------------------------------------------------------------------------
    protected function GetDataSet($fsort = "", $limit = "", $mode = "", $sort_field = "", $numeric_sort = false, $first_time = false){
        $this->SetEncodingOnDatabase();

        // we need this stupid operation to get a total number of rows in our query
        $this->SetTotalNumberRows($fsort, $limit, $mode, $first_time);

        // we need this stupid operation to change field's offset on field's name
        if(($numeric_sort == true) && ($sort_field != "")){
            $this->dataSet = & $this->dbHandler->query($this->SetSqlByDbType($this->sql, $fsort, " LIMIT 0, 1"));            
            $this->sqlSort = str_replace("ABS(".$sort_field.")", "ABS(".$this->GetFieldName($sort_field-1).")", $this->sqlSort);
        }

        if($limit == ""){
            $limit = $this->SetSqlLimitByDbType();
            $this->dataSet = &$this->dbHandler->query($this->SetSqlByDbType($this->sql, $fsort, $limit));
        }

        if($this->dbHandler->isError($this->dataSet) == 1){
            $this->isError = true;
            $this->AddErrors();
        }

        $this->rows = $this->NumberRows();
        $this->columns = $this->NumberCols();
        
        if($this->debug){
            $this->sqlStatements[] = "<table width='".$this->tblWidth[$this->mode]."'><tr><td align='left' class='".$this->cssClass."_dg_error_message no_print' style='COLOR: #333333;'><b>search sql (".Helper::ConvertCase($this->lang['total'],"lower",$this->langName).": ".$this->rows.") </b>".$this->SetSqlByDbType($this->sql, $fsort, $limit)."</td></tr></table>";
        }

        $this->rowLower = 0;
        $this->rowUpper = $this->rows;

        $this->colLower = 0;
        $this->colUpper = $this->columns;        
    }

    //--------------------------------------------------------------------------
    // Ger ORDER BY fields list
    //--------------------------------------------------------------------------
    protected function GetOrderByList(){
        $orderByList = "";
        for($ind=0; $ind < count($this->defaultSortField); $ind++){
            if($ind != 0) $orderByList .= ",";
            $orderByList .= " ".$this->defaultSortField[$ind]." ".$this->defaultSortType[$ind];
        }
        return $orderByList;
    }

    //--------------------------------------------------------------------------
    // Perform security check for possible hack attacks
    //--------------------------------------------------------------------------
    protected function SecurityCheck(){
        // check rid variable
        if(preg_match("/'/", $this->rid) || preg_match('/"/', $this->rid) || preg_match("/%27/", $this->rid) || preg_match("/%22/", $this->rid)){
            return false;
        }
        if($this->securityLevel == "low"){
            // check query string
            $query_string = strtolower(rawurldecode($this->QUERY_STRING));
            $bad_string = array("%00", "%01", "document.cooki");
            foreach ($bad_string as $string_value){
                if (strstr($query_string, $string_value )){
                    return false;
                }
            }                        
        }
        if($this->securityLevel == "medium"){
            // check query string
            $query_string = strtolower(rawurldecode($this->QUERY_STRING));
            $bad_string = array("%00", "%01", "%20union%20", "/*", "*/union/*", "+union+", "document.cooki", "document.cookie", "%3Cscrip", "<script", "<iframe", "<applet", "<form", "<body", "<link", "_GLOBALS", "_REQUEST", "_GET", "_POST", "include_path", "prefix", "http://", "https://", "ftp://", "smb://" );
            foreach ($bad_string as $string_value){
                if (strstr($query_string, $string_value )){
                    return false;
                }
            }            
        }
        if($this->securityLevel == "high"){
            // check query string
            $query_string = strtolower(rawurldecode($this->QUERY_STRING));
            $bad_string = array("%00", "%01", "%20union%20", "/*", "*/union/*", "+union+", "insert+", "update+", "delete+", "load_file", "outfile", "document.cooki", "document.cookie", "onmouse", "%3Cscrip", "<script", "<iframe", "<applet", "<meta", "<style", "<form", "<img", "<body", "<link", "_GLOBALS", "_REQUEST", "_GET", "_POST", "include_path", "prefix", "http://", "https://", "ftp://", "smb://" );
            foreach ($bad_string as $string_value){
                if (strstr($query_string, $string_value )){
                    return false;
                }
            }            
        }
        return true;
    }    

    //--------------------------------------------------------------------------
    // Set encoding and collation on database
    //--------------------------------------------------------------------------
    protected function SetEncodingOnDatabase(){
        $sql_variables = array(
                'character_set_client'  =>$this->encoding,
                'character_set_server'  =>$this->encoding,
                'character_set_results' =>$this->encoding,
                'character_set_database'=>$this->encoding,
                'character_set_connection'=>$this->encoding,
                'collation_server'      =>$this->collation,
                'collation_database'    =>$this->collation,
                'collation_connection'  =>$this->collation
        );
        switch ($this->dbHandler->phptype){ 
            case "ibase":
            case "firebird": 
            case "oci8": break;
            
            default:
                foreach($sql_variables as $var => $value){
                    $sql = "SET $var=$value;";
                    $this->dbHandler->query($sql);
                }        
            break;
        }
    }

    //--------------------------------------------------------------------------
    // Table drawing functions 
    //--------------------------------------------------------------------------
    protected function ShowCaption() {
        $print_css_start = ($this->isPrinting) ? "<center>" : "";
        $print_css_end = ($this->isPrinting) ? "</center>" : "";
        echo ($this->caption != "") ? $print_css_start."<div class='".$this->cssClass."_dg_caption'>". $this->caption ."</div>".$print_css_end."<p></p>".chr(13) : "";
    }

    protected function TblOpen($style=""){
        if($this->scrollingOption == true) {
            $width = ($this->mode == "view") ?  "100%" : $this->tblWidth[$this->mode];
        }else{
            $width = $this->tblWidth[$this->mode];
        }
        $horizontal_align = ($this->tblAlign[$this->mode] == "center") ? "margin-left:auto;margin-right:auto;" : "";
        echo "<table dir='".$this->direction."' align='center' id='".$this->uniquePrefix."_contentTable' class='".$this->cssClass."_dg_table' style='".$horizontal_align.$style."' width='".$width."'>".chr(13);        
    }
    
    protected function TblHeadOpen(){ echo "<thead>".chr(13);; }
    protected function TblHeadClose(){ echo "</thead>".chr(13);; }

    protected function TbodyOpen() { echo "<tbody>".chr(13);  }    
    protected function TbodyClose(){ echo "</tbody>".chr(13); }

    protected function TblClose(){
        echo "</table>".chr(13);
    }

    protected function HideDivOpen(){
        $req_onSUBMIT_FILTER = $this->GetVariable('_ff_onSUBMIT_FILTER');
        if(($this->hideGridBeforeSearch == true) && !($req_onSUBMIT_FILTER != "")){            
            echo "<div style='display: none;'>"; echo chr(13);
        }        
    }

    protected function HideDivClose(){
        $req_onSUBMIT_FILTER = $this->GetVariable('_ff_onSUBMIT_FILTER');        
        if(($this->hideGridBeforeSearch == true) && !($req_onSUBMIT_FILTER != "")){            
            echo "</div>"; echo chr(13);
        }        
    }
    
    protected function RowOpen($id, $rowColor = "", $height=""){
        $text = "<tr class='dg_tr' style='".(($rowColor != "") ? "background-color: ".$rowColor.";" : "") ."'  id='".$this->uniquePrefix."row_".$id."' ";       
        if($height != "") { $text .= "height='".$height."' "; };
        if(!$this->isPrinting){
            if($this->isRowHighlightingAllowed){
                $text .= " onclick=\"onMouseClickRow('".$this->uniquePrefix."','".$id."','".$this->rowColor[5]."', '".$this->rowColor[1]."', '".$this->rowColor[0]."');\" ";
                $text .= " onmouseover=\"onMouseOverRow('".$this->uniquePrefix."','".$id."','".$this->rowColor[4]."', '".$this->rowColor[7]."');\" ";
                $text .= " onmouseout=\"onMouseOutRow('".$this->uniquePrefix."','".$id."','".$rowColor."','".$this->rowColor[5]."');\" ";
            }            
        }else{
            $text .= " ";
        }
        $text .= ">".chr(13);
        echo $text;        
    }
    
    protected function RowClose(){
        echo "</tr>".chr(13);
    }
    
    protected function MainColOpen($align='left', $colSpan=0, $wrap='', $width='', $class='', $style=''){
        if($class == '') $class = $this->cssClass."_dg_th";
        $class_align = ($align == "") ? "" : " dg_".$align;
        $wrap = ($wrap == '') ? $this->wrap : $wrap;        
        $text = "<th class='".$class.$class_align.(($wrap == 'nowrap') ? " dg_nowrap' " : "' ");
        $text .= "style='";
        if($this->rowColor[6] != "") $text .= "background-color:".$this->rowColor[6].";";
        $text .= ($width !== '') ? "width: ".$width.";' " : "' ";        
        $text .= ($this->mode != "edit") ? "onmouseover=\"bgColor='".$this->rowColor[3]."';\" onmouseout=\"bgColor='".$this->rowColor[6]."';\"" : "";
        $text .= ($colSpan != 0) ? " colspan='$colSpan'" : "";        
        $text .= ($style != '') ? " ".$style : "";
        $text .= ">";
        echo $text;                
    }
    
    protected function MainColClose(){
        echo "</th>".chr(13);
    }   
    
    protected function ColOpen($align='left', $colSpan=0, $wrap='', $bgcolor='', $class_td='', $width='', $style=''){
        if($class_td == '') $class_td = $this->cssClass."_dg_td";
        $wrap = ($wrap == '') ? $this->wrap : $wrap;
        $class_align = ($align == "") ? "" : " dg_".$align;
        $text = "<td class='".$class_td.$class_align;
        $text .= ($wrap == 'nowrap') ? " dg_nowrap' " : "' ";
        $text .= "style='";
        $text .= ($width !== '')? " width: ".$width.";" : "";
        $text .= ($bgcolor !== '')? " background-color: ".$bgcolor.";' " : "'";        
        $text .= ($colSpan != 0) ? " colspan='$colSpan'" : "";
        $text .= ($style != '') ? " $style" : "";
        $text .= ">";
        echo $text;                
    }
    
    protected function ColClose(){
        echo "</td>".chr(13);
    }
    
    protected function EmptyRow(){
        $this->RowOpen("","");
        $this->ColOpen();$this->ColClose();
        $this->RowClose();                              
    }

    protected function ScriptOpen($br = "", $src=""){
        return $br."<script type='text/javascript'".(($src != "") ? " ".$src.">" : ">\n<!--\n");
    }

    protected function ScriptClose($br = "\n//-->\n"){
        return $br."</script>\n";
    }

    //--------------------------------------------------------------------------
    // Draw control panel
    //--------------------------------------------------------------------------
    protected function DrawControlPanel(){       
        $req_export = $this->GetVariable('export');
        $req_mode   = $this->GetVariable('mode');        
        $myRef_window = $this->uniquePrefix."myRef";
        
        if($this->filteringAllowed || $this->exportingAllowed || $this->printingAllowed){
            $margin_bottom = ($this->layoutType == "edit") ? "margin-bottom: 7px;" : "margin-bottom: 5px;";
            echo "<table border='0' id='printTbl' align='center' style='margin-left:auto; margin-right:auto; $margin_bottom' width='".$this->tblWidth[$this->mode]."' cellspacing='1' cellpadding='1'>";
            echo "<tr>";
            echo "<td align='left'>";
            if($this->mode == "edit"){
                echo "<label class='".$this->cssClass."_dg_label'>".$this->lang['required_fields_msg']."</label>";
            }else{
                echo $this->navigationBar;
            }
            echo "</td>";        
            if($this->filteringAllowed && (($this->mode != "edit") && ($this->mode != "details"))){
                echo "<td align='right' class='dg_nowrap' style='width: 20px;'>";
                $hide_display = "";
                $unhide_display = "display: none; ";            
                if(isset($_COOKIE[$this->uniquePrefix.'hide_search'])) {
                    if($_COOKIE[$this->uniquePrefix.'hide_search'] == 1){    
                        $this->hideDisplay = "display: none;";
                        $hide_display = "display: none; ";
                        $unhide_display = "";                    
                    }else{
                        $this->hideDisplay = "";
                        $hide_display = "";
                        $unhide_display = "display: none; ";                    
                    }
                }else if($this->initFilteringState == "closed"){
                    $this->hideDisplay = "display: none;";
                    $hide_display = "display: none; ";
                    $unhide_display = "";                                        
                }
                if(!$this->isPrinting){
                    echo "<a id='".$this->uniquePrefix."a_hide' style='cursor:pointer; ".$hide_display."' onClick=\"return hideUnHideFiltering('hide', '".$this->uniquePrefix."');\"><img align='center' src='".$this->directory."styles/".$this->cssClass."/images/search_hide_b.gif' onmouseover='this.src=\"".$this->directory."styles/".$this->cssClass."/images/search_hide_r.gif\"' onmouseout='this.src=\"".$this->directory."styles/".$this->cssClass."/images/search_hide_b.gif\"' alt='".$this->lang['hide_search']."' title='".$this->lang['hide_search']."' /></a>";
                    echo "<a id='".$this->uniquePrefix."a_unhide' style='cursor:pointer; ".$unhide_display."' onClick=\"return hideUnHideFiltering('unhide', '".$this->uniquePrefix."');\"><img align='center' src='".$this->directory."styles/".$this->cssClass."/images/search_unhide_b.gif' onmouseover='this.src=\"".$this->directory."styles/".$this->cssClass."/images/search_unhide_r.gif\"' onmouseout='this.src=\"".$this->directory."styles/".$this->cssClass."/images/search_unhide_b.gif\"' alt='".$this->lang['unhide_search']."' title='".$this->lang['unhide_search']."' /></a>";
                }
                echo "</td>\n";
            }            
            $use_question_sign = ($this->QUERY_STRING == "") ? true : false;
            if($this->exportingAllowed){
                
                if($this->ajaxEnabled){
                    $export_location = "'".(($use_question_sign) ? "?" : $this->HTTP_URL."?".$this->QUERY_STRING."&").$this->uniquePrefix."export=true'";                    
                }else{
                    $export_location = "self.location+'".(($use_question_sign) ? "?" : "&").$this->uniquePrefix."export=true'";   
                }
                if((($req_export == "") || !$this->isPrinting) && ($this->isPrinting == "")){                    
                    if($this->arrExportingTypes["excel"] == true){
                        echo "<td align='right' style='width: 20px;'>\n";
                        echo "<a style='cursor:pointer;' onClick=\"".$myRef_window."=window.open(".$export_location."+'&".$this->uniquePrefix."export_type=csv','ExportToCsv','left=100,top=100,width=540,height=360,toolbar=0,resizable=0,location=0,scrollbars=1');".$myRef_window.".focus();\" class='".$this->cssClass."_dg_a'>";
                        echo "<img align='center' src='".$this->directory."styles/".$this->cssClass."/images/excel_b.gif'  onmouseover='this.src=\"".$this->directory."styles/".$this->cssClass."/images/excel_r.gif\"' onmouseout='this.src=\"".$this->directory."styles/".$this->cssClass."/images/excel_b.gif\"' alt='".$this->lang['export_to_excel']."' title='".$this->lang['export_to_excel']."' /></a>\n";
                        echo "</td>\n";                            
                    }
                    if($this->arrExportingTypes["pdf"] == true){
                        echo "<td align='right' style='width: 20px;'>\n";
                        echo "<a style='cursor:pointer;' onClick=\"".$myRef_window."=window.open(".$export_location."+'&".$this->uniquePrefix."export_type=pdf','ExportToPdf','left=100,top=100,width=540,height=360,toolbar=0,resizable=0,location=0,scrollbars=1');".$myRef_window.".focus();\" class='".$this->cssClass."_dg_a'>";
                        echo "<img align='center' src='".$this->directory."styles/".$this->cssClass."/images/pdf_b.gif'  onmouseover='this.src=\"".$this->directory."styles/".$this->cssClass."/images/pdf_r.gif\"' onmouseout='this.src=\"".$this->directory."styles/".$this->cssClass."/images/pdf_b.gif\"' alt='".$this->lang['export_to_pdf']."' title='".$this->lang['export_to_pdf']."' /></a>";
                        echo "</td>\n";                            
                    }
                    if($this->arrExportingTypes["xml"] == true){
                        echo "<td align='right' style='width: 20px;'>\n";
                        echo "<a style='cursor:pointer;' onClick=\"".$myRef_window."=window.open(".$export_location."+'&".$this->uniquePrefix."export_type=xml','ExportToXml','left=100,top=100,width=540,height=360,toolbar=0,resizable=0,location=0,scrollbars=1');".$myRef_window.".focus();\" class='".$this->cssClass."_dg_a'>";
                        echo "<img align='center' src='".$this->directory."styles/".$this->cssClass."/images/xml_b.gif'  onmouseover='this.src=\"".$this->directory."styles/".$this->cssClass."/images/xml_r.gif\"' onmouseout='this.src=\"".$this->directory."styles/".$this->cssClass."/images/xml_b.gif\"' alt='".$this->lang['export_to_xml']."' title='".$this->lang['export_to_xml']."' /></a>";
                        echo "</td>\n";                                                        
                    }
                }else{
                    echo "<td align='right' style='width: 20px;'></td>\n";        
                }                
            }
            if($this->printingAllowed){
                if($this->ajaxEnabled){
                    $print_location = "'".(($use_question_sign) ? "?" : $this->HTTP_URL."?".$this->QUERY_STRING."&").$this->uniquePrefix."print=true'";   
                }else{
                    $print_location = "self.location+'".(($use_question_sign) ? "?" : "&").$this->uniquePrefix."print=true'";   
                }
                if(($req_export == "") && !$this->isPrinting){
                    echo "<td align='right' style='width: 20px;'><a style='cursor:pointer;' onClick=\"".$myRef_window."=window.open(".str_replace("&", "&amp;", $print_location).",'PrintableView','left=20,top=20,width=840,height=630,toolbar=0,menubar=0,resizable=0,location=0,scrollbars=1');".$myRef_window.".focus()\" class='".$this->cssClass."_dg_a'><img align='center' src='".$this->directory."styles/".$this->cssClass."/images/print_b.gif' onmouseover='this.src=\"".$this->directory."styles/".$this->cssClass."/images/print_r.gif\"' onmouseout='this.src=\"".$this->directory."styles/".$this->cssClass."/images/print_b.gif\"' alt='".$this->lang['printable_view']."' title='".$this->lang['printable_view']."' /></a></td>\n";
                }else{
                    echo "<td align='right'><a style='cursor:pointer;' onClick='window:print();' class='".$this->cssClass."_dg_a no_print'  title='".$this->lang['print_now_title']."'>".$this->lang['print_now']."</a></td>\n";
                }
            }
            if($this->filteringAllowed && ($this->mode == "view") && ($req_mode != "update") && ($req_mode != "delete")){
                if(!$this->isPrinting){
                    $href_string = ($this->ajaxEnabled) ? "javascript:".$this->uniquePrefix."_doAjaxRequest(\"".(($this->QUERY_STRING!="") ? "?".$this->QUERY_STRING : "")."\");" : "document.location.href=self.location;";
                    echo "<td align='right' style='width: 20px;'><a style='cursor:pointer;' onClick='".str_replace("&", "&amp;", $href_string)."' class='".$this->cssClass."_dg_a'><img align='center' src='".$this->directory."styles/".$this->cssClass."/images/recycle.gif' alt='".$this->lang['refresh_page']."' title='".$this->lang['refresh_page']."' /></a></td>";
                }
            }        
            echo "</tr>";
            echo "</table>";
        }else{
            if($this->mode == "edit"){
                $margin_bottom = ($this->layoutType == "edit") ? "margin-bottom: 7px;" : "margin-bottom: 5px;";
                echo "<table border='0' id='printTbl' style='margin-left: auto; margin-right: auto; $margin_bottom' width='".$this->tblWidth[$this->mode]."' cellspacing='1' cellpadding='1'>";
                echo "<tr><td align='left'><label class='".$this->cssClass."_dg_label'>".$this->lang['required_fields_msg']."</label></td></tr>";
                echo "</table>"; 
            }
        }
    }

    //--------------------------------------------------------------------------
    // Export dispatcher 
    //--------------------------------------------------------------------------    
    protected function ExportTo(){
        $req_export  = $this->GetVariable('export');
        $export_type = $this->GetVariable('export_type');
        $req_page_size = (isset($_REQUEST[$this->uniquePrefix.'page_size'])) ? $_REQUEST[$this->uniquePrefix.'page_size'] : $this->reqPageSize;
        if($this->exportAll){
            $page_size = $this->rowUpper;
        }else{
            $page_size = ($this->rowLower + $req_page_size);
        }
        
        if($req_export == true){
            if($export_type == "pdf"){
                $this->ExportToPdf($page_size);
            }else if($export_type == "xml"){
                $this->ExportToXml($page_size);    
            }else{ // csv
                $this->ExportToCsv($page_size);                
            }
        }
    }

    //--------------------------------------------------------------------------
    // Export to CSV (if you change export file name - change file name length in download.php)
    //--------------------------------------------------------------------------    
    protected function ExportToCsv($page_size = 0){
        // we create the file first        
        @chmod($this->exportingDirectory, 0777);
        if($this->debug) $fe = fopen($this->exportingDirectory."export.csv", "w+");
        else $fe = @fopen($this->exportingDirectory."export.csv", "w+");
        if($fe){           
            $somecontent = "";
            if($this->layouts[$this->layoutType] == "0"){
                $type = "tabular";
            }else if($this->layouts[$this->layoutType] == "1"){
                $type = "columnar";
            }           
            if($type == "tabular"){
                // fields headers
                for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                    // get current column's index (offset)
                    $c = $this->sortedColumns[$c_sorted];
                    $field_name = $this->GetFieldName($c);
                    if($this->CanViewField($field_name)){
                        $somecontent .= ucfirst($this->GetHeaderName($field_name, true));
                        if($c_sorted < count($this->sortedColumns) - 1) $somecontent .= ",";                                   
                    }
                }
                $somecontent .= "\n";                                           
                // fields data
                for($r = $this->rowLower; (($r >=0 && $this->rowUpper >=0) && ($r < $this->rowUpper) && ($r < $page_size)); $r++){                  
                    $row = $this->dataSet->fetchRow();               
                    for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                        // get current column's index (offset)
                        $c = $this->sortedColumns[$c_sorted];
                        $field_name = $this->GetFieldName($c);
                        if($this->CanViewField($field_name)){
                            $somecontent .= str_replace(",", "", strip_tags($this->GetFieldValueByType($row[$c], $c, $row)));
                            if($c_sorted < count($this->sortedColumns) - 1) $somecontent .= ",";                       
                        }
                    }
                    $somecontent= str_replace("TRANSFER TO NOT SET", "FEES", $somecontent);
                    $somecontent .= "\n";               
                }
            }else{
                for($r = $this->rowLower; (($r >=0 && $this->rowUpper >=0) && ($r < $this->rowUpper) && ($r < $page_size)); $r++){                   
                    $row = $this->dataSet->fetchRow();               
                    for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                        // get current column's index (offset)
                        $c = $this->sortedColumns[$c_sorted];
                        $field_name = $this->GetFieldName($c);
                        if($this->CanViewField($field_name)){
                            $somecontent .= ucfirst($this->GetHeaderName($field_name, true));
                            $somecontent .= ",";
                            if($this->IsForeignKey($field_name)){
                                $somecontent .= str_replace(",", "", $this->GetForeignKeyInput($row[$this->GetFieldOffset($this->primaryKey)], $field_name, $row[$c], "view"));
                            }else{
                                $somecontent .= str_replace(",", "", strip_tags($this->GetFieldValueByType($row[$c], $c, $row)));
                            }
                            if($c_sorted < count($this->sortedColumns) - 1) $somecontent .= "\n";               
                        }
                        
                    }
                    $somecontent .= "\n";
                }    
            }
            // write some content to the opened file.
            if (fwrite($fe, $somecontent) == FALSE) {
                echo $this->lang['file_writing_error']." (export.csv)";
                exit;
            }                       
            @fclose($fe);
            @chmod($this->exportingDirectory, 0744);    
            echo $this->ExportDownloadFile("export.csv");
        }else{
            echo "<label class='".$this->cssClass."_dg_error_message no_print'>".$this->lang['file_opening_error'];
            if($this->debug) echo " <strong>".$this->exportingDirectory."export.xml</strong>";
            else echo "<br />".$this->lang['turn_on_debug_mode'];
            echo "</lable>";
            exit;
        }       
    }
    
    //---------------------------------------------------
    // Export to PDF (if you change export file name - change file name length in download.php)
    //---------------------------------------------------
    protected function ExportToPdf($page_size = 0) {
        // Let's make sure the we create the file first
      
        $newcontent = array();
        $somecontent = "";
        
        if($this->layouts[$this->layoutType] == "0"){
            $type = "tabular";
        }else if($this->layouts[$this->layoutType] == "1"){
            $type = "columnar";
        }else{
            $type = "tabular";
        }
        if($type == "tabular"){
            // fields headers
            for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                // get current column's index (offset)
                $c = $this->sortedColumns[$c_sorted];
                $field_name = $this->GetFieldName($c);
                if($this->CanViewField($field_name)){
                    $somecontent .= ucfirst($this->GetHeaderName($field_name, true));
                    if($c_sorted < count($this->sortedColumns) - 1) $somecontent .= "\t";                                    
                }
            }
            $newcontent[] = $somecontent;
            $somecontent = "";
            
            // fields data
            for($r = $this->rowLower; (($r >=0 && $this->rowUpper >=0) && ($r < $this->rowUpper) && ($r < $page_size)); $r++){                   
                $row = $this->dataSet->fetchRow();                
                for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                    // get current column's index (offset)
                    $c = $this->sortedColumns[$c_sorted];
                    $field_name = $this->GetFieldName($c);
                    if($this->CanViewField($field_name)){
                        if($this->IsForeignKey($field_name)){
                            $somecontent .= str_replace("\t", "", $this->GetForeignKeyInput($row[$this->GetFieldOffset($this->primaryKey)], $field_name, $row[$c], "view"));
                        }else{
                            $somecontent .= str_replace("\t", "", strip_tags($this->GetFieldValueByType($row[$c], $c, $row)));
                        }                        
                        if($c_sorted < count($this->sortedColumns) - 1) $somecontent .= "\t";                        
                    }
                }
                $somecontent .= "\n";
                $newcontent[] = $somecontent;
                $somecontent = "";            
            }            
        }else{
            // fields headers
            for($r = $this->rowLower; (($r >=0 && $this->rowUpper >=0) && ($r < $this->rowUpper) && ($r < $page_size)); $r++){                   
                $row = $this->dataSet->fetchRow();
                for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                    $somecontent = "";
                    // get current column's index (offset)
                    $c = $this->sortedColumns[$c_sorted];
                    $field_name = $this->GetFieldName($c);
                    if($this->CanViewField($field_name)){
                        $somecontent .= ucfirst($this->GetHeaderName($field_name, true));
                        $somecontent .= "\t";
                        if($this->IsForeignKey($field_name)){
                            $somecontent .= str_replace("\t", "", $this->GetForeignKeyInput($row[$this->GetFieldOffset($this->primaryKey)], $field_name, $row[$c], "view"));
                        }else{
                            $somecontent .= str_replace("\t", "", strip_tags($this->GetFieldValueByType($row[$c], $c, $row)));
                        }
                    }
                    $newcontent[] = $somecontent;    
                }            
                $somecontent = "";
            }
        }            
		
        // write some content to the opened file.
        define('FPDF_FONTPATH', $this->directory.'modules/fpdf/font/');
        include_once($this->directory.'modules/fpdf/fpdf.php');
        $pdf=new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B', 9);
            
        for($i=0;$i<count($newcontent);$i++) {        
            $pdf->Text(10,($i*10)+10,$newcontent[$i]);
        }

        $output_path = ($this->exportingDirectory != "") ? $this->exportingDirectory : $this->directory;
        $pdf->Output($output_path."export.pdf", "", $this->debug);
        
        echo $this->ExportDownloadFile("export.pdf");
    }

    //--------------------------------------------------------------------------
    // Export to XML (if you change export file name - change file name length in download.php)
    //--------------------------------------------------------------------------    
    protected function ExportToXml($page_size = 0){
        // Let's make sure the we create the file first
        @chmod($this->exportingDirectory, 0777);
        if($this->debug) $fe = fopen($this->exportingDirectory."export.xml", "w+");
        else $fe = @fopen($this->exportingDirectory."export.xml", "w+");        
        if($fe){
            $somecontent = "<?xml version='1.0' encoding='UTF-8' ?>";                    
            // fields data
            $somecontent .= "<page>";            
            for($r = $this->rowLower; (($r >=0 && $this->rowUpper >=0) && ($r < $this->rowUpper) && ($r < $page_size)); $r++){                   
                $row = $this->dataSet->fetchRow();               
                $somecontent .= "<row".$r.">";
                for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                    // get current column's index (offset)
                    $c = $this->sortedColumns[$c_sorted];
                    $field_name = $this->GetFieldName($c);
                    if($this->CanViewField($field_name)){
                        $header_name = $field_name;
                        $somecontent .= "<".$header_name.">";
                        if($this->IsForeignKey($field_name)){
                            $somecontent .= str_replace(",", "", $this->GetForeignKeyInput($row[$this->GetFieldOffset($this->primaryKey)], $field_name, $row[$c], "view"));
                        }else{
                            $somecontent .= str_replace(",", "", strip_tags($this->GetFieldValueByType($row[$c], $c, $row)));
                        }
                        $somecontent .= "</".$header_name.">";
                    }
                }
                $somecontent .= "</row".$r.">";
            }
            $somecontent .= "</page>";                        
        
            // write somecontent to the opened file.
            if (fwrite($fe, $somecontent) == FALSE) {
                echo $this->lang['file_writing_error']." (export.xml)";
                exit;
            }                        
            @fclose($fe);
            @chmod($this->exportingDirectory, 0744);
            echo $this->ExportDownloadFile("export.xml");
        }else{
            echo "<label class='".$this->cssClass."_dg_error_message no_print'>".$this->lang['file_opening_error'];
            if($this->debug) echo " <strong>".$this->exportingDirectory."export.xml</strong>";
            else echo "<br />".$this->lang['turn_on_debug_mode'];
            echo "</lable>";
            exit;
        }
    }

    //--------------------------------------------------------------------------
    // Draw filtering
    //--------------------------------------------------------------------------
    protected function DrawFiltering(){
        $selSearchType = $this->GetVariable("_ff_selSearchType");
        $req_onSUBMIT_FILTER = $this->GetVariable('_ff_onSUBMIT_FILTER');        
        $cols = 0;
        
        if($this->filteringAllowed){
            $horizontal_align = ($this->tblAlign[$this->mode] == "center") ? "margin-left:auto; margin-right:auto;" : "";
            if($this->layouts['filter'] == "2"){
                $searchset_width = "99%";
            }else{
                $searchset_width = ($this->browserName == "Firefox") ? "99%" : "100%";    
            }
            echo "<table id='".$this->uniquePrefix."searchset' style='".$horizontal_align." ".$this->hideDisplay."' width='".$searchset_width."'><tr><td style='text-align: center;'>\n";
            if(!$this->isPrinting){
                if($this->layouts['filter'] == "2"){
                    echo "<div class='".$this->cssClass."_dg_fieldset' style='".$horizontal_align." width: ".$this->tblWidth['view']."; padding:3px 5px 3px 5px;'>\n";                    
                }else{
                    echo "<fieldset class='".$this->cssClass."_dg_fieldset' dir='".$this->direction."' style='".$horizontal_align." width: ".$this->tblWidth['view'].";'>\n";
                    echo "<legend class='".$this->cssClass."_dg_legend'>".$this->lang['search_d']."</legend>\n";
                }
            }
            $internal_form_margin = ($this->layouts['filter'] == "2") ? "margin:0px; padding:0px;" : "margin:10px;"; 
            $internal_table_width = ($this->layouts['filter'] == "2") ? "100%" : $this->tblWidth[$this->mode];

            echo "<form name='frmFiltering".$this->uniquePrefix."' id='frmFiltering".$this->uniquePrefix."' action='' method='GET' style='".$internal_form_margin."'>\n";
            $this->SaveHttpGetVars();
            echo "<table dir='".$this->direction."' class='".$this->cssClass."_dg_filter_table' border='0' id='filterTbl".$this->uniquePrefix."' style='margin-left:auto; margin-right:auto;' width='".$internal_table_width."' cellspacing='1' cellpadding='1'>\n";
            if($this->layouts['filter'] == "0" || $this->layouts['filter'] == "2") echo "<tr>\n";
            
            foreach($this->arrFilterFields as $fldName => $fldValue){
                
                $fp_on_js_event     = $this->GetFieldProperty($fldName, "on_js_event", "filter", "normal");
                $fp_calendar_type   = $this->GetFieldProperty($fldName, "calendar_type", "filter", "normal");
                $fp_width           = $this->GetFieldProperty($fldName, "width", "filter", "normal");
                $fp_autocomplete    = $this->GetFieldProperty($fldName, "autocomplete", "filter", "normal");
                $fp_handler         = $this->GetFieldProperty($fldName, "handler", "filter", "normal");
                $fp_maxresults      = $this->GetFieldProperty($fldName, "maxresults", "filter", "normal");
                $fp_shownoresults   = $this->GetFieldProperty($fldName, "shownoresults", "filter", "normal");
                $fp_multiple        = $this->GetFieldProperty($fldName, "multiple", "filter", "normal");
                $fp_multiple_size   = $this->GetFieldProperty($fldName, "multiple_size", "filter", "normal", "4");
                
                $multiple_parameters = ($fp_multiple) ? $multiple_parameters = "multiple size='".$fp_multiple_size."'" : "";
                if($fp_shownoresults == "") $fp_shownoresults = "false";
                $field_width = ($fp_width != "") ? "width: ".$fp_width.";" : "";                
                // get extension for from/to fields                    
                $fp_field_type = $this->GetFieldProperty($fldName, "field_type", "filter", "normal");
                if($fp_field_type != "") $fp_field_type = "_fo_".$fp_field_type;                    
                
                if($this->layouts['filter'] == "1") echo "<tr valign='middle'>\n";
                $fldValue_fields = explode(",", $fldValue['field']);
                // table-filed name with fixed "dot" issue
                $table_field_name = str_replace(".", "_d_", $fldValue['table'])."_".$fldValue_fields[0];

                // full name of field in URL    
                $field_name_in_url = $this->uniquePrefix."_ff_".$table_field_name.$fp_field_type;

                if(isset($_REQUEST[$field_name_in_url]) AND ($_REQUEST[$field_name_in_url] != "")){
                    if(!is_array($_REQUEST[$field_name_in_url])) $filter_field_value = stripcslashes($_REQUEST[$field_name_in_url]);
                    else $filter_field_value = $_REQUEST[$field_name_in_url];
                }else{
                    $filter_field_value = "";  
                }
                $filter_field_value_html = str_replace('"', "&#034;", $filter_field_value); // double quotation mark
                $filter_field_value_html = str_replace("'", "&#039;", $filter_field_value_html); // single quotation mark                        
                $filter_field_operator =  $table_field_name."_operator";                

                // full opearator of field in URL    
                $operator_name_in_url = $this->uniquePrefix."_ff_".$filter_field_operator.$fp_field_type;                

                echo "<td ";                
                if($this->layouts['filter'] == "1"){
                    echo "align='".(($this->direction == "rtl") ? "left" : "right")."' style='width:50%;'>".$fldName."";
                    echo "</td><td>".$this->nbsp."</td><td>";
                    $cols +=3;
                }else if($this->layouts['filter'] == "0" || $this->layouts['filter'] == "2"){
                    if($this->tabularColumns != ""){
                        if($this->layouts['filter'] == "0"){
                            echo "align='".(($this->direction == "rtl") ? "right" : "left")."'";
                        }else echo "align='".(($this->direction == "rtl") ? "left" : "right")."'";
                    }else if($this->layouts['filter'] == "2"){
                        echo "align='".(($this->direction == "rtl") ? "right" : "left")."' style='padding-left:2px; padding-right:3px;'";
                        echo " nowrap='nowrap'";
                    }else{
                        echo "align='center'";
                    }
                    echo "> ".$fldName.": ";
                    $cols +=1;
                }else {
                    echo "align='".(($this->direction == "rtl") ? "left" : "right")."' style='width:50%;'>".$fldName."";
                    echo "</td>\n";
                    echo "<td>".$this->nbsp."</td>\n";
                    echo "<td>";
                    $cols +=2;
                }                
                if(isset($fldValue['show_operator']) && $fldValue['show_operator'] != false && $fldValue['show_operator'] != "false"){
                    if(!$this->isPrinting){
                        if(isset($_REQUEST[$operator_name_in_url]) && $_REQUEST[$operator_name_in_url] != ""){
                            $filter_operator = $_REQUEST[$operator_name_in_url];                            
                        }else if(isset($fldValue['default_operator']) && $fldValue['default_operator'] != ""){
                            $filter_operator = $fldValue['default_operator'];                            
                        }else{
                            $filter_operator = "=";
                        }
                        echo "<select class='".$this->cssClass."_dg_select' name='".$this->uniquePrefix."_ff_".$filter_field_operator."' id='".$this->uniquePrefix."_ff_".$filter_field_operator."'>";
                        echo "<option value='='"; echo ($filter_operator == "=")? " selected='selected'" : ""; echo ">".$this->lang['=']."</option>";
                        echo "<option value='&gt;'"; echo ($filter_operator == ">")? " selected='selected'" : ""; echo ">".$this->lang['>']."</option>";
                        echo "<option value='&lt;'"; echo ($filter_operator == "<")? " selected='selected'" : ""; echo ">".$this->lang['<']."</option>";                        
                        echo "<option value='like'"; echo ($filter_operator == "like")? " selected='selected'" : ""; echo ">".$this->lang['like']."</option>";
                        echo "<option value='".urlencode("like%")."'"; echo (urldecode($filter_operator) == "like%")? " selected='selected'" : ""; echo ">".$this->lang['like%']."</option>";
                        echo "<option value='".urlencode("%like")."'"; echo (urldecode($filter_operator) == "%like")? " selected='selected'" : ""; echo ">".$this->lang['%like']."</option>";
                        echo "<option value='".urlencode("%like%")."'"; echo (urldecode($filter_operator) == "%like%")? " selected='selected'" : ""; echo ">".$this->lang['%like%']."</option>";
                        echo "<option value='not like'"; echo ($filter_operator == "not like")? " selected='selected'" : ""; echo ">".$this->lang['not_like']."</option>";
                        echo "</select>";
                    }else{
                        echo (isset($_REQUEST[$operator_name_in_url])) ? "[".$_REQUEST[$operator_name_in_url]."]" : "";                        
                    }
                }else{
                    // set default operator
                    if(isset($fldValue['default_operator']) && $fldValue['default_operator'] != ""){
                        $filter_operator = urlencode($fldValue['default_operator']);
                    }else{
                        $filter_operator = "=";
                    }
                    echo "<input type='hidden' name='".$this->uniquePrefix."_ff_".$filter_field_operator.$fp_field_type."' id='".$this->uniquePrefix."_ff_".$filter_field_operator.$fp_field_type."' value='".$filter_operator."' />";                    
                }
                if($this->layouts['filter'] == "1"){
                    echo "</td>\n<td>".$this->nbsp."</td>\n";                    
                    echo "<td style='width:50%;' align='"; echo ($this->direction == "rtl")?"right":"left"; echo "'>";
                    $cols +=2;
                }else if($this->layouts['filter'] == "0"){
                    echo "<br />";
                }else if($this->layouts['filter'] == "2"){
                    // nothing 
                }else {
                    echo "</td>\n<td>".$this->nbsp."</td>\n";
                    echo "<td style='width:50%;' align='"; echo ($this->direction == "rtl")?"right":"left"; echo "'>";
                    $cols +=2;
                }
                $filter_field_type = (isset($fldValue['type'])) ? $fldValue['type'] : "" ;
                if(!$this->isPrinting){
                    // table-filed name with fixed "dot" issue
                    $table_field_name = str_replace(".", "_d_", $fldValue['table']);
                    switch($filter_field_type){
                        case "textbox":
                            $fldValue_fields = str_replace(" ", "", $fldValue['field']);
                            $fldValue_fields = explode(",", $fldValue_fields);
                            $count = 0;
                            $onchange_filter_field = "";
                            foreach($fldValue_fields as $fldValue_field){
                                if($count++ > 0){ $onchange_filter_field .= "document.getElementById(\"".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field."\").value="; }
                            }
                            $count = 0;
                            foreach($fldValue_fields as $fldValue_field){
                                if($count++ == 0){
                                    echo "<input class='".$this->cssClass."_dg_textbox' style='".$field_width."' type='text' value='".$filter_field_value_html."' name='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field.$fp_field_type."' id='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field.$fp_field_type."' onchange='".$onchange_filter_field."this.value;' ".$fp_on_js_event." />";
                                    if(($fp_autocomplete == "true") || ($fp_autocomplete === true)){
                                        echo $this->ScriptOpen("\n");
                                        echo "var options = {";
                                        echo "   script:'".$this->directory.$fp_handler."?json=true&limit=".intval($fp_maxresults)."&',";
                                        echo "   varname: 'input',";
                                        echo "   json: true,";                                        
                                        echo "   shownoresults: ".$fp_shownoresults.",";
                                        echo "   maxresults: ".intval($fp_maxresults);
                                        //callback: function (obj) { document.getElementById('testid').value = obj.id; }
                                        echo "};";
                                        echo "var as_json = new bsn.AutoSuggest('".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field."', options);";
                                        echo $this->ScriptClose();
                                    }
                                }else{
                                    $filter_field_operator =  $table_field_name."_".$fldValue_field."_operator";
                                    echo "<input type='hidden' name='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field."' id='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field."' value='".$filter_field_value_html."' />";                                    
                                    echo "<input type='hidden' name='".$this->uniquePrefix."_ff_".$filter_field_operator.$fp_field_type."' id='".$this->uniquePrefix."_ff_".$filter_field_operator.$fp_field_type."' value='".$filter_operator."' />";
                                }
                            }                        
                            break;
                        case "dropdownlist":
                            $field_ddl_name = $this->uniquePrefix."_ff_".$table_field_name."_".$fldValue['field'];
                            $field_ddl_name .= ($fp_multiple) ? "[]" : "";
                            echo " <select class='".$this->cssClass."_dg_select' style='".$field_width."' name='".$field_ddl_name.$fp_field_type."' id='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue['field'].$fp_field_type."' ".$fp_on_js_event." ".$multiple_parameters.">";
                            if(!$fp_multiple) echo "<option value=''>-- ".$this->lang['any']." --</option>";
                            if(is_array($fldValue['source'])){
                                foreach($fldValue['source'] as $val => $opt){
                                    echo "<option value=\"".$val."\" ";
                                    if($filter_field_value != ""){
                                        if($filter_field_value == $val) echo "selected='selected'";
                                    }else if($this->defFilterField != "" && $fldName == $this->defFilterField){
                                        if($val == $this->defFilterFieldValue) echo "selected='selected'";
                                    }
                                    echo ">".$opt."</option>";
                                }
                            }else{
                                if(isset($fldValue['condition']) && trim($fldValue['condition']) !== "") {
                                    $where = $fldValue['condition'];        
                                }else{
                                    $where = " 1=1 ";
                                }
                                $fp_field_view = $this->GetFieldProperty($fldName, "field_view", "filter", "normal");
                                $fp_show_count = $this->GetFieldProperty($fldName, "show_count", "filter", "normal");
                                if($fp_field_view !== ""){
                                    if($fp_show_count == "true" || $fp_show_count === true){
                                        $sql = "SELECT ".$fldValue['field'].", ".$fp_field_view.", COUNT(".$fldValue['field'].") as cnt FROM ".$fldValue['table']." WHERE ".$where." GROUP BY ".$fldValue['field']." ORDER BY ".$fldValue['field']." ".((Helper::ConvertCase((isset($fldValue['order']) ? $fldValue['order'] : ""),"lower",$this->langName) == "desc")?"DESC":"ASC")." ";                                        
                                    }else{
                                        $sql = "SELECT DISTINCT ".$fldValue['field'].", ".$fp_field_view." FROM ".$fldValue['table']." WHERE ".$where." ORDER BY ".$fldValue['field']." ".((Helper::ConvertCase((isset($fldValue['order']) ? $fldValue['order'] : ""),"lower",$this->langName) == "desc")?"DESC":"ASC")." ";
                                    }
                                    $this->dbHandler->setFetchMode(DB_FETCHMODE_ASSOC);
                                    $dSet = $this->dbHandler->query($sql);
                                    if($this->dbHandler->isError($dSet) == 1){
                                        $this->isError = true;
                                        $this->AddErrors($dSet);
                                    }else{
                                        while($row = $dSet->fetchRow()){
                                            $selected = "";
                                            $ff_name = $fp_field_view;
                                            if (preg_match("/ as /i", strtolower($ff_name))) $ff_name = substr($ff_name, strpos(strtolower($ff_name), " as ")+4);
                                            if((is_array($filter_field_value) && in_array($row[$fldValue['field']], $filter_field_value)) ||
                                              (!is_array($filter_field_value) && ($row[$fldValue['field']] === $filter_field_value))){
                                                if($filter_field_value != "") $selected = " selected='selected'";                                                    
                                            }else if($this->defFilterField != "" && $fldName == $this->defFilterField){
                                                if($this->defFilterFieldValue == $row[$fldValue['field']]) $selected = " selected='selected'";
                                            }
                                            if($fp_show_count == "true" || $fp_show_count === true){
                                                $option_text = $row[$ff_name]." (".$row['cnt'].")";
                                            }else{
                                                $option_text = $row[$ff_name];
                                            }                                            
                                            echo "<option".$selected." value=\"".$row[$fldValue['field']]."\">".$option_text."</option>";
                                        }                                        
                                    }
                                }else{
                                    if($fp_show_count == "true" || $fp_show_count === true){
                                        $sql = "SELECT ".$fldValue['field'].", COUNT(".$fldValue['field'].") as cnt FROM ".$fldValue['table']." WHERE ".$where." GROUP BY ".$fldValue['field']." ORDER BY ".$fldValue['field']." ".((Helper::ConvertCase((isset($fldValue['order']) ? $fldValue['order'] : ""),"lower",$this->langName) == "desc")?"DESC":"ASC")." ";
                                    }else{
                                        $sql = "SELECT DISTINCT ".$fldValue['field']." FROM ".$fldValue['table']." WHERE ".$where." ORDER BY ".$fldValue['field']." ".((Helper::ConvertCase((isset($fldValue['order']) ? $fldValue['order'] : ""),"lower",$this->langName) == "desc")?"DESC":"ASC")." ";
                                    }
                                    $this->dbHandler->setFetchMode(DB_FETCHMODE_ASSOC); 
                                    $dSet = $this->dbHandler->query($sql);
                                    if($this->dbHandler->isError($dSet) == 1){
                                        $this->isError = true;
                                        $this->AddErrors($dSet);
                                    }else{
                                        while($row = $dSet->fetchRow()){
                                            $selected = "";
                                            if((is_array($filter_field_value) && in_array($row[$fldValue['field']], $filter_field_value)) ||
                                              (!is_array($filter_field_value) && ($row[$fldValue['field']] === $filter_field_value))){
                                                if($filter_field_value != "") $selected = " selected='selected'";
                                            }else if($this->defFilterField != "" && $fldName == $this->defFilterField){
                                                if($this->defFilterFieldValue == $row[$fldValue['field']]) $selected = " selected='selected'";
                                            }
                                            if($fp_show_count == "true" || $fp_show_count === true){
                                                $option_text = $row[$fldValue['field']]." (".$row['cnt'].")";
                                            }else{
                                                $option_text = $row[$fldValue['field']];
                                            }                                            
                                            echo "<option".$selected." value=\"".$row[$fldValue['field']]."\">".$option_text."</option>";
                                        }                                        
                                    }
                                }
                            }   
                            echo "</select>";
                            break;
                        case "calendar":
                            $fldValue_fields = str_replace(" ", "", $fldValue['field']);
                            $fldValue_fields = explode(",", $fldValue_fields);
                            // get date format
                            $date_format = isset($fldValue['date_format']) ? $fldValue['date_format'] : "";
                            if($date_format != "date" && $date_format != "datedmy" && $date_format != "datetime" && $date_format != "time") $date_format = "date"; 
                            $onchange_filter_field = "";
                            
                            $count = 0;                            
                            foreach($fldValue_fields as $fldValue_field){
                                if($count++ > 0){ $onchange_filter_field .= "document.getElementById(\"".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field."\").value="; }
                            }
                            $count = 0;
                            foreach($fldValue_fields as $fldValue_field){
                                if($count++ == 0){
                                    echo "<input class='".$this->cssClass."_dg_textbox' style='".$field_width."' type='text' value='".$filter_field_value."' name='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field.$fp_field_type."' id='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field.$fp_field_type."' onchange='".$onchange_filter_field."this.value;' ".$fp_on_js_event." />";
                                }else{
                                    $filter_field_operator = $table_field_name."_".$fldValue_field."_operator";
                                    echo "<input type='hidden' name='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field."' id='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field."' value='".$filter_field_value."' />";                                    
                                    echo "<input type='hidden' name='".$this->uniquePrefix."_ff_".$filter_field_operator.$fp_field_type."' id='".$this->uniquePrefix."_ff_".$filter_field_operator.$fp_field_type."' value='".$filter_operator."' />";
                                }
                            }
                            if($fp_calendar_type == "floating"){                                
                                $if_format = $this->GetDateFormatForFloatingCal($date_format);
                                $show_time = ($date_format == "datetime" || $date_format == "time") ? "true" : "false";
                                $textbox_id = $this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field.$fp_field_type;                                
                                $this->jsCode .= "Calendar.setup({firstDay : ".$this->weekStartingtDay.", inputField : '".$textbox_id."', ifFormat : '".$if_format."', showsTime : ".$show_time.", button : 'img_".$textbox_id."'});\n";
                                echo "<img id='img_".$textbox_id."' src='".$this->directory."styles/".$this->cssClass."/images/cal.gif' alt='".$this->lang['set_date']."' title='".$this->lang['set_date']."' align='top' style='cursor:pointer;margin:3px;margin-left:6px;margin-right:6px;border:0px;' ";
                                if($this->ajaxEnabled) echo "onmouseover='javascript:".$this->uniquePrefix."_doOpenFloatingCalendar(\"".$textbox_id."\", \"".$if_format."\", ".$show_time.");'";
                                echo " />\n";                                
                            }else{
                                echo "<a class='".$this->cssClass."_dg_a2' title='' href=\"javascript:openCalendar('".(($this->ignoreBaseTag) ? $this->HTTP_HOST."/" : "").$this->directory."','','frmFiltering".$this->uniquePrefix."','','".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue_field.$fp_field_type."','".$date_format."')\"><img src='".$this->directory."styles/".$this->cssClass."/images/cal.gif' alt='".$this->lang['set_date']."' title='".$this->lang['set_date']."' align='top' style='border:0px; MARGIN:3px;margin-left:6px;margin-right:6px;' /></a>".$this->nbsp;
                            }
                            break;
                        default:
                            echo "<input class='".$this->cssClass."_dg_textbox' type='text' value='".$filter_field_value_html."' name='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue['field']."' id='".$this->uniquePrefix."_ff_".$table_field_name."_".$fldValue['field']."' />";                                        
                            break;                                       
                    }                                    
                }else{
                    echo $filter_field_value;                    
                }
                echo "</td>\n";
                if($this->layouts['filter'] == "1") echo "</tr>\n";
                else if(($this->layouts['filter'] == "0" || $this->layouts['filter'] == "2") && $this->tabularColumns != "" && $this->tabularColumns > 0){
                    if ($cols % $this->tabularColumns == 0) echo "</tr><tr>\n";
                }
            }
            if($this->layouts['filter'] == "2") $cols++; 
            if($this->layouts['filter'] == "0") echo "</tr>\n";
            if($this->layouts['filter'] != "2") echo "<tr><td ".(($cols > 0) ? "colspan='".$cols."'" : "")." style='height:6px;' align='center'></td></tr>\n";
            if($this->layouts['filter'] != "2") echo "<tr>";
            echo "<td ".(($this->layouts['filter'] != "2" && $cols > 0) ? "colspan='".$cols."'" : "")." align='".(($this->layouts['filter'] == "2") ? (($this->direction == "rtl") ? "left" : "right") : "center")."' ".(($this->layouts['filter'] == "2") ? "width='55%'" : "").">";
            if(count($this->arrFilterFields) > 1){
                if($this->showSearchType){ echo $this->lang['search_type'].": "; }
                if(!$this->isPrinting){
                    if($this->showSearchType){
                        echo "<select class='".$this->cssClass."_dg_select' name='".$this->uniquePrefix."_ff_"."selSearchType' id='".$this->uniquePrefix."_ff_"."selSearchType'>";
                        echo "<option value='0' "; echo (($selSearchType != "") && ($selSearchType == 0)) ? "selected='selected'" : ""; echo ">".$this->lang['and']."</option>";
                        echo "<option value='1' "; echo ($selSearchType == 1) ? "selected='selected'" : ""; echo ">".$this->lang['or']."</option>";            
                        echo "</select>";                        
                    }else{
                        echo "<input type='hidden' name='".$this->uniquePrefix."_ff_"."selSearchType' id='".$this->uniquePrefix."_ff_"."selSearchType' value='0' />";
                    }                    
                }else{
                    if(($selSearchType != "") && ($selSearchType == 0)){
                        echo "[and]";
                    }else if($selSearchType == 1){
                        echo "[or]"; 
                    }else {
                        echo "[none]";
                    }
                }
            }
            if(!$this->isPrinting){
                if($req_onSUBMIT_FILTER != ""){
                    echo " <input class='".$this->cssClass."_dg_button' type='button' value='".$this->lang['reset']."' onClick='javascript:".$this->uniquePrefix."_doPostBack(\"reset\");' /> ";
                }
                echo " <input class='".$this->cssClass."_dg_button' style='margin-left:5px;margin-right:5px;' type='submit' name='".$this->uniquePrefix."_ff_"."onSUBMIT_FILTER' id='".$this->uniquePrefix."_ff_"."onSUBMIT_FILTER' value='".$this->lang['search']."' /> ";
            }
            echo "</td>\n</tr>\n";
            if($this->layouts['filter'] != "2") echo "<tr><td ".(($cols > 0) ? "colspan='".$cols."'" : "")." style='height:5px;' align='center'></td></tr>\n";
            $this->TblClose();  
            echo "</form>\n";
            if(!$this->isPrinting){
                if($this->layouts['filter'] == "2"){
                    echo "</div>\n";    
                }else{
                    echo "</fieldset>\n";    
                }                
            }
            echo "</td></tr></table>\n";
        }               
    }
    
    
    public function SetDefaultFiltering($default_field, $default_field_value, $where_clause){
        $this->defFilterField = $default_field;
        $this->defFilterFieldValue = $default_field_value;
        $this->defFilterFieldWhere = $where_clause;
    }
    

    //--------------------------------------------------------------------------
    // Draw customized layout  - last modifyed 03.07.09
    //--------------------------------------------------------------------------
    protected function DrawCustomized(){
        $req_mode = $this->GetVariable('mode');
        $r        = "-1";  
       
        $this->ExportTo();
        $this->ShowCaption($this->caption);
        $this->DrawControlPanel();        
        
        if(($this->mode != "edit") && ($this->mode != "details")) $this->DrawFiltering();   
        if(($req_mode !== "add") || ($req_mode == "")) $this->PagingFirstPart();  
        $this->DisplayMessages();
        if($this->pagingAllowed) $this->PagingSecondPart($this->arrUpperPaging, false, true, "Upper");
        if($this->rowLower == $this->rowUpper) echo "<br />";        

        if($this->isLoadingImageEnabled && !$this->ajaxEnabled) echo "<div id='".$this->uniqueRandomPrefix."loading_image'><br /><table style='margin-left: auto; margin-right: auto;'><tr><td valign='middle'>".$this->lang['loading_data']."</td><td valign='middle'><img src='".$this->directory."images/loading.gif' alt='".$this->lang['loading_data']."'></table></div>\n";                
        // draw hide DG open div 
        $this->HideDivOpen();
        $this->DrawControlButtonsJS();

        if(isset($this->templates[$this->layoutType]['header'])){
            // Add button
            $mode_button = $this->DrawModeButton("add", "javascript:".$this->uniquePrefix."_doPostBack(\"add\",".$this->EncodeParameter('-1').");", $this->lang['add_new'], $this->lang['add_new_record'], "add.gif", "''", false, "", "", true);                        
            $template_header = str_replace("[ADD]", $mode_button, $this->templates[$this->layoutType]['header']);            

            // draw sortable headers
            if($this->sortingAllowed){
                $req_sort_field = $this->GetVariable('sort_field');
                $sort_type      = $this->GetVariable('sort_type');
                $page_size      = $this->GetVariable('page_size');
                for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                    $c = $this->sortedColumns[$c_sorted];
                    $c_field_name = $this->GetFieldName($c);
                    if($req_sort_field && ($c == ($req_sort_field -1))){
                        if($sort_type == "desc") $sort_type = "asc";
                        else $sort_type = "desc";
                    }                    
                    $href_string = $this->amp.$this->uniquePrefix."sort_field=".($c+1).$this->amp.$this->uniquePrefix."sort_type=".$sort_type.$this->amp.$this->uniquePrefix."page_size=".$page_size;
                    $href_string = "javascript:".$this->uniquePrefix."_doPostBack(\"sort\",\"\",\"".$href_string."\");";
                    $fp_header_tooltip = $this->GetFieldProperty($c_field_name, "header_tooltip", "view");
                    $field_titile_tooltip = $this->lang['sort'];                    
                    $header_link = "<a class='".$this->cssClass."_dg_a_header' href='".$href_string."' title='".$field_titile_tooltip."' ><b>".ucfirst($this->GetHeaderName($c_field_name))."</b>";
                    if($fp_header_tooltip != ""){
                        $fp_header_tooltip = str_replace("'", "&#039;", $fp_header_tooltip); // single quotation mark
                        $header_link .= " <img src='".$this->directory."images/question_mark.gif' style='vertical-align:middle;' border='0' alt='' title='".$fp_header_tooltip."' />";
                    }                    
                    $header_link .= "</a>";
                    
                    $template_header = str_replace("@".$c_field_name."@", $header_link, $template_header);                
                }                            
            }
            echo $template_header;
        }
        
        if($req_mode == "add" || $req_mode == "edit"){
            $this->SetEditFieldsFormScript();
            //prepare action url for the form
            $combine_url_rid = ($this->multiRows > 1) ? $this->rid : $this->EncodeParameter($this->rid, false);
            $curr_url = $this->CombineUrl("update", $combine_url_rid, $this->amp); 
            $this->SetUrlString($c_curr_url, "filtering", "sorting", "paging", $this->amp);
            $curr_url .= $c_curr_url;
            if($req_mode === "add") {
                $curr_url .= $this->amp.$this->uniquePrefix."new=1";
            }                                
            echo "<form name='".$this->uniquePrefix."frmEditRow' id='".$this->uniquePrefix."frmEditRow' method='post' action='".$curr_url."'>".chr(13);
            echo "<input type='hidden' name='".$this->uniquePrefix."_operation_randomize_code' value='".$this->GetRandomString(20)."' />".chr(13);            
        }
        
        if($req_mode == "add"){            
            
            if(isset($this->templates[$this->layoutType]['body'])) $template = $this->templates[$this->layoutType]['body'];
            else $template = $this->templates[$this->layoutType];
            foreach($this->columnsEditMode as $key => $val){
                if($this->IsForeignKey($key)){
                    $template = str_replace("{".$key."}", $this->GetForeignKeyInput(-1, $key, '-1', "edit"), $template);
                }else{
                    $template = str_replace("{".$key."}", $this->GetFieldValueByType('', 0, '', $key), $template);
                }                                
            }            
            // Add button
            $mode_button = $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."sendEditFields();", $this->lang['create'], $this->lang['create_new_record'], "update.gif", "''", false, $this->nbsp, "", true);
            $template = str_replace("[CREATE]", $mode_button, $template);

            $param = $this->amp.$this->uniquePrefix."new=1";
            if(isset($this->modes['cancel'][$this->mode]) && $this->modes['cancel'][$this->mode]){            
                $mode_button = $this->DrawModeButton("cancel", "javascript:".$this->uniquePrefix."verifyCancel(\"-1\", \"".$param."\")", "".$this->lang['cancel'], $this->lang['cancel'], "cancel.gif", "''", false, $this->nbsp, "", true);
            }else $mode_button = "";
            $template = str_replace("[CANCEL]", $mode_button, $template);
            
            $template = str_replace("[UPDATE]", "", $template);
            
            echo $template;
        }else{
            
            for($r = $this->rowLower; (($r >=0 && $this->rowUpper >=0) && ($r < $this->rowUpper) && ($r < ($this->rowLower + $this->reqPageSize))); $r++){                

                // draw column data
                $row = $this->dataSet->fetchRow();                
                
                if(isset($this->templates[$this->layoutType]['body'])) $template = $this->templates[$this->layoutType]['body'];
                else $template = $this->templates[$this->layoutType];
                
                $ind = ($this->GetFieldOffset($this->primaryKey) != -1) ? $this->GetFieldOffset($this->primaryKey) : 0;                
    
                // Multi-row row checkboxes
                if($this->isMultirowAllowed){
                    $disable = $this->isPrinting ? "disabled" : "";
                    $checkbox_value = ($row[$this->GetFieldOffset($this->primaryKey)] != -1) ? $row[$this->GetFieldOffset($this->primaryKey)] : "0";
                    $miltirow_checkbox = "<input onclick=\"onMouseClickRow('".$this->uniquePrefix."','".$r."', '".$this->rowColor[5]."', '".$this->rowColor[1]."', '".$this->rowColor[0]."')\" type='checkbox' name='".$this->uniquePrefix."checkbox_".$r."' id='".$this->uniquePrefix."checkbox_".$r."' value='";
                    #$miltirow_checkbox = "<input onclick='isChecked(this.checked);' type='checkbox' name='".$this->uniquePrefix."checkbox_".$r."' id='".$this->uniquePrefix."checkbox_".$r."' value='";
                    $miltirow_checkbox .= $this->EncodeParameter($checkbox_value, false);
                    $miltirow_checkbox .= "' ".$disable." />";
                    $template = str_replace("[MILTIROW_CHECKBOX]", $miltirow_checkbox, $template);
                }                
    
                // Add button
                $mode_button = $this->DrawModeButton("add", "javascript:".$this->uniquePrefix."_doPostBack(\"add\",".$this->EncodeParameter('-1').");", $this->lang['add_new'], $this->lang['add_new_record'], "add.gif", "''", false, "", "", true);                        
                $template = str_replace("[ADD]", $mode_button, $template);
                
                // Edit button            
                $mode_button = $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."_doPostBack(\"edit\",".$this->EncodeParameter($row[$ind]).");", $this->lang['edit'], $this->lang['edit_record'], "edit.gif", "''", false, $this->nbsp, "", true);
                $template = str_replace("[EDIT]", $mode_button, $template);
                
                // Details button            
                $mode_button = $this->DrawModeButton("details", "javascript:".$this->uniquePrefix."_doPostBack(\"details\",".$this->EncodeParameter($row[$ind]).");", $this->lang['details'], $this->lang['view_details'], "details.gif", "''", false, $this->nbsp, "", true);                        
                $template = str_replace("[DETAILS]", $mode_button, $template);
                
                // Back button            
                $mode_button = $this->DrawModeButton("cancel", "javascript:".$this->uniquePrefix."_doPostBack(\"cancel\",".$this->EncodeParameter($row[$this->GetFieldOffset($this->primaryKey)]).");", $this->lang['back'], $this->lang['back'], "cancel.gif", "''", false, $this->nbsp, "", true);
                $template = str_replace("[BACK]", $mode_button, $template);
    
                // Delete button
                $mode_button = $this->DrawModeButton("delete", "javascript:".$this->uniquePrefix."verifyDelete(".$this->EncodeParameter($row[$ind]).");", $this->lang['delete'], $this->lang['delete_record'], "delete.gif", "''", false, "", "", true);                        
                $template = str_replace("[DELETE]", $mode_button, $template);

                // Cancel button            
                if(isset($this->modes['cancel'][$this->mode]) && $this->modes['cancel'][$this->mode]){
                    $mode_button = $this->DrawModeButton("cancel", "javascript:".$this->uniquePrefix."_doPostBack(\"cancel\",".$this->EncodeParameter($row[$this->GetFieldOffset($this->primaryKey)]).");", $this->lang['cancel'], $this->lang['cancel'], "cancel.gif", "''", false, $this->nbsp, "", true);
                }else $mode_button = "";
                $template = str_replace("[CANCEL]", $mode_button, $template);

                // Update button            
                $mode_button = $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."sendEditFields();", $this->lang['update'], $this->lang['update_record'], "update.gif", "''", false, $this->nbsp, "", true);
                $template = str_replace("[UPDATE]", $mode_button, $template);
                
                for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                    // get current column's index (offset)
                    $c = $this->sortedColumns[$c_sorted];
                    $c_field_name = $this->GetFieldName($c);

                    if($c_field_name != "-1"){
                        if($this->IsForeignKey($c_field_name)){
                            $template = str_replace("{".$c_field_name."}", $this->GetForeignKeyInput($row[$this->GetFieldOffset($this->primaryKey)], $c_field_name, $row[$c], "view"), $template);
                        }else{
                            $template = str_replace("{".$c_field_name."}", $this->GetFieldValueByType($row[$c], $c, $row), $template);
                        }                                                        
                    }
                }
                echo $template;
            }            
        }
        
        if($req_mode == "add" || $req_mode == "edit"){
            echo "</form>";
        }
        
        if(isset($this->templates[$this->layoutType]['footer'])) echo $this->templates[$this->layoutType]['footer'];            

        // draw empty table       
        if($r == $this->rowLower){ $this->NoDataFound(); }
        if($this->pagingAllowed) $this->PagingSecondPart($this->arrLowerPaging, true, true, "Lower");

        $curr_url = $this->CombineUrl("update", $this->EncodeParameter($row[$this->GetFieldOffset($this->primaryKey)], false), $this->amp);
        $this->SetUrlString($c_curr_url, "filtering", "sorting", "paging", $this->amp);
        $curr_url .= $c_curr_url;
        
        if($req_mode == "view" || $req_mode == ""){
            $this->DrawMultiRowBar($r, $curr_url);  // draw multi-row footer cell            
        }
        
        // draw hide DG close div 
        $this->HideDivClose();
        if($this->isLoadingImageEnabled && !$this->ajaxEnabled) echo $this->ScriptOpen()."document.getElementById('".$this->uniqueRandomPrefix."loading_image').style.display='none';".$this->ScriptClose();
        
    }
    
    //--------------------------------------------------------------------------
    // Draw tabular layout
    //--------------------------------------------------------------------------
    protected function DrawTabular(){
        $req_mode    = $this->GetVariable('mode');
        $horizontal_align = ($this->tblAlign[$this->mode] == "center") ? "margin-left: auto; margin-right: auto;" : "";
       
        $this->ExportTo();
        $this->ShowCaption($this->caption);
        $this->DisplayMessages();
        $this->DrawControlPanel();
        
        if($this->mode != "edit") $this->DrawFiltering();   
        if(($req_mode !== "add") || ($req_mode == "")) $this->PagingFirstPart();  
        if($this->pagingAllowed) $this->PagingSecondPart($this->arrUpperPaging, false, true, "Upper");
        ///if($this->rowLower == $this->rowUpper) echo "<br />";        

        //prepare summarize columns array
        foreach ($this->columnsViewMode as $key => $val){        
            $fp_summarize = $this->GetFieldProperty($key, "summarize", "view");
            if(($fp_summarize == "true") || ($fp_summarize === true)){    
                $this->arrSummarizeColumns[$key] = array("sum"=>0, "count"=>0);
            }
        }
        
        if($this->isLoadingImageEnabled && !$this->ajaxEnabled) echo "<div id='".$this->uniqueRandomPrefix."loading_image'><br /><table style='margin-left: auto; margin-right: auto;'><tr><td valign='middle'>".$this->lang['loading_data']."</td><td valign='middle'><img src='".$this->directory."images/loading.gif' alt='".$this->lang['loading_data']."'></table></div>\n";                
        // draw hide DG open div 
        $this->HideDivOpen();
        $this->DrawControlButtonsJS();    

        // draw add link-button cell
        if(isset($this->modes['add'][$this->mode]) && $this->modes['add'][$this->mode] &&
           isset($this->modes['add']['show_add_button']) && ($this->modes['add']['show_add_button'] == "outside")){
            echo "<table dir='".$this->direction."' border='0' style='".$horizontal_align."' width='".$this->tblWidth[$this->mode]."'>";
            echo "<tr>";
            echo "<td align='".(($this->direction == "ltr") ? "left" : "right")."'><b>";
            $this->DrawModeButton("add", "javascript:".$this->uniquePrefix."_doPostBack(\"add\",".$this->EncodeParameter('-1').");", $this->lang['add_new'], $this->lang['add_new_record'], "add.gif", "''", false, "", "");                        
            echo "</b></td>";
            echo "</tr>";
            echo "</table>";
            $this->modes['add'][$this->mode] = false;
        }

        if($this->scrollingOption && $this->mode == "view"){ echo "<table cellpadding='0' cellspacing='0' border='0' width='".$this->tblWidth[$this->mode]."' align='".$this->tblAlign[$this->mode]."'><tr><td>\n"; }
        $this->TblOpen();        
        
        // *** START DRAWING HEADERS -------------------------------------------
        $this->TblHeadOpen();
        $this->RowOpen("");

            // draw multi-row checkboxes header
            if(($this->isMultirowAllowed) && ($this->rowsTotal > 0)){                
                $this->ColOpen("center",0,"nowrap",$this->rowColor[0], $this->cssClass."_dg_td", "26px");
                echo $this->nbsp;
                $this->ColClose();
            }            
            
            // draw add link-button cell
            if(isset($this->modes['add'][$this->mode]) && $this->modes['add'][$this->mode]){            
                $this->MainColOpen("center", 0, "nowrap", "1%", $this->cssClass."_dg_th_normal");
                $this->DrawModeButton("add", "javascript:".$this->uniquePrefix."_doPostBack(\"add\",".$this->EncodeParameter('-1').");", $this->lang['add_new'], $this->lang['add_new_record'], "add.gif", "''", false, "", "");                        
                $this->MainColClose();
            }else{            
                if(isset($this->modes['edit'][$this->mode]) && $this->modes['edit'][$this->mode]){
                    $this->MainColOpen("center",0,"nowrap", "1%", $this->cssClass."_dg_th_normal"); echo $this->nbsp; $this->MainColClose();                
                }
            }
            // draw details/delete headers
            if(isset($this->modes['details'][$this->mode]) && $this->modes['details'][$this->mode] && $this->controlsDisplayingType == "grouped"){
                $this->MainColOpen("center",0,"nowrap", "5%", $this->cssClass."_dg_th_normal");$this->MainColClose();
            }                        
            if(isset($this->modes['delete'][$this->mode]) && $this->modes['delete'][$this->mode] && $this->controlsDisplayingType == "grouped"){
                $this->MainColOpen("center",0,"nowrap", "5%", $this->cssClass."_dg_th_normal");$this->MainColClose();
            }
            if(($this->rowsNumeration)){ 
                $this->MainColOpen("center",0,"nowrap", ""); echo $this->numerationSign; $this->MainColClose();                
            }

            // draw column headers in add mode
            if(($this->rid == -1) && ($req_mode == "add")){
                foreach($this->columnsEditMode as $key => $val){                    
                    if($this->GetFieldProperty($key, "type") != "hidden"){
                        $this->MainColOpen("center",0);
                        echo "<b>".ucfirst($this->GetHeaderName($key))."</b>";                        
                        $this->MainColClose();                        
                    }
                }
            }else{
                $req_sort_field    = $this->GetVariable('sort_field');
                $req_sort_field_by = $this->GetVariable('sort_field_by');
                $req_sort_type     = $this->GetVariable('sort_type');    
                if($req_sort_field){
                    $sort_img = (strtolower($req_sort_type) == "desc") ? $this->directory."styles/".$this->cssClass."/images/s_desc.png" : $this->directory."styles/".$this->cssClass."/images/s_asc.png" ;
                    $sort_img_back = (strtolower($req_sort_type) == "desc") ? $this->directory."styles/".$this->cssClass."/images/s_asc.png" : $this->directory."styles/".$this->cssClass."/images/s_desc.png" ;
                    $sort_alt = (strtolower($req_sort_type) == "desc") ? $this->lang['descending'] : $this->lang['ascending'] ;
                }
                if($this->mode === "view"){                
                    // draw column headers in view mode                    
                    for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                        // get current column's index (offset)
                        $c = $this->sortedColumns[$c_sorted];
                        $field_name = $this->GetFieldName($c);
                        
                        $fp_sort_by = $this->GetFieldProperty($field_name, "sort_by", "view");
                        $fp_sort_type = $this->GetFieldProperty($field_name, "sort_type", "view");
                        if($fp_sort_by != ""){
                            $sort_field_by = ($this->GetFieldOffset($fp_sort_by)+1);                            
                        } else {
                            $sort_field_by = "";
                        };
                        
                        if($this->CanViewField($field_name)){
                            $fp_wrap  = $this->GetFieldProperty($field_name, "wrap", "view", "lower", $this->wrap);
                            $fp_width = $this->GetFieldProperty($field_name, "width", "view");
                            $fp_header_tooltip = $this->GetFieldProperty($field_name, "header_tooltip", "view");                            
                            $field_titile_tooltip = $this->lang['sort'];
                            $fp_sortable = $this->GetFieldProperty($field_name, "sortable", "view");
                            $fp_sortable = $this->GetFieldProperty($field_name, "sortable", "view");
                            $fp_header_align = $this->GetHeaderAlign($field_name);
                            if($this->sortingAllowed && !$this->isPrinting && $req_sort_field && ($c == ($req_sort_field -1))){ $th_css_class = $this->cssClass."_dg_th_selected"; } else { $th_css_class = $this->cssClass."_dg_th" ;};                
                            $this->MainColOpen($fp_header_align, 0, $fp_wrap, $fp_width, $th_css_class);
                            if($this->sortingAllowed && $fp_sortable !== false){
                                $href_string = ""; // #0006 $this->CombineUrl("view");
                                $this->SetUrlString($href_string, "", "", "paging"); // removed filtering for _doPostBack
                                if(isset($_REQUEST[$this->uniquePrefix.'sort_type']) && $_REQUEST[$this->uniquePrefix.'sort_type'] == "asc") $sort_type="desc";
                                else $sort_type="asc";
                                if(!$this->isPrinting){                                   
                                    $href_string .= $this->amp.$this->uniquePrefix."sort_field=".($c+1).$this->amp.$this->uniquePrefix."sort_field_by=".$sort_field_by.$this->amp.$this->uniquePrefix."sort_field_type=".$fp_sort_type.$this->amp.$this->uniquePrefix."sort_type=";
                                    // prepare sorting order by field's type 
                                    if($req_sort_field && ($c == ($req_sort_field -1))){
                                        $href_string .= $sort_type;
                                    }else{
                                        if($this->IsDate($field_name)){ $href_string .= "desc"; }
                                        else{ $href_string .= "asc"; }                                        
                                    }
                                    
                                    //[#0012 - 1] - start
                                    /// old code: $href_string = str_replace("&", "&amp;", str_replace("&amp;", "&", $href_string));
                                    //[#0012 - 1] - end
                                    
                                    //[#0012 - 2] - start
                                    // new code: suggested by kalak
                                    $href_string = $this->AddArrayParams($href_string);
                                    //[#0012 - 2] - end

                                    $href_string = "javascript:".$this->uniquePrefix."_doPostBack(\"sort\",\"\",\"".$href_string."\");";
                                    echo "<a class='".$this->cssClass."_dg_a_header' href='".$href_string."' title='".$field_titile_tooltip."' ";
                                    if($req_sort_field && ($c == ($req_sort_field -1))){
                                        echo "onmouseover=\"if(document.getElementById('soimg".$c."')){ document.getElementById('soimg".$c."').src='".$sort_img_back."';  }\" ";
                                        echo "onmouseout=\"if(document.getElementById('soimg".$c."')){ document.getElementById('soimg".$c."').src='".$sort_img."';  }\" ";                                
                                    }
                                    echo "><b>".ucfirst($this->GetHeaderName($field_name))." ";
                                    if($fp_header_tooltip != "" && !preg_match("/selected/i", $th_css_class)){
                                        $fp_header_tooltip = str_replace("'", "&#039;", $fp_header_tooltip); // single quotation mark
                                        echo " <img src='".$this->directory."images/question_mark.gif' style='vertical-align:middle;' border='0' alt='' title='".$fp_header_tooltip."' />";
                                    }
                                    echo "</b> ";
                                    if($req_sort_field && ($c == ($req_sort_field -1))){
                                        echo $this->nbsp."<img id='soimg".$c."' src='".$sort_img."' alt='".$sort_alt."' title='".$sort_alt."' style='border:0px;' />".$this->nbsp;
                                    }
                                    echo "</a>";
                                }else{
                                    echo "<b>".ucfirst($this->GetHeaderName($field_name))."</b>";                            
                                }
                            }else{
                                echo "<b>".ucfirst($this->GetHeaderName($field_name))."</b>";                        
                            }
                            $this->MainColClose();
                        }else{
                            if($field_name == "-1") $field_name = $this->GetFieldName($c_sorted);
                            $this->AddWarning("", "", "Field <b>".$field_name."</b>, used in SELECT not found in the list of fields in View Mode! <br />Please, check carefully your code syntax and field name, it may be case sensitive!");
                        }
                    }//for
                }else if($this->mode === "edit"){                    
                    foreach($this->columnsEditMode as $key => $val){
                        if($this->GetFieldProperty($key, "type") != "hidden"){
                            if($this->CanViewField($key)){
                                $this->MainColOpen("center",0);
                                // alow/disable sorting by headers                    
                                echo "<b>".ucfirst($this->GetHeaderName($key))."</b>";                        
                                $this->MainColClose();                                
                            }
                        }                        
                    }
                }            
            }
            // draw details/delete headers
            if(isset($this->modes['details'][$this->mode]) && $this->modes['details'][$this->mode] && $this->controlsDisplayingType == ""){
                $this->MainColOpen("center",0,"nowrap", "7%", $this->cssClass."_dg_th_normal");echo $this->lang['view'];$this->MainColClose();
            }                        
            if(isset($this->modes['delete'][$this->mode]) && $this->modes['delete'][$this->mode] && $this->controlsDisplayingType == ""){
                $this->MainColOpen("center",0,"nowrap", "7%", $this->cssClass."_dg_th_normal");echo $this->lang['delete'];$this->MainColClose();
            }                
        $this->RowClose();
        $this->TblHeadClose();        
        // *** END HEADERS -----------------------------------------------------

        //if we add a new row on linked tabular view mode table (mode 0 <-> 0)
        $quick_exit = false;        
        if((isset($_REQUEST[$this->uniquePrefix.'mode']) && ($_REQUEST[$this->uniquePrefix.'mode'] == "add")) && ($this->rowLower == 0) && ($this->rowUpper == 0)){
            $this->rowUpper = 1;
            $quick_exit = true;
        }        

        // *** START DRAWING ROWS ----------------------------------------------
        $first_field_name = "";
        $curr_url = "";
        $c_curr_url = "";

        $this->TbodyOpen();
        for($r = $this->rowLower; (($r >=0 && $this->rowUpper >=0) && ($r < $this->rowUpper) && ($r < ($this->rowLower + $this->reqPageSize))); $r++){            
            // add new row (ADD MODE)
            if(($r == $this->rowLower) && ($this->rid == -1) && ($req_mode == "add")){
                if($r % 2 == 0){$this->RowOpen($r, $this->rowColor[0]); $main_td_color=$this->rowColor[2];}
                else  {$this->RowOpen($r, $this->rowColor[1]); $main_td_color=$this->rowColor[3];}
                $curr_url = $this->CombineUrl("update", $this->EncodeParameter(-1, false), $this->amp);
                $this->SetUrlString($c_curr_url, "filtering", "sorting", "paging", $this->amp);                
                $curr_url .= $c_curr_url;
                $curr_url .= $this->amp.$this->uniquePrefix."new=1";
                echo "<form name='".$this->uniquePrefix."frmEditRow' id='".$this->uniquePrefix."frmEditRow' method='post' action='".$curr_url."'>".chr(13);
                echo "<input type='hidden' name='".$this->uniquePrefix."_operation_randomize_code' value='".$this->GetRandomString(20)."' />".chr(13);
                $this->SetEditFieldsFormScript($curr_url);
                // draw multi-row empty cell
                if(($this->isMultirowAllowed) && (!$this->isError)){$this->ColOpen("center",0,"nowrap",$this->rowColor[0], $this->cssClass."_dg_td");echo $this->nbsp;$this->ColClose();}                            
                $this->ColOpen("center",0,"nowrap",$main_td_color, $this->cssClass."_dg_td_main");
                $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."sendEditFields();", $this->lang['create'], $this->lang['create_new_record'], "update.gif", "''", false, "&nbsp", "");                    
                $param = $this->amp.$this->uniquePrefix."new=1";
                if(isset($this->modes['cancel'][$this->mode]) && $this->modes['cancel'][$this->mode]){            
                    $this->DrawModeButton("cancel", "javascript:".$this->uniquePrefix."verifyCancel(\"-1\", \"".$param."\")", "".$this->lang['cancel'], $this->lang['cancel'], "cancel.gif", "''", false, $this->nbsp, "");
                }
                $this->ColClose();                
                
                foreach($this->columnsEditMode as $key => $val){
                    if($this->GetFieldProperty($key, "type") != "hidden"){
                        $this->ColOpen("left",0,"nowrap");
                        if($this->IsForeignKey($key)){
                            echo $this->nbsp.$this->GetForeignKeyInput(-1, $key, '-1', "edit").$this->nbsp;
                        }else{
                            echo $this->GetFieldValueByType('', 0, '', $key);
                        }
                        $this->ColClose();                    
                    }else{
                        echo $this->GetFieldValueByType('', 0, '', $key);
                    }
                }                 
                
                if(isset($this->modes['delete']) && $this->modes['delete'][$this->mode]) $this->ColOpen("center",0,"nowrap");echo"";$this->ColClose();                
                echo "</form>"; 
                $this->RowClose();                
            }
                            
            //if we add a new row on linked tabular view mode table (mode 0 <-> 0) 
            if($quick_exit == true){
                $this->TblClose();
                if($this->isLoadingImageEnabled && !$this->ajaxEnabled) echo $this->ScriptOpen()."document.getElementById('".$this->uniqueRandomPrefix."loading_image').style.display='none';".$this->ScriptClose();                
                if(($this->firstFieldFocusAllowed) && ($first_field_name != "")) echo $this->ScriptOpen()."document.forms['".$this->uniquePrefix."frmEditRow']".$this->GetFieldRequiredType($first_field_name).$first_field_name.".focus();".$this->ScriptClose();                
                return;            
            }
            
            $row = $this->dataSet->fetchRow();
            if($r % 2 == 0){$this->RowOpen($r, $this->rowColor[0]); $main_td_color=$this->rowColor[2];}
            else  {$this->RowOpen($r, $this->rowColor[1]); $main_td_color=$this->rowColor[3];}
            
            // draw multi-row row checkboxes
            if($this->isMultirowAllowed){
                $this->ColOpen("center",0,"nowrap","","");                
                $disable = $this->isPrinting ? "disabled" : "";
                #Editted by Rosario
                #$checkbox_value = ($row[$this->GetFieldOffset($this->primaryKey)] != -1) ? $row[$this->GetFieldOffset($this->primaryKey)] : "0";
                $checkbox_value = ($row[$this->GetFieldOffset("pkey")] != -1) ? $row[$this->GetFieldOffset("pkey")] : "0";
                #echo "<input onclick=\"onMouseClickRow('".$this->uniquePrefix."','".$r."', '".$this->rowColor[5]."', '".$this->rowColor[1]."', '".$this->rowColor[0]."')\" type='checkbox' name='".$this->uniquePrefix."checkbox_".$r."' id='".$this->uniquePrefix."checkbox_".$r."' value='";
                echo "<input  onclick=\"isChecked(this.checked, this.value);\" type='checkbox' name='cid1[]' id='".$this->uniquePrefix."checkbox_".$r."' value='";
                echo $this->EncodeParameter($checkbox_value, false);
                echo "' ".$disable." />";
                $this->ColClose();                
            }
            
            // draw mode buttons
            if(isset($this->modes['edit'][$this->mode]) && $this->modes['edit'][$this->mode]){
                if(($this->mode == "edit") && $this->GetFieldOffset($this->primaryKey) != "-1" && (intval($this->rid) == intval($row[$this->GetFieldOffset($this->primaryKey)]))){
                    $curr_url = $this->CombineUrl("update", $this->EncodeParameter($row[$this->GetFieldOffset($this->primaryKey)], false), $this->amp);
                    $this->SetUrlString($c_curr_url, "filtering", "sorting", "paging", $this->amp);
                    $curr_url .= $c_curr_url;
                    echo "<form name='".$this->uniquePrefix."frmEditRow' id='".$this->uniquePrefix."frmEditRow' method='post' action='".$curr_url."'>".chr(13);
                    echo "<input type='hidden' name='".$this->uniquePrefix."_operation_randomize_code' value='".$this->GetRandomString(20)."' />".chr(13);
                    $this->SetEditFieldsFormScript($curr_url);                    
                    $this->ColOpen("center",0,"nowrap",$main_td_color, $this->cssClass."_dg_td_main");
                    $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."sendEditFields();", $this->lang['update'], $this->lang['update_record'], "update.gif", "''", false, " ", "");
                    if(isset($this->modes['cancel'][$this->mode]) && $this->modes['cancel'][$this->mode]){
                        $this->DrawModeButton("cancel", "javascript:".$this->uniquePrefix."_doPostBack(\"cancel\",".$this->EncodeParameter($row[$this->GetFieldOffset($this->primaryKey)]).");", $this->lang['cancel'], $this->lang['cancel'], "cancel.gif", "''", false, $this->nbsp, "");
                    }
                    $this->ColClose();
                }else {                                                            
                    if($this->dbHandler->phptype == "oci8"){
                        $row_id = $row[0];
                    } else{
                        $row_id = ($this->GetFieldOffset($this->primaryKey) != "-1") ? $row[$this->GetFieldOffset($this->primaryKey)] : $this->GetFieldOffset($this->primaryKey);                        
                    }
                    $curr_url = $this->CombineUrl("edit", $row_id);
                    $this->SetUrlString($curr_url, "filtering", "sorting", "paging");                                            
                    if(isset($_REQUEST[$this->uniquePrefix.'new']) && (isset($_REQUEST[$this->uniquePrefix.'new']) == 1)){
                        $curr_url .= $this->amp.$this->uniquePrefix."new=1";
                    }
                    if(isset($this->modes['edit'][$this->mode]) && $this->modes['edit'][$this->mode]){
                        // by field Value - link on Edit mode page
                        if (isset($this->modes['edit']['byFieldValue']) && ($this->modes['edit']['byFieldValue'] != "")){
                            if($this->GetFieldOffset($this->modes['edit']['byFieldValue']) == "-1"){
                                if($this->debug){
                                    $this->ColOpen(($this->direction == "rtl")?"right":"left",0,"nowrap",$main_td_color, $this->cssClass."_dg_td_main");
                                    echo $this->nbsp.$this->lang['wrong_field_name']." - ".$this->modes['edit']['byFieldValue'].$this->nbsp;
                                }else{
                                    $this->ColOpen("center",0,"nowrap",$main_td_color, $this->cssClass."_dg_td_main");                                    
                                    $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."_doPostBack(\"edit\",".$this->EncodeParameter($row_id).");", $this->lang['edit'], $this->lang['edit_record'], "edit.gif", "''", false, $this->nbsp, "");                                    
                                }
                            }else{
                                $this->ColOpen(($this->direction == "rtl")?"right":"left",0,"nowrap",$main_td_color, $this->cssClass."_dg_td_main");
                                echo $this->nbsp."<a class='".$this->cssClass."_dg_a_header' href='$curr_url'>".$row[$this->GetFieldOffset($this->modes['edit']['byFieldValue'])]."</a>".$this->nbsp;
                            }                            
                        }else{
                            $this->ColOpen("center",0,"nowrap",$main_td_color, $this->cssClass."_dg_td_main", "9%");                            
                            $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."_doPostBack(\"edit\",".$this->EncodeParameter($row_id).");", $this->lang['edit'], $this->lang['edit_record'], "edit.gif", "''", false, $this->nbsp, ""); 
                        }
                        $this->ColClose();                            
                    }                
                }
                $row_id = ($this->GetFieldOffset($this->primaryKey) != "-1") ? $row[$this->GetFieldOffset($this->primaryKey)] : $this->GetFieldOffset($this->primaryKey);
                if($this->controlsDisplayingType == "grouped") $this->DrawControlButtons($row_id);
            }else{
                if(isset($this->modes['add'][$this->mode]) && $this->modes['add'][$this->mode]){                    
                    $this->ColOpen("center",0,"nowrap",$this->rowColor[2], $this->cssClass."_dg_td_main");$this->ColClose();                    
                }
            }
            
            if($this->rowsNumeration){
                $this->ColOpen("center",0,"nowrap"); echo "<label class='".$this->cssClass."_dg_label'>".($r+1)."</label>"; $this->ColClose();
            }

            // draw column data
            for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                // get current column's index (offset)
                $c = $this->sortedColumns[$c_sorted];
                $col_align = $this->GetFieldAlign($c, $row, $this->mode);
                $c_field_name = $this->GetFieldName($c);
                $fp_wrap = $this->GetFieldProperty($c_field_name, "wrap", "view", "lower", $this->wrap);
                if(($this->mode === "view") && ($this->CanViewField($c_field_name))){                    
                    if($req_sort_field == $c+1){
                        $this->ColOpen($col_align, 0, $fp_wrap, (($r % 2 == 0) ? $this->rowColor[8] : $this->rowColor[9]), $this->cssClass."_dg_td_selected"); 
                    }else{
                        $this->ColOpen($col_align, 0, $fp_wrap);
                    }                    
                    $field_value = $this->GetFieldValueByType($row[$c], $c, $row);
                    $fp_summarize = $this->GetFieldProperty($c_field_name, "summarize", "view");
                    $fp_on_item_created = $this->GetFieldProperty($c_field_name, "on_item_created", "view");
                    if(($fp_summarize == "true") || ($fp_summarize === true)){                        
                        // customized working with field value
                        if(function_exists($fp_on_item_created)){
                            //ini_set("allow_call_time_pass_reference", true); 
                            $curr_value = str_replace(",", "", $fp_on_item_created($row[$c]));
                        }else{
                            $curr_value = str_replace(",", "", $row[$c]);
                        }
                        $this->arrSummarizeColumns[$c_field_name]["sum"] += $curr_value;
                        if($curr_value != "" && intval($curr_value) != "0") $this->arrSummarizeColumns[$c_field_name]["count"]++;
                    }
                    $field_value = str_replace("TRANSFER TO NOT SET", "FEES", $field_value);
                    echo $field_value;
                    
                    $this->ColClose();                    
                }else if($this->mode === "edit"){                    
                    if($this->CanViewField($c_field_name)){                        
                        if($first_field_name == "") $first_field_name = $c_field_name;
                        if(intval($this->rid) === intval($row[$this->GetFieldOffset($this->primaryKey)])){
                            if($this->GetFieldProperty($c_field_name, "type") == "hidden"){
                                //[#0004 - 1] - start
                                echo $this->GetFieldValueByType('', 0, '', $c_field_name);                        
                                //[#0004 - 1] - end
                            }else{
                                $this->ColOpen($col_align, 0, $fp_wrap);
                                if($this->IsForeignKey($c_field_name)){
                                    echo $this->nbsp.$this->GetForeignKeyInput($row[$this->GetFieldOffset($this->primaryKey)], $c_field_name, $row[$c], "edit").$this->nbsp;
                                }else{
                                    echo $this->GetFieldValueByType($row[$c], $c, $row); 
                                }
                                $this->ColClose();                                
                            }
                        }else{
                            if($this->GetFieldProperty($c_field_name, "type") != "hidden"){
                                $this->ColOpen($col_align, 0, $fp_wrap);
                                if($this->IsForeignKey($c_field_name)){
                                    echo $this->nbsp.$this->GetForeignKeyInput($row[$this->GetFieldOffset($this->primaryKey)], $c_field_name, $row[$c],"view").$this->nbsp;
                                }else if($this->IsEnum($c_field_name)){
                                    if(is_array($this->columnsEditMode[$c_field_name]["source"])){
                                       echo $this->nbsp.$this->columnsEditMode[$c_field_name]["source"][$row[$c]].$this->nbsp;
                                    }else{
                                       echo $this->GetFieldValueByType($row[$c], $c, $row, "", "", "view");
                                    }
                                }else{
                                    if($this->GetFieldProperty($c_field_name, "hide", "view") == "true"){
                                        echo $this->nbsp."******".$this->nbsp;
                                    }else{
                                        echo $this->GetFieldValueByType($row[$c], $c, $row, "", "", "view");
                                    }                                
                                }                                                                 
                                $this->ColClose();                                
                            }
                        }
                    }
                }
            }
            if($this->dbHandler->phptype == "oci8"){
                $row_id = $row[0];
            } else{
                $row_id = ($this->GetFieldOffset($this->primaryKey) != "-1") ? $row[$this->GetFieldOffset($this->primaryKey)] : $this->GetFieldOffset($this->primaryKey);                        
            }
            if($this->controlsDisplayingType != "grouped") $this->DrawControlButtons($row_id);

            if(($this->mode == "edit") && ($this->GetFieldOffset($this->primaryKey) != "-1") && (intval($this->rid) == intval($row[$this->GetFieldOffset($this->primaryKey)]))){ echo "</form>"; }
            $this->RowClose();
        }
        // *** END ROWS --------------------------------------------------------        
        
        // draw summarizing row
        if($r != $this->rowLower){ $this->DrawSummarizeRow($r); }
        $this->TbodyClose();
        $this->TblClose();
        if($this->scrollingOption && $this->mode == "view"){ echo "</td></tr></table>\n"; }
        
        
        // draw empty table       
        if($r == $this->rowLower){ $this->NoDataFound(); }
        
        $this->DrawMultiRowBar($r, $curr_url);  // draw multi-row row footer cell

        if($this->pagingAllowed) $this->PagingSecondPart($this->arrLowerPaging, true, true, "Lower");
        
        // draw hide DG close div 
        $this->HideDivClose();
        if($this->isLoadingImageEnabled && !$this->ajaxEnabled) echo $this->ScriptOpen()."document.getElementById('".$this->uniqueRandomPrefix."loading_image').style.display='none';".$this->ScriptClose();
        
        if(($this->firstFieldFocusAllowed) && ($first_field_name != "")) echo $this->ScriptOpen()."document.".$this->uniquePrefix."frmEditRow.".$this->GetFieldRequiredType($first_field_name).$first_field_name.".focus();".$this->ScriptClose();        
    }    
  
    //--------------------------------------------------------------------------
    // Draw columnar layout
    //--------------------------------------------------------------------------
    protected function DrawColumnar(){
        $req_mode = ($this->modeAfterUpdate == "") ? $this->GetVariable('mode') : $this->modeAfterUpdate;
        $hidden_fields = "";
        $r = ""; // rows counter
        $row = array();
        
        $this->ExportTo();
        $this->ShowCaption($this->caption);        
        $this->DrawControlPanel();
        
        if((($req_mode !== "add") && ($req_mode !== "details")) || ($req_mode == "")) $this->PagingFirstPart();  
        $this->DisplayMessages();          
        $this->DrawControlButtonsJS();    
      
        if(isset($this->modes['add'][$this->mode]) && $this->modes['add'][$this->mode]){
            $this->TblOpen();
            $this->RowOpen($r, $this->rowColor[0]);            
                $this->MainColOpen("center",0,"nowrap", "", $this->cssClass."_dg_th_normal");
                $this->DrawModeButton("add", "javascript:".$this->uniquePrefix."_doPostBack(\"add\",".$this->EncodeParameter('-1').");", $this->lang['add_new'], $this->lang['add_new'], "add.gif", "''", true, "", "");                        
                $this->MainColClose();
            $this->RowClose();
            $this->TblClose();                
        }

        if($this->pagingAllowed) $this->PagingSecondPart($this->arrUpperPaging, false, true, "Upper");

        //prepare action url for the form
        $combine_url_rid = ($this->multiRows > 1) ? $this->rid : $this->EncodeParameter($this->rid, false);
        $curr_url = $this->CombineUrl("update", $combine_url_rid, $this->amp);
        $this->SetUrlString($c_curr_url, "filtering", "sorting", "paging", $this->amp);
        $curr_url .= $c_curr_url;
        if($req_mode === "add") {
            $curr_url .= $this->amp.$this->uniquePrefix."new=1";
        }                    

        if($this->isLoadingImageEnabled && !$this->ajaxEnabled) echo "<div id='".$this->uniqueRandomPrefix."loading_image'><br /><table align='center'><tr><td valign='middle'>".$this->lang['loading_data']."</td><td valign='middle'><img src='".$this->directory."images/loading.gif' alt='' /></td></tr></table></div>\n";                
        echo "<form name='".$this->uniquePrefix."frmEditRow' id='".$this->uniquePrefix."frmEditRow' method='post' action='".$curr_url."'>".chr(13);
        echo "<input type='hidden' name='".$this->uniquePrefix."_operation_randomize_code' value='".$this->GetRandomString(20)."' />".chr(13);

        // draw hidden fields for Add Mode
        if($this->rid == -1){            
            foreach($this->columnsEditMode as $key => $val){
                if($this->GetFieldProperty($key, "type") == "hidden" && !$this->GetFieldProperty($key, "visible")){
                    //[#0004 - 2] - start
                    $hidden_fields .= $this->GetFieldValueByType('', 0, '', $key).chr(13);
                    //[#0004 - 2] - end
                }                
            }
        }
        
        $this->TblOpen();
        // draw header
        $this->RowOpen($r);
        if($this->mode == "view" && $this->modes['edit'][$this->mode] == "1"){
            // columnar layout in view mode
            $this->MainColOpen("center",0,"nowrap","10%", (($this->isPrinting) ? $this->cssClass."_dg_td" : $this->cssClass."_dg_th")); $this->MainColClose(); 
        }        
        $this->MainColOpen("center",0,"nowrap","32%", (($this->isPrinting) ? $this->cssClass."_dg_td" : $this->cssClass."_dg_th")); echo "<b>".(($this->fieldHeader != "") ? $this->fieldHeader : $this->lang['field'])."</b>"; $this->MainColClose(); 
        $this->MainColOpen("center",0,"nowrap","68%", (($this->isPrinting) ? $this->cssClass."_dg_td" : $this->cssClass."_dg_th")); echo "<b>".(($this->fieldHeaderValue != "") ? $this->fieldHeaderValue : $this->lang['field_value'])."</b>"; $this->MainColClose(); 
        $this->RowClose();        

        // set number of showing rows on the page
        if(($this->layouts['view'] == "0" || $this->layouts['view'] == "2") && ($this->layouts['edit'] == "1") && ($this->mode == "edit")){
            if($this->multiRows > 0){
                $this->reqPageSize = $this->multiRows;
            }else{
                $this->reqPageSize = 1;
            }
        }else if(($this->layouts['view'] == "0" || $this->layouts['view'] == "2") && ($this->layouts['edit'] == "1") && ($this->mode == "details")){
            if($this->multiRows > 0){
                $this->reqPageSize = $this->multiRows;
            }else{
                $this->reqPageSize = 1;
            }            
        }else if(($this->layouts['view'] == "1") && ($this->layouts['edit'] == "1") && ($this->mode == "edit")){
            $this->reqPageSize = 1;
        }else if(($this->layouts['edit'] == "1") && ($this->mode == "details")){
            $this->reqPageSize = 1;
        }         

        $first_field_name = ""; /* we need it to set a focus on this field */
        // draw rows in ADD MODE
        if($this->rid == -1){            
            foreach($this->columnsEditMode as $key => $val){
                if($this->GetFieldProperty($key, "type") == "hidden" && !$this->GetFieldProperty($key, "visible")) { continue; } /* skip hidden fields */
                if(($first_field_name == "") && (($this->mode === "edit") || ($this->mode === "add"))) $first_field_name = $key;
                if($r % 2 == 0) $this->RowOpen($r, $this->rowColor[0]);
                else $this->RowOpen($r, $this->rowColor[1]);
                
                // prepare alignment for header and data
                $col_header_align       = ($this->direction == "rtl") ? "right" : "left";
                $fp_align   = $this->GetFieldProperty($key, "align");
                if($fp_align != "") $col_data_align = $fp_align;
                else $col_data_align    = ($this->direction == "rtl")?"right":"left";                    
                    
                if(preg_match("/delimiter/i", $key)){
                    $this->ColOpen(($this->direction == "rtl")?"right":"left",2,"wrap");
                        echo $this->GetFieldProperty($key, "inner_html");
                    $this->ColClose();
                }else if($key == "validator"){
                    $fp_for_field = $this->GetFieldProperty("validator", "for_field");
                    $fp_header    = $this->GetFieldProperty("validator", "header");
                    $fp_req_type  = $this->GetFieldProperty("validator", "req_type");
                    // column's header
                    $this->ColOpen($col_header_align,0,"nowrap");                
                        echo $this->nbsp;echo "<b>".ucfirst($fp_header)."</b>";                        
                    $this->ColClose();
                    // column's data                    
                    $this->ColOpen($col_data_align,0,"nowrap");
                        echo $this->GetFieldValueByType('', 0, '', $fp_for_field, $fp_req_type);
                    $this->ColClose();
                }else{
                    if($this->CanViewField($key)){                    
                        // column's header
                        $this->ColOpen($col_header_align,0,"nowrap");                
                            echo $this->nbsp;echo "<b>".ucfirst($this->GetHeaderName($key))."</b>";                        
                        $this->ColClose();
                        // column's data
                        $this->ColOpen($col_data_align,0,"nowrap");
                        if($this->IsForeignKey($key)){
                            echo $this->nbsp.$this->GetForeignKeyInput(-1, $key, '-1', "edit").$this->nbsp;
                        }else{
                            echo $this->GetFieldValueByType('', 0, '', $key);
                        }
                        $this->ColClose();
                    }
                }
                $this->RowClose();
            }
        }     
        // *** START DRAWING ROWS ----------------------------------------------
        for($r = $this->rowLower; (($this->rid != -1) && ($r < $this->rowUpper) && ($r < ($this->rowLower + $this->reqPageSize))); $r++){
            // draw space between rows
            if(($this->multiRows) > 0 && $r > $this->rowLower && $r > $this->rowLower){
                $this->RowClose();
                $this->TblClose();
                
                $this->TblOpen("margin-top:12px;");
                // draw header
                $this->RowOpen($r); echo "<td height='0px' width='32%'></td><td height='0px' width='68%'></td>"; $this->RowClose();
            }
            $row = $this->dataSet->fetchRow();            
            // draw column headers                     
            for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                // get current column's index (offset)
                $c = $this->sortedColumns[$c_sorted];
                
                // turn off highlighting if we use columnar layout in vew mode
                if($this->layoutType == "view" && $this->layouts['view'] == "1"){
                    $this->isRowHighlightingAllowed = false;
                }
            
                if($r % 2 == 0) $this->RowOpen($r.$c_sorted, $this->rowColor[0]);
                else $this->RowOpen($r.$c_sorted, $this->rowColor[1]);
                $c_field_name = $this->GetFieldName($c);
                
                // draw hidden fields for Edit Mode
                //[#0004 - 3] - start
                if($this->GetFieldProperty($c_field_name, "type") == "hidden" && !$this->GetFieldProperty($c_field_name, "visible")){
                    if($this->multiRows > 0){
                        $rid_value = $this->DecodeParameter($this->rids[$r]);
                        $multirow_postfix = "_".$rid_value;
                    }else{
                        $rid_value = $this->rid;
                        $multirow_postfix = "";
                    }
                    $hidden_fields .= $this->GetFieldValueByType($row[$c], $c, $row, "", "", "", $multirow_postfix)."\n";                    
                    continue;
                }
                //[#0004 - 3] - start
            
                // prepare alignment for header and data
                $col_header_align       = ($this->direction == "rtl") ? "right" : "left";
                $fp_align   = $this->GetFieldProperty($c_field_name, "align");
                if($fp_align != "") $col_data_align = $fp_align;
                else $col_data_align    = ($this->direction == "rtl")?"right":"left";                    

                if($this->CanViewField($c_field_name)){                    
                    if(($first_field_name == "") && (($this->mode === "edit") || ($this->mode === "add"))) $first_field_name = $c_field_name;
                    // column headers
                    if(($this->mode === "view") && ($this->CanViewField($c_field_name))){
                        // columnar layout for view mode
                        if($this->modes['edit'][$this->mode] == "1"){
                            $this->ColOpen($col_header_align,0,"nowrap");
                                if($c_sorted == $this->colLower){
                                    echo $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."_doPostBack(\"edit\",".$this->EncodeParameter($row[0]).");", $this->lang['edit'], $this->lang['edit_record'], "edit.gif", "''", false, $this->nbsp, "", true);
                                }
                            $this->ColClose();                                                
                        }
                        $this->ColOpen($col_header_align,0,"nowrap");                   
                        echo $this->nbsp;echo "<b>".ucfirst($this->GetHeaderName($c_field_name))."</b>";                        
                        $this->ColClose();
                    }else if(($this->mode === "edit") && ($this->CanViewField($c_field_name))){
                        $this->ColOpen($col_header_align,0,"nowrap", "", "", "", "style='padding-top:5px;' valign='top'");
                        echo $this->nbsp;echo "<b>".ucfirst($this->GetHeaderName($c_field_name))."</b>";                                                    
                        $this->ColClose();
                    }else if(($this->mode === "details") && ($this->CanViewField($c_field_name))){
                        $this->ColOpen($col_header_align,0,"nowrap");                   
                        echo $this->nbsp;echo "<b>".ucfirst($this->GetHeaderName($c_field_name))."</b>";                        
                        $this->ColClose();
                    }
                    // column data 
                    if(($this->mode === "view") && ($this->CanViewField($c_field_name))){
                        $fp_wrap = $this->GetFieldProperty($c_field_name, "wrap", "view");
                        $this->ColOpen($col_data_align, 0, $fp_wrap);
                            echo $this->GetFieldValueByType($row[$c], $c, $row);
                        $this->ColClose();                    
                    }else if(($this->mode === "details") && ($this->CanViewField($c_field_name))){
                        $this->ColOpen($col_data_align,0);
                        if($this->IsForeignKey($c_field_name)){
                            echo $this->GetForeignKeyInput($row[$this->GetFieldOffset($this->primaryKey)], $c_field_name, $row[$c],"view");
                        }else{
                            echo $this->GetFieldValueByType($row[$c], $c, $row);
                        }
                        $this->ColClose();
                    }else if(($this->mode === "edit") && ($this->CanViewField($c_field_name))){
                        // if we have multi-rows selected
                        // mr_2
                        if($this->multiRows > 0){
                            $rid_value = $this->DecodeParameter($this->rids[$r]);
                            $multirow_postfix = "_".$rid_value;
                        }else{
                            $rid_value = $this->rid;
                            $multirow_postfix = "";
                        }

                        $ind = ($this->GetFieldOffset($this->primaryKey) != -1) ? $this->GetFieldOffset($this->primaryKey) : 0;
                        if(intval($rid_value) === intval($row[$ind])){
                            $this->ColOpen($col_data_align,0,"nowrap");
                            if($this->IsForeignKey($c_field_name)){
                                echo $this->nbsp.$this->GetForeignKeyInput($row[$ind], $c_field_name, $row[$c], "edit", $multirow_postfix).$this->nbsp;
                            }else{
                                /// mr_3
                                echo $this->GetFieldValueByType($row[$c], $c, $row, "", "", "", $multirow_postfix);
                            }
                            $this->ColClose();
                        }else{
                            $this->ColOpen($col_data_align,0,"nowrap");
                            if($this->rid == -1){
                                // add new row                                    
                                if($this->IsForeignKey($c_field_name)){
                                    echo $this->nbsp.$this->GetForeignKeyInput(-1, $c_field_name, '-1', "edit").$this->nbsp;
                                }else{
                                    echo $this->GetFieldValueByType('', $c, $row);
                                }                                    
                            }else{
                                if($this->IsForeignKey($c_field_name)){
                                    echo $this->nbsp.$this->GetForeignKeyInput($row[$this->GetFieldOffset($this->primaryKey)], $c_field_name, $row[$c], "view", $multirow_postfix).$this->nbsp;
                                }else{
                                    /// mr_4
                                    echo $this->GetFieldValueByType($row[$c], $c, $row, "", "", "", $multirow_postfix);                                        
                                }                                    
                            }
                            $this->ColClose();
                        }
                    }
                }else{
                    $ind = 0;                        
                    // if we have multi-rows selected
                    // mr_22
                    if($this->multiRows > 0){
                        $rid_value = $this->DecodeParameter($this->rids[$r]);
                        $multirow_postfix = "_".$rid_value;
                    }else{
                        $rid_value = $this->rid;
                        $multirow_postfix = "";
                    }
                    
                    foreach($this->columnsEditMode as $key => $val){
                        if($ind == $c_sorted){
                            if($this->mode != "details"){
                                if($key == "validator"){ // customized rows (validator)
                                    $fp_for_field = $this->GetFieldProperty($key, "for_field");
                                    $fp_header    = $this->GetFieldProperty($key, "header");
                                    $fp_req_type  = $this->GetFieldProperty($key, "req_type");
                                    $this->ColOpen($col_header_align,0,"nowrap");                   
                                        echo $this->nbsp;echo "<b>".ucfirst($fp_header)."</b>";                        
                                    $this->ColClose();
                                    $fp_wrap = $this->GetFieldProperty($c_field_name, "wrap", "view");
                                    $this->ColOpen($col_data_align, 0, $fp_wrap);
                                        $fp_for_field_offset = $this->GetFieldOffset($fp_for_field);
                                        if($fp_for_field_offset != "-1") echo $this->GetFieldValueByType($row[$fp_for_field_offset], $fp_for_field_offset, $row, "", $fp_req_type, "", $multirow_postfix);
                                    $this->ColClose();                    
                                }                                    
                            }
                            if(preg_match("/delimiter/i", $key)){ // customized rows (delimiter)                                
                                $this->ColOpen("",2,"wrap");
                                echo $this->GetFieldProperty($key, "inner_html");
                                $this->ColClose();                                            
                            }
                        }
                        $ind++;
                    }
                }
                $this->RowClose();
            }// for            
        }
        // *** END DRAWING ROWS ------------------------------------------------
        
        $this->TblClose();
        echo "<br />";        
        if(($r == $this->rowLower) && ($this->rid != -1)){
            $this->NoDataFound();
            echo "<br /><center>";
            if($this->isPrinting){
                echo "<span class='".$this->cssClass."_dg_a'><b>".$this->lang['back']."</b></span>";                                        
            }else{
                echo "<a class='".$this->cssClass."_dg_a' href='javascript:history.go(-1);'><b>".$this->lang['back']."</b></a>";                    
            }                
            echo "</center>";        
        }else{            
            if($this->layoutType == "view" && $this->layouts['view'] == "1"){
                // don't draw command buttons bar
            }else{
                if(($this->mode != "details") && isset($this->modes['edit'][$this->mode]) && $this->modes['edit'][$this->mode]){
                    $this->SetEditFieldsFormScript();
                }
                $this->TblOpen(); 
                $this->RowOpen($r, $this->rowColor[1]);
                $this->MainColOpen('left', 0, '', '', (($this->isPrinting) ? $this->cssClass."_dg_td_normal" : $this->cssClass."_dg_th"), "style='BORDER-RIGHT: #d2d0bb 0px solid;'");
                if($this->mode === "details"){
                    echo "<div style='float:";
                    echo ($this->direction == "rtl")?"left":"right";
                    if($this->isPrinting){
                        echo ";'><span class='".$this->cssClass."_dg_a'><b>".$this->lang['back']."</b></span></div>";                                        
                    }else{
                        echo ";'>";
                        $this->DrawModeButton("cancel", "javascript:".$this->uniquePrefix."_doPostBack(\"cancel\",".$this->EncodeParameter($row[$this->GetFieldOffset($this->primaryKey)]).");", $this->lang['back'], $this->lang['back'], "cancel.gif", "''", false, "", "");
                        echo "</div>";
                    }
                }else{
                    $ind = ($this->GetFieldOffset($this->primaryKey) != -1) ? $this->GetFieldOffset($this->primaryKey) : 0;                
                    if(($this->rid != -1) && isset($this->modes['delete'][$this->mode]) && $this->modes['delete'][$this->mode]){
                        $this->DrawModeButton("delete", "javascript:".$this->uniquePrefix."verifyDelete(".$this->EncodeParameter($row[$ind]).");", $this->lang['delete'], $this->lang['delete_record'], "delete.gif", "''", true, "", "");                        
                    }
                    if($this->rid != -1){
                        $rid = $row[$ind];
                    }else{
                        $rid = -1;
                    }
                    $curr_url = $this->CombineUrl("update", $rid);
                    $curr_url .= $c_curr_url;
                    
                    if(isset($this->modes['edit'][$this->mode]) && $this->modes['edit'][$this->mode]){
                        echo "<div style='float:"; echo ($this->direction == "rtl")?"left":"right"; echo ";'>";    
                        if(isset($this->modes['cancel'][$this->mode]) && $this->modes['cancel'][$this->mode]){
                            if($req_mode === "add") {
                                $param = $this->amp.$this->uniquePrefix."new=1";
                                $this->DrawModeButton("cancel", "javascript:".$this->uniquePrefix."verifyCancel(\"-1\", \"".$param."\")", "".$this->lang['cancel'], $this->lang['cancel'], "cancel.gif", "''", false, $this->nbsp, "");
                            }else{                            
                                $this->DrawModeButton("cancel", "javascript:".$this->uniquePrefix."_doPostBack(\"cancel\",".$this->EncodeParameter($rid).");", $this->lang['cancel'], $this->lang['cancel'], "cancel.gif", "''", false, $this->nbsp, "");
                            }
                        }
                        echo "<img src='".$this->directory."images/spacer.gif' width='20px' height='1px' alt='' />";
                        if($this->rid == -1){ // new record
                           $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."sendEditFields();", $this->lang['create'], $this->lang['create_new_record'], "update.gif", "''", false, $this->nbsp, "");
                        }else{
                           $this->DrawModeButton("edit", "javascript:".$this->uniquePrefix."sendEditFields();", $this->lang['update'], $this->lang['update_record'], "update.gif", "''", false, $this->nbsp, "");
                        }
                        echo "</div>";
                    }else{
                        echo "<div style='float:"; echo ($this->direction == "rtl")?"left":"right"; echo ";'>";   
                        $this->DrawModeButton("cancel", "javascript:".$this->uniquePrefix."_doPostBack(\"cancel\",".$this->EncodeParameter($row[$ind]).");", $this->lang['back'], $this->lang['back'], "cancel.gif", "''", false, $this->nbsp, "");
                        echo "</div>";                       
                    }
                }
                $this->MainColClose();
                $this->RowClose();
                $this->TblClose();                              
            }
        }
        
        //[#0004 - 2/3] - start
        echo $hidden_fields;
        
        echo "</form>";
        if($this->isLoadingImageEnabled && !$this->ajaxEnabled) echo $this->ScriptOpen()."document.getElementById('".$this->uniqueRandomPrefix."loading_image').style.display='none';".$this->ScriptClose();
        
        if($this->pagingAllowed) $this->PagingSecondPart($this->arrLowerPaging, true, true, "Lower");               
        if(($this->firstFieldFocusAllowed) && ($first_field_name != "")) echo $this->ScriptOpen()."document.".$this->uniquePrefix."frmEditRow.".$this->GetFieldRequiredType($first_field_name).$first_field_name.".focus();".$this->ScriptClose();
    } 


    //--------------------------------------------------------------------------
    // Draw multi-row bar
    //--------------------------------------------------------------------------
    protected function DrawMultiRowBar($r, $curr_url){
        $horizontal_align = ($this->tblAlign[$this->mode] == "center") ? "margin-left: auto; margin-right: auto;" : "";        
        if(($this->isMultirowAllowed) && ($r != $this->rowLower)){
            echo $this->ScriptOpen();            
            echo "function ".$this->uniquePrefix."verifySelected(param, button_type, flag_name, flag_value, operation_type){
                if(operation_type == 'delete'){ 
                    if(!confirm('".$this->lang['alert_perform_operation']."')){
                        return false;
                    }
                }
                selected_rows = '&".$this->uniquePrefix."rid=';
                selected_rows_ids = '';
                found = 0;
                for(i=".$this->rowLower."; i < ".$this->rowUpper."; i++){
                    if(document.getElementById(\"".$this->uniquePrefix."checkbox_\"+i) && document.getElementById(\"".$this->uniquePrefix."checkbox_\"+i).checked == true){
                        if(found == 1){ selected_rows_ids += '-'; }
                        selected_rows_ids += document.getElementById(\"".$this->uniquePrefix."checkbox_\"+i).value;
                        found = 1;
                    }
                }
                if(found){
                    document_location_href = param+selected_rows+selected_rows_ids;
                    if(flag_name != ''){                            
                        found = (document_location_href.indexOf(flag_name) != -1);
                        if(!found){
                            document_location_href += '&'+flag_name+'='+flag_value;
                        }
                    }\n";
                    if($this->ajaxEnabled) echo "document.location.href = document_location_href;";
                    else echo "document.location.href = document_location_href.replace(/&amp;/g, '&');"; 
                    echo "
                }else{
                    alert('".$this->lang['alert_select_row']."');
                    return false;
                }
            };\n
            function ".$this->uniquePrefix."setCheckboxes(check){
                if(check){
                    for(i=".$this->rowLower."; i < ".$this->rowUpper."; i++){
                        if(document.getElementById('".$this->uniquePrefix."checkbox_'+i)){
                            document.getElementById('".$this->uniquePrefix."checkbox_'+i).checked = true;
                            if(document.getElementById('".$this->uniquePrefix."row_'+i)){
                                document.getElementById('".$this->uniquePrefix."row_'+i).style.background = '".$this->rowColor[5]."';
                            }
                        }
                    }
                }else{
                    for(i=".$this->rowLower."; i < ".$this->rowUpper."; i++){
                        if(document.getElementById('".$this->uniquePrefix."checkbox_'+i)){
                            document.getElementById('".$this->uniquePrefix."checkbox_'+i).checked = false;
                            if((i % 2) == 0) row_color_back = '".$this->rowColor[0]."';
                            else row_color_back = '".$this->rowColor[1]."';
                            if(document.getElementById('".$this->uniquePrefix."row_'+i)){
                                document.getElementById('".$this->uniquePrefix."row_'+i).style.background = row_color_back;
                            }
                        }
                    }                
                }
            }";
            echo $this->ScriptClose();
            echo "\n<table dir='".$this->direction."' border='0' style='".$horizontal_align."' width='".$this->tblWidth[$this->mode]."'>";
            echo "\n<tr>";
            echo "\n<td align='".(($this->direction == "ltr") ? "left" : "right")."'>";
            echo "\n<table border='0'>
                  \n<tr>
                    <td align='".(($this->direction == "ltr") ? "left" : "right")."' valign='middle' class='dg_nowrap'>";
                        $count = 0;
                        foreach($this->arrMultirowOperations as $key => $val){
                            if($this->arrMultirowOperations[$key]['view']) $count++;
                        }                        
                        if($count > 0){
                            echo "<img style='padding:0px; margin:0px; border:0px;' src='".$this->directory."styles/".$this->cssClass."/images/arrow_ltr.png' width='38' height='22' alt='".$this->lang['with_selected']."' title='' />";
                                if(!$this->isPrinting){
                                    echo "<a class='".$this->cssClass."_dg_a' href='javascript:void(0);' onClick='".$this->uniquePrefix."setCheckboxes(true); return false;'>".$this->lang['check_all']."</a> / <a class='".$this->cssClass."_dg_a' href='javascript:void(0);' onClick='".$this->uniquePrefix."setCheckboxes(false); return false;'>".$this->lang['uncheck_all']."</a>";
                                }else{
                                    echo "<a class='".$this->cssClass."_dg_label'>".$this->lang['check_all']."</label> / <a class='".$this->cssClass."_dg_label'>".$this->lang['uncheck_all']."</label>";                                    
                                }
                            echo "<label class='".$this->cssClass."_dg_label' style='padding-left:4px;padding-right:4px;'><i>".$this->lang['with_selected'].":</i></label> </td>
                                  <td align='".(($this->direction == "ltr") ? "left" : "right")."' valign='middle'>";
                            foreach($this->arrMultirowOperations as $key => $val){
                                if($this->arrMultirowOperations[$key]['view']){
                                    echo "<img src='".$this->directory."images/spacer.gif' width='7px' height='5px' alt='' />";
                                    $curr_url = $this->CombineUrl($key, "");
                                    $flag_name = isset($val['flag_name']) ? $val['flag_name'] : "";
                                    $flag_value = isset($val['flag_value']) ? $val['flag_value'] : "";
                                    $tooltip = isset($val['tooltip']) ? $val['tooltip'] : $this->lang[$key.'_selected'];
                                    $image = isset($val['image']) ? $val['image'] : $key.".gif" ;
                                    $this->SetUrlString($curr_url, "filtering", "sorting", "paging");
                                    $curr_url = str_replace("&", "&amp;", $curr_url);
                                    $this->DrawModeButton($key, $curr_url, $tooltip, $tooltip, $image, "\"return ".$this->uniquePrefix."verifySelected('$curr_url', '$key', '$flag_name', '$flag_value', '$key');\"", false, "", "image");
                                }
                            }
                        }                            
            echo "\n</td>\n</tr>\n</table>";
            echo "\n</td>\n</tr>\n</table>";
        }
    }

    //--------------------------------------------------------------------------
    // Draw summarize row
    //--------------------------------------------------------------------------
    protected function DrawSummarizeRow($r){
        if(count($this->arrSummarizeColumns) > 0){
            $this->RowOpen("", $this->rowColor[0]);            
            // draw multi-row footer cell
            if($this->isMultirowAllowed){
                $this->ColOpen("center",0,"nowrap","","");
                echo $this->nbsp;
                $this->ColClose();            
            }
            
            // draw column headers in view mode                    
            for($c_sorted = $this->colLower; $c_sorted < count($this->sortedColumns); $c_sorted++){
                // get current column's index (offset)
                $c = $this->sortedColumns[$c_sorted];
                $c_field_name = $this->GetFieldName($c);
                if($c_sorted == $this->colLower){
                    if((isset($this->modes['add'][$this->mode]) && $this->modes['add'][$this->mode]) ||
                       (isset($this->modes['edit'][$this->mode]) && $this->modes['edit'][$this->mode]))  
                    {
                        $this->ColOpen("center",0,"nowrap",$this->rowColor[2], $this->cssClass."_dg_td_main");
                        echo "<a class='".$this->cssClass."_dg_a'><b>".$this->lang['total'].":</b></a>";
                        $this->ColClose();                    
                    }
                    if($this->rowsNumeration){
                       $this->ColOpen("center",0,"nowrap"); echo ""; $this->ColClose();
                    }
                }                
                if($this->GetFieldProperty($c_field_name, "type") == "hidden"){
                    //[#0004 - 4] - start
                    // echo $this->GetFieldValueByType('', 0, '', $c_field_name);
                    // $this->ColOpen("right",0,"nowrap");
                    // just to take a place in column
                    // $this->ColClose();             
                    //[#0004 - 4] - end                    
                }else if($this->CanViewField($c_field_name)){                      
                    $this->ColOpen("right",0,"nowrap");
                    $fp_summarize = $this->GetFieldProperty($c_field_name, "summarize", "view");
                    $fp_summarize_function = $this->GetFieldProperty($c_field_name, "summarize_function", "view");
                    if($fp_summarize_function != "SUM" && $fp_summarize_function != "AVG") $fp_summarize_function = $this->summarizeFunction;
                    if(($fp_summarize == "true") || ($fp_summarize === true)){
                        if($fp_summarize_function == "SUM"){
                            $summarize_value = $this->arrSummarizeColumns[$c_field_name]["sum"];
                        }else if($fp_summarize_function == "AVG" && $this->arrSummarizeColumns[$c_field_name]["count"] != "0"){
                            $summarize_value = $this->arrSummarizeColumns[$c_field_name]["sum"] / $summarize_value = $this->arrSummarizeColumns[$c_field_name]["count"];                        
                        }
                        echo $this->nbsp."=".$this->nbsp."<a class='".$this->cssClass."_dg_a'><b>".number_format($summarize_value, (is_float($summarize_value)?$this->summarizeNumberFormat['decimal_places']:"0") , $this->summarizeNumberFormat['decimal_separator'], $this->summarizeNumberFormat['thousands_separator'])."</b></a>";                        
                    }
                    $this->ColClose();                
                }
                
            }
            if((isset($this->modes['details'][$this->mode]) && $this->modes['details'][$this->mode])){
                $this->ColOpen("right",0,"nowrap");$this->ColClose();
            }        
            if((isset($this->modes['delete'][$this->mode]) && $this->modes['delete'][$this->mode])){
                $this->ColOpen("right",0,"nowrap");$this->ColClose();
            }        
            $this->RowClose();
        }    
    }

    //--------------------------------------------------------------------------
    // Sort columns by mode order
    //--------------------------------------------------------------------------
    protected function SortColumns($mode = ""){
        if($mode == "view"){            
            foreach($this->columnsViewMode as $fldName => $fldValue){
                $this->sortedColumns[] = $this->GetFieldOffset($fldName);
            }
        }else if(($mode == "edit") || ($mode == "details")){
            if(isset($this->columnsEditMode) && is_array($this->columnsEditMode)){
                foreach($this->columnsEditMode as $fldName => $fldValue){
                    $this->sortedColumns[] = $this->GetFieldOffset($fldName);
                }                            
            }
        }
    }

    //--------------------------------------------------------------------------
    // Add error to array of errors
    //--------------------------------------------------------------------------
    protected function AddErrors($dSet = ""){
        if($this->debug){
            if($dSet == "") $dSet = $this->dataSet;            
            $this->errors[] = $dSet->getDebugInfo();            
        }
    }
   
    //--------------------------------------------------------------------------
    // Add warning to array of warnings
    //--------------------------------------------------------------------------
    protected function AddWarning($warning_field = "", $warning_value = "", $str_warning = ""){
        if($this->debug){
            if($str_warning != ""){
                $this->warnings[] = $str_warning;
            }else{
                $warning = str_replace('_FIELD_', $warning_field, $this->lang['wrong_parameter_error']);
                $warning = str_replace('_VALUE_', $warning_value, $warning);
                $this->warnings[] = $warning;
            }
        }
    }
        
    //--------------------------------------------------------------------------
    // Display SQL statements
    //--------------------------------------------------------------------------
    protected function DisplaySqlStatements(){
        if($this->debug){
            echo "<br />";
            echo "<table width='91%' align='center'><tr><td align='left'>";                                
            foreach($this->sqlStatements as $key){
                echo $key."<br />";            
            }
            echo "</td></tr></table>";                                
        }        
    }    

    //--------------------------------------------------------------------------
    // Display warnings
    //--------------------------------------------------------------------------
    protected function DisplayWarnings(){
        if($this->debug){
            $count = 0;        
            if(count($this->warnings) > 0){
                echo "<table width='91%' align='center'><tr><td align='left'>";                                
                echo "<font class='".$this->cssClass."_dg_warning_message no_print dg_underlined'><b>".$this->lang['warnings']."</b>:</font><br /><br />";
                foreach($this->warnings as $key){
                    echo "<font class='".$this->cssClass."_dg_warning_message no_print'>".(++$count).") $key</font><br />";            
                }
                echo "<br />";
                echo "</td></tr></table>";                                
            }
        }
    }

    //--------------------------------------------------------------------------
    // Display errors
    //--------------------------------------------------------------------------
    protected function DisplayErrors(){
        if($this->debug){
            $count = 0;
            if(count($this->errors) > 0){
                echo "<table width='91%' align='center'><tr><td align='left'>";            
                echo "<font class='".$this->cssClass."_dg_error_message no_print dg_underlined'><b>".$this->lang['errors']."</b>:</font><br /><br />";
                foreach($this->errors as $key){
                    echo "<font class='".$this->cssClass."_dg_error_message no_print'>".(++$count).") </font>";
                    echo "<font class='".$this->cssClass."_dg_label'>".substr($key, 0, strpos($key, "["))."</font><br />";
                    echo "<font class='".$this->cssClass."_dg_error_message no_print'>".stristr($key, "[")."</font><br /><br />";                
                }
                echo "<br />";            
                echo "</td></tr></table>";            
            }
        }
    }

    //--------------------------------------------------------------------------
    // Draw data sent by POST and GET
    //--------------------------------------------------------------------------    
    protected function DisplayDataSent(){
        if($this->debug){
            echo "<table width='91%' align='center'><tr><td align='left'>";                        
            print_r("<font class='".$this->cssClass."_dg_ok_message no_print'><b>POST</b>: ");
            print_r($_POST);
            print_r("</font><br /><br />");
            print_r("<font class='".$this->cssClass."_dg_ok_message no_print'><b>GET</b>: ");
            print_r($_GET);
            print_r("</font><br /><br />");
            echo "</td></tr></table>";            
        }
    }
        
    //--------------------------------------------------------------------------
    // Draw messages
    //--------------------------------------------------------------------------
    protected function DisplayMessages(){
        if($this->messaging && $this->actMsg){
            $css_class = "".$this->cssClass."_dg_ok_message";
            if($this->isError) $css_class= "".$this->cssClass."_dg_error_message no_print";
            if($this->isWarning) $css_class= "".$this->cssClass."_dg_error_message no_print";            
            echo "<div style='margin-top:10px;margin-bottom:10px;'><center><font class='".$css_class."'>".$this->actMsg."</font></center></div>";
            $this->actMsg = "";            
        }        
    }
 
    //--------------------------------------------------------------------------
    // Save Http Get variables
    //--------------------------------------------------------------------------
    protected function SaveHttpGetVars(){
        echo "<div style='padding:0px; margin:0px;'>\n";        
        if(is_array($this->httpGetVars) && (count($this->httpGetVars) > 0)){
            foreach($this->httpGetVars as $key){
                echo "<input type='hidden' name='".$key."' id='".$key."' value='".((isset($_REQUEST[$key]))?$_REQUEST[$key]:"")."' />\n";                            
            }
        }
        echo "<input type='hidden' name='".$this->uniquePrefix."page_size'       id='".$this->uniquePrefix."page_size'       value='".((isset($_REQUEST[$this->uniquePrefix.'page_size']))?$_REQUEST[$this->uniquePrefix.'page_size']:$this->reqPageSize)."' />\n";                            
        echo "<input type='hidden' name='".$this->uniquePrefix."sort_field'      id='".$this->uniquePrefix."sort_field'      value='".((isset($_REQUEST[$this->uniquePrefix.'sort_field']))?$_REQUEST[$this->uniquePrefix.'sort_field']:"")."' />\n";
        echo "<input type='hidden' name='".$this->uniquePrefix."sort_field_by'   id='".$this->uniquePrefix."sort_field_by'   value='".((isset($_REQUEST[$this->uniquePrefix.'sort_field_by']))?$_REQUEST[$this->uniquePrefix.'sort_field_by']:"")."' />\n";
        echo "<input type='hidden' name='".$this->uniquePrefix."sort_field_type' id='".$this->uniquePrefix."sort_field_type' value='".((isset($_REQUEST[$this->uniquePrefix.'sort_field_type']))?$_REQUEST[$this->uniquePrefix.'sort_field_type']:"")."' />\n";                            
        echo "<input type='hidden' name='".$this->uniquePrefix."sort_type'       id='".$this->uniquePrefix."sort_type'       value='".((isset($_REQUEST[$this->uniquePrefix.'sort_type']))?$_REQUEST[$this->uniquePrefix.'sort_type']:"")."' />\n";
        
        // get URL vars from another  DG
        if(is_array($this->anotherDatagrids) && (count($this->anotherDatagrids) > 0)){
            foreach($this->anotherDatagrids as $key => $val){
                if($val[$this->mode] == true){
                    foreach($_REQUEST as $r_key => $r_val){
                        if(strstr($r_key, $key)){ // ."_ff_"
                           echo "<input type='hidden' name='".$r_key."' id='".$r_key."' value='".((isset($_REQUEST[$r_key]))?$_REQUEST[$r_key]:"")."' />\n";
                        }                
                    }                    
                }
            }
        }
        echo "</div>\n";                
    }
    
    //--------------------------------------------------------------------------
    // Combine URL
    //--------------------------------------------------------------------------
    protected function CombineUrl($mode, $rid="", $amp="", $other_datagrids = true){
        $amp = ($amp != "") ? $amp : $this->amp;
        if($this->ajaxEnabled) $amp = "&";
        $ind = 0;
        if(is_array($this->httpGetVars) && (count($this->httpGetVars) > 0)){
            foreach($this->httpGetVars as $key){
                if($ind == 0){ $a_url = (($this->ignoreBaseTag) ? $this->HTTP_URL : "")."?"; $ind = 1; }
                else $a_url .= $amp; 
                $a_url .= $key."=".((isset($_REQUEST[$key]))?$_REQUEST[$key]:"");
            }
        }
        if($ind == 0) $a_url = (($this->ignoreBaseTag) ? $this->HTTP_URL : "")."?".$this->uniquePrefix."mode=".$mode."";
        else $a_url .= $amp.$this->uniquePrefix."mode=".$mode."";
        if($rid !== "") $a_url .= $amp.$this->uniquePrefix."rid=".$rid;
        
        // get URL vars from another DG
        if(is_array($this->anotherDatagrids) && (count($this->anotherDatagrids) > 0) && $other_datagrids){
            foreach($this->anotherDatagrids as $key => $val){
                if($val[$this->mode] == true){  
                    $a_url .= $amp.$key."mode=".((isset($_REQUEST[$key.'mode']))?$_REQUEST[$key.'mode']:"");
                    $a_url .= $amp.$key."rid=".((isset($_REQUEST[$key.'rid']))?$this->DecodeParameter($_REQUEST[$key.'rid']):"");
                    $a_url .= $amp.$key."sort_field=".((isset($_REQUEST[$key.'sort_field']))?$_REQUEST[$key.'sort_field']:"");
                    $a_url .= $amp.$key."sort_field_by=".((isset($_REQUEST[$key.'sort_field_by']))?$_REQUEST[$key.'sort_field_by']:"");
                    $a_url .= $amp.$key."sort_field_type=".((isset($_REQUEST[$key.'sort_field_type']))?$_REQUEST[$key.'sort_field_type']:"");
                    $a_url .= $amp.$key."sort_type=".((isset($_REQUEST[$key.'sort_type']))?$_REQUEST[$key.'sort_type']:"");
                    $a_url .= $amp.$key."page_size=".((isset($_REQUEST[$key.'page_size']))?$_REQUEST[$key.'page_size']:"");
                    $a_url .= $amp.$key."p=".((isset($_REQUEST[$key.'p']))?$_REQUEST[$key.'p']:"");
                    foreach($_REQUEST as $r_key => $r_val){                    
                        if(strstr($r_key, $key."_ff_")){
                            $a_url .= $amp.$r_key."=".((isset($_REQUEST[$r_key]))?rawurlencode($_REQUEST[$r_key]):"");
                        }                
                    }                    
                }
            }
        }        
        return $a_url;         
    }

    //--------------------------------------------------------------------------
    // Set SQL limit 
    //--------------------------------------------------------------------------
    protected function SetSqlLimit(){        
        $req_page_num  = "";
        $req_page_size = $this->GetVariable('page_size');
        $req_p = $this->GetVariable('p');

        if($req_page_size != "") $this->reqPageSize = $req_page_size;
        if($req_p != "") $req_page_num  = $req_p;        
        if(is_numeric($req_page_num)){
            if($req_page_num > 0) $this->pageCurrent = $req_page_num;
            else $this->pageCurrent = 1;
        }else{
            $this->pageCurrent = 1;
        }

        // if the last row from the last page was deleted
        if(intval($this->rowsTotal) <= intval(($this->pageCurrent - 1) * $this->reqPageSize)){
            if($this->pageCurrent > 1){
                $this->pageCurrent--;
                $_REQUEST[$this->uniquePrefix.'p'] = $this->pageCurrent;
            }
        }       
        
        $this->limitStart = ($this->pageCurrent - 1) * $this->reqPageSize;
        $this->limitSize = $this->reqPageSize;
    }

    //--------------------------------------------------------------------------
    // Set SQL limit by DB type
    //--------------------------------------------------------------------------
    protected function SetSqlLimitByDbType($limit_start="", $limit_size=""){
        // get full recordset if export_all defined as true
        if($this->GetVariable('export') == "true" && $this->exportAll == true) return ""; 
            
        $this->SetSqlLimit();
        if($limit_start == "") $limit_start = $this->limitStart;
        if($limit_size == "") $limit_size = $this->limitSize; 
        $limit_string = "";
        switch($this->dbHandler->phptype){
            case "oci8":    // Oracle                
                $limit_string = "AND (rownum > ".$limit_start." AND rownum <= ".intval($limit_start + $limit_size).") ";
                break;          
            case "mssql":   // MSSQL            
                $limit_string = "AND (RowNumber > ".$limit_start." AND RowNumber <= ".intval($limit_start + $limit_size).") ";
                break;
            case "pgsql":   // PostgreSql                
                $limit_string = "OFFSET ".$limit_start." LIMIT ".$limit_size." ";
                break;                 
            case "ibase":   // iBase/Firebird
            case "firebird":
                $limit_string = "FIRST ".$limit_size." SKIP ".$limit_start." ";
                break;
            case "mysql":   // MySQL and others 
            default:
                $limit_string = "LIMIT ".$limit_start.", ".$limit_size." ";
                break;            
        }
        return $limit_string;
    }    

    //--------------------------------------------------------------------------
    // Set real escape string by DB type
    //--------------------------------------------------------------------------
    protected function SetRealEscapeStringByDbType($field_value = ""){
        if(!$this->allowRealEscape) return $field_value;
        switch($this->dbHandler->phptype){
            case "mysql":   // mysql 
                return mysql_real_escape_string($field_value);  break;    
            case "pgsql":   // PostgreSql                
                return pg_escape_string($field_value);  break;    
                break;
            default:
                return $field_value;  break;    
        }        
    }

    //--------------------------------------------------------------------------
    // Set SQL by DB type
    //--------------------------------------------------------------------------
    protected function SetSqlByDbType($sql="", $order_by="", $limit=""){
        $sql_string = "";
        preg_match_all("/\d+/",$limit,$matches);
        $req_mode   = $this->GetVariable('mode');
        
        switch($this->dbHandler->phptype){
            case "oci8":    // oracle                
                if($limit != ""){
                    $limit_start = $matches[0][0]; 
                    $limit_size = $matches[0][1]-$limit_start; 
                    $sql_string = $this->dbHandler->modifyLimitQuery($sql." ".$order_by, $limit_start, $limit_size); 
                    if($this->debug) $this->sqlStatements[] = "<table><tr><td><b>Oracle sql: </b>".$sql_string."</td></tr></table><br />"; 
                }else{
                    $sql_string = $sql." ".$order_by;
                }
                break;
            case "mssql":   // mssql
                /// [#0015-1]
                if(($order_by != "") && !preg_match("/order/i", $order_by)) $order_by = " ORDER BY ".$order_by;
                /// [#0008] - START
                $select_top = isset($matches[0][1]) ? $matches[0][1] : "";
                if($select_top != ""){
                    $select_index = strpos(Helper::ConvertCase($sql,"lower",$this->langName), "select ");
                    $from_index   = strpos(Helper::ConvertCase($sql,"lower",$this->langName), "from ");
                    $where_index  = strpos(Helper::ConvertCase($sql,"lower",$this->langName), "where ");
                    $table_name   = substr($sql, $from_index+4, $where_index-$from_index-4);
                    $fields_list  = substr($sql, $select_index+6, $from_index-$select_index-6);
                    // [#0015] fixed bug 14.04.2010
                    if(preg_match("/where/i", $sql)){
                        $where_clause = substr($sql, $where_index+5, strlen($sql)-($where_index+5))." ";
                    }else{
                        $where_clause = "1=1 ";
                    }
                    
                    // [#0014-1] fixed bug 08.04.2010
                    if(trim($fields_list) == "*"){
                        if($table_name == "") $table_name = $this->tblName;
                        $fields_list = $table_name.".*";
                    }
                    
                    if($req_mode != "edit" && $req_mode != "details"){
                        $sql_string = "SELECT * FROM ( ";
                        $sql_string .= " SELECT TOP ".$select_top." ROW_NUMBER() OVER (".$order_by.") AS RowNumber, ".$fields_list." FROM ".$table_name;
                        $sql_string .= ") as foo ";
                        $sql_string .= "WHERE ".$where_clause;
                        $sql_string .= " ".$limit;
                        $sql_string .= " ".$order_by;
                    }else{
                        $sql_string = "SELECT * FROM ".$table_name;
                        $sql_string .= "WHERE ".$where_clause;
                        $sql_string .= " ".$order_by;                        
                    }                    
                }else{
                    /// [#0015-2]
                    $sql_string .= $sql." ".$order_by;
                }
                /// [#0008] - END
                // old code
                #$select_top = isset($matches[0][1]) ? $matches[0][1] : "";
                #$over_order_by = (isset($this->primaryKey) && $this->primaryKey != "") ? $this->primaryKey : trim(str_ireplace(array("ORDER BY", "ASC", "DESC"), "", $order_by));
                #if($select_top != "" && $over_order_by != ""){
                #    $from_index = strpos(Helper::ConvertCase($sql,"lower",$this->langName), "from ");
                #    $prefix = substr($sql, 0, $from_index); 
                #    $suffix = substr($sql, $from_index); 
                #    $sql_string = $prefix.", SELECT TOP ".$select_top." ROW_NUMBER() OVER (ORDER BY ".$over_order_by.") AS RowNumber ".$suffix; 
                #    $sql_string .= " ".$limit." ".$order_by;                    
                #}
                break;          
            case "ibase":    // interbase/firebird        
            case "firebird": 
                $sql_string = str_replace("SELECT ", "SELECT ".$limit." ", $sql)." ".$order_by;
                break;
            case "mysql":   // mysql and others
            default:
                $sql_string = $sql." ".$order_by." ".$limit;
                break;            
        }
        return $sql_string;        
    }

    //--------------------------------------------------------------------------
    // Get LCASE function name by DB type
    //--------------------------------------------------------------------------
    protected function GetLcaseFooByDbType(){
        $lcase_name = "";
        switch($this->dbHandler->phptype){
            case "oci8":     // oracle                
                $lcase_name = "lower";  break;          
            case "mssql":    // mssql
                $lcase_name = "LCASE";  break;
            case "pgsql":    // pgsql 
                $lcase_name = "lower";  break;                
            case "ibase":    // interbase/firebird
            case "firebird": // 
                $lcase_name = "lower";  break;
            case "mysql":    // mysql and others
            default:
                $lcase_name = "LCASE";  break;            
        }
        return $lcase_name;                
    }    
    
    //--------------------------------------------------------------------------
    // Paging function - part 1
    //--------------------------------------------------------------------------
    protected function PagingFirstPart(){        
        // (1) if we got a wrong number of page -> set page=1
        $req_page_num  = "";
        $req_page_size = $this->GetVariable('page_size');
        $req_p = $this->GetVariable('p');
        if(($req_page_size != "") && ($req_page_size != 0)) $this->reqPageSize = $req_page_size;
        if($req_p != "") $req_page_num  = $req_p;
        
        if(is_numeric($req_page_num)){
            if($req_page_num > 0) $this->pageCurrent = $req_page_num;
            else $this->pageCurrent = 1;
        }else{
            $this->pageCurrent = 1;
        }
        // (2) set pagesTotal & pageCurrent vars for paging        
        if($this->rowsTotal > 0){
            if(is_float($this->rowsTotal / $this->reqPageSize))
                $this->pagesTotal = intval(($this->rowsTotal / $this->reqPageSize) + 1);
            else
                $this->pagesTotal = intval($this->rowsTotal / $this->reqPageSize);
        }else{
            $this->pagesTotal = 0;
        }   
        if($this->pageCurrent > $this->pagesTotal) $this->pageCurrent = $this->pagesTotal;        
    }

    //--------------------------------------------------------------------------
    // Paging function - part 2 
    //--------------------------------------------------------------------------    
    protected function PagingSecondPart($lu_paging=false, $upper_br, $lower_br, $type="1"){
        // (4) display paging line
        if(!$this->isPrinting) {$a_tag = "a";} else {$a_tag = "span";};
        $text = "";
        $horizontal_align = ($this->tblAlign[$this->mode] == "center") ? "margin-left:auto; margin-right:auto;" : "";
        
        if($this->pagesTotal >= 1){
            $href_string = "";
            $this->SetUrlString($href_string, "", "sorting", "", "&");
            $href_string = str_replace("&", "&amp;", $href_string);
            $href_string .= "&amp;".$this->uniquePrefix."page_size=".$this->reqPageSize;
            //[#0012 - 3] - start
            // new code: suggested by kalak
            $href_string = $this->AddArrayParams($href_string);
            //[#0012 - 3] - end
            if($lu_paging['results'] || $lu_paging['pages'] || $lu_paging['page_size']){
                if($upper_br) $text .= "";  
                $text .= "\n<form name='frmPaging$this->uniquePrefix".$type."' id='frmPaging$this->uniquePrefix".$type."' action='' style='margin:0px; padding:0px;'>";
            }
            $text .= "<table class='".$this->cssClass."_dg_paging_table' dir='".$this->direction."' style='height:7px; width: ".$this->tblWidth[$this->mode]."; ".$horizontal_align."' border='0' >";
            $text .= "<tr>";
            $text .= "<td align='".$lu_paging['results_align']."' class='dg_nowrap'>";
            if($lu_paging['results']){
                $text .= " ".$this->lang['results'].": ";
                if(($this->pageCurrent * $this->reqPageSize) <= $this->rowsTotal) $total = ($this->pageCurrent * $this->reqPageSize);
                else $total = $this->rowsTotal;
                $text .= number_format(($this->pageCurrent * $this->reqPageSize - $this->reqPageSize + 1), 0, "", ",")." - ".number_format($total, 0, "", ",");
                $text .= " ".$this->lang['of']." ";
                $text .= number_format($this->rowsTotal, 0, "", ",")." ";
            }
            $text .= "</td>";
            $text .= "<td align='".$lu_paging['pages_align']."' class='dg_nowrap'>";
            if($lu_paging['pages']){
                $text .= "<table class='".$this->cssClass."_dg_paging_table' border='0' style='padding:0px;margin:0px;border:0px;' dir='".$this->direction."'><tr>";
                $text .= "<td>";
                $text .= " ".$this->lang['pages'].": ";
                // dropdown paging option                
                if ($this->dropdownPaging === true) {
                    $paging_array = array();
                    for($i = 1; $i <= $this->pagesTotal; $i++){ $paging_array[$i] = $i; }
                    $ddl_onchange = "javascript:".$this->uniquePrefix."_doPostBack('paging','','".$href_string."&amp;".$this->uniquePrefix."p=' + this.value)";
                    $text .= $this->DrawDropDownList($this->uniquePrefix."dropdownPaging".$type, "", $paging_array, $this->pageCurrent, "", "", "", "", "onchange=\"".$ddl_onchange."\"");
                }
                $href_prev1 = $href_prev2 = $href_first = "";
                if($this->pageCurrent > 1){
                    $href_prev1 = "href=\"javascript:".$this->uniquePrefix."_doPostBack('paging','','".$href_string."&amp;".$this->uniquePrefix."p=".($this->pageCurrent - 1)."')\"";
                    $href_prev2 = "href=\"javascript:".$this->uniquePrefix."_doPostBack('paging','','".$href_string."&amp;".$this->uniquePrefix."p=".$this->pageCurrent."')\"";
                    $href_first = "href=\"javascript:".$this->uniquePrefix."_doPostBack('paging','','".$href_string."&amp;".$this->uniquePrefix."p=1')\"";
                }
                $text .= " <".$a_tag." title='".$this->lang['first']."' class='".$this->cssClass."_dg_a' style='text-decoration: none;' ".$href_first.">".$this->firstArrow."</".$a_tag.">";
                if($this->pageCurrent > 1) $text .= " <".$a_tag." class='".$this->cssClass."_dg_a' style='text-decoration: none;' title='".$this->lang['previous']."' ".$href_prev1.">".$this->previousArrow."</".$a_tag.">";
                else $text .= " <".$a_tag." class='".$this->cssClass."_dg_a' style='text-decoration: none;' title='".$this->lang['previous']."' ".$href_prev2.">".$this->previousArrow."</".$a_tag.">";
                $text .= " ";
                $text .= "</td><td>";
                $low_window_ind = $this->pageCurrent - 3;
                $high_window_ind = $this->pageCurrent + 3;
                if($low_window_ind > 1){ $start_index = $low_window_ind; $text .= "..."; }
                else $start_index = 1;
                if($high_window_ind < $this->pagesTotal) $end_index = $high_window_ind;
                else $end_index = $this->pagesTotal;
                for($ind=$start_index; $ind <= $end_index; $ind++){
                    $href_middle = "javascript:".$this->uniquePrefix."_doPostBack('paging','','".$href_string."&amp;".$this->uniquePrefix."p=".$ind."')";
                    if($ind == $this->pageCurrent) $text .= " <".$a_tag." class='".$this->cssClass."_dg_a dg_underlined' style='text-decoration: underline;' title='".$this->lang['current']."' href=\"".$href_middle."\"><b>".$ind."</b></".$a_tag.">"; 
                    else $text .= " <".$a_tag." class='".$this->cssClass."_dg_a' style='text-decoration: none;' href=\"".$href_middle."\">".$ind."</".$a_tag.">";
                    if($ind < $this->pagesTotal) $text .= ", ";
                    else $text .= " ";
                }
                if($high_window_ind < $this->pagesTotal) $text .= "...";
                $href_next1 = $href_next2 = $href_last = "";
                if($this->pageCurrent < $this->pagesTotal){
                    $href_next1 = "href=\"javascript:".$this->uniquePrefix."_doPostBack('paging','','".$href_string."&amp;".$this->uniquePrefix."p=".($this->pageCurrent + 1)."')\"";
                    $href_next2 = "href=\"javascript:".$this->uniquePrefix."_doPostBack('paging','','".$href_string."&amp;".$this->uniquePrefix."p=".$this->pageCurrent."')\"";
                    $href_last  = "href=\"javascript:".$this->uniquePrefix."_doPostBack('paging','','".$href_string."&amp;".$this->uniquePrefix."p=".$this->pagesTotal."')\"";
                }
                $text .= "</td><td>";
                if($this->pageCurrent < $this->pagesTotal) $text .= " <".$a_tag." class='".$this->cssClass."_dg_a' style='text-decoration: none;' title='".$this->lang['next']."' ".$href_next1.">".$this->nextArrow."</".$a_tag.">";
                else $text .= " <".$a_tag." class='".$this->cssClass."_dg_a' style='text-decoration: none;' title='".$this->lang['next']."' ".$href_next2.">".$this->nextArrow."</".$a_tag.">";
                $text .= " <".$a_tag." class='".$this->cssClass."_dg_a' style='text-decoration: none;' title='".$this->lang['last']."' ".$href_last.">".$this->lastArrow."</".$a_tag.">";
                $text .= "</td>";
                $text .= "</tr></table>";
            }
            $text .= "</td>";
            $text .= "<td align='".$lu_paging['page_size_align']."' class='dg_nowrap'>";            
            if($lu_paging['page_size']){
                $text .= " ".$this->lang['page_size'].": ";
                $text .= $this->DrawDropDownList('page_size'.$type, '_doPostBack("page_resize","","'.$href_string.'&amp;'.$this->uniquePrefix.'page_size="+document.frmPaging'.$this->uniquePrefix.$type.'.page_size'.$type.'.value)', $this->arrPages, $this->reqPageSize);
            }
            $text .= "</td>";
            $text .= "</tr>";            
            $text .= "</table>";
            if($lu_paging['results'] || $lu_paging['pages'] || $lu_paging['page_size']){
                $text .= "</form>\n";
                if($lower_br) $text .= ""; //<br />
            }
            echo $text;
        }else{
            echo "<br /><br />";    
        }
    }
   
    //--------------------------------------------------------------------------
    // Set total number of rows in query
    //--------------------------------------------------------------------------
    protected function SetTotalNumberRows($fsort = "", $limit = "", $mode = "", $first_time = false){
        $req_mode = ($mode == "") ? $this->GetVariable('mode') : $mode;
        $temp_sql = $this->SetSqlByDbType($this->sql, "", "");
        $this->rowsTotal = 0;
        $bError = false;
        
        if(($req_mode == "edit") || ($req_mode == "details")){
            // [#0003-1 under check - 15.07.09] - start
            if($first_time){
                // we need this stupid operation to get a total number of rows in our query
                $from_pos              = $this->SubStrOccurence($temp_sql, "from ", true); /* get last occurence */
                $strlen_start_position = (int)(strlen($temp_sql) - $from_pos);
                $strlen_length         = (int)$from_pos;
                $new_sql = "SELECT COUNT(*) as cnt FROM ".substr($temp_sql, $strlen_start_position, $strlen_length);            
                $this->dataSet = & $this->dbHandler->query($new_sql);        
                if(!$this->dbHandler->isError($this->dataSet)){
                    $row = $this->dataSet->fetchRow();
                    $this->rowsTotal = $row[0];
                } else $bError = true;             
            }else{
            // [#0003-1 under check - 15.07.09] - end
                $this->dataSet = & $this->dbHandler->query($this->SetSqlByDbType($this->sql, $fsort, $limit));
                $this->rowsTotal = $this->NumberRows();                
            }
        }else{
            $group_by_is     = false;
            $union_is        = false;
            $exists_is       = false;
            
            if(preg_match("/group by/i", $temp_sql)) $group_by_is = true;
            if(preg_match("/union/i", $temp_sql)) $union_is = true;
            if(preg_match("/exists /i", $temp_sql)){
                /* handle EXIST/NOT EXISTS cases */
                $from_pos = $this->SubStrOccurence($temp_sql, "from "); /* get first occurence */
                $strlen_start_position = (int)$from_pos + 4;
                $strlen_length = (int)(strlen($temp_sql) - $from_pos);
            }else{
                $from_pos = $this->SubStrOccurence($temp_sql, "from ", true); /* get last occurence */
                $strlen_start_position = (int)(strlen($temp_sql) - $from_pos);
                $strlen_length = (int)$from_pos;
            }            

            if($union_is){
                $new_sql = str_ireplace("SELECT ", "SELECT COUNT(*) as union_cnt, ", $temp_sql);
                $this->dataSet = & $this->dbHandler->query($new_sql);                                        
                if(!$this->dbHandler->isError($this->dataSet)){
                    while($row = $this->dataSet->fetchRow()){
                        $this->rowsTotal += $row[0];
                    }
                } else $bError = true;                             
            }else{
                $new_sql = "SELECT ".(($group_by_is) ? "*" : "count(*) as cnt")." FROM ".substr($temp_sql, $strlen_start_position, $strlen_length);
                
                $this->dataSet = & $this->dbHandler->query($new_sql);        
                if(!$this->dbHandler->isError($this->dataSet)){
                    $row = $this->dataSet->fetchRow();
                    if($group_by_is){
                        $this->rowsTotal = $this->dataSet->numRows();
                    }else{
                        $this->rowsTotal = $row[0];
                    }                
                } else $bError = true;                         
            }            
        }
        if ($bError){
            //try another way to get the count.
            $new_sql = "SELECT COUNT(*) as cnt FROM ( $temp_sql ) t ";           
            $this->dataSet = & $this->dbHandler->query($new_sql);       
            if(!$this->dbHandler->isError($this->dataSet)){
                $row = $this->dataSet->fetchRow();
                $this->rowsTotal = $row[0];
            }
        }        
    }

    //--------------------------------------------------------------------------
    // Number rows
    //--------------------------------------------------------------------------
    protected function NumberRows(){
        if($this->dbHandler->isError($this->dataSet)){
            return 0;
        }else{
            return $this->dataSet->numRows();
        }        
    }
    
    //--------------------------------------------------------------------------
    // Number of columns
    //--------------------------------------------------------------------------
    protected function NumberCols(){
        if($this->dbHandler->isError($this->dataSet)){
            return 0;
        }else{
            return $this->dataSet->numCols();        
        }        
    }

    //--------------------------------------------------------------------------
    // No data found
    //--------------------------------------------------------------------------
    protected function NoDataFound(){
        $no_data_found_text = ($this->noDataFoundText != "") ? $this->noDataFoundText : $this->lang['no_data_found'];
        $this->TblOpen();
        $this->RowOpen(0, $this->rowColor[0]);
            $add_column = 0;
            if((isset($this->modes['add'][$this->mode]) && ($this->modes['add'][$this->mode])) ||
               (isset($this->modes['edit'][$this->mode]) && ($this->modes['edit'][$this->mode]))
              ) $add_column += 1;
            if(isset($this->mode['delete']) && $this->mode['delete']) $add_column += 1;
            $this->ColOpen("center", (count($this->sortedColumns) + $add_column),""); 
                if($this->isError){
                    echo "<br /><span class='".$this->cssClass."_dg_warning_message no_print'>".$this->lang['no_data_found_error']."<br /> ";
                    if(!$this->debug){ echo "<br />".$this->lang['turn_on_debug_mode']."<br > "; }
                    echo "</span>";
                }else{
                    echo "<br />".$no_data_found_text."<br /><br /> ";
                }
            $this->ColClose();                   
        $this->RowClose();
        $this->TblClose();
    }

    //--------------------------------------------------------------------------
    // Delete row
    //--------------------------------------------------------------------------
    protected function DeleteRow($rid){
        $req_operation_randomize_code = $this->GetVariable("_operation_randomize_code", true, "post");
        if(!$this->CheckF5CaseValidation($req_operation_randomize_code)) return false;
        if(!$this->CheckSecurityCaseValidation("delete", "delete", "deleting")) return false;        
        
        $file_fileds_array = array();
        $this->rids = explode("-", $rid);
        $keys_list = "";
        $sql = "DELETE FROM ".$this->tblName." WHERE ".$this->primaryKey." IN ('-1' ";         
        foreach ($this->rids as $key){
            $key = (count($this->rids) > 1) ? $this->DecodeParameter($key) : $key;
            $keys_list .= ($keys_list != "") ? ",".$key : $key;
            $sql .= ", '".$key."' ";
        }
        $sql .= ");";        
        
        if(!$this->isDemo){
            $this->PrepareFileFields($file_fileds_array, $sql);
            $this->dbHandler->query($sql);
        }else{
            $dSet = null;
        }
        $affectedRows = $this->dbHandler->affectedRows();
        if($affectedRows > 0){
            $this->actMsg = ($this->arrDgMessages['delete'] != "") ? $this->arrDgMessages['delete'] : $this->lang['deleting_operation_completed'];                
            if(isset($_SESSION)) { $_SESSION[$this->uniquePrefix.'_operation_randomize_code'] = $req_operation_randomize_code; }
            $this->isOperationCompleted = true;
            $this->DeleteFileFields($file_fileds_array);
        }else{
            $this->isWarning = true;
            if(!$this->isDemo) $this->actMsg = $this->lang['deleting_operation_uncompleted'];
            else $this->actMsg = "Deleting operation is blocked in demo version";            
            if(isset($_SESSION)) { $_SESSION[$this->uniquePrefix.'_operation_randomize_code'] = ""; }
            $this->isOperationCompleted = false;   
        }
        if($this->debug) $this->sqlStatements[] = "<table width='".$this->tblWidth[$this->mode]."'><tr><td align='left' class='".$this->cssClass."_dg_error_message no_print' style='COLOR: #333333;'><b>delete sql (".Helper::ConvertCase($this->lang['total'],"lower",$this->langName).": ".$affectedRows.") </b>".$sql."</td></tr></table>";        
        if($this->debug) $this->actMsg .= " ".$this->lang['record_n']." ".$keys_list;                    
    }

    //--------------------------------------------------------------------------
    // Update row
    //--------------------------------------------------------------------------
    protected function UpdateRow($rid){ 
        $req_operation_randomize_code = $this->GetVariable("_operation_randomize_code", true, "post");
        if(!$this->CheckF5CaseValidation($req_operation_randomize_code)) return false;
        if(!$this->CheckSecurityCaseValidation("edit", "update", "updating")) return false;        
        
        // if we have more that 1 row selected
        $rids = explode("-", $rid);
        $unique_field_found = false;
        $field_header = "";
        $field_count = "0";
        $keys_list = "";
            
        foreach ($rids as $key){
            $key = (count($rids) > 1) ? $this->DecodeParameter($key) : $key;
            // check for unique fields
            foreach($this->columnsEditMode as $fldName => $fldValue){
                $fp_unique = $this->GetFieldProperty($fldName, "unique");
                if(($fldName != "") && ($fp_unique === true || $fp_unique == "true")){
                    $field_prefix = "syy";                    
                    if(isset($fldValue['req_type'])){
                        if(strlen(trim($fldValue['req_type'])) == 3){ $field_prefix = $fldValue['req_type']; }
                        else if(strlen(trim($fldValue['req_type'])) == 2){ $field_prefix = $fldValue['req_type']."y"; }
                    }                
                    $field_header     = (isset($fldValue['header'])) ? $fldValue['header'] : $fldName;
                    $unique_condition = (isset($fldValue['unique_condition'])) ? trim($fldValue['unique_condition']) : "" ;
                    if(count($rids) <= 1){
                        $field_value = (isset($_POST[$field_prefix.$fldName])) ? $_POST[$field_prefix.$fldName] : "";                        
                    }else{
                        $field_value = (isset($_POST[$field_prefix.$fldName."_".$key])) ? $_POST[$field_prefix.$fldName."_".$key] : "";                                                
                    }
                    $sql = "SELECT COUNT(*) as count FROM $this->tblName WHERE $this->primaryKey <> '$key' AND $fldName = '$field_value'";
                    if($unique_condition != "") $sql .= " AND ".$unique_condition." ";
                    if($field_value != "" && ($field_count = $this->SelectSqlItem($sql)) > 0){
                        $unique_field_found = true;
                        break;
                    }
                }            
            }
            if($unique_field_found) break;
        }

        if(!$unique_field_found){            
            // prepare UPDATE SQL for each key
            foreach ($rids as $key){
                $key = (count($rids) > 1) ? $this->DecodeParameter($key) : $key;
                $keys_list .= ($keys_list != "") ? ",".$key : $key;

                // create update statment
                $sql = "UPDATE $this->tblName SET ";
                $ind = 0;
                $this->AddCheckBoxesValues(((count($rids) > 1) ? "_".$key : ""));            
                $max = count($_POST);
                foreach($_POST as $fldName => $fldValue){
                    
                    // check multirow postfix and remove them
                    if(count($rids) > 1){
                        if(preg_match("/_".$key."/", $fldName)){                                
                            $fldName = str_replace("_".$key, "", $fldName);
                        }else{
                            continue;    
                        }                            
                    }
                    
                    // update all fields, excepting uploading fields                    
                    if(!$this->isExceptedField($fldName)){
                        $fldName = substr($fldName, 3, strlen($fldName));
                        $fldValue = $this->IsDatePrepare($fldName,$fldValue);
                        if(!$this->IsReadonly($fldName) && !$this->IsValidator($fldName)){
                            if (intval($ind) >= 1) $sql .= ", ";                            
                            if($this->IsDate($fldName)) {
                                if(trim($fldValue) != ""){
                                    $sql .= "$fldName = '".$fldValue."'";
                                }else{
                                    $sql .= "$fldName = NULL";    
                                }                        
                            }else if($this->IsPassword($fldName)){
                                $fldValue_new = $this->IsPasswordCrypted($fldName, $fldValue);
                                $sql .= "$fldName = ".$fldValue_new." ";
                            }else if($this->IsMoney($fldName)){
                                $fldValue_new = $this->SetMoneyFormat($fldName, $fldValue);
                                $sql .= "$fldName = '".$fldValue_new."' ";
                            }else if($this->IsText($fldName)){                                
                                $fldValue_new = $fldValue;
                                if(is_array($fldValue)){    // it was a multiple enum
                                    $count = 0; $fldValue_new = "";
                                    foreach ($fldValue as $val){ if($count++ > 0) $fldValue_new .= ","; $fldValue_new .= $val; }
                                }
                                $sql .= "$fldName = '".$this->SetRealEscapeStringByDbType($fldValue_new)."' ";
                            }else{
                                if(trim($fldValue) != ""){
                                    $sql .= "$fldName = '".$fldValue."'";
                                }else if($this->IsFieldRequired($fldName)){
                                    $sql .= "$fldName = '0'";    
                                }else{
                                    $sql .= "$fldName = 'NULL'";    
                                }                        
                            }
                            $ind++;                            
                        }                        
                    }
                }
                $sql .= " WHERE $this->primaryKey = '".$key."'";                
                
                if(!$this->isDemo){
                    $this->dbHandler->query($sql);
                    $affectedRows = $this->dbHandler->affectedRows();
                }else{
                    $dSet = null;
                    $affectedRows = -1;
                }            
                if($affectedRows >= 0){
                    $this->actMsg = ($this->arrDgMessages['update'] != "") ? $this->arrDgMessages['update'] : $this->lang['updating_operation_completed'];                
                    if(isset($_SESSION)) { $_SESSION[$this->uniquePrefix.'_operation_randomize_code'] = $req_operation_randomize_code; }
                    $this->isOperationCompleted = true;                
                }else{
                    $this->isWarning = true;
                    if(!$this->isDemo) $this->actMsg = $this->lang['updating_operation_uncompleted'];
                    else $this->actMsg = "Updating operation is blocked in demo version";                
                    if(isset($_SESSION)) { $_SESSION[$this->uniquePrefix.'_operation_randomize_code'] = ""; }
                    $this->isOperationCompleted = false;   
                }
                if($this->debug) $this->sqlStatements[] = "<table width='".$this->tblWidth[$this->mode]."'><tr><td align='left' class='".$this->cssClass."_dg_error_message no_print' style='COLOR: #333333;'><b>update sql #".$key." (".Helper::ConvertCase($this->lang['total'],"lower",$this->langName).": ".$affectedRows.") </b>".$sql."</td></tr></table>";
            }
        }else{
            $this->isWarning = true;            
            $this->actMsg = str_replace("_FIELD_", $field_header, $this->lang['unique_field_error']);               
            if($this->debug) $this->sqlStatements[] = "<table width='".$this->tblWidth[$this->mode]."'><tr><td align='left' class='".$this->cssClass."_dg_error_message no_print' style='COLOR: #333333;'><b>select sql (".Helper::ConvertCase($this->lang['total'],"lower",$this->langName).": ".$field_count.") </b>".$sql."</td></tr></table>";                    
        }
        if($this->debug) $this->actMsg .= " ".$this->lang['record_n']." ".$keys_list;                                
    }

    //--------------------------------------------------------------------------
    // Add row
    //--------------------------------------------------------------------------
    protected function AddRow(){
        $req_operation_randomize_code = $this->GetVariable("_operation_randomize_code", true, "post");
        if(!$this->CheckF5CaseValidation($req_operation_randomize_code)) return false;
        if(!$this->CheckSecurityCaseValidation("add", "add_new", "adding")) return false;        
        
        $unique_field_found = false;
        $field_header = "";
        $field_count = "0";
        $dSet = "";
        
        // check for unique fields
        foreach($this->columnsEditMode as $fldName => $fldValue){
            $fp_unique = $this->GetFieldProperty($fldName, "unique");
            if(($fldName != "") && ($fp_unique === true || $fp_unique == "true")){
                $field_prefix = "syy";                    
                if(isset($fldValue['req_type'])){
                    if(strlen(trim($fldValue['req_type'])) == 3){ $field_prefix = $fldValue['req_type']; }
                    else if(strlen(trim($fldValue['req_type'])) == 2){ $field_prefix = $fldValue['req_type']."y"; }
                }                
                $field_header =     (isset($fldValue['header'])) ? $fldValue['header'] : $fldName;
                $unique_condition = (isset($fldValue['unique_condition'])) ? trim($fldValue['unique_condition']) : "" ;
                $field_value =      (isset($_POST[$field_prefix.$fldName])) ? $_POST[$field_prefix.$fldName] : "";                                 
                $sql = "SELECT COUNT(*) as count FROM $this->tblName WHERE $fldName = '$field_value' ";
                if($unique_condition != "") $sql .= " AND ".$unique_condition." ";
                if(($field_count = $this->SelectSqlItem($sql)) > 0){
                    $unique_field_found = true;
                    break;
                }
            }            
        }
        // create insert statment
        if(!$unique_field_found){
            $this->AddCheckBoxesValues();                    
            $sql = "INSERT INTO $this->tblName (";
                $ind = 0;
                $max = count($_POST);
                if($this->dbHandler->phptype == "oci8"){ $sql .= strtoupper($this->primaryKey).", "; }
                foreach($_POST as $fldName => $fldValue){
                    $ind ++;
                    // all fields, excepting uploading fields
                    if(!$this->isExceptedField($fldName)){
                        if(!$this->IsValidator($fldName)){
                            $fldName = substr($fldName, 3, strlen($fldName));
                            $sql .= "$fldName";
                            if (intval($ind) < intval($max) ) $sql .= ", ";
                        }
                    }
                }
            $sql .= ") VALUES (";
                $ind = 0;
                $max = count($_POST);
                if($this->dbHandler->phptype == "oci8"){ $sql .= "(SELECT CONTROL.next_id_operador FROM CONTROL), "; }
                foreach($_POST as $fldName => $fldValue){
                    $ind ++;
                    // all fields, excepting uploading fields
                    if(!$this->isExceptedField($fldName)){
                        if(!$this->IsValidator($fldName)){
                            $fldName = substr($fldName, 3, strlen($fldName));                    
                            $fldValue = $this->IsDatePrepare($fldName, $fldValue);                                                        
                            if($this->IsDate($fldName)) {
                                if(trim($fldValue) != ""){
                                    $sql .=  "'".$fldValue."'";
                                }else{
                                    $sql .= 'NULL';    
                                }                                                        
                            }else if($this->IsPassword($fldName)){
                                $fldValue_new = $this->IsPasswordCrypted($fldName, $fldValue);
                                $sql .= $fldValue_new." ";
                            }else if($this->IsMoney($fldName)){
                                $fldValue_new = $this->SetMoneyFormat($fldName, $fldValue);
                                $sql .= "'".$fldValue_new."' ";
                            }else if($this->IsText($fldName)) {                            
                                if($fldValue != ""){
                                    $fldValue_new = $fldValue;
                                    if(is_array($fldValue)){    // it was a multiple enum
                                        $count = 0; $fldValue_new = "";
                                        foreach ($fldValue as $val){ if($count++ > 0) $fldValue_new .= ","; $fldValue_new .= $val; }
                                    }                                        
                                    $sql .=  "'".$this->SetRealEscapeStringByDbType($fldValue_new)."'";
                                }else if($this->IsFieldRequired($fldName)){
                                    $sql .= "' '";    
                                }else{
                                    $sql .= "''";    
                                }
                            }else{
                                if(trim($fldValue) != ""){
                                    if($this->dbHandler->phptype == "oci8") $sql .= $fldValue;
                                    else $sql .=  "'".$fldValue."'";
                                }else if($this->IsFieldRequired($fldName)){
                                    $sql .= '0';    
                                }else{
                                    $sql .= 'NULL';    
                                }                        
                            }
                            if (intval($ind) < intval($max) ) $sql .= ", ";
                        }                        
                    }
                }
            $sql .= ") ";
            if(!$this->isDemo){
                $dSet = $this->dbHandler->query($sql);
            }else{
                $dSet = null;
            }            
            $affectedRows = $this->dbHandler->affectedRows();
            if($this->debug) $this->sqlStatements[] = "<table width='".$this->tblWidth[$this->mode]."'><tr><td align='left' class='".$this->cssClass."_dg_error_message no_print' style='COLOR: #333333;'><b>insert sql (".Helper::ConvertCase($this->lang['total'],"lower",$this->langName).": ".$affectedRows.") </b>".$sql."</td></tr></table>";        
                
            if($affectedRows > 0){
                $this->actMsg = ($this->arrDgMessages['add'] != "") ? $this->arrDgMessages['add'] : $this->lang['adding_operation_completed'];                
                $res = $this->dbHandler->query("SELECT MAX(".$this->primaryKey.") as maximal_row FROM ".$this->tblName." ");
                $row = $res->fetchRow();
                $this->rid = $row[0];
                if($this->debug){
                    $this->actMsg .= " ".$this->lang['record_n']." ".$this->rid;
                }  
                if(isset($_SESSION)) { $_SESSION[$this->uniquePrefix.'_operation_randomize_code'] = $req_operation_randomize_code; }
                $this->isOperationCompleted = true;   
            }else{
                $this->isWarning = true;            
                if(!$this->isDemo) $this->actMsg = $this->lang['adding_operation_uncompleted'];
                else $this->actMsg = "Adding operation is blocked in demo version";
                if($this->dbHandler->isError($dSet) == 1){
                    $this->isError = true;
                    $this->AddErrors($dSet);
                }
                if(isset($_SESSION)) { $_SESSION[$this->uniquePrefix.'_operation_randomize_code'] = ""; }
                $this->isOperationCompleted = false;   
            }            
        }else{
            $this->isWarning = true;            
            $this->actMsg = str_replace("_FIELD_", $field_header, $this->lang['unique_field_error']);               
            if($this->debug) $this->sqlStatements[] = "<table width='".$this->tblWidth[$this->mode]."'><tr><td align='left'><b>select sql (".Helper::ConvertCase($this->lang['total'],"lower",$this->langName).": ".$field_count.") </b>".$sql."</td></tr></table>";                                
        }          

        $this->sql = "SELECT * FROM $this->tblName ";       
        $fsort = " ORDER BY ".$this->primaryKey." DESC";        
        $this->GetDataSet($fsort);
    }   

    //--------------------------------------------------------------------------
    // Check for F5 refresh case
    //--------------------------------------------------------------------------
    protected function CheckF5CaseValidation($req_operation_randomize_code = ""){
        if(isset($_SESSION[$this->uniquePrefix.'_operation_randomize_code']) && $req_operation_randomize_code != "" && ($_SESSION[$this->uniquePrefix.'_operation_randomize_code'] == $req_operation_randomize_code)){
            $this->isWarning = true;            
            $this->actMsg = $this->lang['operation_was_already_done'];
            return false;
        } return true;
    }

    //--------------------------------------------------------------------------
    // Check for security case
    //--------------------------------------------------------------------------
    protected function CheckSecurityCaseValidation($mode = "", $operation = "", $gerundy = ""){
        if(($this->modes[$mode]["view"] == false) && ($this->modes[$mode]["edit"] == false)){
            $this->isWarning = true;            
            if($this->debug){
                $this->actMsg = $this->lang[$operation.'_record_blocked'];
            }else{
                $this->actMsg = $this->lang[$gerundy.'_operation_uncompleted'];
            }
            return false;
        } return true;        
    }

    //--------------------------------------------------------------------------
    // Get field offset
    //--------------------------------------------------------------------------
    protected function GetFieldOffset($field_name){
        if(!$this->isError){
            $fields = $this->dataSet->tableInfo();
            for($ind=0; $ind < $this->dataSet->numCols(); $ind++){
                if($fields[$ind]['name'] === $field_name) return $ind;  
            }            
        }
        return -1;
    }

    //--------------------------------------------------------------------------
    // Check is field required
    //--------------------------------------------------------------------------
    protected function IsFieldRequired($field){        
        if(!$this->isError){
            $fields = $this->dataSet->tableInfo();                        
            if($this->GetFieldOffset($field) != -1){
                $flags = $fields[$this->GetFieldOffset($field)]['flags'];
                if(strstr(strtolower($flags), "not_null")){
                    return true;   
                }
            }
        }
        return false;
    }

    //--------------------------------------------------------------------------
    // Check if field excepted
    //--------------------------------------------------------------------------    
    protected function isExceptedField($field_name){        
        if(preg_match("/file_act/i", $field_name) ||
           preg_match("/ration_randomize_code/i", $field_name) ||
           preg_match("/__nc/i", $field_name)){                
                return true;
        }
        return false;
    }

    //--------------------------------------------------------------------------
    // Get field info
    //--------------------------------------------------------------------------
    protected function GetFieldInfo($field, $parameter='', $type=0){        
        if(!$this->isError){
            $fields = $this->dataSet->tableInfo();            
            if($type == 0){
                if($this->GetFieldOffset($field) != -1)
                   return $fields[$this->GetFieldOffset($field)][$parameter];
                else
                   return '';
            }else{
                return $fields[$field][$parameter];
            }
        }
        return -1;
    }   
   
    //--------------------------------------------------------------------------
    // Set datetime field in right format (dd-mm-yyyy)|(yyyy-mm-dd)
    //--------------------------------------------------------------------------
    protected function IsDatePrepare($field_name, $fldValue, $mode = "edit", $attr = "type"){
        $fp_type = $this->GetFieldProperty($field_name, $attr, $mode, "normal");
        switch ($fp_type){
            case 'date':        // date: DATE
            case 'datetime':    // date: DATE
                break;                
            case 'datetimedmy': // date: DATETIME 23-10-2009 14:58:00
                $time   = substr(trim($fldValue), 11, 8);
                $year   = substr(trim($fldValue), 6, 4);
                $month  = substr(trim($fldValue), 3, 2);
                $day    = substr(trim($fldValue), 0, 2);
                $fldValue = $year."-".$month."-".$day." ".$time;
                break;
            case 'datedmy':    // date: DATE 23-10-2009
                $year   = substr(trim($fldValue), 6, 4);
                $month  = substr(trim($fldValue), 3, 2);
                $day    = substr(trim($fldValue), 0, 2);
                $fldValue = $year."-".$month."-".$day;
                break;
            case 'datemdy':    // American format: DATE 10-23-2009
                $year   = substr(trim($fldValue), 6, 4);
                $month  = substr(trim($fldValue), 0, 2);
                $day    = substr(trim($fldValue), 3, 2);
                $fldValue = $year."-".$month."-".$day;
                break;
            default:
                break;
        }
        return $fldValue;
    }
    
    //--------------------------------------------------------------------------
    // Check if password crypted
    //--------------------------------------------------------------------------
    protected function IsPasswordCrypted($field_name, $fldValue){
        $fp_type = $this->GetFieldProperty($field_name, "type", "edit");
        $fp_cryptography = $this->GetFieldProperty($field_name, "cryptography", "edit");
        $fp_cryptography_type = $this->GetFieldProperty($field_name, "cryptography_type", "edit");
        $fp_aes_password = $this->GetFieldProperty($field_name, "aes_password", "edit");
        if($fp_type == "password" && ($fp_cryptography == true || $fp_cryptography == "true")){
            if($fp_cryptography_type == "md5"){
                return "'".md5($fldValue)."'";                
            }else if($fp_cryptography_type == "aes"){
                return "AES_ENCRYPT('".$fldValue."', '".$fp_aes_password."')";                
            }
        }
        return "'".$fldValue."'";    
    }

    //--------------------------------------------------------------------------
    // Set money format
    //--------------------------------------------------------------------------
    protected function SetMoneyFormat($field_name, $field_value){
        $fp_decimal_places   = $this->GetFieldProperty($field_name, "decimal_places", "view"); 
        $fp_dec_separator    = $this->GetFieldProperty($field_name, "dec_separator", "view"); 
        $fp_thousands_separator = $this->GetFieldProperty($field_name, "thousands_separator", "view");                        
        if($fp_thousands_separator == "." && $fp_dec_separator == ","){
            $field_value = str_replace(".", "#", $field_value);
            $field_value = str_replace(",", ".", $field_value);
            $field_value = str_replace("#", "", $field_value);
        }else if($fp_thousands_separator == "," && $fp_dec_separator == "."){
            $field_value = str_replace(",", "", $field_value);
        }
        return $field_value;
    }

    //--------------------------------------------------------------------------
    // Get money format
    //--------------------------------------------------------------------------
    protected function GetMoneyFormat($field_name, $field_value){
        if($field_value == "") return "";
        $fp_decimal_places   = $this->GetFieldProperty($field_name, "decimal_places", "view"); 
        $fp_dec_separator    = $this->GetFieldProperty($field_name, "dec_separator", "view"); 
        $fp_thousands_separator = $this->GetFieldProperty($field_name, "thousands_separator", "view");                        
        if($fp_thousands_separator == "." && $fp_dec_separator == ","){
            $field_value = str_replace(",", ".", $field_value);
            $field_value = number_format($field_value, $fp_decimal_places, $fp_dec_separator, $fp_thousands_separator);
        }
        return $field_value;
    }

    //--------------------------------------------------------------------------
    // Check if field type needs ''(text) or not (numeric...)
    //--------------------------------------------------------------------------
    protected function IsText($field_name){
        $field_type = $this->GetFieldInfo($field_name, 'type', 0);
        $result = true;
        switch (strtolower($field_type)){
            case 'int':     // int: TINYINT, SMALLINT, MEDIUMINT, INT, INTEGER, BIGINT, TINY, SHORT, LONG, LONGLONG, INT24
            case 'real':    // real: FLOAT, DOUBLE, DECIMAL, NUMERIC
            case 'null':    // empty: NULL
            case 'number':  // NUMBER - for oci8 (oracle)
                $result = false; break;
            case 'string':  // string: CHAR, VARCHAR, TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT, ENUM, SET, VAR_STRING
            case 'blob':    // blob: TINYBLOB, MEDIUMBLOB, LONGBLOB, BLOB, TEXT
            case 'date':    // date: DATE
            case 'timestamp':    // date: TIMESTAMP
            case 'year':    // date: YEAR
            case 'time':    // date: TIME
            case 'datetime':    // date: DATETIME
                $result = true; break;
            default:
                $result = true; break;
        }
        return $result;
    }

    //--------------------------------------------------------------------------
    // Check if field type is a date/time type
    //--------------------------------------------------------------------------
    protected function IsDate($field_name){
        $field_type = $this->GetFieldInfo($field_name, 'type', 0);
        $result = false;
        switch (strtolower($field_type)){
            case 'date':       // date: DATE
            case 'timestamp':  // date: TIMESTAMP
            case 'year':       // date: YEAR
            case 'time':       // date: TIME
            case 'datetime':   // date: DATETIME
                $result = true; break;
            default:
                $result = false; break;
        }
        return $result;
    }

    //--------------------------------------------------------------------------
    // Check if field type is a password
    //--------------------------------------------------------------------------
    protected function IsPassword($field_name){
        $fp_type = $this->GetFieldProperty($field_name, "type", "edit");
        return ($fp_type == "password") ? true : false; 
    }    
    
    //--------------------------------------------------------------------------
    // Check if field type is a money
    //--------------------------------------------------------------------------
    protected function IsMoney($field_name){
        $fp_type = $this->GetFieldProperty($field_name, "type", "edit");
        return ($fp_type == "money") ? true : false; 
    }    

    //--------------------------------------------------------------------------
    // Check if a field is readonly
    //--------------------------------------------------------------------------
    protected function IsReadonly($field_name){
        $fp_readonly = $this->GetFieldProperty($field_name, "readonly");
        if($fp_readonly == true){
            return true;
        }else{
            return false;
        }
    }    

    //--------------------------------------------------------------------------
    // Check if a field is validator
    //--------------------------------------------------------------------------
    protected function IsValidator($field_name){
        $validator_letter = substr($field_name, 1, 1);
        $validator_field = substr($field_name, 3, strlen($field_name));
        if($validator_letter == "v"){
            foreach($this->columnsEditMode as $key => $val){
                if(isset($val['type']) && $val['type'] == "validator" && $val['for_field'] == $validator_field){
                    return true;        
                }
            }            
        }
        return false;
    }    

    //--------------------------------------------------------------------------
    // Check if a field is a foreign key
    //--------------------------------------------------------------------------
    protected function IsForeignKey($field_name){
        if(array_key_exists($field_name, $this->arrForeignKeys)){
           return true; 
        }
        return false;
    }
    
    //--------------------------------------------------------------------------
    // Check if a field is a foreign key
    //--------------------------------------------------------------------------
    protected function IsEnum($field_name){
        if(isset($this->columnsEditMode[$field_name]["type"]) && $this->columnsEditMode[$field_name]["type"] == "enum"){
            return true;        
        }            
        return false;
    }    
    
    //--------------------------------------------------------------------------
    // Get foreign key input
    //--------------------------------------------------------------------------
    protected function GetForeignKeyInput($keyFieldValue, $fk_field_name, $fk_field_value, $mode="edit", $multirow_postfix = ""){
        $req_mode = $this->GetVariable('mode');

        // check if foreign key field is readonly or disabled
        $readonly = "";
        $disabled = "";
        $fp_pre_addition   = $this->GetFieldProperty($fk_field_name, "pre_addition", "edit");
        $fp_post_addition  = $this->GetFieldProperty($fk_field_name, "post_addition", "edit");        
        $fp_readonly = $this->GetFieldProperty($fk_field_name, "readonly");
        $fp_radiobuttons_alignment = "horizontal";        
        if(isset($this->arrForeignKeys[$fk_field_name]['radiobuttons_alignment']) && (strtolower($this->arrForeignKeys[$fk_field_name]['radiobuttons_alignment']) == "vertical")){
            $fp_radiobuttons_alignment = "vertical";        
        }
        if($req_mode == "edit"){
            if($fp_readonly == true){                
                $disabled = "disabled"; //$readonly = "readonly='readonly'";
            }
        }
        
        $sql  = " SELECT ".$fk_field_name."";
        $sql .= " FROM ".$this->tblName."";
        $sql .= " WHERE ".$this->primaryKey." = '".$keyFieldValue."' ";
        $this->dbHandler->setFetchMode(DB_FETCHMODE_ASSOC);
        $dSet = $this->dbHandler->query($sql);        
        if($this->dbHandler->isError($dSet) != 1){
            if($dSet->numRows() > 0){
                $row = $dSet->fetchRow();            
                $kFieldValue = $row[$fk_field_name];
            }else{
                $kFieldValue = -1;
            }
        }
        
        // select from outer table
        $sql  = " SELECT ".$this->arrForeignKeys[$fk_field_name]['field_key'].",".$this->arrForeignKeys[$fk_field_name]['field_name']." ";
        $sql .= " FROM ".$this->arrForeignKeys[$fk_field_name]['table']." ";
        $sql .= " WHERE 1=1 ";
        if($mode !== "edit"){
            $sql .= " AND ".$this->arrForeignKeys[$fk_field_name]['field_key']." = '".$kFieldValue."'";
        }
        if(isset($this->arrForeignKeys[$fk_field_name]['condition']) && ($this->arrForeignKeys[$fk_field_name]['condition'] != "")){
            $sql .= " AND " .$this->arrForeignKeys[$fk_field_name]['condition'];
        }
        // define sorting order
        if(isset($this->arrForeignKeys[$fk_field_name]['order_by_field']) && ($this->arrForeignKeys[$fk_field_name]['order_by_field'] != "")){
            $order_by_field = $this->arrForeignKeys[$fk_field_name]['order_by_field'];
        }else{
            $order_by_field = $this->arrForeignKeys[$fk_field_name]['field_key'];
        }
        // define sorting type
        $order_type = "DESC";
        if(isset($this->arrForeignKeys[$fk_field_name]['order_type'])){
            if(strtolower($this->arrForeignKeys[$fk_field_name]['order_type']) == "asc"){
                $order_type = "ASC";
            }
        }
        $sql .= " ORDER BY ".$order_by_field." ".$order_type;
        
        $dSet = $this->dbHandler->query($sql);

        if($this->dbHandler->isError($dSet) == 1){
            $this->isError = true;
            $this->AddErrors($dSet);
        }
       
        if($this->debug){
            if($this->dbHandler->isError($dSet) == 1){
                $num_rows = 0; 
            }else{
                $num_rows = $dSet->numRows();                
            }
            $this->sqlStatements[] = "<table width='".$this->tblWidth[$this->mode]."'><tr><td align='left' wrap><b>search sql (".Helper::ConvertCase($this->lang['total'],"lower",$this->langName).": ".$num_rows.") </b>". $sql."</td></tr></table>";            
        }       
      
        if($mode === "edit"){            
            // save entered values from fields in add/edit modes
            $req_field_value = $this->GetVariable($this->GetFieldRequiredType($fk_field_name).$fk_field_name, false, "post");            
            $on_js_event = (isset($this->arrForeignKeys[$fk_field_name]['on_js_event'])) ? $this->arrForeignKeys[$fk_field_name]['on_js_event'] : "";
            $view_type = (isset($this->arrForeignKeys[$fk_field_name]['view_type'])) ? $this->arrForeignKeys[$fk_field_name]['view_type'] : "";            
            if($view_type == "label"){ //'view_type"=>"label"
                while($row = $dSet->fetchRow()){
                    $ff_name = $this->arrForeignKeys[$fk_field_name]['field_name'];
                    $ff_key  = $this->arrForeignKeys[$fk_field_name]['field_key'];
                    if(preg_match("/ as /i", strtolower($ff_name))) $ff_name = substr($ff_name, strpos(strtolower($ff_name), " as ")+4);
                    if($row[$ff_key] === $kFieldValue){
                        return $this->nbsp.$fp_pre_addition.$row[$ff_name].$fp_post_addition.$this->nbsp;                 
                    }
                }
                return "";
            }else if($view_type == "textbox"){ //'view_type"=>"textbox"
                while($row = $dSet->fetchRow()){
                    $ff_name = $this->arrForeignKeys[$fk_field_name]['field_name'];
                    if(preg_match("/ as /i", strtolower($ff_name))) $ff_name = substr($ff_name, strpos(strtolower($ff_name), " as ")+4);
                    if($row[$ff_name] === $kFieldValue){
                        $kFieldValue = $row[$ff_name];
                        $kFieldValue = str_replace('"', "&quot;", $kFieldValue); // double quotation mark
                        $kFieldValue = str_replace("'", "&#039;", $kFieldValue); // single quotation mark                        
                    }
                }
                return "<input class='".$this->cssClass."_dg_textbox' type='text' title='".$this->GetFieldTitle($fk_field_name)."' id='".$this->GetFieldRequiredType($fk_field_name).$fk_field_name.$multirow_postfix."' name='".$this->GetFieldRequiredType($fk_field_name).$fk_field_name.$multirow_postfix."' value='".$kFieldValue."' $disabled ".$on_js_event." />";
            }else if($view_type == "radiobutton"){ //'view_type"=>"radiobutton"
                if($kFieldValue == "-1") $kFieldValue = $this->GetFieldProperty($fk_field_name, "default");
                return $this->DrawRadioButtons($this->GetFieldRequiredType($fk_field_name).$fk_field_name.$multirow_postfix, $fk_field_name, $dSet, $kFieldValue, 'field_key', 'field_name', $disabled, $on_js_event, $fp_radiobuttons_alignment);
            }else { //'view_type"=>"dropdownlist" - default   
                $req_field_name = $this->GetVariable($this->GetFieldRequiredType($fk_field_name).$fk_field_name, false, "post");                
                if($req_mode == "add"){
                    if($req_field_name != "") $new_field_value = $req_field_value;
                    else $new_field_value = $this->GetFieldProperty($fk_field_name, "default");
                }else {
                    if(($req_field_name != "") && ($fk_field_value == "")){
                        $new_field_value = $req_field_value;
                    }else if(($req_field_name != "") && ($fk_field_value != "")){ 
                        // to prevent loosing selection when we update 2nd grid
                        if($this->anotherDatagrids != ""){
                            $new_field_value = $fk_field_value;    
                        }else{
                            $new_field_value = $req_field_value;    
                        }
                    }else $new_field_value = $fk_field_value;
                }
                return $fp_pre_addition.$this->DrawDropDownList($this->GetFieldRequiredType($fk_field_name).$fk_field_name.$multirow_postfix, '', $dSet, $new_field_value, $fk_field_name, 'field_key', 'field_name', $disabled, $on_js_event).$fp_post_addition;
            }
        }else{
            if(!isset($dSet->message) || $dSet->message == ""){            
                $row = $dSet->fetchRow();
                $ff_name = $this->arrForeignKeys[$fk_field_name]['field_name']; 
                if (preg_match("/ as /i", strtolower($ff_name))) $ff_name = substr($ff_name, strpos(strtolower($ff_name), " as ")+4); 
                return $this->nbsp.$fp_pre_addition.$row[$ff_name].$fp_post_addition.$this->nbsp;                 
            }else{
                if(isset($dSet->message)){ echo $dSet->message; }
                if(isset($dSet->userinfo)){ echo $dSet->userinfo; }
                return "";
            }
        }        
    }

    ////////////////////////////////////////////////////////////////////////////
    // URL string creating
    ////////////////////////////////////////////////////////////////////////////
    //--------------------------------------------------------------------------
    // Set URL
    //--------------------------------------------------------------------------  
    protected function SetUrlString(&$curr_url, $filtering = "", $sorting = "", $paging ="", $amp=""){
        $amp = ($amp != "") ? $amp : $this->amp;
        if($filtering != "") $this->SetUrlStringFiltering($curr_url, $amp);
        if($sorting != "") $this->SetUrlStringSorting($curr_url, $amp);
        if($paging != "") $this->SetUrlStringPaging($curr_url, $amp);        
    }
    
    //--------------------------------------------------------------------------
    // Set URL string filtering
    //--------------------------------------------------------------------------  
    protected function SetUrlStringFiltering(&$curr_url, $amp=""){
        $amp = ($amp != "") ? $amp : $this->amp;
        if($this->ajaxEnabled) $amp = "&";
        $req_onSUBMIT_FILTER = $this->GetVariable('_ff_onSUBMIT_FILTER');

        if($this->filteringAllowed){
            foreach($this->arrFilterFields as $fldName => $fldValue){
                $fp_field_type = $this->GetFieldProperty($fldName, "field_type", "filter", "normal");
                if($fp_field_type != "") $fp_field_type = "_fo_".$fp_field_type;                    

                // get extension for from/to fields
                $table_field_name = str_replace(".", "_d_", $fldValue['table'])."_".$fldValue['field'];
                // split if there is a complicated filed like (last_name, first_name)
                if(preg_match("/\,/", $table_field_name)){
                    $table_field_name_split = explode(",", $table_field_name);
                    $table_field_name = $table_field_name_split[0];
                }
                
                // full name of field in URL    
                $field_name_in_url = $this->uniquePrefix."_ff_".$table_field_name.$fp_field_type;
                $filter_field_value = (isset($_REQUEST[$field_name_in_url]) && !is_array($_REQUEST[$field_name_in_url])) ? stripcslashes($_REQUEST[$field_name_in_url]) : "";                    
                if($filter_field_value != ""){
                    $curr_url .= $amp.$field_name_in_url."=".urlencode($filter_field_value)."";
                }
                
                $table_field_name_operator = $table_field_name."_operator";
                // full operator name in URL
                $operator_name_in_url = $this->uniquePrefix."_ff_".$table_field_name_operator.$fp_field_type;                
                if(isset($_REQUEST[$operator_name_in_url]) && ($_REQUEST[$operator_name_in_url] != "")){
                    $curr_url .= $amp.$operator_name_in_url."=".urlencode($_REQUEST[$operator_name_in_url]).""; 
                }
            }
            if(isset($_REQUEST[$this->uniquePrefix."_ff_".'selSearchType']) && (trim($_REQUEST[$this->uniquePrefix."_ff_".'selSearchType']) != ""))
                $curr_url .= $amp.$this->uniquePrefix."_ff_"."selSearchType=".urlencode($_REQUEST[$this->uniquePrefix."_ff_".'selSearchType'])."";            
            if($req_onSUBMIT_FILTER != "")
                $curr_url .= $amp.$this->uniquePrefix."_ff_"."onSUBMIT_FILTER=search";    
        }
    }

    //--------------------------------------------------------------------------
    // Set URL string sorting 
    //--------------------------------------------------------------------------  
    protected function SetUrlStringSorting(&$curr_url, $amp=""){
        $amp = ($amp != "") ? $amp : $this->amp;
        if($this->ajaxEnabled) $amp = "&";
        $sort_field = $this->GetVariable('sort_field');
        $sort_field_by = $this->GetVariable('sort_field_by');
        $sort_field_type = $this->GetVariable('sort_field_type');
        $sort_type = $this->GetVariable('sort_type');                
        if(isset($this->defaultSortFieldHelp )) { $this->defaultSortField[0] = $this->defaultSortFieldHelp; }
        if(isset($this->defaultSortTypeHelp )) { $this->defaultSortType[0] = $this->defaultSortTypeHelp; }
        if($sort_field != "") {
           $this->sortField = $sort_field;
           $this->sort_field_by = $sort_field_by;
           $this->sort_field_type = $sort_field_type;
           $curr_url .= $amp.$this->uniquePrefix."sort_field=".$this->sortField.$amp.$this->uniquePrefix."sort_field_by=".$this->sort_field_by.$amp.$this->uniquePrefix."sort_field_type=".$this->sort_field_type;
        }else {
            //d 30.01.09 if(!is_numeric($this->defaultSortField[0])){ $this->defaultSortField[0] = $this->GetFieldOffset($this->defaultSortField[0]) + 1; }
            $curr_url .= $amp.$this->uniquePrefix."sort_field=".$this->defaultSortField[0];
        }; // make pKey      
        if($sort_type != "") {
            $this->sortType = $sort_type;
            $curr_url .= $amp.$this->uniquePrefix."sort_type=".$this->sortType;
        } else {
            $curr_url .= $amp.$this->uniquePrefix."sort_type=".$this->defaultSortType[0];
        };          
    }

    //--------------------------------------------------------------------------
    // Set URL string pading
    //--------------------------------------------------------------------------  
    protected function SetUrlStringPaging(&$curr_url, $amp=""){
        $amp = ($amp != "") ? $amp : $this->amp;
        if($this->ajaxEnabled) $amp = "&";
        $page_size = $this->GetVariable('page_size');
        $p = $this->GetVariable('p');
        if($this->layouts['edit'] == "0"){            
            if($page_size != ""){
                $this->reqPageSize = $page_size;
                $curr_url .= $amp.$this->uniquePrefix."page_size=".$this->reqPageSize;
            }else{ 
                $curr_url .= $amp.$this->uniquePrefix."page_size=".$this->reqPageSize;
            }            
        }else{            
            if($this->mode === "view"){
                $curr_url .= $amp.$this->uniquePrefix."page_size=".$this->reqPageSize;
            }else{ 
                if($page_size != ""){
                    $this->reqPageSize = $page_size;
                }else{
                    if($this->mode == "edit"){
                        $this->reqPageSize = $this->defaultPageSize;
                    }
                }
                $curr_url .= $amp.$this->uniquePrefix."page_size=".$this->reqPageSize;
            }
        }
        if($p != "") {
            $this->pageCurrent = $p;
            $curr_url .= $amp.$this->uniquePrefix."p=".$this->pageCurrent;
        }else {
            $this->pageCurrent = 1;
            $curr_url .= $amp.$this->uniquePrefix."p=1";
        };
    } 

    ////////////////////////////////////////////////////////////////////////////
    // View & Edit mode methods
    ////////////////////////////////////////////////////////////////////////////
    //--------------------------------------------------------------------------
    // Get enum values
    //--------------------------------------------------------------------------
    protected function GetEnumValues( $table , $field ){
        $enum_array = "";
        $query = " SHOW COLUMNS FROM $table LIKE '$field' ";
        $this->dbHandler->setFetchMode(DB_FETCHMODE_ORDERED);  
        $result = $this->dbHandler->query($query);
        if($this->dbHandler->isError($result) != 1){
            if($row = $result->fetchRow()){
                // extract the values, the values are enclosed in single quotes and separated by commas
                $regex = "/'(.*?)'/";
                preg_match_all( $regex , $row[1], $enum_array );            
                $temp_enum_fields = $enum_array[1];
                $enum_fields = array();

                foreach($temp_enum_fields as $key => $val){
                    $enum_fields[$val] = $val;
                }
                return $enum_fields ;
            }            
        }
        return array();
    } 
  
    //--------------------------------------------------------------------------
    // Check if field exists & can be viewed
    //--------------------------------------------------------------------------
    protected function CanViewField($field_name){
        $fp_visible =  $this->GetFieldProperty($field_name, "visible", $this->mode, "lower", "true");      
        if($this->mode === "view"){
            if(array_key_exists($field_name, $this->columnsViewMode) && ($fp_visible == true)) return true;    
        }else if($this->mode === "edit"){
            if(array_key_exists($field_name, $this->columnsEditMode) && ($fp_visible == true)) return true;    
        }else if($this->mode === "details"){
            if(array_key_exists($field_name, $this->columnsEditMode) && ($fp_visible == true)) return true;    
        }else if($this->mode === "add"){
            if(array_key_exists($field_name, $this->columnsEditMode) && ($fp_visible == true)) return true;    
        }
        return false;
    }
    
    //--------------------------------------------------------------------------
    // Check if field exists & can be viewed
    //--------------------------------------------------------------------------
    protected function GetHeaderName($field_name, $force_simple = false){
        $force_simple = (($force_simple == true) || ($force_simple == "true")) ? true : false ;
        $fp_header = $this->GetFieldProperty($field_name, "header", $this->mode, "normal");
        if($this->mode === "view"){
            if(array_key_exists($field_name, $this->columnsViewMode) && ($fp_header != "")){
                return $fp_header;
            }
        }else if($this->mode === "edit"){
            if(array_key_exists($field_name, $this->columnsEditMode)){
                if($fp_header == "") $fp_header = $field_name;
                if((substr($this->GetFieldRequiredType($field_name), 0, 1) == "r") && (!$force_simple)){
                    return ucfirst($fp_header)." <font color='#cd0000'>*</font> ";
                }else{
                    return $fp_header;
                }
            }                
        }else if($this->mode === "details"){
            if(array_key_exists($field_name, $this->columnsEditMode) && ($fp_header != "")){
                return $fp_header;
            }
        }        
        return $field_name;
    }

    //--------------------------------------------------------------------------
    // Returns field name
    //--------------------------------------------------------------------------
    protected function GetFieldName($field_offset){
        if(!$this->isError){
            $fields = $this->dataSet->tableInfo();
            $field_name = isset($fields[$field_offset]['name']) ? $fields[$field_offset]['name'] : "";            
            if($field_name) return $field_name;
        }
        return $field_offset;
    }  

    //--------------------------------------------------------------------------
    // Get field required type
    //--------------------------------------------------------------------------
    protected function GetFieldRequiredType($field_name, $validator=false){
        $field_prefix = "syy";
        $field_req_type = trim($this->GetFieldProperty($field_name, "req_type"));
        if($field_req_type != ""){
            if(strlen($field_req_type) == 3){ $field_prefix = $field_req_type; }
            else if(strlen($field_req_type) == 2){
                $field_prefix = $field_req_type."y";
            }
        }
        if($validator) $field_prefix[1] = "v";
        return $field_prefix;
    }

    //--------------------------------------------------------------------------
    // Get field property
    //--------------------------------------------------------------------------
    protected function GetFieldProperty($field_name, $property_name, $mode = "edit", $case = "normal", $return_value = ""){
        switch($mode){
            case "view":
                if(isset($this->columnsViewMode[$field_name][$property_name])){
                    if($case === "lower"){
                        $return_value =  strtolower($this->columnsViewMode[$field_name][$property_name]);
                    }else{
                        $return_value = $this->columnsViewMode[$field_name][$property_name];
                    }
                }            
                break;
            case "filter":
                if(isset($this->arrFilterFields[$field_name][$property_name])){
                    if($case === "lower"){
                        $return_value = strtolower($this->arrFilterFields[$field_name][$property_name]);
                    }else{
                        $return_value = $this->arrFilterFields[$field_name][$property_name];
                    }
                }            
                break;
            case "details":
            case "edit":
            default:
                if(isset($this->columnsEditMode[$field_name][$property_name])){
                    if($case === "lower"){                        
                        if(is_array($this->columnsEditMode[$field_name][$property_name])){
                            return $this->columnsEditMode[$field_name][$property_name];
                        }else{
                            $return_value = strtolower($this->columnsEditMode[$field_name][$property_name]);
                        }                        
                    }else{
                        $return_value = $this->columnsEditMode[$field_name][$property_name];
                    }
                }
                break;
        }
        if($return_value === "true"){
            $return_value = true;
        }else if($return_value === "false"){
            $return_value = false;
        }
        return $return_value;        
    }

    //--------------------------------------------------------------------------
    // Get field title
    //--------------------------------------------------------------------------
    protected function GetFieldTitle($field_name, $mode="edit"){
        $field_title = $this->GetFieldProperty($field_name, "title", $mode, "");
        if($field_title === ""){
            $field_header = $this->GetFieldProperty($field_name, "header", $mode);
            if($field_header === ""){
                return $field_name;            
            }else{
                return str_replace("'", "&#039;", $field_header);            
            }            
        }else{
            return $field_title;
        }
    }

    //--------------------------------------------------------------------------
    // Get field alignment
    //--------------------------------------------------------------------------
    protected function GetFieldAlign($ind, $row, $mode="view"){
        $field_name = $this->GetFieldName($ind);
        $field_align = $this->GetFieldProperty($field_name, "align", $mode);
        if($mode == "edit" && $field_align == ""){
            return "left";
        }else if($field_align != ""){
            return $field_align;            
        }else{            
            if(isset($row[$ind]) && $this->IsText($field_name)){
                return ($this->direction == "ltr")?"left":"right";
            }else{
                return ($this->direction == "ltr")?"right":"left";
            }
        }
    }

    //--------------------------------------------------------------------------
    // Get header alignment
    //--------------------------------------------------------------------------
    protected function GetHeaderAlign($field_name){
        $header_align = $this->GetFieldProperty($field_name, "header_align", "view", "normal", "");
        if($header_align == ""){
            $header_align = $this->GetFieldProperty($field_name, "align", "view", "normal", "center");
        }
        return $header_align;
    }

    //--------------------------------------------------------------------------
    // Get Record ID for selected row
    //--------------------------------------------------------------------------
    protected function GetRecordID($row){
        return intval($row[(($this->GetFieldOffset($this->primaryKey) != -1) ? $this->GetFieldOffset($this->primaryKey) : 0)]);
    }

    //--------------------------------------------------------------------------
    // Get field value by type
    //--------------------------------------------------------------------------
    protected function GetFieldValueByType($field_value, $ind, $row, $field_name="", $m_field_req_type="", $mode="", $multirow_postfix=""){
        // Un-quote string quoted by SetRealEscapeStringByDbType()
        if(get_magic_quotes_gpc()) {
            if(ini_get('magic_quotes_sybase')) {
                $field_value = str_replace("''", "'", $field_value);
            } else {
                // [#0013] - remove! $field_value = str_replace("''", "'", $field_value);                
                // [#0007] - START solves problem with single quote when $dgrid->allowRealEscape = false;
                if($this->allowRealEscape == false){
                    $field_value = str_replace("'", "&#039;", $field_value);
                }
                // [#0007] - END
                if(!is_array($field_value)) $field_value = stripslashes($field_value);
            }
        }        
        
        $req_mode  = $this->GetVariable('mode');
        if($mode == "") $mode = $this->mode;
      
        if($field_name == "") $field_name = $this->GetFieldName($ind);
        // -= VIEW MODE =-
        if($mode === "view"){
            if(array_key_exists($field_name, $this->columnsViewMode)){
                
                $fp_tooltip = $this->GetFieldProperty($field_name, "tooltip", "view");
                $fp_tooltip_type = $this->GetFieldProperty($field_name, "tooltip_type", "view");
                $fp_pre_addition    = $this->GetFieldProperty($field_name, "pre_addition", "view");
                $fp_post_addition   = $this->GetFieldProperty($field_name, "post_addition", "view");
                $fp_on_item_created = $this->GetFieldProperty($field_name, "on_item_created", "view");
                $fp_text_length     = $this->GetFieldProperty($field_name, "text_length", "view");
                $fp_type            = $this->GetFieldProperty($field_name, "type", "view");
                $fp_case            = $this->GetFieldProperty($field_name, "case", "view");
                $on_js_event                    = $this->GetFieldProperty($field_name, "on_js_event", "view", "normal");                
                $fp_hide            = $this->GetFieldProperty($field_name, "hide", "view");
                
                // customized working with field value
                if(function_exists($fp_on_item_created)){
                    //ini_set("allow_call_time_pass_reference", true); 
                    $field_value = $fp_on_item_created($field_value);
                }
                
                $title = "";
                if(($fp_text_length != "-1") && ($fp_text_length != "") && ($field_value != "")){
                    if((strlen($field_value)) > $fp_text_length){
                        $field_value = str_replace('"', "&quot;", $field_value); // double quotation mark
                        $field_value = str_replace("'", "&#039;", $field_value); // single quotation mark 
                        $field_value = str_replace(chr(13), "", $field_value);   // CR sign
                        $field_value = str_replace(chr(10), " ", $field_value);  // LF sign                    
                        if(!$this->isPrinting){
                            if(($fp_tooltip == true) || ($fp_tooltip == "true")){
                                if($fp_tooltip_type == "floating"){
                                    $field_value_slashed = str_replace("&#039;", "\'", $field_value);
                                    $title = " onmouseover=\"return overlib('".$field_value_slashed."');\" onmouseout='return nd();' style='cursor: help;'";	                            
                                }else{
                                    $title = "title='".$field_value."' style='cursor: help;'";
                                }
                            }                        
                        }
                        $field_value = substr($field_value, 0, $fp_text_length)."...";
                    }
                }
                
                $field_type = ($fp_type == "") ? "label" : $fp_type;
                // format case of field value
                if(strtolower($fp_case) == "upper"){
                    $field_value = Helper::ConvertCase($field_value,"upper",$this->langName);
                }else if(strtolower($fp_case) == "lower"){
                    $field_value = Helper::ConvertCase($field_value,"lower",$this->langName);
                }else if(strtolower($fp_case) == "camel"){
                    $field_value = Helper::ConvertCase($field_value,"camel",$this->langName);
                }
                if($this->isPrinting){ $field_type = "label"; }                                                    

                switch($field_type){
                    case "barchart":
                        $fp_field         = $this->GetFieldProperty($field_name, "field", "view");
                        $fp_maximum_value = $this->GetFieldProperty($field_name, "maximum_value", "view");
                        if($fp_maximum_value == 0) $fp_maximum_value = 1;
                        $fp_display_type  = $this->GetFieldProperty($field_name, "display_type", "view");
                        if(($fp_field != "") && ($this->GetFieldOffset($fp_field) != -1)) $field_value = $row[$this->GetFieldOffset($fp_field)];
                        $inner_width = ($field_value/$fp_maximum_value * 100);                        
                        if($inner_width > 66) $inner_color = "#d0f0d0";
                        else if($inner_width > 33) $inner_color = "#f0f0d0";
                        else $inner_color = "#f0d0d0";                        
                        if($fp_display_type == "vertical"){
                            $barchart_result ="
                            <table height='120px' style='border:0px;' align='center' cellpadding='0' cellspacing='0' ".$on_js_event.">
                            <tr>
                                <td valign='bottom' align='center'>".(($field_value >= 0) ? $field_value : "")."                            
                                    <table width='20px;' style='background-color:#efefef;border:1px solid #cccccc;' align='center' cellpadding='0' cellspacing='0' ".$on_js_event.">
                                    <tr><td align='center' height='".$inner_width."px' bgcolor='".$inner_color."' class='dg_nowrap'></td></tr>
                                    </table>
                                </td>
                            </tr>
                            </table>";
                        }else{
                            $barchart_result ="
                            <table width='110px;' height='10px;' style='background-color:#efefef;border:1px solid #cccccc;' align='center' cellpadding='0' cellspacing='0' ".$on_js_event.">
                            <tr title='".$field_value."'><td style='FONT-SIZE:9px;' width='".$inner_width."px' align='center' bgcolor='".$inner_color."' class='dg_nowrap'>".(($field_value > 0) ? $field_value : "")."</td>";
                            if((100 - $inner_width) > 0){
                                $barchart_result .= "<td style='FONT-SIZE:9px;' width='".(100 - $inner_width)."px' align='center' class='dg_nowrap'>".(($field_value == 0) ? $field_value : "")."</td>";                                
                            }
                            $barchart_result .= "</tr></table>";
                        }
                        return $fp_pre_addition.$barchart_result.$fp_post_addition;
                        break;
                    case "blob":
                        $sizeinbytes = strlen($field_value);
                        return $fp_pre_addition.$this->nbsp."[BLOB] - ".$sizeinbytes." B".$this->nbsp.$fp_post_addition;
                        break;
                    case "checkbox":
                        $checked = "";
                        $full_field_name = "sy".$field_name.$multirow_postfix;
                        $row_id = $this->GetRecordID($row);
                        $fp_true_value = $this->GetFieldProperty($field_name, "true_value", "view");
                        $fp_false_value = $this->GetFieldProperty($field_name, "false_value", "view");
                        $fp_readonly = $this->GetFieldProperty($field_name, "readonly", "view");                         
                        $pk_value = isset($row[$this->GetFieldOffset($this->primaryKey)]) ? "_".$row[$this->GetFieldOffset($this->primaryKey)] : "";
                        if($fp_readonly == true) $readonly = "disabled";
                        else $readonly = "";                 

                        $new_field_value = $fp_true_value;
                        if(($fp_true_value !== "") && ($fp_false_value !== "")){
                            if($field_value == $fp_true_value){
                                $checked = "checked";
                                $new_field_value = $fp_false_value;
                            }else{
                                $new_field_value = $fp_true_value;
                            }
                        }
                        $c_curr_url = "";
                        $curr_url = $this->CombineUrl("update", $row_id, $this->amp); 
                        $this->SetUrlString($c_curr_url, "filtering", "sorting", "paging", $this->amp);
                        $curr_url .= $c_curr_url;
                        $on_change = "onclick='".$this->uniquePrefix."toggleStatus(\"$curr_url\", \"$field_name\", \"\", \"$new_field_value\");'";
                        return $fp_pre_addition.$this->nbsp."<input ".$on_change." class='".$this->cssClass."_dg_checkbox' type='checkbox' name='".$full_field_name."' id='".$full_field_name.$pk_value."' title='".$this->GetFieldTitle($field_name)."' value='".trim($field_value)."' ".$checked." ".$readonly." ".$on_js_event." />".$this->nbsp.$fp_post_addition;
                        break;
                    case "color":
                        $fp_view_type = $this->GetFieldProperty($field_name, "view_type", "view");
                        $color_name = Helper::GetColorNameByValue($field_value);
                        switch($fp_view_type){
                            case "image":
                                $ret_color = "<table align='center' cellspacing='0' cellpadding='0' border='0'><tr><td title='".$color_name."'><div style='border:1px solid #cecece;width:17px;height:17px;background-color:".$field_value.";layer-background-color:".$field_value.";'></div></td><td align='right' width='55px'><label class='".$this->cssClass."_dg_label'>".$field_value."</label></td></tr></table>";
                                break;                                
                            case "text":
                            default:
                                $ret_color = $field_value;
                                break;                                
                        }                        
                        return $fp_pre_addition.$ret_color.$fp_post_addition;
                        break;                        
                    case "enum":
                        if (is_array($this->columnsViewMode[$field_name]["source"])){
                           return $fp_pre_addition.$this->nbsp.$this->columnsViewMode[$field_name]["source"][$field_value].$this->nbsp.$fp_post_addition;
                        }else{
                           return $fp_pre_addition.$this->nbsp."<label>".trim($field_value)."</label>".$this->nbsp.$fp_post_addition;
                        }
                        break;
                    case "image":
                        $fp_align        = $this->GetFieldProperty($field_name, "align", "view", "lower", "center");
                        $fp_target_path  = $this->GetFieldProperty($field_name, "target_path", "view");
                        $fp_image_width  = $this->GetFieldProperty($field_name, "image_width", "view", "lower", "50px");
                        $fp_image_height = $this->GetFieldProperty($field_name, "image_height", "view", "lower", "30px");
                        $fp_default      = $this->GetFieldProperty($field_name, "default", "view", "normal");
                        $fp_magnify      = $this->GetFieldProperty($field_name, "magnify", "view", "normal");
                        $fp_magnify_type = $this->GetFieldProperty($field_name, "magnify_type", "view", "normal");
                        $fp_magnify_power= $this->GetFieldProperty($field_name, "magnify_power", "view", "normal");
                        $fp_magnify_power= (is_numeric($fp_magnify_power)) ? $fp_magnify_power : "2";
                        $fp_linkto       = $this->GetFieldProperty($field_name, "linkto", "view", "normal");
                        $img_default                 = "";
                        $img_magnify                 = "";
                        $img_src                     = $fp_target_path.trim($field_value);
                        if($fp_default != ""){
                            if(file_exists(trim($fp_default))){
                                $img_default = "<img src='".$fp_default."' width='".$fp_image_width."' height='".$fp_image_height."' alt='' title='' ".$on_js_event.">";
                            }else{
                                $img_default = "<span class='".$this->cssClass."_dg_label' ".$on_js_event.">".$this->lang['no_image']."</span>";    
                            }                            
                        }
                        $ret_image_img = $this->nbsp."<img style='vertical-align: middle; border:0px;' src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event.">".$this->nbsp;
                        $ret_image = $img_default;
                        if(($fp_magnify == "true") || ($fp_magnify === true)){
                            if($fp_magnify_type == "lightbox"){
                                if((trim($field_value) !== "") && file_exists($img_src)){
                                    $ret_image = $this->nbsp."<a href='".$img_src."' rel='lytebox' title=''><img style='vertical-align: middle; border:0px solid #cccccc;' src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event."></a>".$this->nbsp;
                                }                                
                            }else if($fp_magnify_type == "popup"){
                                if((trim($field_value) !== "") && file_exists($img_src)){
                                    $ret_image = $this->nbsp."<img style='vertical-align: middle; border:0px solid #cccccc;cursor:pointer;' onClick=\"new_win=window.open('".$img_src."','ImageViewer','left=100,top=100,width=400,height=300,toolbar=0,menubar=0,resizable=1,location=0,scrollbars=1');new_win.focus()\" src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event." />".$this->nbsp;
                                }
                            }else if($fp_magnify_type == "magnifier"){
                                $img_magnify = "onmouseover='showtrail(\"".$img_src."\",\"\",\"\",\"1\", ".($fp_image_height*$fp_magnify_power).", 1, ".($fp_image_width*$fp_magnify_power).");' onmouseout='hidetrail();'";   
                                if((trim($field_value) !== "") && file_exists($img_src)){
                                    $ret_image = $this->nbsp."<img style='vertical-align: middle; border:1px;' src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event." ".$img_magnify.">".$this->nbsp;
                                }
                            }else if((trim($field_value) !== "") && file_exists($img_src)){
                                $ret_image = $ret_image_img;
                            }
                        }else{
                            if(trim($field_value) != "" && file_exists(trim($img_src))) $ret_image = $ret_image_img; 
                        }
                        if ($fp_linkto == "details"){
                            $curr_url = $this->CombineUrl("details", $this->GetRecordID($row));
                            $this->SetUrlStringPaging($curr_url);
                            $this->SetUrlStringSorting($curr_url);
                            $this->SetUrlStringFiltering($curr_url);
                            $ret_image = "<a class='".$this->cssClass."_dg_a' href='".$curr_url."'>".$ret_image."</a>";
                        }
                        return $fp_pre_addition.$ret_image.$fp_post_addition;                        
                        break;
                    case "label":
                        if((trim($field_value) != "")
                            // we need this for right handling wysiwyg editor values
                            && (trim(Helper::ConvertCase($field_value,"lower",$this->langName)) !== "<pre></pre>")
                            && (trim(Helper::ConvertCase($field_value,"lower",$this->langName)) !== "<pre>".$this->nbsp."</pre>")
                            && (trim(Helper::ConvertCase($field_value,"lower",$this->langName)) !== "<p></p>")
                            && (trim(Helper::ConvertCase($field_value,"lower",$this->langName)) !== "<p>".$this->nbsp."</p>")){ 
                            return $fp_pre_addition.$this->nbsp."<label class='".$this->cssClass."_dg_label' ".$title." ".$on_js_event.">".trim($field_value)."</label>".$this->nbsp.$fp_post_addition;
                        }else{
                            return " ";
                        }
                        break;                    
                    case "link":
                    case "linkbutton":
                        $fp_field_data = $this->GetFieldProperty($field_name, "field_data", "view", "normal");
                        $fp_rel        = $this->GetFieldProperty($field_name, "rel", "view");
                        $fp_href       = $this->GetFieldProperty($field_name, "href", "view");
                        $fp_target     = $this->GetFieldProperty($field_name, "target", "view");
                        
                        if($fp_field_data != ""){
                            $rel = ($fp_rel != "") ? "rel=".$fp_rel : "";
                            $title = $this->GetFieldTitle($field_name, "view");
                            $href = $fp_href;
                            foreach ($this->columnsViewMode[$field_name] as $search_field_key => $search_field_value){
                                if(substr($search_field_key, 0, 9) == "field_key"){                                    
                                    $field_number = intval(substr($search_field_key, 10, strlen($search_field_key) - 10));
                                    $field_inner = ($this->GetFieldOffset($search_field_value) != "-1") ? $row[$this->GetFieldOffset($search_field_value)] : "";
                                    if(strpos($fp_href, "{".$field_number."}") >= 0){
                                        $href = str_replace("{".$field_number."}", $field_inner, $href);
                                        $on_js_event = str_replace("{".$field_number."}", $field_inner, $on_js_event);
                                    }                                    
                                }                                
                            }
                            // remove unexpected 'http://'s
                            if(strstr($fp_href, "https://") != "" || strstr($href, "https://") != ""){
                                $href = str_replace(array("https://", "http://"), "", $href);
                                $href = "https://".$href;
                            }else if(strstr($fp_href, "http://") != ""){
                                $href = str_replace("http://", "", $href);
                                $href = "http://".$href;
                            }
                            $link_type = "";
                            if($this->GetFieldOffset($fp_field_data) != "-1"){
                                $field_value = trim($row[$this->GetFieldOffset($fp_field_data)]);
                                if(strtolower($fp_case) == "upper"){
                                    $field_value = Helper::ConvertCase($field_value,"upper",$this->langName);
                                }else if(strtolower($fp_case) == "lower"){
                                    $field_value = Helper::ConvertCase($field_value,"lower",$this->langName);
                                }else if(strtolower($fp_case) == "camel"){
                                    $field_value = Helper::ConvertCase($field_value,"camel",$this->langName);
                                }
                                $link_type = "1";
                            }else if($field_value != ""){
                                $link_type = "2";
                            }else{
                                return "";
                            }
                            if($link_type == "1" || $link_type == "2"){
                                if($field_type == "linkbutton"){
                                    return $fp_pre_addition.$this->nbsp."<input type='button' class='".$this->cssClass."_dg_button' value='".$field_value."' onclick=\"javascript:document.location.href='".$href."'\">".$this->nbsp.$fp_post_addition;
                                }else{                                    
                                    return $fp_pre_addition.$this->nbsp."<a class='".$this->cssClass."_dg_a2' href=\"".$href."\" target='".$fp_target."' ".$rel." title='".$title."' ".$on_js_event.">".$field_value."</a>".$this->nbsp.$fp_post_addition;
                                }
                            }
                        }else{
                            return $this->nbsp;   
                        }                        
                        break;
                    case "linktoview":
                        $row_id = $this->GetRecordID($row);
                        return $fp_pre_addition.$this->nbsp."<a class='".$this->cssClass."_dg_a' href='javascript:".$this->uniquePrefix."_doPostBack(\"details\",".$this->EncodeParameter($row_id).");' title='".$this->lang['view_details']."' ".$on_js_event.">".trim($field_value)."</a>".$this->nbsp.$fp_post_addition;
                        break;
                    case "linktoedit":
                        $row_id = $this->GetRecordID($row);
                        return $fp_pre_addition.$this->nbsp."<a class='".$this->cssClass."_dg_a' href='javascript:".$this->uniquePrefix."_doPostBack(\"edit\",".$this->EncodeParameter($row_id).");' title='".$this->lang['edit_record']."' ".$on_js_event.">".trim($field_value)."</a>".$this->nbsp.$fp_post_addition;
                        break;
                    case "linktodelete":
                        $row_id = $this->GetRecordID($row);                         
                        return $fp_pre_addition.$this->nbsp."<a class='".$this->cssClass."_dg_a' href='javascript:".$this->uniquePrefix."verifyDelete(".$this->EncodeParameter($row_id).");' title='".$this->lang['delete_record']."' ".$on_js_event.">".trim($field_value)."</a>".$this->nbsp.$fp_post_addition;
                        break;
                    case "money": 
                        $fp_decimal_places   = $this->GetFieldProperty($field_name, "decimal_places", "view"); 
                        $fp_dec_separator    = $this->GetFieldProperty($field_name, "dec_separator", "view"); 
                        $fp_thousands_separator = $this->GetFieldProperty($field_name, "thousands_separator", "view");                        
                        $fp_money_sign       = $this->GetFieldProperty($field_name, "sign", "view");
                        $money_sign_after                = $money_sign_before = "";
                        if($this->GetFieldProperty($field_name, "sign_place", "view") == "before"){
                            $money_sign_before = $fp_money_sign;                            
                        }else{                                                        
                            $money_sign_after  = $fp_money_sign;
                        }
                        if((trim($field_value) != "") 
                            // we need this for right handling wysiwyg editor values 
                            && (trim(Helper::ConvertCase($field_value,"lower",$this->langName)) !== "<pre></pre>") 
                            && (trim(Helper::ConvertCase($field_value,"lower",$this->langName)) !== "<pre>".$this->nbsp."</pre>") 
                            && (trim(Helper::ConvertCase($field_value,"lower",$this->langName)) !== "<p></p>") 
                            && (trim(Helper::ConvertCase($field_value,"lower",$this->langName)) !== "<p>".$this->nbsp."</p>")){ 
                            return $fp_pre_addition.$this->nbsp."<label>".trim($money_sign_before.number_format($field_value, $fp_decimal_places, $fp_dec_separator, $fp_thousands_separator)).$money_sign_after."</label>".$this->nbsp.$fp_post_addition;
                        }else{ 
                            return $this->nbsp;   
                        } 
                        break;                     
                    case "percent":                        
                        $fp_decimal_places   = $this->GetFieldProperty($field_name, "decimal_places", "view");
                        if(!is_numeric($fp_decimal_places)) $fp_decimal_places = "0";
                        $fp_dec_separator    = $this->GetFieldProperty($field_name, "dec_separator", "view");
                        $field_value = ($field_value != "") ? number_format($field_value, $fp_decimal_places, $fp_dec_separator, ",")."%" : "";
                        return $fp_pre_addition.$this->nbsp."<label>".$field_value."</label>".$this->nbsp.$fp_post_addition;
                        break;
                    case "data":                        
                        return $field_value;
                        break;                    
                    default:
                        return $fp_pre_addition.$this->nbsp."<label class='".$this->cssClass."_dg_label' ".$title." ".$on_js_event.">".trim($field_value)."</label>".$this->nbsp.$fp_post_addition; break;
                }
            }
        // -= ADD / EDIT / DETAILS MODE =-    
        }else if(($mode === "edit") || ($mode === "details")){

            if(array_key_exists($field_name, $this->columnsEditMode)){
                $fp_maxlength        = $this->GetFieldProperty($field_name, "maxlength");
                $fp_type             = $this->GetFieldProperty($field_name, "type");
                $fp_req_type         = ($m_field_req_type != "") ? $m_field_req_type : $this->GetFieldProperty($field_name, "req_type");
                $fp_width            = $this->GetFieldProperty($field_name, "width");
                $fp_readonly         = $this->GetFieldProperty($field_name, "readonly");
                $fp_default          = $this->GetFieldProperty($field_name, "default", "edit", "normal");
                $fp_value            = $this->GetFieldProperty($field_name, "value", "edit", "normal");
                $on_js_event                     = $this->GetFieldProperty($field_name, "on_js_event", "edit", "normal");
                $fp_pre_addition     = $this->GetFieldProperty($field_name, "pre_addition");
                $fp_post_addition    = $this->GetFieldProperty($field_name, "post_addition");
                $fp_on_item_created  = $this->GetFieldProperty($field_name, "on_item_created", "edit");
                $fp_autocomplete     = $this->GetFieldProperty($field_name, "autocomplete");
                $autocomplete                    = ($fp_autocomplete == "off") ? "autocomplete='off'" : "";
                $fp_hide             = $this->GetFieldProperty($field_name, "hide", "edit");
                $fp_generate         = $this->GetFieldProperty($field_name, "generate", "edit");
                $fp_visible          = $this->GetFieldProperty($field_name, "visible");
                
                $fp_calendar_type     = $this->GetFieldProperty($field_name, "calendar_type");
                $show_seconds         = $this->GetFieldProperty($field_name, "show_seconds", "edit", "normal", true); 
                $date_time_format_ymd = ($show_seconds === false) ? "Y-m-d H:i" : "Y-m-d H:i:s";
                $date_time_format_mdy = ($show_seconds === false) ? "d-m-Y H:i" : "d-m-Y H:i:s";
                
                $template                   = $this->GetFieldProperty($field_name, "template");

                // customized working with field value
                if($fp_type != "enum" && function_exists($fp_on_item_created)){
                    //ini_set("allow_call_time_pass_reference", true);                     
                    $field_value = $fp_on_item_created($field_value);
                }
                
                // detect maxlength for the current field
                $field_maxlength = $this->GetFieldInfo($field_name, 'len', 0);
                if($field_maxlength <= 0) $field_maxlength = "";
                else $field_maxlength = "maxlength='".$field_maxlength."'";                        
                if($fp_maxlength == ""){
                    if(!$this->IsText($field_name)){ $field_maxlength = "maxlength='50'"; }
                }else{
                    if(($fp_maxlength != "-1") && ($fp_maxlength != "")){
                        $field_maxlength = "maxlength='".$fp_maxlength."'";    
                    }
                }                                
                // detect field's type
                if($fp_type == ""){ $field_type = "label"; } else $field_type = $fp_type;
                // get required prefix for a field
                $field_req_type = $fp_req_type;                
                if(strlen(trim($field_req_type)) == 3){ $field_req_type = $field_req_type; }
                else if(strlen(trim($field_req_type)) == 2){ $field_req_type = $field_req_type."y"; }
                else { $field_req_type = "syy"; }
                $full_field_name = $field_req_type.$field_name.$multirow_postfix;
                
                // detect field's width
                if($fp_width != "") $field_width = "style='width:".$fp_width.";'"; else $field_width = "";
                // detect field's readonly property                
                if($fp_readonly == true) { $readonly = "readonly='readonly'"; $disabled = "disabled"; }
                else { $readonly = ""; $disabled = ""; }                
                if($this->isPrinting && $field_type != "image"){ $field_type = "print"; }

                // get default value of field
                if($field_type == "hidden"){                    
                    if($req_mode == "add"  && $fp_default != "") { $field_value = $fp_default; }
                    if($req_mode == "edit" && $fp_value != "" )   { $field_value = $fp_value; }
                    if($req_mode == "edit" && $fp_value == "" && $fp_default != "")   { $field_value = $fp_default; }
                }else{
                    if($req_mode == "add"  && $fp_default != "") { $field_value = $fp_default; }
                }

                if ($mode === "edit"){
                    // save entered values from fields in add/edit modes
                    $req_field_value = $this->GetVariable($field_req_type.$field_name.$multirow_postfix, false, "post");
                    if($req_field_value != "") $field_value = $req_field_value;
                    switch($field_type){
                        case "blob":                           
                            return $fp_pre_addition.$this->nbsp."<textarea class='".$this->cssClass."_dg_textbox' name='".$full_field_name."' id='".$full_field_name."' title='".$this->GetFieldTitle($field_name)."' rows='3' cols='50' ".$readonly.">".$field_value."</textarea>".$this->nbsp.$fp_post_addition;
                            break;
                        case "checkbox":                        
                            $checked = "";
                            $fp_true_value = $this->GetFieldProperty($field_name, "true_value");
                            $fp_false_value = $this->GetFieldProperty($field_name, "false_value");
                            if(($fp_true_value !== "") && ($fp_false_value !== "")){
                                if($field_value == $fp_true_value){
                                    $checked = "checked";
                                }
                            }
                            return $fp_pre_addition.$this->nbsp."<input class='".$this->cssClass."_dg_checkbox' type='checkbox' name='".$full_field_name."' id='".$full_field_name."' title='".$this->GetFieldTitle($field_name)."' value='".trim($field_value)."' ".$checked." ".$readonly." ".$on_js_event." />".$this->nbsp.$fp_post_addition;
                            break;
                        case "color":
                            $ret_color = "<table cellspacing='0' cellpadding='0' border='0'><tr><td valign='middle'>";
                            $fp_view_type = $this->GetFieldProperty($field_name, "view_type");
                            $fp_save_format = $this->GetFieldProperty($field_name, "save_format");
                            $on_js_event = "onChange=\"changeColor('".$field_name."_colorbox".$multirow_postfix."', this.value);\"".$on_js_event;
                            
                            $arr_colors = Helper::GetColorsByName();
                            switch($fp_view_type){
                                case "dropdownlist":
                                default:
                                    $ret_color .= $this->nbsp.$this->DrawDropDownList($full_field_name, '', $arr_colors, $field_value, $field_name, "", "", $disabled, $on_js_event, false, "1", true).$this->nbsp;
                                    break;                                
                                //case "palette":
                                //default:                                
                                //break;
                            }
                            $ret_color .= "</td><td valign='middle' align='left'><div id='".$field_name."_colorbox".$multirow_postfix."' style='border:1px solid #cecece;margin-left:5px;width:17px;height:17px;background-color:".$field_value.";layer-background-color:".$field_value.";'></div></tr></table>";
                            return $fp_pre_addition.$ret_color.$fp_post_addition;
                            break;                        
                        case "date":
                            return $this->DrawCalendarButton($field_name, $field_type, "Y-m-d", $field_value, $fp_pre_addition, $fp_post_addition, $field_width, $field_maxlength, $on_js_event, $readonly, $fp_calendar_type, $multirow_postfix);
                            break;                        
                        case "datedmy":
                            return $this->DrawCalendarButton($field_name, $field_type, "d-m-Y", $field_value, $fp_pre_addition, $fp_post_addition, $field_width, $field_maxlength, $on_js_event, $readonly, $fp_calendar_type, $multirow_postfix);
                            break;                        
                        case "datemdy":
                            return $this->DrawCalendarButton($field_name, $field_type, "m-d-Y", $field_value, $fp_pre_addition, $fp_post_addition, $field_width, $field_maxlength, $on_js_event, $readonly, $fp_calendar_type, $multirow_postfix);
                            break;                        
                        case "datetime":
                            return $this->DrawCalendarButton($field_name, $field_type, $date_time_format_ymd, $field_value, $fp_pre_addition, $fp_post_addition, $field_width, $field_maxlength, $on_js_event, $readonly, $fp_calendar_type, $multirow_postfix);
                            break;                        
                        case "datetimedmy":
                            return $this->DrawCalendarButton($field_name, $field_type, $date_time_format_mdy, $field_value, $fp_pre_addition, $fp_post_addition, $field_width, $field_maxlength, $on_js_event, $readonly, $fp_calendar_type, $multirow_postfix);
                            break;
                        case "enum":                            
                            $ret_enum = "";
                            $fp_view_type = $this->GetFieldProperty($field_name, "view_type");
                            $fp_radiobuttons_alignment = $this->GetFieldProperty($field_name, "radiobuttons_alignment");
                            if($this->GetFieldProperty($field_name, "multiple") == true){ $enum_multiple = true; } else { $enum_multiple = false; }
                            $fp_multiple_size = $this->GetFieldProperty($field_name, "multiple_size", "edit", "lower", "4");                            
                            switch($fp_view_type){
                                case "radiobutton":
                                    if(is_array($this->columnsEditMode[$field_name]["source"])){  // don't remove columns_edit_mode
                                        $ret_enum .= $this->nbsp.$this->DrawRadioButtons($full_field_name, $field_name, $this->columnsEditMode[$field_name]["source"], $field_value, 'source', "", $disabled, $on_js_event, $fp_radiobuttons_alignment).$this->nbsp;
                                    }else{
                                        $ret_enum .= $this->nbsp.$this->DrawRadioButtons($full_field_name, $field_name, $this->GetEnumValues($this->tblName, $field_name), $field_value, 'source', "", $disabled, $on_js_event, $fp_radiobuttons_alignment).$this->nbsp;
                                    }                                        
                                    break;                            
                                case "checkbox":
                                    if(is_array($this->columnsEditMode[$field_name]["source"])){  // don't remove columns_edit_mode
                                        $ret_enum .= $this->nbsp.$this->DrawCheckBoxes($full_field_name, '', $this->columnsEditMode[$field_name]["source"], $field_value, "", "", "", $disabled, $on_js_event, $enum_multiple, $fp_multiple_size).$this->nbsp;
                                    }else{
                                        $ret_enum .= $this->nbsp.$this->DrawCheckBoxes($full_field_name, '', $this->GetEnumValues($this->tblName, $field_name), trim($field_value), "", "", "", $disabled, $on_js_event, $enum_multiple, $fp_multiple_size).$this->nbsp;
                                    }
                                    break;    
                                case "dropdownlist":
                                default:                                
                                    if(is_array($this->columnsEditMode[$field_name]["source"])){  // don't remove columns_edit_mode
                                        $ret_enum .= $this->nbsp.$this->DrawDropDownList($full_field_name, '', $this->columnsEditMode[$field_name]["source"], $field_value, "", "", "", $disabled, $on_js_event, $enum_multiple, $fp_multiple_size).$this->nbsp;
                                    }else{
                                        $ret_enum .= $this->nbsp.$this->DrawDropDownList($full_field_name, '', $this->GetEnumValues($this->tblName, $field_name), trim($field_value), "", "", "", $disabled, $on_js_event, $enum_multiple, $fp_multiple_size).$this->nbsp;
                                    }
                                    break;
                            }
                            return $fp_pre_addition.$ret_enum.$fp_post_addition;
                            break;
                        case "hidden":
                            $ret_hidden = "<input type='hidden' id='".$full_field_name."' name='".$full_field_name."' value='".trim($field_value)."' />";
                            if($fp_visible && ($this->layouts[$this->layoutType] != "0")) $ret_hidden .= "<label class='".$this->cssClass."_dg_label'>".$field_value."</label>";
                            return $fp_pre_addition.$ret_hidden.$fp_post_addition;                        
                            break;                        
                        case "image":
                        case "file":        
                            $ret_file = "";
                            $file = false;
                            $file_error_msg = "";
                            $file_name_view = $field_value;
                            $file_act = $this->GetVariable('file_act');
                            $file_id = $this->GetVariable('file_id');
                            // where the file is going to be placed 
                            $fp_target_path   = $this->GetFieldProperty($field_name, "target_path");
                            $fp_file_name     = $this->GetFieldProperty($field_name, "file_name");
                            $fp_image_width   = $this->GetFieldProperty($field_name, "image_width", "edit", "lower", "120px");
                            $fp_image_height  = $this->GetFieldProperty($field_name, "image_height", "edit", "lower", "90px");
                            $fp_max_file_size = $this->GetFieldProperty($field_name, "max_file_size", "edit", "lower");
                            $fp_resize_image  = $this->GetFieldProperty($field_name, "resize_image", "edit");
                            $fp_resize_width  = $this->GetFieldProperty($field_name, "resize_width", "edit");
                            $fp_resize_height = $this->GetFieldProperty($field_name, "resize_height", "edit");
                            $fp_magnify       = $this->GetFieldProperty($field_name, "magnify", "edit");
                            $fp_magnify_type  = $this->GetFieldProperty($field_name, "magnify_type", "edit");
                            $fp_magnify_power = $this->GetFieldProperty($field_name, "magnify_power", "edit", "normal");
                            $fp_magnify_power = (is_numeric($fp_magnify_power)) ? $fp_magnify_power : "2";                            
                            $img_magnify                  = "";
                            $img_src                      = $fp_target_path.trim($field_value);
                            if($multirow_postfix != "") $rid = str_replace("_", "", $multirow_postfix);
                            else $rid = $this->rid;
                            
                            if($this->GetFieldProperty($field_name, "host") == "remote"){
                                // *** upload file from url (remote host)
                                $ret_file = "";
                                if(trim($field_value) == ""){
                                    if(($file_act == "upload") && ($file_id == $field_name.$multirow_postfix)){
                                        $file_error_msg = $this->lang['file_uploading_error'];
                                        $file = false;
                                    }
                                }else{
                                    if(($file_act == "remove") && ($file_id == $field_name.$multirow_postfix)){                                    
                                        if(!$this->isDemo){
                                            $sql = "UPDATE $this->tblName SET ".$field_name." = '' WHERE $this->primaryKey = '".$rid."' ";
                                            $this->dbHandler->query($sql);
                                            if($this->debug) echo $sql."<br />";
                                            // delete file from target path
                                            if(file_exists($fp_target_path.$field_value)){ @unlink($fp_target_path.$field_value); }
                                            else{ $file_error_msg = $this->lang['file_deleting_error']; }
                                            $file = false;
                                        } else { $file = true; $file_error_msg = "Deleting operation is blocked in demo version"; }
                                    }else if(($file_act == "upload") && ($file_id == $field_name.$multirow_postfix)){
                                        if(!$this->isDemo){
                                            if($downloaded_file = fopen($field_value, "r")){
                                                $content = $this->HttpGetFile($field_value);
                                                // get file name from url
                                                $field_value = strrev($field_value);
                                                $last_slash = strlen($field_value) - strpos($field_value,'/');
                                                $field_value = strrev($field_value);
                                                if($last_slash) { $field_value = substr($field_value,$last_slash); }
                                                if($fp_file_name != ""){
                                                    $file_name_view = $fp_file_name.strchr(basename($field_value),".");
                                                    $field_value = $file_name_view;                                                
                                                }
                                                if($content == ""){
                                                    $file_error_msg = $this->lang['file_uploading_error'];
                                                }else if($uploaded_file = fopen($fp_target_path.$field_value, "w")){
                                                    if(!fwrite($uploaded_file, $content)){
                                                        $file_error_msg = $this->lang['file_writing_error'];
                                                        $file = false;
                                                    }else{
                                                        if($req_mode != "add"){
                                                            $sql = "UPDATE $this->tblName SET ".$field_name." = '".$field_value."' WHERE $this->primaryKey = '".$rid."'";
                                                            $this->dbHandler->query($sql);
                                                        }
                                                        $file = true;
                                                        fclose($uploaded_file);
                                                    }                                                
                                                }
                                                fclose($downloaded_file);
                                            }else{
                                                $file_error_msg = $this->lang['file_uploading_error'];                                            
                                            }                                            
                                        } else { $file = false; $file_error_msg = "Uploading operation is blocked in demo version"; }
                                    }else{
                                        $file = true;
                                    }
                                }                                

                                // [#0009-1 under check - 19.09.09] - start
                                // to prevent error on uploading after some operation was done on another datagrid
                                $upload_curr_url = $this->QUERY_STRING;
                                $upload_curr_url = str_replace("&".$this->uniquePrefix."file_act=remove", "", $upload_curr_url);
                                $upload_curr_url = str_replace("&".$this->uniquePrefix."file_act=upload", "", $upload_curr_url);
                                $upload_curr_url = str_replace("&".$this->uniquePrefix."file_id=".$field_name.$multirow_postfix, "", $upload_curr_url);
                                if(is_array($this->anotherDatagrids)){
                                    foreach($this->anotherDatagrids as $key => $val){
                                        $upload_curr_url = str_replace($key."mode=update", $key."mode=view", $upload_curr_url);
                                    }
                                }                                
                                /// old variant
                                /// $upload_curr_url = $this->QUERY_STRING;                                
                                // [#0009-1 under check - 19.09.09] - end

                                // if there is a file (uploaded or exists)
                                if($file == true){
                                    if(strlen($field_value) > 40){
                                        $str_start = strlen($field_value) - 40;
                                        $str_prefix = "...";
                                    }else{
                                        $str_start = 0;
                                        $str_prefix = "";
                                    }
                                    if($file_error_msg != "") $ret_file .= $this->nbsp."<label class='".$this->cssClass."_dg_error_message no_print'>".$file_error_msg."</label><br />";
                                    $ret_file .= "<table><tr valign='middle'><td align='center'>";
                                    if($field_type == "image"){
                                        list($f_width, $f_height, $f_type, $f_attr) = getimagesize($fp_target_path.$field_value);
                                        $f_size = number_format((filesize($fp_target_path.$field_value)/1024),2,".",",")." Kb";
                                        if((trim($field_value) !== "") && file_exists($fp_target_path.trim($field_value))){
                                            $ret_file_img = $this->nbsp."<img src='".$fp_target_path.$field_value."' height='".$fp_image_height."' width='".$fp_image_width."' title='$field_value ($f_width x $f_height - $f_size)' alt='$field_value'>".$this->nbsp;
                                        }else $ret_file_img = "";
                                        if(($fp_magnify == "true") || ($fp_magnify == true)){
                                            if($fp_magnify_type == "lightbox"){
                                                if((trim($field_value) !== "") && file_exists($img_src)){
                                                    $ret_file_img = $this->nbsp."<a href='".$img_src."' rel='lytebox' title='$field_value ($f_width x $f_height - $f_size)'><img style='border:0px;' src='".$img_src."' height='".$fp_image_height."' width='".$fp_image_width."' title='$field_value ($f_width x $f_height - $f_size)' alt='$field_value' ".$img_magnify."></a>".$this->nbsp;
                                                }                                
                                            }else if($fp_magnify_type == "popup"){
                                                if((trim($field_value) !== "") && file_exists($img_src)){
                                                    $ret_file_img = $this->nbsp."<a href=\"javascript:new_win = window.open('".$img_src."','ImageViewer','left=100,top=100,width=400,height=300,toolbar=0,resizable=1,location=0,scrollbars=1'); new_win.focus();\" title=''><img style='vertical-align: middle; border:0px solid #cccccc;' src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event."></a>".$this->nbsp;
                                                }
                                            }else if($fp_magnify_type == "magnifier"){
                                                $img_magnify = "onmouseover='showtrail(\"".$img_src."\",\"\",\"\",\"1\", ".($fp_image_height*$fp_magnify_power).", 1, ".($fp_image_width*$fp_magnify_power).");' onmouseout='hidetrail();'";
                                                if((trim($field_value) !== "") && file_exists($img_src)){
                                                    $ret_file_img = $this->nbsp."<img src='".$img_src."' height='".$fp_image_height."' width='".$fp_image_width."' title='$field_value ($f_width x $f_height - $f_size)' alt='$field_value' ".$img_magnify.">".$this->nbsp;
                                                }                                
                                            }
                                        }
                                        $ret_file .= $ret_file_img;                                        
                                    }else{
                                        $ret_file .= $this->nbsp.$str_prefix.substr($file_name_view, $str_start, 40).$this->nbsp;                                    
                                    }
                                    if($field_type == "image") $ret_file .= "<br />";
                                    else $ret_file .= " ";
                                    if(($fp_readonly != "true") && ($fp_readonly != true) && !$this->isPrinting){
                                        $ret_file .= $this->nbsp."[<a class='".$this->cssClass."_dg_a' href='javascript:void(0);' onclick='formAction(\"remove\", \"".$field_name.$multirow_postfix."\", \"".$this->uniquePrefix."\", \"".$this->HTTP_URL."\", \"".$upload_curr_url."\"); return false;'>".$this->lang['remove']."</a>]".$this->nbsp;
                                    }
                                    $ret_file .= "</td></tr></table>";
                                    $ret_file .= "<input type='hidden' value='$field_value' name='".$full_field_name."' id='".$full_field_name."' />";                                 
                                }else{
                                    if($file_error_msg != "") $ret_file .= $this->nbsp."<label class='".$this->cssClass."_dg_error_message no_print'>".$file_error_msg."</label><br />";
                                    $ret_file .= "<table border='0' cellspacing='0' cellpadding='0'><tr>";
                                    $ret_file .= "<td><input type='textbox' class='".$this->cssClass."_dg_textbox' ".$field_width." title='".$this->GetFieldTitle($field_name)."' name='".$full_field_name."' id='".$full_field_name."' ".$disabled." ".$on_js_event." /></td><td nowrap='nowrap' width='7px'></td>";
                                    $ret_file .= "<td>[<a class='".$this->cssClass."_dg_a' ".(($disabled == "disabled") ? "" : "style='cursor: pointer;' onclick='".$this->uniquePrefix."updateWysiwygFields(); formAction(\"upload\", \"".$field_name.$multirow_postfix."\", \"".$this->uniquePrefix."\", \"".$this->HTTP_URL."\", \"".$upload_curr_url."\"); return false;'").">".$this->lang['upload']."</a>]</td>";
                                    $ret_file .= "</tr></table>";
                                }
                                return $fp_pre_addition.$ret_file.$fp_post_addition;
                                
                            }else{
                                // *** upload file from local machine                                
                                $ret_file = "";
                                if(trim($field_value) == ""){
                                    $file = true;
                                    if((count($_FILES) > 0) && ($file_id == $field_name.$multirow_postfix)){
                                        if(!$this->isDemo){
                                            if (isset($_FILES[$full_field_name]["error"]) && ($_FILES[$full_field_name]["error"] > 0)){
                                                $file_error_msg = $this->lang['file_uploading_error'];
                                                if($this->debug){ $file_error_msg .= " Error: ".$_FILES[$full_field_name]["error"]; }
                                                $file = false;
                                            }else{
                                                // check file's max size
                                                if($fp_max_file_size != ""){
                                                    $max_file_size = $fp_max_file_size; 
                                                    if (!is_numeric($max_file_size)) { 
                                                        if (strpos($max_file_size, 'm') !== false) 
                                                            $max_file_size = intval($max_file_size)*1024*1024; 
                                                        elseif (strpos($max_file_size, 'k') !== false) 
                                                            $max_file_size = intval($max_file_size)*1024; 
                                                        elseif (strpos($max_file_size, 'g') !== false) 
                                                            $max_file_size = intval($max_file_size)*1024*1024*1024; 
                                                    }
                                                    if(isset($_FILES[$full_field_name]["size"]) && ($_FILES[$full_field_name]["size"] > $max_file_size)){
                                                       $file = false;
                                                       $file_error_msg = $this->lang['file_invalid file_size'].": ".number_format(($_FILES[$full_field_name]["size"]/1024),2,".",",")." Kb (".$this->lang['max'].". ".number_format(($max_file_size/1024),2,".",",")." Kb) ";
                                                    }
                                                }                                        
                                            }                                    
                                            if($file == true){
                                                // create a directory for uploading, if it was not.
                                                if (!file_exists($fp_target_path)) { @mkdir($fp_target_path,0744); }
                                                // add the original filename to our target path. Result is "uploads/filename.extension"                                                                                
                                                if($fp_file_name != ""){
                                                    $target_path_full = $fp_target_path . $fp_file_name.strchr(basename($_FILES[$full_field_name]['name']),".");
                                                }else{
                                                    $target_path_full = $fp_target_path . (isset($_FILES[$full_field_name]['name']) ? basename($_FILES[$full_field_name]['name']) : "") ;
                                                }
                                                if(isset($_FILES[$full_field_name]['tmp_name'])){
                                                    @chmod($fp_target_path, 0777);
                                                    if(move_uploaded_file($_FILES[$full_field_name]['tmp_name'], $target_path_full)) {                                                        
                                                        $sql = "UPDATE $this->tblName SET ".$field_name;
                                                        if($fp_file_name != ""){
                                                            $file_name_view = $fp_file_name.strchr(basename($_FILES[$full_field_name]['name']),".");
                                                            $sql .= " = '".$file_name_view."'";
                                                        }else{
                                                            $file_name_view = $_FILES[$full_field_name]['name'];                                                            
                                                            $sql .= " = '".$file_name_view."' ";                                                    
                                                        }
                                                        $field_value = $file_name_view;
                                                        $sql .= " WHERE $this->primaryKey = '".$rid."' ";
                                                        if($req_mode != "add"){
                                                            $dSet = $this->dbHandler->query($sql);
                                                            if($this->debug){
                                                                echo $sql."<br />";
                                                                if($this->dbHandler->isError($dSet) == 1){
                                                                    $this->isError = true;
                                                                    $this->AddErrors($dSet);
                                                                }
                                                            }
                                                        }
                                                        $file = true;
                                                        $img_src = $fp_target_path.trim($field_value);
                                                        if($fp_resize_image == "true" || $fp_resize_image === true) $this->ResizeImage($fp_target_path, $file_name_view, $fp_resize_width, $fp_resize_height);                                                        
                                                    } else{
                                                        $file_error_msg = $this->lang['file_uploading_error'];
                                                        $file = false;
                                                    }
                                                    @chmod($fp_target_path, 0755);
                                                }else{ $file = false; }
                                            }                                            
                                        } else { $file = false; $file_error_msg = "Uploading operation is blocked in demo version"; }
                                    }else{ $file = false; }
                                }else{
                                    if(($file_act == "remove") && ($file_id == $field_name.$multirow_postfix)){
                                        if(!$this->isDemo){
                                            $sql = "UPDATE $this->tblName SET ".$field_name." = '' WHERE $this->primaryKey = '".$rid."' ";
                                            $this->dbHandler->query($sql);
                                            if($this->debug) echo $sql."<br />";
                                            // delete file from target path
                                            if(file_exists($fp_target_path.$field_value)){
                                                @unlink($fp_target_path.$field_value);
                                            }else{ $file = false; $file_error_msg = $this->lang['file_deleting_error']; }
                                        } else { $file = true; $file_error_msg = "Deleting operation is blocked in demo version"; }                                        
                                    }else{
                                        $file = true;
                                    }
                                }
                                
                                // [#0009-2 under check - 19.09.09] - start
                                // to prevent error on uploading after some operation was done on another datagrid
                                $upload_curr_url = $this->QUERY_STRING;
                                $upload_curr_url = str_replace("&".$this->uniquePrefix."file_act=remove", "", $upload_curr_url);
                                $upload_curr_url = str_replace("&".$this->uniquePrefix."file_act=upload", "", $upload_curr_url);
                                $upload_curr_url = str_replace("&".$this->uniquePrefix."file_id=".$field_name.$multirow_postfix, "", $upload_curr_url);
                                if(is_array($this->anotherDatagrids)){
                                    foreach($this->anotherDatagrids as $key => $val){
                                        $upload_curr_url = str_replace($key."mode=update", $key."mode=view", $upload_curr_url);
                                    }
                                }
                                /// old variant
                                /// $upload_curr_url = $this->QUERY_STRING;                                
                                // [#0009-2 under check - 19.09.09] - end
                                
                                // if there is a file (uploaded or exists)
                                if($file == true){
                                    if(strlen($field_value) > 40){
                                        $str_start = strlen($field_value) - 40;
                                        $str_prefix = "...";
                                    }else{
                                        $str_start = 0;
                                        $str_prefix = "";
                                    }
                                    if($file_error_msg != "") $ret_file .= $this->nbsp."<label class='".$this->cssClass."_dg_error_message no_print'>".$file_error_msg."</label><br />";
                                    $ret_file .= "<table><tr valign='middle'><td align='center'>";
                                    if($field_type == "image"){
                                        $f_width = $f_height = $f_size = 0;
                                        if(strtolower($this->platform) == "windows") $perform_check = false;
                                        else $perform_check = true;
                                        if(!$perform_check || file_exists($fp_target_path.$field_value)){
                                            list($f_width, $f_height, $f_type, $f_attr) = getimagesize($fp_target_path.$field_value);
                                            $f_size = number_format((filesize($fp_target_path.$field_value)/1024),2,".",",")." Kb";                                                                                    
                                        }else{
                                            $ret_file .= $this->nbsp."<label class='".$this->cssClass."_dg_error_message no_print'>".$this->lang['file_uploading_error']."</label><br />";                                            
                                        }
                                        if(!$perform_check || ((trim($field_value) !== "") && file_exists($fp_target_path.trim($field_value)))){
                                            $ret_file_img = $this->nbsp."<img src='".$fp_target_path.$field_value."' ".(($fp_image_height != "") ? "height='".$fp_image_height."'" : "")." ".(($fp_image_width != "") ? "width='".$fp_image_width."'" : "")." title='$field_value ($f_width x $f_height - $f_size)' alt='$field_value'>".$this->nbsp;
                                        }else $ret_file_img = "";
                                        if(($fp_magnify == "true") || ($fp_magnify == true)){
                                            if($fp_magnify_type == "lightbox"){
                                                if((trim($field_value) !== "") && file_exists($img_src)){
                                                    $ret_file_img = $this->nbsp."<a href='".$img_src."' rel='lytebox' title='$field_value ($f_width x $f_height - $f_size)'><img style='border:0px;' src='".$img_src."' ".(($fp_image_height != "") ? "height='".$fp_image_height."'" : "")." ".(($fp_image_width != "") ? "width='".$fp_image_width."'" : "")." title='$field_value ($f_width x $f_height - $f_size)' alt='$field_value' ".$img_magnify."></a>".$this->nbsp;
                                                }                                
                                            }else if($fp_magnify_type == "popup"){                                                
                                                if((trim($field_value) !== "") && file_exists($img_src)){
                                                    $ret_file_img = $this->nbsp."<a href=\"javascript:new_win = window.open('".$img_src."','ImageViewer','left=100,top=100,width=400,height=300,toolbar=0,resizable=1,location=0,scrollbars=1'); new_win.focus();\" title=''><img style='vertical-align: middle; border:0px solid #cccccc;' src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event."></a>".$this->nbsp;
                                                }
                                            }else if($fp_magnify_type == "magnifier"){
                                                $img_magnify = "onmouseover='showtrail(\"".$img_src."\",\"\",\"\",\"1\", ".($fp_image_height*$fp_magnify_power).", 1, ".($fp_image_width*$fp_magnify_power).");' onmouseout='hidetrail();'";
                                                if((trim($field_value) !== "") && file_exists($img_src)){
                                                    $ret_file_img = $this->nbsp."<img src='".$img_src."' height='".$fp_image_height."' width='".$fp_image_width."' title='$field_value ($f_width x $f_height - $f_size)' alt='$field_value' ".$img_magnify.">".$this->nbsp;
                                                }                                
                                            }
                                        }
                                        $ret_file .= $ret_file_img;                                        
                                    }else{
                                        $ret_file .= $this->nbsp.$str_prefix.substr($file_name_view, $str_start, 40).$this->nbsp;                                        
                                    }
                                    if($field_type == "image") $ret_file .= "<br />";
                                    else $ret_file .= " ";
                                    if(($fp_readonly != "true") && ($fp_readonly != true) && !$this->isPrinting){
                                        $ret_file .= $this->nbsp."[<a class='".$this->cssClass."_dg_a' href='javascript:void(0);' onclick='formAction(\"remove\", \"".$field_name.$multirow_postfix."\", \"".$this->uniquePrefix."\", \"".$this->HTTP_URL."\", \"".$upload_curr_url."\"); return false;'>".$this->lang['remove']."</a>]".$this->nbsp;
                                    }
                                    $ret_file .= "</td></tr></table>";
                                    $ret_file .= "<input type='hidden' value='$field_value' name='".$full_field_name."' id='".$full_field_name."' />";
                                }else{
                                    if(!$this->isPrinting){
                                        if($file_error_msg != "") $ret_file .= $this->nbsp."<label class='".$this->cssClass."_dg_error_message no_print'>".$file_error_msg."</label><br />";
                                        $ret_file .= "<table border='0' cellspacing='0' cellpadding='0'><tr>";
                                        $ret_file .= "<td>".$this->nbsp."<input type='file' class='".$this->cssClass."_dg_textbox' ".$field_width." title='".$this->GetFieldTitle($field_name)."' name='".$full_field_name."' id='".$full_field_name."' ".$disabled." ".$on_js_event." ".(($this->isDemo) ? "disabled='disabled' " : "")."/></td><td nowrap='nowrap' width='7px'></td>";
                                        $ret_file .= "<td>[<a class='".$this->cssClass."_dg_a' ".(($disabled == "disabled" || $this->isDemo) ? "" : "style='cursor: pointer;' onclick='".$this->uniquePrefix."updateWysiwygFields(); formAction(\"upload\", \"".$field_name.$multirow_postfix."\", \"".$this->uniquePrefix."\", \"".$this->HTTP_URL."\", \"".$upload_curr_url."\"); return false;'").">".$this->lang['upload']."</a>] [<a href='javascript:void(0);' class='".$this->cssClass."_dg_a' onclick=\"javascript:document.getElementById('".$full_field_name."').value='';\">".$this->lang['clear']."</a>]</td>";
                                        $ret_file .= "</tr></table>";                                        
                                    }
                                }
                                return $fp_pre_addition.$ret_file.$fp_post_addition;
                            }
                            break;                        
                        case "label":
                            return $fp_pre_addition.$this->nbsp."<label class='".$this->cssClass."_dg_label' ".$field_width." ".$on_js_event.">".trim($field_value)."</label>".$this->nbsp.$fp_post_addition; 
                            break;
                        case "link":
                            $test_link = " <a class='".$this->cssClass."_dg_a' style='cursor:pointer;' onclick=\"test_win = window.open(document.getElementById('".$full_field_name."').value,'testURL','');test_win.focus();\">[".$this->lang['test']."]</a>";
                            return $fp_pre_addition.$this->nbsp."<input type='text' class='".$this->cssClass."_dg_textbox' ".$field_width." title='".$this->GetFieldTitle($field_name)."' name='".$full_field_name."' id='".$full_field_name."' value='".trim($field_value)."' $field_maxlength $readonly ".$on_js_event." />".$this->nbsp.$test_link.$fp_post_addition;
                            break;                        
                        case "money": 
                            $fp_money_sign = $this->GetFieldProperty($field_name, "sign", "edit");
                            $money_sign_after          = $money_sign_before = "";
                            if($this->GetFieldProperty($field_name, "sign_place", "edit") == "before"){
                                $money_sign_before = $fp_money_sign;                            
                            }else{                                                        
                                $money_sign_after  = $fp_money_sign;
                            }
                            return $fp_pre_addition.$this->nbsp.$money_sign_before."<input class='".$this->cssClass."_dg_textbox' ".$field_width." type='text' title='".$this->GetFieldTitle($field_name)."' name='".$full_field_name."' id='".$full_field_name."' value='".trim($this->GetMoneyFormat($field_name, $field_value))."' ".$field_maxlength." ".$readonly." ".$on_js_event." ".$autocomplete." />".$money_sign_after.$this->nbsp.$fp_post_addition;
                            break;                     
                        case "password":
                            $ret_password = $this->nbsp."<input type='".(($fp_hide == "true" || $fp_hide == true) ? "password" : "text")."' class='".$this->cssClass."_dg_textbox' ".$field_width." title='".$this->GetFieldTitle($field_name)."' name='".$full_field_name."' id='".$full_field_name."' value='".$field_value."' $field_maxlength $readonly ".$on_js_event.">".$this->nbsp;
                            if($fp_generate == "true" || $fp_generate == true){ 
                                $ret_password .= " <a href='javascript:void(0);' class='".$this->cssClass."_dg_a2' onclick='document.getElementById(\"".$full_field_name."\").value = generatePassword(8);'>[".Helper::ConvertCase($this->lang['generate'],"camel",$this->langName)."]</a>";
                            }
                            return $fp_pre_addition.$ret_password.$fp_post_addition;
                            break; 
                        case "percent":
                            $fp_decimal_places = $this->GetFieldProperty($field_name, "decimal_places", "edit");
                            $fp_dec_separator = $this->GetFieldProperty($field_name, "dec_separator", "edit");
                            $field_value = number_format(floatval($field_value), $fp_decimal_places, $fp_dec_separator, "");                            
                            return $fp_pre_addition.$this->nbsp."<input class='".$this->cssClass."_dg_textbox' ".$field_width." type='text' title='".$this->GetFieldTitle($field_name)."' name='".$full_field_name."' id='".$full_field_name."' value='".$field_value."' ".$field_maxlength." ".$readonly." ".$on_js_event." ".$autocomplete." /> %".$this->nbsp.$fp_post_addition;
                            break;
                        case "print":
                            return $fp_pre_addition.$this->nbsp."<label class='".$this->cssClass."_dg_label' ".$field_width.">".trim($field_value)."</label>".$this->nbsp.$fp_post_addition; 
                            break;                        
                        case "textarea":
                            $field_value = str_replace('"', "&quot;", $field_value); // double quotation mark
                            $field_value = str_replace("'", "&#039;", $field_value); // single quotation mark
                            $resizable           = $fp_resizable = $this->GetFieldProperty($field_name, "resizable", "edit", "lower", "false");
                            $field_rows          = $fp_rows      = $this->GetFieldProperty($field_name, "rows", "edit", "lower", "3");
                            $field_cols          = $fp_cols      = $this->GetFieldProperty($field_name, "cols", "edit", "lower", "23");
                            $field_edit_type     = $fp_edit_type = $this->GetFieldProperty($field_name, "edit_type");
                            $field_wysiwyg_width = $fp_width     = $this->GetFieldProperty($field_name, "width", "edit", "lower", "0");
                            $field_class         = "";
                            $fp_upload_images = $this->GetFieldProperty($field_name, "upload_images", "edit", "lower", "false");
                            $fp_upload_images = (!$this->isDemo && ($fp_upload_images == true || $fp_upload_images == "true")) ? "true" : "false";
                            
                            if(strtolower($field_edit_type) == "wysiwyg"){
                                $field_maxlength = "";
                            }else if(($resizable === true) || ($resizable == "true")) {
                                $field_class = "class='resizable'";
                            }
                            
                            $texarea  = $this->nbsp."<textarea ".$field_class." id='".$full_field_name."' name='".$full_field_name."' title='".$this->GetFieldTitle($field_name)."' rows='".$field_rows."' cols='".$field_cols."' ".$field_maxlength." ".$field_width." ".$readonly." ".$on_js_event." >".trim($field_value)."</textarea>".$this->nbsp;
                            if(strtolower($field_edit_type) == "wysiwyg"){
                                $texarea .= $this->nbsp.$this->ScriptOpen("\n");
                                $texarea .= "wysiwygWidth = ".((intval($field_wysiwyg_width) > ((9.4)*$field_cols)) ? intval($field_wysiwyg_width) : ((9.4)*$field_cols)).";";
                                $texarea .= "wysiwygHeight = ".(21*$field_rows).";";
                                $texarea .= "generate_wysiwyg('".$full_field_name."', ".$fp_upload_images.");";  
                                $texarea .= $this->ScriptClose();
                            }
                            return $fp_pre_addition.$texarea.$fp_post_addition;    
                            break;                    
                        case "textbox":                           
                            $field_value = str_replace('"', "&quot;", $field_value); // double quotation mark
                            $field_value = str_replace("'", "&#039;", $field_value); // single quotation mark
                            if($template != "") $template = "template='".$template."'";
                            return $fp_pre_addition.$this->nbsp."<input class='".$this->cssClass."_dg_textbox' ".$field_width." type='text' title='".$this->GetFieldTitle($field_name)."' name='".$full_field_name."' id='".$full_field_name."' value='".trim($field_value)."' ".$field_maxlength." ".$readonly." ".$on_js_event." ".$autocomplete." ".$template."/>".$this->nbsp.$fp_post_addition;
                            break;
                        case "time":
                            if(strtolower($show_seconds) == "true" or $show_seconds === true){
                                $time_format = "H:i:s";
                                $floating_time_format = "%H:%M:%S";
                                $formated_field_value = $field_value;
                            }else{
                                $time_format = "H:i";
                                $floating_time_format = "%H:%M";
                                $formated_field_value = substr($field_value, 0, 5);
                            }
                            $ret_date  = $this->nbsp."<input class='".$this->cssClass."_dg_textbox' ".$field_width." readonly type='text' title='".$this->GetFieldTitle($field_name)."' name='".$full_field_name."' id='".$full_field_name."' value='".trim($formated_field_value)."' $field_maxlength ".$on_js_event." />";
                            if($fp_calendar_type == "floating"){
                                if(!$readonly) $ret_date .= "<img id='img".$full_field_name."' src='".$this->directory."styles/".$this->cssClass."/images/cal.gif' alt='".$this->lang['set_date']."' title='".$this->lang['set_date']."' align='top' style='cursor:pointer;margin:3px;margin-left:6px;margin-right:6px;border:0px;' />\n".$this->ScriptOpen()."Calendar.setup({firstDay : ".$this->weekStartingtDay.", inputField : '".$full_field_name."', ifFormat : '".$floating_time_format."', showsTime : true, button : 'img".$full_field_name."'});".$this->ScriptClose().$this->nbsp;
                            }else{
                                if(!$readonly) $ret_date .= "<a class='".$this->cssClass."_dg_a2' title='".$this->GetFieldTitle($field_name)."' href=\"javascript:openCalendar('".(($this->ignoreBaseTag) ? $this->HTTP_HOST."/" : "").$this->directory."','','".$this->uniquePrefix."frmEditRow','".$field_req_type.$field_name.$multirow_postfix."','".$field_name.$multirow_postfix."','$field_type')\"><img src='".$this->directory."styles/".$this->cssClass."/images/cal.gif' alt='".$this->lang['set_date']."' title='".$this->lang['set_date']."' align='top' style='margin:3px;margin-left:6px;margin-right:6px;border:0px;' /></a>".$this->nbsp;
                            }
                            if(!$readonly) $ret_date .= "<a class='".$this->cssClass."_dg_a2' style='cursor: pointer;' onClick='document.getElementById(\"".$full_field_name."\").value=\"".@date($time_format)."\"'>[".@date($time_format)."]</a>";
                            if((!$readonly) && (substr($this->GetFieldRequiredType($field_name), 0, 1) == "s")) $ret_date .= " <a class='".$this->cssClass."_dg_a2'  style='cursor: pointer;' onClick='document.getElementById(\"".$full_field_name."\").value=\"\"' title='".$this->lang['clear']."'>[".$this->lang['clear']."]</a>";
                            return $fp_pre_addition.$ret_date.$fp_post_addition;
                            break;
                        case "validator": 
                            $fp_for_field       = $this->GetFieldProperty($field_name, "for_field");
                            $fp_validation_type = $this->GetFieldProperty($field_name, "validation_type");
                            $field_req_type                 = $this->GetFieldRequiredType($fp_for_field, true);
                            if($fp_validation_type == "password"){ $validator_field_type = "password"; } else { $validator_field_type = "text"; }
                            return $fp_pre_addition.$this->nbsp."<input type='".$validator_field_type."' class='".$this->cssClass."_dg_textbox' ".$field_width." title='".$this->GetFieldTitle($field_name)."' name='".$field_req_type.$fp_for_field.$multirow_postfix."' id='".$field_req_type.$fp_for_field.$multirow_postfix."' value='' $field_maxlength $readonly ".$on_js_event." />".$this->nbsp.$fp_post_addition;
                            break;                        
                        default:
                            return $fp_pre_addition.$this->nbsp."<input type='text' class='".$this->cssClass."_dg_textbox' ".$field_width." title='".$this->GetFieldTitle($field_name)."' name='".$full_field_name."' id='".$full_field_name."' value='".trim($field_value)."' $field_maxlength $readonly ".$on_js_event." />".$this->nbsp.$fp_post_addition;
                            break;
                    }
                }else if($mode === "details"){
                    switch($field_type){
                        case "blob":
                            $sizeinbytes = strlen($field_value);
                            return $fp_pre_addition.$this->nbsp."[BLOB] - ".$sizeinbytes." B".$this->nbsp.$fp_post_addition; 
                            break;
                        case "checkbox":
                            return $fp_pre_addition.$this->nbsp.(($field_value == 1) ? $this->lang['yes'] : $this->lang['no']).$this->nbsp.$fp_post_addition;
                            break;                        
                        case "date":
                            $field_value = trim($field_value);
                            return $fp_pre_addition.$this->nbsp.(($field_value == '0000-00-00') ? '' : $field_value).$this->nbsp.$fp_post_addition;
                            break;
                        case "datedmy":
                            return $fp_pre_addition.$this->nbsp.$this->MyDate($field_value, "datedmy").$this->nbsp.$fp_post_addition;
                            break;                        
                        case "datemdy":
                            return $fp_pre_addition.$this->nbsp.$this->MyDate($field_value, "datemdy").$this->nbsp.$fp_post_addition;
                            break;                        
                        case "datetime":
                            $field_value = trim($field_value);
                            return $fp_pre_addition.$this->nbsp.(($field_value == '0000-00-00 00:00:00') ? '' : $this->MyDate($field_value, "datetime", $show_seconds)).$this->nbsp.$fp_post_addition;
                            break;                        
                        case "datetimedmy":
                            return $fp_pre_addition.$this->nbsp.$this->MyDate($field_value, "datetimedmy", $show_seconds).$this->nbsp.$fp_post_addition;
                            break;                            
                        case "enum":
                            // don't remove columns_edit_mode
                            if(isset($this->columnsEditMode[$field_name]['source']) && is_array($this->columnsEditMode[$field_name]['source'])){                                
                                foreach($this->columnsEditMode[$field_name]['source'] as $val => $opt){
                                    if($field_value == $val) return $this->nbsp.trim($opt).$this->nbsp;
                                }
                            }                        
                            return $fp_pre_addition.$this->nbsp.trim($field_value).$this->nbsp.$fp_post_addition;
                            break;
                        case "file":
                            $fp_target_path   = $this->GetFieldProperty($field_name, "target_path");
                            $fp_allow_downloading = $this->GetFieldProperty($field_name, "allow_downloading");
                            
                            if($fp_allow_downloading) $field_value .= "<br /><a class='x-blue_dg_a' href='".$fp_target_path.$field_value."' title='".$this->lang['click_to_download']."'>[".$this->lang['download']."]</a>";                            
                            return $fp_pre_addition.$this->nbsp.trim($field_value).$fp_post_addition;                         
                            break;
                        case "hidden":
                            return "";  break;                        
                        case "image":
                            $fp_target_path   = $this->GetFieldProperty($field_name, "target_path");
                            $fp_image_width   = $this->GetFieldProperty($field_name, "image_width", "edit", "lower", "50px");
                            $fp_image_height  = $this->GetFieldProperty($field_name, "image_height", "edit", "lower", "30px");
                            $fp_default       = $this->GetFieldProperty($field_name, "default", "edit", "normal");
                            $img_default                  = (($fp_default != "") && file_exists($fp_target_path.trim($fp_default))) ? "<img src='".$fp_target_path.$fp_default."' width='".$fp_image_width."' height='".$fp_image_height."' alt='' title=''>" : "<span class='".$this->cssClass."_dg_label'>".$this->lang['no_image']."</span>";                    
                            $fp_magnify       = $this->GetFieldProperty($field_name, "magnify", "edit", "normal");
                            $fp_magnify_type  = $this->GetFieldProperty($field_name, "magnify_type", "edit", "normal");
                            $fp_magnify_power = $this->GetFieldProperty($field_name, "magnify_power", "edit", "normal");
                            $fp_magnify_power = (is_numeric($fp_magnify_power)) ? $fp_magnify_power : "2";
                            $img_src                      = $fp_target_path.trim($field_value);
                            $fp_allow_downloading = $this->GetFieldProperty($field_name, "allow_downloading");
                            
                            if((trim($field_value) !== "") && file_exists($fp_target_path.trim($field_value))){
                                $ret_image_img = $this->nbsp."<img style='vertical-align: middle; border:1px;' src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event.">".$this->nbsp;
                                if(($fp_magnify == "true") || ($fp_magnify == true)){
                                    if($fp_magnify_type == "lightbox"){
                                        if((trim($field_value) !== "") && file_exists($img_src)){
                                            $ret_image_img = $this->nbsp."<a href='".$img_src."' rel='lytebox' title=''><img style='vertical-align: middle; border:0px solid #cccccc;' src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event."></a>".$this->nbsp;
                                        }
                                    }else if($fp_magnify_type == "popup"){
                                        if((trim($field_value) !== "") && file_exists($img_src)){
                                            $ret_image_img = $this->nbsp."<a href=\"javascript:new_win = window.open('".$img_src."','ImageViewer','left=100,top=100,width=400,height=300,toolbar=0,resizable=1,location=0,scrollbars=1'); new_win.focus();\" title=''><img style='vertical-align: middle; border:0px solid #cccccc;' src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event."></a>".$this->nbsp;                                            
                                        }
                                    }else if($fp_magnify_type == "magnifier"){
                                        $img_magnify = "onmouseover='showtrail(\"".$img_src."\",\"\",\"\",\"1\", ".($fp_image_height*$fp_magnify_power).", 1, ".($fp_image_width*$fp_magnify_power).");' onmouseout='hidetrail();'";
                                        if((trim($field_value) !== "") && file_exists($img_src)){
                                            $ret_image_img = $this->nbsp."<img style='vertical-align: middle; border:1px;' src='".$img_src."' width='".$fp_image_width."' height='".$fp_image_height."' ".$on_js_event." ".$img_magnify.">".$this->nbsp;
                                        }
                                    }
                                }
                                $ret_image = $ret_image_img;
                                if($fp_allow_downloading) $ret_image .= "<br /><a class='x-blue_dg_a' href='".$img_src."' title='".$this->lang['click_to_download']."'>[".$this->lang['download']."]</a>";
                                return $fp_pre_addition.$ret_image.$fp_post_addition;                            
                            }else{
                                return $fp_pre_addition."<table style='BORDER: solid 1px #000000;' width='".$fp_image_width."' height='".$fp_image_height."'><tr><td align='center'>".$img_default."</td></tr></table>".$fp_post_addition;
                            }
                            break;
                        case "label":
                            return $fp_pre_addition.$this->nbsp."<label class='".$this->cssClass."_dg_label' ".$on_js_event.">".trim($field_value)."</label>".$this->nbsp.$fp_post_addition;
                            break;
                        case "link":                        
                            $fp_field_data = $this->GetFieldProperty($field_name, "field_data", "edit", "normal");
                            if($fp_field_data != ""){
                                // [#0011 under check - 21.11.09] - start
                                // [#0011 under check - 21.11.09] - end
                                
                                $href = $href_inner = $fp_href = $this->GetFieldProperty($field_name, "href");
                                $fp_target = $this->GetFieldProperty($field_name, "target");
                                $on_js_event  = $this->GetFieldProperty($field_name, "on_js_event", "details", "normal");
                                foreach ($this->columnsEditMode[$field_name] as $search_field_key => $search_field_value){
                                    if(substr($search_field_key, 0, 9) == "field_key"){
                                        $field_number = intval(substr($search_field_key, 10, strlen($search_field_key) - 10));
                                        $field_inner = ($this->GetFieldOffset($search_field_value) != "-1") ? $row[$this->GetFieldOffset($search_field_value)] : "";                                        
                                        if(strpos($href_inner, "{".$field_number."}") >= 0){
                                            $href = str_replace("{".$field_number."}", $field_inner, $href);
                                        }                                   
                                    }                               
                                }
                                
                                // remove unexpected 'http://'s
                                if(strstr($fp_href, "https://") != "" || strstr($href, "https://") != ""){
                                    $href = str_replace(array("https://", "http://"), "", $href);
                                    $href = "https://".$href;
                                }else if(strstr($href_inner, "http://") != ""){
                                    $href = str_replace("http://", "", $href);
                                    $href = "http://".$href;
                                }
                                $link_value = ($this->GetFieldOffset($fp_field_data) != "-1") ? trim($row[$this->GetFieldOffset($fp_field_data)]) : "";
                                return $fp_pre_addition.$this->nbsp."<a class='".$this->cssClass."_dg_a2' ".(($href != "") ? "href='".$href."'" : "style='cursor:pointer;'")." target='".$fp_target."' ".$on_js_event.">".$link_value."</a>".$this->nbsp.$fp_post_addition;
                            }else{
                                return $fp_pre_addition.$this->nbsp.$field_value.$this->nbsp.$fp_post_addition;
                            }                        
                            break;                        
                        case "money": 
                            $fp_decimal_places   = $this->GetFieldProperty($field_name, "decimal_places", "edit"); 
                            $fp_dec_separator    = $this->GetFieldProperty($field_name, "dec_separator", "edit"); 
                            $fp_thousands_separator = $this->GetFieldProperty($field_name, "thousands_separator", "edit");                        
                            $fp_money_sign       = $this->GetFieldProperty($field_name, "sign", "edit");
                            $money_sign_after                = $money_sign_before = "";
                            if($this->GetFieldProperty($field_name, "sign_place", "edit") == "before"){
                                $money_sign_before = $fp_money_sign;                            
                            }else{                                                        
                                $money_sign_after  = $fp_money_sign;
                            }
                            return $fp_pre_addition.$this->nbsp.$money_sign_before."<label class='".$this->cssClass."_dg_label' ".$on_js_event.">".number_format($field_value, $fp_decimal_places, $fp_dec_separator, $fp_thousands_separator)."</label>".$money_sign_after.$this->nbsp.$fp_post_addition;
                            break;                     
                        case "password":
                            return $fp_pre_addition.$this->nbsp."<label class='".$this->cssClass."_dg_label'>".(($fp_hide == "true" || $fp_hide == true) ? "******" : $field_value)."</label>".$this->nbsp.$fp_post_addition;
                            break;                    
                        case "print":
                            return $fp_pre_addition.$this->nbsp."<label class='".$this->cssClass."_dg_label' ".$field_width.">".trim($field_value)."</label>".$this->nbsp.$fp_post_addition; 
                            break;
                        case "textarea":
                        case "textbox":
                            return $fp_pre_addition.$this->nbsp.trim($field_value).$fp_post_addition; 
                            break;
                        case "validator":
                            return "";  break;                        
                        default:
                            return $fp_pre_addition.$this->nbsp.trim($field_value).$fp_post_addition; 
                            break;
                    }                                        
                }
            }                        
        }
        return false;
    }


    //--------------------------------------------------------------------------
    // Add check voxes values
    //--------------------------------------------------------------------------
    protected function AddCheckBoxesValues($multirow_postfix = ""){
        $toggle_status = $this->GetVariable('toggle_status', false);
        $toggle_field = $this->GetVariable('toggle_field', false);
        $toggle_field_value = $this->GetVariable('toggle_field_value', false);
        if($toggle_status == "1"){
            // toggle checkbox values for View Mode 
            $_POST["syy".$toggle_field] = $toggle_field_value;            
        }else{
            // save checkbox values for Edit Mode 
            foreach($this->columnsEditMode as $itemName => $itemValue){
                $full_field_name = $this->GetFieldRequiredType($itemName).$itemName.$multirow_postfix;
                if(isset($itemValue['type']) && $itemValue['type'] == "checkbox"){
                    $found = false;
                    foreach($_POST as $i => $v){
                        if($i == $full_field_name){
                            $found = true;
                        }
                    }
                    if(!$found){                    
                        $_POST[$full_field_name] = $itemValue['false_value'];
                    }else{
                        $_POST[$full_field_name] = $itemValue['true_value'];
                    }
                }            
            }            
        }
    }

    //--------------------------------------------------------------------------
    // Get $_REQUEST variable
    //--------------------------------------------------------------------------
    protected function GetVariable($var = "", $prefix = true, $method = "request"){
        $prefix = (($prefix == true) || ($prefix == "true")) ? true : false;
        $unique_prefix = ($prefix) ? $this->uniquePrefix : "" ;
        $unique_prefix_var = (isset($_GET[$unique_prefix.$var])) ? $_GET[$unique_prefix.$var] : "0";

        // check for possible hack attack        
        $max_page_size = intval(max($this->arrPages));
        if(($var == "page_size") && (intval($unique_prefix_var) > intval($max_page_size))) {
            return $max_page_size; 
        } 
 
        switch($method){
            case "get":
                return isset($_GET[$unique_prefix.$var]) ? $_GET[$unique_prefix.$var] : "";                                
                break;
            case "post":
                return isset($_POST[$unique_prefix.$var]) ? $_POST[$unique_prefix.$var] : "";                                
                break;
            default:
                return isset($_REQUEST[$unique_prefix.$var]) ? $_REQUEST[$unique_prefix.$var] : "";                                
                break;
        }
    }

    //--------------------------------------------------------------------------
    // Draw RadioButtons
    //--------------------------------------------------------------------------
    protected function DrawRadioButtons($tag_name, $field_name, &$select_array, $compare = "", $sub_field_value="", $sub_field_name="", $disabled="", $on_js_event="", $radiobuttons_alignment=""){
        $break_by = ($radiobuttons_alignment == "vertical") ? "<br />" : "";
        $text = "";
        if(!$this->isPrinting){
            if($on_js_event !="") $text .= "<span ".$on_js_event.">";
            if(is_object($select_array)){
                while($row = $select_array->fetchRow()){
                    if(strtolower($row[$this->arrForeignKeys[$field_name][$sub_field_value]]) == strtolower($compare)){                        
                        $text .= "<input class='".$this->cssClass."_dg_radiobutton' type='radio' title='".$this->GetFieldTitle($field_name)."' name='".$tag_name."' id='".$tag_name."' value='".$row[$this->arrForeignKeys[$field_name][$sub_field_value]]."' checked ".$disabled.">".$row[$this->arrForeignKeys[$field_name][$sub_field_name]].$this->nbsp.$break_by;                    
                    }else{
                        $text .= "<input class='".$this->cssClass."_dg_radiobutton' type='radio' title='".$this->GetFieldTitle($field_name)."' name='".$tag_name."' id='".$tag_name."' value='".$row[$this->arrForeignKeys[$field_name][$sub_field_value]]."'  ".$disabled.">".$row[$this->arrForeignKeys[$field_name][$sub_field_name]].$this->nbsp.$break_by;
                    }
                }                
            }else{
                foreach($select_array as $key => $val){
                    if(strtolower($key) == strtolower($compare)){
                        $text .= "<input class='".$this->cssClass."_dg_radiobutton' type='radio' id='".$tag_name."' name='".$tag_name."' value='".$key."' title='".$this->GetFieldTitle($field_name)."' checked  ".$disabled.">".$val." ".$break_by;                    
                    }else{
                        $text .= "<input class='".$this->cssClass."_dg_radiobutton' type='radio' id='".$tag_name."' name='".$tag_name."' value='".$key."' title='".$this->GetFieldTitle($field_name)."'  ".$disabled.">".$val." ".$break_by;
                    }
                }                
            }
            if($on_js_event !="") $text .= "</span>";            
        }else{
            if(is_object($select_array)){
                $found = 0;
                while(($row = $select_array->fetchRow()) && (!$found)){                    
                    if(strtolower($row[$this->arrForeignKeys[$field_name][$sub_field_value]]) == strtolower($compare)){ 
                        $text .= "<span ".$on_js_event.">".$row[$this->arrForeignKeys[$field_name][$sub_field_name]]."</span>";
                        $found = 1;
                    }                        
                }
                if($found == 0) $text .= "<span ".$on_js_event.">none</span>";                
            }else{
                $text = $compare;        
            }            
        }
        return $text;
    }

    //--------------------------------------------------------------------------
    // Draw checkboxes
    //--------------------------------------------------------------------------
    protected function DrawCheckBoxes($tag_name, $foo_name, &$select_array, $compare = "", $field_name="", $sub_field_value="", $sub_field_name="", $disabled="", $on_js_event="", $multiple=false, $multiple_size="4"){                       
        $text = "";
        $checkboxes_count = 0;
        $tag_id = $tag_name;
        $tag_name = ($multiple) ? $tag_name = $tag_name."[]" : $tag_name;
        $readonly = "";
        if(!$this->isPrinting){
            if(is_array($select_array)){
                if(!is_array($compare)){ $split_compare = explode(",", $compare); }else{ $split_compare = $compare; }
                $text .= "<input class='".$this->cssClass."_dg_checkbox' type='hidden' name='".$tag_name."' id='".$tag_id."' value='' />";                
                foreach($select_array as $key => $val){
                    $checked = "";                    
                    if(count($split_compare) >= 1){
                        foreach($split_compare as $spl_val){
                            if($spl_val == $key) {$checked = "checked"; break; }	
                        }
                    }else{
                        $checked = ((strtolower($compare) == strtolower($key)) ? "checked" : "");
                    }
                    $text .= "<input class='".$this->cssClass."_dg_checkbox' type='checkbox' name='".$tag_name."' id='".$tag_id."' title='".$this->GetFieldTitle($field_name)."' value='".$key."' ".$checked." ".$readonly." ".$on_js_event." /> ".$val." ";
                    if($multiple && (++$checkboxes_count % $multiple_size == 0)) $text .= "<br />";
                }
            }
        }else{
            $text = $compare;     
        }
        return $text;

    }
    
    //--------------------------------------------------------------------------
    // Draw drop-down list
    //--------------------------------------------------------------------------
    protected function DrawDropDownList($tag_name, $foo_name, &$select_array, $compare = "", $field_name="", $sub_field_value="", $sub_field_name="", $disabled="", $on_js_event="", $multiple=false, $multiple_size="4", $draw_select_option = false){                       
        $text = "";
        $multiple_parameters = ($multiple) ? $multiple_parameters = "multiple size='".$multiple_size."'" : "";
        $tag_id = $tag_name;
        $tag_name = ($multiple) ? $tag_name = $tag_name."[]" : $tag_name;        
        if(!$this->isPrinting){
            if(is_object($select_array)){
                $text = "<select class='".$this->cssClass."_dg_select' name='".$tag_name."' id='".$tag_id."' title='".$this->GetFieldTitle($field_name)."' ".(($foo_name != "") ? "onChange='".$this->uniquePrefix.$foo_name."'" : "")." ".$disabled." ".$on_js_event." ".$multiple_parameters.">";
                $text .= "<option value=''>-- ".$this->lang['select']." --</option>";
                if($this->dbHandler->isError($select_array) != 1){
                    while($row = $select_array->fetchRow()){
                        $ff_name = $this->arrForeignKeys[$field_name][$sub_field_name];
                        if(preg_match("/ as /i", strtolower($ff_name))) $ff_name = substr($ff_name, strpos(strtolower($ff_name), " as ")+4);                        
                        if(strtolower($row[$this->arrForeignKeys[$field_name][$sub_field_value]]) == strtolower($compare)) 
                            $text .= "<option selected='selected' style='font-weight:bold;' value='".$row[$this->arrForeignKeys[$field_name][$sub_field_value]]."'>".$row[$ff_name]."</option>";
                        else 
                            $text .= "<option value='".$row[$this->arrForeignKeys[$field_name][$sub_field_value]]."'>".$row[$ff_name]."</option>";
                    }
                }
            }else{
                if(!is_array($compare)){ $split_compare = explode(",", $compare); }else{ $split_compare = $compare; }
                $text = "<select class='".$this->cssClass."_dg_select' name='".$tag_name."' id='".$tag_id."' title='".$this->GetFieldTitle($field_name)."' ".(($foo_name != "") ? "onChange='".$this->uniquePrefix.$foo_name."'" : "")." ".$disabled." ".$on_js_event." ".$multiple_parameters.">";
                if($draw_select_option) $text .= "<option value=''>-- ".$this->lang['select']." --</option>";
                foreach($select_array as $key => $val){
                    $selected = "";
                    if(count($split_compare) > 1){
                        foreach($split_compare as $spl_val){
                            if($spl_val == $key) {$selected = "selected='selected' style='font-weight:bold;'"; break; }	
                        }
                    }else{
                        $selected = ((strtolower($compare) == strtolower(str_replace("''", "'", $key))) ? "selected='selected' style='font-weight:bold;'" : "");
                    }
                    
                    if(is_array($val)){
                        $text .= "<optgroup label='".$key."'>";
                        foreach($val as $val_key => $val_val){
                            $selected = ((strtolower($compare) == strtolower($val_key)) ? "selected='selected' style='font-weight:bold;'" : "");
                            $text .= "<option ".$selected." value='".$val_key."'>(".$val_key.") ".$val_val."</option>";
                        }
                        $text .= "</optgroup>";
                    }else{
                        $text .= "<option ".$selected." value='".$key."'>".$val."</option>";
                    }
                }
            }
            $text .= "</select>";
        }else{
            if(is_object($select_array)){
                $found = 0;
                while(($row = $select_array->fetchRow()) && (!$found)){                    
                    if(strtolower($row[$this->arrForeignKeys[$field_name][$sub_field_value]]) == strtolower($compare)){
                        $text .= "<span>".$row[$this->arrForeignKeys[$field_name][$sub_field_name]]."</span>";
                        $found = 1;
                    }                        
                }
                if($found == 0) $text .= "<span>none</span>";                
            }else{
                $text = $compare;        
            }            
        }
        return $text;
    }

    //--------------------------------------------------------------------------
    // Draw control duttons (details and delete)
    //--------------------------------------------------------------------------
    protected function DrawControlButtons($row_id = ""){        
        if(isset($this->modes['details'][$this->mode]) && $this->modes['details'][$this->mode]){
            $this->ColOpen("center",0,"nowrap");
            $this->DrawModeButton("details", "javascript:".$this->uniquePrefix."_doPostBack(\"details\",".$this->EncodeParameter($row_id).");", $this->lang['details'], $this->lang['view_details'], "details.gif", "''", false, $this->nbsp, "");                        
            $this->ColClose();
        }
        if(isset($this->modes['delete'][$this->mode]) && $this->modes['delete'][$this->mode]){
            $this->ColOpen("center",0,"nowrap");  
            $this->DrawModeButton("delete", "javascript:".$this->uniquePrefix."verifyDelete(".$this->EncodeParameter($row_id).");", $this->lang['delete'], $this->lang['delete_record'], "delete.gif", "''", false, "", "");                        
            $this->ColClose();
        }
    }

    //--------------------------------------------------------------------------
    // Draw mode button
    //--------------------------------------------------------------------------
    protected function DrawModeButton($mode, $mode_url, $botton_name, $alt_name, $image_file, $onClick="''", $div_align=false, $nbsp="", $type="", $is_return=false){
        if($type == ""){
            $mode_type = (isset($this->modes[$mode]['type'])) ? $this->modes[$mode]['type'] : "";
        }else{
            $mode_type = $type;
        }
        $return_value = "";        
        if(!$this->isError){                
            if(!$this->isPrinting){
                switch($mode_type){
                    case "button":
                        $onClick = ($onClick != "''" && $onClick != "") ? $onClick : '"'.str_replace('"', "'", $mode_url).'"';
                        $return_value .= $nbsp."<input class='".$this->cssClass."_dg_button' type='button' ";
                        if($div_align){ $return_value .= "style='float: "; $return_value .= ($this->direction == "rtl")?"right":"left"; $return_value .= "' "; }                    
                        $return_value .= "onClick=$onClick value='".$botton_name."'>".$nbsp;
                        break;
                    case "image":                        
                        $onClick = ($onClick != "''" && $onClick != "") ? $onClick : '"'.str_replace('"', "'", $mode_url).'"';
                        if($div_align){ $return_value .= "<div style='float:"; $return_value .= ($this->direction == "rtl")?"right":"left"; $return_value .= ";'>"; }
                        $return_value .= $nbsp."<img style='cursor:pointer; vertical-align: middle;' onClick=".$onClick." src='".$this->directory."styles/".$this->cssClass."/images/".$image_file."' alt='$alt_name' title='$alt_name' />".$nbsp;
                        if($div_align) $return_value .= "</div>"; 
                        break;                        
                    default:
                        if($div_align){ $return_value .= "<div style='float:"; $return_value .= ($this->direction == "rtl")?"right":"left"; $return_value .= ";'>"; }
                        $return_value .= $nbsp."<a class='".$this->cssClass."_dg_a".(($mode == "add") ? "_header" : "")."' href='$mode_url' onClick=".$onClick." title='$alt_name'>".$botton_name."</a>".$nbsp;
                        if($div_align) $return_value .= "</div>"; 
                        break;
                }
            }else{
                switch($mode_type){                    
                    case "button":
                        $return_value .= "<span ";
                        if($div_align){ $return_value .= "style='float: "; $return_value .= ($this->direction == "rtl")?"right":"left"; $return_value .= "' "; }                                        
                        $return_value .= ">".$botton_name."</span>";
                        break;
                    case "image":
                        if($div_align){ $return_value .= "<div style='float:"; $return_value .= ($this->direction == "rtl")?"right":"left"; $return_value .= ";'>"; }
                        $return_value .= "<img style='vertical-align: middle;' src='".$this->directory."styles/".$this->cssClass."/images/".$image_file."' readonly>";
                        if($div_align) $return_value .= "</div>";     
                        break;                        
                    default:
                        if($div_align){ $return_value .= "<div style='float:"; $return_value .= ($this->direction == "rtl")?"right":"left"; $return_value .= ";'>"; }
                        $return_value .= $nbsp."<span class='".$this->cssClass."_dg_a' >".$botton_name."</span>".$nbsp;
                        if($div_align) $return_value .= "</div>"; 
                        break;
                }
            }
        }
        if($is_return == true){
            return $return_value;
        }else{
            echo $return_value;    
        }        
    }
   
    //--------------------------------------------------------------------------
    // Set common JavaScriptAjax
    //--------------------------------------------------------------------------
    function SetCommonJavaScriptAjax(){        
        if($this->ajaxEnabled){
            $is_test = false;
            echo $this->ScriptOpen("\n", "src='".$this->directory."scripts/dg_ajax.js'").$this->ScriptClose("");
        }
        echo $this->ScriptOpen();
            if($this->scrollingOption && $this->mode == "view"){ $run_scrolling = true; $scrolling_height = $this->scrollingHeight; }
            else{ $run_scrolling = false; $scrolling_height = $this->scrollingHeight; }

            echo "function ".$this->uniquePrefix."_doAjaxRequest(query_string, http_url){
                var http_url = (http_url != null) ? http_url : '".$this->HTTP_URL."';
                dg_doAjaxRequest(query_string, '".$this->uniquePrefix."', http_url, ".(($this->debug) ? "true": "false").", '".$run_scrolling."', '".$scrolling_height."'); \n
            }\n";              
            echo $this->jsCode."\n";                        
            echo "function ".$this->uniquePrefix."_doOpenFloatingCalendar(textbox_id, if_format, show_time){
                Calendar.setup({firstDay : ".$this->weekStartingtDay.", inputField : textbox_id, ifFormat : if_format, showsTime : show_time, button : 'img_'+textbox_id}); \n}\n";
            
            if($this->scrollingOption && $this->mode == "view"){                
                echo "var t = new ScrollableTable(document.getElementById('".$this->uniquePrefix."_contentTable'), '".$this->scrollingHeight."');\n";
            }
        echo $this->ScriptClose();            
    }
    
    //--------------------------------------------------------------------------
    // Set common JavaScript
    //--------------------------------------------------------------------------
    protected function SetCommonJavaScript(){
        $req_mode = $this->GetVariable('mode');
        $req_new = $this->GetVariable('new');
        $magnify_field_lightbox = false;
        $magnify_field_magnifier = false;
        
        // change mode after update
        if(($req_mode == "update") && ($req_new != 1) && ($this->modeAfterUpdate == "edit")){
            $req_mode = $this->modeAfterUpdate;
        }
        echo "\n<!-- START This script was generated by datagrid.class.php v.".$this->dgVersion." (http://www.apphp.com/php-datagrid/index.php) START -->";
        $this->CheckExistingFields();

        // set common JavaScript
        if (!file_exists($this->directory.'scripts/dg.js') && $this->debug) {            
            echo "<label class='".$this->cssClass."_dg_error_message no_print'>Cannot find file: <b>".$this->directory."scripts/dg.js</b>. Check if this file exists and you use a correct path!</label><br /><b>";
        }else{
            if(!defined("_DG_JS_INCLUDED")){
                echo $this->ScriptOpen("\n", "src='".$this->directory."scripts/dg.js'").$this->ScriptClose("");
                echo $this->ScriptOpen("", "src='".$this->directory."languages/js/dg-".$this->GetLangAbbrForDG().".js'").$this->ScriptClose("");
                define("_DG_JS_INCLUDED", true);
            }
        }        

        if($req_mode == "details"){
            if (($this->existingFields['magnify_field_edit']) && ($this->existingFields['magnify_field_edit_lightbox'])) $magnify_field_lightbox = true;
            if (($this->existingFields['magnify_field_edit']) && ($this->existingFields['magnify_field_edit_magnifier'])) $magnify_field_magnifier = true;
           
        }else if(($req_mode == "add") || ($req_mode == "edit")){
            if (($this->existingFields['magnify_field_edit']) && ($this->existingFields['magnify_field_edit_lightbox'])) $magnify_field_lightbox = true;
            if (($this->existingFields['magnify_field_edit']) && ($this->existingFields['magnify_field_edit_magnifier'])) $magnify_field_magnifier = true;

            // include form checking script, if needed
            if (!file_exists($this->directory.'modules/jsafv/form.scripts.js') && $this->debug) {            
                echo "<label class='".$this->cssClass."_dg_error_message no_print'>Cannot find file: <b>".$this->directory."modules/jsafv/form.scripts.js</b>. Check if this file exists and you use a correct path!</label><br /><br />";
            }else{
                echo $this->ScriptOpen("", "src='".$this->directory."modules/jsafv/lang/jsafv-".$this->GetLangAbbrForJSAFV().".js'").$this->ScriptClose("");
                if($this->encoding == "utf8"){
                    echo $this->ScriptOpen("", "src='".$this->directory."modules/jsafv/chars/diactric_chars_utf8.js'").$this->ScriptClose("");
                }else{
                    echo $this->ScriptOpen("", "src='".$this->directory."modules/jsafv/chars/diactric_chars.js'").$this->ScriptClose("");
                }
                echo $this->ScriptOpen("", "src='".$this->directory."modules/jsafv/form.scripts.js'").$this->ScriptClose("");
            }
            // include resizable textarea script, if needed        
            if ($this->existingFields['resizable_field'] && !defined("_DG_RESIZE_INCLUDED")){
                if (!file_exists($this->directory.'scripts/resize.js') && $this->debug) {            
                    echo "<label class='".$this->cssClass."_dg_error_message no_print'>Cannot find file: <b>".$this->directory."scripts/resize.js</b>. Check if this file exists and you use a correct path!</label><br /><br />";
                }else{
                    echo $this->ScriptOpen("", "src='".$this->directory."modules/jquery/jquery.js'").$this->ScriptClose("");
                    echo $this->ScriptOpen("", "src='".$this->directory."scripts/resize.js'").$this->ScriptClose("");
                }
                define("_DG_RESIZE_INCLUDED", true);
            }            
            // include WYSIWYG script, if needed
            if ($this->existingFields['wysiwyg_field']) {            
                // set WYSIWYG
                echo $this->ScriptOpen("\n");
                echo "imagesDir = '".$this->directory."modules/wysiwyg/icons/';\n";  // Images Directory
                echo "cssDir = '".$this->directory."modules/wysiwyg/styles/';\n";    // CSS Directory
                echo "popupsDir = '".$this->directory."modules/wysiwyg/popups/';\n"; // Popups Directory
                echo "addonsDir = '".$this->directory."modules/wysiwyg/addons/';\n"; // AdOne Directory
                echo $this->ScriptClose();
                echo $this->ScriptOpen("", "src='".$this->directory."modules/wysiwyg/wysiwyg.js'").$this->ScriptClose("");
                if($this->isDemo){
                    if(isset($_SESSION)) $_SESSION['wysiwyg_image_uploading'] = false;
                }else{
                    if(isset($_SESSION)) $_SESSION['wysiwyg_image_uploading'] = true;
                }
            }
            // set verify JS functions
            if(isset($this->modes['cancel'][$this->mode]) && $this->modes['cancel'][$this->mode]){
                echo $this->ScriptOpen("\n");
                echo "function ".$this->uniquePrefix."verifyCancel(rid, param){if(confirm(\"".$this->lang['cancel_creating_new_record']."\")){ ".$this->uniquePrefix."_doPostBack(\"cancel\",rid,param); } else { false;}};";
                echo $this->ScriptClose();                                           
            }
        }else{ // view mode            
            if (($this->existingFields['magnify_field_view']) && ($this->existingFields['magnify_field_view_lightbox'])) $magnify_field_lightbox = true;
            if (($this->existingFields['magnify_field_view']) && ($this->existingFields['magnify_field_view_magnifier'])) $magnify_field_magnifier = true;

            // include autosuggest.js file and other for AutoSuggestion
            if ($this->existingFields['autosuggestion_field'] && !defined("_DG_AUTOSUGGESTION_INCLUDED")){
                echo $this->ScriptOpen("", "src='".$this->directory."modules/autosuggest/js/bsn.AutoSuggest_2.1.3.js'").$this->ScriptClose("");
                echo "\n<link rel='stylesheet' href='".$this->directory."modules/autosuggest/css/autosuggest_inquisitor.css' type='text/css' media='screen' charset='utf-8' />";
                define("_DG_AUTOSUGGESTION_INCLUDED", true);
            }
            // include overlib.js file for floating tooltips
            if ($this->existingFields['tooltip_type_floating'] && !defined("_DG_OVERLIB_INCLUDED")){
                if (!file_exists($this->directory.'modules/overlib/overlib.js') && $this->debug) {            
                    echo "<label class='".$this->cssClass."_dg_error_message no_print'>Cannot find file: <b>".$this->directory."modules/overlib/overlib.js</b>. Check if this file exists and you use a correct path!</label><br /><br />";
                }else{
                    echo $this->ScriptOpen("", "src='".$this->directory."modules/overlib/overlib.js'").$this->ScriptClose("");
                }
                define("_DG_OVERLIB_INCLUDED", true);
            }
            // include highlight.js file for rows highlighting
            if($this->isRowHighlightingAllowed && !defined("_DG_HIGHLIGHT_INCLUDED")){
                if (!file_exists($this->directory.'scripts/highlight.js') && $this->debug) {            
                    echo "<label class='".$this->cssClass."_dg_error_message no_print'>Cannot find file: <b>".$this->directory."scripts/highlight.js</b>. Check if this file exists and you use a correct path!</label><br /><br />";
                }else{                 
                    echo $this->ScriptOpen("", "src='".$this->directory."scripts/highlight.js'").$this->ScriptClose("");
                }
                define("_DG_HIGHLIGHT_INCLUDED", true);
            }
            
            if($this->scrollingOption && !defined("_DG_SCROLLING_INCLUDED")){
                // include scrolling.js file for scrolling of table
                if (!file_exists($this->directory.'scripts/scrolling.js') && $this->debug) {            
                    echo "<label class='".$this->cssClass."_dg_error_message no_print'>Cannot find file: <b>".$this->directory."scripts/scrolling.js</b>. Check if this file exists and you use a correct path!</label><br /><br />";
                }else{                 
                    echo $this->ScriptOpen("", "src='".$this->directory."scripts/scrolling.js'").$this->ScriptClose("");
                }
                define("_DG_SCROLLING_INCLUDED", true);            
            }
        }        
        // include magnify files for magnifying images
        if ($magnify_field_magnifier && !defined("_DG_MAGNIFIER_INCLUDED")){
            if (!file_exists($this->directory.'scripts/magnify.js') && $this->debug) {            
                echo "<label class='".$this->cssClass."_dg_error_message no_print'>Cannot find file: <b>".$this->directory."scripts/magnify.js</b>. Check if this file exists and you use a correct path!</label><br /><br />";
            }else{
                echo $this->ScriptOpen("", "src='".$this->directory."scripts/magnify.js'").$this->ScriptClose("");
                echo "\n<STYLE>#trailimageid { DISPLAY: none; FONT-SIZE: 0.75em; Z-INDEX: 200; LEFT: 0px; POSITION: absolute; TOP: 0px; HEIGHT: 0px }</STYLE>";
            }
            define("_DG_MAGNIFIER_INCLUDED", true);            
        }                    

        if ($magnify_field_lightbox && !defined("_DG_LIGHTBOX_INCLUDED")){
            if (!file_exists($this->directory.'modules/lightbox/js/lytebox.js') && $this->debug) {            
                echo "<label class='".$this->cssClass."_dg_error_message no_print'>Cannot find file: <b>".$this->directory."modules/lightbox/js/lytebox.js</b>. Check if this file exists and you use a correct path!</label><br /><br />";
            }else{
                echo $this->ScriptOpen("\n", "src='".$this->directory."modules/lightbox/js/lytebox.js'").$this->ScriptClose("");
                echo "\n<link rel='stylesheet' href='".$this->directory."modules/lightbox/css/lytebox.css' type='text/css' media='screen' charset='utf-8'>";        
            }
            define("_DG_LIGHTBOX_INCLUDED", true);            
        }            

        // include calendar script (floating), if needed        
        if ($this->existingFields['calendar_type_floating'] && !defined("_DG_FLOATING_CAL_INCLUDED")) {
            // set calendar JS                
            echo "<style type='text/css'>@import url(".$this->directory."modules/jscalendar/skins/aqua/theme.css);</style>\n"; 
            //<!-- import the calendar script -->
            echo $this->ScriptOpen("", "src='".$this->directory."modules/jscalendar/calendar.js'").$this->ScriptClose("");
            //<!-- import the language module -->
            echo $this->ScriptOpen("", "src='".$this->directory."modules/jscalendar/lang/calendar-".$this->GetLangAbbrForCalendar().".js'").$this->ScriptClose("");
            //<!-- the following script defines the Calendar.setup helper function, which makes
            //adding a calendar a matter of 1 or 2 lines of code. -->
            echo $this->ScriptOpen("", "src='".$this->directory."modules/jscalendar/calendar-setup.js'").$this->ScriptClose("");
            define("_DG_FLOATING_CAL_INCLUDED", true);            
        }
    }
  
    protected function SetCommonJavaScriptEnd(){
        // set verify JS functions  
        if(isset($this->modes['delete'][$this->mode]) && $this->modes['delete'][$this->mode]){
            echo $this->ScriptOpen();
            echo "function ".$this->uniquePrefix."verifyDelete(rid){if(confirm(\"".$this->lang['delete_this_record']."\")){ ".$this->uniquePrefix."_doPostBack(\"delete\",rid); } else { false;}};\n";            
            echo $this->ScriptClose();
        }
        // set toggle JS functions
        if($this->mode == "view"){
            echo $this->ScriptOpen();
            echo "function ".$this->uniquePrefix."toggleStatus(param, field_name, field_id, field_value){ \n";            
            echo "document_location_href = param+'&toggle_status=1&toggle_field='+field_name+'&toggle_field_id='+field_id+'&toggle_field_value='+field_value; \n";            
                  if($this->ajaxEnabled) echo "document.location.href = document_location_href; \n";
                  else echo "document.location.href = document_location_href.replace(/&amp;/g, '&'); \n"; 
            echo "}";        
            echo $this->ScriptClose();
        }     
    }
  
    protected function SetMediaPrint(){
        echo "\n<link href='".$this->directory."styles/print.css' type='text/css' rel='stylesheet' media='print' />";
    }         
        
    //--------------------------------------------------------------------------
    // Set edit fields form script 
    //--------------------------------------------------------------------------
    protected function SetEditFieldsFormScript($url=""){
        echo $this->ScriptOpen();       
        echo "function ".$this->uniquePrefix."updateWysiwygFields(){ ";
            if($this->browserName == "Firefox"){
                echo " result_value = updateWysiwygFieldsFF('".$this->uniquePrefix."', false);";
            }else{ // "MSIE" or other
                echo " result_value = updateWysiwygFieldsIE('".$this->uniquePrefix."', false);";
            };
        echo "}\n";        
        echo "function ".$this->uniquePrefix."sendEditFields(){ jsSendEditFields('".$this->uniquePrefix."', '".$this->browserName."', '".$this->jsValidationErrors."') }";
        echo $this->ScriptClose();
    }  
    
    //--------------------------------------------------------------------------
    // Return date format
    //--------------------------------------------------------------------------
    protected function MyDate($field_value, $type="datedmy", $show_seconds = true){
        $ret_date = "";
        if(strtolower($show_seconds) == "true" or $show_seconds === true) $show_seconds = true;
        if($type == "datedmy"){ 
            if (substr(trim($field_value), 4, 1) == "-"){ 
                $year1 = substr(trim($field_value), 0, 4); 
                $month1 = substr(trim($field_value), 5, 2); 
                $day1 = substr(trim($field_value), 8, 2); 
                if($day1 != ""){ $ret_date = $day1."-".$month1."-".$year1; } 
            }else{         
                $year1 = substr(trim($field_value), 6, 4); 
                $month1 = substr(trim($field_value), 3, 2); 
                $day1 = substr(trim($field_value), 0, 2); 
                if($day1 != ""){ $ret_date = $day1."-".$month1."-".$year1; } 
            } 
        }else if($type == "datemdy"){
            $year = substr(trim($field_value), 0, 4); 
            $month = substr(trim($field_value), 5, 2); 
            $day = substr(trim($field_value), 8, 2); 
            if($month != "" && $day != "" && $year != "") $ret_date = $month."-".$day."-".$year;
        }else if($type == "datetimedmy"){
            if (substr(trim($field_value), 4, 1) == "-"){        
                $year1 = substr(trim($field_value), 0, 4); 
                $month1 = substr(trim($field_value), 5, 2); 
                $day1 = substr(trim($field_value), 8, 2); 
                $time1 = substr(trim($field_value), 11, 2); 
                $time2 = substr(trim($field_value), 14, 2); 
                $time3 = substr(trim($field_value), 17, 2);
                if($time3 == "") $time3 = "00";
                if($day1 != ""){ $ret_date = $day1."-".$month1."-".$year1." ".$time1.":".$time2.(($show_seconds)?":".$time3:""); } 
            }else{         
                $year1 = substr(trim($field_value), 6, 4); 
                $month1 = substr(trim($field_value), 3, 2); 
                $day1 = substr(trim($field_value), 0, 2); 
                $time1 = substr(trim($field_value), 11, 2); 
                $time2 = substr(trim($field_value), 14, 2); 
                $time3 = substr(trim($field_value), 17, 2);
                if($time3 == "") $time3 = "00";
                if($day1 != ""){ $ret_date = $day1."-".$month1."-".$year1." ".$time1.":".$time2.(($show_seconds)?":".$time3:""); } 
            } 
        }else{
            if($show_seconds){
                $ret_date = $field_value;                 
            }else{
                if(strlen($field_value) > 16){
                    $ret_date = substr($field_value, 0, strlen($field_value)-3);
                }else{
                    $ret_date = $field_value;                    
                }
            }
        } 
        return $ret_date; 
    }

    
    ////////////////////////////////////////////////////////////////////////////
    //
    // Auxiliary methods
    // -------------------------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////
    protected function RealEscapeString(){
        
    }
    
    protected function AddArrayParams($href_string){
        $href_string = str_replace("&amp;", "&", $href_string);
        $array_params = "";
        foreach ($_GET as $key => $value){
            if(is_array($value)){
                $count = 0;
                foreach ( $value as $paramvalue ) {
                  $array_params .= "&".$key."=".$value[$count];
                  $count++;
                }
            }
        }                                    
        $array_params = str_replace("%3D", "%5B%5D=", str_replace("%26", "&", urlencode($array_params)));                                    
        $href_string = $array_params.$href_string;
        $href_string = str_replace("&", "&amp;", $href_string);
        return $href_string;
    }

    protected function PreparePasswordDecryption(){
        // prepare decryption of password
        $fields_list = "";
        foreach($this->columnsEditMode as $column_name => $column_array){
            $fp_type = $this->GetFieldProperty($column_name, "type", "edit");
            if($fp_type == "password"){
                $fp_cryptography = $this->GetFieldProperty($column_name, "cryptography", "edit");
                $fp_cryptography_type = $this->GetFieldProperty($column_name, "cryptography_type", "edit");
                $fp_aes_password = $this->GetFieldProperty($column_name, "aes_password", "edit");
                if($fp_cryptography == true || $fp_cryptography == "true"){
                    if($fp_cryptography_type == "aes"){
                        $fields_list .= "AES_DECRYPT(".$column_name.", '".$fp_aes_password."') as ".$column_name.", ";    
                    }
                }
            }
        }
        return $fields_list;
    }
    
    protected function PrepareFileFields(&$file_fileds_array, $sql){
        // prepare list of file/image fields
        $files = array();
        if(is_array($this->columnsEditMode)){        
            foreach($this->columnsEditMode as $fldName => $fldParam){
                if(isset($fldParam['type']) && ($fldParam['type'] == "image" || $fldParam['type'] == "file")){
                    if(isset($fldParam['file_name']) && isset($fldParam['target_path'])){
                        $files[$fldName] = array("file_name"=>$fldParam['file_name'], "target_path"=>$fldParam['target_path']);                        
                    }                    
                }
            }
        }        
        // there are some file/image fields 
        if(count($files) > 0){
            $fields_list_count = 0;
            $fields_list = "";
            foreach($files as $key => $val){
                if($fields_list_count++ > 0) $fields_list .= ", ";
                $fields_list .= $key;
            }
            $sql = str_replace("DELETE", "SELECT ".$fields_list." ", $sql);
            $dSet = $this->dbHandler->query($sql);
            while($row = $dSet->fetchRow()){
                $ind = 0;
                foreach($files as $key => $val){
                    $files[$key]["file_name"] = $row[$ind++];
                }
            }
            $file_fileds_array = array_merge($file_fileds_array, $files);
        }
    }

    protected function DeleteFileFields($file_fileds_array){
        foreach($file_fileds_array as $key => $val){
            @unlink($val["target_path"].$val["file_name"]); 
        }        
    }
    
    protected function DrawControlButtonsJS(){
        // write control buttons javascript function    
        $details_curr_url = $this->CombineUrl("details", "_RID_");        
        $this->SetUrlString($details_curr_url, "filtering", "sorting", "paging");
        $delete_curr_url = $this->CombineUrl("delete", "_RID_");
        $this->SetUrlString($delete_curr_url, "filtering", "sorting", "paging");                
        $edit_curr_url = $this->CombineUrl("edit", "_RID_");
        $this->SetUrlString($edit_curr_url, "filtering", "sorting", "paging");                
        $add_curr_url = $this->CombineUrl("add", "_RID_");
        $this->SetUrlString($add_curr_url, "filtering", "sorting", "paging");
        $cancel_curr_url = $this->CombineUrl("cancel", "_RID_");
        $this->SetUrlString($cancel_curr_url, "filtering", "sorting", "paging");
        $sorting_curr_url = $this->CombineUrl("view");
        $this->SetUrlString($sorting_curr_url, "filtering", "", "");
        $paging_curr_url  = $this->CombineUrl("view");
        $this->SetUrlString($paging_curr_url, "filtering", "", "");
        $page_resize_curr_url = $this->CombineUrl("view");
        $this->SetUrlString($page_resize_curr_url, "filtering", "", "");
        $reset_curr_url = $this->CombineUrl("view");
        $this->SetUrlString($reset_curr_url, "", "sorting", "paging");
        
        // [httpSubmitMethod - IN TEST #0010-1] 
        if($this->httpSubmitMethod == "POST"){
            $break_sign = "\n";
            echo "<form name='".$this->uniquePrefix."frmAddNew' id='".$this->uniquePrefix."frmAddNew' method='POST'>".$break_sign;
                $add_curr_url = str_replace("?", "", $add_curr_url);
                $add_curr_url_array = explode("&amp;", $add_curr_url);
                foreach($add_curr_url_array as $key => $val){
                    $key_array = explode("=", $val);
                    echo "<input type='hidden' name='".$key_array[0]."' id='".$key_array[0]."' value='".$key_array[1]."' />".$break_sign;                    
                }
            echo "</form>\n";
            
            echo "<form name='".$this->uniquePrefix."frmCancelNew' id='".$this->uniquePrefix."frmCancelNew' method='POST'>".$break_sign;
                $cancel_curr_url = str_replace("?", "", $cancel_curr_url);
                $cancel_curr_url_array = explode("&amp;", $cancel_curr_url);
                foreach($cancel_curr_url_array as $key => $val){
                    $key_array = explode("=", $val);
                    echo "<input type='hidden' name='".$key_array[0]."' id='".$key_array[0]."' value='".$key_array[1]."' />".$break_sign;                    
                }
            echo "</form>\n";
        }
        
        echo $this->ScriptOpen()."function ".$this->uniquePrefix."_doPostBack(mode,rid,param){
        var param = (param == null) ? '' : param;
        var details_url = '".$details_curr_url."';       details_url = details_url.replace(/_RID_/g, rid); details_url = details_url.replace(/&amp;/g, '&'); 
        var delete_url  = '".$delete_curr_url."';        delete_url  = delete_url.replace(/_RID_/g, rid);  delete_url  = delete_url.replace(/&amp;/g, '&'); 
        var edit_url    = '".$edit_curr_url."';          edit_url    = edit_url.replace(/_RID_/g, rid);    edit_url = edit_url.replace(/&amp;/g, '&'); 
        var add_url     = '".$add_curr_url."';           add_url     = add_url.replace(/_RID_/g, rid);     add_url = add_url.replace(/&amp;/g, '&');        
        var cancel_url  = '".$cancel_curr_url."'+param;  cancel_url  = cancel_url.replace(/_RID_/g, rid);  cancel_url = cancel_url.replace(/&amp;/g, '&');        
        var sorting_url = '".$sorting_curr_url."'+param; sorting_url = sorting_url.replace(/&amp;/g, '&');\n";
        
        // [#0012 - 4] start suggested by kalak
        echo "sorting_url = sorting_url.replace(/\[\]\=/g, '%5B%5D=');
              sorting_url = sorting_url.replace(/\+\&/g, '%2B&');\n";
        // [#0012 - 4] end
        
        echo "var paging_url  = '".$paging_curr_url."'+param;  paging_url  = paging_url.replace(/&amp;/g, '&');        
        var page_resize_url = '".$page_resize_curr_url."'+param;  page_resize_url  = page_resize_url.replace(/&amp;/g, '&');        
        var reset_url   = '".$reset_curr_url."'+param;   reset_url   = reset_url.replace(/&amp;/g, '&');        
        
        if(mode == 'details'){ document.location.href = details_url; }
        else if(mode == 'delete'){ document.location.href = delete_url; }
        else if(mode == 'edit'){ document.location.href = edit_url; }
        else if(mode == 'add'){ ".(($this->httpSubmitMethod == "POST") ? "document.getElementById('".$this->uniquePrefix."frmAddNew').submit();" : "document.location.href = add_url;")." }
        else if(mode == 'cancel'){ ".(($this->httpSubmitMethod == "POST") ? "document.getElementById('".$this->uniquePrefix."frmCancelNew').submit();" : "document.location.href = cancel_url;")." }
        else if(mode == 'sort'){ ".(($this->ajaxEnabled) ? $this->uniquePrefix."_doAjaxRequest(sorting_url);" : "document.location.href = sorting_url;")." }
        else if(mode == 'paging'){ ".(($this->ajaxEnabled) ? $this->uniquePrefix."_doAjaxRequest(paging_url);" : "document.location.href = paging_url;")." }
        else if(mode == 'page_resize'){ ".(($this->ajaxEnabled) ? $this->uniquePrefix."_doAjaxRequest(page_resize_url);" : "document.location.href = page_resize_url;")." }
        else if(mode == 'reset'){ document.location.href = reset_url; }
        else{ ".(($this->debug) ? "alert('Unknown Mode!');" : "")." } }".$this->ScriptClose();        
    }

    //--------------------------------------------------------------------------
    // Converts date format to floating calendar date format
    //--------------------------------------------------------------------------
    protected function GetDateFormatForFloatingCal($datetime_format = ""){
        $if_format = "%Y-%m-%d";
        
        if($datetime_format == "Y-m-d")             { $if_format = "%Y-%m-%d"; }
        else if($datetime_format == "d-m-Y")        { $if_format = "%d-%m-%Y"; }
        else if($datetime_format == "Y-m-d H:i:s")  { $if_format = "%Y-%m-%d %H:%M:%S"; }
        else if($datetime_format == "Y-m-d H:i")    { $if_format = "%Y-%m-%d %H:%M"; }
        else if($datetime_format == "d-m-Y H:i:s")  { $if_format = "%d-%m-%Y %H:%M:%S"; }
        else if($datetime_format == "d-m-Y H:i")    { $if_format = "%d-%m-%Y %H:%M"; }
        else if($datetime_format == "datedmy")      { $if_format = "%d-%m-%Y"; }
        else if($datetime_format == "m-d-Y")        { $if_format = "%m-%d-%Y"; }
        else if($datetime_format == "datetime")     { $if_format = "%Y-%m-%d %H:%M:%S"; }
        else if($datetime_format == "time")         { $if_format = "%H:%M:%S"; }
        
        return $if_format;
    }
    
    //--------------------------------------------------------------------------
    // Draws calendar button
    //--------------------------------------------------------------------------
    protected function DrawCalendarButton($field_name, $field_type, $datetime_format="Y-m-d", $field_value="", $fp_pre_addition="", $fp_post_addition="", $field_width="", $field_maxlength="", $on_js_event="", $readonly=false, $fp_calendar_type = "popup", $multirow_postfix = ""){
        $if_format = $this->GetDateFormatForFloatingCal($datetime_format);
        $show_seconds = "false"; 
        $show_time = "false";
        if($datetime_format == "Y-m-d")           { $show_time = "false"; }
        else if($datetime_format == "d-m-Y")      { $show_time = "false"; }
        else if($datetime_format == "m-d-Y")      { $show_time = "false"; }
        else if($datetime_format == "Y-m-d H:i:s"){ $show_time = "true"; $show_seconds = "true"; }
        else if($datetime_format == "Y-m-d H:i")  { $show_time = "true"; }
        else if($datetime_format == "d-m-Y H:i")  { $show_time = "true"; }
        else if($datetime_format == "d-m-Y H:i:s"){ $show_time = "true"; $show_seconds = "true"; }
        
        $fp_req_type = $this->GetFieldRequiredType($field_name);
        $fp_title = $this->GetFieldTitle($field_name);
        $full_field_name = $fp_req_type.$field_name.$multirow_postfix;        
        
        if($fp_calendar_type == "floating"){
            $ret_date  = $this->nbsp."<input class='".$this->cssClass."_dg_textbox' ".$field_width." readonly type='text' title='".$fp_title."' name='".$full_field_name."' id='".$full_field_name."' value='".$this->MyDate($field_value, $field_type, $show_seconds)."' $field_maxlength ".$on_js_event." />";
            if(!$readonly) $ret_date .= "<img id='img".$full_field_name."' src='".$this->directory."styles/".$this->cssClass."/images/cal.gif' alt='".$this->lang['set_date']."' title='".$this->lang['set_date']."' align='top' style='cursor:pointer;margin:3px;margin-left:6px;margin-right:6px;border:0px;' />".$this->nbsp.$this->ScriptOpen()."Calendar.setup({firstDay : ".$this->weekStartingtDay.", inputField : '".$full_field_name."', ifFormat : '".$if_format."', showsTime : ".$show_time.", button : 'img".$full_field_name."'});".$this->ScriptClose();//$$$
        }else if($fp_calendar_type == "dropdownlist"){
            $field_id  = $this->uniquePrefix."frmEditRow".$full_field_name;
            $ret_date  = $this->nbsp."<input style='width:0px;border:0px;margin:0px;padding:0px;' type='text' title='".$fp_title."' name='".$full_field_name."' id='".$field_id."' value='".$this->MyDate($field_value, $field_type, $show_seconds)."' $field_maxlength ".$on_js_event." />";
            
            $arr_ret_date = array();
            $arr_ret_date["y"] = "<select name='".$field_id."__nc_year' id='".$field_id."__nc_year' onChange='setCalendarDate(\"".$this->uniquePrefix."frmEditRow\", \"".$field_id."\", \"".$datetime_format."\")'><option value=''>".$this->lang['year']."</option>"; for($i=@date("Y")-50; $i<=@date("Y")+10; $i++) { $arr_ret_date["y"] .= "<option value='".$i."'>".$i."</option>"; }; $arr_ret_date["y"] .= "</select>";                            
            $arr_ret_date["m"] = "<select name='".$field_id."__nc_month' id='".$field_id."__nc_month' onChange='setCalendarDate(\"".$this->uniquePrefix."frmEditRow\", \"".$field_id."\", \"".$datetime_format."\")'><option value=''>".$this->lang['month']."</option>"; for($i=1; $i<=12; $i++) { $arr_ret_date["m"] .= "<option value='".(($i < 10) ? "0".$i : $i)."'>".$this->lang['months'][$i]."</option>"; }; $arr_ret_date["m"] .= "</select>";
            $arr_ret_date["d"] = "<select name='".$field_id."__nc_day' id='".$field_id."__nc_day' onChange='setCalendarDate(\"".$this->uniquePrefix."frmEditRow\", \"".$field_id."\", \"".$datetime_format."\")'><option value=''>".$this->lang['day']."</option>"; for($i=1; $i<=31; $i++) { $arr_ret_date["d"] .= "<option value='".(($i < 10) ? "0".$i : $i)."'>".(($i < 10) ? "0".$i : $i)."</option>"; }; $arr_ret_date["d"] .= "</select>";

            $ret_date .= $arr_ret_date[strtolower(substr($datetime_format, 0, 1))];
            $ret_date .= $arr_ret_date[strtolower(substr($datetime_format, 2, 1))];
            $ret_date .= $arr_ret_date[strtolower(substr($datetime_format, 4, 1))];

            if($show_time == "true"){
                $ret_date .= " : ";
                $ret_date .= "<select name='".$field_id."__nc_hour' id='".$field_id."__nc_hour' onChange='setCalendarDate(\"".$this->uniquePrefix."frmEditRow\", \"".$field_id."\", \"".$datetime_format."\")'><option value=''>".$this->lang['hour']."</option>"; for($i=0; $i<=23; $i++) { $ret_date .= "<option value='".(($i < 10) ? "0".$i : $i)."'>".(($i < 10) ? "0".$i : $i)."</option>"; }; $ret_date .= "</select>";
                $ret_date .= "<select name='".$field_id."__nc_minute' id='".$field_id."__nc_minute' onChange='setCalendarDate(\"".$this->uniquePrefix."frmEditRow\", \"".$field_id."\", \"".$datetime_format."\")'><option value=''>".$this->lang['min']."</option>"; for($i=0; $i<=59; $i++) { $ret_date .= "<option value='".(($i < 10) ? "0".$i : $i)."'>".(($i < 10) ? "0".$i : $i)."</option>"; }; $ret_date .= "</select>";                    
                if($show_seconds == "true") { $ret_date .= "<select name='".$field_id."__nc_second' id='".$field_id."__nc_second' onChange='setCalendarDate(\"".$this->uniquePrefix."frmEditRow\", \"".$field_id."\", \"".$datetime_format."\")'><option value=''>".$this->lang['sec']."</option>"; for($i=0; $i<=59; $i++) { $ret_date .= "<option value='".(($i < 10) ? "0".$i : $i)."'>".(($i < 10) ? "0".$i : $i)."</option>"; }; $ret_date .= "</select>"; }
            }
            $ret_date .= " ";
            if(!$readonly) $ret_date .= "<a class='".$this->cssClass."_dg_a2' style='cursor: pointer;' onClick='setCalendarDate(\"".$this->uniquePrefix."frmEditRow\", \"".$field_id."\", \"".$datetime_format."\", \"".@date($datetime_format)."\", \"".(@date("Y")-50)."\", false)'>[".@date($datetime_format)."]</a>";
            if((!$readonly) && (substr($fp_req_type, 0, 1) == "s")) $ret_date .= " <a class='".$this->cssClass."_dg_a2'  style='cursor: pointer;' onClick='resetDDL(\"".$field_id."__nc_year\");resetDDL(\"".$field_id."__nc_month\");resetDDL(\"".$field_id."__nc_day\");resetDDL(\"".$field_id."__nc_hour\");resetDDL(\"".$field_id."__nc_minute\");resetDDL(\"".$field_id."__nc_second\");' title='".$this->lang['clear']."'>[".$this->lang['clear']."]</a>";                                    
            $ret_date .= $this->ScriptOpen()."setCalendarDate('".$this->uniquePrefix."frmEditRow', '".$field_id."', '".$datetime_format."', '".trim($field_value)."', '".(@date("Y")-50)."');".$this->ScriptClose();    
        }else{
            $ret_date  = $this->nbsp."<input class='".$this->cssClass."_dg_textbox' ".$field_width." readonly type='text' title='".$fp_title."' name='".$full_field_name."' id='".$full_field_name."' value='".$this->MyDate($field_value, $field_type, $show_seconds)."' $field_maxlength ".$on_js_event." />";
            if(!$readonly) $ret_date .= "<a class='".$this->cssClass."_dg_a2' title='".$fp_title."' href=\"javascript:openCalendar('".(($this->ignoreBaseTag) ? $this->HTTP_HOST."/" : "").$this->directory."','','".$this->uniquePrefix."frmEditRow','".$full_field_name."','".$field_name."','$field_type')\"><img src='".$this->directory."styles/".$this->cssClass."/images/cal.gif' alt='".$this->lang['set_date']."' title='".$this->lang['set_date']."' align='top' style='margin:3px;margin-left:6px;margin-right:6px;border:0px;' /></a>".$this->nbsp;
        }
        if(($fp_calendar_type == "floating") || ($fp_calendar_type == "popup")){
            if(!$readonly) $ret_date .= "<a class='".$this->cssClass."_dg_a2' style='cursor: pointer;' onClick='document.getElementById(\"".$full_field_name."\").value=\"".@date($datetime_format)."\"'>[".@date($datetime_format)."]</a>";
            if((!$readonly) && (substr($fp_req_type, 0, 1) == "s")) $ret_date .= " <a class='".$this->cssClass."_dg_a2'  style='cursor: pointer;' onClick='document.getElementById(\"".$full_field_name."\").value=\"\"' title='".$this->lang['clear']."'>[".$this->lang['clear']."]</a>";                            
        }
        
        return $fp_pre_addition.$ret_date.$fp_post_addition;
    }

    //--------------------------------------------------------------------------
    // Get formatted microtime
    //--------------------------------------------------------------------------
    protected function GetFormattedMicrotime(){
        list($usec, $sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }
    
    //--------------------------------------------------------------------------
    // Download export file 
    //--------------------------------------------------------------------------
    protected function ExportDownloadFile($file_name){
        $_SESSION['datagrid_export_dir']= $this->exportingDirectory;
        $_SESSION['datagrid_export_file']= $file_name;
        $_SESSION['datagrid_debug']= $this->debug;
        
        return $this->ScriptOpen()."if(confirm('Do you want to export datagrid content into [".$file_name."] file?')){ ".
        " document.write('".str_replace("_FILE_", $file_name, $this->lang['export_message'])."'); ".            
        " document.location.href = '".$this->directory."scripts/download.php'; ".
        "} else {".
        " window.close();".
        "}".$this->ScriptClose();
    }
    
    //--------------------------------------------------------------------------
    // Check existing types of fields
    //--------------------------------------------------------------------------    
    protected function CheckExistingFields(){        
        // view mode filter fields
        if(isset($this->columnsViewMode)){
            foreach($this->columnsViewMode as $fldName => $fldValue){
                $tooltip_allowed = false;
                foreach($fldValue as $key => $val){
                    if(($key == "tooltip") && (($val == true) || ($val == "true"))){ $tooltip_allowed = true; }
                    if($tooltip_allowed && ($key == "tooltip_type") && (strtolower($val) == "floating")) { $this->existingFields['tooltip_type_floating'] = true; }
                    if(($key == "magnify") && (($val == true) || ($val == "true"))){ $this->existingFields['magnify_field_view'] = true; }
                    if(($key == "magnify_type") && ($val == "magnifier")) { $this->existingFields['magnify_field_view_magnifier'] = true; }
                    if(($key == "magnify_type") && ($val == "lightbox")) { $this->existingFields['magnify_field_view_lightbox'] = true; }
                }
            }
        }
        // add/edit/details mode filter fields
        if(is_array($this->columnsEditMode)){        
            foreach($this->columnsEditMode as $fldName => $fldValue){
                $found_field_type = false;        
                foreach($fldValue as $key => $val){
                    if(($key == "resizable") && (($val == true) || ($val == "true"))) $this->existingFields['resizable_field'] = true;
                    if(($key == "edit_type") && (strtolower($val) == "wysiwyg")) $this->existingFields['wysiwyg_field'] = true;                    
                    if($key == "type"){
                        if(($val == "date") || ($val == "datedmy") || ($val == "datemdy") || ($val == "datetime") || ($val == "datetimedmy") || ($val == "time")){
                            $found_field_type = true;
                        }
                    }
                    if($key == "calendar_type"){
                        if($found_field_type && (strtolower($val) == "floating")){ $this->existingFields['calendar_type_floating'] = true; }
                        if($found_field_type && (strtolower($val) == "popup")){ $this->existingFields['calendar_type_popup'] = true; }
                    }                    
                    if(($key == "magnify") && (($val == true) || ($val == "true"))){ $this->existingFields['magnify_field_edit'] = true; }
                    if(($key == "magnify_type") && ($val == "magnifier")) { $this->existingFields['magnify_field_edit_magnifier'] = true; }
                    if(($key == "magnify_type") && ($val == "lightbox")) { $this->existingFields['magnify_field_edit_lightbox'] = true; }
                }
            }
        }
        // filter fields
        if(is_array($this->arrFilterFields)){
            foreach($this->arrFilterFields as $fldName => $fldValue){
                foreach($fldValue as $key => $val){
                    if(($key == "autocomplete") && (($val == true) || ($val == "true"))) $this->existingFields['autosuggestion_field'] = true;;
                    if($key == "calendar_type"){
                        if(strtolower($val) == "floating"){ $this->existingFields['calendar_type_floating'] = true; }
                    }                    
                }
            }            
        }
    }

    //--------------------------------------------------------------------------
    // Get remote file content
    //--------------------------------------------------------------------------
    protected function HttpGetFile($url)  {    
        $url_stuff = parse_url($url);
        $port = isset($url_stuff['port']) ? $url_stuff['port']:80;     
        $fp = fsockopen($url_stuff['host'], $port);     
        $query  = 'GET ' . $url_stuff['path'] . " HTTP/1.0\n";
        $query .= 'Host: ' . $url_stuff['host'];
        $query .= "\n\n";
        $buffer = "";
        fwrite($fp, $query);    
        while ($line = fread($fp, 1024)) {
           $buffer .= $line;
        }     
        preg_match('/Content-Length: ([0-9]+)/', $buffer, $parts);
        
        if($buffer != "" && isset($parts[1])){
            return substr($buffer, - $parts[1]);    
        } else if($buffer != ""){
            return $buffer;
        } else{
            return "";    
        }        
    }    

    //--------------------------------------------------------------------------
    // Get http port 
    //--------------------------------------------------------------------------
    protected function GetPort(){        
        $port = "";
        if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != "80"){
            if(!strpos($_SERVER['HTTP_HOST'], ":")){
                $port = ":".$_SERVER['SERVER_PORT'];
            }
        }
        return $port;        
    }    

    //--------------------------------------------------------------------------
    // Get protocol (http/s)
    //--------------------------------------------------------------------------
    protected function GetProtocol(){        
        $protocol = "http://";
        if((isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != "off")) ||
            strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, 5)) == "https"){
            $protocol = "https://";
        }
        return $protocol;        
    }

    //--------------------------------------------------------------------------
    // Get server name
    //--------------------------------------------------------------------------
    protected function GetServerName(){
        $server = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : "";
        $colon = strpos($server,':');
        if ($colon > 0 && $colon < strlen($server)){
            $server = substr($server, 0, $colon);
        }
        return $server;
    }
    
    //--------------------------------------------------------------------------
    // Return last substring occurence
    //--------------------------------------------------------------------------
    protected function SubStrOccurence($string, $substring, $reverse = false){
        $string = str_replace(array("\t", "\n"), " ", $string);
        if($reverse == true){
            $string = strrev($string);
            $substring = strrev($substring);
        }
        return strpos(strtolower($string), strtolower($substring));
    }

    //--------------------------------------------------------------------------
    // Encode parameter
    //--------------------------------------------------------------------------    
    protected function EncodeParameter($param, $return_string = true){
        if($this->safeMode){
            $base64 = base64_encode($param);
            $base64url = strtr($base64, '+/=', '-_,');
            if($return_string) return "\"".$base64url."\""; 
            else return $base64url;                     
        }
        return $param;
    }

    //--------------------------------------------------------------------------
    // Decode parameter
    //--------------------------------------------------------------------------    
    protected function DecodeParameter($param){
        if($this->safeMode){
            $base64url = strtr($param, '-_,', '+/=');
            $base64 = base64_decode($base64url);
            return $base64;          
        }
        return $param;        
    }
  
    //--------------------------------------------------------------------------
    // Gets random string
    //--------------------------------------------------------------------------
    function GetRandomString($length = 20) {
        return Helper::GetRandomString($length);
    }

    //--------------------------------------------------------------------------
    // Get language abbreviation for JS AFV
    //--------------------------------------------------------------------------    
    protected function GetLangAbbrForJSAFV(){
        $return_abbrv = "en";
        switch($this->langName){
            case "de":
                $return_abbrv = "de"; break;                            
            case "es":
                $return_abbrv = "es"; break;
            case "fr":
                $return_abbrv = "fr"; break;
            case "ja_utf8":
                $return_abbrv = "ja"; break;
            case "en":
            default:
                $return_abbrv = "en"; break;
        }
        return $return_abbrv;
    }
    
    //--------------------------------------------------------------------------
    // Get language abbreviation for DG
    //--------------------------------------------------------------------------    
    protected function GetLangAbbrForDG(){
        $return_abbrv = "en";
        switch($this->langName){
            case "de":
                $return_abbrv = "de"; break;
            case "es":
                $return_abbrv = "es"; break;
            case "fr":
                $return_abbrv = "fr"; break;
            case "en":
            default:
                $return_abbrv = "en"; break;
        }
        return $return_abbrv;
    }
    
    //--------------------------------------------------------------------------
    // Get language abbreviation for calendar
    //--------------------------------------------------------------------------    
    protected function GetLangAbbrForCalendar(){
        $return_abbrv = "en";
        switch($this->langName){
            case "ar": $return_abbrv = "en"; break; // Arabic
            case "hr": $return_abbrv = "hr"; break; // Bosnian/Croatian            
            case "bg": $return_abbrv = "bg"; break; // Bulgarian
            case "pb": $return_abbrv = "pt"; break; // Brazilian Portuguese    
            case "ca": $return_abbrv = "ca"; break; // Catala
            case "ch": $return_abbrv = "cn"; break; // Chinese
            case "cz": $return_abbrv = "cs"; break; // Czech
            case "de": $return_abbrv = "de"; break; // German                
            case "es": $return_abbrv = "es"; break; // Espanol
            case "fr": $return_abbrv = "fr"; break; // Francais
            case "gk": $return_abbrv = "en"; break; // Greek
            case "he": $return_abbrv = "he"; break; // Hebrew
            case "hu": $return_abbrv = "hu"; break; // Hungarian
            case "it": $return_abbrv = "it"; break; // Italiano
            case "ja_utf8": $return_abbrv = "ja"; break; // Japanese
            case "nl": $return_abbrv = "nl"; break; // Netherlands/"Vlaams"(Flemish)
            case "pl": $return_abbrv = "pl"; break; // Polish
            case "ro_utf8": 
            case "ro": $return_abbrv = "ro"; break; // Romanian            
            case "ru_utf8":
            case "ru": $return_abbrv = "ru"; break; // Russian
            case "sr": $return_abbrv = "en"; break; // Serbian
            case "se": $return_abbrv = "sv"; break; // Swedish
            case "tr": $return_abbrv = "tr"; break; // Turkish
            case "en":
            default:
                $return_abbrv = "en"; break;
        }
        return $return_abbrv;
    }
    
    //--------------------------------------------------------------------------
    // Set Default Timezone
    //--------------------------------------------------------------------------    
    function SetDefaultTimezone($timezone){        
        if($timezone != ""){
            $this->timezone = $timezone;            
            date_default_timezone_set($this->timezone);
        }
    }    
    
    //--------------------------------------------------------------------------
    // Resize uploaded image
    //--------------------------------------------------------------------------    
    function ResizeImage($image_path, $image_name, $resize_width = "", $resize_height = ""){
        $image_path_name = $image_path.$image_name;
        
        if(empty($image_path_name)){ // No Image?    
            $this->AddWarning("", "", $this->lang['uploaded_file_not_image']);
        }else{ // An Image?
			if($image_path_name) {
                $size   = getimagesize($image_path_name);
                $width  = $size[0];
                $height = $size[1];
                
                $case = "";
                $ext = strtolower(substr($image_path_name,strrpos($image_path_name,".")+1));
                switch($ext)  {
                    case 'png':
                        $iTmp = imagecreatefrompng($image_path_name);
                        $case = "png";
                        break;
                    case 'gif':
                        $iTmp = imagecreatefromgif($image_path_name);
                        $case = "gif";
                        break;                
                    case 'jpeg':            
                    case 'jpg':
                        $iTmp = imagecreatefromjpeg($image_path_name);
                        $case = "jpg";
                        break;                
                }
            }
            
			if ($case != "") {
                if($resize_width != "" && $resize_height == ""){
                    $new_width=$resize_width;
                    $new_height = ($height/$width)*$new_width;                
                }else if($resize_width == "" && $resize_height != ""){
                    $new_height = $resize_height;
                    $new_width=($width/$height)*$new_height;
                }else if($resize_width != "" && $resize_height != ""){
                    $new_width  = $resize_width;
                    $new_height = $resize_height;                    
                }else{
                    $new_width  = $width;  
                    $new_height = $height;
                }
				$iOut = imagecreatetruecolor(intval($new_width), intval($new_height));     
				imagecopyresampled($iOut,$iTmp,0,0,0,0,intval($new_width), intval($new_height), $width, $height);
                imagejpeg($iOut,$image_path_name,100);
			}
        }        
    }
    
}// end class


?>     
