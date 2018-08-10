<?php
    class Todolist extends User { /*met extends krijgen de lijsten info uit de User class*/
        /* protected pdo kan weg omdat dit al in user class staat */
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function lists($user_id, $listBy) {
            $stmt = $this->pdo->prepare("SELECT * FROM `lists`, `users` WHERE `listBy` = :user_id AND `user_id` = :listBy");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->execute();

            $lists = $stmt->fetchAll(PDO::FETCH_OBJ);

            foreach($lists as $list) {
                echo'
                    <article class="list">
                        <a href="#">
                            <h3>'.$list->listtitle.'</h3>
                            <ul class="list__block">
                                    <li class="list__block--task fat-text">Task</li>
                                    <li class="list__block--duration">2h & 20min</li>
                                    <li class="list__block--deadline">08/09/18</li>
                            </ul> 
                        </a>
                    
                    </article>
                ';
            }
        }
    }
?>