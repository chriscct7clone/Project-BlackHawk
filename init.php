<?php
 /**
 * BlackHawk Init
 *
 * Contains program constants
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage General
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @since      File available since Release 0.3.0
 * @todo       Add All HTTP Header descriptions
 */
// turn off errors on prod
ini_set('display_errors', 'off');
ini_set("arg_separator.output", "&amp;");
ini_set('default_charset', 'utf-8');
// get full path to kombineer
define("BLACKHAWK_ROOT", realpath(dirname(__FILE__)));
// configuration to load
define("BLACKHAWK_CONFIG", "standard");
// BLACKHAWK version
define("BLACKHAWK_VERSION", 0.2);
// BLACKHAWK subversion
define("BLACKHAWK_SUBVERSION", .1);
// BLACKHAWK version
define("BLACKHAWK_COMMIT", 42);
// Below only works if Init was included everywhere
// uncomment for debugging
//error_reporting(E_ALL | E_STRICT);

// KES variables
// set debug status (1 is on)
$global_debug=0;
$error_system_version=1.15;
?>