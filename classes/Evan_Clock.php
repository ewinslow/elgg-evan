<?php

/**
 * An object representing the system clock.
 */
class Evan_Clock {
    
    /**
     * @return DateTime The current system time.
     */
    public function getTime() {
        return new DateTime();
    }
    
}