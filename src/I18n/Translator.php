<?php
namespace Evan\I18n;

interface Translator {
    public function translate($string, array $args = array(), $lang);
}