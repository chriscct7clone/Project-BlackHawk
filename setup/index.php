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
	
	// User Area of Form
	// Get User Email
	$first_user_email		= $_POST['first_user_email'];

	
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
	$bcrypt_rounds=intval($bcrypt_rounds);
	if(empty($bcrypt_rounds)) {
		$bcrypt_rounds = 12;
	}
	if($bcrypt_rounds<9 && $bcrypt_rounds>0) {
		$bcrypt_rounds = '"0".$bcrypt_rounds';
	}
	if($bcrypt_rounds<1) {
		$bcrypt_rounds = 12;
	}
	if($bcrypt_rounds>100) {
	$notice->add('info', 'Bcrypt rounds is over the 99 limit. Installed using Bcrypt Rounds=99.');
		$bcrypt_rounds = 99;
	}
	if(empty($email_master)) {
		$notice->add('error', 'Please enter a E-Mail that will be used to contact users.');
		$email_master = null;
	}
	
			/* Check Admin E-Mail */
			if(!empty($first_user_email)) {
				$check_email = strtolower($first_user_email);
				// TODO php explode to make sure its valid	
					/* Is the E-Mail really an E-Mail? */
					if(filter_var($check_email, FILTER_VALIDATE_EMAIL) == true) {
						// we are good
					} else {
						$notice->add('error', 'Invalid E-Mail');
						$first_user_email = null;
					}
			} else {
			$notice->add('error', 'Please enter an email to use as the email for the Admin account');
			$first_user_email = null;
			}
	if($hostname=='localhost' && (($email_verification==true)|| ($email_welcome == true))){
	$notice->add('notice', 'Install Error #9. See User Manual for details'); 
	//$email_verification=false;
	//$email_welcome=false;
	
	/*
	I want to figure out a better way describing this error. I think the best way is actually to return a direct link to a 
	anchor tab in our documentation about this. Seems easy enough to do. However it can't be done till we set that up.
	The actual issue is that on localhost servers, PHP's mail() function is disabled, meaning we can't send the emails. When
	the mail() function is called on localhost, PHP throws a fatal error, thus preventing BlackHawk from working.
	I'll work on this TODO later
	-Chris
	*/
	}
	else {
	// do nothing
	}
	
	
	
	if($notice->errorsExist() == false) {
		$showForm = false;

		$installURL = dirname($_SERVER['SCRIPT_NAME']);
		$save= $installURL;
		$str = str_replace( '/setup', '', $save ); //remove /setup/
		$installURL= $str ;
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
  `parkingrole` int(11) NOT NULL,
  `userrole` int(11) NOT NULL,
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

//time in next one is time of last update to totals
$mysql_garage_list = 'CREATE TABLE IF NOT EXISTS `garage_list` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `numoftotalspots` int(8) NOT NULL,
  `numspotsinuse` int(8) NOT NULL,
  `percentageofuse` int(3) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';
//time in next one is time of first parking
$mysql_garage_by_uid = 'CREATE TABLE IF NOT EXISTS `garage_by_uid` (
  `uid` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `garage` int(8) NOT NULL,
  `floor` int(8) NOT NULL,
  `spot` int(8) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';
$mysql_statistics = 'CREATE TABLE IF NOT EXISTS `garage_by_uid` (
  `uid` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `garage` int(8) NOT NULL,
  `floor` int(8) NOT NULL,
  `spot` int(8) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';

//TODO: add all codes here
	$fp = fopen("../.htaccess", "a");
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
	fwrite($fp, "ErrorDocument 415 ". $installURL."/errorcode.php?error=414 \n");
	fwrite($fp, "ErrorDocument 416 ". $installURL."/errorcode.php?error=416 \n");
	fwrite($fp, "ErrorDocument 417 ". $installURL."/errorcode.php?error=417 \n");
	fwrite($fp, "ErrorDocument 418 ". $installURL."/errorcode.php?error=418 \n");
	fwrite($fp, "ErrorDocument 420 ". $installURL."/errorcode.php?error=420 \n");
	fwrite($fp, "ErrorDocument 422 ". $installURL."/errorcode.php?error=422 \n");
	fwrite($fp, "ErrorDocument 423 ". $installURL."/errorcode.php?error=423 \n");
	fwrite($fp, "ErrorDocument 424 ". $installURL."/errorcode.php?error=424 \n");
	fwrite($fp, "ErrorDocument 425 ". $installURL."/errorcode.php?error=425 \n");
	fwrite($fp, "ErrorDocument 426 ". $installURL."/errorcode.php?error=426 \n");
	fwrite($fp, "ErrorDocument 428 ". $installURL."/errorcode.php?error=428 \n");
	fwrite($fp, "ErrorDocument 429 ". $installURL."/errorcode.php?error=429 \n");
	fwrite($fp, "ErrorDocument 431 ". $installURL."/errorcode.php?error=431 \n");
	fwrite($fp, "ErrorDocument 444 ". $installURL."/errorcode.php?error=444 \n");
	fwrite($fp, "ErrorDocument 449 ". $installURL."/errorcode.php?error=449 \n");
	fwrite($fp, "ErrorDocument 450 ". $installURL."/errorcode.php?error=450 \n");
	fwrite($fp, "ErrorDocument 451 ". $installURL."/errorcode.php?error=451 \n");
	fwrite($fp, "ErrorDocument 494 ". $installURL."/errorcode.php?error=494 \n");
	fwrite($fp, "ErrorDocument 495 ". $installURL."/errorcode.php?error=495 \n");
	fwrite($fp, "ErrorDocument 496 ". $installURL."/errorcode.php?error=496 \n");
	fwrite($fp, "ErrorDocument 497 ". $installURL."/errorcode.php?error=497 \n");
	fwrite($fp, "ErrorDocument 499 ". $installURL."/errorcode.php?error=499 \n");
	fwrite($fp, "ErrorDocument 500 ". $installURL."/errorcode.php?error=500 \n");
	fwrite($fp, "ErrorDocument 501 ". $installURL."/errorcode.php?error=501 \n");
	fwrite($fp, "ErrorDocument 502 ". $installURL."/errorcode.php?error=502 \n");
	fwrite($fp, "ErrorDocument 503 ". $installURL."/errorcode.php?error=503 \n");
	fwrite($fp, "ErrorDocument 504 ". $installURL."/errorcode.php?error=504 \n");
	fwrite($fp, "ErrorDocument 505 ". $installURL."/errorcode.php?error=505 \n");
	fwrite($fp, "ErrorDocument 506 ". $installURL."/errorcode.php?error=506 \n");
	fwrite($fp, "ErrorDocument 507 ". $installURL."/errorcode.php?error=507 \n");
	fwrite($fp, "ErrorDocument 508 ". $installURL."/errorcode.php?error=508 \n");
	fwrite($fp, "ErrorDocument 509 ". $installURL."/errorcode.php?error=509 \n");
	fwrite($fp, "ErrorDocument 510 ". $installURL."/errorcode.php?error=510 \n");
	fwrite($fp, "ErrorDocument 511 ". $installURL."/errorcode.php?error=511 \n");
	fwrite($fp, "ErrorDocument 598 ". $installURL."/errorcode.php?error=598 \n");
	fwrite($fp, "ErrorDocument 599 ". $installURL."/errorcode.php?error=599 \n");
	fwrite($fp, "ErrorDocument 999 ". $installURL."/errorcode.php?error=999 \n");
	fclose($fp);
	@chmod("../.htaccess", 0644);	
		
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
		/* mysql_garage_by_uid */
		$statement = $pdo->prepare($mysql_garage_by_uid);
		if($statement->execute()){
			$notice->add('success', 'Table `garage_by_uid` populated!');
		} else {
			$notice->add('error', 'Could not populate garage_by_uid!');
		}		
		/* mysql_garage_list */
		$statement = $pdo->prepare($mysql_garage_list);
		if($statement->execute()){
			$notice->add('success', 'Table `garage_list` populated!');
		} else {
			$notice->add('error', 'Could not populate garage_list!');
		}		
		/* mysql_statistics */
		$statement = $pdo->prepare($mysql_statistics);
		if($statement->execute()){
			$notice->add('success', 'Table `statistics` populated!');
		} else {
			$notice->add('error', 'Could not populate statistics!');
		}	
		
		
		require_once("../assets/member.inc.php");
		// Fire User Registration 
		if($member->firstuserregister($first_user_email) == true){
		$notice->add('success', 'Admin User was created!');
		}
		else {
		$notice->add('error', 'Admin User was not created!');
		}
		
		//Notify that everything is done
		// TODO: make sure htaccess exists
		//Ask to delete setup folder
		
		if($notice->errorsExist() == false) {
			$notice->add('success', 'BlackHawk has been installed!');
			$finishing_up = '<hr />For security reasons, we will now delete the /setup/ folder. <br /><hr />
<form action="index.php" method="post">
<input name="finish" type="submit" value="Delete Folder and Finish" />
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
	$email_welcome = true;
	$email_template = 'default';
	$email_verification = true;
	$showForm = true;

	$first_user_email= null;
}


if(isset($_POST['finish'])) {
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
				<option value="true"<?php if($remember_me == 'true') { echo ' selected="selected"'; } ?>>True</option>
				<option value="false"<?php if($remember_me == 'false') { echo ' selected="selected"'; } ?>>False</option>
			</select>
			
			<label>Require Captcha on login?</label>
			<select name="captcha">
				<option value="true"<?php if($captcha == 'true') { echo ' selected="selected"'; } ?>>True</option>
				<option value="false"<?php if($captcha == 'false') { echo ' selected="selected"'; } ?>>False</option> 
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

			<label>Send a welcome E-Mail?</label>
			<select name="email_welcome">
				<option value="true"<?php if($email_welcome == 'true') { echo ' selected="selected"'; }?>>True</option>
				<option value="false"<?php if($email_welcome == 'false') { echo ' selected="selected"'; }?>>False</option>
			</select>
			
			<label>Requre E-mail verification?</label>
			<select name="email_verification">
				<option value="true"<?php if($email_verification == 'true') { echo ' selected="selected"'; }?>>True</option>
				<option value="false"<?php if($email_verification == 'false') { echo ' selected="selected"'; }?>>False</option>
			</select>
		</fieldset>
		<fieldset>
			<legend>Admin User</legend>
			
			<label>Admin Email</label>
			<input name="first_user_email" type="text" value="<?php echo $first_user_email; ?>"  />
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
<?php 
// TODO: Add PHPVersion check
// TODO: Add bycrypt() check
// TODO: Add sessions check
// TODO: Add cookies check
// TODO: Add validate the admin emails
?>