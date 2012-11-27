<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
class mailerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var mailer
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new mailer('chriscct7@gmail.com','default');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers mailer::genTemplate
     * @todo   Implement testGenTemplate().
     */
    public function testGenTemplate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers mailer::mail
     * @todo   Implement testMail().
     */
    public function testMail() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
