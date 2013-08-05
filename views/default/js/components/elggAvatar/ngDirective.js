define(function(require) {
	return function() {
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
	};
});
