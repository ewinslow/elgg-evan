define(function(require) {
	var angular = require('angular');

	var deps = [];

	return angular.module('userLogin2Route', deps).config(function($routeProvider) {
		$routeProvider.when('/login2', {
			controller: require('./Controller'),
			template: require('text!./template.html')
		});
	});
});