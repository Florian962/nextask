<?php
     //met extends krijgen de taken info uit de user list
    class Task extends User {
       
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function tasks($user_id, $listBy) {
            $stmt = $this->pdo->prepare("SELECT * FROM `tasks`, `lists`, `users` WHERE `taskIn` = `list_id` AND `listBy` = :user_id AND `user_id` = :listBy");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->execute();

            $tasks = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            foreach ($tasks as $task) {
                echo '
                    
                        <li class="list__block--task fat-text">'.$task->task.'</li>
                        <li class="list__block--duration">'.$task->duration.' hours</li>
                        <li class="list__block--deadline">'.$task->deadline.'</li>
                ';
            }
        }
        

    }
?>