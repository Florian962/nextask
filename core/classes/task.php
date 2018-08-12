<?php
     //met extends krijgen de taken info uit de user list
    class Task extends User {
       
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function tasks($user_id, $listBy, $list_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `tasks`, `lists`, `users` WHERE `taskIn` = `list_id` AND `listBy` = :user_id AND `user_id` = :listBy AND `list_id` = :list_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $stmt->execute();

            $tasks = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            foreach ($tasks as $task) {
                echo '
                    
                    <a class="list__block--task fat-text" href="'.BASE_URL.'php/task.php?task_id='.$task->task_id.'&list_id=">'.$task->task.'</a>
                    <a class="list__block--duration" href="'.BASE_URL.'php/task.php?task_id='.$task->task_id.'">'.$task->duration.' hours</a>
                    <a class="list__block--deadline" href="'.BASE_URL.'php/task.php?task_id='.$task->task_id.'">'.$task->deadline.'</a>
                ';
            }
        }
        

    }
?>