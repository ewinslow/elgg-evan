define(function(require) {
	require('angular-sanitize');
	
	var angular = require('angular');
	
	var deps = [
		require('components/elggFriendlyTime/ngModule').name,
		require('components/elggResponses/ngModule').name,
		require('ng/services/elgg').name,
		require('ng/services/evanDatabase').name,
		'ngSanitize',
	];
	
	return angular.module('blogViewRouteDeps', deps);	
});