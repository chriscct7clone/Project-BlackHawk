<?php
// I thought I would import this from a little bit of Kombineer's update file to become BlackHawk's scheduled maintenence script.
error_reporting(0);
// optimize tables
$opt1 = mysql_query("OPTIMIZE TABLE `files`");
$opt2 = mysql_query("OPTIMIZE TABLE `files_attached`");
$opt3 = mysql_query("OPTIMIZE TABLE `log`");
$opt4 = mysql_query("OPTIMIZE TABLE `messages`");
$opt5 = mysql_query("OPTIMIZE TABLE `milestones`");
$opt6 = mysql_query("OPTIMIZE TABLE `milestones_assigned`");
$opt7 = mysql_query("OPTIMIZE TABLE `projectfolders`");
$opt8 = mysql_query("OPTIMIZE TABLE `project`");
$opt9 = mysql_query("OPTIMIZE TABLE `project_assigned`");
$opt10 = mysql_query("OPTIMIZE TABLE `roles`");
$opt11 = mysql_query("OPTIMIZE TABLE `roles_assigned`");
$opt12 = mysql_query("OPTIMIZE TABLE `settings`");
$opt13 = mysql_query("OPTIMIZE TABLE `tasklist`");
$opt14 = mysql_query("OPTIMIZE TABLE `tasks`");
$opt15 = mysql_query("OPTIMIZE TABLE `tasks_assigned`");
$opt16 = mysql_query("OPTIMIZE TABLE `timetracker`");
$opt17 = mysql_query("OPTIMIZE TABLE `user`");
//$opt18 = mysql_query("OPTIMIZE TABLE `projectfolders`");
//$opt19 = mysql_query("OPTIMIZE TABLE `roles`");
//$opt20 = mysql_query("OPTIMIZE TABLE `roles_assigned`");
?>