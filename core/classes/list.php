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
                return $this->db->getPDO()->lastInsertId();
            }
        }       

        /* Function that returns lists. */
        public function getLists($user_id, $listBy) {

            /*LIJSTEN*/
            $stmt = $this->db->getPDO()->prepare("SELECT * FROM `lists`, `users` WHERE `listBy` = :user_id AND listActive = 1 AND `user_id` = :listBy");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->execute();

            $lists = $stmt->fetchAll(PDO::FETCH_OBJ);

            foreach($lists as $list) {
                echo '
                <article class="list">
                    <a href="'.BASE_URL.'php/list.php?list_id='.$list->list_id.'" class="list__title"><h3>'.$list->listtitle.'</h3></a>
                    <a href="#" class="list__delete" data-list="'.$list->list_id.'"><img src="'.BASE_URL.'assets/images/bin.png" alt="bin" class="bin"></a>           
                </article>    
                ';
            }
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
         public function tasks($user_id, $listBy, $list_id) {
            $stmt = $this->db->getPDO()->prepare("SELECT * FROM `tasks`, `lists`, `users` WHERE `taskIn` = `list_id` AND `listBy` = :user_id AND `user_id` = :listBy AND `list_id` = :list_id AND taskActive = 1 ORDER BY `deadline` ASC");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $stmt->execute();

            $tasks = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            foreach ($tasks as $task) {
                echo '
                    <div class="task__block--hover">
                        <a class="task__block--task fat-text" href="'.BASE_URL.'php/task.php?task_id='.$task->task_id.'&list_id='.$list_id.'">'.$task->task.'</a>
                        <a class="task__block--duration" href="'.BASE_URL.'php/task.php?task_id='.$task->task_id.'&list_id='.$list_id.'">'.$task->duration.' hours</a>
                        ';
                        if($task->deadline != 0) {
                            echo '<a class="task__block--deadline" href="'.BASE_URL.'php/task.php?task_id='.$task->task_id.'&list_id='.$list_id.'">'.$task->deadline.'</a>';
                        }
                echo '
                        <a href="#" class="task__block--status" data-task="'.$task->task_id.'">'.$task->taskStatus.'</a>
                        <a href="#" class="task__delete" data-task="'.$task->task_id.'"><img src="'.BASE_URL.'assets/images/bin.png" alt="bin" class="taskbin"></a>
                    </div>
                ';
            }
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