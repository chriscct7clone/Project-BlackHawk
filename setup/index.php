<?php
require_once("../init.php");
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

Config::write(\'blackhawkconfig\', \'' . BLACKHAWK_CONFIG . '\');
Config::write(\'blackhawkversion\', \'' . BLACKHAWK_VERSION .'.'.BLACKHAWK_SUBVERSION . '.' . BLACKHAWK_COMMIT . '\');
?>';
			fwrite($config_handle, $config_data);
			$notice->add('success', 'Config file created');
		} else {
			$notice->add('error', 'Could not create config file!<br />Check your folder permissions.');
		}

$mysql_users = 'CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `garage_role` int(11) NOT NULL,
  `user_role` int(11) NOT NULL,
  `parked_status` int(11) NOT NULL,
  `parked_location` varchar(255) NOT NULL,
  `profile_colors` varchar(255) NOT NULL,
  `profile_fixed` int(11) NOT NULL,
  `profile_image` int(11) NOT NULL,
  `profile_fav_garages` varchar(255) NOT NULL, 
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;';

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

$mysql_statistics = 'CREATE TABLE IF NOT EXISTS `garage_statistics` (
  `uid` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `garage` int(8) NOT NULL,
  `floor` int(8) NOT NULL,
  `spot` int(8) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';
$mysql_garage_roles = 'CREATE TABLE IF NOT EXISTS `garage_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,	
  `name` varchar(225) NOT NULL,
  `students_campus` int(11) NOT NULL,
  `students_offcampus` int(11) NOT NULL,  
  `vistor` int(11) NOT NULL,  
  `staff` int(11) NOT NULL,  
  `reserved` int(11) NOT NULL,  
  `police` int(11) NOT NULL,  
  `admin` int(11) NOT NULL,  
  `handicap` int(11) NOT NULL,  
  `motorcycle` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';

$mysql_user_roles = 'CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,	
  `name` varchar(225) NOT NULL,
  `add_users` int(11) NOT NULL,
  `edit_users` int(11) NOT NULL,
  `delete_users` int(11) NOT NULL,  
  `import_users` int(11) NOT NULL,   
  `export_users` int(11) NOT NULL,  
  `add_garages` int(11) NOT NULL,
  `edit_garages` int(11) NOT NULL,
  `delete_garages` int(11) NOT NULL,  
  `import_garages` int(11) NOT NULL,   
  `export_garages` int(11) NOT NULL, 
  `edit_garage_status` int(11) NOT NULL, 
  `add_tickets` int(11) NOT NULL,  
  `edit_tickets` int(11) NOT NULL,  
  `delete_tickets` int(11) NOT NULL,  
  `pay_tickets` int(11) NOT NULL, 
  `manage_system` int(11) NOT NULL, 
  `adv_statistics` int(11) NOT NULL,  
  `user_profile` int(11) NOT NULL,  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';

if($htaccess_handle = fopen('../.htaccess', 'a')) {
$htaccess_data = '
# ErrorDocuments
ErrorDocument 400 '. $installURL.'/errorcode.php?error=400
ErrorDocument 401 '. $installURL.'/errorcode.php?error=401
ErrorDocument 402 '. $installURL.'/errorcode.php?error=402
ErrorDocument 403 '. $installURL.'/errorcode.php?error=403
ErrorDocument 404 '. $installURL.'/errorcode.php?error=404
ErrorDocument 405 '. $installURL.'/errorcode.php?error=405
ErrorDocument 406 '. $installURL.'/errorcode.php?error=406
ErrorDocument 407 '. $installURL.'/errorcode.php?error=407
ErrorDocument 408 '. $installURL.'/errorcode.php?error=408
ErrorDocument 409 '. $installURL.'/errorcode.php?error=409
ErrorDocument 410 '. $installURL.'/errorcode.php?error=410
ErrorDocument 411 '. $installURL.'/errorcode.php?error=411
ErrorDocument 412 '. $installURL.'/errorcode.php?error=412
ErrorDocument 413 '. $installURL.'/errorcode.php?error=413
ErrorDocument 414 '. $installURL.'/errorcode.php?error=414
ErrorDocument 415 '. $installURL.'/errorcode.php?error=414
ErrorDocument 416 '. $installURL.'/errorcode.php?error=416
ErrorDocument 417 '. $installURL.'/errorcode.php?error=417
ErrorDocument 418 '. $installURL.'/errorcode.php?error=418
ErrorDocument 420 '. $installURL.'/errorcode.php?error=420
ErrorDocument 422 '. $installURL.'/errorcode.php?error=422
ErrorDocument 423 '. $installURL.'/errorcode.php?error=423
ErrorDocument 424 '. $installURL.'/errorcode.php?error=424
ErrorDocument 425 '. $installURL.'/errorcode.php?error=425
ErrorDocument 426 '. $installURL.'/errorcode.php?error=426
ErrorDocument 500 '. $installURL.'/errorcode.php?error=500
ErrorDocument 501 '. $installURL.'/errorcode.php?error=501
ErrorDocument 502 '. $installURL.'/errorcode.php?error=502
ErrorDocument 503 '. $installURL.'/errorcode.php?error=503
ErrorDocument 504 '. $installURL.'/errorcode.php?error=504
ErrorDocument 505 '. $installURL.'/errorcode.php?error=505
ErrorDocument 506 '. $installURL.'/errorcode.php?error=506
ErrorDocument 507 '. $installURL.'/errorcode.php?error=507
ErrorDocument 508 '. $installURL.'/errorcode.php?error=508
ErrorDocument 509 '. $installURL.'/errorcode.php?error=509
ErrorDocument 510 '. $installURL.'/errorcode.php?error=510
';
	fwrite($htaccess_handle, $htaccess_data);
	$notice->add('success', 'htaccess file created');
	} 
	else {
	$notice->add('error', 'Could not create htaccess file!<br />Check your folder permissions.');
	}
	
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
		/* mysql_garage_roles */
		$statement = $pdo->prepare($mysql_garage_roles);
		if($statement->execute()){
			$notice->add('success', 'Table `garage_roles` populated!');
		} else {
			$notice->add('error', 'Could not populate garage_roles!');
		}
		/* mysql_user_roles */
		$statement = $pdo->prepare($mysql_user_roles);
		if($statement->execute()){
			$notice->add('success', 'Table `user_roles` populated!');
		} else {
			$notice->add('error', 'Could not populate user_roles!');
		}
		/* mysql_garage_statistics */
		// logs statistics, but we also use this to keep our garage config data
		$statement = $pdo->prepare($mysql_statistics);
		if($statement->execute()){
			$notice->add('success', 'Table `garage_statistics` populated!');
		} else {
			$notice->add('error', 'Could not populate garage_statistics!');
		}		
		/* Insert Default Garage Roles */
		// Insert Before 1st user, so we can assign him to a role
		// Police: All Access on Parking, Second Tertiary on User Role
		$garage_role_1="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Police', '1', '1', '1', '1', '1', '1', '1', '1', '1');";
		$statement = $pdo->prepare($garage_role_1);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Police` added!');
		} else {
			$notice->add('error', 'Could not add `Police` garage role!');
		}
		// Admin: Standard
		$garage_role_2="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Admin: Standard', '1', '1', '1', '1', '1', '0', '1', '0', '0');";
		$statement = $pdo->prepare($garage_role_2);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Admin: Standard` added!');
		} else {
			$notice->add('error', 'Could not add `Admin: Standard` garage role!');
		}
		// Admin: Motorcyle
		$garage_role_3="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Admin: Motorcyle', '1', '1', '1', '1', '1', '0', '1', '0', '1');";
		$statement = $pdo->prepare($garage_role_3);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Admin: Motorcyle` added!');
		} else {
			$notice->add('error', 'Could not add `Admin: Motorcyle` garage role!');
		}
		// Admin: Handicap
		$garage_role_4="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Admin: Handicap', '1', '1', '1', '1', '1', '0', '1', '1', '0');";
		$statement = $pdo->prepare($garage_role_4);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Admin: Handicap` added!');
		} else {
			$notice->add('error', 'Could not add `Admin: Handicap` garage role!');
		}
		// Staff: Standard (includes Parking Services staff and Computing Services)
		$garage_role_5="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Staff: Standard', '1', '1', '1', '1', '1', '0', '0', '0', '0');";
		$statement = $pdo->prepare($garage_role_5);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Staff: Standard` added!');
		} else {
			$notice->add('error', 'Could not add `Staff: Standard` garage role!');
		}
		// Staff: Motorcyle
		$garage_role_6="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Staff: Motorcyle', '1', '1', '1', '1', '1', '0', '0', '0', '1');";
		$statement = $pdo->prepare($garage_role_6);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Staff: Motorcyle` added!');
		} else {
			$notice->add('error', 'Could not add `Staff: Motorcyle` garage role!');
		}
		// Staff: Handicap
		$garage_role_7="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Staff: Handicap', '1', '1', '1', '1', '1', '0', '0', '1', '0');";
		$statement = $pdo->prepare($garage_role_7);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Staff: Handicap` added!');
		} else {
			$notice->add('error', 'Could not add `Staff: Handicap`  garage role!');
		}
		// Student (Off Campus): Standard
		$garage_role_8="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Student (Off Campus): Standard', '0', '1', '0', '0', '0', '0', '0', '0', '0');";
		$statement = $pdo->prepare($garage_role_8);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Student (Off Campus): Standard` added!');
		} else {
			$notice->add('error', 'Could not add `Student (Off Campus): Standard`  garage role!');
		}
		// Student (Off Campus): Motorcyle
		$garage_role_9="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Student (Off Campus): Motorcyle', '0', '1', '0', '0', '0', '0', '0', '0', '1');";
		$statement = $pdo->prepare($garage_role_9);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Student (Off Campus): Motorcyle` added!');
		} else {
			$notice->add('error', 'Could not add `Student (Off Campus): Motorcyle`  garage role!');
		}
		// Student (Off Campus): Handicap
		$garage_role_10="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Student (Off Campus): Handicap', '0', '1', '0', '0', '0', '0', '0', '1', '0');";
		$statement = $pdo->prepare($garage_role_10);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Student (Off Campus): Handicap` added!');
		} else {
			$notice->add('error', 'Could not add `Student (Off Campus): Handicap` garage role!');
		}
		// Student (On Campus): Standard
		$garage_role_11="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Student (On Campus): Standard', '1', '0', '0', '0', '0', '0', '0', '0', '0');";
		$statement = $pdo->prepare($garage_role_11);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Student (On Campus): Standard` added!');
		} else {
			$notice->add('error', 'Could not add `Student (On Campus): Standard` garage role!');
		}
		// Student (On Campus): Motorcyle
		$garage_role_12="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Student (On Campus): Motorcyle', '1', '0', '0', '0', '0', '0', '0', '0', '1');";
		$statement = $pdo->prepare($garage_role_12);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Student (On Campus): Motorcyle` added!');
		} else {
			$notice->add('error', 'Could not add `Student (On Campus): Motorcyle`  garage role!');
		}
		// Student (On Campus): Handicap
		$garage_role_13="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Student (On Campus): Handicap', '1', '0', '0', '0', '0', '0', '0', '1', '0');";
		$statement = $pdo->prepare($garage_role_13);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Student (On Campus): Handicap` added!');
		} else {
			$notice->add('error', 'Could not add `Student (On Campus): Handicap`  garage role!');
		}
		// Alumni: Standard
		$garage_role_14="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Alumni: Standard', '1', '1', '1', '0', '0', '0', '0', '0', '0');";
		$statement = $pdo->prepare($garage_role_14);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Alumni: Standard` added!');
		} else {
			$notice->add('error', 'Could not add `Alumni: Standard`  garage role!');
		}
		// Alumni: Motorcycle
		$garage_role_15="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Alumni: Motorcycle', '1', '1', '1', '0', '0', '0', '0', '0', '1');";
		$statement = $pdo->prepare($garage_role_15);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Alumni: Motorcycle` added!');
		} else {
			$notice->add('error', 'Could not add `Alumni: Motorcycle`  garage role!');
		}
		// Alumni: Handicap
		$garage_role_16="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Alumni: Handicap', '1', '1', '1', '0', '0', '0', '0', '1', '0');";
		$statement = $pdo->prepare($garage_role_16);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Alumni: Handicap` added!');
		} else {
			$notice->add('error', 'Could not add `Alumni: Handicap`  garage role!');
		}	
		// Visitor: Standard
		$garage_role_17="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Visitor: Standard', '0', '0', '1', '0', '0', '0', '0', '0', '0');";
		$statement = $pdo->prepare($garage_role_17);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Visitor: Standard` added!');
		} else {
			$notice->add('error', 'Could not add `Visitor: Standard` garage role!');
		}		
		// Visitor: Motorcycle
		$garage_role_18="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Visitor: Motorcycle', '0', '0', '1', '0', '0', '0', '0', '0', '1');";
		$statement = $pdo->prepare($garage_role_18);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Visitor: Motorcycle` added!');
		} else {
			$notice->add('error', 'Could not add `Visitor: Motorcycle` garage role!');
		}
		// Visitor: Handicap
		$garage_role_19="INSERT INTO `garage_roles` (`id`, `name`, `students_campus`, `students_offcampus`, `vistor`, `staff`, `reserved`, `police`, `admin`, `handicap`, `motorcycle`) VALUES (NULL, 'Visitor: Handicap', '0', '0', '1', '0', '0', '0', '0', '1', '0');";
		$statement = $pdo->prepare($garage_role_19);
		if($statement->execute()){
			$notice->add('success', 'Garage Role `Visitor: Handicap` added!');
		} else {
			$notice->add('error', 'Could not add `Visitor: Handicap` garage role!');
		}
		$countofroles = "SELECT count(*) FROM `garage_roles` WHERE id"; 
		$statement = $pdo->prepare($countofroles);
		if($statement->execute() == 19){
			$notice->add('success', 'All Roles Created!');
		} else {
			$notice->add('error', 'Role Creation Failed. Made'. $countofroles .' roles');
		}
		
		
		// Create Default User Roles
		// Total Access: Not Used By FGCU
		$user_role_1="INSERT INTO `user_roles` (`id`, `name`, `add_users`,`edit_users`,`delete_users`, `import_users`,`export_users`,`add_garages`,`edit_garages`,`delete_garages`, `import_garages`,`export_garages`,`edit_garage_status`, `add_tickets`,`edit_tickets`,`delete_tickets`, `pay_tickets`, `manage_system`, `adv_statistics`, `user_profile`) VALUES (NULL, 'Total Access', '1', '1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1');";
		$statement = $pdo->prepare($user_role_1);
		if($statement->execute()){
			$notice->add('success', 'User Role `Total Access` added!');
		} else {
			$notice->add('error', 'Could not add `Total Access` role!');
		}
		// Computing Services
		$user_role_2="INSERT INTO `user_roles` (`id`,`name`, `add_users`,`edit_users`,`delete_users`, `import_users`,`export_users`,`add_garages`,`edit_garages`,`delete_garages`, `import_garages`,`export_garages`,`edit_garage_status`, `add_tickets`,`edit_tickets`,`delete_tickets`, `pay_tickets`, `manage_system`, `adv_statistics`, `user_profile`) VALUES (NULL, 'Computing Services', '1', '1','1','1','1','1','1','1','1','1','1','0','0','0','0','1','1','1');";
		$statement = $pdo->prepare($user_role_2);
		if($statement->execute()){
			$notice->add('success', 'User Role `Computing Services` added!');
		} else {
			$notice->add('error', 'Could not add `Computing Services` role!');
		}
		// Police
		$user_role_3="INSERT INTO `user_roles` (`id`,`name`, `add_users`,`edit_users`,`delete_users`, `import_users`,`export_users`,`add_garages`,`edit_garages`,`delete_garages`, `import_garages`,`export_garages`,`edit_garage_status`, `add_tickets`,`edit_tickets`,`delete_tickets`, `pay_tickets`, `manage_system`, `adv_statistics`, `user_profile`) VALUES (NULL, 'Police', '0', '1','0','0','0','0','0','0','0','0','1','1','1','1','1','0','1','0');";
		$statement = $pdo->prepare($user_role_3);
		if($statement->execute()){
			$notice->add('success', 'User Role `Police` added!');
		} else {
			$notice->add('error', 'Could not add `Police` role!');
		}
		// Parking Services
		$user_role_4="INSERT INTO `user_roles` (`id`,`name`, `add_users`,`edit_users`,`delete_users`, `import_users`,`export_users`,`add_garages`,`edit_garages`,`delete_garages`, `import_garages`,`export_garages`,`edit_garage_status`, `add_tickets`,`edit_tickets`,`delete_tickets`, `pay_tickets`, `manage_system`, `adv_statistics`, `user_profile`) VALUES (NULL, 'Computing Services', '1', '1','1','1','1','1','1','1','1','1','0','0','0','0','0','0','0','0');";
		$statement = $pdo->prepare($user_role_4);
		if($statement->execute()){
			$notice->add('success', 'User Role `Parking Services` added!');
		} else {
			$notice->add('error', 'Could not add `Parking Services` role!');
		}
		// General
		$user_role_5="INSERT INTO `user_roles` (`id`,`name`, `add_users`,`edit_users`,`delete_users`, `import_users`,`export_users`,`add_garages`,`edit_garages`,`delete_garages`, `import_garages`,`export_garages`,`edit_garage_status`, `add_tickets`,`edit_tickets`,`delete_tickets`, `pay_tickets`, `manage_system`, `adv_statistics`, `user_profile`) VALUES (NULL, 'General', '0', '0','0','0','0','0','0','0','0','0','0','0','0','0','1','0','0','1');";
		$statement = $pdo->prepare($user_role_5);
		if($statement->execute()){
			$notice->add('success', 'User Role `General` added!');
		} else {
			$notice->add('error', 'Could not add `General` role!');
		}
		// Public
		$user_role_6="INSERT INTO `user_roles` (`id`,`name`, `add_users`,`edit_users`,`delete_users`, `import_users`,`export_users`,`add_garages`,`edit_garages`,`delete_garages`, `import_garages`,`export_garages`,`edit_garage_status`, `add_tickets`,`edit_tickets`,`delete_tickets`, `pay_tickets`, `manage_system`, `adv_statistics`, `user_profile`) VALUES (NULL, 'Public', '0', '0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');";
		$statement = $pdo->prepare($user_role_6);
		if($statement->execute()){
			$notice->add('success', 'User Role `Public` added!');
		} else {
			$notice->add('error', 'Could not add `Public` role!');
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
		rrmdir('../documentation');
		$notice->add('success', 'Documentation folder removed');
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