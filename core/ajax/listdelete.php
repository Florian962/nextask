<?php

    include '../init.php';
    if(isset($_POST['showPopup']) && !empty($_POST['showPopup'])){
        $list_id = $_POST['showPopup'];
        $user_id = $_SESSION['user_id'];
        $list    = $getFromL->listDelete($list_id, $user_id);
    }
?>
