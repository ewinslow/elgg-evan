<?php
// URL: /activity-json?published_before=$before

header("Content-type: application/json");

$published_before = strtotime(get_input('published_before', to_atom(time())));

$options = array(
	'action_type' => 'create',
	'type' => 'object',
	'subtypes' => array('blog', 'album', 'thewire'),
	'posted_time_upper' => $published_before - 1,
	'limit' => 5,
);

$activities = elgg_get_river($options);

$options['count'] = true;

$totalItems = elgg_get_river($options);

$collection_json = array(
	'totalItems' => $totalItems,
	'items' => array(),
	'links' => array(
		'next' => null,
	),
);

if (count($activities) != $totalItems) {
	$first_published = to_atom($activities[count($activities) - 1]->posted);
	$collection_json['links']['next'] = array(
		'href' => elgg_normalize_url("/activity-json?published_before=" . urlencode($first_published))
	);
}

foreach ($activities as $activity) {
	
	$activity_json = array(
		'published' => to_atom($activity->posted),
		'title' => elgg_view('river/elements/summary', array('item' => $activity)),
		'actor' => elgg_get_person_proto($activity->getSubjectEntity()),
		'object' => elgg_get_object_proto($activity->getObjectEntity()),
		'target' => elgg_get_object_proto($activity->getObjectEntity()->getContainerEntity()),
	);
	
	$collection_json['items'][] = $activity_json;
}

echo json_encode($collection_json);
