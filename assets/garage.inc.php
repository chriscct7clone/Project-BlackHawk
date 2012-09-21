<?php
/*
**********
Init Class for the Garage Parent Class
**********
*/
/* Include Class */
require_once('config.inc.php');
require_once("database.class.php");
require_once("garage.class.php");
/* Start an instance of the Database Class */
$database = new database();
/* Create an instance of the garage Class */
$garage = new garage();
?>