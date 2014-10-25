<?php
namespace Evan\Email;

class MessageTest extends \PHPUnit_Framework_TestCase {
    public function testCanConstruct() {
        $message = new Message();
        
        $this->assertNotNull($message);
    }
}