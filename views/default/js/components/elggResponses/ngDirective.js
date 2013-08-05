define(function(require) {
	/**
	 * @ngInject
	 */
	return function() {
		return {
			restrict: 'A',
			replace: true,
			scope: {
				object: '='
			},
			template: require("text!./template.html"),
			controller: require('./Controller'),
			controllerAs: 'ctrl'
		};
	};
});