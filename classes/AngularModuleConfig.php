<?php

class AngularModuleConfig {

	private $name;

	private $deps = array();

	private $directives = array();

	private $filters = array();
	
	private $values = array();

	private $services = array();

	private $factories = array();

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

	function registerFactory($service, $factory) {
		$this->factories[$service] = $factory;
		return $this;
	}

	function getFactories() {
		return $this->factories;
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
