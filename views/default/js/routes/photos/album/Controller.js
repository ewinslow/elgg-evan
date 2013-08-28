define(function(require) {
	
	var newClass = require('evan/newClass');
	
	var Controller = newClass({
		/**
		 * @ngInject
		 */
		constructor: function($scope, album, $window, $location, $rootScope, elgg) {
			$scope.album = album;
			this.elgg = elgg;
			this.$window = $window;
			this.$location = $location;
			this.$rootScope = $rootScope;
		},
		
		deleteEntity: function(album) {
			if (this.$window.confirm('Are you sure?')) {
				this.elgg.action('photos/delete', {
					guid: album.guid,
				}).success(this.onDeleteSuccess_.bind(this));
			}
		},
		
		onDeleteSuccess_: function(result) {
			this.$location.url(result.forward_url.slice(this.elgg.config.wwwroot.length));
			this.$rootScope.$digest();
		}
	});
	
	Controller.$resolve = {
		/**
		 * @ngInject
		 */
		album: function(evanDatabase, $route) {
			return evanDatabase.getObject('/album-json', {
				guid: $route.current.params.guid
			});
		}
	};

	return Controller;
});
