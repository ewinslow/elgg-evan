<?php

/**
 * Always returns successfully but does not actually send any email.
 * 
 * Useful for testing.
 */
class Evan_Email_NullSender implements Evan_Email_Sender {

    /** @override */
    public function send(Evan_Email_Message $email) {
        return true;
    }
    
}