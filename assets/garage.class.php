<?php

/**
  * @author My Name
  * @author My Name <my.name@example.com>
  */

class garage {
	// no other garage in use
	public function installgaragetable($name, $rolesallowed,$floors){
		/* Start an instance of the Database Class */
		$database = new database();
		//TODO: STRreplace name
		$namefordb=$name;
		
		// TODO: insert name into the garages_list
		
		// create garage table
		$mysql_garage = 'CREATE TABLE IF NOT EXISTS `$namefordb` (
							`floor` int(3) NOT NULL,
							`spot` int(3) NOT NULL,
							`status` int(3) NOT NULL,
							`uid` int(12) NULL,
							`type` int(3) NOT NULL,
							`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
							PRIMARY KEY (`floor`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;';
		}
		$statement = $pdo->prepare($mysql_garage);
			if($statement->execute()){
				$notice->add('success', $name.' was added!');
			} else {
				$notice->add('error',  $name.' was not added!');
			}

/* 
Intake Array format:

$floors = array(
    1 => array( // floor 0 is ground floor...not garage
			'num_spots' => 100, 
			'police' => array(15,16,17), //for ground level parking  
			'num_police' => 3,
			'teacher' => array (47,62), //for ground level parking  
			'num_teacher' => 2,
			'visitors' => array (47,62), //for ground level parking  
			'num_visitors' => 2,
			'handicap' => array(15,16,17),
			'num_handicap' => 3,
			'motorcycle' => array (47,62),
			'num_motorcycle' => 2
        ),   

    2 => array(
			'num_spots' => 100,
			'police' => array(15,16,17),  
			'num_police' => 3,
			'teacher' => array (47,62),
			'num_teacher' => 2,
			'visitors' => array (47,62),
			'num_visitors' => 2,
			'handicap' => array(15,16,17),
			'num_handicap' => 3,
			'motorcycle' => array (47,62),
			'num_motorcycle' => 2
        )
);

*/
$numfloors=$count($floors);

for ($a=0, $a>$numfloors,$a++){
$numspots=[$a]['num_spots'][0];
for ($b=0, $b>$numspots, $b++){
    $floor=$a;
	$spot=$b+1;
	$type=0; // Student
	// Check if in Police
	for ($x=0,$x>($floors[$a]['num_police']),$x++){
		if ($spot==$floors[$a]['police'][$x]){
			$type=1;
		}	
	}
	// Check if in teacher
	for ($x=0,$x>($floors[$a]['num_teacher']),$x++){
		if ($spot==$floors[$a]['teacher'][$x]){
			$type=2;
		}	
	}		
	// Check if in Handicap
	for ($x=0,$x>($floors[$a]['num_handicap']),$x++){
		if ($spot==$floors[$a]['handicap'][$x]){
			$type=3;
		}	
	}
	// Check if in motorcycle
	for ($x=0,$x>($floors[$a]['num_motorcycle']),$x++){
		if ($spot==$floors[$a]['motorcycle'][$x]){
			$type=4;
		}	
	}
	// TODO: Reserved spots. Type 5 and pass uid along for the ride.
	$date = date("Y-m-d", time());
	$uid=null; //no one's parked there
	$status=0; //open	
	$database->query('INSERT INTO $namefordb(floor, spot, status, uid, type, time) VALUES(:floor, :spot, :status, :uid, :type,:time)', array(':floor' => $floor, ':spot' => $spot,':status' => $status, ':uid' => $uid,':type' => $type,':time' => $time  ));
	}
	}
}
	public function addgarage($name, $rolesallowed, $floors) {
	
	
	installgaragetable($name, $rolesallowed,$floors); // Adds database
 	}
	public function editgarage($name) {
 	}
	public function removegarage($name) {
 	}
	public function listofgarages($name) {
 	}
}
?>