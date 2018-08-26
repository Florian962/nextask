<?php
    include '../init.php';
    require_once '../classes/List.php';

    $todolist = new TodoList();

    if(isset($_POST['deleteComment']) && !empty($_POST['deleteComment'])){
        $comment_id = $_POST['deleteComment'];
        $user_id    = $_SESSION['user_id'];
        $comment    = $todolist->deleteComment($comment_id, $user_id);
    }
?>
