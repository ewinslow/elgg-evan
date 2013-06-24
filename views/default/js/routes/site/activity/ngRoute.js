define(function(require) {
	return {
		template: require('text!./template.html'),
		controller: require('./Controller'),
		resolve: require('./Controller').$resolve
	};
});
