<?php 
/**
 * Using this plugin for routing is much different and much simpler than core Elgg.
 * 
 * To declare routes:
 *  * Add a routes.php file to your plugin's root, and
 *  * From that file, return a map of routes to handlers like so:
 * 
 *        return array(
 *            '/blog' => 'blog/index',
 *        );
 * 
 * It's important that all your routes begin with a slash (`/`) character. This is just to make it obvious which side
 * is the handler and which side is the url matcher.
 * 
 * On the left side we have the route to look for -- this is compared against the url. If a match is found, we look
 * for a handler file in pages/$handler.php, so in this case it would be pages/blog/index.php. This file is expected to
 * return an array that will seed the $vars of the view that is called. The view is evan/pages/$handler, so in this case
 * the view would be evan/pages/blog/index.
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
				system_message("Registering routes for $plugin plugin");
				self::register(require_once $file);
			}
		}
	}
	
	public static function register(array $routeMap) {
		self::$routes += $routeMap;
	}
	
	public static function route($path) {
		system_message("Routing... $path");
		system_message(count(self::$routes) . " routes to check");
		foreach (self::$routes as $route => $handler) {
			if (self::matches($route, $path)) {
				foreach (array_reverse(evan_get_plugins()) as $plugin) {
					$file = elgg_get_plugins_path() . "$plugin/pages/$handler.php";
					if (file_exists($file)) {
						$vars = require_once $file;
						$vars['title'] = elgg_echo("evan/pages/$handler/title");
						$vars['description'] = elgg_echo("evan/pages/$handler/description");
						echo elgg_view("evan/pages/$handler", $vars);
						return false; // Prevent further routing
					}
				}
		
			}
		}
	}
	
	private static function matches($route, $path) {
		system_message("Does `$route` match `$path`?");
		return $route === $path;
	}
}