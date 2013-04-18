define(function(require) {
	var Collection = require('./Collection');
	var jasmine = require('jasmine');

	describe("Collection", function() {

		it('can tell you whether there are any more items to fetch', function() {
			var data = { items: [], totalItems: 0 };
			var collection = new Collection(data);

			expect(collection.hasRemainingItems()).toEqual(false);

			data.totalItems = 1;

			expect(collection.hasRemainingItems()).toEqual(true);
		});

		it('can fetch the collection\'s current items', function() {
			var data = { items: [] };
			var collection = new Collection(data);

			expect(collection.getItems()).toEqual(data.items);
		});

		it('can tell you how many more items there are to fetch', function() {
			var data = {items:[], totalItems: 1};
			var collection = new Collection(data);
	
			expect(collection.getRemainingItemsCount()).toEqual(1);
		});

	});
});
