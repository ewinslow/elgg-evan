define(function(require) {
	var angular = require('angular');
	
	var id = 'elggEcho';
	var module = id + 'Filter';
	var deps = [
		require('ng/service/elgg').name	
	];
	
	return angular.module(module, deps).filter(id, function(elgg) {
		return elgg.echo;
	});
});
