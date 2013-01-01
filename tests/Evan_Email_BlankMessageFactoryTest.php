<?php

class Evan_Email_BlankMessageFactoryTest extends PHPUnit_Framework_TestCase {
    function testGeneratesMessages() {
        $factory = new Evan_Email_BlankMessageFactory();
        
        $message = $factory->createForUser($this->getMock('ElggUser'));
        
        $this->assertNotNull($message);
    }
}