<?php

class Evan_ViewServiceTest extends PHPUnit_Framework_TestCase {
    function testConstructor() {
        $db = new Evan_ViewService();
        
        $this->assertNotNull($db);
    }
}