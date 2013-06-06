<?php

$image = get_entity(get_input('guid'));

if (!$image) {
	header("Status: 404 Not Found");
}

$album = $image->getContainerEntity();

$nextImage = $album->getNextImage($image->getGUID());
$prevImage = $album->getPreviousImage($image->getGUID());

$imageJson = elgg_get_object_proto($image);
$imageJson['album'] = array(
	'index' => $album->getIndex($image->getGUID()),
	'totalItems' => $album->getSize(),
);

if ($nextImage) {
	$imageJson['next'] = array(
		'displayName' => $nextImage->getTitle(),
		'url' => $nextImage->getUrl(),
	);
}

if ($prevImage) {
	$imageJson['prev'] = array(
		'displayName' => $prevImage->getTitle(),
		'url' => $prevImage->getUrl(),
	);
}

echo json_encode($imageJson);
