<?php

class Evan_Email_ElggSenderTest extends PHPUnit_Framework_TestCase {
    function testCanSend() {
        $sender = $this->getMock('Evan_Email_ElggSender', array('send_'));
        
        $from = 'foobar@example.com';
        $to = 'bazbiff@example.com';
        $subject = 'Subject';
        $body = 'Body';
        
        $message = new Evan_Email_Message();
        $message->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body);
        
        $sender
            ->expects($this->once())
            ->method('send_')
            ->with($from, $to, $subject, $body)
            ->will($this->returnValue(true));
        
        $this->assertTrue($sender->send($message));
    }
}