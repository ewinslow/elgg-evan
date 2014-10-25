<?php
namespace Evan\Email;

class ElggSenderTest extends \PHPUnit_Framework_TestCase {
    function testCanSend() {
        $sender = $this->getMock('Evan\Email\ElggSender', array('send_'));
        
        $from = 'foobar@example.com';
        $to = 'bazbiff@example.com';
        $subject = 'Subject';
        $body = 'Body';
        
        $message = new Message();
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