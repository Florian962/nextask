<?php
    include '../init.php';
    require_once '../classes/Comment.php';

    $comment = new Comment();

    if(isset($_POST['comment']) && !empty($_POST['comment'])){
        $commentText = checkInput($_POST['comment']);
        $commentText = ucfirst($commentText).'.';
        $user_id = $_SESSION['user_id'];
        $listBy = $user_id;


        $task_id = $_POST['task_id'];

        if(!empty($commentText)){
            $comment->createComment('comments', array('comment' => $commentText, 'commentOn' => $task_id, 'commentBy' => $user_id, 'commentAt' => date('Y-m-d H:i:s'), 'commentActive' => 1));
            $comments = $comment->getComments($task_id);
            //$task = $getFromT->tasks($user_id, $listBy); 

            foreach ($comments as $comment) {
                echo '
                <div class="comments__comment">
                    <img src="../assets/images/profileIcon.png" alt="profileIcon">
                    <p>'.$comment->comment.'</p>
                    <a href="#" class="comment__delete" data-comment="'.$comment->comment_id.'"><img src="../assets/images/bin2.png" alt="bin" class="commentbin"></a>
                    <div></div>
                </div>
                
                ';
            }
        }
    }

?>
