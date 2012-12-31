<?php

class Evan_Db_MysqlTest extends PHPUnit_Framework_TestCase {
    function testConstructor() {
        $db = new Evan_Db_Mysql();
        
        $this->assertNotNull($db);
    }
}