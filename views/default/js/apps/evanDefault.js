// This is what a typical bootstrapper looks like for async angularjs apps.
define('apps/evanDefault', function(require) {
	var angular = require('angular');
	
	var ngModule = angular.module('evanDefaultApp', [
		require('routes/site/activity/ngDeps').name,
		require('routes/blog/view/ngDeps').name,
		require('routes/blog/edit/ngDeps').name,
		require('routes/blog/add/ngDeps').name,
	]);
	
	ngModule.config(function($locationProvider) {
		$locationProvider.html5Mode(true);
	});
	
	ngModule.config(function($routeProvider) {
		$routeProvider.when('/activity', {
			templateUrl: require.toUrl('routes/site/activity/template.html'),
			controller: require('routes/site/activity/Controller'),
			resolve: require('routes/site/activity/Controller').$resolve,
		});
		$routeProvider.when('/blog/view/:guid', {
			templateUrl: require.toUrl('routes/blog/view/template.html'),
			controller: require('routes/blog/view/Controller'),
			resolve: require('routes/blog/view/Controller').$resolve,
		});
		$routeProvider.when('/blog/view/:guid/:title', {
			templateUrl: require.toUrl('routes/blog/view/template.html'),
			controller: require('routes/blog/view/Controller'),
			resolve: require('routes/blog/view/Controller').$resolve,
		});
		$routeProvider.when('/blog/add/:container_guid', {
			templateUrl: require.toUrl('routes/blog/add/template.html'),
			controller: require('routes/blog/add/Controller'),
			resolve: require('routes/blog/add/Controller').$resolve,
		});
		$routeProvider.when('/blog/edit/:guid', {
			templateUrl: require.toUrl('routes/blog/edit/template.html'),
			controller: require('routes/blog/edit/Controller'),
			resolve: require('routes/blog/edit/Controller').$resolve,
		});
		$routeProvider.when("/photos/add/:container_guid", {
			templateUrl: require.toUrl('routes/photos/add/template.html'),
			controller: require('routes/photos/add/Controller'),
			resolve: require('routes/photos/add/Controller').$resolve,
		});
		$routeProvider.when("/photos/album/:guid/:title", {
			templateUrl: require.toUrl('routes/photos/album/template.html'),
			controller: require('routes/photos/album/Controller'),
			resolve: require('routes/photos/album/Controller').$resolve,
		});
		$routeProvider.when('/photos/all', {
			templateUrl: require.toUrl('routes/photos/all/template.html'),
			controller: require('routes/photos/all/Controller'),
			resolve: require('routes/photos/all/Controller').$resolve,
		});
		$routeProvider.when("/photos/image/:guid/:title", {
			templateUrl: require.toUrl('routes/photos/image/template.html'),
			controller: require('routes/photos/image/Controller'),
			resolve: require('routes/photos/image/Controller').$resolve,
		});
		$routeProvider.when("/photos/owner/:alias", {
			templateUrl: require.toUrl('routes/photos/owner/template.html'),
			controller: require('routes/photos/owner/Controller'),
			resolve: require('routes/photos/owner/Controller').$resolve,
		});
		$routeProvider.otherwise({
			redirectTo: function() {
				window.location.reload(); // Careful of infinite loops!
			}
		});
	});
	
	angular.bootstrap(document, [ngModule.name]);
	
	// Is this necessary? Nothing should depend on this module
	return ngModule;
});

// Force it to always run to ensure angular.bootstrap gets called.
require(['apps/evanDefault']);
