<?php

class EvanDatabase {	

	public function getPrefix() {
		global $CONFIG;
		return $CONFIG->dbprefix;
	}

	public function getUsers() {
		return new EvanUsersQuery($this);
	}
	
	public function getEntities() {
		return new EvanEntitiesQuery($this);
	}
}