<?php

$entity = $vars['entity'];

?>

<?php echo elgg_echo('byline', array(evan_view_entity('link', $entity->getOwnerEntity()))); ?>

<?php echo elgg_view_friendly_time($entity->time_created); ?>