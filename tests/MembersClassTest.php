<?php

global $travis;
$travis=true;
require_once('assets/member.inc.php');

class MembersClassTest extends PHPUnit_Framework_TestCase
{
	private $pdo;
    public function setUp()
    {
        $database->query("CREATE TABLE hello (what VARCHAR(50) NOT NULL)");
    }
  
    public function tearDown()
    {
        $database->query("DROP TABLE hello");
    }

	public function testCheckTable()
	{
		$result = $database->query("SELECT * FROM hello");
		assertTrue($result);
	}
}
