/**
 * We can't define the routes explicitly because we don't want to make plugins
 * have to configure routes in two places. This is a way that we can 
 * bundle the dependencies of this Controller/template/resolve combo without
 * also defining the route.
 */
define(function(require) {
	var angular = require('angular');
	
	return angular.module('siteActivityRouteDeps', [
		require('ng/services/evanDatabase').name,
		require('ng/services/evanUser').name,
		require('components/elggRiverItem/ngModule').name
	]);
});