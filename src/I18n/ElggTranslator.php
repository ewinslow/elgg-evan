<?php
namespace Evan\I18n;

class ElggTranslator implements Translator {
    public function translate($string, array $args = array(), $lang) {
        return \elgg_echo($string, $args, $lang);
    }
}