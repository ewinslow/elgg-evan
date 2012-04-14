define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	
	function isClickAjaxable(event) {
		return event.target.href && !event.metaKey && !event.ctrlKey && isSameOrigin(location, event.target);
	}
	
	function isSameOrigin(url1, url2) {
		return url1.hostname == url2.hostname &&
               url1.protocol == url2.protocol &&
               url1.port == url2.port;
	}
	
	$('a').live('click', function(event) {
		if (isClickAjaxable(event)) {
			return elgg.trigger_hook('navigate', 'window', event, true);
		}
	});
	
	elgg.register_hook_handler('navigate', 'window', function(hook, type, event, result) {
		if (event.target.pathname.indexOf('/admin/statistics/') === 0) {
			var contentUrl = elgg.config.wwwroot + 'ajax/view' + event.target.pathname + '?' + new Date();
			require(['text!' + contentUrl, 'elgg/i18n'], function(content, i18n) {
				var segments = event.target.pathname.split('/');
				segments.shift();
				segments.shift();
				alert('hallo');
				$('.elgg-main').html(content).prepend(
					'<div class="elgg-head"><h2>' + 
					i18n('admin:' + segments[0]) + ' : ' + i18n('admin:' + segments.join(':')) + 
					'</h2></div>');
				window.history.pushState({}, '', event.target.href);
			});
			
			return false;
		}
	});
});