<?php
namespace Evan\Email;

/**
 * Always returns successfully but does not actually send any email.
 * 
 * Useful for testing.
 */
class NullSender implements Sender {

    /** @override */
    public function send(Message $email) {
        return true;
    }
    
}