<script>

define('angular', function() { return angular; });
define('ng/module/ngSanitize', function() { return angular.module('ngSanitize'); });
define('ng/module/ngResource', function() { return angular.module('ngResource'); });
require(['angular', 'ng/module/elggDefault'], function(angular) {
	angular.bootstrap(document, ['elggDefault']);
});

</script>
