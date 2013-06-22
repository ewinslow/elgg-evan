/**
 * This is my angularized walled-garden equivalent.
 * The page shell for this app is located at the "page/evanExternal" view.
 */

define('apps/evanExternal', function(require) {
	var angular = require('angular');
	
	var deps = [
		require('routes/user/login2/ngModule').name	
	];
	
	return angular.module('evanExternalApp', deps).config(function($locationProvider) {
		$locationProvider.html5Mode(true);
	}).config(function($routeProvider) {
		$routeProvider.otherwise({
			redirectTo: function() { 
				window.location.reload();
			}
		});

	});
});

// This is what a typical bootstrapper looks like for async angularjs apps.
require(['angular', 'apps/evanExternal'], function(angular, app) {
	angular.bootstrap(document, [app.name]);
});
