<?php

$entity = $vars['entity'];
$size = $vars['size'];
unset($vars['entity']);
unset($vars['size']);

echo elgg_view_entity_icon($entity, $size, $vars);