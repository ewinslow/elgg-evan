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
	foreach ($module->getValues() as $service => $value) {
		echo "ngModule.value('$service', require('$value'));\n";
	}

	foreach ($module->getServices() as $service => $constructor) {
		echo "ngModule.service('$service', require('$constructor'));\n";
	}

	foreach ($module->getFactories() as $service) {
		echo "ngModule.factory('$service', require('ng/service/$service'));\n";
	}

	// directives
	foreach ($module->getDirectives() as $directive) {
		echo "ngModule.directive('$directive', require('ng/directive/$directive/factory'));\n";
	}

	// filters
	foreach ($module->getFilters() as $filter) {
		echo "ngModule.filter('$filter', require('ng/filter/$filter'));\n";
	}
	?>

	ngModule.config(function($routeProvider, $locationProvider) {
		$locationProvider.html5Mode(true).hashPrefix('!/');

		<?php
		foreach ($module->getRoutes() as $pattern => $view) {
			echo "\$routeProvider.when('$pattern', require('ng/view/$view/route'));\n";
		}
		?>
		
		$routeProvider.otherwise({
			redirectTo: function() { 
				var targetHref = window.location.href;
				window.history.back();
				setTimeout(function() {
					window.location.href = targetHref;
				}, 0);
			}
		});
	});
	
	return ngModule;
});
