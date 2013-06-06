<?php

class Evan_RouterTest extends PHPUnit_Framework_TestCase {

	function setUp() {
		$this->router = new Evan_Router();
		$this->pages = dirname(dirname(__FILE__)) . '/files/pages';
	}

	function testCanRegisterFilesAsRequestHandlers() {
		$this->router->registerRoutes(array(
			'/hello' => "{$this->pages}/hello.php",
		));
		
		$request = new Evan_Request(array(
			'REQUEST_URI' => '/hello',
		));
		
		ob_start();
		$this->router->route($request);
		$result = ob_get_clean();
		
		$this->assertEquals("Hello, World!", $result);
	}
	
	function testStaticFileHandlersSkipPhpInterpreter() {
		$this->router->registerRoutes(array(
			'/hello.html' => "{$this->pages}/hello.html",
		));
		
		$request = new Evan_Request(array(
			'REQUEST_URI' => '/hello.html',
		));
		
		ob_start();
		$this->router->route($request);
		$result = ob_get_clean();
		
		$this->assertEquals('<?php echo "Hello, World!"; ?>', $result);
	}
	
	function testCanMatchExactlyOneSegmentWithColon() {
		$this->router->registerRoutes(array(
			'/hello/:name' => "{$this->pages}/hello.php",
		));
		
		// Matches a single segment
		$request = new Evan_Request(array(
			'REQUEST_URI' => '/hello/world',
		));
		
		ob_start();
		$this->router->route($request);
		$result = ob_get_clean();
		
		$this->assertEquals("Hello, World!", $result);
		$this->assertEquals("world", $request->getInput('name'));
		
		// Does not match multiple segments
		$request = new Evan_Request(array(
			'REQUEST_URI' => '/hello/one/two/three',
		));
		
		ob_start();
		$this->router->route($request);
		$result = ob_get_clean();
		
		$this->assertEquals("", $result);		
	}
	
	function testCanMatchOneOrMoreSegmentsUsingStar() {
		$this->router->registerRoutes(array(
			'/hello/*segments' => "{$this->pages}/hello.php",
		));
		
		// Matches one segment
		$request = new Evan_Request(array(
			'REQUEST_URI' => '/hello/world',
		));
		
		ob_start();
		$this->router->route($request);
		$result = ob_get_clean();
		
		$this->assertEquals("Hello, World!", $result);
		$this->assertEquals("world", $request->getInput('segments'));

		// Matches multiple segments
		$request = new Evan_Request(array(
			'REQUEST_URI' => '/hello/one/two/three',
		));
		
		ob_start();
		$this->router->route($request);
		$result = ob_get_clean();
		
		$this->assertEquals("Hello, World!", $result);
		$this->assertEquals("one/two/three", $request->getInput('segments'));
	}
	
	function testMatchesMostSpecificRoutesFirst() {
		
		// The least specific routes are registered first in this map to
		// demonstrate that the behavior is not just a coincidence of the
		// order of registration
		$this->router->registerRoutes(array(
			'/hello/*foo/:bar' => 'Cannot be matched!',
			'/hello/*foo' => "{$this->pages}/foo.php",
			'/hello/:name' => "{$this->pages}/hello.php",
			'/hello/world' => "{$this->pages}/hello.html",
		));
		
		// Most specific (matching route pattern has no parameters)
		$request = new Evan_Request(array(
			'REQUEST_URI' => '/hello/world',
		));
		
		ob_start();
		$this->router->route($request);
		$result = ob_get_clean();
		
		$this->assertEquals('<?php echo "Hello, World!"; ?>', $result);

		// Less specific (matching route pattern has single-segment parameter)
		$request = new Evan_Request(array(
			'REQUEST_URI' => '/hello/bob',
		));
		
		ob_start();
		$this->router->route($request);
		$result = ob_get_clean();
		
		$this->assertEquals('Hello, World!', $result);
		$this->assertEquals('bob', $request->getInput('name'));
		
		// Least specific (matching route pattern has multi-segment parameter)
		$request = new Evan_Request(array(
			'REQUEST_URI' => '/hello/bar/baz',
		));
		
		ob_start();
		$this->router->route($request);
		$result = ob_get_clean();
		
		$this->assertEquals('foo', $result);
		$this->assertEquals('bar/baz', $request->getInput('foo'));
	}
	
}