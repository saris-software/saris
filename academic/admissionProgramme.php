<?php

################################################################################
## +---------------------------------------------------------------------------+
## | 1. Creating & Calling:                                                    | 
## +---------------------------------------------------------------------------+
##  *** define a relative (virtual) path to datagrid.class.php file
##  *** (relatively to the current file)
##  *** RELATIVE PATH ONLY ***

    define ("DATAGRID_DIR", "../datagrid/");                              /* Ex.: "datagrid/" */ 
    define ("PEAR_DIR", "../datagrid/pear/");                    /* Ex.: "datagrid/pear/" */
    include ('../datagrid/pear/DB.php');
    require ('../datagrid/datagrid.class.php');
    
   require_once(DATAGRID_DIR.'datagrid.class.php');
    require_once(PEAR_DIR.'PEAR.php');
   require_once(PEAR_DIR.'DB.php');
    
##
##  *** creating variables that we need for database connection 

    // includes database connection parameters
    include_once('../Connections/zalongwa.php');
   
    $DB_USER=strrev($username_zalongwa);            
    $DB_PASS=strrev($password_zalongwa);          
    $DB_HOST=$hostname_zalongwa;       
    $DB_NAME=$database_zalongwa; 
    
  ob_start();
##  *** (example of ODBC connection string)
##  *** $result_conn = $db_conn->connect(DB::parseDSN('odbc://root:12345@test_db'));
##  *** (example of Oracle connection string)
##  *** $result_conn = $db_conn->connect(DB::parseDSN('oci8://root:12345@localhost:1521/mydatabase)); 
##  *** (example of PostgreSQL connection string)
##  *** $result_conn = $db_conn->connect(DB::parseDSN('pgsql://root:12345@localhost/mydatabase)); 
##  === (Examples of connections to other db types see in "docs/pear/" folder)


    $db_conn = DB::factory('mysql');  /* don't forget to change on appropriate db type */
    $result_conn = $db_conn->connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
    if(DB::isError($result_conn)){ die($result_conn->getDebugInfo()); }
##  *** put a primary key on the first place 
    $sql=" SELECT programme.ProgrammeID, programme.ProgrammeCode, programme.ProgrammeName, programme.Title,
             programme.Ntalevel, programme.Faculty, programme.CampusID FROM programme";
##  *** set needed options and create a new class instance 
  $debug_mode = false;        /* display SQL statements while processing */    
  $messaging = true;          /* display system messages on a screen */ 
  $unique_prefix = "prs_";    /* prevent overlays - must be started with a letter */

  $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
##  *** set encoding and collation (default: utf8/utf8_unicode_ci)
/// $dg_encoding = "utf8";
/// $dg_collation = "utf8_unicode_ci";
/// $dgrid->SetEncoding($dg_encoding, $dg_collation);
##  *** set data source with needed options
  $default_order_field = "ProgrammeName";
  $default_order_type = "ASC";
  $dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);

##
##
## +---------------------------------------------------------------------------+
## | 2. General Settings:                                                      | 
## +---------------------------------------------------------------------------+
## +-- AJAX -------------------------------------------------------------------+
##  *** enable or disable using of AJAX (for sorting and paging ONLY)
 $ajax_option = true;
 $dgrid->AllowAjax($ajax_option);
##  *** set interface language (default - English)
##  *** (en) - English     (de) - German     (se) - Swedish   (hr) - Bosnian/Croatian
##  *** (hu) - Hungarian   (es) - Espanol    (ca) - Catala    (fr) - Francais
##  *** (nl) - Netherlands/"Vlaams"(Flemish) (it) - Italiano  (pl) - Polish
##  *** (ch) - Chinese     (sr) - Serbian    (bg) - Bulgarian (pb) - Brazilian Portuguese
##  *** (ar) - Arabic      (tr) - Turkish    (cz) - Czech     (ro/ro_utf8) - Romanian
##  *** (gk) - Greek       (he) - Hebrew     (ru_utf8) - Russian
/// $dg_language = "en";  
/// $dgrid->SetInterfaceLang($dg_language);
##  *** set direction: "ltr" or "rtr" (default - "ltr")
/// $direction = "ltr";
/// $dgrid->SetDirection($direction);
##  *** set layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized 
 $layouts = array("view"=>"0", "edit"=>"1", "details"=>"1", "filter"=>"2"); 
 $dgrid->SetLayouts($layouts);
