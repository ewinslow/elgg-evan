<?php
namespace Evan\Email;

use ElggUser as User;


/**
 * Create personalized emails for users.
 */
interface MessageFactory {
    
    /**
     * @return Message The new email to be sent.
     */
    public function createForUser(User $user);
    
}