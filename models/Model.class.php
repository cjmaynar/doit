<?php
/**
 * Abstract: Model
 * A base class that all models will inherit.
 * Provides a wrapper for PDO queries.
 */
abstract class Model {
    public function __construct(PDO $DBH) {
        $this->db = $DBH;
        $this->model = strtolower(get_class($this)) . 's';
    }

    public function create(Array $attrs) {
        $attrs['user'] = 1;

        $sql = "INSERT INTO $this->model ";
        $sql .= '(' . implode(', ', array_keys($attrs)) . ') ';
        $sql .= 'VALUES (' . implode(',', array_fill(0, count($attrs), '?')) . ')';

        error_log($sql);
        error_log(print_r($attrs, true));

        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(array_values($attrs));
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }

    public function update(Array $attrs) {
        $id = $attrs['id'];
        unset($attrs['id']);

        $sql = "UPDATE $this->model SET ";
        foreach ($attrs as $key => $val) {
            $sql .= "$key = ? ";
        }

        $sql .= "WHERE id = ?";
        $attrs['id'] = $id;
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(array_values($attrs));
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }

    }

    public function get($key, $value) {
        $sql = "SELECT * FROM $this->model ";
        $sql .= "WHERE $key=?";
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(Array($value));
        } catch (PDOException $e) {
            return false;
        }
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->model WHERE id=?";
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(Array($id));
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}
?>
