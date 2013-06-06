define(function(require) {
	return function(moment) {
		return function(dateString) {
			return moment(new Date(dateString)).calendar();
		};
	};
});
