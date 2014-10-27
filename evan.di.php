<?php

use Evan\Structs\ArrayCollection;

return array(
	// TODO(ewinslow): Use classname resolution when we can require PHP 5.5
	'ElggSite' => DI\factory(function() {
		return elgg_get_site_entity();
	}),
	'Evan\Email\Sender' => DI\object('Evan\Email\ElggSender'),
	'Evan\I18n\Translator' => DI\object('Evan\I18n\ElggTranslator'),
	'Evan\Storage\Db' => DI\object('Evan\Storage\MysqlDb'),
	'Evan\Time\Clock' => DI\object('Evan\Time\SystemClock'),
	'plugins' => DI\factory(function() {
		// Register all active plugins for convention-based plugin hooks + events
		// return new ArrayCollection(elgg_get_plugins('active'));
		return new ArrayCollection();
	}),
);
