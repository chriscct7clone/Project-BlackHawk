<?php


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
		$_SERVER['REMOTE_ADDR']='127.0.0.1';
        $this->pdo->query("DROP TABLE hello");
    }

	public function checkTable()
	{
		$result = $database->query("SELECT * FROM hello");
		assertTrue($result);
	}
}
