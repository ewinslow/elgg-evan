<?php
namespace Evan;

class ViewerTest extends \PHPUnit_Framework_TestCase {
    function testConstructor() {
        $db = new Viewer();
        
        $this->assertNotNull($db);
    }
}