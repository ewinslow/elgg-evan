<?php

class Evan_ClockTest extends PHPUnit_Framework_TestCase {
    public function testGetTimeReturnsCurrentDateTime() {
        $time = new DateTime();
        
        $clock = new Evan_Clock();
        
        $this->assertEquals($time, $clock->getTime());
    }   
}