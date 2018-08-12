<?php
     //met extends krijgen de taken info uit de user list
    class Comment extends User {
       
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function taskToComment($user_id, $listBy, $list_id, $task_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `tasks`, `lists`, `users` WHERE `taskIn` = `list_id` AND `listBy` = :user_id AND `user_id` = :listBy AND `list_id` = :list_id AND `task_id` = :task_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
            $stmt->execute();

            $tasks = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            foreach ($tasks as $task) {
                echo '
                    
                    <p class="list__block--task fat-text">'.$task->task.'</p>
                    <p class="list__block--duration">'.$task->duration.' hours</p>
                    <p class="list__block--deadline">'.$task->deadline.'</p>
                ';
            }
        }
        

    }
?>