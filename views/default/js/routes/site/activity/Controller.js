define(function(require) {
	var newClass = require('evan/newClass');
	
	var Controller = newClass({
		constructor: function($scope, river, evanUser) {
			this.$scope = $scope;
			this.river = river;

			$scope.ctrl = this;
			$scope.target = evanUser;
		},
		
		loadNextItems: function() {
			this.river.loadNextItems().always(function() {
				this.$scope.$digest();
			}.bind(this));
		},
	});

	Controller.$resolve = {
		river: function(evanDatabase) {
			return evanDatabase.getActivity();
		}
	};

	return Controller;
});
