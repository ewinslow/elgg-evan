<?php

elgg_extend_view('css/elgg', 'css/data-icon');
elgg_extend_view('css/elgg', 'css/evan');
elgg_extend_view('js/elgg', 'js/evan');

elgg_extend_view('css/elgg', 'js/ng/directive/elggUsers/styles.css');
elgg_extend_view('css/elgg', 'js/ng/directive/elggFriendlyTime/styles.css');
elgg_extend_view('css/admin', 'js/ng/directive/elggUsers/styles.css');
elgg_extend_view('css/admin', 'js/ng/directive/elggFriendlyTime/styles.css');

elgg_extend_view('js/elgg', 'js/elgg/composer');


elgg_register_admin_menu_item('administer', 'browse', 'users');

elgg_register_js('moment', array(
	'src' => "//cdnjs.cloudflare.com/ajax/libs/moment.js/1.7.2/moment.min.js",
	'deps' => array(),
	'exports' => 'moment',
));

elgg_register_ajax_view('blog/composer');
elgg_register_ajax_view('bookmarks/composer');
elgg_register_ajax_view('file/composer');
elgg_register_ajax_view('messageboard/composer');
elgg_register_ajax_view('photos/album/composer');
elgg_register_ajax_view('thewire/composer');
