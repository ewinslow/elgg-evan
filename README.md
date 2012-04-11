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

See the comments in start.php

### Convention-based hook + event registration

See the comments in start.php.

### Simplified routing system

See the comments in classes/EvanRoute.php
