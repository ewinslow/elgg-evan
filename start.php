<?php

// For local development
@include_once __DIR__ . "/vendor/autoload.php";

use DI\ContainerBuilder;
use ElggEntity as Entity;
use ElggObject as Object;
use ElggPlugin as Plugin;
use ElggUser as User;



function from_atom($timestamp) {	
	return date_create_from_format(DateTime::ATOM, $timestamp)->getTimestamp();
}

function to_atom($timestamp) {
	return date_create()->setTimestamp($timestamp)->format(DateTime::ATOM);
}

global $EVAN;

if (!$EVAN) {
	$builder = new ContainerBuilder();
	$builder->addDefinitions(__DIR__ . "/evan.di.php");
    $EVAN = $builder->build();
}

/**
 * This function allows you to handle various visualizations of entities very easily.
 *
 * For example, `evan_view_entity('link', $blog)` will look for views in the following order: 
 * <ol>
 * <li>object/blog/link
 * <li>object/default/link
 * <li>entity/link
 * </ol>
 * 
 * This allows you to avoid filling your views with so many if/else statements like this:
 *
 * https://github.com/Elgg/Elgg/blob/f122c12ab35f26d5b77a18cc263fc199eb2a7b01/mod/blog/views/default/object/blog.php
 *
 * @param string $view     The subview to use to visualize this this entity.
 * @param Entity $entity   The entity to visualize.
 * @param array  $vars     Extra variables to pass to the view.
 * @param string $viewtype Set this to force the viewtype.
 *
 * @return string The generated view.
 */
function evan_view_entity($view, Entity $entity, array $vars = array(), $viewtype = 'default') {
	$type = $entity->getType();
	$subtype = $entity->getSubtype();
	
	$vars['entity'] = $entity;
	
	if (elgg_view_exists("$type/$subtype/$view")) {
		return elgg_view("$type/$subtype/$view", $vars, $viewtype);
	} elseif (elgg_view_exists("$type/default/$view")) {
		return elgg_view("$type/default/$view", $vars, $viewtype);
	} else {
		return elgg_view("entity/$view", $vars, $viewtype);
	}
}


function evan_user_can($verb, Entity $object, Entity $target = NULL) {
	switch ($verb) {
		case 'post':
			if (!$target) {
				$target = elgg_get_logged_in_user_entity();
			}
			
			$result = $target->canWriteToContainer(0, $object->getType(), $object->getSubtype());
			break;
		case 'update':
			$result = $object->canEdit();
			break;
		default:
			$result = false;
			break;
	}

	return elgg_trigger_plugin_hook("permission", $verb, array(
		'actor' => elgg_get_logged_in_user_entity(),
		'verb' => $verb,
		'object' => $object,
		'target' => $target,
	), $result);
}

elgg_register_event_handler('init', 'system', function() {
	elgg_extend_view("css/elgg", "css/data-icon");
	elgg_extend_view("css/elgg", "css/evan");
	elgg_extend_view("css/elgg", "css/elgg/link.css");
	
	elgg_extend_view("page/elements/head", "evan/user", 2);
});
