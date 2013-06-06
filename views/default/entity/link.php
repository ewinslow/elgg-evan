<?php

/** @var ElggEntity $entity */
$entity = $vars['entity'];
unset($vars['entity']);

$defaults = array(
	'text' => isset($entity->name) ? $entity->name : $entity->title,
	'href' => $entity->getUrl(),
	'encode_text' => true,
	'is_trusted' => true,
);

echo elgg_view('output/url', array_merge($defaults, $vars));