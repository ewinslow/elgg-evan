<?php
namespace Evan\Email;

use ElggUser as User;

/**
 * Just generates blank messages, with only the "to" field set.
 * Useful for testing.
 */
class BlankMessageFactory implements MessageFactory {
    public function createForUser(User $user) {
        $message = new Message();
        $message->setTo($user->email);
        return $message;
    }
}