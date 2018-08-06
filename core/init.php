<?php
    include 'database/connection.php';
    include 'classes/user.php';
    include 'classes/task.php';
    include 'classes/admin.php';

    global $pdo;

    session_start();

    $getFromU = new User($pdo);
    $getFromT = new Task($pdo);
    $getFromA = new Admin($pdo);

    define("BASE_URL", "http://localhost/nextask/");
?>