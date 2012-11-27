<?php
 /**
 * Creates Mail Class
 *
 * This file creates functions used internally for garages
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage Mail
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @see        garage.inc.php
 * @since      File available since Release 0.3.0
 */

 
 /**
 * Implements emails
 *
 * @package    BlackHawk
 * @subpackage Mail
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.0
 * @version    0.3.0
 * @since      File available since Release 0.3.0
 */
class mailer {
	/**
	 * @var $email_master
	 *
	 * The Master E-Mail
	 */
	public $email_master;
	/**
	 * @var $template
	 *
	 * Stores template choice
	 */
	public $template;
	
	/**
	 * __construct
	 *
	 * Sets template
	 * 
	 * @param string $email_master Which email to send from
	 * @param string $template Which template to use
	 */
	public function __construct($email_master, $template = 'default') {
		$this->email_master = $email_master;
		$this->template = $template;
	}
	
	/**
	 * genTemplate
	 *
	 * Parsers the template
	 * 
	 * @param string $subject Subject of the email
	 * @param string $content Content of the email
	 */
	public function genTemplate($subject, $content) {
		$search = array(
			'subject' => '{{subject}}',
			'content' => '{{content}}'
		);
		$template = array(
			'subject' => $subject,
			'content' => $content
		);
		/* Set Template Path */
		$template_path = 'assets/email_templates/' . $this->template . '.html';
		/* E-Mail body */
		if(file_exists($template_path)) {
			$body = file_get_contents($template_path);
			$body = str_replace($search, $template, $body);
		} else {
			$body = $template['subject'] . '<hr />' . $template['content'];
		}
		return $body;
	}
	
	/**
	 * mail
	 *
	 * Mails inputed data
	 * 
	 * @param string $emailmaster The email address to send from
	 * @param string $email The email reciver
	 * @param string $subject Subject of the email
	 * @param string $content Content of the email
	 * @return email $email Sends email
	 */
	public function mail($email, $subject, $content) {
		if(function_exists('mail')) {
			/* Headers */
			$headers = "From: " . strip_tags($this->email_master) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($this->email_master) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			/* Send it */
			if(mail($email, $subject, $this->genTemplate($subject, $content), $headers)) {
				return true;
			} else {
				return false;
			}
		} else {
			return 'PHP Mail() function is not enabled!';
		}
	}
}
?>