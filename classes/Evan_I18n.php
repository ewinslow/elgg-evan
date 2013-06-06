<?php

class Evan_I18n {
    public function translate($string, array $args = array(), $lang) {
        return elgg_echo($string, $args, $lang);
    }
}