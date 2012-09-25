<?php
 /**
 * Creates Captcha Image
 *
 * This file creates the image for the captcha, as long as Captcha has been turned on during setup.
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/PackageName
 * @see        member()
 * @since      File available since Release 0.3.0
 */

 
 /**
 * Implements the captcha class
 *
 * @package    BlackHawk
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/PackageName
 * @see        member()
 * @since      File available since Release 0.3.0
 */
class captcha {
/**
 * Creates a Captcha image
 *
 * @param  integer    $width  Dimension param
 * @param  integer    $height  Dimension param
 * @param  string    $text string to make
 * @return image
 */ 
	public function display($width, $height, $text) {
			require_once("garage.php");
		/* Create Image */
		$image = imagecreate($width, $height);
		/* Set Background */
		$bg    = imagecolorallocate($image, 255, 255, 255);
		/* Set Text Color */
		$color  = imagecolorallocate($image, 0, 0, 0);
		/* Patch together Image */
		/* First character */
		$r = rand(-25, 25);
		imagettftext($image, 26, $r, 10, 33, $color, "fonts/arial.ttf", substr($text, 0, 1));
		/* Each character after that */
		for($i = 0; $i <= strlen($text); $i++) {
			$part = substr($text, $i + 1, 1);
			$r    = rand(-25, 25);
			$x    = 36 + (26 * $i);
			imagettftext($image, 26, $r, $x, 37, $color, "fonts/arial.ttf", $part);
			
		}
		
		/* Output the image */
		header('Content-type: image/png');
		
		imagepng($image);
		imagedestroy($image);
	}
}

$captcha = new captcha();
session_start();
echo $captcha->display("170", "50", $_SESSION['captcha']);
?>
