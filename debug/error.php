<?php
ob_start();
include './../init.php';
include './error_browser.php';
include './error_os.php';
ob_end_clean();
$debug=$global_debug;
?>
<html>
<head>
<title>BlackHawk System Version <?php echo $error_system_version ?></title>
<style type="text/css">
body { margin-left:200px; margin-top:50px; width:500px; font-family:verdana,sans-serif; }
input, textarea { width:500px; font-family:monospace; }
.nowrap { white-space:nowrap; }
</style>
<body>
<?php if ($global_debug == 1): ?>
<form method="GET" action="<?php echo($_SERVER['PHP_SELF']) ?>">
<h3>BlackHawk Error System Version <?php echo $error_system_version ?></h3>
<?php
$host = $uri = '';
if( isset($_GET['host']) )
{
	$host = $_GET['host'];
	$uri = ( isset($_GET['uri']) and strlen($_GET['uri']) > 0 ) ? $_GET['uri'] : '/';
   $content = '';
   $fp = fsockopen("$host", 80, $errno, $errstr, 30); // Alternatively use port 8080
   if(!$fp)
   {
      echo "$errstr ($errno)<br />\n";
      return;
   } 
   else
   {
      fwrite($fp,"HEAD $uri HTTP/1.0\r\n");
      fwrite($fp,"Host: $host\r\n");
      fwrite($fp,"Connection: Close\r\n");
      fwrite($fp,"\r\n");
      while (!feof($fp)) { $content .= fgets($fp, 128); }
      fclose($fp);
   }
   echo "<p>Results for http://$host$uri</p>";
   echo '<textarea cols="55" rows="14" wrap="off">';
   	  echo "BlackHawk Information: \n";
	  echo "BlackHawk Version: " . BLACKHAWK_VERSION . "\n";
	  echo "BlackHawk Full Version: " . BLACKHAWK_VERSION . BLACKHAWK_SUBVERSION . "\n";
	  echo "BlackHawk Root: " . BLACKHAWK_ROOT."\n";
	  echo "BlackHawk Commit #: " . BLACKHAWK_COMMIT . "\n";
	  echo "PHP Version: " . PHP_VERSION . "\n";
	  echo "MySQL Version: " . mysql_get_server_info() . "\n" ;
	  	  echo("MySQL Status: ");
	  $link = mysql_connect($db_host,$db_user,$db_pass); 
		if (!$link) { 
	  echo("Could not connect to MySQL: " . mysql_error(). "\n"); 
		} 
		echo( "Connection OK \n");
		mysql_close($link);
	  echo "\n";
	  echo "User Computer Information: \n";
	  $user_os = getOS();
	  echo "User Operating System: " . $user_os . "\n";
	  $browser = new Browser();
	   echo "User Browser: ".$browser;
	   echo "\n"; 
	echo "Page Status: \n ";
	echo $content;
	echo '</textarea><br /><hr /><br />';
}
?>
<p>
What is the host name (the domain name without the "http://" part)?<br />
<input type="text" name="host" size="55" value="<?php echo($host) ?>">
</p>
<p>
What is the URI (the part of the URL after the domain name, or "/" if default page)?<br />
<input type="text" name="uri" size="55" value="<?php echo($uri) ?>">
</p>
<p>
<input type="submit" name="submit" value="Debug Me!" style="text-align:left">
</p>
<p> More Debug Info: <a href="./masdebug.php">Click here </a> </p>
</form>
<?php endif; ?>
<?php if ($global_debug == 0){
	header("HTTP/1.0 404 Not Found");
// For Fast-CGI sites: Comment out previous line and uncomment this one
// header("Status: 404 Not Found");
}?>
</body>
</html>