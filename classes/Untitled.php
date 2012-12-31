<?php

$db->entities->query(array(
    'time_created' => array('<=', 1234567890),
))

$db->getEntities()
    ->where('time_created', '<=', 1234567890)
    ->where(')