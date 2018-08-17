<?php
     //met extends krijgen de taken info uit de user list
    class Task extends User {
       
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

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

        public function comments($task_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `user_id` WHERE `commentOn` = :task_id AND `commentActive` = 1");
            $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function taskDelete($task_id, $user_id) {
            /* Eerst checken of de task bestaat */
            /*$check = $this->pdo->prepare("SELECT `listBy` FROM `lists` WHERE `list_id` = :list_id");
            $check->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $check->execute();

            /* geeft een int terug die gelijk moet zijn aan de user_id */
           /* $userCheck = $check->fetch(PDO::FETCH_ASSOC)['listBy'];

            if($userCheck == $user_id) {*/
                $stmt = $this->pdo->prepare("UPDATE `tasks` SET `taskActive` = :taskActive WHERE `task_id` = :task_id");
                //var_dump($list_id);
                $taskActive = 0;
                $stmt->bindParam(":taskActive", $taskActive, PDO::PARAM_INT);
                $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
                $stmt->execute();
           /* }*/
        }

        public function taskStatus($task_id, $user_id) {
            /* Eerst checken of de task bestaat */
            /*$check = $this->pdo->prepare("SELECT `listBy` FROM `lists` WHERE `list_id` = :list_id");
            $check->bindParam(":list_id", $list_id, PDO::PARAM_INT);
            $check->execute();

            /* geeft een int terug die gelijk moet zijn aan de user_id */
           /* $userCheck = $check->fetch(PDO::FETCH_ASSOC)['listBy'];

            if($userCheck == $user_id) {*/
                $stmt = $this->pdo->prepare("UPDATE `tasks` SET `taskStatus` = :task_status WHERE `task_id` = :task_id");
                //var_dump($list_id);
                $task_status = "DONE";
                $stmt->bindParam(":task_status", $task_status, PDO::PARAM_STR, 10);
                $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
                $stmt->execute();
           /* }*/
        }

        function uploadImage($file) {
            $filename    = basename($file['name']);
            $fileTmp     = $file['tmp_name'];
            $fileSize    = $file['size'];
            $fileError   = $file['error'];

            $ext         = explode('.', $filename);
            $ext         = strtolower(end($ext));
            $allowed_ext = array('jpg', 'jpg', 'pdf');

            if(in_array($ext, $allowed_ext) === true) {
                if($fileError === 0) {
                    if($fileSize <= 209272152) {
                        $fileRoot = '../users/' . $filename;
                        move_uploaded_file($fileTmp, $fileRoot);
                        return $fileRoot;
                    }
                    else {
                        $GLOBALS['imageError'] = "The filesize is too big.";
                    }
                }
                else {
                    $GLOBALS['imageError'] = "The extension is not allowed.";
                }
            }
           
        }
    }
?>