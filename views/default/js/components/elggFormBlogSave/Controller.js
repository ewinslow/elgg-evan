// <script>

define(function() {
	return function($scope, $location, elgg) {
		$scope.ctrl = this;
		
		$scope.submit = function() {
			elgg.action('blog/save', {
				guid: this.blog.guid,
				container_guid: this.blog.container.guid,
				title: this.blog.displayName,
				description: this.blog.content,
				access_id: this.blog.access_id,
				excerpt: this.blog.excerpt,
				comments_on: this.blog.comments_on,
				status: this.blog.status,
				save: true
			}).success(function(result) {
				if (result.status == 0) {
					$location.url(result.forward_url.slice(elgg.config.wwwroot.length));
				}
				
				$scope.$apply();
			});
		};		
	};
});
