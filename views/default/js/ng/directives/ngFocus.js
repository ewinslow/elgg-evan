// Remove once angular includes these directives natively.
define(function(require) {
	var angular = require('angular');
	
	return angular.module('ngFocusDirective', []).directive('ngFocus', function() {
		return {
			restrict: 'A',
			link: function($scope, $element, $attrs) {
				$element.focus(function() {
					$scope.$apply($attrs.ngFocus);
				});
			}
		};
	});
});