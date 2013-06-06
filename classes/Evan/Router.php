<?php

/**
 * Delegates requests to controllers based on the provided configuration.
 */
class Evan_Router {
	private $routes = array(
		0 => array(), // stores routes that have 0 named parameters
	);
	
	/**
	 * Tells the router how to handle more URLs.
	 * 
	 * @param array $routes The map of routes to handlers. Keys should be URL
	 *     templates relative to Elgg's site root. Values should be paths to the
	 *     file that handles the request.
	 */
	public function registerRoutes(array $routes) {
		// Sorts routes by specificity. Lower number means more specific
		foreach ($routes as $route => $handler) {
			$specificity = substr_count($route, ':');
			
			// One star is less specific than any number of colons
			$specificity += substr_count($route, "*") * 1000;
			if (!isset($this->routes[$specificity])) {
				$this->routes[$specificity] = array();
			}
			
			$this->routes[$specificity][$route] = $handler;
		}
		
		ksort($this->routes);
	}
	
	/**
	 * Generates a response from the given request based on the currently 
	 * registered routes and handlers.
	 * 
	 * @param Evan_Request $request The request to handle.
	 * @return boolean Whether the request was routed successfully.
	 */
	public function route(Evan_Request $request) {
		$path = $request->getPath();
		
		// Shortcut for most specific routes
		if (!empty($this->routes[0][$path])) {
			return $this->executeHandler($this->routes[0][$path]);
		}
		
		foreach ($this->routes as $specificity => $routeMap) {
			if ($specificity == 0) {
				continue;
			}
			
			foreach ($routeMap as $route => $handler) {
				if (empty($handler)) { // handler was unregistered
					continue;
				}
				
				$inputs = $this->match($route, $path);
				if (is_array($inputs)) {
					foreach ($inputs as $name => $value) {
						$request->setInput($name, $value);
					}
					
					return $this->executeHandler($handler);
				}
			}
		}
		
		// No matching routes. 404
		return false;
	}
	
	private function executeHandler($handler) {
		$extension = pathinfo($handler, PATHINFO_EXTENSION);
		if ($extension == 'php') {
			return (bool)include $handler;				
		} elseif (!empty($extension)) {
			return (bool)readfile($handler);
		} else {
			// Invalid handler (500 error).
			return false;
		}
		
		return true;
	}

	/**
	 * @param string $route e.g. '/blog/:guid'
	 * @param string $path  e.g. '/blog/123'
	 * @return array Returns an array of inputs if the route matched the path. False otherwise.
	 */
	private function match($route, $path) {

		// Periods are literal
		$routeRegEx = preg_replace('/\\./', '\\\\.', $route);
		
		// Converts colon and star to appropriate "named subpatterns"
		$routeRegEx = preg_replace('/:([a-z_]+)/', '(?P<$1>[^/]+)', $routeRegEx);
		$routeRegEx = preg_replace('/\\*([a-z_]+)/', '(?P<$1>.+)', $routeRegEx);
	
		$matches = array();
		$count = preg_match("#^$routeRegEx$#", $path, $matches);
		
		if ($count) {
			
			$result = array();
			
			foreach ($matches as $name => $value) {
				if (!is_int($name)) {				
					$result[$name] = $matches[$name];
				}
			}
			
			return $result;
		}
		
		return false;
	}

}