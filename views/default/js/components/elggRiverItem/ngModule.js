define(function(require) {
	require('angular-sanitize');
	
	var angular = require('angular');
	
	var deps = [
		require('ng/filters/calendar').name,
		require('ng/filters/fromNow').name,
		require('components/elggResponses/ngModule').name,
		'ngSanitize', // ng-bind-html
	];
	
	return angular.module('elggRiverItemDirective', deps).directive('elggRiverItem', function() {
		return {
			restrict: 'A',
			replace: true,
			template: require("text!./template.html"),
			controller: require('./Controller'),
			scope: {
				'activity': '='
			}
		};
	});
});
