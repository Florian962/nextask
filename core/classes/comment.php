<?php
     //met extends krijgen de taken info uit de user list
    class Comment extends User {
       
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function taskToComment($user_id, $listBy, $list_id, $task_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `tasks`, `lists`, `users` WHERE `taskIn` = `list_id` AND `listBy` = :user_id AND `user_id` = :listBy AND `list_id` = :list_id AND `task_id` = :task_id AND taskActive =1");
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
                $diff = abs(strtotime($deadline) - strtotime($dateToday));
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                
                echo '
                    <div class="task__block--hover task__block--bottom">
                        <p class="task__block--task fat-text">'.$task->task.'</p>
                        <p class="task__block--duration">'.$task->duration.' hours</p>
                        ';
                        if($task->deadline != 0) {
                            echo '<p class="task__block--deadline">'.$task->deadline.'</p>
                            ';
                            if($days < 20) {
                                echo '<p class="task__block--time">'.$days.' days remaining</p>';
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

        public function commentDelete($comment_id, $user_id) {
            /* Eerst checken of de task bestaat */
            /*$check = $this->pdo->prepare("SELECT `listBy` FROM `lists` WHERE `list_id` = :list_id");
            $check->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $check->execute();

            /* geeft een int terug die gelijk moet zijn aan de user_id */
           /* $userCheck = $check->fetch(PDO::FETCH_ASSOC)['listBy'];

            if($userCheck == $user_id) {*/
                $stmt = $this->pdo->prepare("UPDATE `comments` SET `commentActive` = :commentActive WHERE `comment_id` = :comment_id");
                //var_dump($list_id);
                $commentActive = 0;
                $stmt->bindParam("commentActive", $commentActive, PDO::PARAM_INT);
                $stmt->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
                $stmt->execute();
           /* }*/
        }
        

    }
?>