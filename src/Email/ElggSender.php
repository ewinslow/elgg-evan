<?php
namespace Evan\Email;


/**
 * Uses Elgg's `elgg_send_email` function to send emails.
 */
class ElggSender implements Sender {

    /** @override */
    public function send(Message $email) {
        return $this->send_($email->getFrom(), $email->getTo(), $email->getSubject(), $email->getBody());
    }
    
    public function send_($from, $to, $subject, $body) {
        return \elgg_send_email($from, $to, $subject, $body);
    }

}