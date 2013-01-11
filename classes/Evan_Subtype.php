<?php
/**
 * Provides a mechanism for configuring the properties and features that entities
 * of a given subtype possess, as well as the restrictions on those features
 * for the sake of simplifying data validation, which otherwise can get tedious
 * and repetetive.
 */
class Evan_Subtype {
    private $properties = array();
    
    private $relationships = array();
    
    private $annotations = array();
    
    private $images = array();

    /**
     * Register a new property for entities of this subtype.
     * 
     * This typically ends up being metadata, since all the core properties have
     * already been defined.
     * 
     * The `$options` array allows you to specify limitations and restrictions
     * to put on the property in question. The options are inspired by HTML5.
     * 
     * * "type" - HTML5-inspired data type field ("number", "datetime", etc.)
     * * "max"/"min" - The maximum and/or minimum number value, respectively.
     * * "maxlength/minlength" - The max and/or min string length, respectively.
     * * "required" - Whether the field is mandatory.
     * * "options" - a whitelist of valid values for this property
     * * "multiple" - whether this can be an array of values (e.g. tags)
     * 
     * There is no plan to provide "validate" or "filter" options where
     * you can pass callback functions. Instead, we expect we would fire plugin
     * hooks for those two cases.
     * 
     * @example
     * // "Places have a locality property that can be any text value"
     * $places->registerProperty('locality');
     * 
     * @example
     * // "Places have a required country field that must be a valid country"
     * $places->registerProperty('country', array(
     *     'type' => 'country',
     *     'required' => true,
     * ));
     * 
     * @example
     * // "Reviews can have ratings between 1 and 5 with a precision of .5"
     * $reviews->registerProperty('rating', array(
     *     'type' => 'number',
     *     'step' => 0.5,
     *     'min' => 1,
     *     'max' => 5,
     * ));
     * 
     * @example
     * // "Users must have usernames which are alphanumeric, 4-10 characters long"
     * $users->registerProperty('username', function(
     *     'pattern' => '[A-Za-z0-9]*',
     *     'minlength' => 4,
     *     'maxlength' => 10,
     *     'required' => true,
     * ));
     * 
     * @param string $name The name of the field.
     * @param array $options Defines valid values for the field.
     * @return Evan_Subtype The subtype instance for chaining.
     */
    public function registerProperty($name, array $options = array()) {
        if (!isset($this->properties[$name])) {
            $this->properties[$name] = array();
        }
        
        $this->properties[$name] = array_merge($this->properties[$name], $options);
        return $this;
    }
    
    /**
     * Delete the configuration for the given property.
     * @return Evan_Subtype The subtype instance for chaining.
     */
    public function unregisterProperty($name) {
        unset($this->properties[$name]);
        return $this;
    }

    /**
     * Tells Elgg that entities of this subtype can be the subjects of a
     * relationship with the given name.
     * 
     * The options array defines the limitations of the relationship.
     * Firstly, what entities are allowed to act as objects of the relationship.
     * This is specified via the 'type' and 'subtype' arguments.
     * 
     * Secondly, you can also pass an argument call 'multiple', which is a
     * boolean. This argument determines whether entities are permitted to have
     * multiple objects for this particular relationship. The default value is
     * `true`.
     * 
     * Finally, there is the 'limit' option, which allows you to set a cap on
     * the number of relationships can be formed between one subject entity and
     * the object entities. This defaults to 0, which is interpreted to mean "no
     * limit."
     * 
     * @example
     * // "Groups can have up to 1000 users as members"
     * $groupSubtype->registerRelationship('member', array(
     *     'type' => 'user', // All members must be users
     *     'multiple' => true, // Groups can have many members
     *     'limit' => 1000, // ...but no more than 1000.
     * ));
     * 
     * @example
     * // "An entity can only be located in one place at a time"
     * $allSubtypes->registerRelationship('location', array(
     *     'type' => 'object',
     *     'subtype' => 'place', // Location must be a "place" object.
     *     'multiple' => false, // Can only be in one place at a time!
     *     'limit' => 12345, // Ignored. 'multiple' explicitly set to false.
     * ));
     * 
     * @example
     * // "Groups can have up to 2000 members"
     * $groupSubtype->registerRelationship('member', array(
     *     'limit' => 2000, // Just overrides this particular value.
     * ));
     * 
     * @example
     * // "Users can have an unlimited number of other users as friends"
     * $userSubtype->registerRelationship('friend', array(
     *     'type' => 'user',
     * ));
     * 
     * ElggEntity should add some more relationship functions to support the
     * single relationship use case.
     * 
     * setRelationship($name, ElggEntity $object);
     * getEntityFromRelationship($name);
     * 
     * @param string $name    The name of the relationship.
     * @param array  $options Relationship config. See examples.
     * @return Evan_Subtype The subtype instance for chaining.
     */
    public function registerRelationship($name, array $options = array()) {
        if (!isset($this->relationships[$name])) {
            $this->relationships[$name] = array();
        }
        
        $this->relationships[$name] = array_merge($this->relationships[$name], $options);
        return $this;
    }
    
