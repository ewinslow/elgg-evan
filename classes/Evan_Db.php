<?php

interface Evan_Db {
    
    // entities.create
    // entities.getByGuid
    // entities.get
    // entities.getFromAnnotations
    // entities.getFromRelationship
    // entities.exists (ignores access control)
    // entities.update
    // entities.delete

    // This should be the equivalent of elgg_get_entities_from_metadata
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