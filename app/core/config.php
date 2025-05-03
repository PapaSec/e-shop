<?php

define("WEBSITE_NAME", 'E-SHOP');

// Database Name
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define("DB_NAME", "eshop_db");
    define("DB_USER", "root");
    define("DB_PASS", value: "");
    define("DB_TYPE", value: "mysql");
    define("DB_HOST", value: "localhost");
} else {
    define("DB_NAME", "if0_38892432_eshop_db");
    define("DB_USER", "if0_38892432");
    define("DB_PASS", value: "bBYuoQ3ZTBNb4");
    define("DB_TYPE", value: "mysql");
    define("DB_HOST", value: "sql212.infinityfree.com");
}


define('THEME', 'eshop/');
define('DEBUG', true);

if (DEBUG) {
    ini_set('display_errors', DEBUG ? 1 : 0);
}
