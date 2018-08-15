<?php
    include '../init.php';
    if(isset($_POST['statusTask']) && !empty($_POST['statusTask'])){
        $task_id = $_POST['statusTask'];
        $user_id = $_SESSION['user_id'];
        $task    = $getFromT->taskStatus($task_id, $user_id);

    }
?>