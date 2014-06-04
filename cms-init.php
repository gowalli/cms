<?php

/* You can edit some stuff starting here */

// Change this value to define whether this is a production server; this will affect error reporting
define('PRODSERV', false);

// Directory definitions
define('ROOT_DIR', getcwd() . '/');
define('LIB_DIR', ROOT_DIR . 'lib/');
define('VIEW_DIR', ROOT_DIR . 'views/');
define('MODEL_DIR', ROOT_DIR . 'models/');
define('CONTROLLER_DIR', ROOT_DIR . 'controllers/');
define('CONFIG_DIR', ROOT_DIR . 'config/');
define('THEME_DIR', dirname(ROOT_DIR) . '/themes/');

/* Stop editing here */

include(LIB_DIR . 'utility.php');
include(ROOT_DIR . 'vendor/autoload.php');

// Set error level
if(PRODSERV)
        error_reporting(0);
else
        error_reporting(E_ALL);

// Include database settings
include(CONFIG_DIR . 'database.php');

// Make sure we can autoload files
function yap_autoloader($class) {
        $directories = array(CONTROLLER_DIR, LIB_DIR, MODEL_DIR);

        foreach($directories as $directory) {
                if(!@include("$directory/$class.php"))
                        @include($directory.strtolower($class).".php");
        }
}

spl_autoload_register('yap_autoloader');
