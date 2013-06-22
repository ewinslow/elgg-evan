define(function(require) {
	var newClass = require('evan/newClass');
	
	return newClass({
		constructor: function($scope, $timeout) {
			$scope.ctrl = this;
			
			/** @private */
			this.$timeout = $timeout;
			
			this.mode = 'email';
			this.waiting = false;
		},
		
		submit: function() {
			if (this.mode == 'email') {
				this.handleEmailSubmit();
			} else {
				this.handleLegacySubmit();
			}
		},
		
		
		handleEmailSubmit: function() {
			this.waiting = true;
			
			// Simulate waiting for server
			this.$timeout(function() {
				this.mode = 'legacy';
				this.waiting = false;
			}.bind(this), 2500);
		},
		
		
		handleLegacySubmit: function() {
			alert('Coming soon!');
		}
	});
});
