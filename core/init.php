<?php
    require_once 'database/Database.php';
    require_once 'classes/AuthenticationService.php';
    require_once 'functions/functions.php';
    
    Database::getInstance();
    //var_dump(Database::getInstance());

    session_start();

    $as = new AuthenticationService();
    //var_dump($_SERVER['REQUEST_URI']);
    if($as->loggedIn() === false && $_SERVER['REQUEST_URI'] !== '/nextask/php/welcome.php'){

        header('Location: http://localhost/nextask/php/welcome.php');
    }
    $user = $as->getLoggedInUser();

    define("BASE_URL", "http://localhost/nextask/");
    //define("BASE_URL", "http://nextask.florianraeymaekers.be/");

    
