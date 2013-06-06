<?php

class Evan_SystemClockTest extends PHPUnit_Framework_TestCase {
    public function testGetDateTimeReturnsCurrentDateTime() {
        $time = new DateTime();
        
        $clock = new Evan_SystemClock();
        
        $this->assertEquals($time, $clock->getDateTime());
    }   
}