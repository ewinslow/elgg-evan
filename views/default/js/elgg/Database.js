define(function(require) {
	var ActivityStreamsCollection = require('activitystreams/Collection');
	
	var Database = function($http, elgg) {
		this.$http = $http;
		this.elgg = elgg;
	};
	
	Database.prototype.getObject = function(url, data) {
		return this.$http.get(this.elgg.normalize_url(url), {params:data}).then(function(result) {
			return result.data;
		});
	};

	Database.prototype.getCollection = function(url, data) {
		return this.getObject(url, data).then(function(result) {
			return new ActivityStreamsCollection(result);
		});		
	};
	
	Database.prototype.getEntity = function(guid) {
		return this.getObject('/entity-json', {guid: guid});
	};

	Database.prototype.getActivity = function() {
		return this.getCollection('/activity-json');
	};
	
	Database.prototype.getUsers = function(data) {
		return this.getCollection('/users-json', data);
	};
	
	Database.prototype.getPlugin = function(id) {
		return this.getObject('/admin/plugins-json', {id:id});
	};

	Database.prototype.getAlbums = function() {
		return this.getCollection('/albums-json');
	};
	
	return Database;
});
