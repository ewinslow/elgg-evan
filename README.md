# Evan's Elgg Development Framework

This plugin gives me the freedom to experiment with some features that I
think would be useful in Elgg core.

## Requirements

* PHP 5.3
* Elgg 1.9-dev

## Setup

Just install this plugin like any other Elgg plugin. You can declare dependency on this plugin by adding the following
to your plugin's manifest.xml:

	<requires>
		<type>plugin</type>
		<name>evan</name>
		<version>2.0-dev</version>
	</requires>
	<requires>
		<type>priority</type>
		<plugin>evan</plugin>
		<priority>after</priority>
	</requires>


## Features

### elgg.json

This framework adds support for declaratively setting up your plugin via a
elgg.json file.

Instead of using all the registration functions elgg provides, you can just
create a JSON structure and we'll register it all for you in the right order, etc.

#### `elgg_register_js` => "scripts"

```json
{
	"scripts": {
		"foo": {
			"url": "http://foojs.org/"
			"src": "//cdnjs.cloudflare.com/ajax/libs/foo.js/x.y.z/foo-min.js",
			"deps": ["bar"],
			"exports": "foo",
			"location": "footer"
		}
	}
}
```

#### `elgg_register_css` => "styles"

```json
{
	"styles": {
		"normalize": {
			"url": "http://necolas.github.io/normalize.css/",
			"href": "//cdnjs.cloudflare.com/ajax/libs/normalize/2.1.0/normalize.css"
		}
	}
}
```

#### `elgg_extend_view`, `elgg_register_simplecache_view`, `elgg_register_ajax_view` => "views"

Traditionally you do this in your init,system hook handler:
```php
elgg_register_ajax_view('page/elements/head');
elgg_register_simplecache_view('page/elements/head');
elgg_extend_view('page/elements/head', 'evan/html5', 1);
```

With my framework, you can just do this in elgg.json:
```json
{
	"views": {
		"page/elements/head": {
			"ajax": true,
			"cache": true,
			"extensions": {
				"evan/html5": 1
			}
		}
	}
}
```

### Viewing entities with `evan_view_entity()`

This function allows you to handle various visualizations of entities very easily.

For example, `evan_view_entity('link', $blog)` will look for views in the following order: 

 1. object/blog/link
 2. object/default/link
 3. entity/link

This allows you to avoid filling your views with so many if/else statements like this:
https://github.com/Elgg/Elgg/blob/f122c12ab35f26d5b77a18cc263fc199eb2a7b01/mod/blog/views/default/object/blog.php

### Convention-based hook + event registration

This plugin makes it possible to register for hooks using directory structure conventions rather than explicit
function registration. In order to register for the `"register", "menu:site"` hook, put a file at
`my_plugin/hooks/register/menu/site.php`.

A similar feature is also available for events. In order to register for the `"init", "system"` event, for example,
put the behavior of the event at `my_plugin/events/init/system.php`. Return `false` from the file in order to cancel
further events, just like normal event handler functions.

#### Limitations
It is not possible to register for all types of a certain hook with this method. I.e., a file at
`my_plugin/hooks/register/all.php` will not be run on all 'register' hooks.

There is no way to unregister hooks when using this method. Best you can do is add a hook that undoes the
the effect of the hook you want to "unregister" and make sure the plugin that defines this hook is loaded later.

#### Warning!!!
You MUST include an explicit return value in hook handlers in order to avoid clobbering the results. If you don't want
to change the return value, `return $return` will work, as will `return NULL`. If you fail to do this, the return value
will be forced to `true`, which is often not what you want.

### Simplified routing system

To declare routes, add a "routes" parameter in your plugin's elgg.json:

```json
{
	"routes": {
		"/blog" => "blog/index",
	}
}
```

It's important that all your routes begin with a slash (`/`) character,
otherwise they will not be matched. This also makes it obvious which side
is the url and which side is the handler.

On the left side we have the route to look for -- this is compared against the url.
If a match is found, we look for a handler file in pages/$handler.php, so in this
case it would be pages/blog/index.php. These page handlers are expected to behave
like standard Elgg 1.8 handlers. Plugins are checked for page handlers from last loaded to
first loaded, so page handlers can now essentially be overridden just like views.

#### Named inputs
In addition to exact matches, you can define routes that pass named parameters
as input to the handlers.

    return array(
        '/blog/:guid' => 'blog/view',
    )

This will pass the input "guid" to the "blog/view" handler. You can use arbitrary names after the colon to define
inputs (e.g., :my_cool_input), but the framework recognizes some as special:

 * `guid` and anything that ends in `_guid` will only match integers.
 * More to come... any suggestions?

### CSS-based icon insertion

Instead of:

    echo elgg_view('output/url', array(
        'text' => elgg_view_icon('home') . htmlspecialchars($text),
    ));

Which produces output like this:

    <a href="..."><span class="elgg-icon elgg-icon-home"></span>Text</a>

You can do:

    echo elgg_view('output/url', array(
        'text' => $text, 
        'encode_text' => true, 
        'data-icon' => 'home',
    ));

