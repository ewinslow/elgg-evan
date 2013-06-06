<?php
// URL: /posters.json
header("Content-type: application/json");

$postersJson = array(
	'totalItems' => null,
	'items' => array(),
	'links' => array(
		'next' => null,
		'prev' => null,
	),
);

$posters = cbcoverseas_get_posters();
foreach ($posters as $poster) {
	$postersJson['items'][] = elgg_get_person_proto($poster);
}

$postersJson['totalItems'] = count($postersJson['items']);

echo json_encode($postersJson);
