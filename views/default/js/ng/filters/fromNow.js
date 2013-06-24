define(function(require) {
	var angular = require('angular');
	var moment = require('moment');
	
	return angular.module('fromNowFilter', []).filter('fromNow', function() {
		return function(dateString) {
			return moment(new Date(dateString)).fromNow();
		};
	});
});
