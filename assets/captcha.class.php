<?php
 /**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Original Author <author@example.com>
 * @author     Another Author <another@example.com>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      File available since Release 1.2.0
 * @deprecated File deprecated in Release 2.0.0
 */

 
 /**
 * An example of how to write code to PEAR's standards
 *
 * Docblock comments start with "/**" at the top.  Notice how the "/"
 * lines up with the normal indenting and the asterisks on subsequent rows
 * are in line with the first asterisk.  The last line of comment text
 * should be immediately followed on the next line by the closing asterisk
 * and slash and then the item you are commenting on should be on the next
 * line below that.  Don't add extra lines.  Please put a blank line
 * between paragraphs as well as between the end of the description and
 * the start of the @tags.  Wrap comments before 80 columns in order to
 * ease readability for a wide variety of users.
 *
 * Docblocks can only be used for programming constructs which allow them
 * (classes, properties, methods, defines, includes, globals).  See the
 * phpDocumentor documentation for more information.
 * http://phpdoc.org/docs/HTMLSmartyConverter/default/phpDocumentor/tutorial_phpDocumentor.howto.pkg.html
 *
 * The Javadoc Style Guide is an excellent resource for figuring out
 * how to say what needs to be said in docblock comments.  Much of what is
 * written here is a summary of what is found there, though there are some
 * cases where what's said here overrides what is said there.
 * http://java.sun.com/j2se/javadoc/writingdoccomments/index.html#styleguide
 *
 * The first line of any docblock is the summary.  Make them one short
 * sentence, without a period at the end.  Summaries for classes, properties
 * and constants should omit the subject and simply state the object,
 * because they are describing things rather than actions or behaviors.
 *
 * Below are the tags commonly used for classes. @category through @version
 * are required.  The remainder should only be used when necessary.
 * Please use them in the order they appear here.  phpDocumentor has
 * several other tags available, feel free to use them.
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Original Author <author@example.com>
 * @author     Another Author <another@example.com>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      Class available since Release 1.2.0
 * @deprecated Class deprecated in Release 2.0.0
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
