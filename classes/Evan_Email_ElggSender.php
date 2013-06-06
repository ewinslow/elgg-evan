<?php

/**
 * Uses Elgg's `elgg_send_email` function to send emails.
 */
class Evan_Email_ElggSender implements Evan_Email_Sender {

    /** @override */
    public function send(Evan_Email_Message $email) {
        return $this->send_($email->getFrom(), $email->getTo(), $email->getSubject(), $email->getBody());
    }
    
    public function send_($from, $to, $subject, $body) {
        return elgg_send_email($from, $to, $subject, $body);
    }

}