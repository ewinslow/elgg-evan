<?php 
// URL: /:guid/comments.json

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/engine/start.php';

header("Content-type: application/json");

$guid = (int)get_input('guid');
$created_before = from_atom(get_input('created_before'));
$limit = (int)get_input('limit', 50);

$comments_json = array(
	'items' => array(),
);

$comments = elgg_get_annotations(array(
	'annotation_created_time_upper' => $created_before - 1, // -1 because Elgg does <= and we want <
	'annotation_name' => 'generic_comment',
	'guid' => $guid,
	'limit' => $limit,
));

foreach ($comments as $comment) {
	$comments_json['items'][] = elgg_get_comment_proto($comment);
}

echo json_encode($comments_json);