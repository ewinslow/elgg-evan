define(function(require) {
	var angular = require('angular');
	var Database = require('evan/Database');
	
	return angular.module("evanDatabaseService", []).service('evanDatabase', Database);	
});