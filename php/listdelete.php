<?php
    include '../core/init.php';
    $getFromL->listDelete($user_id); 
    header('Location: ../index.php');
?>