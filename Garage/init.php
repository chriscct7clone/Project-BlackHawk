<?php
// turn off errors on prod
ini_set('display_errors', 'off');
ini_set("arg_separator.output", "&amp;");
ini_set('default_charset', 'utf-8');
// get full path to kombineer
define("CL_ROOT", realpath(dirname(__FILE__)));
// configuration to load
define("CL_CONFIG", "standard");
// kombineer version
define("CL_VERSION", 0.0);
// kombineer subversion
define("CL_SUBVERSION", .1);
// commit version
define("CL_COMMIT", 1);

// uncomment for debugging
//error_reporting(E_ALL | E_STRICT);

// KES variables
// set debug status (1 is on)
$global_debug=0;
$error_system_version=1.15;
?>