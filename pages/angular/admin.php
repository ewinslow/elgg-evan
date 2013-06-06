<?php
/**
 * Elgg angular pageshell for the admin area
 *
 * @package Elgg
 * @subpackage Core
 */

admin_gatekeeper();
elgg_admin_add_plugin_settings_menu();
elgg_set_context('admin');

elgg_unregister_css('elgg');
elgg_load_js('elgg.admin');
elgg_load_js('jquery.jeditable');

$notices_html = '';
$notices = elgg_get_admin_notices();
if ($notices) {
	foreach ($notices as $notice) {
		$notices_html .= elgg_view_entity($notice);
	}

	$notices_html = "<div class=\"elgg-admin-notices\">$notices_html</div>";
}

// render content before head so that JavaScript and CSS can be loaded. See #4032
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$header = elgg_view('admin/header');
$footer = elgg_view('admin/footer');


// Set the content type
header("Content-type: text/html; charset=UTF-8");

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo elgg_view('page/elements/head'); ?>
</head>
<body>
	<div class="elgg-page elgg-page-admin">
		<div class="elgg-inner">
			<div class="elgg-page-header">
				<div class="elgg-inner clearfix">
					<?php echo $header; ?>
				</div>
			</div>
			<div class="elgg-page-messages">
				<?php echo $messages; ?>
				<?php echo $notices_html; ?>
			</div>
			<div class="elgg-page-body">
				<div class="elgg-inner">
					<div class="elgg-layout elgg-layout-one-sidebar">
						<div class="elgg-sidebar clearfix">
							<?php echo elgg_view('admin/sidebar'); ?>
						</div>
						<div class="elgg-main elgg-body" data-ng-view>
							<div class="elgg-ajax-loader centered"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="elgg-page-footer">
				<div class="elgg-inner">
					<?php echo $footer; ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php echo elgg_view('page/elements/foot'); ?>
	
	<script>
	require(['angular', 'angular/module/elggAdmin'], function(angular) {
		angular.bootstrap(document.body, ['elggAdmin']);
	});
	</script>

</body>
</html>