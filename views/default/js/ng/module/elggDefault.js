define(function(require) {
	var angular = require('angular');
	
	return angular.module('elggDefault', [
		require('components/elggComments/ngModule').name,
	]);
});