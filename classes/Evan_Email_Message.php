<?php

class Evan_Email_Message {
    private $to;
    
    private $from;
    
    private $subject;
    
    private $body;
    
    public function getTo() {
        return $this->to;
    }
    
    public function setTo($to) {
        $this->to = $to;
        return $this;
    }
    
    public function getFrom() {
        return $this->from;
    }
    
    public function setFrom($from) {
        $this->from = $from;
        return $this;
    }
    
    public function getSubject() {
        return $this->subject;
    }
    
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }
    
    public function getBody() {
        return $this->body;
    }
    
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }
}