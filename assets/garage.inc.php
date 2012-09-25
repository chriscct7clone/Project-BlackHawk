<?php
 /**
 * Creates Garage Class
 *
 * Instantiates objects for member, database, and garage
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage Garage
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @see        garage.class.php
 * @since      File available since Release 0.3.0
 */
/* Include Class */
require_once('config.inc.php');
require_once("database.class.php");
require_once("garage.class.php");
/* Start an instance of the Database Class */
$database = new database();
/* Create an instance of the Garage Class */
$garage = new garage();
?>