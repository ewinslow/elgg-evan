define(function(require) {
	require('angular-sanitize');
	
	var angular = require('angular');
	
	var deps = [
		require('ng/services/evanDatabase').name,
		require('components/elggFormBlogSave/ngModule').name,
		'ngSanitize',
	];
	
	return angular.module('blogEditRouteDeps', deps);	
});