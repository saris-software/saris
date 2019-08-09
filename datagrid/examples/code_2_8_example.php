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

      // includes database connection parameters
      include_once('install/config.inc.php');
    
      //$DB_USER='username';            
      //$DB_PASS='password';           
      //$DB_HOST='localhost';       
      //$DB_NAME='database_name';    

      ob_start();
    ##  *** (example of ODBC connection string) - odbc
    ##  *** $result_conn = $db_conn->connect(DB::parseDSN('odbc://root:12345@test_db'));
    ##  *** (example of Oracle connection string) - oci8
    ##  *** 1. $DB_DESC = (DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = xx.xx.xx.xx)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = dev.domain.com)))
    ##  *** 2. $DB_DESC = "localhost:1521/mydatabase"; 
    ##  *** $result_conn = $db_conn->connect(DB::parseDSN('oci8://root:12345@'.$DB_DESC)); 
    ##  *** (example of PostgreSQL connection string) - pgsql
    ##  *** $result_conn = $db_conn->connect(DB::parseDSN('pgsql://root:12345@localhost/mydatabase')); 
    ##  *** (example of Firebird connection string)
    ##  *** $DB_NAME='c:\\program\\firebird21\\data\\db_test.fdb';   
    ##  *** $db_conn->connect(DB::parseDSN('firebird://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));      
    ##  === (Examples of connections to other db types see in "docs/pear/" folder)
      $db_conn = DB::factory('mysql');  /* don't forget to change on appropriate db type */
      $result_conn = $db_conn->connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
      if(DB::isError($result_conn)){ die($result_conn->getDebugInfo()); }  
    ##  *** write down the primary key in the first place (MUST BE AUTO-INCREMENT NUMERIC!)
      $sql = "SELECT
                id,
                model_name,
                description,
                image_thumb,
                image,
                price_from,
                price_to,
                submodels,
                model_name as details_link
            FROM demo_cars ";
    ##  *** set needed options and create a new class instance 
      $debug_mode = false;        /* display SQL statements while processing */    
      $messaging = true;          /* display system messages on a screen */ 
      $unique_prefix = "cr_";    /* prevent overlays - must be started with a letter */
      $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
    ##  *** set encoding and collation (default: utf8/utf8_unicode_ci)
    /// $dg_encoding = "utf8";
    /// $dg_collation = "utf8_unicode_ci";
    /// $dgrid->SetEncoding($dg_encoding, $dg_collation);
    ##  *** set data source with needed options
      $default_order_field = "model_name"; /* Ex.: field_name_1 [, field_name_2...] */
      $default_order_type = "ASC";           /* Ex.: ASC|DESC [, ASC|DESC...] */
      $dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);	    
    ##
    ##
    ## +---------------------------------------------------------------------------+
    ## | 2. General Settings:                                                      | 
    ## +---------------------------------------------------------------------------+
    ## +-- AJAX -------------------------------------------------------------------+
    ##  *** enable or disable using of AJAX (for sorting and paging ONLY)
    // $ajax_option = true;
    // $dgrid->AllowAjax($ajax_option);
    ##
    ## +-- Languages --------------------------------------------------------------+
    ##  *** set interface language (default - English)
    ##  *** (en) - English     (de) - German     (se) - Swedish   (hr) - Bosnian/Croatian
    ##  *** (hu) - Hungarian   (es) - Espanol    (ca) - Catala    (fr) - Francais
    ##  *** (nl) - Netherlands/"Vlaams"(Flemish) (it) - Italiano  (pb) - Brazilian Portuguese
    ##  *** (ch) - Chinese     (sr) - Serbian    (bg) - Bulgarian (ja_utf8) - Japanese
    ##  *** (ar) - Arabic      (tr) - Turkish    (cz) - Czech     (ro/ro_utf8) - Romanian
    ##  *** (gk) - Greek       (he) - Hebrew     (pl) - Polish    (ru_utf8) - Russian
    ##  *** (da) - Danish
    /// $dg_language = "en";  
    /// $dgrid->SetInterfaceLang($dg_language);
    ##  *** set direction: "ltr" or "rtr" (default - "ltr")
    /// $direction = "ltr";
    /// $dgrid->SetDirection($direction);
    ##
    ## +-- Layouts, Templates & CSS -----------------------------------------------+
    ##  *** set layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized 
    ##  *** use "view"=>"0" and "edit"=>"0" only if you work on the same tables
     $layouts = array("view"=>"2", "edit"=>"1", "details"=>"1", "filter"=>"1"); 
     $dgrid->SetLayouts($layouts);
    /// *** $mode_template = array("header"=>"", "body"=>"", "footer"=>"");
    /// $details_template = array("header"=>"", "body"=>"", "footer"=>"");
    /// $details_template['body'] = "<table><tr><td>{field_name_1}</td><td>{field_name_2}</td></tr></table>";
    /// $details_template['footer'] = "<table><tr><td>[ADD][CREATE][EDIT][DELETE][BACK]</td></tr></table>";
     $view_template = array("header"=>"", "body"=>"", "footer"=>"");

     // 
     $view_template['header'] = "
        <table style='margin-bottom:3px; BORDER-COLLAPSE: collapse; BORDER: #d0d0d0 1px solid; FONT: normal 12px Tahoma;' align='center' width='80%' border='0' cellspacing='2' cellpadding='3' bgcolor='#f3f3f3'>
        <tr><td colspan='4' height='10' nowrap='nowrap' align='left'>[ADD]</td></tr>
        </table>";
     $view_template['body'] = "     
        <table style='margin-bottom:3px; BORDER-COLLAPSE: collapse; BORDER: #d0d0d0 1px solid; FONT: normal 12px Tahoma;' align='center' width='80%' border='0' cellspacing='2' cellpadding='3' bgcolor='#f3f3f3'>
        <tr><td colspan='4' height='10' nowrap='nowrap' align='left'></td></tr>
        <tr>
            <td width='105px' valign='top' align='center'>
                <a href='uploads/{image}' rel='lyteshow[cars]' title=''>{image_thumb}</a><br />
                [EDIT]
            </td>
            <td width='5px' nowrap='nowrap'></td>
            <td valign='top'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <td>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                            <td width='235' height='20' valign='top' style='font-size:12px'><strong>{details_link}</strong></td>
                            <td width='140' valign='top'><span style='color:#960000;'>{price_from} - {price_to}</span></td>
                            <td width='185' valign='top'><a class='x-gray_dg_a' href=\"javascript:alert('Blocked in Demo version!');\">EuroAutomobile</a></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width='550'>{description}</td>
                </tr>
                <tr><td height='3' nowrap='nowrap'></td></tr>
                <tr>
                    <td height='20'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                            <td width='68' valign='top' style='color:#666666'>Submodel(s):&nbsp;</td>
                            <td valign='top' style='color:#008a8a'> {submodels}</td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr><td height='20' style='font-style:italic'>Updated:&nbsp; 20-Aug-2009</td></tr>
                </table>
            </td>
            <td valign='top' width='150px' align='center'>
                N/A <br/>                
                <a class='x-gray_dg_a' href=\"javascript:alert('Blocked in Demo version!');\">Rate it!</a><br/>                
                <a class='x-gray_dg_a' href=\"javascript:alert('Blocked in Demo version!');\">EXPERT REVIEW</a>
            </td>
        </tr>
        </table>";
     
     //$view_template['footer'] = "<table><tr><td>[ADD][CREATE][EDIT][DELETE][BACK]</td></tr></table>";
     $dgrid->SetTemplates($view_template,"","");
    ##  *** set modes for operations ("type" => "link|button|image")
    ##  *** "view" - view mode | "edit" - add/edit/details modes
    ##  *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
     $modes = array(
         "add"	  =>array("view"=>true, "edit"=>false, "type"=>"link", "show_add_button"=>"inside|outside"),
         "edit"	  =>array("view"=>true, "edit"=>true,  "type"=>"link", "byFieldValue"=>""),
         "cancel"  =>array("view"=>true, "edit"=>true,  "type"=>"link"),
         "details" =>array("view"=>true, "edit"=>false, "type"=>"link"),
         "delete"  =>array("view"=>true, "edit"=>false,  "type"=>"image")
     );
     $dgrid->SetModes($modes);
    ##  *** set CSS class for datagrid
    ##  *** "default", "blue", "x-blue", "gray", "green" or "pink" or "empty" your own css file 
     $css_class = "x-gray";
     $dgrid->SetCssClass($css_class);
    ##  *** set DataGrid caption
     $dg_caption = "New Cars - <a href=index.php>Back to Index</a>";
     $dgrid->SetCaption($dg_caption);
    ##
    ## +-- Scrolling --------------------------------------------------------------+
    ##  *** allow scrolling on datagrid
    /// $scrolling_option = false;
    /// $dgrid->AllowScrollingSettings($scrolling_option);  
    ##  *** set scrolling settings (optional)
    /// $scrolling_height = "200px";
    /// $dgrid->SetScrollingSettings($scrolling_height);
    ##
    ## +-- Multirow Operations ----------------------------------------------------+
    ##  *** allow multirow operations
    //  $multirow_option = true;
    //  $dgrid->AllowMultirowOperations($multirow_option);
    /// $multirow_operations = array(
    ///     "delete"  => array("view"=>true),
    ///     "details" => array("view"=>true),
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
     $paging_option = true;
     $rows_numeration = false;
     $numeration_sign = "N #";
     $dropdown_paging = false;
     $dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign, $dropdown_paging);
    ##  *** set paging settings
     $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", " "=>true, "page_size_align"=>"right");
     $top_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
     $pages_array = array("2"=>"2", "5"=>"5", "10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000");
     $default_page_size = 5;
     $paging_arrows = array("first"=>"|&lt;&lt;", "previous"=>"&lt;&lt;", "next"=>"&gt;&gt;", "last"=>"&gt;&gt;|");
     $dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
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
    ##  *** "field_type" may be "from" or "to"
    ##  *** "date_format" may be "date|datedmy|datetime|time"
    ##  *** "default_operator" may be =|<|>|like|%like|like%|%like%|not like
    /// $fill_from_array = array("0"=>"No", "1"=>"Yes");  /* as "value"=>"option" */
    /// $filtering_fields = array(
    ///     "Caption_1"=>array("type"=>"textbox", "table"=>"tableName_1", "field"=>"fieldName_1|,fieldName_2", "filter_condition"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "on_js_event"=>""),
    ///     "Caption_2"=>array("type"=>"textbox", "autocomplete"=>"false", "handler"=>"modules/autosuggest/test.php", "maxresults"=>"12", "shownoresults"=>"false", "table"=>"tableName_1", "field"=>"fieldName_1|,fieldName_2", "filter_condition"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "on_js_event"=>""),
    ///     "Caption_3"=>array("type"=>"dropdownlist", "table"=>"tableName_2", "field"=>"fieldName_2", "field_view"=>"", "filter_condition"=>"", "order"=>"ASC|DESC", "source"=>"self"|$fill_from_array, "condition"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "multiple"=>"false", "multiple_size"=>"4", "on_js_event"=>""),
    ///     "Caption_4"=>array("type"=>"calendar", "calendar_type"=>"popup|floating", "date_format"=>"date", "table"=>"tableName_3", "field"=>"fieldName_3", "filter_condition"=>"", "field_type"=>"", "show_operator"=>"false", "default_operator"=>"=", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "on_js_event"=>""),
    /// );
    /// $dgrid->SetFieldsFiltering($filtering_fields);
    ##
    ## 
    ## +---------------------------------------------------------------------------+
    ## | 6. View Mode Settings:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** set view mode table properties
     $vm_table_properties = array("width"=>"80%");
     $dgrid->SetViewModeTableProperties($vm_table_properties);  
    ##  *** set columns in view mode
    ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
    ##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
     $fill_from_array = array("0"=>"Banned", "1"=>"Active", "2"=>"Closed", "3"=>"Removed"); /* as "value"=>"option" */
     $vm_colimns = array(        
        "details_link"=>array("header"=>"Details view", "type"=>"linktoview", "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
        "image_thumb" =>array("header"=>"Thumbnail", "type"=>"image",      "align"=>"center", "width"=>"120px", "wrap"=>"nowrap", "text_length"=>"-1", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "default"=>"default_image.ext", "image_width"=>"100px", "image_height"=>"75px", "linkto"=>"", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2"),
        "image"       =>array("header"=>"Image", "type"=>"data"),
        "submodels"   =>array("header"=>"Submodels", "type"=>"data"),
        "model_name"  =>array("header"=>"Model", "type"=>"label",      "align"=>"left", "width"=>"", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
        "description" =>array("header"=>"Desciption", "type"=>"label",      "align"=>"left", "width"=>"", "wrap"=>"wrap|nowrap", "text_length"=>"255", "tooltip"=>"true", "tooltip_type"=>"simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>""),
        "price_from"  =>array("header"=>"Price From", "type"=>"money",     "align"=>"right", "width"=>"", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "sign"=>"$", "sign_place"=>"before", "decimal_places"=>"0", "dec_separator"=>".", "thousands_separator"=>","),
        "price_to"    =>array("header"=>"Price to", "type"=>"money",     "align"=>"right", "width"=>"", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "sign"=>"$", "sign_place"=>"before", "decimal_places"=>"0", "dec_separator"=>".", "thousands_separator"=>","),

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
    ///     "FieldName_12"=>array("header"=>"Name_l", "type"=>"barchart",  "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "field"=>"field_name", "maximum_value"=>"value", "display_type"=>"vertical|horizontal"),
    ///     "FieldName_13"=>array("header"=>"Name_M", "type"=>"enum",      "align"=>"left", "width"=>"X%|Xpx", "wrap"=>"wrap|nowrap", "text_length"=>"-1", "tooltip"=>"false", "tooltip_type"=>"floating|simple", "case"=>"normal|upper|lower|camel", "summarize"=>"false", "sort_type"=>"string|numeric", "sort_by"=>"", "visible"=>"true", "on_js_event"=>"", "source"=>$fill_from_array),
    ///     "FieldName_14"=>array("header"=>"Name_N", "type"=>"blob"),
     );
     $dgrid->SetColumnsInViewMode($vm_colimns);
    ##  *** set auto-generated columns in view mode
    //  $auto_column_in_view_mode = true;
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
    ##  ***  set settings for add/edit/details modes
      $table_name  = "demo_cars";
      $primary_key = "id";
    ##  for ex.: "table_name.field = ".$_REQUEST['abc_rid'];
      $condition   = "";
      $dgrid->SetTableEdit($table_name, $primary_key, $condition);
    ##  *** set columns in edit mode   
    ##  *** first letter:  r - required, s - simple (not required)
    ##  *** second letter: t - text(including datetime), n - numeric, a - alphanumeric,
    ##                     e - email, f - float, y - any, l - login name, z - zipcode,
    ##                     p - password, i - integer, v - verified, c - checkbox, u - URL
    ##  *** third letter (optional): 
    ##          for numbers: s - signed, u - unsigned, p - positive, n - negative
    ##          for strings: u - upper,  l - lower,    n - normal,   y - any
    ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
    ##  *** Ex.: type = textbox|textarea|label|date(yyyy-mm-dd)|datedmy(dd-mm-yyyy)|datetime(yyyy-mm-dd hh:mm:ss)|datetimedmy(dd-mm-yyyy hh:mm:ss)|time(hh:mm:ss)|image|password|enum|print|checkbox
    ##  *** make sure your WYSIWYG dir has 755 access permissions
    ##  *** make sure uploading directories for files/images have 755 access permissions
    /// $fill_from_array = array("0"=>"No", "1"=>"Yes", "2"=>"Don't know", "3"=>"My be"); /* as "value"=>"option" */
     $em_columns = array(
        "model_name"  =>array("header"=>"Model Name", "type"=>"textbox",    "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
        "description" =>array("header"=>"Desciption", "type"=>"textarea",   "req_type"=>"ry", "width"=>"430px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "edit_type"=>"simple", "resizable"=>"true", "rows"=>"3", "cols"=>"50"),
        "submodels"   =>array("header"=>"Submodels", "type"=>"textbox",     "req_type"=>"sy", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
        
        "image_thumb" =>array("header"=>"Thumbnail", "type"=>"image",      "req_type"=>"st", "width"=>"220px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100KB", "image_width"=>"100px", "image_height"=>"75px", "resize_image"=>"true", "resize_width"=>"100px", "resize_height"=>"75px", "magnify"=>"false", "magnify_type"=>"popup|magnifier|lightbox", "magnify_power"=>"2", "file_name"=>"car_thumb_".((isset($_GET[$unique_prefix.'mode']) && ($_GET[$unique_prefix.'mode'] == "add")) ? $dgrid->GetRandomString("10") : $dgrid->GetRandomString("10")), "host"=>"local|remote"),
        "image"       =>array("header"=>"Image", "type"=>"image",      "req_type"=>"st", "width"=>"220px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"300KB", "image_width"=>"100px", "image_height"=>"75px", "resize_image"=>"false", "resize_width"=>"100px", "resize_height"=>"75px", "magnify"=>"false", "magnify_type"=>"popup|magnifier|lightbox", "magnify_power"=>"2", "file_name"=>"car_".((isset($_GET[$unique_prefix.'mode']) && ($_GET[$unique_prefix.'mode'] == "add")) ? $dgrid->GetRandomString("10") : $dgrid->GetRandomString("10")), "host"=>"local|remote"),

        "price_from"  =>array("header"=>"Price From", "type"=>"money",      "req_type"=>"rf", "width"=>"80px",  "title"=>"", "readonly"=>"false", "maxlength"=>"9", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "sign"=>"$", "sign_place"=>"before", "decimal_places"=>"0", "dec_separator"=>".", "thousands_separator"=>","),
        "price_to"    =>array("header"=>"Price To", "type"=>"money",      "req_type"=>"rf", "width"=>"80px",  "title"=>"", "readonly"=>"false", "maxlength"=>"9", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "sign"=>"$", "sign_place"=>"before", "decimal_places"=>"0", "dec_separator"=>".", "thousands_separator"=>","),

    ///     "FieldName_1"  =>array("header"=>"Name_A", "type"=>"textbox",    "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
    ///     "FieldName_2"  =>array("header"=>"Name_B", "type"=>"textarea",   "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "edit_type"=>"simple|wysiwyg", "resizable"=>"false", "rows"=>"7", "cols"=>"50"),
    ///     "FieldName_3"  =>array("header"=>"Name_C", "type"=>"label",      "req_type"=>"st", "title"=>"", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
    ///     "FieldName_4"  =>array("header"=>"Name_D", "type"=>"date",       "req_type"=>"rt", "width"=>"187px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "calendar_type"=>"popup|floating|dropdownlist"),
    ///     "FieldName_5"  =>array("header"=>"Name_E", "type"=>"datetime",   "req_type"=>"st", "width"=>"187px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "calendar_type"=>"popup|floating|dropdownlist", "show_seconds"=>"true"),
    ///     "FieldName_6"  =>array("header"=>"Name_F", "type"=>"time",       "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
    ///     "FieldName_7"  =>array("header"=>"Name_G", "type"=>"image",      "req_type"=>"st", "width"=>"220px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100000|100K|10M|1G", "image_width"=>"120px", "image_height"=>"90px", "resize_image"=>"false", "resize_width"=>"", "resize_height"=>"", "magnify"=>"false", magnify_type"=>"popup|magnifier|lightbox", "magnify_power"=>"2", "file_name"=>"", "host"=>"local|remote"),
    ///     "FieldName_8"  =>array("header"=>"Name_H", "type"=>"password",   "req_type"=>"rp", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "hide"=>"false", "generate"=>"true", "cryptography"=>"false", "cryptography_type"=>"aes|md5", "aes_password"=>"aes_password"),
    ///     "FieldName_9"  =>array("header"=>"Name_I", "type"=>"money",      "req_type"=>"rf", "width"=>"80px",  "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "sign"=>"$", "sign_place"=>"before|after", "decimal_places"=>"2", "dec_separator"=>".", "thousands_separator"=>","),
    ///     "FieldName_9"  =>array("header"=>"Name_I", "type"=>"enum",       "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "source"=>"self"|$fill_from_array, "view_type"=>"dropdownlist(default)|radiobutton|checkbox", "radiobuttons_alignment"=>"horizontal|vertical", "multiple"=>"false", "multiple_size"=>"4"),
    ///     "FieldName_10" =>array("header"=>"Name_J", "type"=>"print",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
    ///     "FieldName_11" =>array("header"=>"Name_K", "type"=>"checkbox",   "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "true_value"=>1, "false_value"=>0),
    ///     "FieldName_12" =>array("header"=>"Name_L", "type"=>"file",       "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"uploads/", "max_file_size"=>"100000|100K|10M|1G", "file_name"=>"File_Name", "host"=>"local|remote"),
    ///     "FieldName_13_a" =>array("header"=>"Name_M (for add/edit mode)", "type"=>"link",   "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>""),
    ///     "FieldName_13_b" =>array("header"=>"Name_M (for details mode)",  "type"=>"link",   "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "field_key"=>"", "field_key_1"=>"", "field_data"=>"", "rel"=>"", "title"=>"", "target"=>"_self", "href"=>"{0}"),
    ///     "FieldName_14" =>array("header"=>"Name_N", "type"=>"foreign_key","req_type"=>"ri", "width"=>"210px", "title"=>"", "readonly"=>"false", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true"),
    ///     "FieldName_15" =>array("header"=>"Name_O", "type"=>"blob",       "req_type"=>"st", "readonly"=>"false"),
    ///     "FieldName_16" =>array("header"=>"",       "type"=>"hidden",     "req_type"=>"st", "default"=>"default_value", "unique"=>"false"),
    ///     "validator"    =>array("header"=>"Name_N", "type"=>"validator",  "req_type"=>"rv", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "visible"=>"true", "on_js_event"=>"", "for_field"=>"", "validation_type"=>"password|email"),
    ///     "delimiter_1|2|3..."    =>array("inner_html"=>"<br>"),
     );
     $dgrid->SetColumnsInEditMode($em_columns);
    ##  *** set auto-generated columns in edit mode
    //  $auto_column_in_edit_mode = true;
    //  $dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);
    ##  *** set foreign keys for add/edit/details modes (if there are linked tables)
    ##  *** Ex.: "field_name"=>"CONCAT(field1,','field2) as field3" 
    ##  *** Ex.: "condition"=>"TableName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
    ##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
    /// $foreign_keys = array(
    ///     "ForeignKey_1"=>array("table"=>"TableName_1", "field_key"=>"FieldKey_1", "field_name"=>"FieldName_1", "view_type"=>"dropdownlist(default)|radiobutton|textbox|label", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"", "order_type"=>"ASC|DESC", "on_js_event"=>""),
    ///     "ForeignKey_2"=>array("table"=>"TableName_2", "field_key"=>"FieldKey_2", "field_name"=>"FieldName_2", "view_type"=>"dropdownlist(default)|radiobutton|textbox|label", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"", "order_type"=>"ASC|DESC", "on_js_event"=>"")
    /// ); 
    /// $dgrid->SetForeignKeysEdit($foreign_keys);
    ################################################################################
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>PHP DataGrid :: Sample #2-8 (code) - Customized layout in View Mode</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name='keywords' content='php grid, php datagrid, php data grid, datagrid sample, datagrid php, datagrid, grid php, datagrid in php, data grid in php, free php grid, free php datagrid, pear datagrid, datagrid paging' />
    <meta name='description' content='Advanced Power of PHP :: PHP DataGrid - Customized layout in View Mode' />
    <meta content='Advanced Power of PHP' name='author'></meta>
    <meta name="ROBOTS" content="All" />
    <meta name="revisit-after" content="7 days" />
    <?
        ## call of this method between HTML <HEAD> elements
        $dgrid->WriteCssClass();
    ?>
</head>
<body>
<?
    ################################################################################   
    ## +---------------------------------------------------------------------------+
    ## | 8. Bind the DataGrid:                                                     | 
    ## +---------------------------------------------------------------------------+
    ##  *** bind the DataGrid and draw it on the screen
      $dgrid->Bind();        
      ob_end_flush();
    ################################################################################   
?>
