<?php
namespace Evan;


/**
 * A service that wraps some of the elgg view-related functions.
 * 
 * Useful for passing as a dependency to improve testability.
 * 
 * Already included as ElggViewService in Elgg 1.9.
 */
class Viewer {
    public function view($name, $vars = array(), $viewtype = '') {
        return \elgg_view($name, $vars, false, false, $viewtype);
    }
    
}