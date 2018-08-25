<?php

    include '../core/init.php';

    $as->logout(); 
    if($as->loggedIn() === false)  {
        header('Location: welcome.php');
    }
?>
