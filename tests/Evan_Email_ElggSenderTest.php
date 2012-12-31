<?php

class Evan_Email_ElggSenderTest extends PHPUnit_Framework_TestCase {
    function testCanSend() {
        $sender = $this->getMock('Evan_Email_ElggSender', array('send_'));
        
        $sender
            ->expects($this->once())
            ->method('send_')
            ->will($this->returnValue(true));
        
        $this->assertTrue($sender->send(new Evan_Email_Message()));
    }
}