    /**
     * Delete the configuration for the given relationship.
     * @return Evan_Subtype The subtype instance for chaining.
     */
    public function unregisterRelationship($name) {
        unset($this->relationships[$name]);
        return $this;
    }
        
    /**
     * Registers a new annotation for entities of this subtype.
     * 
     * Annotations are very similar to properties, except that each user has their
     * own annotation(s) of the given name on the entity. This affects the
     * semantics of "multiple". In this case, its always possible for the entity
     * to have multiple $name annotations on it, since each user can have one
     * of their own. However, setting multiple to "false" allows people to give
     * only one annotation of the kind before annotating again.
     * 
     * @example
     * // "Users can RSVP to events with 'yes', 'no', or 'maybe'".
     * $eventSubtype->registerAnnotation('rsvp', array(
     *     'options' => array('yes', 'no', 'maybe'),
     *     'multiple' => false, // Each user can only RSVP once!
     * ));
     * 
     * @param string $name    The name of the new annotation.
     * @param array  $options Annotation configuration. See examples.
     * @return Evan_Subtype The subtype instance for chaining.
     */
    public function registerAnnotation($name, array $options = array()) {
        if (!isset($this->annotations[$name])) {
            $this->annotations[$name] = array();
        }
        
        $this->annotations[$name] = array_merge($this->annotations[$name], $options);
        return $this;
        
    }

    /**
     * Delete the configuration for the given annotation.
     * @return Evan_Subtype The subtype instance for chaining.
     */
    public function unregisterAnnotation($name) {
        unset($this->annotations[$name]);
        return $this;
    }
    
    /**
     * Registers a named image to be associated with entities of this subtype.
     * 
     * Think icons, cover photos, favicons, screenshots, etc. 
     * 
     * Arguments passed are sizes that specify width/height. The width/height
     * ratio of the smaller sizes should be the same as the master size in order
     * to prevent a skewed look.
     *  * master -- the upload size
     *  * large -- typically smaller than master
     *  * medium -- smaller than large
     *  * small -- size used for avatars in the activity stream
     *  * tiny -- size used for comments on items in the activity stream
     *  * topbar -- smallest size, for fitting in the Elgg topbar
     * 
     * @example
     * // "Places can have huge background photos"
     * $places->registerImage('background', array(
     *     'master' => array(
     *         'width' => 4096,
     *         'height' => 3072,
     *     ),
     * ));
     *
     * @example
     * // "Users can upload a profile cover photo that is 960x480"
     * // "small, medium, and large versions will be automatically cached too"
     * $users->registerImage('cover', array(
     *     'small' => array(
     *         'width' => 120,
     *         'height' => 60,
     *     ),
     *     'medium' => array(
     *         'width' => 240,
     *         'height' => 120,
     *     ),
     *     'large' => array(
     *         'width' => 480,
     *         'height' => 240,
     *     ),
     *     'master' => array(
     *         'width' => 960,
     *         'height' => 480,
     *     ),
     * ));
     * 
     * @param string $name    Describes the relationship of the image to the entity.
     * @param array  $options Configures the image.
     * @return Evan_Subtype The subtype instance for chaining.
     */
    public function registerImage($name, array $options = array()) {
        if (!isset($this->images[$name])) {
            $this->images[$name] = array();
        }
        
        $this->annotations[$name] = array_merge($this->annotations[$name], $options);
        return $this;
    }
    
    /**
     * Delete the configuration for the given image.
     * @return Evan_Subtype The subtype instance for chaining.
     */
    public function unregisterImage($name) {
        unset($this->images[$name]);
        return $this;
    }
}