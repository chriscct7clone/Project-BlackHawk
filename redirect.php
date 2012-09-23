<?php
include("assets/member.inc.php");
/* TODO: Redirect
if ($role=admin)
redirect to...
else if ($role=police)
redirect to...
else //role is student
redirect to...

On each, we need to check their cookie and then if not correct role, redirect them back to this.
*/


// TODO: User should be logged in on this page
$title   = 'Passing through roles';
$content =  '<meta http-equiv="refresh" content="2;url=./roles/student_commuter.php" /><p>Passing through roles....</p>';
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
	</div>
	<div id="body" class="group">
		<?php echo $content; ?>
	</div>
</div>
</body>
</html>