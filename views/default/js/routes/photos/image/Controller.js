// <script>

define(function() {
	function Controller($scope, image) {
		$scope.image = image;
	}

	Controller.$resolve = {
		image: function(evanDatabase, $route) {
			return evanDatabase.getObject('/image-json', {
				guid: $route.current.params.guid
			});
		}
	};

	return Controller;
});
