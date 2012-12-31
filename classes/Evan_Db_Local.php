<?php

/**
 * This is an in-memory DB that implements the Evan_Db interface.
 * Useful for testing.
 */
class Evan_Db_Local implements Evan_Db {
    private $nextGuid = 1;
    
    // The current user for purposes of access control.
    // NULL means logged out.
    private $currentUser = NULL;
    
    // The entities table.
    private $entities = array();
    
    // The relationships table.
    private $relationships = array();
    
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