define(function() {
	return function($window) {
		return JSON.parse($window.document.getElementById('evanUser').innerHTML);
	};
});