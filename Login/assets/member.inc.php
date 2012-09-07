<?php
/*
**********
Member Page Includes
**********
*/
/* Include Class */
require_once('config.inc.php');
require_once("database.class.php");
require_once("member.class.php");
/* Start an instance of the Database Class */
$database = new database();
/* Create an instance of the Member Class */
$member = new member();
?>