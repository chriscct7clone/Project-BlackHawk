<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
session_start();
$_SERVER['REMOTE_ADDR']='127.0.0.1';
require_once('assets/member.inc.php');
class MembersClassTest extends PHPUnit_Framework_TestCase
{
	private $pdo;
    public function setUp()
    {
		global $database;
        $database->query("CREATE TABLE IF NOT EXISTS `garage_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20");
		unset ( $database);
	}
  
    public function tearDown()
    {
		global $database;
        $database->query("DROP TABLE garage_roles");
		unset ( $database);
	}
	public function testAddition(){
		$this->assertEquals(1,1);
		$this->assertEquals((2-1),1);
	}
	public function testTableAddition()
	{	
		global $database;
		$result = $database->query("INSERT INTO `garage_roles` (`id`, 	`name`) VALUES (1, 'Police');");
		// We only get return if failed.
		$result = ($result==null)? true : false;
		$this->assertTrue($result);
		unset ( $database);
	}
}
