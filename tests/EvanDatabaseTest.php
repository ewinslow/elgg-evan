<?php

class EvanDatabaseTest extends PHPUnit_Framework_TestCase {
    function testConstructor() {
        $db = new EvanDatabase();
        
        $this->assertNotNull($db);
    }
}