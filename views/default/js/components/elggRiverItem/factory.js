// <script>
define(function(require) {
	var $ = require('jquery');
	
	return function() {
        return {
            restrict: 'A',
            replace: true,
            template: require("text!./template.html"),
            controller: require('./Controller'),
            scope: {
	        'activity': '='
	    },
        };
    };
});
