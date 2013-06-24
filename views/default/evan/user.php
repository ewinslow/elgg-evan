<?php

if (!elgg_is_logged_in()) {
	return true;
}

$user = elgg_get_logged_in_user_entity();
$json = json_encode(elgg_get_person_proto($user));

echo "<script type='application/json' id='evanUser'>$json</script>";
