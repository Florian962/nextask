<?php

    require_once '../init.php';
    require_once '../classes/List.php';

    $todolist = new TodoList();


    if(isset($_POST['deleteList']) && !empty($_POST['deleteList'])){
        $list_id = $_POST['deleteList'];
        $user_id = $_SESSION['user_id'];
        $list    = $todolist->deleteList($list_id, $user_id);
    }
?>

