<?php

define("WEBSITE_NAME", 'E-SHOP');

// Database Name
define( "DB_NAME", "eshop_db");
define( "DB_USER", "root");
define( "DB_PASS", value: "");
define( "DB_TYPE", value: "mysql");
define( "DB_HOST", value: "localhost");


define('THEME', 'eshop/');
define('DEBUG', true);

if(DEBUG){
    ini_set('display_errors', DEBUG ? 1 : 0);
}
