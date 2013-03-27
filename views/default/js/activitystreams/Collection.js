define(function(require) {
	var elgg = require('elgg');
	var $ = require('jquery');
	
	return function(collection) {
	
		this.getRemainingItemsCount = function() {
			return collection.totalItems - collection.items.length;
		};

		this.hasRemainingItems = function() {
			return this.getRemainingItemsCount() > 0;
		};

		this.getItems = function() {
			return collection.items;
		};

		this.getTotalItems = function() {
			return collection.totalItems;
		};
	
	        this.appendItem = function(item) {
	                collection.items.push(item);
	        };
	
        	this.resetLoadingNext = function() {
        	        this.loadingNextItems = null;
        	};

		this.appendCollection = function(newCollection) {
			collection.totalItems = newCollection.totalItems;
			newCollection.items.forEach(this.appendItem, this);
			collection.links.next = newCollection.items.length ? newCollection.links.next : null;
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
		
			return this.loadingNextItems = elgg.getJSON(collection.links.next.href).
				done(this.appendCollection.bind(this)).
				always(this.resetLoadingNext.bind(this));
		};
	
		this.hasNextItems = function() {
			return !!(collection.links && collection.links.next);
		};
	
		this.isLoadingNextItems = function() {
			return !!this.loadingNextItems;
		};
		
		this.getOldestPublishedTime = function() {
			return collection.items.map(function(object) { 
				return object.published; 
			}).sort()[0];
		};
		
		this.indexOfEntity = function(entity) {
			var index = -1;
			
			collection.items.forEach(function(item, idx) {
				if (item.guid == entity.guid) {
					index = idx;
				}
			});
			
			return index;                
		};
	
		this.indexOfAnnotation = function(annotation) {
			var index = -1;
			
			collection.items.forEach(function(item, idx) {
				if (item.annotation_id == annotation.annotation_id) {
					index = idx;
				}
			});
			
			return index;
		};
	};
});
