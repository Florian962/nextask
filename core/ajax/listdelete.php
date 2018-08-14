<?php

    include '../init.php';
    if(isset($_POST['deleteList']) && !empty($_POST['deleteList'])){
        $list_id = $_POST['deleteList'];
        $user_id = $_SESSION['user_id'];
        $list    = $getFromL->listDelete($list_id, $user_id);
    }
?>

