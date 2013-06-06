<?php

/**
 * Provides a simple interface for sending emails.
 */
interface Evan_Email_Sender {
    public function send(Evan_Email_Message $email);
}