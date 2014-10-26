<?php

return array(
	// TODO(ewinslow): Use classname resolution when we can require PHP 5.5
	'Evan\Email\Sender' => DI\object('Evan\Email\ElggSender'),
	'Evan\I18n\Translator' => DI\object('Evan\I18n\ElggTranslator'),
	'Evan\Storage\Db' => DI\object('Evan\Storage\MysqlDb'),
	'Evan\Time\Clock' => DI\object('Evan\Time\SystemClock'),
	'plugins' => DI\factory(function() {
		$plugins = array();
		
		// Register all active plugins for convention-based plugin hooks + events
		foreach (elgg_get_plugins('active') as $plugin) {
			$plugins[] = $plugin->getID();
		}
		
		return $plugins;
	}),
);