<?php
namespace Evan\Storage;

class LocalDbTest extends \PHPUnit_Framework_TestCase {
    function testConstructor() {
        $db = new LocalDb();
        
        $this->assertNotNull($db);
    }
}