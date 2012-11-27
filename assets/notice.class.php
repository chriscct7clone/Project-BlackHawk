<?php
 /**
 * Creates Notice Class
 *
 * This file creates the notice outputs
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage Notice
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @since      File available since Release 0.3.0
 *
 */

 
 /**
 * Implements Notice
 *
 * @package    BlackHawk
 * @subpackage Notice
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.0
 * @version    0.3.0
 * @since      File available since Release 0.3.0
 */
class notice {
	/**
	 * @var $_notices
	 *
	 * Used to store all the notices
	 */
	private $_notices = array();
	
	/** 
	 * Add Notice
	 *
	 * Adds a notice to the notice array
	 *
	 * @param $type Type of notice (info, error, success)
	 * @param $message The notice message
	 */
	public function add($type, $message) {
		$this->_notice[$type][] = $message;
	}
	
	/** 
	 * Report
	 * 
	 * Reports all notices (info, error, success)
	 */
	public function report() {
		$data = '';
		/* Report any Info */
		if(isset($this->_notice['info'])) {
			foreach($this->_notice['info'] as $message) {
				$data .= '<div class="notice info">' . $message . '</div>';
			}
		}
		/* Report any Errors */
		if(isset($this->_notice['error'])) {
			foreach($this->_notice['error'] as $message) {
				$data .= '<div class="notice error">' . $message . '</div>';
			}
		}
		/* Report any Success */
		if(isset($this->_notice['success'])) {
			foreach($this->_notice['success'] as $message) {
				$data .= '<div class="notice success">' . $message . '</div>';
			}
		}
		/* Return data */
		if(isset($data)) {
			return $data;
		}
	
	}
	
	/** 
	 * errorsExist
	 * 
	 * @return bool True if errors exist, false if no errors
	 */
	public function errorsExist() {
		if(empty($this->_notice['error'])) {
			return false;
		} else {
			return true;
		}
	}
}
?>