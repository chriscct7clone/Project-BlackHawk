<?php
 /**
 * The Home Page
 *
 * Displays the home page, and does some redirecting work
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage Home
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @see        redirect.php
 * @since      File available since Release 0.3.0
 */

/* If this file does not exist, it's because they haven't run the install yet. */
if(!file_exists('assets/config.inc.php')) {
	echo '<a href="setup/index.php">Please install the parking system first!</a>';
} else {
/*
TODO: Finish Stage 2 Seperation
*/
/* Include Code */
require_once('assets/member.inc.php');
/* Is an Action set? */
if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = null;
}
if($action == 'secure') {
	$member->LoggedIn();
	$title   = 'Redirecting';
	// $role    = $member->role(); Gets role of user
	$content =  '<meta http-equiv="refresh" content="2;url=dashboard.php"/><p>Redirecting....</p>';
	}
else if($action == 'global') {
	$member->LoggedIn();
	$title   = 'Redirecting';
	$content =  '<meta http-equiv="refresh" content="2;url=statistics.php"/><p>Loading Statistics....</p>';
} else{
	$title   = 'Welcome';
	$content =  'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title ?></title>
	<!--CSS Files-->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>
<body>
<div id="wrapper" class="group">
	<div id="header" class="group">
		<h1 id="logo">BlackHawk</h1>
		<div id="user">
		<?php if ($member->sessionIsSet()==true){
		?>
			<div id="user-info">Hello, <?php echo $_SESSION['member_name']; ?></div>
			<ul id="user-ops">
				<li><a href="member.php?action=settings">Settings</a></li>
				<li><a href="member.php?action=logout">Logout</a></li>
			</ul>
		<?php } else { ?>
			<div id="user-info">Hello, Guest</div>
			<ul id="user-ops">
				<li><a href="member.php?action=login">Login</a></li>
			</ul>
		<?php } ?>
		</div>
	</div>
	<ul id="navigation" class="group">
		<li><a href="index.php">Home Page</a></li>
		<?php if ($member->sessionIsSet()==true){ ?>
		<li><a href="index.php?action=secure">Secure Page</a></li>
		<?php } else { ?>
		<li><a href="member.php?action=login">Login</a></li>
		<?php } ?>
		<li><a href="index.php?action=global">Public Statistics</a></li>
	</ul>
	<div id="body" class="group">
<?php echo $content; ?>
	</div>
</div>
</body>
</html>
<?php } ?>