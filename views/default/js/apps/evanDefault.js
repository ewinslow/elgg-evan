// This is what a typical bootstrapper looks like for async angularjs apps.
define('apps/evanDefault', function(require) {
	var angular = require('angular');
	
	var ngModule = angular.module('evanDefaultApp', [
		require('components/elggComments/ngModule').name,
		require('routes/site/activity/ngDeps').name
	]);
	
	ngModule.config(function($locationProvider) {
		$locationProvider.html5Mode(true);
	});
	
	ngModule.config(function($routeProvider) {
		$routeProvider.when('/activity', require('routes/site/activity/ngRoute'));
	});
	
	angular.bootstrap(document, [ngModule.name]);
	
	// Is this necessary? Nothing should depend on this module
	return ngModule;
});

// Force it to always run to ensure angular.bootstrap gets called.
require(['apps/evanDefault']);
