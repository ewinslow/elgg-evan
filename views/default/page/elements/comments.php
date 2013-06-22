<?php
/**
 * List comments with optional add form
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['show_add_form'] Display add form or not
 * @uses $vars['id']            Optional id for the div
 * @uses $vars['class']         Optional additional class for the div
 */

elgg_require_js('apps/elggDefault');

$entity = $vars['entity'];

$attributes = array(
	'id' => $vars['id'],
	'class' => "elgg-comments {$vars['class']}",
	'data-entity' => $entity->getGUID(),
);

?>

<elgg-comments <?php echo elgg_format_attributes($attributes); ?>></elgg-comments>
