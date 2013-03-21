<?php 
// URL: /entity.json

header("Content-type: application/json");

$guid = (int)get_input('guid');
$entity = get_entity($guid);

if ($entity) {
	echo json_encode(elgg_get_object_proto($entity));
} else {
	header('Status: 404 Not Found');
}