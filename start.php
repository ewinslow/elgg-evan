<?php
/**
 * 
 */

function from_atom($timestamp) {
        return date_create_from_format(DateTime::ATOM, $timestamp)->getTimestamp();
}

function to_atom($timestamp) {
        return date_format(date_timestamp_set(date_create(), $timestamp), DateTime::ATOM);
}

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

/**
 * Returns the activitystreams representation of an ElggUser
 */
function elgg_get_person_proto(ElggUser $user) {
        $person = array(
                'guid' => $user->guid,
                'objectType' => 'person',
                'displayName' => $user->name,
                'summary' => $user->briefdescription,
                'image' => array(
                        'url' => $user->getIconURL('medium'),
                        'width' => 100, // TODO: dynamically determine this from config variables
                        'height' => 100, // TODO: ...and this too, of course
                ),
                'url' => $user->getURL(),
                'location' => array(
                        'displayName' => $user->location,
                ),
                'username' => $user->username,
        );

        if (elgg_is_admin_logged_in()) {
                $person['published'] = to_atom($user->time_created);
                $person['banned'] = $user->isBanned();
                $person['ban_reason'] = $user->ban_reason;
                $person['email'] = $user->email;

                if ($user->last_action) {
                        $person['last_action'] = to_atom($user->last_action);
                }
        }

        return $person;
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

function evan_user_can($verb, ElggEntity $object, ElggEntity $target = NULL) {
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

elgg_register_event_handler('init:angular', 'elggDefault', function($event, $type, AngularModuleConfig $elggDefault) {
        $elggDefault
                ->registerDirective('elggFocusModel')
                // ->registerDirective('elggInputHtml') // Broken
                // ->registerDirective('elggResponses')
                ->registerDirective('elggComments')
                // ->registerDirective('elggRiver')
                // ->registerDirective('elggRiverComment')
                // ->registerDirective('elggRiverItem')
                // ->registerDirective('elggUsers')
                ->registerFilter('elggEcho')
                ->registerValue('elgg', 'elgg')
                ->registerFactory('elggUser')
                ->registerDep('ngSanitize');
});

elgg_register_event_handler('init:angular', 'elggAdmin', function($event, $type, AngularModuleConfig $elggAdmin) {

        $elggAdmin
		->registerValue('elgg', 'elgg')
		->registerValue('moment', 'moment')
		->registerService('elggDatabase', 'elgg/Database')
		->registerFilter('fromNow')
		->registerFilter('calendar')
		->registerDirective('elggUsers')
                ;

});

function angular_get_module_config($name) {
        $module = new AngularModuleConfig($name);

        elgg_trigger_event('init:angular', $name, $module);

        return $module;
}

elgg_register_event_handler('init', 'system', function() {
        elgg_extend_view('page/default', 'angular/bootstrap/elggDefault');
        elgg_extend_view('page/admin', 'angular/bootstrap/elggAdmin');
        elgg_extend_view('css/elgg', 'css/elgg/link.css');

        elgg_register_simplecache_view("js/ng/module/elggDefault.js");
        elgg_register_simplecache_view("js/ng/module/elggAdmin.js");

        elgg_register_js('angular', "//ajax.googleapis.com/ajax/libs/angularjs/1.1.3/angular.js", 'footer');
        elgg_register_js('ng/module/ngResource', "//ajax.googleapis.com/ajax/libs/angularjs/1.0.4/angular-resource.min.js", 'footer');
        elgg_register_js('ng/module/ngSanitize', "//ajax.googleapis.com/ajax/libs/angularjs/1.0.4/angular-sanitize.min.js", 'footer');

        elgg_load_js('angular');
        elgg_load_js('ng/module/ngResource');
        elgg_load_js('ng/module/ngSanitize');
});

elgg_register_plugin_hook_handler('all', 'all', 'evan_plugin_hook_handler');
elgg_register_event_handler('all', 'all', 'evan_event_handler');
elgg_register_plugin_hook_handler('route', 'all', 'evan_routes_hook_handler');
