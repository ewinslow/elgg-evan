<?php

/**
 * Create personalized emails for users.
 */
interface Evan_Email_MessageFactory {
    
    /**
     * @return Evan_Email_Message The new email to be sent.
     */
    public function createForUser(ElggUser $user);
    
}