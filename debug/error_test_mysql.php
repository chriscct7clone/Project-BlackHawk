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
<?php if ($global_debug == 0){
header("HTTP/1.0 404 Not Found");
// For Fast-CGI sites: Comment out previous line and uncomment this one
// header("Status: 404 Not Found");
}
 ?>