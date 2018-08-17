<?php
    include '../init.php';
    if(isset($_POST['deleteComment']) && !empty($_POST['deleteComment'])){
        $comment_id = $_POST['deleteComment'];
        $user_id = $_SESSION['user_id'];
        $comment    = $getFromC->commentDelete($comment_id, $user_id);
    }
?>
