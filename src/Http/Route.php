<?php
namespace Evan\Http;

use ElggPlugin as Plugin;

/**
 * Class to encapsulate all the routing-related functions.
 * @author Evan
 *
 */
class Route {
	private static $routes = array();

	public static function registerAll() {
		$files = \evan_get_plugins()->map(function(Plugin $plugin) {
			return $plugin->getPath() . "routes.php";
		})->filter(function($file) {
			return file_exists($file);
		});
		
		foreach ($files as $file) {
			self::register(require_once $file);
		}
	}
	
	public static function registerOne($route, $file) {
		self::$routes[$route] = $file;
	}
	
	private static function registerMany(array $routeMap) {
		self::$routes = \array_merge(self::$routes, $routeMap);
	}
	
	
	
	public static function route($path) {
		foreach (self::$routes as $route => $handler) {
			$inputs = self::match($route, $path);
			if (\is_array($inputs)) {
				foreach ($inputs as $key => $value) {
					\set_input($key, $value);
				}

				// Find the page handler in the plugin with the highest priority
				if (\file_exists($handler)) {
					require_once $handler;
					return false; // Prevent further routing
				}
			}
		}
	}
	
	/**
	 * @param string $route e.g. '/blog/:guid'
	 * @param string $path  e.g. '/blog/123'
	 * @return array Returns an array of inputs if the route matched the path. False otherwise.
	 */
	private static function match($route, $path) {
		// Exact match
		if ($route === $path) {
			return array(); // exact match so no named inputs
		} 
		
		// No regex, so can't be a match
		if (\strpos($route, ':') === false) {
			return false;
		}

		$routeRegEx = $route;
		$routeRegEx = \preg_replace('/:([a-z_]+_)?guid/', '([0-9]+)', $routeRegEx);
		$routeRegEx = \preg_replace('/:[a-z_]+/', '([^/]+)', $routeRegEx);
						
		$pathArgValues = array();
		$count = \preg_match("#^$routeRegEx$#", $path, $pathArgValues);
		
		if ($count) {
			// Convert to regex for matching against $path
			// E.g., /blog/:guid => /blog/([0-9]+)
			$routeArgNames = array();
			\preg_match_all("/:([a-z_]+)/", $route, $routeArgNames);
			// Get the list of plain names without leading colon
			$routeArgNames = $routeArgNames[1];
			
			// First item is the whole path, which we don't need
			\array_shift($pathArgValues);

			$result = array();
			foreach ($routeArgNames as $key => $name) {
				$result[$name] = $pathArgValues[$key];
			}
			return $result;
		}
		
		return false;
	}
}