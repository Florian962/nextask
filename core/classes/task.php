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

        












        /* Function that returns tasks. */
        public function getTasks($user_id, $listBy, $list_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `tasks`, `lists`, `users` WHERE `taskIn` = `list_id` AND `listBy` = :user_id AND `user_id` = :listBy AND `list_id` = :list_id AND taskActive = 1 ORDER BY `deadline` ASC");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $stmt->execute();

            $tasks = $stmt->fetchAll(PDO::FETCH_OBJ);
            

            foreach ($tasks as $task) {
                $deadline = $task->deadline;
                $dateToday = date("Y-m-d"); 
                /* SOURCE: https://stackoverflow.com/questions/676824/how-to-calculate-the-difference-between-two-dates-using-php */
                $diff = strtotime($deadline) - strtotime($dateToday);
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                
                echo '
                    <div class="task__block--hover">
                        <a href="edittask.php?task_id='.$task->task_id.'&list_id='.$list_id.'" class="task__block--edit"><img src="'.BASE_URL.'assets/images/edit.png" alt="Edit" class="taskbin"></a>
                        <a class="task__block--task fat-text underline" href="'.BASE_URL.'php/task.php?task_id='.$task->task_id.'&list_id='.$list_id.'">'.$task->task.'</a>
                        <a class="task__block--duration" href="'.BASE_URL.'php/task.php?task_id='.$task->task_id.'&list_id='.$list_id.'">'.$task->duration.' hours</a>
                        ';
                        if($task->deadline != 0) {
                            echo '<a class="task__block--deadline" href="'.BASE_URL.'php/task.php?task_id='.$task->task_id.'&list_id='.$list_id.'">'.$task->deadline.'</a>
                            ';
                            if ($diff <0) {
                                echo '<p class="task__block--time danger">Deadline expired!</p>';
                            }
                            else if($days < 20) {
                                echo '<p class="task__block--time">'.$days.' days remaining.</p>';
                            }  
                        }
                echo '
                        <a href="" class="task__block--status" data-task="'.$task->task_id.'">'.$task->taskStatus.'</a>
                        <a href="#" class="task__delete" data-task="'.$task->task_id.'"><img src="'.BASE_URL.'assets/images/bin.png" alt="bin" class="taskbin"></a>
                    </div>
                ';
            }
        }










        


    }
?>