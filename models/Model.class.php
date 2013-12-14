<?php
namespace Models;
use \PDO, \PDOException;

/**
 * Abstract: Model
 * A base class that all models will inherit.
 * Provides a wrapper for PDO queries.
 */
abstract class Model {
    /**
     * Property: model
     * Stores the name of the concrete class
     */
    public $model = '';

    /**
     * Constructor: __construct
     * Takes in the PDO instance and stores it for the Model
     */
    public function __construct(PDO $DBH) {
        $this->db = $DBH;
        $classname = strtolower(get_class($this)) . 's';
        $this->model = explode('\\', $classname)[1];
    }

    /**
     * Function: create
     * Insert a new entry to the database
     * 
     * Parameters:
     * attrs (Array) - A key value array of the information
     * to be stored
     *
     * Returns:
     * A key value array of the saved item, plus the unique id
     */
    public function create(Array $attrs) {
        foreach ($attrs as $key => $value) {
            $attrs[$key] = strip_tags($value);
        }

        $sql = "INSERT INTO $this->model ";
        $sql .= '(' . implode(', ', array_keys($attrs)) . ') ';
        $sql .= 'VALUES (' . implode(',', array_fill(0, count($attrs), '?')) . ')';

        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(array_values($attrs));
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }

        $attrs['id'] = $this->db->lastInsertId();
        return $attrs;
    }

    /**
     * Function: update
     * Modify an existing item in the database
     *
     * Parameters:
     * attrs (Array) - A key value array of the properties
     * to be modified. Requires a key named 'id'
     *
     * Returns:
     * A key value array of the saved item, plus the unique id
     */
    public function update(Array $attrs) {
        if (!array_key_exists('id', $attrs)) {
            throw new Exception("attrs must contain an id key");
        }

        foreach ($attrs as $key => $value) {
            $attrs[$key] = strip_tags($value);
        }

        $id = $attrs['id'];
        unset($attrs['id']);

        $sql = "UPDATE $this->model SET ";
        foreach ($attrs as $key => $val) {
            $sql .= "$key=?, ";
        }
        $sql = trim($sql, ', ');
        $sql .= "WHERE id=?";

        $attrs['id'] = $id;
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(array_values($attrs));
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }

        return $attrs;
    }

    /**
     * Function: filter
     * Get multiple entries from the database that match
     * a given set of parameters
     *
     * Parameters:
     * params (Array) - A key value array used to lookup
     * entries
     *
     * Returns:
     * An array of the rows that matched the parameters
     * in separate key value arrays
     */
    public function filter(Array $params) {
        $sql = "SELECT * FROM $this->model WHERE ";
        foreach ($params as $key => $val) {
            if ($val == null) {
                $sql .= "$key IS NULL AND ";
                unset($params[$key]);
            } else {
                $sql .= "$key=? AND ";
            }
        }
        $sql = trim($sql, 'AND ');

        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(array_values($params));
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Function: delete
     * Delete a row from the database
     *
     * Parameters:
     * id (int) - The id of the row to be deleted
     *
     * Returns:
     * An empty array
     */
    public function delete($id) {
        $sql = "DELETE FROM $this->model WHERE id=?";
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(Array($id));
        } catch (PDOException $e) {
            return false;
        }
        return Array();
    }
}
?>
