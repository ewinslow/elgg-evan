define(function(require) {
	var angular = require('angular');
	
	var deps = [
		
	];
	
	return angular.module('elggResponsesDirective', deps).directive('elggResponses', function() {
		return {
			restrict: 'A',
			replace: true,
			scope: {
				object: '='
			},
			template: require("text!./template.html"),
			controller: require('./Controller'),
		};
	});
});
