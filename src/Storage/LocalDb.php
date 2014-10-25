<?php
namespace Evan\Storage;

use ElggUser as User;


/**
 * This is an in-memory DB that implements the Evan_Db interface.
 * Useful for testing.
 */
class LocalDb implements Db {
    private $nextGuid = 1;
    
    // The current user for purposes of access control.
    // NULL means logged out.
    private $currentUser = NULL;
    
    // The entities table.
    private $entities = array();
    
    // The relationships table.
    private $relationships = array();
    
    /** @override */
    public function getUser() {
        return $_SESSION['user'];
    }

    /** @override */
    public function setUser(User $user = NULL) {
        $_SESSION['user'] = $user;
        return $this;
    }

    public function getEntities(array $options = array()) {
        return new EvanUsersQuery($this);
    }
    
    public function saveEntity(array $fields = array()) {
        $guid = $nextGuid;
        $fields['guid'] = $guid;
        $entities[$guid] = $fields;
        $nextGuid++; // Successfully saved, so increment this.
    }
}