<?php

$module = elgg_in_context('admin') ? 'elggAdmin' : 'elggDefault';

$boot = <<<BOOT
<script>
require(['angular', 'ng/module/$module'], function(angular, ngModule) {
	angular.bootstrap(document, [ngModule.name]);
});
</script>
BOOT;

echo $boot;
