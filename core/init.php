<?php
    include 'database/connection.php';
    include 'classes/user.php';
    include 'classes/list.php';
    include 'classes/task.php';
    include 'classes/comment.php';
    include 'classes/admin.php';

    /* om aan de conn te kunnen uit connection.php */
    global $pdo;

    session_start();

    $getFromU = new User($pdo);
    $getFromL = new Todolist($pdo);
    $getFromT = new Task($pdo);
    $getFromC = new Comment($pdo);
    $getFromA = new Admin($pdo);

    define("BASE_URL", "http://nextask.florianraeymaekers.be/");
?>