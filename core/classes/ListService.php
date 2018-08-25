<?php

    require_once 'ValueObjects/List.php';


    class listService {

        protected $db;

        function __construct(){
            $this->db = Database::getInstance();
        }

        public function createList($fields = array()) {
            $columns = implode(',', array_keys($fields));
            $values  = ':'.implode(', :', array_keys($fields));
            $sql     = "INSERT INTO `lists` ({$columns}) VALUES ({$values})";
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
        public function getLists($user_id) {
            /*LIJSTEN*/
            $stmt = $this->db->getPDO()->prepare("SELECT * FROM `lists` AS l LEFT JOIN `tasks` AS t ON t.taskIn = l.list_id WHERE l.listBy = :user_id AND listActive = 1");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $todoLists = array();

            foreach($lists as $key => $list) {
                if ($key === 0) {
                    $todoLists[] = array(
                        'list_id' => $list['list_id'],
                        'listtitle' => $list['listtitle'],
                        'listBy' => $list['listBy'],
                        'listPostedOn' => $list['listPostedOn'],
                        'listActive' => $list['listActive'],
                        'tasks' => array();
                    );
                }
                if (isset($lists[$key+1]) &&
                    $list['list_id'] !== $lists[$key+1]['list_id']) {
                    $todoLists[] = array(
                        'list_id' => $lists[$key+1]['list_id'],
                        'listtitle' => $lists[$key+1]['listtitle'],
                        'listBy' => $lists[$key+1]['listBy'],
                        'listPostedOn' => $lists[$key+1]['listPostedOn'],
                        'listActive' => $lists[$key+1]['listActive'],
                        'tasks' => array();
                    );
                }
    
                if ($list['task_id'] !== null) {
                    $task = new Task();
                    $task->fetchTaskFromDb($list);
                    foreach($todoLists as $index => $todoList) {
                        if ($task->getTaskIn() === $todoList['list_id']) {
                            $todoLists[$index]['tasks'][] = $task;
                        }
                    }
                }
            }
    
            $tls = array();
            foreach ($todoLists as $todoList) {
                $tl = new TodoList();
                $tl->fetchListFromDb($todoList);
                $tls[] = $tl;
            }
    
            return $tls;
        }

        /* Function that returns tasks. */
         public function tasks($user_id, $listBy, $list_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `tasks`, `lists`, `users` WHERE `taskIn` = `list_id` AND `listBy` = :user_id AND `user_id` = :listBy AND `list_id` = :list_id AND taskActive = 1 ORDER BY `deadline` ASC");
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

        /* Function to delete a list. */
        public function listDelete($list_id, $user_id) {
            /* Eerst checken of de list bestaat */
            $check = $this->pdo->prepare("SELECT `listBy` FROM `lists` WHERE `list_id` = :list_id");
            $check->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $check->execute();

            /* geeft een int terug die gelijk moet zijn aan de user_id */
            $userCheck = $check->fetch(PDO::FETCH_ASSOC)['listBy'];

            if($userCheck == $user_id) {
                $stmt = $this->pdo->prepare("UPDATE `lists` SET `listActive` = 0 WHERE `list_id` = :list_id");
                //var_dump($list_id);
                $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        /* Function that returns list data. */
        public function listData($list_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `lists` WHERE `list_id` = :list_id");
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
            if($stmt = $this->pdo->prepare($sql)) {
                foreach ($fields as $key => $value) {
                    $stmt->bindValue(':'.$key, $value); 
                }
                /*var_dump($sql);*/
                $stmt->execute();
            }
        }
    }
?>