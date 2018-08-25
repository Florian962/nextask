<?php
    /* db connection */
    include_once 'database/Database.php';
    require_once 'classes/AuthenticationService.php';
    Database::getInstance();
    //var_dump(Database::getInstance());

    session_start();

    define("BASE_URL", "http://localhost/nextask/");
    //define("BASE_URL", "http://nextask.florianraeymaekers.be/");
    $as = new AuthenticationService();
    if($as->loggedIn() === false){
        var_dump('sdg');
        header('Location: http://localhost/nextask/php/welcome.php');
    }
    $user = $as->getLoggedInUser();

    
