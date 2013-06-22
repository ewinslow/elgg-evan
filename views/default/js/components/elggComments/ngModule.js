define(function(require) {

	// require('css!./styles');
	// require('css!components/elggAjaxLoader/styles');
	// require('css!components/elggButton/styles');
	// require('css!components/elggIcon/styles');
	// require('css!components/elggImageBlock/styles');
	require('angular-sanitize'); // for ng-bind-html

	var angular = require('angular');
	
	var deps = [
		require('components/elggAvatar/ngModule').name,
		require('components/elggFriendlyTime/ngModule').name,
		require('ng/filters/elggEcho').name,
		require('ng/services/elgg').name,
		require('ng/services/evanCommentsStorage').name,
		'ngSanitize' // for ng-bind-html
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
