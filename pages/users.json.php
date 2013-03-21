<?php
header("Content-type: application/json");

$db = new EvanDatabase();
$users = $db->getUsers()->where('banned', NULL);
$limit = (int)get_input('limit', 10, false);
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