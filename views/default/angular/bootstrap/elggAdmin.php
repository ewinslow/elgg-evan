<script>

define('angular', function() { return angular; });
require(['angular', 'ng/module/elggAdmin'], function(angular) {
	angular.bootstrap(document, ['elggAdmin']);
});

</script>
