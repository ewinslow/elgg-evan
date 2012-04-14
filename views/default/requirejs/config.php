<script>
/**
 * Defines some modules to be reused so they can be refactored transparently later on.
 */

define('jquery', function() { return jQuery; });
define('elgg', function() { return elgg; });
define('elgg/ElggEntity', function() { return elgg.ElggEntity; });
define('elgg/ElggUser', function() { return elgg.ElggUser; });
define('elgg/ElggPriorityList', function() { return elgg.ElggPriorityList; });
define('elgg/i18n', function() { return elgg.echo; });
define('elgg/ui', function() { return elgg.ui; });
define('elgg/ui/widgets', function() { return elgg.ui.widgets; });

require.config({
	paths: {
		'text': '/mod/evan/vendors/requirejs-1.0.7/text.min',
		'elgg/evan/admin': '/mod/evan/js/evan/admin'
	},
});

require(['elgg/evan/admin'], function() {});

</script>