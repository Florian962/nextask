<?php

    include '../init.php';
    if(isset($_POST['deleteTask']) && !empty($_POST['deleteTask'])){
        $task_id = $_POST['deleteTask'];
        $user_id = $_SESSION['user_id'];
        $task    = $getFromT->taskDelete($task_id, $user_id);
    }
?>

