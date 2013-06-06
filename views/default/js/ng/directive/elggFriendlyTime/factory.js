define(function(require) {
	return function(moment) {
		return function($scope, $element, $attrs) {
			var datetime = moment($attrs.datetime);
			if (datetime) {
				$element.html(datetime.fromNow());
				$element.attr('title', datetime.format('LLLL'));
			}

			$element.addClass('elgg-timestamp');
			// TODO(ewinslow): Auto-updates
		};
	};
});
