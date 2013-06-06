<?php 
// URL: /:guid/likes.json

header("Content-type: application/json");

$guid = (int)get_input('guid');
$limit = (int)get_input('limit', 50);

$likes_json = array(
	'items' => array(),
);

$likes = get_entity($guid)->getAnnotations('likes', 0);
foreach ($likes as $like) {
	$likes_json['items'][] = elgg_get_person_proto($like->getOwnerEntity());
}

$likes_json['totalItems'] = elgg_get_annotations(array(
	'annotation_name' => 'likes',
	'guid' => $guid,
	'limit' => $limit,
	'count' => true,
));

echo json_encode($likes_json);