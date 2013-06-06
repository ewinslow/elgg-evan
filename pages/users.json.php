<?php
header("Content-type: application/json");

$banned = (boolean)get_input('banned', false);
$db = new EvanDatabase();
$users = $db->getUsers()->where('banned', $banned);
$limit = (int)get_input('limit', 100, false);
$offset = (int)get_input('offset', 0, false);

$nextOffset = $offset + $limit;

$usersJson = array(
	'totalItems' => $users->getCount(),
	'items' => array(),
	'links' => array(
		'next' => NULL,
	),
);

if ($nextOffset < $usersJson['totalItems']) {
	$usersJson['links']['next'] = array(
		'href' => "users-json?offset=$nextOffset",
	);
}

foreach ($users->getItems($limit, $offset) as $user) {
	$usersJson['items'][] = elgg_get_person_proto($user);
}



echo json_encode($usersJson);
