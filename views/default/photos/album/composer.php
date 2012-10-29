<?php
$body_vars = tidypics_prepare_form_vars();

echo elgg_view_form('photos/album/save', array(), array_merge($body_vars, $vars));
