<?php

class Evan_Db_LocalTest extends PHPUnit_Framework_TestCase {
    function testConstructor() {
        $db = new Evan_Db_Local();
        
        $this->assertNotNull($db);
    }
}