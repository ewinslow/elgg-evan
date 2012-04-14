<?php
/**
 * 
 */

/**
 *
 */
global $EVAN;

$EVAN = new stdClass;

/**
 * Keeps track of plugins registered with the framework.
 */
$EVAN->plugins = array();

// Register all active plugins for convention-based plugin hooks + events
foreach (elgg_get_plugins('active') as $plugin) {
	$EVAN->plugins[] = $plugin->getID();
}

function evan_get_plugins() {
	global $EVAN;
	return $EVAN->plugins;
}

EvanRoute::registerAll();
elgg_register_js('require', '/mod/evan/vendors/requirejs-1.0.7/require.min.js', 'footer');
elgg_load_js('require');
elgg_extend_view('page/elements/foot', 'requirejs/config');

if (elgg_is_admin_logged_in()) {
	elgg_register_ajax_view('admin/statistics/server');
	elgg_register_ajax_view('admin/statistics/overview');
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
 * @param string     $view     The subview to use to visualize this this entity.
 * @param ElggEntity $entity   The entity to visualize.
 * @param array      $vars     Extra variables to pass to the view.
 * @param string     $viewtype Set this to force the viewtype.
 *
 * @return string The generated view.
 */
function evan_view_entity($view, ElggEntity $entity, array $vars = array(), $viewtype = 'default') {
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


/**
 * This function makes it possible to register for hooks using directory structure conventions.
 */
function evan_plugin_hook_handler($hook, $type, $return, $params) {
	foreach (evan_get_plugins() as $plugin) {
		$file = elgg_get_plugins_path() . "$plugin/hooks/" . str_replace(':', '/', "$hook/$type.php");
		if (file_exists($file)) {
			$result = include $file;
			if (isset($result)) {
				$return = $result;
			}
		}
	}
	
	return $return;
}


/**
 * This function makes it possible to register for events using directory structure conventions.
 */
function evan_event_handler($event, $type, $object) {
	foreach (evan_get_plugins() as $plugin) {
		$file = elgg_get_plugins_path() . "$plugin/events/" . str_replace(':', '/', "$event/$type.php");
		if (file_exists($file)) {
			$result = include $file;
			if ($result === false) {
				return false;
			}
		}
	}
}

function evan_routes_hook_handler($hook, $handler, $params) {
	$segments = array($handler);
	if (is_array($params['segments'])) {
		$segments = array_merge($segments, $params['segments']);
	}
	return EvanRoute::route('/' . implode($segments, '/'));
}

elgg_register_plugin_hook_handler('all', 'all', 'evan_plugin_hook_handler');
elgg_register_event_handler('all', 'all', 'evan_event_handler');
elgg_register_plugin_hook_handler('route', 'all', 'evan_routes_hook_handler');