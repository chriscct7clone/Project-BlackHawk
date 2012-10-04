<?php
 /**
 * Security Index Page
 *
 * This file prevents directory listing
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage Security
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @since      File available since Release 0.3.0
 */
header("HTTP/1.0 404 Not Found");
// For Fast-CGI sites: Comment out previous line and uncomment this one
// header("Status: 404 Not Found");
?>