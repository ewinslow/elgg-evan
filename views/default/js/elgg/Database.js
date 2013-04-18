define(function(require) {
	var Database = function($http, elgg) {
		this.$http = $http;
		this.elgg = elgg;
	};
	
	Database.prototype.getObject = function(url, data) {
		return this.$http.get(this.elgg.normalize_url(url), {params:data}).then(function(result) {
			return result.data;
		});
	};

	Database.prototype.getEntity = function(guid) {
		return this.getObject('/entity-json', {guid: guid});
	};

	Database.prototype.getActivity = function() {
		return this.getObject('/activity-json');
	};
	
	Database.prototype.getUsers = function(data) {
		return this.getObject('/users-json', data);
	};
	
	Database.prototype.getPlugin = function(id) {
		return this.getObject('/admin/plugins-json', {id:id});
	};

	Database.prototype.getAlbums = function() {
		return this.getObject('/albums-json');
	};
	
	return Database;
});
