<?php

$plugin_root = dirname(__DIR__);

// Initializes $CONFIG;
require_once "$plugin_root/Elgg/engine/settings.example.php";

// Bare minimum of engine needed to run tests
require_once "$plugin_root/Elgg/engine/lib/elgglib.php";

// Mocked elgg_normalize_url required for ElggMenuItem
function elgg_normalize_url($url) {
	return $url;
}

elgg_register_classes("$plugin_root/classes");
