<?php

    class Task {
       
        protected $db;

        /* zo kan deze klasse aan de db. */
        public function __construct() {
            $this->db = Database::getInstance();
        }

        /* Function that checks if task is already in db. */
        public function checkTask ($task) {
            $stmt = $this->db->getPDO()->prepare("SELECT `task` FROM `tasks` WHERE `task` = :task");
            $stmt->bindParam(":task", $task, PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();
            if($count > 0) {
                return true;
            }
            else {
                return false;
            }
        }

         /* Function to create table in db. */
         public function createTask($table, $fields = array()) {
            $columns = implode(',', array_keys($fields));
            $values  = ':'.implode(', :', array_keys($fields));
            $sql     = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
            /*var_dump($sql);*/
            if($stmt = $this->db->getPDO()->prepare($sql)){
                foreach ($fields as $key => $data) {
                    $stmt->bindValue(':'.$key, $data);
                }  
                $stmt->execute();
                return $this->db->getPDO()->lastInsertId();
            }
        }

        /* Function to update table in db. */
        public function updateTask($table, $task_id, $fields = array()) {
            $columns = '';
            $i       = 1; /* om velden te tellen*/

            foreach ($fields as $name => $value) {
                $columns .= "`{$name}` = :{$name}";
                if($i < count($fields)) {
                    $columns .= ', ';
                }
                $i++;
            }
            $sql = "UPDATE {$table} SET {$columns} WHERE `task_id` = {$task_id}";
            if($stmt = $this->db->getPDO()->prepare($sql)) {
                foreach ($fields as $key => $value) {
                    $stmt->bindValue(':'.$key, $value); 
                }
                /*var_dump($sql);*/
                $stmt->execute();
            }
        }
    }
?>