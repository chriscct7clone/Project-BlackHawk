<?php
 /**
 * Creates Garage Class
 *
 * This file creates functions used internally for garages
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage Garage
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @see        garage.inc.php
 * @since      File available since Release 0.3.0
 *
 * @todo TODO List for file
 *     <ol>
 *       <li>Finish Documentation</li>
 *         <ol>
 *           <li>File Comments</li>
 *           <li>Class Comments</li>
 *           <li>Function Comments</li>
 *         </ol>
 *       <li>Garage Functions</li>
 *         <ol>
 *           <li>Add Garage</li>
 *           <li>Edit Garage</li>
 *           <li>Remove Garage</li>
 *         </ol>
 *       <li>External Todo</li>
 *         <ol>
 *           <li>Form for garages</li>
 *           <li>Find my car</li>
 *           <li>Statistics</li>
 *         </ol>
 *     </ol>
 */

 
 /**
 * Implements garages
 *
 * @package    BlackHawk
 * @subpackage Garage
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.0
 * @version    0.3.0
 * @since      File available since Release 0.3.0
 */

class garage {
	// no other garage in use
	
	public function installgaragetable($name, $floors){
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
		
		$statement = $pdo->prepare($mysql_garage);
			if($statement->execute()){
				$notice->add('success', $name.' was added!');
			} else {
				$notice->add('error',  $name.' was not added!');
			}
			}
	public function addspotsviacsv($spot){
		require_once('../csv.php');
		$lines = new CsvReader(dirname(__FILE__).'/../tests/data/one-line.csv');
foreach ($lines as $line_number => $values) {
	echo '<td>'.$line_number.'</td>';
	foreach ($values as $value) {
	}
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
	public function addgarage($name) {
 	}
	public function editgarage($name) {
 	}
	public function removegarage($name) {
 	}
	public function listofgarages($name) {
 	}
	public function garagestats($name) {
 	}
	public function findmycar($name) {
 	}
	}
?>