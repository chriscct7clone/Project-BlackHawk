<?php 
ob_start();
include './../init.php';
include './../config/standard/config.php';
ob_end_clean(); ?>
<?php if ($global_debug == 1): ?>
<?php
$link = mysql_connect($db_host,$db_user,$db_pass); 
if (!$link) { 
	die('Could not connect to MySQL: ' . mysql_error()); 
} 
echo 'Connection OK'; mysql_close($link); 
?>
<?php endif; ?>
<?php if ($global_debug == 0): ?>
<h1> Access Denied </h1>
<?php endif; ?>