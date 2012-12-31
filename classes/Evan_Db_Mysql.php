<?php

class Evan_Db_Mysql implements Evan_Db {
    public function getPrefix() {
		global $CONFIG;
		return $CONFIG->dbprefix;
	}

	public function getUsers() {
		return new EvanUsersQuery($this);
	}
	
	public function getEntities(array $options = array()) {
        if (empty($options)) {
            // Experimental API
		    return new EvanEntitiesQuery($this);
        } else {
            return elgg_get_entities($options);
        }
	}
}

