define(function(require) {

	// require('css!./styles');

	var angular = require('angular');
	
	var id = 'elggAvatar';
	var module = id + 'Directive';
	var deps = [];
	
	return angular.module(module, deps).directive(id, function() {
		return {
			restrict: 'E',
			replace: true,
			scope: {
				entity: '='
			},
			template: require("text!./template.html"),
			link: function($scope, $element, $attrs) {
				var size = $attrs.size || 'small';
				
				$element.addClass('elgg-avatar-' + size);
			}
		};
	});
});
