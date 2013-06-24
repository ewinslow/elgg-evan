define(function(require) {
	var angular = require('angular');
	var evanUser = JSON.parse(document.getElementById('evanUser').innerHTML);
	return angular.module('evanUserService', []).value('evanUser', evanUser);
});