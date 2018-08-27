<?php
    class TodoList { /*met extends krijgen de lijsten info uit de User class*/
        /* protected pdo kan weg omdat dit al in user class staat */
        /*protected $pdo;*/

        protected $db;

        /* zo kan deze klasse aan de db. */
        public function __construct() {
            $this->db = Database::getInstance();
        }

         /* Function to create table in db. */
         public function createList($table, $fields = array()) {
            $columns = implode(',', array_keys($fields));
            $values  = ':'.implode(', :', array_keys($fields));
            $sql     = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
            /*var_dump($sql);*/
            if($stmt = $this->db->getPDO()->prepare($sql)){
                foreach ($fields as $key => $data) {
                    $stmt->bindValue(':'.$key, $data);
                }  
                $stmt->execute();
            }
        }       

        /* Function that returns lists. */
        public function getLists($user_id, $listBy) {

            /*LIJSTEN*/
            $stmt = $this->db->getPDO()->prepare("SELECT * FROM `lists`, `users` WHERE `listBy` = :user_id AND listActive = 1 AND `user_id` = :listBy");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        /* Function to delete a list. */
        public function deleteList($list_id, $user_id) {
            /* Eerst checken of de list bestaat */
            $check = $this->db->getPDO()->prepare("SELECT `listBy` FROM `lists` WHERE `list_id` = :list_id");
            $check->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $check->execute();

            /* geeft een int terug die gelijk moet zijn aan de user_id */
            $userCheck = $check->fetch(PDO::FETCH_ASSOC)['listBy'];

            if($userCheck == $user_id) {
                $stmt = $this->db->getPDO()->prepare("UPDATE `lists` SET `listActive` = 0 WHERE `list_id` = :list_id");
                //var_dump($list_id);
                $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        /* Function that returns tasks. */
        public function getTodoListTasks($user_id, $listBy, $list_id) {
            $stmt = $this->db->getPDO()->prepare("SELECT * FROM `tasks`, `lists`, `users` WHERE `taskIn` = `list_id` AND `listBy` = :user_id AND `user_id` = :listBy AND `list_id` = :list_id AND taskActive = 1 ORDER BY `deadline` ASC");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        /* Function to delete a task. */
        public function deleteTask($task_id, $user_id) {

                $stmt = $this->db->getPDO()->prepare("UPDATE `tasks` SET `taskActive` = :taskActive WHERE `task_id` = :task_id");
                //var_dump($list_id);
                $taskActive = 0;
                $stmt->bindParam(":taskActive", $taskActive, PDO::PARAM_INT);
                $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
                $stmt->execute();
        }

        /* Function to change task status. */
        public function changeTaskStatus($task_id, $user_id) {
            $stmt = $this->db->getPDO()->prepare("UPDATE `tasks` SET `taskStatus` = :task_status WHERE `task_id` = :task_id");
            //var_dump($list_id);
            $task_status = "DONE";
            $stmt->bindParam(":task_status", $task_status, PDO::PARAM_STR, 10);
            $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        /* Function to delete a comment. */
        public function deleteComment($comment_id, $user_id) {
                $stmt = $this->db->getPDO()->prepare("UPDATE `comments` SET `commentActive` = :commentActive WHERE `comment_id` = :comment_id");
                //var_dump($list_id);
                $commentActive = 0;
                $stmt->bindParam("commentActive", $commentActive, PDO::PARAM_INT);
                $stmt->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
                $stmt->execute();
        }
        /* Function that returns list data. */
        public function listData($list_id) {
            $stmt = $this->db->getPDO()->prepare("SELECT * FROM `lists` WHERE `list_id` = :list_id");
            $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        }

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