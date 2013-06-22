define(function(require) {
	var angular = require('angular');
	var moment = require('moment');
	
	var id = 'elggEcho';
	var module = id + 'Filter';
	var deps = [];
	
	return angular.module(module, deps).filter(id, function() {
		return function(dateString) {
			return moment(new Date(dateString)).fromNow();
		};
	});
});
