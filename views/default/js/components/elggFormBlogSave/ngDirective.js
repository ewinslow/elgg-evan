define(function(require) {
	return function() {
		return {
			restrict: 'E',
			replace: true,
			scope: {
				blog: '=',
			},
			controller: require('./Controller'),
			template: require('text!./template.html'),
		};
	};
});
