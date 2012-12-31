<?php

interface Evan_Db_Collection {
    public function getItems($limit = 10, $offset = 0);
        
    public function getTotalItems();
}