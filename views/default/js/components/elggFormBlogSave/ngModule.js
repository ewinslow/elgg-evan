define(function(require) {
	var angular = require('angular');
	
	var deps = [
		require('ng/services/elgg').name,
	];
	
	return angular.module('elggFormBlogSaveDirective', deps).directive('elggFormBlogSave', function() {
		return {
			restrict: 'E',
			replace: true,
			scope: {
				blog: '=',
			},
			controller: require('./Controller'),
			template: require('text!./template.html'),
		};
	});
});
