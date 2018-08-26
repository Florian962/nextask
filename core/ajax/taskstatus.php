<?php
    include '../init.php';
    require_once '../classes/List.php';

    $todolist = new TodoList();

    if(isset($_POST['statusTask']) && !empty($_POST['statusTask'])){
        $task_id = $_POST['statusTask'];
        $user_id = $_SESSION['user_id'];
        $task    = $todolist->changeTaskStatus($task_id, $user_id);

    }
?>