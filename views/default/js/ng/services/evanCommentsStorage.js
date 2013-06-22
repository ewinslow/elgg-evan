define(function(require) {
	var angular = require('angular');
	var CommentsStorage = require('evan/CommentsStorage');
	
	var id = 'evanCommentsStorage';
	var module = id + 'Service';
	var deps = [
		require('ng/services/elgg').name	
	];

	return angular.module(module, deps).service(id, CommentsStorage);
});