<?php

$menu = new EvanMenu($return);

$menu->registerItem('tinymce_toggler', array(
	'link_class' => 'tinymce-toggle-editor elgg-longtext-control',
	'href' => "#{$params['id']}",
	'text' => elgg_echo('tinymce:toggle'),
));

return $menu->getItems();