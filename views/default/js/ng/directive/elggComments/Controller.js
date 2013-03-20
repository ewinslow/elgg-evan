define(function(require) {
	var $ = require('jquery');
	var Collection = require('activitystreams/Collection');
	
	return function($scope, elgg) {
		$scope.user = elgg.session.user;
		
		var comments = {
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
				content: 'BOoya!',
			},{
                                author: {
                                        displayName: 'Evan Winslow',
                                        image: {
                                                url: 'http://www.gravatar.com/avatar/HASH?d=mm'
                                        }
                                },
				content: 'There is nothing to say!',
			}],
			totalItems: 13
		}

		Collection.call($scope, comments);

		$scope.submit = function() {
			var newComment = {
				content: this.newComment,
				author: this.user,
			};
            
			comments.items.push(newComment);
			comments.totalItems++;
            
			elgg.action('comments/add', {
				entity_guid: this.object.guid,
				generic_comment: this.newComment
			}).then(function(json) {
				$.extend(newComment, json.output);
			}).done(function() {
				$scope.$digest();
			});
            
			this.reset();
		};
        
		$scope.reset = function() {
			this.newComment = {};
			this.isCommenting = false;
			this.startCommentingButtonFocused = true;
		};
	};
});
