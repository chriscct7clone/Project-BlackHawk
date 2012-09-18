<?php
/*
 * Garage Class
 */
class Config {
	// no other garage in use
	public function installgaragetable($name, $rolesallowed, ){
		require_once('config.inc.php');
		require_once("database.class.php");
		/* Start an instance of the Database Class */
		$database = new database();
		//TODO: STRreplace name
		$namefordb=$name;
		// insert name into the garages_list
		
		
		$mysql_garage_list = 'CREATE TABLE IF NOT EXISTS `$namefordb` (
							`floor` int(3) NOT NULL,
							`spot` int(3) NOT NULL,
							`status` int(3) NOT NULL,
							`uid` int(12) NULL,
							`type` int(3) NOT NULL,
							`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
							PRIMARY KEY (`floor`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';
		}
	$statement = $pdo->prepare($mysql_garage_list);
		if($statement->execute()){
			$notice->add('success', $name.' added!');
		} else {
			$notice->add('error',  $name.' not added!');
		}
	$date = date("Y-m-d", time());
	// Loop for each spot
	$uid=null; //no one's parked there
	$status=0; //open
	$database->query('INSERT INTO $namefordb(floor, spot, status, uid, type, time) VALUES(:floor, :spot, :status, :uid, :type,:time)', array(':floor' => $floor, ':spot' => $spot,':status' => $status, ':uid' => $uid,':type' => $type,':time' => $time  ));
	public function addgarage($name) {
	
 	}
	public function editgarage($name) {
 	}
	public function removegarage($name) {
 	}
	public function listofgarages($name) {
 	}
}
?>