define(function(require) {
	var moment = require('moment');
	
	return function() {
		return function(dateString) {
			return moment(new Date(dateString)).fromNow();
		};
	};
});
