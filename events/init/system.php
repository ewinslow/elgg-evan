<?php

elgg_register_admin_menu_item('administer', 'browse', 'users');

// Experimental manifest-based configuration!!
$manifest = json_decode(file_get_contents(dirname(dirname(__DIR__)) . "/manifest.json"), true);

// Register scripts based on manifest
foreach ($manifest['scripts'] as $name => $options) {
	elgg_register_js($name, (array)$options);
}

// Some scripts must still be registered dynamically
elgg_register_js('elgg', array(
	'src' => elgg_get_simplecache_url('js', 'elgg')
));


// Register view options like extensions, caching, ajax, etc.
foreach ($manifest['views'] as $view => $options) {
	foreach ($options['extensions'] as $extension => $priority) {
		if ($priority === false) {
			elgg_unextend_view($view, $extension);
		} else {
			elgg_extend_view($view, $extension, $priority);
		}
	}
	
	if (isset($options['ajax'])) {
		if ($options['ajax']) {
			elgg_register_ajax_view($view);
		} else {
			elgg_unregister_ajax_view($view);
		}
	}
	
	if (isset($options['cache']) && $options['cache']) {
		elgg_register_simplecache_view($view);
	}
}