<?php 
// URL: /:guid/comments.json

header("Content-type: application/json");

$guid = (int)get_input('guid');
$created_before = from_atom(get_input('published_before', to_atom(time())));
$limit = (int)get_input('limit', 50);

$comments_json = elgg_get_comments_proto(get_entity($guid));

echo json_encode($comments_json);