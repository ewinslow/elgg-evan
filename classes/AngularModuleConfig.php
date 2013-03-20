<?php

class AngularModuleConfig {

	private $name;

	private $deps = array();

	private $directives = array();

	private $filters = array();

	private $services = array();

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

	function unregisterDirective($directive) {
		unset($this->directives[$directive]);
		return $this;
	}

	function getDirectives() {
		return array_keys($this->directives);
	}

	
	
	function registerFilter($filter) {
		$this->filters[$filter] = true;
		return $this;
	}

	function unregisterFilter($filter) {
		unset($this->filters[$filter]);
		return $this;
	}

	function getFilters() {
		return array_keys($this->filters);
	}

	
	
	function registerService($service) {
		$this->services[$service] = true;
		return $this;
	}

	function unregisterService($service) {
		unset($this->services[$service]);
		return $this;
	}

	function getServices() {
		return array_keys($this->services);
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
