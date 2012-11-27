<?php
/*
 * Config Include
 * 
 * Blackhawk 
 */

/*
 * Get the Config class
 */
require_once('config.class.php');

/*
 * Write settings to the config
 */
Config::write('hostname', 'localhost');
Config::write('database', 'blackhawk');
Config::write('username', 'root');
Config::write('password', '');
Config::write('drivers', array(PDO::ATTR_PERSISTENT => true));
Config::write('hash', 'bcrypt'); /* Once set DO NOT CHANGE (sha512/bcrypt) */
Config::write('bcryptRounds', '12');
Config::write('remember', false);
Config::write('email_template', 'Default');
Config::write('email_master', 'chriscct7@gmail.com');
Config::write('email_welcome', false);
Config::write('email_verification', false);
Config::write('blackhawkconfig', 'standard');
Config::write('blackhawkversion', '0.2.0.1.42');
?>