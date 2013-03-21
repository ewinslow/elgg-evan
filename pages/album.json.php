<?php 

header("Content-type: application/json");

$album = get_entity(get_input('guid'));

$albumJson = elgg_get_object_proto($album);

$albumJson['items'] = array();

$images = $album->getImages(50);

foreach ($images as $image) {
	$albumJson['items'][] = elgg_get_object_proto($image);
}

echo json_encode($albumJson);