/// $details_template = "<table><tr><td>{field_name_1}</td><td>{field_name_2}</td></tr>...</table>";
/// $dgrid->SetTemplates("","",$details_template);
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
##  *** allow scrolling on datagrid
/// $scrolling_option = false;
/// $dgrid->AllowScrollingSettings($scrolling_option);  
##  *** set scrolling settings (optional)
/// $scrolling_height = "200px";
/// $dgrid->SetScrollingSettings($scrolling_height);
##  *** allow multirow operations
    $multirow_option = true;
    $dgrid->AllowMultirowOperations($multirow_option);
    $multirow_operations = array(
        "edit"  => array("view"=>true),
        "delete"  => array("view"=>true),
        "details" => array("view"=>true),
       
    );
    $dgrid->SetMultirowOperations($multirow_operations);  
##  *** set CSS class for datagrid
##  *** "default" or "blue" or "gray" or "green" or "pink" or your own css file 
 $css_class = "x-blue";
 $dgrid->SetCssClass($css_class);
##  *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.) 
// $http_get_vars = array("id");
// $dgrid->SetHttpGetVars($http_get_vars);
##  *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
##  *** format (in which mode to allow processing of another datagrids)
##  *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
/// $anotherDatagrids = array("abcd_"=>array("view"=>true, "edit"=>true, "details"=>true));
/// $dgrid->SetAnotherDatagrids($anotherDatagrids);  
##  *** set DataGrid caption

  if(!isset($_GET['prs_mode'])){
 $dg_caption = '<div style="color:blue;width:1000px;">Click on Program Code to Edit Subject List.  Click on Short Name to Edit Total Credits </div>';
 $dgrid->SetCaption($dg_caption);
  }
##
##
## +---------------------------------------------------------------------------+
## | 3. Printing & Exporting Settings:                                         | 
## +---------------------------------------------------------------------------+
##  *** set printing option: true(default) or false 
 $printing_option = true;
 $dgrid->AllowPrinting($printing_option);
##  *** set exporting option: true(default) or false and relative (virtual) path
##  *** to export directory (relatively to datagrid.class.php file).
##  *** Ex.: "" - if we use current datagrid folder
 $exporting_option = FALSE;
 $exporting_directory = "../datagrid/download/";               
 $dgrid->AllowExporting($exporting_option, $exporting_directory);
 $exporting_types = array("excel"=>"true", "pdf"=>"true", "xml"=>"true");
 $dgrid->AllowExportingTypes($exporting_types);
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
 $dropdown_paging = true;
 $dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign, $dropdown_paging);
##  *** set paging settings
 $bottom_paging = array("results"=>true, "results_align"=>"left", "pages"=>true, "pages_align"=>"center", "page_size"=>true, "page_size_align"=>"right");
 $top_paging = array();
 $pages_array = array("5"=>"5", "10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000");
 $default_page_size = 10;
 $paging_arrows = array("first"=>"|&lt;&lt;", "previous"=>"&lt;&lt;", "next"=>"&gt;&gt;", "last"=>"&gt;&gt;|");
 $dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
##
##
## +---------------------------------------------------------------------------+
## | 5. Filter Settings:                                                       | 
## +---------------------------------------------------------------------------+
##  *** set filtering option: true or false(default)
    $filtering_option = true;
    $show_search_type = true;
    $dgrid->AllowFiltering($filtering_option, $show_search_type);
