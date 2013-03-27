<?php
header("Content-type: application/json");

$albumsOptions = array(
	'type' => 'object',
	'subtype' => 'album',
);
$limit = (int)get_input('limit', 10, false);
$offset = (int)get_input('offset', 0, false);

$nextOffset = $offset + $limit;


$albumsOptions['count'] = true;

$count = elgg_get_entities($albumsOptions);

$albumsJson = array(
	'totalItems' => $count,
	'items' => array(),
	'links' => array(
		'next' => NULL,
	),
);

if ($nextOffset < $albumsJson['totalItems']) {
	$albumsJson['links']['next'] = array(
		'href' => "albums-json?offset=$nextOffset",
	);
}

$albumsOptions['count'] = false;
$albumsOptions['limit'] = $limit;
$albumsOptions['offset'] = $offset;

$albums = elgg_get_entities($albumsOptions);

foreach ($albums as $album) {
	$albumsJson['items'][] = elgg_get_object_proto($album);
}



echo json_encode($albumsJson);
