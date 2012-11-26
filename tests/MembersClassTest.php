<?php
session_start();
$_SERVER['REMOTE_ADDR']='127.0.0.1';

require_once('assets/member.inc.php');

class MembersClassTest extends PHPUnit_Framework_TestCase
{
	private $pdo;
    public function setUp()
    {
		global $database;
        $database->query("CREATE TABLE hello (what VARCHAR(50) NOT NULL)");
    }
  
    public function tearDown()
    {
		global $database;
        $database->query("DROP TABLE hello");
    }
	public function testAddition(){
		assertEquals(1,1);
		assertEquals((2-1),1);
	}
	public function testTableAddition()
	{	
		global $database;
		$result = $database->query("SELECT * FROM hello");
		assertTrue($result);
	}
}
