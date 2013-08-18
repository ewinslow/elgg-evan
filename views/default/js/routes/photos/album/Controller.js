define(function(require) {
	
	var newClass = require('evan/newClass');
	
	var Controller = newClass({
		/**
		 * @ngInject
		 */
		constructor: function($scope, album, $window, $location, $rootScope, elgg) {
			$scope.album = album;
			
			$scope.deleteEntity = function(album) {
				if ($window.confirm('Are you sure?')) {
					elgg.action('photos/delete', {
						guid: album.guid,
					}).success(function(result) {
						$location.url(result.forward_url.slice(elgg.config.wwwroot.length));
						$rootScope.$digest();
					});
				}
			};
		}
	});
	
	Controller.$resolve = {
		/**
		 * @ngInject
		 */
		album: function(evanDatabase, $route) {
			return evanDatabase.getCollection('/album-json', {
				guid: $route.current.params.guid
			});
		}
	};

	return Controller;
});
