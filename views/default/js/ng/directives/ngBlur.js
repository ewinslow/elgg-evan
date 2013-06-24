// TODO: Remove once angular includes these directives natively.
define(function(require) {
	var angular = require('angular');
	
	return angular.module('ngBlurDirective', []).directive('ngBlur', function() {
		return {
			restrict: 'A',
			link: function($scope, $element, $attrs) {
				$element.blur(function() {
					$scope.$apply($attrs.ngBlur);
				});
			}
		};
	});
});