# Evan's Elgg Development Framework

This plugin gives me the freedom to experiment with some features that I
think would be potentially useful in Elgg core.

## Requirements

* PHP 5.3
* Elgg 1.8.3

## Setup

In order for your plugin to take advantage of all available features, you should call 
`evan_register_plugin('my_plugin');` in your start.php file. This tells the framework that it should examine your
plugin's folder structure for hook/event handlers and such.

## Features

### `evan_view_entity()`

See the comments in start.php

### Convention-based hook + event registration

See the comments in start.php.
