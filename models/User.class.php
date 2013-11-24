<?php
require_once 'Model.class.php';

class User extends Model
{
    /**
     * Function: create
     * Extend the base create method to require
     * username and password in the attrs array
     */
    public function create(Array $attrs) {
        if (array_key_exists('username', $attrs) && array_key_exists('password', $attrs)) {
            return parent::create($attrs);
        } else {
            return false;
        }
    }
}
?>
