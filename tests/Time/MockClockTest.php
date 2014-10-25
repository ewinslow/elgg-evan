<?php
namespace Evan\Time;

use DateTime;

class MockClockTest extends \PHPUnit_Framework_TestCase {
    public function testCanSetDateTimeExplicitly() {
        $clock = new MockClock();
        $clock->setDate(2010, 5, 31);
        $clock->setTime(12, 35, 13);
        
        $datetime = $clock->getDateTime();
        
        $this->assertEquals("2010-05-31T12:35:13", $datetime->format("Y-m-d\TH:i:s"));
    }   
}