<?php
     //met extends krijgen de taken info uit de user list
    class Task extends User {
       
        /*protected $pdo;*/

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        /* Function that checks if task is already in db. */
        public function checkTask ($task) {
            $stmt = $this->pdo->prepare("SELECT `task` FROM `tasks` WHERE `task` = :task");
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

        /* Function that returns tasks. */
        public function tasks($user_id, $listBy, $list_id) {
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

        /* Function that returns comments. */
        public function comments($task_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `user_id` WHERE `commentOn` = :task_id AND `commentActive` = 1");
            $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        /* Function to delete a task. */
        public function taskDelete($task_id, $user_id) {

                $stmt = $this->pdo->prepare("UPDATE `tasks` SET `taskActive` = :taskActive WHERE `task_id` = :task_id");
                //var_dump($list_id);
                $taskActive = 0;
                $stmt->bindParam(":taskActive", $taskActive, PDO::PARAM_INT);
                $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
                $stmt->execute();
        }

        /* Function to change task status. */
        public function taskStatus($task_id, $user_id) {
                $stmt = $this->pdo->prepare("UPDATE `tasks` SET `taskStatus` = :task_status WHERE `task_id` = :task_id");
                //var_dump($list_id);
                $task_status = "DONE";
                $stmt->bindParam(":task_status", $task_status, PDO::PARAM_STR, 10);
                $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
                $stmt->execute();
        }

        /* Function to upload an image. */
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