<?php
namespace Evan\Time;

use DateTime;



/**
 * A clock whose current time can be set explicitly and does not advance
 * automatically.
 */
class MockClock extends DateTime implements Clock {
    /** @override */
    public function getDateTime() {
        return clone $this;
    }
}