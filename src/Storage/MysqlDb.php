<?php
namespace Evan\Storage;

use ElggUser as User;

class MysqlDb implements Db {
    public function getPrefix() {
		global $CONFIG;
		return $CONFIG->dbprefix;
	}
    
    public function addMetastring($metastring) {
        return \add_metastring($metastring);
    }

    /** @override */
    public function getUser() {
        return $_SESSION['user'];
    }

    /** @override */
    public function setUser(User $user = NULL) {
        $_SESSION['user'] = $user;
        return $this;
    }

	public function getUsers() {
		return new UsersQuery($this);
	}
	
    /** @override */
	public function getEntities(array $options = array()) {
        if (empty($options)) {
            // Experimental API
		    return new EntitiesQuery($this);
        } else {
            return \elgg_get_entities_from_metadata($options);
        }
	}
}

