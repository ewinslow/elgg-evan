<?php

elgg_load_js('elgg/composer');

$target = elgg_extract('target', $vars, elgg_get_logged_in_user_entity());
$menu = elgg_view_menu('composer', array(
	'target' => $target,
	'class' => 'elgg-menu-hz',
	'sort_by' => 'priority',
));

if (!$menu) {
	return true;
}

?>

<div class="elgg-composer">
	<h4><?php echo elgg_echo('composer:prompt'); ?></h4>
	<?php echo $menu; ?>
</div>