<?php
    include '../init.php';
    if(isset($_POST['comment']) && !empty($_POST['comment'])){
        $comment = $getFromU->checkInput($_POST['comment']);
        $comment = ucfirst($comment).'.';
        $user_id = $_SESSION['user_id'];
        $listBy = $user_id;


        $task_id = $_POST['task_id'];

        if(!empty($comment)){
            $getFromU->create('comments', array('comment' => $comment, 'commentOn' => $task_id, 'commentBy' => $user_id, 'commentAt' => date('Y-m-d H:i:s') 'commentActive' => 1));
            $comments = $getFromT->comments($task_id);
            $task = $getFromT->tasks($user_id, $listBy); 

            foreach ($comments as $comment) {
                echo '
                <div class="comments__comment">
                    <img src="../assets/images/profileIcon.png" alt="profileIcon">
                    <p>'.$comment->comment.'</p>
                    <div></div>
                </div>
                
                ';
            }
        }
    }

?>
