<?php

$id = get_input('id');

$plugin = elgg_get_plugin_from_id($id);

if ($plugin) {
	echo json_encode(elgg_get_plugin_proto($plugin));
} else {
	header("Status: 404 Not Found");
}