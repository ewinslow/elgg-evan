define(function(require) {

	require('css!./styles');
	require('css!components/elggAjaxLoader/styles');
	require('css!components/elggButton/styles');
	require('css!components/elggIcon/styles');
	require('css!components/elggImageBlock/styles');

	require('ng/module/ngSanitize');

	var angular = require('angular');
	
	var deps = [
		require('components/elggAvatar/ngModule').name,
		require('components/elggFriendlyTime/ngModule').name,
		require('ng/filter/elggEcho').name,
		require('ng/service/elgg').name,
		'ngSanitize' //ng-bind-html
	];
	
	var id = 'elggComments';
	var module = id + 'Directive';
	return angular.module(module, deps).directive(id, function() {
		return {
			restrict: 'E',
			replace: true,
			scope: {
				entity: '='
			},
			template: require("text!./template.html"),
			controller: require('./Controller')
		};
	});
});
