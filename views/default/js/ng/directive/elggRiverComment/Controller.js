// <script>
define(function() {
	return function($scope, markdown) {
		$scope.deleting = false;
		
		$scope.delete = function() {
	    		this.$emit('comments/delete');
		};
	
		$scope.getContent = function() {
			return markdown.makeHtml(this.comment.content || '');
		};
	};
});
