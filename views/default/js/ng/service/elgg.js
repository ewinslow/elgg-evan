define(function(require) {
	var angular = require('angular');
	var elgg = require('elgg');
	
	var id = 'elgg';
	var module = id + 'Service';
	var deps = [];

	return angular.module(module, deps).value(id, elgg);
});