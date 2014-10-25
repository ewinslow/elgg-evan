<?php
namespace Evan\Storage;

class MysqlDbTest extends \PHPUnit_Framework_TestCase {
    function testConstructor() {
        $db = new MysqlDb();
        
        $this->assertNotNull($db);
    }
}