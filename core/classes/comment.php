<?php
     //met extends krijgen de taken info uit de user list
    class Comment {
       
        protected $db;

        /* zo kan deze klasse aan de db. */
        public function __construct() {
            $this->db = Database::getInstance();
        }

        /* Function to create table in db. */
        public function createComment($table, $fields = array()) {
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

        /* Function that returns comments. */
        public function getComments($task_id) {
            $stmt = $this->db->getPDO()->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `user_id` WHERE `commentOn` = :task_id AND `commentActive` = 1");
            $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        /* Function that returns the task that can be commented. */
        public function taskToComment($user_id, $listBy, $list_id, $task_id) {
            $stmt = $this->db->getPDO()->prepare("SELECT * FROM `tasks`, `lists`, `users` WHERE `taskIn` = `list_id` AND `listBy` = :user_id AND `user_id` = :listBy AND `list_id` = :list_id AND `task_id` = :task_id AND taskActive =1");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
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
                    <div class="task__block--hover task__block--bottom">
                        <a href="edittask.php?task_id='.$task->task_id.'&list_id='.$list_id.'" class="task__block--edit"><img src="'.BASE_URL.'assets/images/edit.png" alt="Edit" class="taskbin"></a>
                        <p class="task__block--task fat-text">'.$task->task.'</p>
                        <p class="task__block--duration">'.$task->duration.' hours</p>
                        ';
                        if($task->deadline != 0) {
                            echo '<p class="task__block--deadline">'.$task->deadline.'</p>
                            ';
                            if ($diff <0) {
                                echo '<p class="task__block--time danger">Deadline expired!</p>';
                            }
                            else if($days < 20) {
                                echo '<p class="task__block--time">'.$days.' days remaining.</p>';
                            }
                            
                        }
                echo '  <a href="#" class="task__block--status" data-task="'.$task->task_id.'">'.$task->taskStatus.'</a>
                        <a href="list.php?list_id='.$task->list_id.'" class="task__delete" data-task="'.$task->task_id.'"><img src="'.BASE_URL.'assets/images/bin.png" alt="bin" class="taskbin"></img></a>';
                        if(!empty($task->taskImage)) {
                            echo '<img class="taskImageDisplay" src="../'.$task->taskImage.'" alt""></img>';
                        }
                echo '

                    </div>  
                ';
            }
        }

        /* Function to delete a comment. */
        public function commentDelete($comment_id, $user_id) {
                $stmt = $this->pdo->prepare("UPDATE `comments` SET `commentActive` = :commentActive WHERE `comment_id` = :comment_id");
                //var_dump($list_id);
                $commentActive = 0;
                $stmt->bindParam("commentActive", $commentActive, PDO::PARAM_INT);
                $stmt->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
                $stmt->execute();
        }
    }
?>