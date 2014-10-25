<?php
namespace Evan\Time;

use DateTime;


/**
 * An object representing the system clock.
 */
class SystemClock implements Clock {
    
    /** @override */
    public function getDateTime() {
        return new DateTime();
    }
    
    /** @override */
    public function getTimestamp() {
        return time();
    }
}