<?php 
/**
 * Using this plugin for routing is much different and much simpler than core Elgg.
 * 
 * To declare routes, add a routes.php file to your plugin's root that returns a map of routes to handlers like so:
 * 
 *     return array(
 *         '/blog' => 'blog/index',
 *     );
 * 
 * It's important that all your routes begin with a slash (`/`) character. This is just to make it obvious which side
 * is the handler and which side is the url matcher.
 * 
 * On the left side we have the route to look for -- this is compared against the url. If a match is found, we look
 * for a handler file in pages/$handler.php, so in this case it would be pages/blog/index.php. This file is expected to
 * return an array that will seed the $vars of the view that is called. The view is page/$handler, so in this case
 * the view would be page/blog/index.
 * 
 * In addition to exact matches, you can define routes that pass named parameters as input to the handlers.
 * 
 *     return array(
 *         '/blog/:guid' => 'blog/view',
 *     )
 * 
 * This will pass the input "guid" to the "blog/view" handler. You can use arbitrary names after the colon to define
 * inputs (e.g., :my_cool_input), but the framework recognizes some as special:
 * 
 *  * `guid` and anything that ends in `_guid` will only match integers.
 *  * More to come...
 */

/**
 * Class to encapsulate all the routing-related functions.
 * @author Evan
 *
 */
class EvanRoute {
	private static $routes = array();

	public static function registerAll() {
		foreach (evan_get_plugins() as $plugin) {
			$file = elgg_get_plugins_path() . "$plugin/routes.php";
			if (file_exists($file)) {
				self::register(require_once $file);
			}
		}
	}
	
	public static function register(array $routeMap) {
		self::$routes = array_merge(self::$routes, $routeMap);
	}
	
	public static function route($path) {
		foreach (self::$routes as $route => $handler) {
			$inputs = self::match($route, $path);
			if (is_array($inputs)) {
				foreach ($inputs as $key => $value) {
					set_input($key, $value);
				}

				foreach (array_reverse(evan_get_plugins()) as $plugin) {
					$file = elgg_get_plugins_path() . "$plugin/pages/$handler.php";
					if (file_exists($file)) {
						echo elgg_view("page/$handler", require_once $file);
						return false; // Prevent further routing
					}
				}
		
			}
		}
	}
	
	/**
	 * 
	 * @param string $route e.g. '/blog/:guid'
	 * @param string $path  e.g. '/blog/123'
	 * @return boolean Returns true if the route matched the path.
	 */
	private static function match($route, $path) {
		// Exact match
		if ($route === $path) {
			return true;
		} 
		
		// No regex, so can't be a match
		if (strpos($route, ':') === false) {
			return false;
		}

		$routeRegEx = $route;
		$routeRegEx = preg_replace('/:([a-z_]+_)?guid/', '([0-9]+)', $routeRegEx);
		$routeRegEx = preg_replace('/:[a-z_]+/', '([^/]+)', $routeRegEx);
						
		$pathArgValues = array();
		$count = preg_match("#^$routeRegEx$#", $path, $pathArgValues);
		
		if ($count) {
			// Convert to regex for matching against $path
			// E.g., /blog/:guid => /blog/([0-9]+)
			$routeArgNames = array();
			preg_match_all("/:([a-z_]+)/", $route, $routeArgNames);
			// Get the list of plain names without leading colon
			$routeArgNames = $routeArgNames[1];
			
			// First item is the whole path, which we don't need
			array_shift($pathArgValues);

			$result = array();
			foreach ($routeArgNames as $key => $name) {
				$result[$name] = $pathArgValues[$key];
			}
			return $result;
		}
		
		return false;
	}
}