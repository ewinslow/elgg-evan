<?php

/**
 * A clock whose current time can be set explicitly and does not advance
 * automatically.
 */
class Evan_MockClock extends DateTime implements Evan_Clock {
    /** @override */
    public function getDateTime() {
        return clone $this;
    }
}