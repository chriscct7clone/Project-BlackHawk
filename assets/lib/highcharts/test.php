<?php
header("Content-type: text/json");
$db = mysql_connect("localhost","root","");
mysql_select_db("roles9");
$day=date('Y-m-d'); //UTC standar time
$result = mysql_query("SELECT COUNT(*) FROM `user_roles`;");
$count = mysql_fetch_array($result);
// The x value is the current JavaScript time, which is the Unix time multiplied by       1000.
$x = time() * 1000;
// TODO: Fix below, maybe int the result
// Currently returns non decimal results
$y = (intval($count[0]) +  ((mt_rand(-100,100))/100))*12;// Our base # is 6, which we add a random .XX to. Then mutlply times 12 to get in the 60-70 range.
// Create a PHP array and echo it as JSON
$ret = array($x, $y);
echo json_encode($ret);
?>