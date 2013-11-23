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

}
?>
