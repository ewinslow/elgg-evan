<?php
namespace Evan\Time;

use DateTime;

class SystemClockTest extends \PHPUnit_Framework_TestCase {
    public function testGetDateTimeReturnsCurrentDateTime() {
        $time = new DateTime();
        
        $clock = new SystemClock();
        
        $this->assertEquals($time, $clock->getDateTime());
    }   
}