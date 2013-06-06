define(function(require) {
	var $ = require('jquery');
	
	function CollectionCtrl(collection, $http) {
		this.collection = collection;
		this.$http = $http;

		this.getRemainingItemsCount = function() {
			return this.collection.totalItems - this.collection.items.length;
		};

		this.hasRemainingItems = function() {
			return this.getRemainingItemsCount() > 0;
		};

		this.getItems = function() {
			return this.collection.items;
		};

		this.getTotalItems = function() {
			return this.collection.totalItems;
		};
	
	        this.appendItem = function(item) {
	                this.collection.items.push(item);
	        };
	
        	this.resetLoadingNext = function() {
        	        this.loadingNextItems = null;
        	};

		this.appendCollection = function(newCollection) {
			this.collection.totalItems = newCollection.totalItems;
			newCollection.items.forEach(this.appendItem, this);
			this.collection.links.next = newCollection.items.length ? newCollection.links.next : null;
		};
	
		this.resetLoadingNext = function() {
			this.loadingNextItems = null;
		};
		
		// Public member functions
		this.loadNextItems = function() {
			if (!this.hasNextItems()) {
				throw new Error('There are no more items to load!');	
			}
		
			if (this.loadingNextItems) {
				// Loading in progress. Don't trigger two loads at once!
				return this.loadingNextItems;	
			}
		
			var resetLoadingNext = this.resetLoadingNext.bind(this);
			return this.loadingNextItems = $http.get(collection.links.next.href).
				then(this.appendCollection.bind(this)).
				then(resetLoadingNext, resetLoadingNext);
		};
	
		this.hasNextItems = function() {
			return !!(this.collection.links && this.collection.links.next);
		};
	
		this.isLoadingNextItems = function() {
			return !!this.loadingNextItems;
		};
		
		this.getOldestPublishedTime = function() {
			return this.collection.items.map(function(object) { 
				return object.published; 
			}).sort()[0];
		};
		
		this.indexOfEntity = function(entity) {
			var index = -1;
			
			this.collection.items.forEach(function(item, idx) {
				if (item.guid == entity.guid) {
					index = idx;
				}
			});
			
			return index;                
		};
	
		this.indexOfAnnotation = function(annotation) {
			var index = -1;
			
			this.collection.items.forEach(function(item, idx) {
				if (item.annotation_id == annotation.annotation_id) {
					index = idx;
				}
			});
			
			return index;
		};
	};

	return CollectionCtrl;
});
