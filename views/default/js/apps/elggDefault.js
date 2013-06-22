define('apps/elggDefault', function(require) {
	var angular = require('angular');
	
	return angular.module('elggDefault', [
		require('components/elggComments/ngModule').name,
	]);
});

// This is what a typical bootstrapper looks like for async angularjs apps.
require(['angular', 'apps/elggDefault'], function(angular, app) {
	angular.bootstrap(document, [app.name]);
});