##  *** set additional filtering settings
##  *** tips: use "," (comma) if you want to make search by some words, for ex.: hello, bye, hi
/// $fill_from_array = array("0"=>"No", "1"=>"Yes");  /* as "value"=>"option" */
    $filtering_fields = array(
     "Programme Code"    =>array("type"=>"textbox", "table"=>"programme", "field"=>"ProgrammeCode", "show_operator"=>"false", "default_operator"=>"like%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"130px", "on_js_event"=>""),
    "Short Name "  =>array("type"=>"textbox", "table"=>"programme", "field"=>"ProgrammeName", "show_operator"=>"false", "default_operator"=>"like%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"130px", "on_js_event"=>""),
    "Full Name"  =>array("type"=>"textbox", "table"=>"programme", "field"=>"Title", "show_operator"=>"false", "default_operator"=>"like%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"130px", "on_js_event"=>""),
    "Faculty"  =>array("type"=>"textbox", "table"=>"programme", "field"=>"Faculty", "show_operator"=>"false", "default_operator"=>"like%", "case_sensitive"=>"false", "comparison_type"=>"string", "width"=>"130px", "on_js_event"=>""),
    
///     "Caption_1"=>array("type"=>"textbox", "table"=>"tableName_1", "field"=>"fieldName_1|,fieldName_2", "show_operator"=>"false", "default_operator"=>"=|<|>|like|%like|like%|%like%|not like", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "on_js_event"=>""),
///     "Caption_2"=>array("type"=>"textbox", "autocomplete"=>"false", "handler"=>"modules/autosuggest/test.php", "maxresults"=>"12", "shownoresults"=>"false", "table"=>"tableName_1", "field"=>"fieldName_1|,fieldName_2", "show_operator"=>"false", "default_operator"=>"=|<|>|like|%like|like%|%like%|not like", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "on_js_event"=>""),
///     "Caption_3"=>array("type"=>"dropdownlist", "order"=>"ASC|DESC", "table"=>"tableName_2", "field"=>"fieldName_2", "source"=>"self"|$fill_from_array, "show"=>"", "condition"=>"", "show_operator"=>"false", "default_operator"=>"=|<|>|like|%like|like%|%like%|not like", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "multiple"=>"false", "multiple_size"=>"4", "on_js_event"=>""),
///     "Caption_4"=>array("type"=>"calendar", "table"=>"tableName_3", "field"=>"fieldName_3", "show_operator"=>"false", "default_operator"=>"=|<|>|like|%like|like%|%like%|not like", "case_sensitive"=>"false", "comparison_type"=>"string|numeric|binary", "width"=>"", "on_js_event"=>""),
    );
    $dgrid->SetFieldsFiltering($filtering_fields);
##
## 
## +---------------------------------------------------------------------------+
## | 6. View Mode Settings:                                                    | 
## +---------------------------------------------------------------------------+
##  *** set view mode table properties
 $vm_table_properties = array("width"=>"1000px");
 $dgrid->SetViewModeTableProperties($vm_table_properties);  
##  *** set columns in view mode
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
##  ***      "barchart" : number format in SELECT SQL must be equal with number format in max_value
$fill_from_array = array("3000"=>"Banned"); /* as "value"=>"option" */
 $vm_colimns = array(
     "ProgrammeCode" => array("header"=>"Programme Code", "width"=>"90px", "type"=>"link",  "field_key"=>"ProgrammeCode","field_data"=>"ProgrammeCode", "href"=>"lectureProgrammeCourselistyear.php?edit={0}", "align"=>"left",  "wrap"=>"wrap", "class"=>"sophy",  "text_length"=>"", "case"=>"normal"),
     "ProgrammeName" => array("header"=>"Short Name", "type"=>"link","type"=>"link",  "field_key"=>"ProgrammeCode","field_data"=>"ProgrammeName", "href"=>"lecturerProgrammecoursecount.php?edit={0}", "align"=>"left",  "wrap"=>"wrap",   "text_length"=>"", "case"=>"normal"),
     "Title" => array("header"=>"Full Name",  "type"=>"label", "align"=>"left",  "wrap"=>"wrap",   "text_length"=>"", "case"=>"normal"),
      "Faculty" => array("header"=>"Faculty",  "type"=>"label", "align"=>"left",  "wrap"=>"wrap",   "text_length"=>"", "case"=>"normal"),
 );
 $dgrid->SetColumnsInViewMode($vm_colimns);
##  *** set auto-generated columns in view mode
//  $auto_column_in_view_mode = false;
//  $dgrid->SetAutoColumnsInViewMode($auto_column_in_view_mode);
##
##
## +---------------------------------------------------------------------------+
## | 7. Add/Edit/Details Mode Settings:                                        | 
## +---------------------------------------------------------------------------+
##  *** set add/edit mode table properties
    $em_table_properties = array("width"=>"600px");
    $dgrid->SetEditModeTableProperties($em_table_properties);
##  *** set details mode table properties
    $dm_table_properties = array("width"=>"600px");
    $dgrid->SetDetailsModeTableProperties($dm_table_properties);
##  ***  set settings for add/edit/details modes
    $table_name  = "programme";
    $primary_key = "ProgrammeID";
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
##  *** make sure your WYSIWYG dir has 777 permissions
/// $fill_from_array = array("0"=>"No", "1"=>"Yes", "2"=>"Don't know", "3"=>"My be"); /* as "value"=>"option" */
  
    $em_columns = array(
         "CampusID"    =>array("header"=>"Institution:",       "type"=>"textbox",  "width"=>"250px", "req_type"=>"ri", "title"=>"Institution"),
         "Faculty"  =>array("header"=>"Faculty:", "type"=>"textbox",     "req_type"=>"rt", "width"=>"250px", "title"=>"Campus"),
         "Dept"     =>array("header"=>"Department:",     "type"=>"textbox",  "width"=>"250px",   "req_type"=>"rt",  "title"=>"Department"),
"Ntalevel"     =>array("header"=>"Award:",     "type"=>"textbox",  "width"=>"250px",   "req_type"=>"rt",  "title"=>"Award"),
         "ProgrammeCode"  =>array("header"=>"Programme Code:",  "type"=>"textbox",  "width"=>"250px", "req_type"=>"rt", "unique"=>TRUE, $readonly. "title"=>"Programme Code"),
         "ProgrammeName"   =>array("header"=>"Short Name:",     "type"=>"textbox", "width"=>"250px", "req_type"=>"rt", "unique"=>TRUE,  "title"=>"Short Name" ),
         "Title"   =>array("header"=>"Full Name:",     "type"=>"textbox", "width"=>"250px", "req_type"=>"rt", "unique"=>TRUE,  "title"=>"Full Name"),
    );
    
    //allow read only in program code
    if(isset($_GET['prs_mode']) && $_GET['prs_mode'] == 'edit'){
    	$em_columns['ProgrammeCode']['readonly']=TRUE;
    }
    $dgrid->SetColumnsInEditMode($em_columns);
##  *** set auto-generated columns in edit mode
//  $auto_column_in_edit_mode = false;
//  $dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);
##  *** set foreign keys for add/edit/details modes (if there are linked tables)
##  *** Ex.: "field_name"=>"CONCAT(field1,','field2) as field3" 
##  *** Ex.: "condition"=>"TableName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
 $foreign_keys = array(
    "CampusID"=>array("table"=>"campus", "field_key"=>"CampusID", "field_name"=>"Campus", "view_type"=>"dropdownlist", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"", "order_type"=>"ASC", "on_js_event"=>""),
    "Faculty"=>array("table"=>"faculty", "field_key"=>"FacultyName", "field_name"=>"FacultyName", "view_type"=>"dropdownlist", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"", "order_type"=>"ASC", "on_js_event"=>""),
    "Dept"=>array("table"=>"department", "field_key"=>"DeptName", "field_name"=>"DeptName", "view_type"=>"dropdownlist", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"", "order_type"=>"ASC", "on_js_event"=>""),
"Ntalevel"=>array("table"=>"studylevel", "field_key"=>"LevelCode", "field_name"=>"LevelName", "view_type"=>"dropdownlist", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"", "order_type"=>"ASC", "on_js_event"=>""),
///    "ForeignKey_2"=>array("table"=>"TableName_2", "field_key"=>"FieldKey_2", "field_name"=>"FieldName_2", "view_type"=>"dropdownlist(default)|radiobutton|textbox", "radiobuttons_alignment"=>"horizontal|vertical", "condition"=>"", "order_by_field"=>"", "order_type"=>"ASC|DESC", "on_js_event"=>"")
 ); 
 $dgrid->SetForeignKeysEdit($foreign_keys);

?>
<?php 
	require_once('../Connections/zalongwa.php');
	require_once('../Connections/sessioncontrol.php');

	include('policy.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Programme Information';
	$szSubSection = 'Programme';
	//include("lecturerheader.php");
	
        ## call of this method between HTML <HEAD> elements
        $dgrid->WriteCssClass();
    
    ?>


<?php
    ################################################################################   
    ## +---------------------------------------------------------------------------+
    ## | 8. Bind the DataGrid:                                                     | 
    ## +---------------------------------------------------------------------------+
    ##  *** bind the DataGrid and draw it on the screen
      $dgrid->Bind();        
      ob_end_flush();
    
    ################################################################################   



function my_format_date($last_login_time){
    $last_login = mktime(substr($last_login_time, 11, 2), substr($last_login_time, 14, 2),
                        substr($last_login_time, 17, 2), substr($last_login_time, 5, 2),
                        substr($last_login_time, 8, 2), substr($last_login_time, 0, 4));
    if($last_login_time != ""){
        return date("M d, Y g:i A", $last_login);
        //return substr(0, 4);
    }else return "";
}
include '../footer/footer.php';
?>
