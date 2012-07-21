# Evan's Elgg Development Framework

This plugin gives me the freedom to experiment with some features that I
think would be potentially useful in Elgg core.

## Requirements

* PHP 5.3
* Elgg 1.8.3

## Setup

Just install this plugin like any other Elgg plugin. You can declare dependency on this plugin by adding the following
to your plugin's manifest.xml:

	<requires>
		<type>plugin</type>
		<name>evan</name>
		<version>1.0</version>
	</requires>
	<requires>
		<type>priority</type>
		<plugin>evan</plugin>
		<priority>after</priority>
	</requires>


## Features

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

Using this plugin for routing is much different and much simpler than core Elgg.

#### Basic configuration
To declare routes, add a routes.php file to your plugin's root that returns a map of routes to handlers like so:

    return array(
        '/blog' => 'blog/index',
    );

It's important that all your routes begin with a slash (`/`) character, otherwise they will not be matched. This also
makes it obvious which side is the url and which side is the handler.

On the left side we have the route to look for -- this is compared against the url. If a match is found, we look
for a handler file in pages/$handler.php, so in this case it would be pages/blog/index.php. These page handlers
are expected to behave like standard Elgg 1.8 handlers. Plugins are checked for page handlers from last loaded to
first loaded, so page handlers can now essentially be overridden just like views -- super handy.

#### Named inputs
In addition to exact matches, you can define routes that pass named parameters as input to the handlers.

    return array(
        '/blog/:guid' => 'blog/view',
    )

This will pass the input "guid" to the "blog/view" handler. You can use arbitrary names after the colon to define
inputs (e.g., :my_cool_input), but the framework recognizes some as special:

 * `guid` and anything that ends in `_guid` will only match integers.
 * More to come... any suggestions?

### CSS-based icon insertion

Instead of:

    echo elgg_view('output/url', array('text' => elgg_view_icon('home') . htmlspecialchars($text)));

Which produces output like this:

    <a href="..."><span class="elgg-icon elgg-icon-home"></span>Text</a>

You can do:

    echo elgg_view('output/url', array('text' => $text, 'encode_text' => true, 'data-icon' => 'home'));

Which produces output like this:

    <a href="..." data-icon="home">Text</a>

And has the same visual effect. The hope is that this will make menu configuration
more plugin-friendly -- for example, if you just want to change the icon, not the
text of the menu item, your plugin doesn't have to conflict with another plugin that
wants to change the text but not the icon.

See http://trac.elgg.org/ticket/3547 for the official progress.


### `EvanMenu`: Easier menu-configuration in plugin hooks

In Elgg right now, tweaking the menu items registered for a menu is tough work.
All you get in the plugin hook is an array of items without any API for manipulating
the contents. `EvanMenu` solves this problem.

You can use `EvanMenu` like so within your plugin hooks.

    $menu = new EvanMenu($items);
    
    $menu->registerItem(...); // similar API to elgg_register_menu_item
    $menu->unregisterItem($name); // Remove items by name.
    
    return $menu->getItems();

