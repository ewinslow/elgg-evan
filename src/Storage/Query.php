<?php
namespace Evan\Storage;

interface Query {
    public function getItems($limit = 10, $offset = 0);
        
    public function getTotalItems();
}