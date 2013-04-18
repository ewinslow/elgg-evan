<?php

class Evan_Email_BlankMessageFactoryTest extends PHPUnit_Framework_TestCase {
    function testGeneratesMessages() {
        $factory = new Evan_Email_BlankMessageFactory();
        $user = $this->getMock('ElggUser', array(), array(), '', FALSE);
        $message = $factory->createForUser($user);
        
        $this->assertNotNull($message);
    }
}