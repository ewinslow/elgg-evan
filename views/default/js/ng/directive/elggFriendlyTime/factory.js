// <script>
define(function(require) {
	return function(moment) {
		return function($scope, $element, $attrs) {
			var datetime = moment($attrs.datetime);
			$element.html(datetime.fromNow());
			$element.attr('title', datetime.format('LLLL'));
			// TODO(ewinslow): Auto-updates
		};
	};
});
