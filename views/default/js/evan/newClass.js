define(function(require) {
	var elgg = require('elgg');
	var angular = require('angular');
	
	return function(classDef) {
		var Ctor = classDef.constructor;
		
		if (classDef['extends']) {
			elgg.inherit(Ctor, classDef['extends']);
			
			delete classDef['extends'];
		}
		
		angular.extend(Ctor.prototype, classDef);
		
		return Ctor;
	};
});