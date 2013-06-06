<?php

/**
 * An object representing the system clock.
 */
class Evan_SystemClock implements Evan_Clock {
    
    /** @override */
    public function getDateTime() {
        return new DateTime();
    }
    
    /** @override */
    public function getTimestamp() {
        return time();
    }
}