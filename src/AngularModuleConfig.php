<?php
namespace Evan;


class AngularModuleConfig {

	private $name;

	private $deps = array();

	private $directives = array();

	private $filters = array();
	
	private $values = array();

	private $services = array();

	private $factories = array();
	
	private $routes = array();

	function __construct($name) {
		$this->name = $name;
	}

	function getName() {
		return $this->name;
	}

	
	function registerDirective($directive) {
		$this->directives[$directive] = true;
		return $this;
	} 

	function getDirectives() {
		return array_keys($this->directives);
	}

	
	
	function registerFilter($filter) {
		$this->filters[$filter] = true;
		return $this;
	}

	function getFilters() {
		return array_keys($this->filters);
	}

	

	function registerValue($service, $value) {
		$this->values[$service] = $value;
		return $this;
	}

	function getValues() {
		return $this->values;
	}

	function registerService($service, $constructor) {
		$this->services[$service] = $constructor;
		return $this;
	}

	function getServices() {
		return $this->services;
	}

	function registerFactory($service) {
		$this->factories[$service] = true;
		return $this;
	}

	function getFactories() {
		return array_keys($this->factories);
	}

	function registerRoutes(array $routes) {
		$this->routes = array_merge($this->routes, $routes);
		return $this;
	}

	function getRoutes() {
		return $this->routes;
	}

	
	
	function registerDep($dep) {
		$this->deps[$dep] = true;
		return $this;
	}

	function unregisterDep($dep) {
		unset($this->deps[$dep]);
		return $this;
	}

	function getDeps() {
		return array_keys($this->deps);
	}
}
