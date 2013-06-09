define(function(require) {
	
	require('css!./styles');
	
	var angular = require('angular');
	var moment = require('moment');
	
	var directive = 'elggFriendlyTime';
	var module = directive + 'Directive';
	var deps = [];
	
	return angular.module(module, deps).directive(directive, function() {
		return {
			restrict: 'A',
			link: function($scope, $element, $attrs) {
				var datetime = moment($attrs.datetime);
				if (datetime) {
					$element.html(datetime.fromNow());
					$element.attr('title', datetime.format('LLLL'));
				}
	
				$element.addClass('elgg-timestamp');
				// TODO(ewinslow): Auto-updates
			}
		};
	});
});