<?php
    class Todolist extends User { /*met extends krijgen de lijsten info uit de User class*/
        /* protected pdo kan weg omdat dit al in user class staat */
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function lists($user_id, $listBy) {
            $stmt = $this->pdo->prepare("SELECT * FROM `lists`, `users` WHERE `listBy` = :user_id AND listActive = 1 AND `user_id` = :listBy");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":listBy", $listBy, PDO::PARAM_INT);
            $stmt->execute();

            $lists = $stmt->fetchAll(PDO::FETCH_OBJ);

            foreach($lists as $list) {
                echo'
                <article class="list">
                <a href="'.BASE_URL.'php/list.php" class="list__title"><h3>'.$list->listtitle.'</h3></a>
                <a href="#" class="list__delete" data-list="'.$list->list_id.'"><img src="'.BASE_URL.'assets/images/bin.png" alt="bin" class="bin"></a>
                <a href="#" class="list__tasks">
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

            public function showlist($list_id, $user_id) {
                $stmt = $this->pdo->prepare("SELECT * FROM `lists` WHERE `list_id` = :list_id");
                $stmt->bindParam(":list_id", $list_id, PDO::PARAM_INT);
                $stmt->execute();
            }
            
        }
    }
?>