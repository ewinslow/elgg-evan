<?php
namespace Evan\Email;


/**
 * Provides a simple interface for sending emails.
 */
interface Sender {
    public function send(Message $email);
}