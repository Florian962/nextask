<?php
    /*include 'database/connection.php';
    
    include 'classes/list.php';
    include 'classes/task.php';
    include 'classes/comment.php';
    include 'classes/admin.php';*/
    include 'database/Database.php';
    include 'classes/Authentication.php';
    include 'functions/functions.php';

    Database::getInstance();

    /* om aan de conn te kunnen uit connection.php */
    //global $pdo;

    session_start();

    $as = new Authentication();

    if($as->loggedIn() === false && $_SERVER['REQUEST_URI'] !== '/nextask/php/welcome.php'){
        header('Location: http://localhost/nextask/php/welcome.php');
    }

    /*$getFromU = new User($pdo);
    $getFromL = new Todolist($pdo);
    $getFromT = new Task($pdo);
    $getFromC = new Comment($pdo);
    $getFromA = new Admin($pdo);*/

    define("BASE_URL", "http://localhost/nextask/");
    //define("BASE_URL", "http://nextask.florianraeymaekers.be/");
?>