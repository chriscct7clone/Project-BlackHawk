<?php
 /**
  * This is the short description for a DocBlock.
  *
  * This is the long description for a DocBlock. This text may contain
  * multiple lines and even some _markdown_.
  *
  * * Markdown style lists function too
  * * Just try this out once
  *
  * The section after the long description contains the tags; which provide
  * structured meta-data concerning the given element.
  *
  * @author  Chris Christoff <chris@futuregencode.com.com>
  *
  * @since 0.2
  * @package BlackHawk
  * @param int    $example  This is an example function/method parameter description.
  * @param string $example2 This is a second example.
  */
class captcha {
/**
 * Creates a Captcha image
 *
 * @param  integer    $width  Dimension param
 * @param  integer    $width  Dimension param
 * @param  integer    $width  Dimension param
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
