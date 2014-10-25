<?php
namespace Evan\Http;

/**
 * Simplified representation of an HTTP request.
 */
class Request {
	private $server;
	private $request;
	
	/**
	 * @param array $_server  An array that conforms to the $_SERVER api.
	 * @param array $_request An array that conforms to the $_REQUEST api.
	 */
	public function __construct(array $_server, array $_request = array()) {
		$this->server = $_server;
		$this->request = $_request;
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