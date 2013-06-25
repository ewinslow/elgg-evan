define(function() {
	function Controller($scope, albums, evanUser, elgg) {
		$scope.albums = albums;		
		$scope.user = evanUser;
		$scope.owner = elgg.page_owner;
	};

	Controller.$resolve = {
		albums: function(evanDatabase, $route) {
			return evanDatabase.getAlbums({
				alias: $route.current.params.alias
			});
		}
	};

	return Controller;
});
