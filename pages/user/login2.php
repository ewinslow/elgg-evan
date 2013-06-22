<?php

// Set the content type
header("Content-type: text/html; charset=UTF-8");

// This is the magic
elgg_load_js('apps/evanExternal');

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo elgg_view('page/elements/head', $vars); ?>
</head>
<body>
	<div class="elgg-page elgg-page-default">
		<header class="elgg-page-header">
			<div class="elgg-inner">
			</div>
		</header>
		<div class="elgg-page-body">
			<div class="elgg-inner" ng-view>
			</div>
		</div>
		<footer class="elgg-page-footer">
			<div class="elgg-inner">
			</div>
		</footer>
	</div>
	<?php echo elgg_view('page/elements/foot'); ?>
</body>
</html>