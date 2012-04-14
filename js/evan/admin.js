define(function() {
	function isClickAjaxable(event) {
		return event.target.href && !event.metaKey && !event.ctrlKey &&
		       location.host == event.target.host &&
		       location.protocol == event.target.protocol &&
		       location.port == event.target.port;
	}
	
	$('a').live('click', function(event) {
		if (isClickAjaxable(event)) {
			return elgg.trigger_hook('navigate', 'window', event, true);
		}
	});
});