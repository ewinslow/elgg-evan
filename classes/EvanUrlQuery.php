<?php

class EvanUrlQuery {
	public $parts;

	function __construct($query) {
		parse_str($query, $this->parts);
	}

	function __get($name) {
		return $this->parts[$name];
	}

	function __set($name, $value) {
		$this->parts[$name] = $value;
	}

	function __unset($name) {
		unset($this->parts[$name]);
	}

	function __isset($name) {
		return isset($this->parts[$name]);
	}

	function __toString() {
		return http_build_query($this->parts);
	}
}
