<?php

/**
 * Uses Elgg's `elgg_send_email` function to send emails.
 */
class Evan_Email_ElggSender implements Evan_Email_Sender {
    public function send(Evan_Email_Message $email) {
        return $this->send_($email->getTo(), $email->getFrom(), $email->getSubject(), $email->getBody());
    }
    
    public function send_($to, $from, $subject, $body) {
        return elgg_send_email($to, $from, $subject, $body);
    }
}