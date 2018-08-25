<?php
    /* db connection */
    include_once 'database/Database.php';

    /*
    include 'database/connection.php';
    include 'classes/user.php';
    include 'classes/list.php';
    include 'classes/task.php';
    include 'classes/comment.php';
    include 'classes/admin.php';
    */

    /* om aan de conn te kunnen uit connection.php */
    /*
    global $pdo;
    */

    Database::getInstance();
    //var_dump(Database::getInstance());

    session_start();

    $as = new AuthenticationService();
    /* get user data */
    

    /*$getFromU = new User($pdo);
    $getFromL = new Todolist($pdo);
    $getFromT = new Task($pdo);
    $getFromC = new Comment($pdo);
    $getFromA = new Admin($pdo);*/

    define("BASE_URL", "http://localhost/nextask/");
    //define("BASE_URL", "http://nextask.florianraeymaekers.be/");