Which produces output like this:

    <a href="..." data-icon="home">Text</a>

And has the same visual effect. The hope is that this will make menu configuration
more plugin-friendly -- for example, if you just want to change the icon, not the
text of the menu item, your plugin doesn't have to conflict with another plugin that
wants to change the text but not the icon.

See <http://trac.elgg.org/ticket/3547> for the official progress.


### `EvanMenu`: Easier menu-configuration in plugin hooks

In Elgg right now, tweaking the menu items registered for a menu is tough work.
All you get in the plugin hook is an array of items without any API for manipulating
the contents. `EvanMenu` solves this problem.

You can use `EvanMenu` like so within your plugin hooks.

    $menu = new EvanMenu($items);
    
    $menu->registerItem(...); // similar API to elgg_register_menu_item
    $menu->unregisterItem($name); // Remove items by name.
    
    return $menu->getItems();

### Gutters for grids

Elgg 1.8 introduced a grids system, but there was no gutter support. This plugin takes advantage
of the fact that the css is generated with PHP and emits a grid system based on the gutter width
you choose. See css/elements/grid.php -- just edit the $gutterWidthPercent value to change gutters.

### `evan_user_can($verb, $object, $target)`

This is an experimental implementation of <http://trac.elgg.org/ticket/4888>.

Elgg comes with various permissions-related functions such as `can_edit` and
`can_write_to_container`. In addition, there are several permissions hooks for
controlling what users can and cannot do. This function unifies the interface to
Elgg's permissions system and also broadens the scope of what Elgg's permission
system can handle. For example, there has never been a standard way to ask Elgg,
"Can the current user invite user X to event Y?" Now, that question is easy to
ask:

    elgg_user_can('invite', $user, $event);

An additional benefit of requesting permissions this way is that it is not
dependent on data-model. If, for example, we were tracking event invites with
annotations and we decided to switch to using relationships at some point, the
permissions code wouldn't have to change at all. That makes everything a lot
more maintainable than before.

#### Example Usage

Here are a few examples along with the old way of checking permissions to
highlight the improved readability and maintainability of the new system.

Checking if the current user can post a blog to their own wall:

    elgg_user_can('post', new ElggBlog(), $user);

Checking if the current user can invite another user to an event:

    elgg_user_can('invite', $user, $event);

Checking if the current user can join a group:

    elgg_user_can('join', $group);

Checking if the current user can follow another user:

    elgg_user_can('follow', $user);

Checking if the current user can delete something:

    elgg_user_can('delete', $entity);

Checking if the current user can tag another user in a photo:

    elgg_user_can('tag', $user, $photo);

#### Customizing permissions via hooks

To control the results, simply register for the plugin hook "permission,verb"
like so:

    elgg_register_plugin_hook_handler('permission', 'post', 'handler');

Or if you prefer the file-system-based method that the evan-framework provides:

    /mod/myplugin/hooks/permission/post.php

Your handler will be passed four values: actor, verb, object, and target.
Plugin developers are encouraged to use the [activitystreams verbs][as-verbs]
whenever one is available that fits their needs.

 [as-verbs]: http://activitystrea.ms/head/activity-schema.html#verbs

#### Backwards compatibility

Of course, in order for this to be useful, it needs to be backwards compatible
with the permissions models from before. I've hardcoded the translations from
the new code to the old code where appropriate. If you find anything missing,
submit a bug/pull request and we'll get that fixed.

#### Limitations

This function does not accept non-entities as the object or target of the
permissions check. For example, as of 1.8, you cannot ask using this function
whether the user has permission to comment on a blog, since comments are modeled
as annotations. The appropriate way to do that would have been:

    elgg_user_can('post', new ElggComment(), $blog);

But the object must be an ElggEntity. It may be tempting to instead do:

    elgg_user_can('comment', $blog);
    
But that is discouraged since this is not consistent with the activitystreams
spec and it is best to align with that spec as much as possible. I hope that
this new permissions interface will help clarify for people what should be an 
ElggEntity and what should be an ElggAnnotation so that we don't have this
situation again in the future.

### EvanDatabase

This factory class provides some useful tools for querying entities. For example,
to fetch 10 banned users:

    $db = new EvanDatabase();
    $db->getUsers()->where('banned', true)->getItems(10, 0); // The array of users

To count the number of banned users:

    $db = new EvanDatabase();
    $db->getUsers()->where('banned', true)->getCount(); // The number of banned users

The power comes from having a dedicated EvanUsersQuery object that understands
user-specific fields. For example, we can now easily query for admins:

    $db = new EvanDatabase();
    $db->getUsers()->where('admin', true)->getItem(0); // A single admin user

It also makes some very handy admin-relevant queries easy:

    $db = new EvanDatabase();
    $db->getUsers()->where('validated', false)->getItems(); // 10 unvalidated users

#### Limitations

As of right now, only `getEntities()` and `getUsers()` are supported. `getObjects()`
and `getGroups()` seem like logical next steps.

It's not yet possible to query on metadata with this API. You can still use 
`elgg_get_entities_from_metadata()` for that.
