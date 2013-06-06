<?php

class EvanQueryParams {
	public $parts = array();

	function __construct($query) {
		parse_str($query, $this->parts);
	}

	function get($name) {
		return $this->parts[$name];
	}

	function set($name, $value) {
		$this->parts[$name] = $value;
        return $this;
	}

	function __toString() {
		return http_build_query($this->parts);
	}
}
