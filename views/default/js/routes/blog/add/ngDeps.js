define(function(require) {
	var angular = require('angular');
	
	var deps = [
		require('ng/filters/elggEcho').name,
		require('components/elggFormBlogSave/ngModule').name,
	];
	
	return angular.module('blogAddRouteDeps', deps);	
});