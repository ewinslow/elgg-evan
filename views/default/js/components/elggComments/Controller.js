define(function(require) {
	var Collection = require('activitystreams/Collection');
	var angular = require('angular');
	
	function Controller($scope, elgg, $http) {
		var comments = {
			totalItems: 13,
			items: [{
				author: {
					displayName: 'Evan Winslow',
					image: {
						url: 'http://www.gravatar.com/avatar/HASH?d=mm'
					}
				},
				content: "Can't touch this!",
				elgg: {
					canDelete: true
				}
			},{
				author: {
					displayName: 'Evan Winslow',
					image: {
						url: 'http://www.gravatar.com/avatar/HASH?d=mm'
					}
				},
				content: 'BOoya!'
			},{
				author: {
					displayName: 'Evan Winslow',
					image: {
						url: 'http://www.gravatar.com/avatar/HASH?d=mm'
					}
				},
				content: 'There is nothing to say!'
			}]
		};

		Collection.call(this, comments, $http);
		
		$scope.user = elgg.session.user;
		$scope.ctrl = this;
		
		/** @private */
		this.elgg = elgg;
		
		/** @private */
		this.$scope = $scope;
	};
	elgg.inherit(Controller, Collection);

	Controller.prototype.submit = function() {
		this.collection.items.push(this.newComment);
		this.collection.totalItems++;
		
		// TODO Extract this out as a comments service
		this.elgg.action('comments/add', {
			entity_guid: this.object.guid,
			generic_comment: this.newComment.content
		}).then(function(json) {
			angular.extend(this.newComment, json.output);
		}.bind(this)).done(function() {
			this.$scope.$digest();
		}.bind(this));
		
		this.newComment = {
			author: this.elgg.session.user,
			content: ''
		};
	};

	return Controller;
});
