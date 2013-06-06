<?php

class Evan_Email_NullSenderTest extends PHPUnit_Framework_TestCase {
    function testSendAlwaysReturnsTrue() {
        $email = new Evan_Email_Message();
        $sender = new Evan_Email_NullSender();
        
        $this->assertTrue($sender->send($email));
    }
}