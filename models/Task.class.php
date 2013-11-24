<?php
require_once 'Model.class.php';

/**
 * Class: Task
 * Extend the Model to add unique code for Tasks
 */
class Task extends Model
{
    /**
     * Function: create
     * When creating a task store the current time,
     * and convert the datepicker date format into a MySQL format.
     */
    public function create(Array $attrs) {
        $attrs['created'] = date("Y-m-d H:i:s");
        $slashDue = $attrs['due'];
        $due = explode('/', $attrs['due']);
        $attrs['due'] = $due[2] . '-' . $due[0] . '-' . $due[1];

        $attrs = parent::create($attrs);
        $attrs['due'] = $slashDue;

        return $attrs;
    }

    /**
     * Function: update
     * When updating a task convert the datepicker
     * format into MySQL format
     */
    public function update(Array $attrs) {
        if (array_key_exists('due', $attrs)) {
            $slashDue = $attrs['due'];
            $due = explode('/', $attrs['due']);
            $attrs['due'] = $due[2] . '-' . $due[0] . '-' . $due[1];
        }
        $attrs = parent::update($attrs);
        $attrs['due'] = $slashDue;

        return $attrs;
    }

    /**
     * Function: complete
     * Mark a task as complete by setting a
     * completed time
     * 
     * Parameters:
     * id (int) - The id of the task to complete
     */
    public function complete($id) {
        $attrs['completed'] = date("Y-m-d H:i:s");
        $attrs['id'] = $id;
        return $this->update($attrs);
    }

    /**
     * Function: completed
     * Get all the tasks that a user has completed
     *
     * Parameters:
     * id (int) - The id of the user whose tasks
     * are to be retrived
     */
    public function completed($id) {
        $sql = "SELECT * FROM $this->model WHERE user=? AND completed IS NOT NULL";
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(Array($id));
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
