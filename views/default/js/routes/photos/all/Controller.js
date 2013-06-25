// <script>
define(function() {
	function Controller($scope, albums) {
		$scope.albums = albums;		
	};

	Controller.$resolve = {
		albums: function(evanDatabase) {
			return evanDatabase.getAlbums();
		}
	};

	return Controller;
});
