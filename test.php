<?php
include("assets/member.inc.php");
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
<form name="register" action="" method="post">
	<label>
		<span>Username2</span>
		<input type="text" name="username" value="' . $username . '" />
	</label>
	<label>
		<span>Password2</span>
		<input type="password" name="password" />
	</label>
	<label>
		<span>Password Again2</span>
		<input type="password" name="password_again" />
	</label>
	<label>
		<span>E-Mail2</span>
		<input type="text" name="email"/>
	</label>
	<input name="register" type="submit" value="Register" />
</form>
</div>
</div>
</body>
</html>
<?php


?>