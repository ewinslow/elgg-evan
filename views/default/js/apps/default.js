define('apps/default', function(require) {
	var angular = require('angular');
	
	return angular.module('defaultApp', [
		require('components/elggComments/ngModule').name,
	]);
});

// This is what a typical bootstrapper looks like for async angularjs apps.
require(['angular', 'apps/default'], function(angular, app) {
	angular.bootstrap(document, [app.name]);
});
