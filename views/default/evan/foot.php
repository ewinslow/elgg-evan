
<script>

<?php

$module = elgg_in_context('admin') ? 'elggAdmin' : 'elggDefault';

echo <<<BOOT
require(['angular', 'ng/module/$module'], function(angular) {
	angular.bootstrap(document, ['$module']);
});
BOOT;

?>

</script>
