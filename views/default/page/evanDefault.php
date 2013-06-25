<?php
/**
 * Evan pageshell (ajaxified pages)
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title'] The page title
 */

elgg_require_js('apps/evanDefault');

// render content before head so that JavaScript and CSS can be loaded. See #4032
$header = elgg_view('page/elements/header', $vars);
$body = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);

// Set the content type
header("Content-type: text/html; charset=UTF-8");

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo elgg_view('page/elements/head', $vars); ?>
</head>
<body>
<div class="elgg-page elgg-page-default">
	
	<?php if (elgg_is_logged_in()) { ?>
	<div class="elgg-page-topbar">
		<div class="elgg-inner">
			<?php echo elgg_view('page/elements/topbar', $vars); ?>
		</div>
	</div>
	<?php } ?>

	<header class="elgg-page-header">
		<div class="elgg-inner">
			<?php echo $header; ?>
		</div>
	</header>
	
	<div class="elgg-page-body">
		<div class="elgg-inner" ng-view></div>
	</div>

	<footer class="elgg-page-footer">
		<div class="elgg-inner">
			<?php echo $footer; ?>
		</div>
	</footer>
</div>
<?php echo elgg_view('page/elements/foot'); ?>
</body>
</html>
