<?php

class EvanUrl {
	/** @var string */
	public $scheme;

	/** @var string */
	public $host;

	/** @var int */
	public $port;

	/** @var string */
	public $user;

	/** @var string */
	public $pass;

	/** @var string */
	public $path;

	/** @var EvanUrlQuery */
	private $query;

	/** @var string */
	public $fragment;

	/**
	 * Takes a string in URL form and parses it into its pieces.
	 * @param string $url
	 */
	public function __contruct($url) {
		$pieces = parse_url($url);

		$this->scheme = $pieces['scheme'];
		$this->host = $pieces['host'];
		$this->port = $pieces['port'];
		$this->user = $pieces['user'];
		$this->pass = $pieces['pass'];
		$this->path = $pieces['path'];
		$this->query = new EvanUrlQuery($pieces['query']);
		$this->fragment = $pieces['fragment'];
	}

	public function __toString() {
		return http_build_url(array(
			'scheme' => $this->scheme,
			'host' => $this->host,
			'port' => $this->port,
			'user' => $this->user,
			'pass' => $this->pass,
			'path' => $this->path,
			'query' => "$this->query",
			'fragment' => $this->fragment,
		));
	}

	/**
	 * Convenience function for setting these two parameters on the URL. You must generate
	 * the timestamp and token elsewhere. This was done because every URL should not have
	 * to carry a pointer to the current Elgg session.
	 */
	public function addActionTokens($timestamp, $token) {
		return $this->setParam('__elgg_ts', $timestamp)
		            ->setParam('__elgg_token', $token);
	}

	/**
	 * Convenience function for setting the viewtype.
	 */
	public function setViewtype($viewtype) {
		return $this->setParam('viewtype', $viewtype);
	}

	public function getParam($name) {
		return $this->query->{$name};
	}

	public function setParam($name, $value) {
		$this->query->set($name, $value);
		return $this;
	}
}
