<?php

/**
 * Simplified representation of an HTTP request.
 */
class Evan_Request {
	private $server;
	private $request;
	
	/**
	 * @param array $_SERVER  An array that conforms to the $_SERVER api.
	 * @param array $_REQUEST An array that conforms to the $_REQUEST api.
	 */
	public function __construct(array $_SERVER, array $_REQUEST = array()) {
		$this->server = $_SERVER;
		$this->request = $_REQUEST;
	}

	/**
	 * Returns the path relative to the site root. Includes leading slash.
	 */
	public function getPath() {
		return $this->server['REQUEST_URI'];
	}

	/**
	 * @param string $name  The input key.
	 * @param string $value The input value.
	 */
	public function setInput($name, $value) {
		$this->request[$name] = $value;
	}
	
	/**
	 * @param string $name The input key.
	 */
	public function getInput($name) {
		return $this->request[$name];
	}
}