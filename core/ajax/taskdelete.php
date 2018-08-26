<?php
    include '../init.php';
    require_once '../classes/List.php';

    $todolist = new TodoList();

    if(isset($_POST['deleteTask']) && !empty($_POST['deleteTask'])){
        $task_id = $_POST['deleteTask'];
        $user_id = $_SESSION['user_id'];
        $task    = $todolist->deleteTask($task_id, $user_id);
    }
?>

