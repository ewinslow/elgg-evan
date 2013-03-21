// <script>
define(function() {
	return function($scope, elggDatabase) {
		/** A map of guids to booleans indicating whether the user is selected */
		$scope.selections = {};

		$scope.toggleSelections = function() {
			if (this.allSelected()) {
				this.setAllSelections(false);
			} else {
				this.setAllSelections(true);
			}
		};
			
		$scope.setAllSelections = function(selected) {
			this.getItems().forEach(function(user) {
				this.selections[user.guid] = selected;
			}.bind(this));
		};

		$scope.allSelected = function() {
			return this.getSelectedCount() == this.getItems().length;
		};

		$scope.getSelectedCount = function() {
			var total = 0;

			$.each(this.selections, function(guid, selected) {
				if (selected) {
					total++;
				}
			});

			return total;
		};

		elggDatabase.getUsers().then(function(collection) {
			$scope.getItems = collection.getItems.bind(collection);
			$scope.getTotalItems = collection.getTotalItems.bind(collection);
			$scope.hasNextItems = collection.hasNextItems.bind(collection);
			$scope.isLoadingNextItems = collection.isLoadingNextItems.bind(collection);

			$scope.loadNextItems = function() {
                        	collection.loadNextItems().always(this.$digest.bind(this));
                	};

		});
	};
});
