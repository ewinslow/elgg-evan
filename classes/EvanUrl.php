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
	 * Prepends the Elgg root if there is no host specified.
	 * Urls intended to be relative to the Elgg root must have a beginning forward-slash ("/")
	 * @param string $url
	 */
	static function normalize($url) {
		if (preg_match('#^/[^/]#', $url)) {
			return elgg_get_site_url() . ltrim($url, '/');
		} else {
			return $url;
		}
	}

	/**
	 * Takes a string in URL form and parses it into its pieces.
	 * @param string $url
	 */
	public function __contruct($url) {
		$pieces = parse_url(EvanUrl::normalize($url));

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

		if (isset($this->user)) {
			$auth = $this->user;

			if (isset($this->pass)) {
				$auth .= ":$this->pass";
			}

			$auth .= "@";
		}

		$scheme = isset($this->scheme) ? "$this->scheme:" : '';
		$port = isset($this->port) ? ":$this->port" : '';
		$query = isset($this->query) ? "?$this->query": '';
		$fragment = isset($this->fragment) ? "#$this->fragment": '';

		return "{$scheme}//{$auth}{$this->host}{$port}/{$this->path}{$query}{$fragment}";
	}

	public function addActionTokens() {
		$this->query->set('__elgg_ts', $timestamp = time());
		$this->query->set('__elgg_token', generate_action_token($timestamp));
	}

	public function setFormat($format) {
		$this->query->set('viewtype', $format);
	}
}