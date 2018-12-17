<?php

class Database
{ 

    private function attributes ()
    {
        $string = array();
        global $dbh;
        foreach ($this->dbfields as $field) {
            if (is_int($this->$field) || is_double($this->$field)) {
                $string[] = $field . " = " . $this->$field . "";
            } else {
                $string[] = $field . " = " .$dbh->quote($this->$field);
            }
        }
        return implode(",", $string);
    }
    private function add () {
        global $dbh;
        $sql = "INSERT INTO " . $this->tableName . " SET " . $this->attributes();
        if ($dbh->exec($sql) != false) {
            $this->id = $dbh->lastInsertId();//build in function return last inserted id
        } else {
            return false;
        }
        return true;
    }
    private function update () {
        global $dbh;
        $sql = "UPDATE " . $this->tableName . " SET " . $this->attributes() .
                 ' WHERE id = ' . $this->id;
        $affectedRows = $dbh->exec($sql);
        return $affectedRows != false ? true : false;
    }
    public function delete () {
        global $dbh;
        $sql = "DELETE FROM " . $this->tableName . ' WHERE id = ' . $this->id;
        $affectedRows = $dbh->exec($sql);
        return $affectedRows != false ? true : false;
    }
    //To add or updates New Records instead of using add,update methods
    public function save() {
        return ($this->id === null) ? $this->add() : $this->update();
    }
    //read from tables
    public static function read($sql, $type = PDO::FETCH_ASSOC, $class = null)
    {
        global $dbh;
        $results = $dbh->query($sql);
        if($results) {
            if(null !== $class && $type == PDO::FETCH_CLASS) {
                $data = $results->fetchAll($type, $class);
            } else {
                $data = $results->fetchAll($type);
            }
            if(count($data) == 1) {
                $data = array_shift($data);
            }
            return $data;
        } else {
            return false;
        }
    }
}