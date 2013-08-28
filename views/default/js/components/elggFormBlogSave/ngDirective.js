define(function(require) {
	return function() {
		return {
			restrict: 'E',
			replace: true,
			scope: {
				blog: '=',
			},
			controller: require('./Controller'),
			templateUrl: require.toUrl('./template.html'),
		};
	};
});
