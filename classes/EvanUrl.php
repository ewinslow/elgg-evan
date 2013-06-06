<?php

/**
 * Provides an OO interface for interacting with URLs.
 */
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
	 * @param string $url The string representation of the URL to be parsed into
     *     its component parts by `parse_url`.
	 */
	public function __construct($url) {
        $defaults = array(
            'scheme' => NULL,
            'user' => NULL,
            'pass' => NULL,
            'host' => NULL,    
            'port' => NULL,
            'path' => NULL,
            'query' => NULL,
            'fragment' => NULL,
        );
		$pieces = array_merge($defaults, parse_url($url));

		$this->scheme = $pieces['scheme'];
    	$this->user = $pieces['user'];
		$this->pass = $pieces['pass'];
		$this->host = $pieces['host'];
		$this->port = $pieces['port'];
		$this->path = $pieces['path'];
		$this->query = new EvanQueryParams($pieces['query']);
		$this->fragment = $pieces['fragment'];
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
		return $this->query->get($name);
	}

	public function setParam($name, $value) {
		$this->query->set($name, $value);
		return $this;
	}

    public function __toString() {
        // elgg.org/the/path
        $url = "{$this->host}{$this->path}";
        
        // elgg.org/the/path?some=params
        if ($this->query) {
            $url = "$url?$this->query";
        }
        
        // elgg.org/the/path?some=params#fragment
        if ($this->fragment) {
            $url = "$url#$this->fragment";
        }
        
        // user@elgg.org/the/path?some=params#fragment
        if ($this->user) {
            $user = $this->user;
            
            // user:pass@elgg.org/the/path?some=params#fragment
            if ($this->pass) {
                $user = "$user:$this->pass";
            }
            
            $url = "$user@$url";
        }
        
        $url = "//$url";
        
        // http://elgg.org/the/path?some=params#fragment
        if ($this->scheme) {
            $url = "$this->scheme:$url";
        }

        return $url;
	}
}
