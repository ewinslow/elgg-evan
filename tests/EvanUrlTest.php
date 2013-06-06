<?php

class EvanUrlTest extends PHPUnit_Framework_TestCase {
    function testParsingAndSerializing() {
		$href = "http://user:pass@elgg.org/path?query=fun+times#fragment";
        
		$url = new EvanUrl($href);
        
		$this->assertEquals('http', $url->scheme);
    	$this->assertEquals('user', $url->user);
		$this->assertEquals('pass', $url->pass);
		$this->assertEquals('elgg.org', $url->host);
		$this->assertEquals('/path', $url->path);
		$this->assertEquals('fun times', $url->getParam('query'));
		$this->assertEquals('fragment', $url->fragment);
        
		// Ensure non-existent params were initialized to null.
		$this->assertNull($url->port);
        
		// Ensure toString re-encodes exactly correctly.
		$this->assertEquals($href, "$url");
	}
}
