<?php
     //met extends krijgen de taken info uit de user list
    class Task extends User {
       
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function tasks() {
            $stmt = $this->pdo->prepare("SELECT * FROM `tasks`, `lists` WHERE `taskIn` = `list_id`");
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