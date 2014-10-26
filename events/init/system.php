<?php
use ElggPlugin as Plugin;

elgg_register_admin_menu_item('administer', 'browse', 'users');

$manifests = evan_get_plugins()->map(function(Plugin $plugin) {
	return $plugin->getPath() . "elgg.json";
})->filter(function($file) {
	return file_exists($file);
})->map(function($filepath) {
	// Experimental manifest-based configuration!!
	$manifest = json_decode(file_get_contents($filepath), true);
	
	if (!$manifest) {
		throw new Exception("$plugin plugin's elgg.json was invalid or unreadable!");
	}

	return $manifest;	
});

foreach ($manifests as $manifest) {
	
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
}