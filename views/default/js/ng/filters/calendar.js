define(function(require) {
	var angular = require('angular');
	var moment = require('moment');
	
	return angular.module('calendarFilter', []).filter('calendar', function() {
		return function(dateString) {
			return moment(new Date(dateString)).calendar();
		};
	});
});
