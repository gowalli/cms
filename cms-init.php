<?php

/* You can edit some stuff starting here */

// Change this value to define whether this is a production server; this will affect error reporting
define('PRODSERV', false);

// Directory definitions
define('ROOT_DIR', getcwd() . '/');
define('LIB_DIR', ROOT_DIR . 'lib/');
define('MODEL_DIR', ROOT_DIR . 'models/');
define('THEME_DIR', ROOT_DIR . 'themes/');

/* Stop editing here */

include(ROOT_DIR . 'vendor/autoload.php');

// Set error level
if(PRODSERV)
        error_reporting(0);
else
        error_reporting(E_ALL);

// Include database settings
include('cms-config.php');

// Make sure we can autoload files
function yap_autoloader($class) {
        $directories = array(LIB_DIR, MODEL_DIR);

        foreach($directories as $directory) {
                if(!@include("$directory/$class.php"))
                        @include($directory.strtolower($class).".php");
        }
}

spl_autoload_register('yap_autoloader');

$dbtype = DB_TYPE;
$database = new $dbtype;
if(strlen(DB_HOST) && strlen(DB_USER) && strlen(DB_PASS) && strlen(DB_NAME))
        $database->initialize(DB_HOST, DB_USER, DB_PASS, DB_NAME);
