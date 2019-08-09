<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>PHP DataGrid :: Sample #1-1 (code)</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name='keywords' content='php grid, php datagrid, php data grid, datagrid sample, datagrid php, datagrid, grid php, datagrid in php, data grid in php, free php grid, free php datagrid, pear datagrid, datagrid paging' />
    <meta name='description' content='Advanced Power of PHP - using PHP DataGrid Pro for displaying some statistical data' />
    <meta content='Advanced Power of PHP' name='author'></meta>
  </head>

<body>
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
      $sql=" SELECT "  
       ." demo_countries.id, "
       ." demo_countries.name, "
       ." demo_countries.description, "
       ." demo_countries.picture_url, "
       ." FORMAT(demo_countries.population, 0) as population, "   
       ." CASE WHEN demo_countries.is_democracy = 1 THEN 'Yes' ELSE 'No' END as is_democracy "
       ."FROM demo_countries ";
       
    ##  *** set needed options
      $debug_mode = false;
      $messaging = true;
      $unique_prefix = "f_";  
      $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);

    ##  *** set data source with needed options
      $default_order_field = "name";
      $default_order_type = "ASC";
      $dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);	    
      $dg_caption = '<b>Simplest PHP DataGrid</b> - <a href=index.php>Back to Index</a>';
      $dgrid->SetCaption($dg_caption);
    
    ## +---------------------------------------------------------------------------+
    ## | 6. View Mode Settings:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** set columns in view mode
       $dgrid->SetAutoColumnsInViewMode(true);  
    
    ## +---------------------------------------------------------------------------+
    ## | 7. Add/Edit/Details Mode settings:                                        | 
    ## +---------------------------------------------------------------------------+
    ##  ***  set settings for edit/details mode
      $table_name = "demo_countries";
      $primary_key = "id";
      $condition = "";
      $dgrid->SetTableEdit($table_name, $primary_key, $condition);
      $dgrid->SetAutoColumnsInEditMode(true);
      
    ## +---------------------------------------------------------------------------+
    ## | 8. Bind the DataGrid:                                                     | 
    ## +---------------------------------------------------------------------------+
    ##  *** set debug mode & messaging options
        $dgrid->Bind();        
        ob_end_flush();
    ################################################################################    
?>
</body>
</html>