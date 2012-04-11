<?php 

class EvanRoute {
	private static $routes = array();

	private static function register($route, $handler) {
		self::$routes[$route] = $handler;	
	}
	
	private static function registerAll(array $routeMap) {
		self::$routes += $routeMap;
	}
	
	public static function registerFromFile($path) {
		$routeMap = require_once $path;
		if (is_array($routeMap)) {
			self::registerAll($routeMap);
		}
	}
	
	public static function getUrl($handler, $vars) {
		throw new Exception();
	}
}