<?php
/* Include Notice & Mailer Class */
require_once("../assets/notice.class.php");
$notice = new notice;

if(isset($_POST['setup'])) {

	$hostname            = $_POST['hostname'];
	$database            = $_POST['database'];
	$username            = $_POST['username'];
	$password            = $_POST['password'];
	
	$hash                = $_POST['hash'];
	$bcrypt_rounds       = $_POST['bcrypt_rounds'];
	if ($bcrypt_rounds=="Disabled (because you are not using bcrypt() )"){
	$bcrypt_rounds=12;
	}
	$remember_me         = $_POST['remember_me'];
	$captcha             = $_POST['captcha'];
	
	$email_master        = $_POST['email_master'];
	
	$email_template      = $_POST['email_template'];
	
	$email_welcome       = $_POST['email_welcome'];
	$email_verification  = $_POST['email_verification'];
	
	/* e-mail templates */
	$dh = opendir('../assets/email_templates');
	while(false !== ($filename = readdir($dh))) {
		$ext = strtolower(end(explode('.', $filename)));
		if($ext == 'html') {
			$templates[] = ucfirst(substr($filename,0,-5));
		}
	}
	
	if(empty($hostname)) {
		$notice->add('error', 'Please fill in the hostname');
		$cantDB = true;
	} else {
		$cantDB = false;
	}
	if(empty($database)) {
		$notice->add('error', 'Please fill in the database name');
		$cantDB = true;
	} else {
		$cantDB = false;
	}
	if(empty($username)) {
		$notice->add('error', 'Please fill in the database username');
		$cantDB = true;
	} else {
		$cantDB = false;
	}
	
	if($cantDB == false) {
		/* Try the connections */
		try {
			/* Create a connections with the supplied values */
			$pdo = new PDO("mysql:host=" . $hostname . ";dbname=" . $database . "", $username, $password, array(PDO::ATTR_PERSISTENT => true));
		} catch(PDOException $e) {
			/* If any errors echo the out and kill the script */
			$notice->add('error', 'Database conncetion fail!<br />Make sure your database information is correct');
		}
	}
	
	if(empty($bcrypt_rounds)) {
		$bcrypt_rounds = 12;
	}
	
	
	if(empty($email_master)) {
		$notice->add('error', 'Please enter a E-Mail that will be used to contcat users.');
		$email_master = null;
	}
	
	if($notice->errorsExist() == false) {
		$showForm = false;
		
		
		//Create Config File
		if($config_handle = fopen('../assets/config.inc.php', 'w')) {
			$config_data = '<?php
/*
 * Config Include
 * 
 * Used to write config information into a static var to be
 * used anywhere
 */

/*
 * Get the Config class
 */
require_once(\'config.class.php\');

/*
 * Write settings to the config
 */
Config::write(\'hostname\', \'' . $hostname . '\');
Config::write(\'database\', \'' . $database . '\');
Config::write(\'username\', \'' . $username . '\');
Config::write(\'password\', \'' . $password . '\');
Config::write(\'drivers\', array(PDO::ATTR_PERSISTENT => true));

Config::write(\'hash\', \'' . $hash . '\'); /* Once set DO NOT CHANGE (sha512/bcrypt) */

Config::write(\'bcryptRounds\', \'' . $bcrypt_rounds . '\');

Config::write(\'remember\', ' . $remember_me . ');

Config::write(\'captcha\', ' . $captcha . ');


Config::write(\'email_template\', \'' . $email_template . '\');
Config::write(\'email_master\', \''. $email_master . '\');
Config::write(\'email_welcome\', ' . $email_welcome . ');
Config::write(\'email_verification\', ' . $email_verification . ');
?>';
			fwrite($config_handle, $config_data);
			$notice->add('success', 'Config file created');
		} else {
			$notice->add('error', 'Could not create config file!<br />Check your folder permissions.');
		}
		
		//Run SQL
	// 	Note the two roles are in there but are not being used yet. 
	// Login role= 3=admin, 2=police, 1=students,visitors,teachers
$mysql_users = 'CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `loginrole` int(11) NOT NULL,
  `garagerole` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';


$mysql_users_inactive = 'CREATE TABLE IF NOT EXISTS `users_inactive` (
  `verCode` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';

$mysql_users_logged = 'CREATE TABLE IF NOT EXISTS `users_logged` (
  `id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;';

$mysql_users_logs = 'CREATE TABLE IF NOT EXISTS `users_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';

$mysql_users_recover = 'CREATE TABLE IF NOT EXISTS `users_recover` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `verCode` varchar(225) NOT NULL,
  `requestTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';
		
		
		/* mysql_users */
		$statement = $pdo->prepare($mysql_users);
		if($statement->execute()){
			$notice->add('success', 'Table `users` populated!');
		} else {
			$notice->add('error', 'Could not populate users!');
		}
		
		/* mysql_users_inactive */
		$statement = $pdo->prepare($mysql_users_inactive);
		if($statement->execute()){
			$notice->add('success', 'Table `users_inactive` populated!');
		} else {
			$notice->add('error', 'Could not populate users_inactive!');
		}
		
		/* mysql_users_logged */
		$statement = $pdo->prepare($mysql_users_logged);
		if($statement->execute()){
			$notice->add('success', 'Table `users_logged` populated!');
		} else {
			$notice->add('error', 'Could not populate users_logged!');
		}
		
		/* mysql_users_logs */
		$statement = $pdo->prepare($mysql_users_logs);
		if($statement->execute()){
			$notice->add('success', 'Table `users_logs` populated!');
		} else {
			$notice->add('error', 'Could not populate users_logs!');
		}
		
		/* mysql_users_recover */
		$statement = $pdo->prepare($mysql_users_recover);
		if($statement->execute()){
			$notice->add('success', 'Table `users_recover` populated!');
		} else {
			$notice->add('error', 'Could not populate users_recover!');
		}
		
		
		//Notify that everything is done
		
		//Ask to delete setup folder
		
		if($notice->errorsExist() == false) {
			$notice->add('success', 'BlackHawk has been installed!');
			$finishing_up = '<hr />Please delete your /setup/ folder for security reasons.
<form action="index.php" method="post">
	<span style="text-align: left; margin: 10px 0px 10px 0px; float: left;"><input type="checkbox" name="delete_setup" value="true" /> Delete /setup/ folder</span>
	<input name="continue" type="submit" value="Continue" />
</form>
			';
			
		}
		
	} else {
		$showForm = true;
	}
	
	
} else {
	$notice->add('info', 'Welcome to the BlackHawk Login setup.');
	
	/* Better Passwords? */
	if(defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
		$hash = 'bcrypt';
	} else {
		$notice->add('info', 'Your server does not support Bcrypt!<br />Please use sha512 instead.');
		$hash = 'sha512';
	}
	
	/* Mail enabled? */
	if(function_exists('mail')) {
		$email_welcome = true;
		$email_verification = true;
	} else {
		$notice->add('error', 'Your server does not have mail() enabled.<br />You should keep e-mail verification and welcome e-mail to false however you will need it if you want users to have the ability to recover their passwords.');
		$email_welcome = false;
		$email_verification = false;
	}
	
	/* e-mail templates */
	$dh = opendir('../assets/email_templates');
	while(false !== ($filename = readdir($dh))) {
		$ext = strtolower(end(explode('.', $filename)));
		if($ext == 'html') {
			$templates[] = ucfirst(substr($filename,0,-5));
		}
	}
	
	
	$hostname      = 'localhost';
	$database      = null;
	$username      = 'root';
	$password      = null;
	
	$bcrypt_rounds = 12;
	$remember_me   = true;
	$captcha       = true;
	
	$email_master  = null;
	$email_template = 'default';
	
	$showForm = true;
}


if(isset($_POST['continue'])) {
		$showForm = false;
		rrmdir('../setup');
		$notice->add('success', 'Setup folder removed');
		header('Location: ../index.php');
}
// Disabled so that I don't lose my setup folder after setup.
function rrmdir($dir) {
//	if (is_dir($dir)) {
//		$objects = scandir($dir);
//		foreach ($objects as $object) {
//			if ($object != "." && $object != "..") {
//				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
//			}
//		}
//		reset($objects);
//		rmdir($dir);
//	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>BlackHawk Login Setup</title>
	<!--CSS Files-->
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="wrapper">
	<h1>BlackHawk Login Setup</h1>
<?php
echo $notice->report();
if($showForm == true) {
?>
	<form action="index.php" method="post">
		<fieldset>
			<legend>Database Connection</legend>
			
			<label>Hostname</label>
			<input name="hostname" type="text" value="<?php echo $hostname; ?>" />
			
			<label>Database Name</label>
			<input name="database" type="text" value="<?php echo $database; ?>" />
			
			<label>Username</label>
			<input name="username" type="text" value="<?php echo $username; ?>" />
			
			<label>Password</label>
			<input name="password" type="password" value="<?php echo $password; ?>" />
		</fieldset>
	


		
		
<fieldset>
			<legend>Security</legend>
			<label>Hash Type</label>
			<select name="hash" id="myId">
				<option value="bcrypt"<?php if($hash == 'bcrypt') { echo ' selected="selected"'; } ?>>Bcrypt</option>
				<option value="sha512"<?php if($hash == 'sha512') { echo ' selected="selected"'; } ?>>SHA512</option>
			</select>
<!-- Jquery to allow for disable/enable bycrypt field -->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.1.min.js" /></script>
		<script type="text/javascript">
$("#myId").change(function() {
    var tst = document.getElementById('myId').value;

    if(tst == "sha512") {
        document.getElementById('test').disabled=true;
		document.getElementById('test').value="Disabled (because you are not using bcrypt() )";
    } else {
        document.getElementById('test').disabled=false;
		document.getElementById('test').value="12";
    }
});
		</script>
			<label>Bcrypt rounds <i>(12 Rounds is recommended)</i></label> 
			<input name="bcrypt_rounds" id="test" type="text" value="<?php echo $bcrypt_rounds; ?>"   />
			
			<label>Allow Remember me feature on login?</label>
			<select name="remember_me">
				<option value="false"<?php if($remember_me == 'false') { echo ' selected="selected"'; } ?>>False</option> <!-- First so that True is default -->
				<option value="true"<?php if($remember_me == 'true') { echo ' selected="selected"'; } ?>>True</option>
				
			</select>
			
			<label>Require Captcha on registration</label>
			<select name="captcha">
				<option value="false"<?php if($captcha == 'false') { echo ' selected="selected"'; } ?>>False</option> <!-- First so that True is default -->
				<option value="true"<?php if($captcha == 'true') { echo ' selected="selected"'; } ?>>True</option>
			</select>
		</fieldset>

		<fieldset>
			<legend>E-Mail</legend>
			
			<label>Master E-Mail (E-Mail used to contact users)</label>
			<input name="email_master" type="text" value="<?php echo $email_master; ?>"  />
			
			<label>Email Template</label>
			<select name="email_template">
				<?php
foreach($templates as $template) {
	if(strtolower($email_template) == strtolower($template)) {
		$templateSelected = ' selected="selected"';
	} else {
		$templateSelected = null;
	}
	echo '				<option value="' . $template . '"' . $templateSelected . '>' . $template . '</option>';
}
				?>
			</select>

			<label>Send a welcome E-Mail on registration?</label>
			<select name="email_welcome">
				<option value="true"<?php if($email_welcome == 'true') { echo ' selected="selected"'; }?>>True</option>
				<option value="false"<?php if($email_welcome == 'false') { echo ' selected="selected"'; }?>>False</option>
			</select>
			
			<label>Requre E-mail verification on registration?</label>
			<select name="email_verification">
				<option value="true"<?php if($email_verification == 'true') { echo ' selected="selected"'; }?>>True</option>
				<option value="false"<?php if($email_verification == 'false') { echo ' selected="selected"'; }?>>False</option>
			</select>
		</fieldset>

		<input name="setup" type="submit" value="Setup" />
	</form>
<?php
} else {
	if(isset($finishing_up)) {
		echo $finishing_up;
	}
}
?>
</div>
</body>
</html>