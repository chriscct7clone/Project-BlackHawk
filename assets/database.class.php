<?php
 /**
 * Implements Database Connections
 *
 * This file defines our PDO connections
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage Internal Functions
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @see        database.inc.php
 * @since      File available since Release 0.3.0
 */
 
 /**
 * Implements method to store, delete and edit database values via PDO
 *
 * @package    BlackHawk
 * @subpackage Internal Functions
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.0
 * @version    0.3.0
 * @since      File available since Release 0.3.0
 */ 
class database {
	/**
	 * @var $pdo A reference to the PDO instance;
	 * 	Also used for connecions via PDO.
	 */
	public $pdo = null;
	
	/**
	 * @var $statement Used to contain query for prepared statments;
	 * 	Also used for value binding & execution
	 */
	public $statement = null;
	
	/**
	 * Database Constructor
	 * 
	 * This method is used to create a new database object with a connection to a datbase
	 */
	public function __construct() {
		/* Try the connections */
		try {
			/* Create a connections with the supplied values */
			$this->pdo = new PDO("mysql:host=" . Config::read('hostname') . ";dbname=" . Config::read('database'), Config::read('username'), Config::read('password'), Config::read('drivers'));
		} catch(PDOException $e) {
			/* If any errors echo the out and kill the script */
			print "<b>[DATABASE] Error - Connection Failed:</b> " . $e->getMessage() . "<br/>";
			die();
		}
	}
	
	/**
	 * Database Query
	 * 
	 * This method is used to create a new database prepared query
	 * 
	 * @param string $query The prepared statement query to the database
	 * @param array|string $bind All the variables to bind to the prepared statement
	 * @param string $fetch fetch method
	 * @return return the executed string
	 */
	public function query($query, $bind = null, $fetch = 'FETCH_ASSOC') {
		/* Prepare the query statement */
		$this->statement = $this->pdo->prepare($query);
		/* Bind each value supplied from $bind */
		if($bind != null) {
			foreach($bind as $select => $value) {
				/* For each type of value give the appropriate param */
				if(is_int($value)) {
					$param = PDO::PARAM_INT; 
				} elseif(is_bool($value)) {
					$param = PDO::PARAM_BOOL;
				} elseif(is_null($value)) {
					$param = PDO::PARAM_NULL;
				} elseif(is_string($value)) {
					$param = PDO::PARAM_STR;
				} else {
					$param = FALSE;
				}
				/* Bid value */
				if($param) {
					$this->statement->bindValue($select, $value, $param);
				}
			}
		}
		/* Execute Query & check for any errors */
		if(!$this->statement->execute()){
			$result = array(
				1 => 'false',
				2 => '<b>[DATABASE] Error - Query:</b> There was an error in sql syntax',
			);
			return $result;
		}
		/* Return all content */
		if($fetch == 'FETCH_ASSOC') {
			$result = $this->statement->fetch(PDO::FETCH_ASSOC);
		} elseif($fetch == 'FETCH_BOTH') {
			$result = $this->statement->fetch(PDO::FETCH_BOTH);
		} elseif($fetch == 'FETCH_LAZY') {
			$result = $this->statement->fetch(PDO::FETCH_LAZY);
		} elseif($fetch == 'FETCH_OBJ') {
			$result = $this->statement->fetch(PDO::FETCH_OBJ);
		} elseif($fetch == 'fetchAll') {
			$result = $this->statement->fetchAll();
		}
		return $result;
	}
}
?>