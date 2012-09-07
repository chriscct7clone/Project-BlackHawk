<?php
/*
This is the rough start of a conversion from the install script from Kombineer(the PHP project management system) to the install script for the 
garage side. This script DOES NOT WORK atm. Theres alot of work to be done here, but nothing thats not manageable ;).
Its almost tempting to use the SMARTY template for the install of Kombineer and then after the garage part is installed, use PHP's rmdir to delete
the whole install SMARTY template and files, because after all they will never be used again. Tempting...tempting. Will think about it, but ideally,
at some point I am gonna merge this script with the one for the install of the User system (so they only have to use one script to install) so I will
probably not just use the SMARTY template. Tempting as it may be.
*/

error_reporting(0);
// BlackHawk .0.1: Start setting up install script for garage
require_once("./include/installfunctions.php");
require_once("./include/mysqldatabase.class.php");
//check if the settings table is present. If yes, assume BlackHawk is already installed and abort.
$alwaysfalse=false; //for now
if ($alwaysfalse==true) {
die("Project BlackHawk seems to be already installed.<br />If this is an error, please clear your database.");
}
// If folders do not exist, make them
// if (!file_exists("./templates_c") or !is_writable("./templates_c")) {
// $templates_c_status = mkdir("./temp");
//$files_status = mkdir("./files");
}
// Make sure we have the folders. If not, we do not have write access.
//if (!file_exists("./templates_c") || !is_writable("./templates_c")) {
//die("Required folder templates_c does not exist or is not writable. <br />Please create the folder or make it writable in order to proceed.");
//}
require("./init.php");
$action = getArrayVal($_GET, "action");
$installURL = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
$template->assign("locale", $locale);
$title = 'Install BlackHawk Garage';
$template->assign("title", $title);
if (!$action) {
// check if required directories are writable
$configfilechk = is_writable(CL_ROOT . "/config/" . CL_CONFIG . "/config.php");
$filesdir = is_writable(CL_ROOT . "/files/");
$templatesdir = is_writable(CL_ROOT . "/templates_c/");
$phpver = phpversion();
$is_mbstring_enabled = extension_loaded('mbstring');
$sessionsactive=extension_loaded('session');
$subdombool=subdomboolcheck();
$template->assign("phpver", $phpver);
$template->assign("configfile", $configfilechk);
$template->assign("filesdir", $filesdir);
$template->assign("templatesdir", $templatesdir);
$template->assign("is_mbstring_enabled", $is_mbstring_enabled);
$template->assign("subdombool",$subdombool);

$template->display("install1.tpl");
} elseif ($action == "step2") {
if (!empty($settings)) {
die("Kombineer seems to be already installed.<br />If this is an error, please clear your database.");
}
$db_host = $_POST['db_host'];
$db_name = $_POST['db_name'];
$db_user = $_POST['db_user'];
$db_pass = $_POST['db_pass'];

// connect database.
$db = new database();
$conn = $db->connect($db_name, $db_user, $db_pass, $db_host);
if (!($conn)) {
die("Database connection could not be established. <br />Please check if database exists and check if login credentials are correct.");
die();
}
// Create MySQL Tables
$table1  = mysql_query($sqltable1);
$table2  = mysql_query($sqltable2);
$table3  = mysql_query($sqltable3);
$table4  = mysql_query($sqltable4);
$table5  = mysql_query($sqltable5);
$table6  = mysql_query($sqltable6);
$table7  = mysql_query($sqltable7);
$table8  = mysql_query($sqltable8);
$table9  = mysql_query($sqltable9);
$table10 = mysql_query($sqltable10);
$table11 = mysql_query($sqltable11);
$table12 = mysql_query($sqltable12);
$table13 = mysql_query($sqltable13);
$table14 = mysql_query($sqltable14);
$table15 = mysql_query($sqltable15);
$table16 = mysql_query($sqltable16);
$table17 = mysql_query($sqltable17);
$table18 = mysql_query($sqltable18);
$table19 = mysql_query($sqltable19);
$table20 = mysql_query($sqltable20);

// Checks if tables could be created
if (!$table1 || !$table2 || !$table3 || !$table4 || !$table5 || !$table6 || !$table7 || !$table8 || !$table9 || !$table10 || !$table11 || !$table12 || !$table13 || !$table14 || !$table15 || !$table16 || !$table17 || !$table18 || !$table19 || !$table20) {
$template->assign("errortext", "Error: Tables could not be created.");
$template->display("error.tpl");
die();
}
// Get the servers default timezone
$timezone = date_default_timezone_get();

// insert default settings
$ins = mysql_query("INSERT INTO settings (name,subtitle,locale,timezone,dateformat,template,mailnotify,mailfrom,mailmethod) VALUES ('BlackHawk','Garage Management','$locale','$timezone','d.m.Y','standard',1,'BlackHawk@localhost','mail')");


if (!$ins) {
$template->assign("errortext", "Error: Failed to create initial settings.");
$template->display("error.tpl");
die();
}

// Write config files
$iniver = CL_VERSION . CL_SUBVERSION.".".CL_COMMIT;
$api_secret = md5( 'BlackHawk' ); // shared api secret key, can be changed anytime via config
// write db login data to config file
$file = fopen(CL_ROOT . "/config/" . CL_CONFIG . "/config.php", "w+");
$str = "<?php
\$db_host = '$db_host';\n
\$db_name = '$db_name';\n
\$db_user = '$db_user';\n
\$db_pass = '$db_pass';\n
\$iniver = '$iniver';\n
\$api_secret = '$api_secret'\n
?>";
$put = fwrite($file, "$str");
if ($put) {
@chmod(CL_ROOT . "/config/" . CL_CONFIG . "/config.php", 0755);
}

// Write .htaccess file
$fp = fopen(CL_ROOT . "/.htaccess", "a");
fwrite($fp, "\n\n# ErrorDocuments \n");
fwrite($fp, "ErrorDocument 400 ". $installURL."/errorcode.php?error=400 \n");
fwrite($fp, "ErrorDocument 401 ". $installURL."/errorcode.php?error=401 \n");
fwrite($fp, "ErrorDocument 402 ". $installURL."/errorcode.php?error=402 \n");
fwrite($fp, "ErrorDocument 403 ". $installURL."/errorcode.php?error=403 \n");
fwrite($fp, "ErrorDocument 404 ". $installURL."/errorcode.php?error=404 \n");
fwrite($fp, "ErrorDocument 405 ". $installURL."/errorcode.php?error=405 \n");
fwrite($fp, "ErrorDocument 406 ". $installURL."/errorcode.php?error=406 \n");
fwrite($fp, "ErrorDocument 407 ". $installURL."/errorcode.php?error=407 \n");
fwrite($fp, "ErrorDocument 408 ". $installURL."/errorcode.php?error=408 \n");
fwrite($fp, "ErrorDocument 409 ". $installURL."/errorcode.php?error=409 \n");
fwrite($fp, "ErrorDocument 410 ". $installURL."/errorcode.php?error=410 \n");
fwrite($fp, "ErrorDocument 411 ". $installURL."/errorcode.php?error=411 \n");
fwrite($fp, "ErrorDocument 412 ". $installURL."/errorcode.php?error=412 \n");
fwrite($fp, "ErrorDocument 413 ". $installURL."/errorcode.php?error=413 \n");
fwrite($fp, "ErrorDocument 414 ". $installURL."/errorcode.php?error=414 \n");
fwrite($fp, "ErrorDocument 500 ". $installURL."/errorcode.php?error=500 \n");
fwrite($fp, "ErrorDocument 501 ". $installURL."/errorcode.php?error=501 \n");
fwrite($fp, "ErrorDocument 502 ". $installURL."/errorcode.php?error=502 \n");
fwrite($fp, "ErrorDocument 503 ". $installURL."/errorcode.php?error=503 \n");
fwrite($fp, "ErrorDocument 504 ". $installURL."/errorcode.php?error=504 \n");
fwrite($fp, "ErrorDocument 505 ". $installURL."/errorcode.php?error=505 \n");
fclose($fp);
if ($put) {
	@chmod(CL_ROOT . ".htaccess", 0644);
}

$template->display("install2.tpl");
} elseif ($action == "step3") {
$template->display("install3.tpl");
	}
?>