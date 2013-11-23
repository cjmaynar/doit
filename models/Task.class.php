<?php
require_once 'Model.class.php';

class Task extends Model
{
    public function create(Array $attrs) {
        $attrs['created'] = date("Y-m-d H:i:s");
        $slashDue = $attrs['due'];
        $due = explode('/', $attrs['due']);
        $attrs['due'] = $due[2] . '-' . $due[0] . '-' . $due[1];

        $attrs = parent::create($attrs);
        $attrs['due'] = $slashDue;

        return $attrs;
    }

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
