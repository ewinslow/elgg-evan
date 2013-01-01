<?php

/**
 * Just generates blank messages, with only the "to" field set.
 * Useful for testing.
 */
class Evan_Email_BlankMessageFactory implements Evan_Email_MessageFactory {
    public function createForUser(ElggUser $user) {
        $message = new Evan_Email_Message();
        $message->setTo($user->email);
        return $message;
    }
}