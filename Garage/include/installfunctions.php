<?php
/* Install (Garage) functions */
function subdomboolcheck(){
$parts = explode(".",$_SERVER['HTTP_HOST']);
$length = count($parts);
$subdomain = $length>2 ?  $issub=true : $issub=false;
if($issub==true){
    return true;
}
else{ 
$dir=$_SERVER['REQUEST_URI'];
$scriptname="install.php";
$subdomain=str_replace($scriptname, "", $dir);
if(($subdomain=="\\")||($subdomain=="/") || ($subdomain==''))
{
	//var_dump($subdomain);
	return false;
}
else
{
	//var_dump($subdomain);
	return true;
 }
}
}
// NOTE: The tables below have not been updated for use in our program yet, but it does show how to setup tables in PHP. Neat eh?
$sqltable1=("CREATE TABLE `users` (
`UID` int(10) NOT NULL default '',
`name` varchar(255) NOT NULL default '',
`email` varchar(255) NOT NULL default '',
`phone` varchar(255) NOT NULL default '',
`address1` varchar(255) NOT NULL default '',
`address2` varchar(255) NOT NULL default '',
`state` varchar(255) NOT NULL default '',
`country` varchar(255) NOT NULL default '',
`logo` varchar(255) NOT NULL default '',
PRIMARY KEY  (`ID`),
KEY `UID` (`UID`)
) ENGINE=MyISAM");
$sqltable2=("CREATE TABLE `company_assigned` (
`ID` int(10) NOT NULL auto_increment,
`user` int(10) NOT NULL default '0',
`company` int(10) NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `company` (`company`),
KEY `user` (`user`)
) ENGINE=MyISAM");
$sqltable3=("CREATE TABLE `files` (
`ID` int(10) NOT NULL auto_increment,
`name` varchar(255) NOT NULL default '',
`desc` varchar(255) NOT NULL default '',
`project` int(10) NOT NULL default '0',
`milestone` int(10) NOT NULL default '0',
`user` int(10) NOT NULL default '0',
`tags` varchar(255) NOT NULL default '',
`added` varchar(255) NOT NULL default '',
`datei` varchar(255) NOT NULL default '',
`type` varchar(255) NOT NULL default '',
`title` varchar(255) NOT NULL default '',
`folder` int(10) NOT NULL,
`visible` text NOT NULL,
PRIMARY KEY  (`ID`),
KEY `name` (`name`),
KEY `datei` (`datei`),
KEY `added` (`added`),
KEY `project` (`project`),
KEY `tags` (`tags`)
) ENGINE=MyISAM");
$sqltable4=("CREATE TABLE `log` (
`ID` int(10) NOT NULL auto_increment,
`user` int(10) NOT NULL default '0',
`username` varchar(255) NOT NULL default '',
`name` varchar(255) NOT NULL default '',
`type` varchar(255) NOT NULL default '',
`action` int(1) NOT NULL default '0',
`project` int(10) NOT NULL default '0',
`datum` varchar(255) NOT NULL default '',
PRIMARY KEY  (`ID`),
KEY `datum` (`datum`),
KEY `type` (`type`),
KEY `action` (`action`),
FULLTEXT KEY `username` (`username`),
FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM");
$sqltable5=("CREATE TABLE `messages` (
`ID` int(10) NOT NULL auto_increment,
`project` int(10) NOT NULL default '0',
`title` varchar(255) NOT NULL default '',
`text` text NOT NULL,
`tags` varchar(255) NOT NULL,
`posted` varchar(255) NOT NULL default '',
`user` int(10) NOT NULL default '0',
`username` varchar(255) NOT NULL default '',
`replyto` int(11) NOT NULL default '0',
`milestone` int(10) NOT NULL,
PRIMARY KEY  (`ID`),
KEY `project` (`project`),
KEY `user` (`user`),
KEY `replyto` (`replyto`),
KEY `tags` (`tags`)
) ENGINE=MyISAM");
$sqltable6=("CREATE TABLE `milestones` (
`ID` int(10) NOT NULL auto_increment,
`project` int(10) NOT NULL default '0',
`name` varchar(255) NOT NULL default '',
`desc` text NOT NULL,
`start` varchar(255) NOT NULL default '',
`end` varchar(255) NOT NULL default '',
`status` tinyint(1) NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `name` (`name`),
KEY `end` (`end`),
KEY `project` (`project`)
) ENGINE=MyISAM");
$sqltable7=("CREATE TABLE `milestones_assigned` (
`ID` int(10) NOT NULL auto_increment,
`user` int(10) NOT NULL default '0',
`milestone` int(10) NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `user` (`user`),
KEY `milestone` (`milestone`)
) ENGINE=MyISAM");
$sqltable8=("CREATE TABLE `project` (
`ID` int(10) NOT NULL auto_increment,
`name` varchar(255) NOT NULL default '',
`desc` text NOT NULL,
`start` varchar(255) NOT NULL default '',
`end` varchar(255) NOT NULL default '',
`status` tinyint(1) NOT NULL default '0',
`budget` float NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `status` (`status`)
) ENGINE=MyISAM");
$sqltable9=("CREATE TABLE `project_assigned` (
`ID` int(10) NOT NULL auto_increment,
`user` int(10) NOT NULL default '0',
`project` int(10) NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `user` (`user`),
KEY `project` (`project`)
) ENGINE=MyISAM");
$sqltable10=("CREATE TABLE `settings` (
`ID` tinyint(1)  default '0',
`name` varchar(255)  default '',
`subtitle` varchar(255)  default '',
`locale` varchar(6)  default '',
`timezone` varchar(60) ,
`dateformat` varchar(50) ,
`template` varchar(255)  default '',
`mailnotify` tinyint(1)  default '1',
`mailfrom` varchar(255) ,
`mailfromname` varchar(255) ,
`mailmethod` varchar(5) ,
`mailhost` varchar(255) ,
`mailuser` varchar(255) ,
`mailpass` varchar(255) ,
`rssuser` varchar(255) ,
`rsspass` varchar(255) ,
KEY `ID` (`ID`),
KEY `name` (`name`),
KEY `subtitle` (`subtitle`),
KEY `locale` (`locale`),
KEY `template` (`template`)
) ENGINE=MyISAM");
$sqltable11=("CREATE TABLE `tasklist` (
`ID` int(10) NOT NULL auto_increment,
`project` int(10) NOT NULL default '0',
`name` varchar(255) NOT NULL default '',
`desc` text NOT NULL,
`start` varchar(255) NOT NULL default '',
`status` tinyint(1) NOT NULL default '0',
`access` tinyint(4) NOT NULL default '0',
`milestone` int(10) NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `status` (`status`),
KEY `milestone` (`milestone`)
) ENGINE=MyISAM");
$sqltable12=("CREATE TABLE `tasks` (
`ID` int(10) NOT NULL auto_increment,
`start` varchar(255) NOT NULL default '',
`end` varchar(255) NOT NULL default '',
`title` varchar(255) NOT NULL default '',
`text` text NOT NULL,
`liste` int(10) NOT NULL default '0',
`status` tinyint(1) NOT NULL default '0',
`project` int(10) NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `liste` (`liste`),
KEY `status` (`status`),
KEY `end` (`end`)
) ENGINE=MyISAM");
$sqltable13=("CREATE TABLE `tasks_assigned` (
`ID` int(10) NOT NULL auto_increment,
`user` int(10) NOT NULL default '0',
`task` int(10) NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `user` (`user`),
KEY `task` (`task`)
) ENGINE=MyISAM");
$sqltable14=("
CREATE TABLE `user` (
`ID` int(10)  auto_increment,
`name` varchar(255) default '',
`email` varchar(255) default '',
`tel1` varchar(255),
`tel2` varchar(255) ,
`pass` varchar(255)  default '',
`company` varchar(255)  default '',
`lastlogin` varchar(255)  default '',
`zip` varchar(10) ,
`gender` char(1)  default '',
`url` varchar(255)  default '',
`adress` varchar(255)  default '',
`adress2` varchar(255)  default '',
`state` varchar(255)  default '',
`country` varchar(255)  default '',
`tags` varchar(255)  default '',
`locale` varchar(6)  default '',
`avatar` varchar(255)  default '',
`rate` varchar(10) ,
PRIMARY KEY  (`ID`),
UNIQUE KEY `name` (`name`),
KEY `pass` (`pass`),
KEY `locale` (`locale`)
) ENGINE=MyISAM");
$sqltable15=("CREATE TABLE `chat` (
`ID` int(10) NOT NULL auto_increment,
`time` varchar(255) NOT NULL default '',
`ufrom` varchar(255) NOT NULL default '',
`ufrom_id` int(10) NOT NULL default '0',
`userto` varchar(255) NOT NULL default '',
`userto_id` int(10) NOT NULL default '0',
`text` varchar(255) NOT NULL default '',
PRIMARY KEY  (`ID`)
) ENGINE=MyISAM");
$sqltable16=("CREATE TABLE `files_attached` (
`ID` int(10) unsigned NOT NULL auto_increment,
`file` int(10) unsigned NOT NULL default '0',
`message` int(10) unsigned NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `file` (`file`,`message`)
) ENGINE=MyISAM");
$sqltable17=("CREATE TABLE `timetracker` (
`ID` int(10) NOT NULL auto_increment,
`user` int(10) NOT NULL default '0',
`project` int(10) NOT NULL default '0',
`task` int(10) NOT NULL default '0',
`comment` text NOT NULL,
`started` varchar(255) NOT NULL default '',
`ended` varchar(255) NOT NULL default '',
`hours` float NOT NULL default '0',
`pstatus` tinyint(1) NOT NULL default '0',
PRIMARY KEY  (`ID`),
KEY `user` (`user`,`project`,`task`),
KEY `started` (`started`),
KEY `ended` (`ended`)
) ENGINE=MyISAM");
$sqltable18=("CREATE TABLE `projectfolders` (
`ID` int(10) unsigned NOT NULL auto_increment,
`parent` int(10) unsigned NOT NULL default '0',
`project` int(11) NOT NULL default '0',
`name` text NOT NULL,
`description` varchar(255) NOT NULL,
`visible` text NOT NULL,
PRIMARY KEY  (`ID`),
KEY `project` (`project`)
) ENGINE=MyISAM");
$sqltable19=("
CREATE TABLE `roles` (
`ID` int(10) NOT NULL auto_increment,
`name` varchar(255) NOT NULL,
`projects` text NOT NULL,
`tasks` text NOT NULL,
`milestones` text NOT NULL,
`messages` text NOT NULL,
`files` text NOT NULL,
`chat` text NOT NULL,
`timetracker` text NOT NULL,
`admin` text NOT NULL,
`user` text NOT NULL,
`api` text NOT NULL,
`holden1` text NOT NULL,
`holden2` text NOT NULL,
`holden3` text NOT NULL,
PRIMARY KEY  (`ID`)
) ENGINE=MyISAM");
$sqltable20=("
CREATE TABLE `roles_assigned` (
`ID` int(10) NOT NULL auto_increment,
`user` int(10) NOT NULL,
`role` int(10) NOT NULL,
PRIMARY KEY  (`ID`)
) ENGINE=MyISAM");
?>