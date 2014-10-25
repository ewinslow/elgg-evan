<?php
namespace Evan\Email;

class NullSenderTest extends \PHPUnit_Framework_TestCase {
    function testSendAlwaysReturnsTrue() {
        $email = new Message();
        $sender = new NullSender();
        
        $this->assertTrue($sender->send($email));
    }
}