<?php

class Evan_Email_MessageTest extends PHPUnit_Framework_TestCase {
    public function testCanConstruct() {
        $message = new Evan_Email_Message();
        
        $this->assertNotNull($message);
    }
}