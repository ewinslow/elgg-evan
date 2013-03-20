<?php

$module = $vars['module'];

?>
// <script>
define(function(require) {
	var angular = require('angular');

	<?php
	foreach ($module->getDeps() as $dep) {
		echo "require('ng/module/$dep');";
	}
	?>

	var ngModule = angular.module('<?php echo $module->getName(); ?>', <?php echo json_encode($module->getDeps()); ?>);

	// services
	<?php
	foreach ($module->getServices() as $service) {
		echo "ngModule.factory('$service', require('ng/service/$service/factory'));\n";
	}
	?>

	// directives
	<?php
	foreach ($module->getDirectives() as $directive) {
		echo "ngModule.directive('$directive', require('ng/directive/$directive/factory'));\n";
	}
	?>

	// filters
	<?php
	foreach ($module->getFilters() as $filter) {
		echo "ngModule.filter('$filter', require('ng/filter/$filter/factory'));\n";
	}
	?>
	
	return ngModule;
});
