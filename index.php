<?php
/* If this file does not exist, it's because they haven't run the install yet. */
if(!file_exists('assets/config.inc.php')) {
	echo '<a href="setup/">Please install the parking system first!</a>';
} else {
/*
Below is the code that handles the contents for the pages. I am handling it the way I am just because it was convinient for me when I 
wrote the script to keep it ultra simple. Obviously this way of having PHP send the entire contents of the page to the site is not
feasible for what we are doing, because you can't do asyc. calls this way. At some point, we will need to convert to using a dedicated
a seperate file for the secure page 
*/
/* Include Code */
include("assets/member.inc.php");
/* Is an Action set? */
if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = null;
}
if($action == 'secure') {
	$member->LoggedIn();
	$title   = 'Live Statistics';
	$content =  '<meta http-equiv="refresh" content="2;url=test.php" />';
} else {
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
		<h1 id="logo">BlackHawk Login System</h1>
		<div id="user">
		<?php if($member->sessionIsSet() == true) { 
			$user = $member->data();
		?>
			<div id="user-info">Hello, <?php echo $user->username; ?></div>
			<ul id="user-ops">
				<li><a href="member.php?action=settings">Settings</a></li>
				<li><a href="member.php?action=logout">Logout</a></li>
			</ul>
		<?php } else { ?>
			<div id="user-info">Hello, Guest</div>
			<ul id="user-ops">
				<li><a href="member.php?action=login">Login</a></li>
				<li><a href="member.php?action=register">Register</a></li>
			</ul>
		<?php } ?>
		</div>
	</div>
	<ul id="navigation" class="group">
		<li><a href="index.php">Index</a></li>
		<li><a href="index.php?action=secure">Secure Page</a></li>
	</ul>
	<div id="body" class="group">
<?php echo $content; ?>
	</div>
</div>
</body>
</html>
<?php } ?>