<?php

/**
 * An object representing a clock. Typically the system clock.
 */
interface Evan_Clock {
    
    /**
     * @return DateTime A new object representing the current time.
     */
    public function getDateTime();
    
    /**
     * @return int The current time as a Unix timestamp.
     */
    public function getTimestamp();
}