<?php

class Evan_Db_Mysql implements Evan_Db {
    public function getPrefix() {
		global $CONFIG;
		return $CONFIG->dbprefix;
	}
    
    public function addMetastring($metastring) {
        return add_metastring($metastring);
    }

    /** @override */
    public function getUser() {
        return $_SESSION['user'];
    }

    /** @override */
    public function setUser(ElggUser $user = NULL) {
        $_SESSION['user'] = $user;
        return $this;
    }

	public function getUsers() {
		return new EvanUsersQuery($this);
	}
	
    /** @override */
	public function getEntities(array $options = array()) {
        if (empty($options)) {
            // Experimental API
		    return new EvanEntitiesQuery($this);
        } else {
            return elgg_get_entities_from_metadata($options);
        }
	}
}

