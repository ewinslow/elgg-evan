<?php
namespace Evan\Storage;

use ElggUser as User;

interface Db {
    
    /**
     * @return ElggUser The currently active user.
     */
    public function getUser();
    
    /**
     * Sets the current active user for this database connection. This affects
     * things like what entities and metadata are returned based on ACLs.
     */
    public function setUser(User $user = NULL);
    
    // entities.create
    // entities.getByGuid
    // entities.get
    // entities.getFromAnnotations
    // entities.getFromRelationship
    // entities.exists (ignores access control)
    // entities.update
    // entities.delete

    /**
     * This should be the equivalent of elgg_get_entities_from_metadata.
     */
    public function getEntities(array $options = array());
    
    
    // users
    
    // groups
    
    // sites
    
    // objects
    
    // relationships.create
    // relationships.get
    // relationships.exists
    // relationships.delete
    
    // annotations.create
    // annotations.getById
    // annotations.get
    // annotations.exists
    // annotations.update
    // annotations.delete
    
    // api_users
    
    // config
    
    // acls
    
    // data
    
    // river
    
    // log
    
    // sessions
    
    
    
    
}