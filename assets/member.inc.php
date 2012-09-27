<?php
 /**
 * Creates Members Class
 *
 * Instantiates objects for member, database, and config
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage Members
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @see        member.class.php
 * @since      File available since Release 0.3.0
 */
 /* Include Classes */
require_once('config.inc.php');
require_once("database.class.php");
require_once("member.class.php");
/* Start an instance of the Database Class */
$database = new database();
/* Create an instance of the Member Class */
$member = new member();
?>