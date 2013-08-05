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

if (!$EVAN) {
    $EVAN = new stdClass;
}

$EVAN->mailer = new Evan_Email_ElggSender();
$EVAN->clock = new Evan_SystemClock();
$EVAN->db = new Evan_Db_Mysql();

$EVAN->views = new Evan_ViewService();
$EVAN->i18n = new Evan_I18n();

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
		'displayName' => $user->getDisplayName(),
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

function elgg_get_object_proto(ElggObject $object) {
	$objectJson = array(
		'guid' => $object->guid,
		'published' => to_atom($object->time_created),
		'updated' => to_atom($object->time_updated),
		"displayName" => $object->getDisplayName(),
		"url" => $object->getURL(),
		"container" => array(
			'guid' => $object->getContainerGuid(),
		),
		"content" => $object->description,
		'canEdit' => $object->canEdit(),
		'canDelete' => $object->canEdit(),
		'hasLiked' => !!elgg_get_annotations(array(
			'annotation_name' => 'likes',
			'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
			'guid' => $object->guid,
			'count' => true,
		)),
		"likes" => elgg_get_likes_proto($object),
		"comments" => elgg_get_comments_proto($object),
		'attachments' => array(),
		'access_id' => $object->access_id,
	);

	$owner = $object->getOwnerEntity();
	if ($owner) {
		$objectJson['author'] = elgg_get_person_proto($owner);
	}


	if ($object->getSubtype() == 'album') {
		$photosOptions = array(
			'container_guid' => $object->guid,
			'type' => 'object',
			'subtype' => 'image',
		);

		$photos = elgg_get_entities($photosOptions);

		$objectJson['totalItems'] = $object->getSize();

		$coverImage = get_entity($object->getCoverImageGuid());
		if ($coverImage) {
			$objectJson['image'] = array(
				'url' => $coverImage->getIconUrl('small'),
			);
		} else {
			$objectJson['image'] = array(
				'url' => elgg_normalize_url("mod/tidypics/graphics/empty_album.png"),
			);
		}

		foreach ($photos as $photo) {
			$objectJson['attachments'][] = elgg_get_attachment_proto($photo);
		}
	}

	if ($object->getSubtype() == 'blog') {
		$objectJson['status'] = $object->status;
		$objectJson['comments_on'] = $object->comments_on;
	}

	if ($object->getSubtype() == 'tidypics_batch') {
		$photos = $object->getEntitiesFromRelationship('belongs_to_batch', true);

		foreach ($photos as $photo) {
			$objectJson['attachments'][] = elgg_get_attachment_proto($photo);
		}
	}

	if ($object->getSubtype() == 'image') {
		$objectJson['image'] = array(
			'url' => $object->getIconUrl('small'),
		);

		$objectJson['fullImage'] = array(
			'url' => $object->getIconUrl('master'),
		);
	}

	return $objectJson;
}

function elgg_get_likes_proto(ElggEntity $entity) {
	$likes = $entity->getAnnotations('likes', 3);
	$likes_count = elgg_get_annotations(array(
		'annotation_name' => 'likes', 
		'guid' => $entity->guid, 
		'count' => true,
	));

	$likes_json = array(
		'totalItems' => $likes_count,
		'items' => array(),
	);

	foreach ($likes as $like) {
		$likes_json['items'][] = elgg_get_person_proto($like->getOwnerEntity());
	}

	return $likes_json;
}
function elgg_get_attachment_proto(ElggObject $object) {
	$objectJson = array(
		'guid' => $object->guid,
		"displayName" => $object->getDisplayName(),
		"url" => $object->getURL(),
		"content" => $object->description,
	);

	if ($object->getSubtype() == 'image') {
		$objectJson['image'] = array(
			'url' => $object->getIconURL('small'),
			'width' => 100, // TODO: dynamically determine this from config variables
			'height' => 100, // TODO: ...and this too, of course
		);
		$objectJson['fullImage'] = array(
			'url' => $object->getIconURL('master'),
			'width' => 550, // TODO: dynamically determine this from config variables
			'height' => 550, // TODO: ...and this too, of course
		);
	}

	return $objectJson;
}
function elgg_get_comments_proto(ElggEntity $entity) {
	$comments = $entity->getAnnotations('generic_comment', 3, 0, 'desc');
	$comments_json = array(
		'totalItems' => $entity->countComments(),
		'items' => array(),
	);

	foreach ($comments as $comment) {
		$comments_json['items'][] = elgg_get_comment_proto($comment);
	}

	return $comments_json;
}

function elgg_get_comment_proto($comment) {
	return array(
		'author' => elgg_get_person_proto($comment->getOwnerEntity()),
		'published' => to_atom($comment->getTimeCreated()),
		'content' => $comment->value,
	);
}

function elgg_get_plugin_proto(ElggPlugin $plugin) {
	$pluginJson = array(
		'guid' => $plugin->guid,
		'version' => $plugin->version,
		'displayName' => $plugin->getDisplayName(),
		'elggPluginId' => $plugin->getId(),
		'isActive' => $plugin->isActive(),
	);

	return $pluginJson;
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

function evan_views_hook_handler($hook, $name, $returnval, $params) {
	$pieces = explode("/", $name);
	if ($pieces[0] != 'js') {
		return $returnval;
	}
	
	array_shift($pieces);
	$name = implode("/", $pieces);
	$pathinfo = pathinfo($name);
	if ($pathinfo['extension'] == 'js') {
		$filename = $pathinfo['filename'];
		$dirname = $pathinfo['dirname'];
		return preg_replace('/^define\(([^\'"])/m', "define(\"$dirname/$filename\", \$1", $returnval, 1);	
	}
}

elgg_register_plugin_hook_handler('all', 'all', 'evan_plugin_hook_handler');
elgg_register_event_handler('all', 'all', 'evan_event_handler');
elgg_register_plugin_hook_handler('route', 'all', 'evan_routes_hook_handler');
elgg_register_plugin_hook_handler('view', 'all', 'evan_views_hook_handler');
