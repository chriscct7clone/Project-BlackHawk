<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
class ConfigTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Config
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Config;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Config::read
     * @todo   Implement testRead().
     */
    public function testRead() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Config::write
     * @todo   Implement testWrite().
     */
    public function testWrite() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
