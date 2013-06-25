define(function(require) {
	require('angular-sanitize');
	
	var angular = require('angular');
	
	var deps = [
		require('ng/filters/elggEcho').name,
	];
	
	return angular.module('blogViewRouteDeps', deps);	
});